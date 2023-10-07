<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
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
            $data['title'] = 'Rekap';
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

            //data presensi
            $presensi = new PresensiModel();
            $absen = $presensi->where('user_id', $userId)->get()->first();
            $data['absensi'] = $absen;

            $presensi = new PresensiModel();
            //Tanggal
            $tanggalBulanIni = getTanggal();
            $data['getTanggal'] = $tanggalBulanIni;

            $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
            $month = isset($_GET['month']) ? $_GET['month'] : date('n');
            $firstDay = mktime(0, 0, 0, $month, 1, $year);
            $monthName = date('F', $firstDay);
            $data['monthName'] = getIndonesianMonth($monthName);


            $data['year'] = $year;
            $data['month'] = $month;
            $data['tanggal'] = generateTanggalKerja($year, $month);

            $totalTerlambat = $presensi->totalTerlambatBulanTahun($userId, $year, $month);

            $data['totalTerlambat'] = $totalTerlambat;

            $tidakHadir = $presensi->tidakHadirBulanTahun($userId, $year, $month);
            $data['tidakHadir'] = $tidakHadir;

            $sisaHari = $presensi->sisaKesempatanTidakHadir($userId, $year, $month);
            $data['sisaHari'] = $sisaHari;
            // dd($sisaHari);

            $this->load->view('template/header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('User/rekap', $data);
            $this->load->view('template/footer');
        }
    }
}
