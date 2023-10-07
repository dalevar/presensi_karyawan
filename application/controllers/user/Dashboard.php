<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //jika tidak login maka tidak bisa mengakses halaman dashboard
        check_not_login();
        user_access();
        $this->load->model('KaryawanModel');
        $this->load->model('UserModel');
        $this->load->model('JabatanModel');
        $this->load->model('PresensiModel');
        $this->load->model('QrcodeModel');
        $this->load->library('session');
        $this->load->library('curl');
    }

    public function index()
    {
        if (!isset($login_button)) {
            //data Karyawan
            $data['title'] = 'Dashboard Presensi';
            $userData = $this->session->userdata('user_data');
            $userId = $userData['id'];

            $karyawanModel = new KaryawanModel();
            $karyawan = $karyawanModel->getByUserId($userId);
            $data['karyawan'] = $karyawan;
            // Memeriksa apakah data karyawan ditemukan
            if ($karyawan) {
                // Mengambil objek jabatan yang terhubung ke karyawan
                $jabatan = $karyawan->jabatan;

                // Menyimpan data jabatan ke dalam array $data
                $data['jabatan'] = $jabatan;

                //Menghitung Tahun Kerja
                $tanggalMasuk = new DateTime($karyawan->tanggal_masuk);
                $tanggalSekarang = new DateTime();
                $selisih = $tanggalMasuk->diff($tanggalSekarang);

                // Menyimpan hasil perhitungan dalam array
                $tahunKerja = $selisih->y;
                $bulanKerja = $selisih->m;
                $hariKerja = $selisih->d;

                // Menyimpan data tahun, bulan, dan hari kerja ke dalam array $data
                $data['tahun_kerja'] = $tahunKerja;
                $data['bulan_kerja'] = $bulanKerja;
                $data['hari_kerja'] = $hariKerja;
            } else {
                echo "Karyawan tidak ditemukan.";
            }

            // Hitungan Status Terlambat
            // $statusPresensi = hitungStatusPresensi($karyawan->id);
            // $data['status_presensi'] = $statusPresensi;

            // Mendapatkan tanggal saat ini
            $tanggal = date('Y-m-d');
            $tanggalAbsen = date('Y-m-d 08:00:00');
            $tanggalHadir = date('Y-m-d H:i:s');

            //QRCode
            $qrModel = new QrcodeModel();
            $qrcode = $qrModel->where('created_on', $tanggal)->get()->first();
            $dataUser = [
                'user_id' => $userId,
                'code' => $qrcode->code,
                'tanggal' => $tanggalAbsen,
                'created_by' => $karyawan->id,
                'created_on' => $tanggalHadir,
            ];
            $dataString = json_encode($dataUser);
            $filename = $userId;
            qrcode($dataString, $filename);
            $data['filename'] = $filename;
            $data['absen'] = json_encode($dataUser);
            $data['tanggal'] = $tanggal;

            //data presensi
            $presensi = new PresensiModel();
            $absen = $presensi->where('user_id', $userId)->get()->first();
            $data['absensi'] = $absen;

            //menghitung data dinamis kehadiran
            $bulanIni = date('m', strtotime($tanggal));
            $tahun = date('Y', strtotime($tanggal));

            $presensi = new PresensiModel();
            //per Bulan
            $hitung = $presensi->hitungTidakHadirBulanIni($userId, $tanggal, $bulanIni, $tahun);
            $terlambat = $presensi->hitungTerlambatBulanIni($userId, $tanggal, $bulanIni, $tahun);
            //per Tahun
            $hitungPerTahun = $presensi->hitungTidakHadirTahunIni($userId, $tahun);
            $terlambatPerTahun = $presensi->hitungTerlambatTahunIni($userId, $tahun);

            $data['hitungBulanIni'] = $hitung;
            $data['hitungTahunIni'] = $hitungPerTahun;

            $data['terlambatBulanIni'] = $terlambat;
            $data['terlambatTahunIni'] = $terlambatPerTahun;

            // // data Hari Libur dari API
            // $dataHariLibur = getHariLibur();
            // $data['dataHariLibur'] = $dataHariLibur;

            //Tanggal
            $tanggalBulanIni = getTanggal();
            $data['getTanggal'] = $tanggalBulanIni;

            // $month = date('n');
            // $year = date('Y');
            // $calendar = generateCalendar($userId, $year, $month, $bulanIni);

            // $data['calendar'] = $calendar;
            // var_dump($data['calendar']);
            // die;

            //Status
            // $status = getStatus($userId, $tanggal);
            // // var_dump($status);
            // // die;
            // $data['status'] = $status;

            $existAbsen = PresensiModel::where('user_id', $userId)
                ->where('tanggal', $tanggalAbsen)
                ->first();
            $data['existAbsen'] = $existAbsen;
            $data['tanggalAbsen'] = $tanggalAbsen;

            $this->load->view('template/header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('User/dashboard', $data);
            $this->load->view('template/footer');
        }
    }

    public function getPresensiData()
    {
        // Ambil parameter dari permintaan AJAX
        $userId = $_POST['userId'];
        $year = $_POST['year'];
        $month = $_POST['month'];

        // Panggil fungsi untuk mengambil data presensi
        $presensiData = getPresensiData($userId, $year, $month);

        // Kembalikan data presensi dalam format yang sesuai (misalnya, dalam bentuk HTML)
        echo generatePresensiHTML($presensiData);
    }
}
