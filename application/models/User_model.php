<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'user';

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserByUsername($username)
    {
        $q = $this->db->where('username', $username)->get($this->table);
        
        if ($q->num_rows() > 0) {
            return $q->row(); // Mengembalikan objek user
        } else {
            return null; // Jika tidak ada data ditemukan
        }
    }

    public function getUserAll()
    {
        return $this->db->get($this->table);
    }

    public function getUserByID($id)
    {
        return $this->db->where('id', $id)->get($this->table);
    }

    public function updateUser($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function insertUser($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }
}
