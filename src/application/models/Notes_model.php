<?php
class Note_model extends CI_Model {

    public function get_notes($user_id, $limit, $offset) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('NotesTable', $limit, $offset)->result_array();
    }

    public function count_notes($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('NotesTable');
    }

    public function create($data) {
        return $this->db->insert('NotesTable', $data);
    }

    public function update($id, $user_id, $data) {
        $this->db->where(['id' => $id, 'user_id' => $user_id]);
        return $this->db->update('NotesTable', $data);
    }

    public function delete($id, $user_id) {
        $this->db->where(['id' => $id, 'user_id' => $user_id]);
        return $this->db->delete('NotesTable');
    }
}