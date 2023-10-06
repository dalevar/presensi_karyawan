<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        admin_access();
        $this->load->model('UserModel');
        $this->load->library('session');
    }

    public function index()
    {
        if (!isset($login_button)) {
            $data['title'] = 'Laporan';
            $data['user'] = $this->session->userdata('user_data');

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/Laporan', $data);
            $this->load->view('template/footer');
        }
    }
}