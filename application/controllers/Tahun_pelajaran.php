<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahun_pelajaran extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Masterdata_model', 'md');
	}

	public function index()
	{

		$data = array(
			'menu' => 'backend/menu',
			'content' => 'backend/tahunPelajaranKonten',
			'title' => 'Admin'
		);
		$this->load->view('template', $data);
	}

	public function table_tahun_pelajaran()
	{

		$q = $this->md->getAllTahunPelajaranNotDeleted();
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
		$id = $this->input->post('id');
		$data['nama_tahun_pelajaran'] = $this->input->post('nama_tahun_pelajaran');
		$data['tanggal_mulai'] = $this->input->post('tanggal_mulai');
		$data['tanggal_akhir'] = $this->input->post('tanggal_akhir');
		$data['status_tahun_pelajaran'] = $this->input->post('status_tahun_pelajaran');
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['deleted_at'] = 0;

		if ($data['nama_tahun_pelajaran']) {
			$cek = $this->md->cekTahunPelajaranDuplicate($data['nama_tahun_pelajaran'], $id);
			if ($cek->num_rows() > 0) {
				$ret['status'] = false;
				$ret['message'] = 'Tahun Pelajaran sudah ada';
				$ret['query'] = $this->db->last_query();
			} else {
				if ($id) {
					$q = $this->md->updateTahunPelajaran($id, $data);
					if ($q) {
						$ret['status'] = true;
						$ret['message'] = 'Data berhasil diupdate';
					} else {
						$ret['status'] = false;
						$ret['message'] = 'Data gagal diupdate';
					}
				} else {
					$q = $this->md->saveTahunPelajaran($data);
					if ($q) {
						$ret['status'] = true;
						$ret['message'] = 'Data berhasil disimpan';
					} else {
						$ret['status'] = false;
						$ret['message'] = 'Data gagal disimpan';
					}
				}
			}
		} else {
			$ret['status'] = false;
			$ret['message'] = 'Tahun Pelajaran tidak boleh kosong';
		}


		echo json_encode($ret);
	}

	public function edit()
	{

		$id = $this->input->post('id');
		$q = $this->md->getTahunPelajaranByID($id);
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

	public function delete()
	{
		$id = $this->input->post('id');
		$data['deleted_at'] = time();
		$q = $this->md->updateTahunPelajaran($id, $data);
		if ($q) {
			$ret['status'] = true;
			$ret['message'] = 'Data berhasil dihapus';
		} else {
			$ret['status'] = false;
			$ret['message'] = 'Data gagal dihapus';
		}
		echo json_encode($ret);
	}
}

/* End of file: Tahun_pelajaran.php */