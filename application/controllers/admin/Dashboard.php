<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        admin_access();
        $this->load->model('KaryawanModel');
        $this->load->model('PresensiModel');
        $this->load->model('UserModel');
        $this->load->library('session');
    }

    public function index()
    {
        if (!isset($login_button)) {
            $data['title'] = 'Dashboard Presensi';
            $userData = $this->session->userdata('user_data');

            $data['user'] = $userData;

            $presensiModel = new PresensiModel();
            $tanggal = date('Y-m-d');
            //Terlambat
            $keterlambatan = $presensiModel->hitungTerlambatHariIni($tanggal);
            $data['keterlambatan'] = $keterlambatan;
            //Tidak Hadir
            $tidakHadir = $presensiModel->hitungTidakHadir($tanggal);
            // dd($tidakHadir);
            $data['tidakHadir'] = $tidakHadir;

            $dataPresensi = $presensiModel->getPresensiArray();
            // dd($dataPresensi);
            $data['dataPresensi'] = $dataPresensi;

            $presensiHariIni = $presensiModel->getPresensiHariIni($tanggal);
            // dd($presensiHariIni);
            $data['presensiHariIni'] = $presensiHariIni;

            $getKaryawan = $presensiModel->getAllUserIds();
            // dd($getKaryawan);
            $data['getKaryawan'] = $getKaryawan;

            $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
            $month = isset($_GET['month']) ? $_GET['month'] : date('n');
            $firstDay = mktime(0, 0, 0, $month, 1, $year);
            $monthName = date('F', $firstDay);
            $data['monthName'] = getIndonesianMonth($monthName);
            // $dataPresensi = $presensiModel->getPresensiKaryawan($year, $month);
            // // dd($dataPresensi);
            // $data['presensi'] = $dataPresensi;

            $data['year'] = $year;
            $data['month'] = $month;
            $data['tanggal'] = generateTanggalKerja($year, $month);


            // dd($data['indonesianMonthName']);
            // $data['absensi'] = PresensiModel::all();


            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('Admin/dashboard', $data);
            $this->load->view('template/footer');
        }
    }
}
