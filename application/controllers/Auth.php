<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModel');
        $this->load->model('UserModel');
        $this->load->model('KaryawanModel');
        $this->load->model('QrcodeModel');
        $this->load->helper('string');
        $this->load->library('session');
    }

    public function index()
    {
        include_once APPPATH . "libraries/vendor/autoload.php";
        $google_client = new Google_Client();
        $google_client->setClientId('657072900008-ueodlmn2rlav9ovcns03fug8dkqojchh.apps.googleusercontent.com'); //Define your ClientID
        $google_client->setClientSecret('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'); //Define your Client Secret Key
        $google_client->setRedirectUri('http://localhost/presensi_karyawan/auth'); //Define your Redirect Uri
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if (isset($_GET["code"])) {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
            if (!isset($token["error"])) {
                $google_client->setAccessToken($token['access_token']);
                $this->session->set_userdata('access_token', $token['access_token']);
                $google_service = new Google_Service_Oauth2($google_client);
                $data = $google_service->userinfo->get();
                $current_datetime = date('Y-m-d H:i:s');

                $user = UserModel::firstOrNew(['login_oauth_uid' => $data['id']]);
                $karyawan = KaryawanModel::where('email', $data['email'])->first();

                if (!$user->exists) {
                    if ($data['email'] == $karyawan->email) {
                        if ($karyawan) {
                            // Data pengguna belum ada, masukkan data
                            $user->login_access = 0;
                            $user->first_name = $data['given_name'];
                            $user->last_name = $data['family_name'];
                            $user->email_address = $data['email'];
                            $user->profile_picture = $data['picture'];
                            $user->created_at = $current_datetime;
                            $user->save();

                            $this->session->set_flashdata('berhasil', 'Email Anda Telah Terdaftar Harap Login kembali');
                            redirect('auth/berhasil');
                        }
                    } else {
                        $this->session->set_flashdata('gagal', 'Email Tidak Terdaftar!');
                        redirect('auth/gagal');
                    }
                } elseif (UserModel::where('login_oauth_uid', $data['id'])->exists()) {
                    $user_data = [
                        // 'login_access' => 1,
                        'id' => $user->id,
                        'first_name' => $data['given_name'],
                        'last_name' => $data['family_name'],
                        'email_address' => $data['email'],
                        'profile_picture' => $data['picture'],
                        'updated_at' => $current_datetime,
                    ];

                    UserModel::where('login_oauth_uid', $data['id'])->update($user_data);
                    KaryawanModel::where('email', $user_data['email_address'])->update(['user_id' => $user_data['id']]);
                } else {
                    UserModel::where('login_oauth_uid', $data['id'])->first();
                }
                // Set data pengguna dalam sesi
                $user_data = [
                    'id' => $user->id,
                    'login_oauth_uid' => $user->login_oauth_uid,
                    'login_access' => $user->login_access,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email_address' => $user->email_address,
                    'profile_picture' => $user->profile_picture,
                ];
                $this->session->set_userdata('user_data', $user_data);

                //qrcode data
                $tanggal = date('Y-m-d');
                $code = strtoupper(random_string('alnum', 6));

                $dataUser = [
                    'user_id' => $user->id,
                    'code' => $code,
                    'created_on' => $tanggal,
                ];

                $dataString = json_encode($dataUser);
                $filename = $user->id;

                $existingQr = QrcodeModel::where('created_on', $dataUser['created_on'])->first();

                if (!$existingQr) {
                    $qr = new QrcodeModel();

                    $qr->code = $dataUser['code'];
                    $qr->created_on = $dataUser['created_on'];
                    $qr->save();
                } else {
                    $qr = $existingQr;
                }
            }
        }

        $login_button = '';
        if (!$this->session->userdata('access_token')) {
            $login_button = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-outline-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 262" preserveAspectRatio="xMidYMid">
            <path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4"></path>
            <path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853"></path>
            <path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05"></path>
            <path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335"></path>
        </svg>
        <span class="ml-1 text-dark font-weight-bold">Google</span></a>';
            $data['login_button'] = $login_button;
            $data['title'] = 'Login';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('template/auth_footer');
        } else {
            $user_data = $this->session->userdata('user_data');

            if (isset($user_data['login_access']) && $user_data['login_access'] == 1) {
                redirect('admin/dashboard');
            } else if (isset($user_data['login_access']) && $user_data['login_access'] == 0) {
                //kirim data ke fungsi generate qrcode
                qrcode($dataString, $filename);
                redirect('user/dashboard');
            } else {
            }
        }
    }

    function logout()
    {
        $this->session->unset_userdata('access_token');
        $this->session->unset_userdata('user_data');
        $this->session->set_flashdata('berhasil', 'Anda Telah Berhasil Logout!');

        redirect('auth');
    }

    /*************** GAGAL LOGIN ***************/
    // function gagal()
    // {
    //     $this->session->unset_userdata('access_token');
    //     $this->session->unset_userdata('user_data');
    //     $this->session->set_flashdata('gagal', 'Email Tidak Terdaftar!');
    //     redirect('auth');
    // }

    function gagal()
    {
        $this->session->unset_userdata('access_token');
        $this->session->unset_userdata('user_data');

        //memerikasa apakah data table user ada data atau tidak ada data
        $user_count = $this->UserModel->count(); // Menghitung jumlah data dalam tabel "user"
        if ($user_count > 0) {
            // Ada data pengguna, tetapi login gagal, tampilkan pesan kesalahan
            $this->session->set_flashdata('gagal', 'Email Tidak Terdaftar!');
            redirect('auth');
        } else {
            $this->session->set_flashdata('info', 'Pilih Email yang ingin anda jadikan sebagai admin');

            include_once APPPATH . "libraries/vendor/autoload.php";
            $google_client = new Google_Client();
            $google_client->setClientId('657072900008-ueodlmn2rlav9ovcns03fug8dkqojchh.apps.googleusercontent.com'); //Define your ClientID
            $google_client->setClientSecret('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'); //Define your Client Secret Key
            $google_client->setRedirectUri('http://localhost/presensi_karyawan/auth/gagal'); //Define your Redirect Uri
            $google_client->addScope('email');
            $google_client->addScope('profile');

            if (isset($_GET["code"])) {
                $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
                if (!isset($token["error"])) {
                    $google_client->setAccessToken($token['access_token']);
                    $this->session->set_userdata('access_token', $token['access_token']);
                    $google_service = new Google_Service_Oauth2($google_client);
                    $data = $google_service->userinfo->get();
                    $current_datetime = date('Y-m-d H:i:s');

                    $user = UserModel::firstOrNew(['login_oauth_uid' => $data['id']]);

                    if (!$user->exists) {
                        $user->login_access = 1;
                        $user->first_name = $data['given_name'];
                        $user->last_name = $data['family_name'];
                        $user->email_address = $data['email'];
                        $user->profile_picture = $data['picture'];
                        $user->created_at = $current_datetime;
                        $user->save();

                        $this->session->set_flashdata('berhasil', 'Email Anda Telah Terdaftar Harap Login kembali');
                        redirect('auth/berhasil');
                    }
                }
            }


            $login_button = '';
            if (!$this->session->userdata('access_token')) {
                $login_button = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-outline-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 262" preserveAspectRatio="xMidYMid">
                <path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4"></path>
                <path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853"></path>
                <path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05"></path>
                <path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335"></path>
            </svg>
            <span class="ml-1 text-dark font-weight-bold">Google</span></a>';
                $data['login_button'] = $login_button;

                // Tidak ada data pengguna, arahkan untuk membuat akun
                $data['title'] = 'Registrasi Akun Baru';
                $this->load->view('template/auth_header', $data);
                $this->load->view('auth/register_form', $data); // Tampilkan form pendaftaran
                $this->load->view('template/auth_footer');
            }
        }
    }


    /*************** BERHASIL LOGIN ***************/
    function berhasil()
    {
        $this->session->unset_userdata('access_token');
        $this->session->unset_userdata('user_data');
        $this->session->set_flashdata('berhasil', 'Email Anda Telah Terdaftar Harap Login kembali');

        redirect('auth');
    }
}
