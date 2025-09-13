<?php
class User_model extends CI_Model {

    public function get_by_username($username) {
        return $this->db->get_where('UsersTable', ['username' => $username])->row_array();
    }
}