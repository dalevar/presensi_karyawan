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
        $this->load->model('PresensiModel');
        $this->load->model('QrcodeModel');
        $this->load->library('session');
    }

    public function index()
    {
        if (!$this->session->userdata('id')) {
            redirect('auth');
        }

        //data Karyawan
        $data['title'] = 'Dashboard';
        $userId = $this->session->userdata('id');
        $karyawanModel = new KaryawanModel();
        $karyawan = $karyawanModel->getByUserId($userId);
        $data['karyawan'] = $karyawan;

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
        $data['absen'] = $absen;

        $this->load->view('template/header', $data);
        $this->load->view('template/user_sidebar', $data);
        $this->load->view('User/dashboard', $data);
        $this->load->view('template/footer');
    }

    // public function generate_codeQr()
    // {
    //     $this->load->helper('string');
    //     $code = strtoupper(random_string('alnum', 6));
    //     $tanggalSekarang = date('Y-m-d');
    //     $qrcodeModel = new QrcodeModel();
    //     $cek_data = $qrcodeModel->codeData($code);
    //     if (!empty($cek_data)) {
    //         $code = substr_replace($code, count($cek_data) + 1, 5);
    //     }

    //     $qrcodeModel->code = $code;
    //     $qrcodeModel->created_on = $tanggalSekarang;
    //     $qrcodeModel->save();
    // }
}
