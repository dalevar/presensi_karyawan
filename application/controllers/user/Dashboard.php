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
        $get = (object) $_GET;

        if (!isset($login_button)) {
            //data Karyawan
            $data['title'] = 'Dashboard Presensi';
            $userData = $this->session->userdata('user_data');
            $userId = $userData['id'];

            /***** DATA KARYAWAN/USER  *****/
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

            /***** DATA JAM PRESENSI  *****/
            $jamMasuk = KonfigModel::where('nama', 'jam_masuk')->first();
            if ($jamMasuk) {
                // Ambil nilai jam masuk dari hasil query
                $jamMasuk = $jamMasuk->nilai;
            } else {
                // Handle jika jam masuk tidak ditemukan dalam konfigurasi
                $jamMasuk = '08:00';
            }
            // Mendapatkan tanggal saat ini
            $tanggal = date('Y-m-d');
            $tanggalAbsen = date('Y-m-d') . ' ' . $jamMasuk . ':00';
            $tanggalHadir = date('Y-m-d H:i:s');

            /***** DATA & GENERATE QRCODE  *****/
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
            qrcode($dataString, $filename); //Mengirim(parsing) Data kedalam function qrCode
            $data['filename'] = $filename;
            $data['absen'] = json_encode($dataUser);
            $data['tanggal'] = $tanggal;

            /***** DATA TANGGAL,BULAN, TAHUN  *****/
            //menghitung data dinamis kehadiran
            $year = isset($get->year) ? $get->year : date('Y');
            $month = isset($get->month) ? $get->month : date('n');
            $firstDay = mktime(0, 0, 0, $month, 1, $year);
            $monthName = date('F', $firstDay);
            $data['monthName'] = getIndonesianMonth($monthName);
            $data['year'] = $year;
            $data['month'] = $month;

            /***** DATA PRESENSI KARYAWAN  *****/
            $presensi = new PresensiModel();
            $absen = $presensi->where('user_id', $userId)->get()->first();
            $data['absensi'] = $absen;

            $presensiData = $presensi->getPresensiData($userId, $year, $month);
            $data['presensiList'] = $presensiData;

            /***** DATA PRESENSI BULAN & TAHUN  *****/
            /***** BULANAN  *****/
            $totalTerlambatBulanan = $presensi->totalTerlambatBulanTahun($userId, $year, $month);
            $data['totalTerlambatBulanan'] = $totalTerlambatBulanan;

            $tidakHadirBulanan = $presensi->tidakHadirBulanan($userId, $month);
            $data['tidakHadirBulanan'] = $tidakHadirBulanan;

            /***** TAHUNAN  *****/
            $tidakHadirTahunan = $presensi->tidakHadirTahunan($userId, $year);
            $data['tidakHadirTahunan'] = $tidakHadirTahunan;

            $terlambat = totalTerlambatTahun($userId, $year);
            $data['totalTerlambatTahunan'] = $terlambat;

            /***** DATA WFH  *****/
            $totalIsWFH = PresensiModel::getTotalIsWFHByUserId($userId);
            $data['wfh'] = $totalIsWFH;

            /***** PRESENSI EXIST  *****/
            $presensiData = $presensi->getPresensiHariSebelumnya($userId);
            $existAbsen = PresensiModel::where('user_id', $userId)
                ->where('tanggal', $tanggalAbsen)
                ->first();
            $data['existAbsen'] = $existAbsen;
            $data['tanggalAbsen'] = $tanggalAbsen;

            /***** VIEW  *****/
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
