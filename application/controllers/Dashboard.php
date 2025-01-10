<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

	
    public function index()
    {
        $q = $this->User_model->getUserAll();
        $data['users'] = $q->result();

        $this->load->view('view_dashboard', $data);
    }

    public function save_ajax()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password'); // Tidak lagi menggunakan hashing

        $data = [
            'username' => $username,
            'password' => $password
        ];

        $insert = $this->User_model->insertUser($data);

        if ($insert) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function update_ajax()
    {
        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $data = ['username' => $username];

        // Jika password diisi, gunakan password baru tanpa hashing
        if (!empty($password)) {
            $data['password'] = $password;
        }

        $update = $this->User_model->updateUser($id, $data);

        if ($update) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function delete_ajax($id = null)
    {
        $delete = $this->User_model->deleteUser($id);

        if ($delete) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}

/* End of file: Dashboard.php */
