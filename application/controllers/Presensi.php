<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        user_access();

        $this->load->model('PresensiModel');
    }


    public function index()
    {
        // if (!$this->session->userdata('id')) {
        //     redirect('auth');
        // }

        // Mengambil data dari URL
        $dataEncoded = $this->input->get('data');
        $filename = $this->input->get('filename');

        $data = json_decode(base64_decode($dataEncoded), true);

        // var_dump($data);
        // die;

        // Memeriksa apakah data yang diperlukan ada dalam data yang diambil dari URL
        if (!isset($data['user_id']) || !isset($data['tanggal']) || !isset($data['created_by']) || !isset($data['created_on'])) {
            $this->session->set_flashdata('gagal', 'Data tidak lengkap');
            redirect('user/dashboard');
        }

        $user_id = $data['user_id'];
        $tanggal = $data['tanggal'];
        $created_by = $filename;
        $created_on = $data['created_on'];

        $existAbsen = PresensiModel::where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($existAbsen) {
            // Jika entri presensi sudah ada, beri pesan error atau lakukan tindakan yang sesuai
            $this->session->set_flashdata('berhasil', 'Anda Telah Melakukan Absensi Hari ini pada jam ' . ' ' . $created_on);
        } else {
            $presensi = new PresensiModel();
            $presensi->user_id = $user_id;
            $presensi->tanggal = $tanggal;
            $presensi->created_by = $created_by;
            $presensi->created_on = $created_on;
            $presensi->save();
        }

        //Jika data berhasil disimpan
        if ($presensi->id) {
            $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk');
            redirect('user/dashboard');
        } else {
            $this->session->set_flashdata('gagal', 'Data Anda tidak ada');
            redirect('user/dashboard');
        }
    }

    public function Presensi()
    {
        $userData = $this->session->userdata('user_data');
        $userId = $userData['id'];
        $year = $this->input->get('year');
        $month = $this->input->get('month');

        // Panggil model atau akses database Anda untuk mengambil data presensi
        $this->load->model('PresensiModel');
        $presensiData = $this->PresensiModel->getPresensiData($userId, $year, $month);

        // Konversi data presensi menjadi format JSON
        $jsonResponse = json_encode($presensiData);

        // Atur header HTTP untuk memberi tahu bahwa ini adalah respons JSON
        header('Content-Type: application/json');

        // Keluarkan respons JSON
        echo $jsonResponse;
    }



    // public function index()
    // {
    //     // if (!$this->session->userdata('id')) {
    //     //     redirect('auth');
    //     // }

    //     $user_id = $this->input->get('user_id');
    //     $tanggal = $this->input->get('tanggal');
    //     $created_by = $this->input->get('created_by');
    //     $created_on = $this->input->get('waktuabsen');


    //     $existAbsen = PresensiModel::where('user_id', $user_id)
    //         ->where('tanggal', $tanggal)
    //         ->first();


    //     if ($existAbsen) {
    //         // Jika entri presensi sudah ada, beri pesan error atau lakukan tindakan yang sesuai
    //         $this->session->set_flashdata('berhasil', 'Anda Telah Melakukan Absensi Hari ini pada jam ' . ' ' . $created_on);
    //     } else {
    //         $presensi = new PresensiModel();
    //         $presensi->user_id = $user_id;
    //         $presensi->tanggal = $tanggal;
    //         $presensi->created_by = $created_by;
    //         $presensi->created_on = $created_on;
    //         $presensi->save();
    //     }

    //     //Jika data berhasil disimpan
    //     if ($presensi->id) {
    //         $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk');
    //         redirect('user/dashboard');
    //     } else {
    //         $this->session->set_flashdata('gagal', 'Data Anda tidak ada');
    //         redirect('user/dashboard');
    //     }
    // }
}
