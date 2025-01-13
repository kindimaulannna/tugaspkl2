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
            'title' => 'Kelas',
        );
        $this->load->view('template', $data);
    }

    public function table_kelas()
    {
        $q = $this->md->getAllKelas();
        if ($q->num_rows() > 0) {
            $ret['status'] = true;
            $ret['data'] = $q->result();
        } else {
            $ret['status'] = false;
            $ret['message'] = 'Data tidak tersedia';
        }
        echo json_encode($ret);
    }

    public function tambah_kelas()
    {
        $data = [
            'id_tahun_pelajaran' => $this->input->post('id_tahun_pelajaran'),
            'id_jurusan' => $this->input->post('id_jurusan'),
            'nama_kelas' => $this->input->post('nama_kelas'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $insert = $this->md->insertKelas($data);
        echo json_encode(['status' => $insert, 'message' => $insert ? 'Data berhasil ditambahkan' : 'Gagal menambahkan data']);
    }

    public function edit_kelas()
    {
        $id = $this->input->post('id');
        $data = [
            'id_tahun_pelajaran' => $this->input->post('id_tahun_pelajaran'),
            'id_jurusan' => $this->input->post('id_jurusan'),
            'nama_kelas' => $this->input->post('nama_kelas'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $update = $this->md->updateKelas($id, $data);
        echo json_encode(['status' => $update, 'message' => $update ? 'Data berhasil diperbarui' : 'Gagal memperbarui data']);
    }

    public function hapus_kelas($id)
    {
        $delete = $this->md->deleteKelas($id);
        echo json_encode(['status' => $delete, 'message' => $delete ? 'Data berhasil dihapus' : 'Gagal menghapus data']);
    }
}
