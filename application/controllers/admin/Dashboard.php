<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        admin_access();

        $this->load->model('KaryawanModel');
        $this->load->model('UserModel');
        $this->load->library('session');
    }

    public function index()
    {

        $data['title'] = 'Dashboard';
        $userId = $this->session->userdata('id');
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);
        $data['user'] = $user;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('Admin/dashboard', $data);
        $this->load->view('template/footer');
    }
}
