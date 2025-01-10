<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard'); // Redirect jika sudah login
        }
        $this->load->view('view_login');
    }

    public function proses_login()
    {
        header('Content-Type: application/json');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            echo json_encode([
                'status' => false,
                'message' => 'Username dan Password tidak boleh kosong'
            ]);
            return;
        }

        $user = $this->User_model->getUserByUsername($username);

        if ($user) {
            // Cek password secara langsung tanpa password_verify
            if ($user->password === $password) { // Perbandingan langsung dengan password
                $this->session->set_userdata([
                    'logged_in' => true,
                    'username' => $user->username,
                    'user_id' => $user->id
                ]);

                echo json_encode([
                    'status' => true,
                    'message' => 'Login berhasil'
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'Password salah'
                ]);
            }
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
