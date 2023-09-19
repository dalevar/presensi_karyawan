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
        $data['title'] = 'Management User';
        $data['tipe'] = TipeModel::all();
        $data['jabatan'] = JabatanModel::all();
        $userId = $this->session->userdata('id');
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);
        $data['user'] = $user;

        $dataKaryawan = $this->KaryawanModel->getKaryawan();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('Admin/manageuser', ['karyawan' => $dataKaryawan], $data);
        $this->load->view('template/footer');
    }

    public function tambahKaryawan()
    {
        $this->_rules();
        $this->form_validation->set_rules('email_karyawan', 'Email', 'required|valid_email|is_unique[user.email]', [
            'is_unique' => 'this email has already registered'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Masukkan semua data karyawan dengar benar');

            $this->index();
        } else {
            $now = date('Y-m-d H:i:s');
            // Langkah 1: Masukkan data ke tabel 'user' menggunakan Eloquent
            $user = new UserModel();
            $user->email = $this->input->post('email_karyawan');
            $user->password = password_hash($this->input->post('confirm_password'), PASSWORD_DEFAULT);
            $user->login_access = 0;
            $user->created_on = $now;
            $user->save();

            // Langkah 2: Dapatkan ID user yang baru saja dimasukkan
            $user_id = $user->id;

            //ambil datanya berdasarkan inputan
            $namaKaryawan = $this->input->post('nama_karyawan');
            $tanggalMasuk = $this->input->post('tanggal_masuk');
            $tipe = $this->input->post('tipe_id');
            $jabatan = $this->input->post('jabatan_id');
            $tingkatPendidikan = $this->input->post('tingkat_pendidikan');
            $catatan = $this->input->post('catatan');

            //masukkan data berdasarkan inputan yang telah diinput
            $karyawan = new KaryawanModel();
            $karyawan->user_id = $user_id;
            $karyawan->nama = $namaKaryawan;
            $karyawan->tanggal_masuk = $tanggalMasuk;
            $karyawan->tipe_id = $tipe;
            $karyawan->jabatan_id = $jabatan;
            $karyawan->tingkat_pendidikan = $tingkatPendidikan;
            $karyawan->catatan = $catatan;
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


    // public function editOtorisasi($id)
    // {
    //     $this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]');
    //     $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
    //     // Pastikan ID pengguna tidak kosong
    //     if (!empty($id)) {
    //         $now = date('Y-m-d H:i:s');

    //         $userModel = new UserModel();
    //         $newPassword = $this->input->post('new_password');

    //         // Hash kata sandi baru (jika perlu)
    //         $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    //         // Temukan pengguna berdasarkan ID
    //         $user = $userModel->find($id);
    //         if ($user) {
    //             // Simpan waktu pembaharuan
    //             $user->update_on = $now;

    //             // Hanya perbarui kata sandi jika ada kata sandi baru
    //             if (!empty($newPassword)) {
    //                 $userModel->password = $hashedPassword;
    //             }

    //             // Gunakan Eloquent untuk memperbarui kata sandi
    //             $userModel->where('id', $id)->update(['password' => $hashedPassword]);
    //             $user->save();

    //             //jika berhasil
    //             $this->session->set_flashdata('berhasil', 'Data Karyawan Berhasil diperbarui');
    //             redirect('admin/manageuser');
    //         } else {
    //             $this->session->set_flashdata('gagal', 'Data Karyawan tidak ditemukan atau pembaruan gagal');
    //             redirect('admin/manageuser');
    //         }
    //     } else {
    //         $this->session->set_flashdata('gagal', 'Data Karyawan tidak ditemukan atau pembaruan gagal');
    //         redirect('admin/manageuser');
    //     }
    // }

    public function hapusKaryawan($id)
    {
        $id = $this->input->post('id');
        $karyawan = new KaryawanModel();
        $hapusKaryawan = $karyawan->deleteKaryawan($id);

        if ($hapusKaryawan) {
            $this->session->set_flashdata('berhasil', 'Data Karyawan berhasil dihapus');
        } else {
            $this->session->set_flashdata('gagal', 'Data Karyawan tidak ditemukan atau gagal dihapus');
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
