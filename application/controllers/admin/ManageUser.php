<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ManageUser extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        admin_access();

        $this->load->model('KaryawanModel');
        $this->load->model('TipeModel');
        $this->load->model('JabatanModel');
        $this->load->model('UserModel');
    }

    public function index()
    {
        if (!isset($login_button)) {
            $data['title'] = 'Management User';
            $data['tipe'] = TipeModel::all();
            $data['jabatan'] = JabatanModel::all();
            $data['user'] = $this->session->userdata('user_data');

            $dataKaryawan = $this->KaryawanModel->getKaryawan();
            $data['karyawan'] = $dataKaryawan;
            // $data['karyawan'] = KaryawanModel::all();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('admin/manageUser', $data);
            $this->load->view('template/footer');
        }
    }

    public function tambahKaryawan()
    {
        $this->_rules();
        $this->form_validation->set_rules('email_karyawan', 'Email', 'required|valid_email|is_unique[karyawan.email]', [
            'is_unique' => 'this email has already registered'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Masukkan semua data karyawan dengar benar');
            $this->index();
        } else {
            $input = $this->input->post(null, TRUE);

            //masukkan data berdasarkan inputan yang telah diinput
            $karyawan = new KaryawanModel();
            //$karyawan->user_id = $user_id;//untuk mengambil user_id diperlukan login oleh user baru nantinya table karyawan diupdate dan diisi oleh user_id
            $karyawan->email = $input['email_karyawan'];
            $karyawan->nama = $input['nama_karyawan'];
            $karyawan->tanggal_masuk = $input['tanggal_masuk'];
            $karyawan->tipe_id = $input['tipe_id'];
            $karyawan->jabatan_id = $input['jabatan_id'];
            $karyawan->tingkat_pendidikan = $input['tingkat_pendidikan'];
            $karyawan->catatan = $input['catatan'];
            $karyawan->save();

            $this->session->set_flashdata('berhasil', 'Data berhasil ditambahkan');
            redirect('admin/manageuser');
        }
    }

    public function editKaryawan($id)
    {
        $this->_rules();
        $karyawan = KaryawanModel::find($id);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Data Karyawan ' . $karyawan->nama . ' gagal diperbarui masukkan data dengan benar');

            $this->index();
        } else {
            $input = $this->input->post(null, TRUE);
            $id = $input['id'];
            // Tangkap data yang dikirimkan dari form edit
            $data = array(
                'email' => $input['email_karyawan'],
                'nama' => $input['nama_karyawan'],
                'tanggal_masuk' => $input['tanggal_masuk'],
                'tipe_id' => $input['tipe_id'],
                'jabatan_id' => $input['jabatan_id'],
                'tingkat_pendidikan' => $input['tingkat_pendidikan'],
                'catatan' => $input['catatan']
            );

            // Panggil method updateKaryawan dari model
            $result = $this->KaryawanModel->updateKaryawan($id, $data);

            if ($result) {
                // Pembaruan berhasil
                $this->session->set_flashdata('berhasil', 'Data Karyawan ' . $karyawan->nama .  ' Berhasil diperbarui');
            } else {
                // Pembaruan gagal
                $this->session->set_flashdata('gagal', 'Data Karyawan tidak ditemukan atau pembaruan gagal');
            }

            redirect('admin/manageuser');
        }
    }

    public function hapusKaryawan($id)
    {
        $id = $this->input->post('id');

        // Hapus data dari tabel karyawan berdasarkan ID atau email
        $karyawan = KaryawanModel::find($id);
        if (!$karyawan) {
            $this->session->set_flashdata('gagal', 'Data Karyawan tidak ditemukan atau gagal dihapus');
            redirect('admin/manageuser');
        }

        // Simpan email karyawan sebelum menghapus
        $emailKaryawan = $karyawan->email;

        // Hapus data karyawan
        $hapusKaryawan = $karyawan->delete();

        if ($hapusKaryawan) {
            // Hapus data pengguna (user) berdasarkan email yang sama
            $user = UserModel::where('email_address', $emailKaryawan)->first();
            if ($user) {
                $user->delete();
            }

            $this->session->set_flashdata('berhasil', 'Data Karyawan berhasil dihapus');
        } else {
            $this->session->set_flashdata('gagal', 'Data Karyawan gagal dihapus');
        }

        redirect('admin/manageuser');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_karyawan', 'Nama', 'required');
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');
        $this->form_validation->set_rules('tipe_id', 'Tipe', 'required');
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'required');
        $this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'required');
    }
}
