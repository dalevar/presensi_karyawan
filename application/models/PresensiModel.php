<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class PresensiModel extends Eloquent
{
    protected $table = 'presensi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'tanggal',
        'created_by',
        'created_on'
    ];

    public function getPresensiKaryawan($tahun, $bulan)
    {
        $presensi = PresensiModel::with('karyawan')
            ->whereMonth('created_on', $bulan)
            ->whereYear('created_on', $tahun)
            ->get();
        // dd($presensi);
        return $presensi;
    }

    public function getPresensiData($userId, $tahun, $bulan)
    {
        $presensi = $this->where('user_id', $userId)
            ->whereMonth('created_on', $bulan)
            ->whereYear('created_on', $tahun)
            ->get();

        return $presensi;
    }

    public function getPresensiArray()
    {
        $presensiData = $this->get(); // Mengambil semua data

        if ($presensiData->count() > 0) {
            return $presensiData->toArray(); // Mengembalikan data dalam bentuk array asosiatif
        } else {
            return array(); // Mengembalikan array kosong jika tidak ada data
        }
    }

    public function getAllUserIds()
    {
        // $userIds = PresensiModel::distinct()->select('created_by')->get()->toArray();
        // return $userIds;

        return $this->distinct()->pluck('created_by')->toArray();
    }

    public function totalTerlambatBulanTahun($userId, $year, $month)
    {
        // Mengambil data presensi untuk pengguna, tahun, dan bulan yang dipilih
        $presensi = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->whereMonth('created_on', $month)
            ->get();

        if ($presensi->isEmpty()) {
            return "-";
        }

        $selisihTotalMenit = 0;

        foreach ($presensi as $dataPresensi) {
            $jamTanggal = date('H:i:s', strtotime($dataPresensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($dataPresensi->created_on));

            // Menghitung selisih waktu dalam menit
            $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);

            if ($selisihWaktu > 0) {
                // Mengkonversi selisih waktu ke menit
                $selisihMenit = floor($selisihWaktu / 60);
                $selisihTotalMenit += $selisihMenit;
            }
        }

        return $selisihTotalMenit;
    }

    public function tidakHadirBulanTahun($userId, $year, $month)
    {
        $presensi = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->whereMonth('created_on', $month)
            ->get();

        if ($presensi->isEmpty()) {
            return "-";
        }

        // Menghitung jumlah hari dalam bulan ini
        $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $jumlahTidakHadir = 0;
        $jumlahPresensi = 0;

        // Iterasi melalui tanggal-tanggal dalam bulan
        for ($day = 1; $day <= $jumlahHariBulan; $day++) {
            $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
            $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
            $isWeekday = ($dayOfWeek >= 1 && $dayOfWeek <= 6);

            foreach ($presensi as $presensiList) {
                $presensiCreated = date('Y-m-d', strtotime($presensiList->created_on));

                if ($isWeekday && $presensiCreated == $currentDate) {
                    $jumlahPresensi++;
                }
            }

            // Jika tidak ada data presensi pada tanggal ini dan itu adalah hari kerja, tambahkan ke jumlah ketidakhadiran
            if ($isWeekday && $jumlahPresensi == 0) {
                $jumlahTidakHadir++;
            }
        }

        $TotaljumlahTidakHadir = $jumlahTidakHadir;
        return $TotaljumlahTidakHadir;
        // dd($TotaljumlahTidakHadir);
    }



    public function sisaKesempatanTidakHadir($userId, $year, $month)
    {
        // Menghitung jumlah maksimum ketidakhadiran dalam bulan ini
        $jumlahMaksimumTidakHadir = 16;

        // Mengambil data presensi untuk pengguna, tahun, dan bulan yang dipilih
        $presensi = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->whereMonth('created_on', $month)
            ->get();

        if ($presensi->isEmpty()) {
            return "-";
        }

        // Menghitung jumlah ketidakhadiran aktual
        $jumlahTidakHadir = $this->TidakHadirBulanTahun($userId, $year, $month);

        // Menghitung sisa kesempatan ketidakhadiran
        $sisaKesempatanTidakHadir = $jumlahMaksimumTidakHadir - $jumlahTidakHadir;

        return $sisaKesempatanTidakHadir;
    }


    public function getPresensiHariIni($tanggal)
    {
        $hariIni = date('Y-m-d H:i:s', strtotime($tanggal . ' 08:00:00'));

        $presensi = $this->where('tanggal', $hariIni)
            ->get();
        return $presensi;
    }

    public function hitungTerlambatHariIni($tanggal)
    {
        $hariIni = date('Y-m-d H:i:s', strtotime($tanggal . ' 08:00:00'));

        $terlambat = $this->where('tanggal', $hariIni)
            ->where('created_on', '>', $hariIni)
            ->count();

        return $terlambat;
    }

    public function hitungTidakHadir($tanggal)
    {
        // Dapatkan semua user_id yang ada di tabel presensi
        $allUserIds = $this->getAllUserIds();
        $hariIni = date('Y-m-d H:i:s', strtotime($tanggal . ' 08:00:00'));

        // Inisialisasi jumlah ketidak hadiran
        $jumlahTidakHadir = 0;

        // Iterasi melalui semua user_id
        foreach ($allUserIds as $userId) {
            // Dapatkan data presensi hari ini untuk user_id tertentu
            $presensiHariIni = $this->where('tanggal', $hariIni)->where('created_by', $userId)->get();
            // dd($presensiHariIni);
            // Jika tidak ada presensi hari ini untuk user_id tertentu, tingkatkan jumlah ketidak hadiran
            if ($presensiHariIni->isEmpty()) {
                $jumlahTidakHadir++;
            }
        }

        // Jika semua karyawan telah melakukan presensi, atur pesan kehadiran lengkap
        if ($jumlahTidakHadir === 0) {
            return 'Kehadiran Lengkap';
        }

        return $jumlahTidakHadir;
    }

    public function getPresensiBulanIni($userId, $tanggal)
    {
        // Mendapatkan bulan dan tahun dari tanggal yang diberikan
        $bulanIni = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        // Mengambil data presensi untuk pengguna pada bulan ini
        $presensi = $this->where('user_id', $userId)
            ->whereMonth('created_on', $bulanIni)
            ->whereYear('created_on', $tahun)
            ->get();

        return $presensi;
    }


    //menghitung per Bulan
    public function hitungTidakHadirBulanIni($userId, $tanggal, $bulanIni, $tahun)
    {
        $presensi = $this->getPresensiBulanIni($userId, $tanggal);

        // Menghitung jumlah hari dalam bulan ini
        $bulanIni = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN, $bulanIni, $tahun);

        // Menghitung jumlah hari Minggu dalam bulan ini
        $jumlahHariMinggu = 0;
        for ($day = 1; $day <= $jumlahHariBulan; $day++) {
            $currentDate = date('Y-m-d', strtotime("$tahun-$bulanIni-$day"));
            $dayOfWeek = date('N', strtotime($currentDate));
            if ($dayOfWeek == 7) { // Hari Minggu (7)
                $jumlahHariMinggu++;
            }
        }

        // Menghitung jumlah hari kerja dalam bulan ini
        $jumlahHariKerja = $jumlahHariBulan - $jumlahHariMinggu;

        // Menghitung jumlah tidak hadir
        $jumlahTidakHadir = $jumlahHariKerja - $presensi->count();

        return $jumlahTidakHadir;
    }


    //menghitung terlambat per bulan
    public function hitungTerlambatBulanIni($userId, $tanggal, $bulanIni, $tahun)
    {
        $presensi = $this->getPresensiBulanIni($userId, $tanggal);

        if ($presensi->isEmpty()) {
            return "-";
        }

        // Menghitung jumlah hari dalam bulan ini
        $bulanIni = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN, $bulanIni, $tahun);

        $selisihTotalMenit = 0;

        foreach ($presensi as $dataPresensi) {
            $jamTanggal = date('H:i:s', strtotime($dataPresensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($dataPresensi->created_on));

            // Menghitung selisih waktu dalam menit
            $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);

            if ($selisihWaktu > 0) {
                // Mengkonversi selisih waktu ke menit
                $selisihMenit = floor($selisihWaktu / 60);
                $selisihTotalMenit += $selisihMenit;
            }
        }

        return $selisihTotalMenit;
    }

    //Menghitung Per Tahun
    public function getPresensiTahunIni($userId, $tanggal)
    {
        $tahun = date('Y', strtotime($tanggal));
        $presensiTahunIni = $this->where('user_id', $userId)
            ->whereYear('created_on', $tahun)
            ->get();

        return $presensiTahunIni;
    }

    public function hitungTidakHadirTahunIni($userId, $tahun)
    {
        // Mengambil semua presensi pengguna selama satu tahun
        $hariLibur = getHariLibur(); // Mengambil daftar tanggal libur nasional
        $presensiTahunIni = $this->getPresensiTahunIni($userId, $tahun)
            ->reject(function ($presensi) use ($hariLibur) {
                return in_array($presensi->tanggal, $hariLibur); // Menghindari tanggal libur
            });

        if ($presensiTahunIni->isEmpty()) {
            return "-";
        }

        // Jumlah hari dalam satu tahun (365 hari)
        $jumlahHariTahunIni = 365;

        // Menghitung jumlah hari tidak hadir
        $jumlahTidakHadirTahunIni = $jumlahHariTahunIni - count($presensiTahunIni);

        return $jumlahTidakHadirTahunIni;
    }

    //menghitung Terlambat Per Tahun
    public function hitungTerlambatTahunIni($userId, $tahun)
    {
        $presensi = $this->getPresensiTahunIni($userId, $tahun);

        if ($presensi->isEmpty()) {
            return "-";
        }

        $selisihTotalMenit = 0;

        foreach ($presensi as $dataPresensi) {
            $jamTanggal = date('H:i:s', strtotime($dataPresensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($dataPresensi->created_on));

            // Menghitung selisih waktu dalam menit
            $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);

            if ($selisihWaktu > 0) {
                // Mengkonversi selisih waktu ke menit
                $selisihMenit = floor($selisihWaktu / 60);
                $selisihTotalMenit += $selisihMenit;
            }
        }

        return $selisihTotalMenit;
    }

    public function getPresensiByUserTanggal($user_id, $tanggal)
    {
        return $this->where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->first();
    }

    public function getAbsensiByUserIdAndDate($user_id, $tanggal)
    {
        return $this->where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->get()
            ->toArray();
    }

    public function karyawan()
    {
        return $this->belongsTo('KaryawanModel', 'created_by', 'id');
    }

    public function getPresensiByTanggal($tanggal)
    {
        return $this->where('tanggal', $tanggal)->get();
    }

    public $timestamps = false;
}
