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
        $get = (object) $_GET;

        if (!isset($login_button)) {
            $data['title'] = 'Dashboard Presensi';

            /***** DATA USER  *****/
            $userData = $this->session->userdata('user_data');
            $data['user'] = $userData;

            /***** DATA PRESENSI  *****/
            $presensiModel = new PresensiModel();
            $tanggal = date('Y-m-d');
            //Terlambat
            $keterlambatan = $presensiModel->hitungTerlambatHariIni($tanggal);
            $data['keterlambatan'] = $keterlambatan;
            //Tidak Hadir
            $tidakHadir = $presensiModel->hitungTidakHadir($tanggal);
            $data['tidakHadir'] = $tidakHadir;

            $dataPresensi = $presensiModel->getPresensiArray();
            $data['dataPresensi'] = $dataPresensi;

            $presensiHariIni = $presensiModel->getPresensiHariIni($tanggal);
            $data['presensiHariIni'] = $presensiHariIni;

            $getKaryawan = $presensiModel->getAllUserIds();
            $data['getKaryawan'] = $getKaryawan;

            /***** TANGGAL KERJA, BULAN, TAHUN  *****/
            $year = isset($get->year) ? $get->year : date('Y');
            $month = isset($get->month) ? $get->month : date('n');
            $firstDay = mktime(0, 0, 0, $month, 1, $year);
            $monthName = date('F', $firstDay);
            $data['monthName'] = getIndonesianMonth($monthName);

            $data['year'] = $year;
            $data['month'] = $month;
            $data['tanggal'] = generateTanggalKerja($year, $month);

            /***** VIEW  *****/
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('Admin/dashboard', $data);
            $this->load->view('template/footer');
        }
    }
}
