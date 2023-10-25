<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RekapTahunan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        admin_access();
        $this->load->model('UserModel');
        $this->load->library('session');
        $this->load->model('PresensiModel');
        $this->load->model('KaryawanModel');
        $this->load->model('JabatanModel');
        $this->load->model('KonfigModel');
    }

    public function index()
    {
        if (!isset($login_button)) {
            $data['title'] = 'Rekap Tahunan';
            $data['user'] = $this->session->userdata('user_data');

            $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
            $month = isset($_GET['month']) ? $_GET['month'] : date('n');
            $firstDay = mktime(0, 0, 0, $month, 1, $year);
            $monthName = date('F', $firstDay);
            $data['monthName'] = getIndonesianMonth($monthName);

            $karyawanModel = new KaryawanModel();
            $karyawanList = $karyawanModel->getKaryawan();
            $data['karyawanList'] = $karyawanList;

            $data['year'] = $year;
            $data['month'] = $month;
            $data['tanggal'] = generateTanggalKerja($year, $month);

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/RekapTahunan', $data);
            $this->load->view('template/footer');
        }
    }


    public function adminEditJamMasuk()
    {
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk Presensi', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Jam Masuk Presensi gagal diperbarui');
            $this->index();
        } else {
            $jamMasukBaru = $this->input->post('jam_masuk');
            $userId = $this->input->post('userId');
            $tanggal = $this->input->post('tanggal');
            $presensi = new PresensiModel();
            // dd($presensi);
            $presensiData = $presensi->where('user_id', $userId)
                ->whereDay('created_on', $tanggal)
                ->first();
            // dd($presensiData);
            if ($presensiData) {
                // $jamMasukBaruPresensi = $jamMasukBaru;
                $createdOnLama = $presensiData->created_on;
                $tanggalBaru = date('Y-m-d', strtotime($createdOnLama)) . ' ' . $jamMasukBaru;
                // $tanggalBaru = date('Y-m-d H:i:s', strtotime($createdOnLama . $jamMasukBaru));
                $presensiData->created_on = $tanggalBaru;
                $presensiData->save();

                // Redirect atau kirim pesan sukses jika berhasil
                $this->session->set_flashdata('berhasil', 'Jam masuk berhasil diubah.');
                redirect('admin/RekapTahunan');
            } else {
                // Redirect atau kirim pesan kesalahan jika data tidak ditemukan
                $this->session->set_flashdata('gagal', 'Data tidak ditemukan.');
                redirect('admin/RekapTahunan');
            }
        }
    }

    public function adminEditWFH()
    {
        $userId = $this->input->post('userId');
        $tanggal = $this->input->post('tanggal');
        $isWfh = $this->input->post('isWfh');
        $presensi = new PresensiModel();
        $presensiData = $presensi->where('user_id', $userId)
            ->whereDay('tanggal', $tanggal)
            ->first();

        if ($presensiData) {
            $presensiData->is_wfh = $isWfh;
            $presensiData->save();

            // Redirect dengan pesan sukses jika berhasil
            $this->session->set_flashdata('berhasil', 'Status WFH berhasil diubah.');
        } else {
            // Redirect dengan pesan kesalahan jika data tidak ditemukan
            $this->session->set_flashdata('gagal', 'Data tidak ditemukan.');
        }
    }

    public function adminEditSakit()
    {
        $userId = $this->input->post('userId');
        $tanggal = $this->input->post('tanggal');
        $isSakit = $this->input->post('isSakit');
        $presensi = new PresensiModel();
        $presensiData = $presensi->where('user_id', $userId)
            ->whereDay('tanggal', $tanggal)
            ->first();

        if ($presensiData) {
            $presensiData->is_Sakit = $isSakit;
            $presensiData->save();

            // Redirect dengan pesan sukses jika berhasil
            $this->session->set_flashdata('berhasil', 'Status Kehadiran berhasil diubah.');
        } else {
            // Redirect dengan pesan kesalahan jika data tidak ditemukan
            $this->session->set_flashdata('gagal', 'Data tidak ditemukan.');
        }
    }


    public function adminEditKehadiran()
    {
        $userId = $this->input->post('user_id');
        $tanggal = $this->input->post('tanggal');
        $sakit = $this->input->post('wfhradio');
    }
}
