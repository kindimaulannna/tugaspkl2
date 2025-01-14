<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurusan extends CI_Controller
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
			'content' => 'backend/jurusanKonten',
			'title' => 'Admin'
		);
		$this->load->view('template', $data);
	}

	public function table_jurusan()
	{
		$q = $this->md->getAllJurusanNotDeleted();
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

	public function option_tahun_pelajaran()
	{
		$q = $this->md->getAllTahunPelajaranNotDeleted();
		$ret = '';
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$ret .= '<option value="' . $row->id . '">' . $row->nama_tahun_pelajaran . '</option>';
			}
		}
		echo $ret;
	}

	public function save()
	{

		$id = $this->input->post('id');
		$id_tahun_pelajaran = $this->input->post('id_tahun_pelajaran');
		$data['nama_jurusan'] = $this->input->post('nama_jurusan');
		$data['id_tahun_pelajaran'] = $this->input->post('id_tahun_pelajaran');
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['deleted_at'] = 0;

		if ($data['nama_jurusan']) {
			$cek = $this->md->cekJurusanDuplicate($data['nama_jurusan'], $id_tahun_pelajaran, $id);
			if ($cek->num_rows() > 0) {
				$ret['status'] = false;
				$ret['message'] = 'Jurusan sudah ada';
			} else {

				if ($id) {
					$q = $this->md->updateJurusan($id, $data);
					if ($q) {
						$ret['status'] = true;
						$ret['message'] = 'Data berhasil diupdate';
					} else {
						$ret['status'] = false;
						$ret['message'] = 'Data gagal diupdate';
					}
				} else {
					$q = $this->md->saveJurusan($data);
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
			$ret['message'] = 'Data gagal disimpan';
		}
		echo json_encode($ret);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$data['deleted_at'] = time();
		$q = $this->md->updateJurusan($id, $data);
		if ($q) {
			$ret['status'] = true;
			$ret['message'] = 'Data berhasil dihapus';
		} else {
			$ret['status'] = false;
			$ret['message'] = 'Data gagal dihapus';
		}
		echo json_encode($ret);
	}
	public function edit()
	{

		$id = $this->input->post('id');
		$q = $this->md->getJurusanByID($id);
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
}

/* End of file: Jurusan.php */