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

	public function add()
	{
		$this->load->view('view_add_user');
	}

	public function tableUser()
	{

		$q = $this->User_model->getUserAll();
		$dt = [];
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$dt[] = $row;
			}

			$ret['status'] = true;
			$ret['data'] = $dt;
			$ret['message'] = '';
		} else {
			$ret['status'] = false;
			$ret['data'] = [];
			$ret['message'] = 'Data tidak tersedia';
		}

		echo json_encode($ret);
	}

	public function save()
	{
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->input->post('password');
		$id = $this->input->post('id');

		if ($data['username'] == '' || $data['password'] == '') {
			$ret = array(
				'status' => false,
				'message' => 'Username atau Password tidak boleh kosong'
			);
		} else {
			$q = $this->User_model->getUserByUsername($data['username']);
			if ($q->num_rows() > 0) {
				$ret = array(
					'status' => false,
					'message' => 'Username sudah digunakan'
				);
			} else {

				if ($id != '') {
					$update = $this->User_model->updateUser($id, $data);
					if ($update) {
						$ret = array(
							'status' => true,
							'message' => 'Data berhasil diupdate'
						);
					} else {
						$ret = array(
							'status' => false,
							'message' => 'Data gagal diupdate'
						);
					}
				} else {
					$insert = $this->User_model->insertUser($data);

					if ($insert) {
						$ret = array(
							'status' => true,
							'message' => 'Data berhasil disimpan'
						);
					} else {
						$ret = array(
							'status' => false,
							'message' => 'Data gagal disimpan'
						);
					}
				}
			}
		}




		echo json_encode($ret);
	}

	public function edit()
	{

		$id = $this->input->post('id');
		$q = $this->User_model->getUserByID($id);



		if ($q->num_rows() > 0) {
			$ret = array(
				'status' => true,
				'data' => $q->row(),
				'message' => ''
			);
		} else {
			$ret = array(
				'status' => false,
				'data' => [],
				'message' => 'Data tidak ditemukan',
				'query' => $this->db->last_query()
			);
		}

		echo json_encode($ret);
	}

	public function update()
	{
		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$data = array(
			'username' => $username,
			'password' => $password
		);

		$update = $this->User_model->updateUser($id, $data);

		if ($update) {
			$ret = array(
				'status' => true,
				'message' => 'Data berhasil diupdate'
			);
		} else {
			$ret = array(
				'status' => false,
				'message' => 'Data gagal diupdate'
			);
		}

		echo json_encode($ret);
	}

	public function delete()
	{

		$id = $this->input->post('id');
		$q = $this->User_model->deleteUser($id);

		if ($q) {
			$ret['status'] = true;
			$ret['message'] = 'Data berhasil dihapus';
		} else {
			$ret['status'] = false;
			$ret['message'] = 'Data gagal dihapus';
		}

		echo json_encode($ret);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}
}

/* End of file: Dashboard.php */