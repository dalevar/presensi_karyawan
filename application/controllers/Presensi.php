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
        $is_wfh = $this->input->get('is_wfh');
        $is_sakit = $this->input->get('is_sakit');


        $data = json_decode(base64_decode($dataEncoded), true);

        // Memeriksa apakah data yang diperlukan ada dalam data yang diambil dari URL
        if (!isset($data['user_id']) || !isset($data['tanggal']) || !isset($data['created_by']) || !isset($data['created_on'])) {
            $this->session->set_flashdata('gagal', 'Data tidak lengkap');
            redirect('user/dashboard');
        }

        $user_id = $data['user_id'];
        $tanggal = $data['tanggal'];
        $created_by = $filename;
        $is_wfh = $is_wfh;
        $is_sakit = $is_sakit;
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
            $presensi->is_wfh = $is_wfh;
            $presensi->is_sakit = $is_sakit;
            $presensi->created_on = $created_on;
            // $presensi->save();
            // if ($presensi->save()) {
            //     if ($presensi->id) {
            //         // $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
            //         // $month = isset($_GET['month']) ? $_GET['month'] : date('n');
            //         // $presensiData = $presensi->getPresensiData($user_id, $year, $month);
            //         // $latestPresensi = PresensiModel::where('user_id', $user_id)
            //         //     ->orderBy('created_on', 'desc')
            //         //     ->first();
            //         $presensiData = $presensi->getPresensiHariSebelumnya($user_id);
            //         if (!empty($presensiData)) {
            //             // $presensi = $presensiData[0];

            //             $tanggalHariSebelumnya = date('Y-m-d', strtotime('-1 day'));
            //             $currentDate = date('Y-m-d');
            //             $tanggalPresensi = date('Y-m-d', strtotime($presensi->created_on));

            //             if ($tanggalPresensi == $tanggalHariSebelumnya) {
            //                 $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk');
            //                 redirect('user/dashboard');
            //             } else if ($tanggalPresensi < $tanggalHariSebelumnya) {
            //                 $this->session->set_flashdata('pemberitahuan', 'SAKIT');
            //                 redirect('user/dashboard');
            //             }

            //             // if ($tanggalPresensi < $tanggalHariSebelumnya) {
            //             //     $this->session->set_flashdata('pemberitahuan', 'SAKIT');
            //             //     redirect('user/dashboard');
            //             // }

            //         } else {
            //             $this->session->set_flashdata('gagal', 'Data Anda tidak ada');
            //             redirect('user/dashboard');
            //         }
            //     }
            // }

            $presensiData = $presensi->getPresensiHariSebelumnya($user_id);
            if (!empty($presensiData)) {
                $tanggalHariSebelumnya = date('Y-m-d', strtotime('-1 day'));
                $currentDate = date('Y-m-d');
                $tanggalPresensi = date('Y-m-d', strtotime($presensiData->created_on));
                if ($tanggalPresensi == $tanggalHariSebelumnya || date('w', strtotime($tanggalHariSebelumnya)) == 0) {
                    $presensi->save();
                    $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk');
                    redirect('user/dashboard');
                } elseif ($tanggalPresensi != $tanggalHariSebelumnya) {
                    $presensi->save();
                    $this->session->set_flashdata('pemberitahuan', 'SAKIT');
                    redirect('user/dashboard');
                }
            } else {
                $this->session->set_flashdata('gagal', 'Data Anda tidak ada');
                redirect('user/dashboard');
            }

            // //Jika data berhasil disimpan
            // if ($presensi->id) {
            //     $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk');
            //     redirect('user/dashboard');
            // } else {
            //     $this->session->set_flashdata('gagal', 'Data Anda tidak ada');
            //     redirect('user/dashboard');
            // }
        }
    }


    public function tambahPresensiSakit()
    {
        // Ambil data dari permintaan POST
        $absenData = $this->input->post('absen');
        $filename = $this->input->post('filename');
        $is_wfh = $this->input->post('is_wfh');
        $is_sakit = $this->input->post('is_sakit');

        // Lakukan dekode data yang dikirim melalui URL
        $absen = json_decode(base64_decode($absenData), true);
        if (is_array($absen) && isset($absen['user_id'])) {
            $user_id = $absen['user_id'];
            $created_by = $filename;

            // $tanggalHari = date('Y-m-d', strtotime('-1 day'));
            // if (date('w', strtotime($tanggalHari)) != 0) {
            //     // Hanya tambahkan tanggal jika bukan hari Minggu
            //     $created_on = $tanggalHari;
            //     $tanggal = $tanggalHari;
            // }

            $tanggal = date('Y-m-d', strtotime('-1 day'));
            $created_on = $tanggal;

            $presensi = new PresensiModel();
            $presensi->user_id = $user_id;
            $presensi->tanggal = $tanggal;
            $presensi->created_by = $created_by;
            $presensi->is_wfh = $is_wfh;
            $presensi->is_sakit = $is_sakit;
            $presensi->created_on = $created_on;


            if ($presensi->save()) {
                $response = ['success' => true, 'message' => 'Data presensi telah berhasil dimasukkan.'];
            } else {
                $response = ['success' => false, 'message' => $presensi->errors()];
            }
        } else {
            // Handle kesalahan jika data tidak sesuai
            $response = ['success' => false, 'message' => 'Data tidak sesuai atau tidak lengkap'];
            echo json_encode($response);
        }

        // Keluarkan respons dalam format JSON
        echo json_encode($response);
    }

    public function tambahPresensiTidakHadir()
    {
        // Ambil data dari permintaan POST
        $absenData = $this->input->post('absen');
        $filename = $this->input->post('filename');
        $is_wfh = $this->input->post('is_wfh');
        $is_sakit = $this->input->post('is_sakit');

        // Lakukan dekode data yang dikirim melalui URL
        $absen = json_decode(base64_decode($absenData), true);
        if (is_array($absen) && isset($absen['user_id'])) {
            $user_id = $absen['user_id'];
            $created_by = $filename;

            $tanggal = date('Y-m-d', strtotime('-1 day'));
            $created_on = date('Y-m-d', strtotime('-1 day'));

            $presensi = new PresensiModel();
            $presensi->user_id = $user_id;
            $presensi->tanggal = $tanggal;
            $presensi->created_by = $created_by;
            $presensi->is_wfh = $is_wfh;
            $presensi->is_sakit = $is_sakit;
            $presensi->created_on = $created_on;


            if ($presensi->save()) {
                $response = ['success' => true, 'message' => 'Data presensi telah berhasil dimasukkan.'];
            } else {
                $response = ['success' => false, 'message' => $presensi->errors()];
            }
        } else {
            // Handle kesalahan jika data tidak sesuai
            $response = ['success' => false, 'message' => 'Data tidak sesuai atau tidak lengkap'];
            echo json_encode($response);
        }

        // Keluarkan respons dalam format JSON
        echo json_encode($response);
    }


    // public function Presensi()
    // {
    //     $userData = $this->session->userdata('user_data');
    //     $userId = $userData['id'];
    //     $year = $this->input->get('year');
    //     $month = $this->input->get('month');

    //     // Panggil model atau akses database Anda untuk mengambil data presensi
    //     $this->load->model('PresensiModel');
    //     $presensiData = $this->PresensiModel->getPresensiData($userId, $year, $month);

    //     // Konversi data presensi menjadi format JSON
    //     $jsonResponse = json_encode($presensiData);

    //     // Atur header HTTP untuk memberi tahu bahwa ini adalah respons JSON
    //     header('Content-Type: application/json');

    //     // Keluarkan respons JSON
    //     echo $jsonResponse;
    // }
}
