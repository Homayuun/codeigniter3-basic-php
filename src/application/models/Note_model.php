<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Note_model extends CI_Model {

    public function get_notes($user_id, $limit = 10, $offset = 0) {
        $query = $this->db
            ->select('id, title, content, created_at')
            ->where('user_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get('NotesTable');
        return $query->result_array();
    }

    public function count_notes($user_id) {
        return (int) $this->db->where('user_id', $user_id)->count_all_results('NotesTable');
    }

    public function create($data) {
        $ok = $this->db->insert('NotesTable', $data);
        return $ok ? $this->db->insert_id() : false;
    }

    public function delete($id, $user_id) {
        return $this->db->where(['id' => $id, 'user_id' => $user_id])->delete('NotesTable');
    }

    public function update($id, $user_id, $data) {
        return $this->db->where(['id' => $id, 'user_id' => $user_id])->update('NotesTable', $data);
    }

    public function get_one($id, $user_id) {
        return $this->db->where(['id' => $id, 'user_id' => $user_id])->get('NotesTable')->row_array();
    }
}
