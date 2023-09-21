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
        // Jika login_access adalah 0, block akses
        redirect('admin/dashboard');
        // show_error('Access Denied', 403);
    }
}

function getStatusPresensi($tanggalPresensi)
{
    $waktuBatasHadir = strtotime('08:00:00'); // Waktu batas hadir, pukul 08:00 pagi

    $tanggalPresensiUnix = strtotime($tanggalPresensi);

    if ($tanggalPresensiUnix > $waktuBatasHadir) {
        return '<p class="mb-0 text-warning d-flex justify-content-start align-items-center">
        <small><svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                                
        <circle cx="12" cy="12" r="8" fill="#db7e06"></circle></svg>
        </small> Terlambat
     </p>';
    } elseif ($tanggalPresensiUnix <= $waktuBatasHadir) {
        return '<p class="mb-0 text-success d-flex justify-content-start align-items-center">
        <small><svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                                
        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
        </small> Hadir
     </p>';
    } else {
        return '<p class="mb-0 text-danger d-flex justify-content-start align-items-center">
        <small><svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                                
        <circle cx="12" cy="12" r="8" fill="#F42B3D"></circle></svg>
        </small> Tidak Hadir
     </p>';
    }
}

function hitungStatusPresensi($karyawan_id)
{
    $CI = &get_instance();
    $CI->load->model('PresensiModel');
    // Mengambil data presensi terakhir untuk karyawan tertentu
    $lastPresensi = $CI->PresensiModel->where('created_by', $karyawan_id)
        ->orderBy('created_on', 'DESC')
        ->first();

    if ($lastPresensi) {
        // Mengambil tanggal dan jam presensi terakhir
        $tanggalPresensi = new DateTime($lastPresensi->created_on);

        // Menentukan waktu yang dianggap sebagai batas waktu "Terlambat" (misalnya pukul 08:00)
        $batasWaktu = new DateTime($tanggalPresensi->format('Y-m-d') . ' 08:00:00');

        // Memeriksa apakah tanggal dan jam presensi kurang dari batas waktu
        if ($tanggalPresensi < $batasWaktu) {
            return '<span class="text-warning">Terlambat</span>';
        } else {
            return 'Tidak Terlambat';
        }
    } else {
        return "Data presensi tidak ditemukan.";
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

function qrcode($data, $filename)
{
    $CI = &get_instance();
    $CI->load->library('ciqrcode');

    $base64Data = base64_encode($data);

    // Membuat URL dengan data yang sudah dibersihkan
    $url = base_url("presensi/" . $base64Data);

    QRcode::png($url, FCPATH . "./uploads/qrcode/$filename.png", QR_ECLEVEL_H, 10);
}
