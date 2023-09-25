<?php
// function check_already_login()
// {
//     $ci = &get_instance();
//     $user_id = $ci->session->userdata('id');

//     if ($user_id) {
//         $ci->load->model('UserModel');

//         // Menggunakan Eloquent untuk mengambil data pengguna berdasarkan ID
//         $user = $ci->UserModel->find($user_id);

//         if ($user) {
//             if ($user->login_access == 1) {
//                 redirect('admin/dashboard');
//             } else {
//                 redirect('user/dashboard');
//             }
//         }
//     }
// }

function check_not_login()
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('access_token');
    //ketika tidak login
    if (!$user_session) {
        redirect('auth');
    }
}

function admin_access()
{
    $ci = &get_instance();
    $userData = $ci->fungsi->user_login();
    // $login_access = $ci->fungsi->user_login()->login_access;

    if (isset($userData['login_access']) && $userData['login_access'] != 1) {
        // Jika login_access adalah 0, block akses
        redirect('user/dashboard');
        // show_error('Access Denied', 403);
    }
}

function user_access()
{
    $ci = &get_instance();
    $userData = $ci->fungsi->user_login();

    // $login_access = $ci->fungsi->user_login()->login_access;

    if (isset($userData['login_access']) && $userData['login_access'] != 0) {

        redirect('admin/dashboard');
    }
}

function hitungJumlahTidakMasuk($user_id, $tanggal)
{
    $ci = &get_instance();
    // Load model AbsensiModel (pastikan model sudah ada)
    $ci->load->model('PresensiModel');

    // Menggunakan model untuk mengambil data absensi berdasarkan user_id dan tanggal_absensi
    $absensiModel = new PresensiModel();
    $absensiData = $absensiModel->getAbsensiByUserIdAndDate($user_id, $tanggal);

    // Hitung jumlah tidak masuk
    $jumlah_tidak_masuk = 0;

    foreach ($absensiData as $absensi) {
        if ($absensi['status'] == 'Tidak Masuk') {
            $jumlah_tidak_masuk++;
        }
    }

    return $jumlah_tidak_masuk;
}


function getHariLibur()
{

    // Load library HTTP client
    $CI = get_instance();
    $CI->load->library('curl');

    // Permintaan ke API Hari Libur
    $response = $CI->curl->simple_get('https://api-harilibur.vercel.app/api');

    if ($response) {
        // Data JSON dari API
        $data = json_decode($response);

        $filteredData = array_filter($data, function ($item) {
            return isset($item->is_national_holiday) && $item->is_national_holiday === true;
        });
        // Proses data sesuai kebutuhan Anda
        // Misalnya, Anda dapat menyimpannya ke dalam model atau menggunakannya dalam logika bisnis

        return $filteredData;
    } else {
        // Handle kesalahan jika tidak dapat terhubung ke API
        return false;
    }
}

function getTanggal()
{
    $ci = &get_instance();

    // Mendapatkan bulan dan tahun saat ini
    $bulanIni = date('m');
    $tahunIni = date('Y');

    // Menghitung jumlah hari dalam bulan ini
    $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulanIni, $tahunIni);

    // Menghasilkan daftar tanggal dalam bulan ini
    $tanggalBulanIni = array();
    for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++) {
        $tanggalFormatted = sprintf("%04d-%02d-%02d 08:00:00", $tahunIni, $bulanIni, $tanggal);
        $tanggalBulanIni[] = $tanggalFormatted;
    }

    return $tanggalBulanIni;
}

// function getTanggalHari()
// {
//     $ci = &get_instance();

//     // Mendapatkan bulan dan tahun saat ini
//     $bulanIni = date('m');
//     $tahunIni = date('Y');

//     // Menghitung jumlah hari dalam bulan ini
//     $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulanIni, $tahunIni);

//     // Menghasilkan daftar tanggal dalam bulan ini dengan format "Senin, 01"
//     $tanggalBulanIni = array();
//     for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++) {
//         // Format tanggal dengan format "Senin, 01" dalam bahasa Indonesia
//         $tanggalFormatted = getHariIndonesia(date('N', strtotime("$tahunIni-$bulanIni-$tanggal"))) . ', ' . date('d', strtotime("$tahunIni-$bulanIni-$tanggal")) . date('S', strtotime("$tahunIni-$bulanIni-$tanggal"));
//         $tanggalBulanIni[] = $tanggalFormatted;
//     }

//     return $tanggalBulanIni;
// }

//nama hari indonesia
// function getHariIndonesia($dayOfWeek)
// {
//     // Daftar nama hari dalam bahasa Indonesia
//     $hariIndonesia = array(
//         'Minggu',
//         'Senin',
//         'Selasa',
//         'Rabu',
//         'Kamis',
//         'Jumat',
//         'Sabtu'
//     );

//     return $hariIndonesia[$dayOfWeek - 1];
// }

function indo_date($date, $print_day = false)
{
    $day        = [1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $month      = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $split      = explode('-', $date);
    $nice_date  = $month[(int) $split[1]] . ', ' .  $split[2];

    if ($print_day) {
        $num = date('N', strtotime($date));
        return $day[$num] . ', ' . $nice_date;
    }
    return $nice_date;
}



function getStatusLibur($tanggal)
{
    // Mengambil data dari API Hari Libur
    $dataHariLibur = getHariLibur();

    foreach ($dataHariLibur as $hariLibur) {
        //Hari Libur sama dengan tanggal lalu ditampilkan tanggal mana saja yang menyediakan hari libur
        if ($hariLibur->holiday_date == $tanggal) {
            echo "Libur : $hariLibur->holiday_name"; // tampil hari libur
            return;
        }
    }
    return "";
}

function getStatus($userId, $bulanIni)
{
    $ci = &get_instance();

    $dataLibur = getHariLibur();

    // Fetch presensi data using your model
    $ci->load->model('PresensiModel');
    $presensiModel = new PresensiModel();
    $presensiBulanIni = $presensiModel->getPresensiBulanIni($userId, $bulanIni);

    $status = array();

    // Tentukan tanggal awal dan akhir bulan
    $tanggalAwal = date('Y-m-01 08:00:00', strtotime($bulanIni));
    $tanggalAkhir = date('Y-m-t 08:00:00', strtotime($bulanIni));

    // Loop untuk menghasilkan status untuk semua tanggal dalam bulan ini
    $currentDate = $tanggalAwal;
    while ($currentDate <= $tanggalAkhir) {
        $tanggal = date('Y-m-d', strtotime($currentDate));
        $tanggalPresensi = date('Y-m-d 08:00:00', strtotime($currentDate));
        $tanggalLibur = date('Y-m-d', strtotime($currentDate));
        $selisihTotalMenit = 0;

        $indodate = indo_date($tanggal);

        $statusItem = array(
            'tanggal' => $indodate,
            'status' => '' // Default status
        );

        // Cek apakah tanggal ini merupakan hari libur
        foreach ($dataLibur as $holiday) {
            if ($holiday->holiday_date == $tanggalLibur) {
                $statusItem['status'] = "<span class='text-danger'>Libur: {$holiday->holiday_name}</span>";
                break;
            }
        }

        foreach ($presensiBulanIni as $presensi) {
            $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));

            $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
            if ($selisihWaktu > 0) {
                // Mengkonversi selisih waktu ke menit
                $selisihMenit = floor($selisihWaktu / 60);
                $selisihTotalMenit += $selisihMenit;
            }

            if ($presensi->tanggal == $tanggalPresensi) {
                if ($presensi->created_on <= $tanggalPresensi) {
                    $statusItem['status'] = "<span class='text-success'><i class='ri-checkbox-circle-line'></i> Hadir</span>";
                } else {
                    $statusItem['status'] = "<span class='text-warning'><i class='ri-error-warning-line'></i> Terlambat : {$selisihMenit} Menit</span>";
                    break;
                }
            }
        }


        //hari minggu
        $hari = date('N', strtotime($tanggalPresensi));
        if ($hari == 7) {
            $statusItem['status'] = "<span class='text-danger'>Libur</span>";
        }

        // Tambahkan status ke dalam array
        $status[] = $statusItem;

        // Lanjutkan ke tanggal berikutnya
        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
    }

    // Tampilkan semua status
    return $status;
}



function qrcode($data, $filename)
{
    $CI = &get_instance();
    $CI->load->library('ciqrcode');

    $base64Data = base64_encode($data);

    // Membuat URL dengan data yang sudah dibersihkan
    $url = base_url("presensi/" . $base64Data);

    QRcode::png($url, FCPATH . "./uploads/qrcode/$filename.png", QR_ECLEVEL_H, 10);
}

// function getStatusPresensi($tanggalPresensi)
// {
//     $waktuBatasHadir = strtotime('08:00:00'); // Waktu batas hadir, pukul 08:00 pagi

//     $tanggalPresensiUnix = strtotime($tanggalPresensi);

//     if ($tanggalPresensiUnix > $waktuBatasHadir) {
//         return '<p class="mb-0 text-warning d-flex justify-content-start align-items-center">
//         <small><svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                                
//         <circle cx="12" cy="12" r="8" fill="#db7e06"></circle></svg>
//         </small> Terlambat
//      </p>';
//     } elseif ($tanggalPresensiUnix <= $waktuBatasHadir) {
//         return '<p class="mb-0 text-success d-flex justify-content-start align-items-center">
//         <small><svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                                
//         <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
//         </small> Hadir
//      </p>';
//     } else {
//         return '<p class="mb-0 text-danger d-flex justify-content-start align-items-center">
//         <small><svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                                
//         <circle cx="12" cy="12" r="8" fill="#F42B3D"></circle></svg>
//         </small> Tidak Hadir
//      </p>';
//     }
// }

// function getStatus($userId, $tanggal)
// {
//     $ci = &get_instance();

//     $ci->load->model('PresensiModel');
//     $presensiModel = new PresensiModel();
//     $presensi = $presensiModel->getPresensiBulanIni($userId, $tanggal);
//     // $tanggalPresensi = PresensiModel::where('user_id', $userId)
//     //     ->where('tanggal', $tanggal)
//     //     ->first();

//     $hariLibur = getHariLibur();
//     $status = array();

//     // Tentukan tanggal awal dan akhir bulan
//     $tanggalAwal = date('Y-m-01', strtotime($tanggal));
//     $tanggalAkhir = date('Y-m-t', strtotime($tanggal));

//     $currentDate = $tanggalAwal;
//     while ($currentDate <= $tanggalAkhir) {


//         $statusItem = array(
//             'tanggal' => '',
//             'status' => '' // Default status
//         );
//     }
// }

// function getStatus($userId, $tanggal)
// {
//     $ci = &get_instance();
//     $hariLibur = getHariLibur();

//     $ci->load->model('PresensiModel');
//     $presensiModel = new PresensiModel();

//     // Mengambil data presensi untuk user dan tanggal tertentu
//     $presensi = $presensiModel->getPresensiBulanIni($userId, $tanggal)->first();

//     $status = array();
//     $tanggalPresensi = date('Y-m-d', strtotime($tanggal));
//     $waktuBatasHadir = '08:00:00';

//     $statusItem = array(
//         'tanggal' => $tanggalPresensi,
//         'status' => '' // Default status
//     );

//     // Cek apakah ada data presensi untuk tanggal ini
//     if ($presensi) {
//         if ($presensi->created_on >= $waktuBatasHadir) {
//             $statusItem['status'] = "<span class='text-success'>Hadir</span>";
//         } else {
//             $statusItem['status'] = "<span class='text-success'>Terlambat</span>";
//         }
//     } else {
//         // Jika tidak ada data presensi, mungkin ini adalah hari libur
//         foreach ($hariLibur as $holiday) {
//             if ($holiday->holiday_date == $tanggalPresensi) {
//                 $statusItem['status'] = "<span class='text-danger'>Libur: {$holiday->holiday_name}</span>";
//                 break;
//             }
//         }
//     }

//     $status[] = $statusItem;

//     return $status;
// }

// function getStatus($userId, $bulanIni)
// {
//     $ci = &get_instance();
//     $hariLibur = getHariLibur();
//     $tanggal = getTanggal();

//     $ci->load->model('PresensiModel');
//     $presensiModel = new PresensiModel();
//     $presensiBulanIni = $presensiModel->getPresensiBulanIni($userId, $bulanIni)->first();

//     $status = array();

//     $tanggalAwal = date('Y-m-01', strtotime($bulanIni));
//     $tanggalAkhir = date('Y-m-t', strtotime($bulanIni));

//     $currentDate = $tanggalAwal;
//     while ($tanggal <= $tanggalAkhir) {
//         $statusItem = array(
//             'tanggal' => $tanggal,
//             'status' => ''
//         );

//         //Cek apakah tanggal ini merupakan hari libur
//         foreach ($hariLibur as $holiday) {
//             if ($holiday->holiday_date == $tanggal) {
//                 $statusItem['status'] = "<span class='text-danger'>Libur: {$holiday->holiday_name}</span>";
//                 break;
//             }
//         }

//         foreach ($presensiBulanIni as $presensi) {
//             if (is_object($presensi) && property_exists($presensi, 'tanggal') && $presensi->created_on <= $currentDate) {
//                 $statusItem['status'] = "<span class='text-success'>Hadir</span>";
//                 break;
//             }
//         }

//         $hari = date('N', strtotime($bulanIni));
//         if ($hari == 7) {
//             $statusItem['status'] = "<span class='text-danger'>Libur</span>";
//         }

//         // Tambahkan status ke dalam array
//         $status[] = $statusItem;

//         // Lanjutkan ke tanggal berikutnya
//         $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
//     }
//     return $status;
// }