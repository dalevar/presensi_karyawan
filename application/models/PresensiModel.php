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

    // public function hitungTidakHadir($tanggal)
    // {
    //     $presensi = $this->getPresensiHariIni($tanggal);

    //     if ($presensi->isEmpty()) {
    //         // Jika tidak ada data presensi hari ini, ambil semua data sesuai tanggal
    //         $semuaPresensi = $this->where('tanggal', $tanggal)->get();
    //         $jumlahPresensi = $semuaPresensi->count();
    //     } else {
    //         $jumlahPresensi = $presensi->count();
    //     }

    //     // Hitung jumlah ketidak hadiran
    //     $jumlahTidakHadir = $jumlahPresensi > 0 ? 1 : 0;

    //     return $jumlahTidakHadir;
    // }

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

        if ($presensi->isEmpty()) {
            return "-";
        }

        // Menghitung jumlah hari dalam bulan ini
        $bulanIni = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN, $bulanIni, $tahun);

        $jumlahTidakHadir = $jumlahHariBulan - $presensi->count();
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
        $presensiTahunIni = $this->getPresensiTahunIni($userId, $tahun);
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
