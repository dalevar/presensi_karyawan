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
            $statusPresensi = hitungStatusPresensi($karyawan->id);
            $data['status_presensi'] = $statusPresensi;

            //data kehadiran
            $bulanIni = date('m');
            $tahunIni = date('Y');
            $model = new PresensiModel();
            $ketidakHadirBulanIni = $model->hitungKetidakHadirBulanTahun($userId, $bulanIni, $tahunIni);

            $data['ketidak_hadir_bulan_ini'] = $ketidakHadirBulanIni;

            // Mendapatkan tanggal saat ini
            $tanggal = date('Y-m-d');

            //QRCode
            $qrModel = new QrcodeModel();
            $qrcode = $qrModel->where('created_on', $tanggal)->get()->first();
            $dataUser = [
                'user_id' => $userId,
                'code' => $qrcode->code,
                'created_on' => $tanggal,
            ];
            $dataString = json_encode($dataUser);
            $filename = $userId;
            qrcode($dataString, $filename);
            $data['filename'] = $filename;
            $data['absen'] = $dataUser;
            $data['tanggal'] = $tanggal;

            //data presensi
            $presensi = new PresensiModel();
            $absen = $presensi->where('user_id', $userId)->get()->first();
            $data['absensi'] = $absen;

            $this->load->view('template/header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('User/dashboard', $data);
            $this->load->view('template/footer');
        }
    }
}
