<?php
//menampilkan data user menggunakan libraries
class Fungsi
{
    protected $ci;
    protected $userModel;

    public function __construct()
    {

        $this->ci = get_instance();
        $this->ci->load->model('UserModel');
    }

    function user_login()
    {
        // Diambil dari session yang login
        $userData = $this->ci->session->userdata('user_data');
        // $userModel = $this->ci->UserModel;
        // // Menggunakan Eloquent untuk mengambil data pengguna
        // $userData = $userModel->find($userId);

        return $userData;
    }
}
