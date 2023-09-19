<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
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
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'this email has already registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Account';
            $userId = $this->session->userdata('id');
            $userModel = new UserModel();
            $user = $userModel->getUserById($userId);
            $data['user'] = $user;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('Admin/account', $data);
            $this->load->view('template/footer');
        } else {
            $now = date('Y-m-d H:i:s');

            $email = $this->input->post('email', true);
            $user = new UserModel();
            $user->email = $email;
            $user->password = password_hash($this->input->post('password2'), PASSWORD_DEFAULT);
            $user->login_access = 1;
            $user->created_on = $now;
            $user->save();

            $this->session->set_flashdata('berhasil', 'Account has been created, Please Activate your Account!');
            redirect('admin/account');
        }
    }
}
