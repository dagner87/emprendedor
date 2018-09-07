<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cities_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('usuario')->where('id_usuario', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }

            return null;
        }

        $query = $this->db->select('*')->from('usuario')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }
    /*

    public function save($city)
    {
        $this->db->set($this->_setCity($city))->insert('cities');

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($city)
    {
        $id = $city['id'];

        $this->db->set($this->_setCity($city))->where('id', $id)->update('cities');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('cities');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    private function _setCity($city)
    {
        return array(
            'name' => $city['name']
        );
    }*/
}