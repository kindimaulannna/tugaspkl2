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
        $q = $this->md->getAllTahunPelajaran();
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

    public function tambah_tahun_pelajaran()
    {
        $data = array(
            'nama_tahun_pelajaran' => $this->input->post('nama_tahun_pelajaran'),
            'tanggal_mulai' => $this->input->post('tanggal_mulai'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'status_tahun_pelajaran' => $this->input->post('status_tahun_pelajaran'),
        );

        $insert = $this->md->insertTahunPelajaran($data);
        if ($insert) {
            $response = ['status' => true, 'message' => 'Data berhasil ditambahkan'];
        } else {
            $response = ['status' => false, 'message' => 'Gagal menambahkan data'];
        }

        echo json_encode($response);
    }

    public function edit_tahun_pelajaran()
    {
        $id = $this->input->post('id');
        $data = array(
            'nama_tahun_pelajaran' => $this->input->post('nama_tahun_pelajaran'),
            'tanggal_mulai' => $this->input->post('tanggal_mulai'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'status_tahun_pelajaran' => $this->input->post('status_tahun_pelajaran'),
        );

        $update = $this->md->updateTahunPelajaran($id, $data);
        if ($update) {
            $response = ['status' => true, 'message' => 'Data berhasil diperbarui'];
        } else {
            $response = ['status' => false, 'message' => 'Gagal memperbarui data'];
        }

        echo json_encode($response);
    }

    public function hapus_tahun_pelajaran($id)
    {
        $delete = $this->md->deleteTahunPelajaran($id);
        if ($delete) {
            $response = ['status' => true, 'message' => 'Data berhasil dihapus'];
        } else {
            $response = ['status' => false, 'message' => 'Gagal menghapus data'];
        }

        echo json_encode($response);
    }
}
