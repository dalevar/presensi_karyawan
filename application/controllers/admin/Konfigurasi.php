<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfigurasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        admin_access();
        $this->load->model('UserModel');
        $this->load->library('session');
        $this->load->model('KonfigModel');
        $this->load->model('PresensiModel');
    }

    public function index()
    {
        if (!isset($login_button)) {
            $data['title'] = 'Konfigurasi';
            $data['konfig'] = KonfigModel::all();
            $data['user'] = $this->session->userdata('user_data');

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/konfigurasi', $data);
            $this->load->view('template/footer');
        }
    }

    public function PengaturanJam()
    {
        $this->_rules();
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Jam Masuk Dan Berakhir Harus diisi');
            $this->index();
        } else {
            $input = $this->input->post(null, true);
            $jamMasuk = $input['waktuMasuk'];
            $JamBerakhir = $input['waktuBerakhir'];

            // Temukan data dengan nama 'jam_masuk' dalam tabel 'konfig'
            $dataJamMasuk = KonfigModel::where('nama', 'jam_masuk')->first();
            $dataJamBerakhir = KonfigModel::where('nama', 'jam_berakhir')->first();
            if ($dataJamMasuk) {
                if ($dataJamBerakhir) {
                    $dataJamMasuk->nilai = $jamMasuk;
                    $dataJamBerakhir->nilai = $JamBerakhir;
                    $dataJamMasuk->save();
                    $dataJamBerakhir->save();

                    // Update kolom 'nilai' dengan nilai baru
                    $this->session->set_flashdata('berhasil', 'Jam Masuk Ditambahkan');
                    $this->index();
                }
            } else {
                //Jika data dengan nama 'jam_masuk' tidak ditemukan, Anda dapat menambahkannya sebagai berikut
                $dataBaru = new KonfigModel();
                $dataBaru->nama = 'jam_masuk';
                $dataBaru->nama = 'jam_berakhir';
                $dataBaru->nilai = $jamMasuk;
                $dataBaru->save();

                $this->session->set_flashdata('gagal', 'Data tidak ada');
                $this->index();
            }
        }
    }

    public function settingKeterlambatan()
    {
        $this->form_validation->set_rules('kali_keterlambatan', 'Kali Keterlambatan', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Kali Keterlambatan Harus Diisi');
            $this->index();
        } else {
            $input = $this->input->post(null, true);
            $kali_keterlambatan = $input['kali_keterlambatan'];

            $dataKaliKeterlambatan = KonfigModel::where('nama', 'kali_keterlambatan')->first();

            if ($dataKaliKeterlambatan) {
                $dataKaliKeterlambatan->nilai = $kali_keterlambatan;
                $dataKaliKeterlambatan->save();

                $this->session->set_flashdata('berhasil', 'Kali Keterlambatan Ditambahkan');
                $this->index();
            } else {
                $this->session->set_flashdata('gagal', 'gagal menambahkan data');
                $this->index();
            }
        }
    }

    public function PengaturanHari()
    {
        $this->form_validation->set_rules('wfh', 'Menit', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Menit Harus diisi');
            $this->index();
        } else {
            $input = $this->input->post(null, true);
            $waktu = $input['wfh'];

            $dataWfh = KonfigModel::where('nama', 'wfh')->first();
            if ($dataWfh) {
                $dataWfh->nilai = $waktu;

                $dataWfh->save();
                $this->session->set_flashdata('berhasil', 'Pengurangan Menit Ditambahkan');
                $this->index();
            } else {
                $this->session->set_flashdata('gagal', 'Data tidak ada');
                $this->index();
            }
        }
    }

    public function alokasiSakit()
    {
        $this->form_validation->set_rules('batasSakit', 'Batas Maksimal Sakit', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('gagal', 'Batas Maksimal Sakit');
            $this->index();
        } else {
            $input = $this->input->post(null, true);
            $batasSakit = $input['batasSakit'];

            $dataSakit = KonfigModel::where('nama', 'sakit')->first();
            if ($dataSakit) {
                $dataSakit->nilai = $batasSakit;

                $dataSakit->save();
                $this->session->set_flashdata('berhasil', 'Batas Maksimal Sakit Ditambahkan');
                $this->index();
            } else {
                $this->session->set_flashdata('gagal', 'Data tidak ada');
                $this->index();
            }
        }
    }

    public function cutiKurang()
    {
        $id = $this->input->post('id');
        $dataSakit = KonfigModel::where('nama', 'cuti_kurang')->first();

        if ($dataSakit) {
            $dataSakit->nilai = $id;

            $dataSakit->save();
            $this->session->set_flashdata('berhasil', 'Cuti Dikurangi');
        } else {
            $this->session->set_flashdata('gagal', 'Data tidak ada');
            $this->index();
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('waktuMasuk', 'Jam Masuk', 'required');
        $this->form_validation->set_rules('waktuBerakhir', 'Jam Berakhir', 'required');
    }
}
