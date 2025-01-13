<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterdata_model extends CI_Model
{

	protected $tableTahunPelajaran = 'data_tahun_pelajaran';
	protected $tableKelas = 'data_kelas';
	protected $tableJurusan = 'data_jurusan';

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllTahunPelajaran()
	{
        return $this->db->get($this->tableTahunPelajaran);
    }

    public function insertTahunPelajaran($data)
    {
        return $this->db->insert($this->tableTahunPelajaran, $data);
    }

    public function updateTahunPelajaran($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->tableTahunPelajaran, $data);
    }

    public function deleteTahunPelajaran($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->tableTahunPelajaran);
    }

	public function getAllJurusan() 
	{
		return  $this->db->get($this->tableJurusan);
	}

	public function insertJurusan($data)
	{
		$insert = $this->db->insert($this->tableJurusan, $data);
		log_message('debug', 'Insert Query: ' . $this->db->last_query());
		return $insert;
	}

    public function updateJurusan($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->tableJurusan, $data);
    }

    public function deleteJurusan($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->tableJurusan);
    }

	public function getAllKelas()
    {
        return $this->db->get_where($this->table, ['deleted_at' => null]);
    }

    /**
     * Insert a new row into data_kelas table.
     * @param array $data
     * @return bool
     */
    public function insertKelas($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update a row in data_kelas table.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateKelas($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Soft delete a row in data_kelas table.
     * @param int $id
     * @return bool
     */
    public function deleteKelas($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['deleted_at' => date('Y-m-d H:i:s')]);
    }



	public function getJurusanById($id)
	{
    $this->db->where('id', $id);
    return $this->db->get($this->tableJurusan)->row();
	}

}
