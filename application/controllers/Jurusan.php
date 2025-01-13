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
        $q = $this->md->getAllJurusan();
        $response = [
            'status' => $q->num_rows() > 0,
            'data' => $q->result(),
            'message' => $q->num_rows() > 0 ? '' : 'Data tidak tersedia',
        ];
        echo json_encode($response);
    }

    public function tambah_jurusan()
    {
        $id_tahun_pelajaran = $this->input->post('id_tahun_pelajaran');
        $nama_jurusan = $this->input->post('nama_jurusan');

        if (empty($id_tahun_pelajaran) || empty($nama_jurusan)) {
            echo json_encode(['status' => false, 'message' => 'Semua field wajib diisi.']);
            return;
        }

        $data = [
            'id_tahun_pelajaran' => $id_tahun_pelajaran,
            'nama_jurusan' => $nama_jurusan,
        ];

        $insert = $this->md->insertJurusan($data);
        echo json_encode([
            'status' => $insert,
            'message' => $insert ? 'Data berhasil ditambahkan' : 'Gagal menambahkan data',
        ]);
    }

    public function edit_jurusan()
    {
        $id = $this->input->post('id');
        $id_tahun_pelajaran = $this->input->post('id_tahun_pelajaran');
        $nama_jurusan = $this->input->post('nama_jurusan');

        if (empty($id) || empty($id_tahun_pelajaran) || empty($nama_jurusan)) {
            echo json_encode(['status' => false, 'message' => 'Semua field wajib diisi.']);
            return;
        }

        $data = [
            'id_tahun_pelajaran' => $id_tahun_pelajaran,
            'nama_jurusan' => $nama_jurusan,
        ];

        $update = $this->md->updateJurusan($id, $data);
        echo json_encode([
            'status' => $update,
            'message' => $update ? 'Data berhasil diperbarui' : 'Gagal memperbarui data',
        ]);
    }

    public function hapus_jurusan($id)
    {
        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $delete = $this->md->deleteJurusan($id);
        echo json_encode([
            'status' => $delete,
            'message' => $delete ? 'Data berhasil dihapus' : 'Gagal menghapus data',
        ]);
    }

    public function detail_jurusan()
    {
        $id = $this->input->post('id');
        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $jurusan = $this->md->getJurusanById($id);
        echo json_encode([
            'status' => (bool)$jurusan,
            'data' => $jurusan,
            'message' => $jurusan ? '' : 'Data tidak ditemukan',
        ]);
    }
}
