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
        'is_wfh',
        'is_sakit',
        'created_on'
    ];

    public function editWFH($userId, $tanggal, $status)
    {
        $presensi = $this->where('user_id', $userId)
            ->where('tanggal', $tanggal)
            ->first();

        if ($presensi) {
            $presensi->is_wfh = $status;
            $presensi->save();
            return true; // Operasi edit berhasil
        }

        return false; // Data tidak ditemukan
    }

    public function getPresensiDataForUserAndDate($userId, $year, $month, $day)
    {
        $presensi = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->whereMonth('created_on', $month)
            ->whereDay('created_on', $day)
            ->first();

        if ($presensi) {
            // Mengembalikan data presensi jika ditemukan
            return $presensi;
        } else {
            // Mengembalikan data kosong jika tidak ditemukan
            return null; // Atau tindakan yang sesuai
        }
    }

    public function getSecondLastAttendanceDate($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->offset(1) // Ini akan mengabaikan record terakhir
            ->limit(1) // Ini akan mengambil satu record
            ->value('tanggal');
    }


    public function getLastAttendanceDate($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->value('tanggal');
    }

    public function getPresensiHariSebelumnya($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_on', 'desc')
            ->first();
    }


    public function getDataPresensiTahun($userId, $year)
    {
        $presensi = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->get();
        // $totalPresensi = count($presensi);
        // dd($totalPresensi);
        return $presensi;
    }

    public function getDataPresensiBulan($userId, $month)
    {
        $presensi = $this->where('user_id', $userId)
            ->whereMonth('created_on', $month)
            ->get();
        // $totalPresensi = count($presensi);
        // dd($totalPresensi);
        return $presensi;
    }

    public function getBulanPresensiList($userId)
    {
        return $this->where('user_id', $userId)
            ->select('tanggal', 'created_by', 'is_wfh', 'created_on')
            ->get();
    }

    public static function getTotalIsWFHByUserId($userId)
    {
        return self::where('user_id', $userId)
            ->where('is_wfh', 1)
            ->count();
    }

    public static function getTotalIsWFH()
    {
        return self::where('is_wfh', 1)->count();
    }

    public function tidakHadirTahun($userId, $year)
    {
        $totalTidakHadirTahunan = 0;

        // Iterasi melalui setiap bulan dalam tahun
        for ($month = 1; $month <= 12; $month++) {
            // Panggil metode Anda yang sudah ada untuk menghitung ketidakhadiran bulanan
            $jumlahTidakHadirBulan = $this->tidakHadirBulanTahun($userId, $year, $month);
            // dd($jumlahTidakHadirBulan);
            // Pastikan bahwa $jumlahTidakHadirBulan adalah numerik sebelum menambahkannya ke total tahunan
            if (is_numeric($jumlahTidakHadirBulan)) {
                $totalTidakHadirTahunan += $jumlahTidakHadirBulan;
            }
        }
    }


    public function tidakHadirBulan($year, $month)
    {
        $presensi = $this->whereYear('created_on', $year)
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

    public function getAllPresensiBulan($year, $month)
    {
        $presensi = $this->whereMonth('created_on', $month)
            ->whereYear('created_on', $year)
            ->get();

        return $presensi;
    }

    public function getPresensiBulan($month)
    {
        $presensi = $this
            ->whereMonth('created_on', $month)
            ->get();

        return $presensi;
    }

    public function getPresensiBulanTahun($year, $month)
    {
        $presensi = $this
            ->whereMonth('created_on', $month)
            ->whereYear('created_on', $year)
            ->get();

        return $presensi;
    }

    public function getPresensiTahun($year)
    {
        $presensi = $this
            ->whereYear('created_on', $year)
            ->get();
        // $totalPresensi = count($presensi);
        // dd($totalPresensi);
        return $presensi;
    }

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

    public function getPresensi($tahun, $bulan)
    {
        $presensi = $this
            ->whereMonth('created_on', $bulan)
            ->whereYear('created_on', $tahun)
            ->get();

        return $presensi;
    }

    public function getPresensiArray()
    {
        $presensiData = PresensiModel::all(); // Mengambil semua data presensi menggunakan Eloquent

        if ($presensiData->count() > 0) {
            return $presensiData->toArray(); // Mengembalikan data dalam bentuk array asosiatif
        } else {
            return array(); // Mengembalikan array kosong jika tidak ada data
        }
    }


    public function getAllUserIds()
    {
        $userIds = PresensiModel::distinct()->select('created_by')->get()->toArray();
        return $userIds;

        // return $this->distinct()->pluck('created_by')->toArray();
    }

    public function totalTerlambatBulanTahun($userId, $year, $month)
    {
        // Mengambil data presensi untuk pengguna, tahun, dan bulan yang dipilih
        $presensiList = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->whereMonth('created_on', $month)
            ->get();

        if ($presensiList->isEmpty()) {
            return "-";
        }

        $totalKeterlambatan = 0;
        $totalWaktuTerlambat = 0;
        $formatWaktuTerlambat = '-';

        foreach ($presensiList as $presensi) {
            $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));

            // Menghitung selisih waktu dalam menit
            $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
            if ($selisihWaktu > 0) {
                // Mengkonversi selisih waktu ke menit
                $selisihMenit = floor($selisihWaktu / 60);
                $totalKeterlambatan += $selisihMenit;
                $totalWaktuTerlambat += $selisihMenit;

                // Hitung jumlah jam
                $totalJam = floor($totalWaktuTerlambat / 60);

                // Hitung jumlah menit sisa setelah mengurangkan jam
                $totalMenit = $totalWaktuTerlambat  % 60;
                // $totalMenit += $totalKeterlambatanWFH;

                $formatWaktuTerlambat = $totalJam . " Jam " . $totalMenit . " Menit";
            }
        }

        return $formatWaktuTerlambat;
    }

    public function tidakHadirBulanan($userId, $month)
    {
        $totalTidakHadirBulanan = 0;

        $year = isset($_GET['year']) ? $_GET['year'] : date('Y');

        // Panggil metode Anda yang sudah ada untuk menghitung ketidakhadiran bulanan
        $jumlahTidakHadirBulan = $this->tidakHadirBulanTahun($userId, $year, $month);
        // dd($jumlahTidakHadirBulan);
        // Pastikan bahwa $jumlahTidakHadirBulan adalah numerik sebelum menambahkannya ke total Bulanan
        if (is_numeric($jumlahTidakHadirBulan)) {
            $totalTidakHadirBulanan += $jumlahTidakHadirBulan;
        }


        // Hitung total keterlambatan dan jam WFH
        $totalKeterlambatanBulanan = $this->hitungTotalKeterlambatanBulanan($userId, $month);
        if ($totalKeterlambatanBulanan > 0) {
            $totalTidakHadirBulanan += $totalKeterlambatanBulanan;
        }

        // dd($totalKeterlambatanBulanan);
        $totalJamWFHBulanan = $this->hitungTotalJamWFHBulanan($userId, $month);
        // dd($totalJamWFHBulanan);
        if ($totalJamWFHBulanan > 0) {
            $totalTidakHadirBulanan += $totalJamWFHBulanan;
        }

        $totalSakitBulanan = $this->hitungTotalSakitBulanan($userId, $month);
        $dataSakit = KonfigModel::where('nama', 'sakit')->first();
        if ($dataSakit) {
            $batasSakit = $dataSakit->nilai;
            if ($totalSakitBulanan > $batasSakit) {
                $totalTidakHadirBulanan += $totalSakitBulanan;
            }
        }
        // dd($jumlahTidakHadirBulan);


        return $totalTidakHadirBulanan;
    }

    public function hitungTotalKeterlambatanBulanan($userId, $month)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereMonth('created_on', $month)
            ->get();

        $jumlahTotalTidakHadir = 0;
        $totalKeterlambatan = 0;

        foreach ($presensiList as $presensi) {
            $bulanPresensi = date('m', strtotime($presensi->tanggal));

            if ($bulanPresensi == $month) {
                $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
                $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));
                // Menghitung selisih waktu dalam menit
                $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
                if ($selisihWaktu > 0) {
                    // Mengkonversi selisih waktu ke menit
                    $selisihMenit = floor($selisihWaktu / 60);
                    $totalKeterlambatan += $selisihMenit;
                    if ($totalKeterlambatan >= 480) {
                        $jumlahTotalTidakHadir++;
                        $totalKeterlambatan -= 480;
                    }
                }
            }
        }
        return $jumlahTotalTidakHadir;
    }

    public function hitungTotalJamWFHBulanan($userId, $month)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereMonth('created_on', $month)
            ->get();

        $totalKeterlambatanWFH = 0;
        $jumlahTotalTidakHadir = 0;

        foreach ($presensiList as $presensi) {
            $isWFH = $presensi->is_wfh;

            if ($isWFH == 1) {
                // Dapatkan data konfigurasi WFH
                $dataWFH = KonfigModel::where('nama', 'wfh')->first();

                // Periksa apakah data konfigurasi WFH ada
                if ($dataWFH) {
                    // Ambil nilai konfigurasi WFH
                    $nilaiWFH = $dataWFH->nilai;

                    // Hitung total keterlambatan
                    if ($isWFH == 1) {
                        // Ubah nilai konfigurasi WFH ke dalam bentuk menit
                        $nilaiWFH = intval($nilaiWFH); // Mengambil angka dari string

                        // Tambahkan nilai konfigurasi WFH ke total keterlambatan WFH
                        $totalKeterlambatanWFH += $nilaiWFH;
                        if ($totalKeterlambatanWFH >= 480) {
                            $jumlahTotalTidakHadir++;
                            $totalKeterlambatanWFH -= 480;
                        }
                    }
                }
            }
        }

        return $jumlahTotalTidakHadir;
    }

    public function hitungTotalSakitBulanan($userId, $month)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereMonth('created_on', $month)
            ->get();

        $jumlahTotalTidakHadirSakit = 0;

        foreach ($presensiList as $presensi) {
            $jamTidakHadir = strtotime('00:00:00');
            $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
            $isSakit = $presensi->is_sakit;

            if ($waktuPresensi == $jamTidakHadir && $isSakit == 1) {
                $jumlahTotalTidakHadirSakit++;
            }
            // dd($jumlahTotalTidakHadirSakit);
        }

        return $jumlahTotalTidakHadirSakit;
    }


    public function tidakHadirTahunan($userId, $year)
    {
        $totalTidakHadirTahunan = 0;

        // Iterasi melalui setiap bulan dalam tahun
        for ($month = 1; $month <= 12; $month++) {
            // Panggil metode Anda yang sudah ada untuk menghitung ketidakhadiran bulanan
            $jumlahTidakHadirBulan = $this->tidakHadirBulanTahun($userId, $year, $month);
            // dd($jumlahTidakHadirBulan);
            // Pastikan bahwa $jumlahTidakHadirBulan adalah numerik sebelum menambahkannya ke total tahunan
            if (is_numeric($jumlahTidakHadirBulan)) {
                $totalTidakHadirTahunan += $jumlahTidakHadirBulan;
            }
        }

        // Hitung total keterlambatan dan jam WFH
        $totalKeterlambatanTahunan = $this->hitungTotalKeterlambatanTahunan($userId, $year);
        // dd($totalKeterlambatanTahunan);
        if ($totalKeterlambatanTahunan > 0) {
            $totalTidakHadirTahunan += $totalKeterlambatanTahunan;
        }

        // dd($totalKeterlambatanTahunan);
        $totalJamWFHTahunan = $this->hitungTotalJamWFHTahunan($userId, $year);
        // dd($totalJamWFHTahunan);
        if ($totalJamWFHTahunan > 0) {
            $totalTidakHadirTahunan += $totalJamWFHTahunan;
        }

        $totalSakitTahunan = $this->hitungTotalSakitTahunan($userId, $year);
        $dataSakit = KonfigModel::where('nama', 'sakit')->first();
        if ($dataSakit) {
            // Ambil batas sakit yang telah ditentukan
            $batasSakit = $dataSakit->nilai;
            if ($totalSakitTahunan > $batasSakit) {
                $totalTidakHadirTahunan += $totalSakitTahunan;
            }
        }
        // dd($jumlahTidakHadirBulan);  


        return $totalTidakHadirTahunan;
    }

    public function hitungTotalKeterlambatanTahunan($userId, $year)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->get();

        $jumlahTotalTidakHadir = 0;
        $totalKeterlambatan = 0;

        foreach ($presensiList as $presensi) {
            $tahunPresensi = date('Y', strtotime($presensi->tanggal));

            if ($tahunPresensi == $year) {
                $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
                $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));
                // Menghitung selisih waktu dalam menit
                $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
                if ($selisihWaktu > 0) {
                    // Mengkonversi selisih waktu ke menit
                    $selisihMenit = floor($selisihWaktu / 60);
                    $totalKeterlambatan += $selisihMenit;
                    if ($totalKeterlambatan >= 480) {
                        $jumlahTotalTidakHadir++;
                        $totalKeterlambatan -= 480;
                    }
                }
            }
        }
        return $jumlahTotalTidakHadir;
    }

    public function hitungTotalSakitTahunan($userId, $year)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->get();

        $jumlahTotalTidakHadirSakit = 0;

        foreach ($presensiList as $presensi) {
            $isSakit = $presensi->is_sakit;

            if ($isSakit == 1) {
                // Dapatkan data konfigurasi WFH
                $dataSakit = KonfigModel::where('nama', 'sakit')->first();

                // Periksa apakah data konfigurasi Sakit ada
                if ($dataSakit) {
                    // Ambil nilai konfigurasi Sakit
                    $batasSakit = $dataSakit->nilai;

                    if ($isSakit == 1) {
                        $jumlahTotalTidakHadirSakit++;
                    }
                }
            }
        }
        return $jumlahTotalTidakHadirSakit;
    }

    public function hitungTotalJamWFHTahunan($userId, $year)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->get();

        $totalKeterlambatanWFH = 0;
        $jumlahTotalTidakHadir = 0;

        foreach ($presensiList as $presensi) {
            $isWFH = $presensi->is_wfh;

            if ($isWFH == 1) {
                // Dapatkan data konfigurasi WFH
                $dataWFH = KonfigModel::where('nama', 'wfh')->first();

                // Periksa apakah data konfigurasi WFH ada
                if ($dataWFH) {
                    // Ambil nilai konfigurasi WFH
                    $nilaiWFH = $dataWFH->nilai;

                    // Hitung total keterlambatan
                    if ($isWFH == 1) {
                        // Ubah nilai konfigurasi WFH ke dalam bentuk menit
                        $nilaiWFH = intval($nilaiWFH); // Mengambil angka dari string

                        // Tambahkan nilai konfigurasi WFH ke total keterlambatan WFH
                        $totalKeterlambatanWFH += $nilaiWFH;
                        if ($totalKeterlambatanWFH >= 480) {
                            $jumlahTotalTidakHadir++;
                            $totalKeterlambatanWFH -= 480;
                        }
                    }
                }
            }
        }

        return $jumlahTotalTidakHadir;
    }

    public function totalSakitTahunan($userId, $year)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->get();

        $jumlahSakit = 0;

        foreach ($presensiList as $presensi) {
            $isSakit = $presensi->is_sakit;

            if ($isSakit == 1) {
                // Dapatkan data konfigurasi WFH
                $dataSakit = KonfigModel::where('nama', 'sakit')->first();

                // Periksa apakah data konfigurasi Sakit ada
                if ($dataSakit) {
                    // Ambil nilai konfigurasi Sakit
                    $nilaiSakit = $dataSakit->nilai;

                    if ($isSakit == 1) {
                        $jumlahSakit++;
                    }
                }
            }
        }

        return $jumlahSakit;
    }

    public function TotalSakitBulanTahun($userId, $year, $month)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->whereMonth('created_on', $month)
            ->get();

        $jumlahTotalTidakHadirSakit = 0;

        foreach ($presensiList as $presensi) {
            $isSakit = $presensi->is_sakit;

            if ($isSakit == 1) {
                // Dapatkan data konfigurasi WFH
                $dataSakit = KonfigModel::where('nama', 'sakit')->first();

                // Periksa apakah data konfigurasi Sakit ada
                if ($dataSakit) {
                    // Ambil nilai konfigurasi Sakit
                    $nilaiSakit = $dataSakit->nilai;

                    if ($isSakit == 1) {
                        $jumlahTotalTidakHadirSakit++;
                    }
                }
            }
        }

        return $jumlahTotalTidakHadirSakit;
    }


    public function tidakHadirBulanTahun($userId, $year, $month)
    {
        $presensiList = $this->where('user_id', $userId)
            ->whereYear('created_on', $year)
            ->whereMonth('created_on', $month)
            ->get();

        if ($presensiList->isEmpty()) {
            return "-";
        }

        // Menghitung jumlah hari dalam bulan ini
        $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $jumlahTidakHadir = 0; //Menghitung Seluruh Total Ketidakhadiran

        // Dapatkan daftar tanggal hari libur nasional
        $dataLibur = getHariLibur();
        $tanggalLibur = [];

        foreach ($dataLibur as $libur) {
            $tanggalLibur[] = $libur->holiday_date;
        }
        // Iterasi melalui tanggal-tanggal dalam bulan
        for ($day = 1; $day <= $jumlahHariBulan; $day++) {
            $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

            // Periksa apakah tanggal adalah hari sebelum tanggal saat ini
            if (strtotime($currentDate) < strtotime(date('Y-m-d'))) {
                $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
                $isWeekday = ($dayOfWeek >= 1 && $dayOfWeek <= 6);

                $jumlahPresensi = 0; // Inisialisasi jumlah presensi pada setiap hari

                foreach ($presensiList as $presensi) {
                    $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
                    $jamTidakBerhadir = strtotime('00:00:00');
                    $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
                    $isSakit = $presensi->is_sakit;

                    if ($isWeekday && $presensiCreated == $currentDate && $waktuPresensi != $jamTidakBerhadir && $isSakit != 1) {
                        $jumlahPresensi++;
                    }
                }

                // Jika tidak ada data presensi pada tanggal ini dan itu adalah hari kerja, tambahkan ke jumlah ketidakhadiran
                if ($isWeekday && $jumlahPresensi == 0 && !in_array($currentDate, $tanggalLibur)) {
                    $jumlahTidakHadir++;
                }

                // dd($jumlahTidakHadir);
            }
        }

        return $jumlahTidakHadir;
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
        // dd($jumlahTidakHadir);
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
