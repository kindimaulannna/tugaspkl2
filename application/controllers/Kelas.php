<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends CI_Controller
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
			'content' => 'backend/kelasKonten',
			'title' => 'Admin'
		);
		$this->load->view('template', $data);
	}

	public function option_tahun_pelajaran()
	{
		$q = $this->md->getAllTahunPelajaranNotDeleted();
		$ret = '<option value="">Pilih Tahun Pelajaran</option>';
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$ret .= '<option value="' . $row->id . '">' . $row->nama_tahun_pelajaran . '</option>';
			}
		}
		echo $ret;
	}

	public function option_jurusan($id)
	{

		$q = $this->md->getJurusanByTahunPelajaranID($id);
		$ret = '<option value="">Pilih Jurusan</option>';
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$ret .= '<option value="' . $row->id . '">' . $row->nama_jurusan . '</option>';
			}
		}
		echo $ret;
	}

	public function table_kelas()
	{
		$q = $this->md->getAllKelasNotDeleted();
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
		$id_tahun_pelajaran = $this->input->post('id_tahun_pelajaran');
		$data['nama_kelas'] = $this->input->post('nama_kelas');
		$data['id_jurusan'] = $this->input->post('id_jurusan');
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['deleted_at'] = 0;

		if ($data['nama_kelas']) {
			$cek = $this->md->cekKelasDuplicate($data['nama_kelas'], $data['id_jurusan'], $id);
			if ($cek->num_rows() > 0) {
				$ret['status'] = false;
				$ret['message'] = 'Kelas sudah ada';
			} else {
				if ($id) {
					$this->md->updateKelas($id, $data);
					$ret['status'] = true;
					$ret['message'] = 'Data berhasil diupdate';
				} else {
					$this->md->saveKelas($data);
					$ret['status'] = true;
					$ret['message'] = 'Data berhasil disimpan';
				}
			}
		} else {
			$ret['status'] = false;
			$ret['message'] = 'Data tidak boleh kosong';
		}

		echo json_encode($ret);
	}

	public function edit()
	{
		$id = $this->input->post('id');
		$q = $this->md->getKelasByID($id);
		if ($q->num_rows() > 0) {
			$ret['status'] = true;
			$ret['data'] = $q->row();
			$ret['message'] = '';
			$ret['query'] = $this->db->last_query();
		} else {
			$ret['status'] = false;
			$ret['data'] = [];
			$ret['message'] = 'Data tidak tersedia';
		}
		echo json_encode($ret);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$data['deleted_at'] = time();
		$q = $this->md->updateKelas($id, $data);
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

/* End of file: Kelas.php */