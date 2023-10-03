<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tipe_jabatan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        admin_access();

        $this->load->model('TipeModel');
        $this->load->model('JabatanModel');
    }

    public function index()
    {
        if (!isset($login_button)) {
            $data['title'] = 'Tipe & Jabatan';
            $data['tipe'] = TipeModel::all();
            $data['jabatan'] = JabatanModel::all();
            $data['user'] = $this->session->userdata('user_data');

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('Admin/tipe_jabatan', $data);
            $this->load->view('template/footer');
        }
    }

    public function tambahTipeJabatan()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Tipe Dan Jabatan harus diisi');
            $this->index();
        } else {
            $input = $this->input->post(null, TRUE);

            $inputTipe = $input['tipe'];
            $tipe = new TipeModel();
            $tipe->tipe = $inputTipe;
            $tipe->save();

            $inputJabatan = $input['jabatan'];
            $jabatan = new JabatanModel();
            $jabatan->jabatan = $inputJabatan;
            $jabatan->save();

            $this->session->set_flashdata('berhasil', 'Tipe Dan Jabatan ditambahkan');
            redirect('admin/tipe_jabatan');
        }
    }

    public function EditTipe($id)
    {
        $this->_rules();

        if (!$this->form_validation->run() == false) {
            $this->index();
        } else {
            // Tangkap data yang dikirimkan dari form edit
            $data = array(
                'id' => $this->input->post('id'),
                'tipe' => $this->input->post('tipe'),
            );

            // Panggil method updateKaryawan dari model
            $result = $this->TipeModel->updateTipe($id, $data);

            if ($result) {
                // Pembaruan berhasil
                $this->session->set_flashdata('berhasil', 'Tipe Berhasil diperbarui');
            } else {
                // Pembaruan gagal
                $this->session->set_flashdata('gagal', 'Tipe tidak ditemukan atau pembaruan gagal');
            }

            redirect('admin/tipe_jabatan');
        }
    }

    public function hapusTipe($id)
    {
        $id = $this->input->post('id');
        $tipe = new TipeModel();
        $hapusTipe = $tipe->deleteTipe($id);

        if ($hapusTipe) {
            $this->session->set_flashdata('berhasil', 'Tipe berhasil dihapus');
        } else {
            $this->session->set_flashdata('gagal', 'Tipe tidak ditemukan atau gagal dihapus');
        }
        redirect('admin/Tipe_jabatan');
    }

    public function EditJabatan($id)
    {
        $this->_rules();

        if (!$this->form_validation->run() == false) {
            $this->index();
        } else {
            // Tangkap data yang dikirimkan dari form edit
            $data = array(
                'id' => $this->input->post('id'),
                'jabatan' => $this->input->post('jabatan'),
                'alokasi_cuti' => $this->input->post('cuti'),
            );

            // Panggil method updateKaryawan dari model
            $result = $this->JabatanModel->updateJabatan($id, $data);

            if ($result) {
                // Pembaruan berhasil
                $this->session->set_flashdata('berhasil', 'Jabatan Berhasil diperbarui');
            } else {
                // Pembaruan gagal
                $this->session->set_flashdata('gagal', 'Jabatan tidak ditemukan atau pembaruan gagal');
            }

            redirect('admin/tipe_jabatan');
        }
    }

    public function hapusJabatan($id)
    {
        $id = $this->input->post('id');
        $jabatan = new JabatanModel();
        $hapusJabatan = $jabatan->deleteJabatan($id);

        if ($hapusJabatan) {
            $this->session->set_flashdata('berhasil', 'Jabatan berhasil dihapus');
        } else {
            $this->session->set_flashdata('gagal', 'Jabatan tidak ditemukan atau gagal dihapus');
        }
        redirect('admin/Tipe_jabatan');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('tipe', 'Tipe', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    }
}
