<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_by_username($username) {
        return $this->db->where('username', $username)
                        ->get('UsersTable')
                        ->row_array();
    }

    public function create($data) {
        return $this->db->insert('UsersTable', $data);
    }
}