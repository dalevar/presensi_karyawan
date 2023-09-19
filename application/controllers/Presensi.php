<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('PresensiModel');
    }

    public function index()
    {
        if (!$this->session->userdata('id')) {
            redirect('auth');
        }


        $user_id = $this->input->get('user_id');
        $tanggal = $this->input->get('tanggal');
        $created_by = $this->input->get('created_by');
        $created_on = $this->input->get('waktuabsen');

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
}
