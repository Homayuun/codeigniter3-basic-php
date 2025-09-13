<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input   $input
 * @property CI_Output  $output
 * @property Note_model $Note_model
 */

class Notes extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Note_model');

        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    function index()
    {
        $this->load->view('notes');
    }


    function load_notes()
    {
        $this->output->set_content_type('application/json');

        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $page    = max(1, (int) $this->input->get('page'));
        $perPage = max(1, (int) $this->input->get('perPage', true) ?: 5);
        $offset  = ($page - 1) * $perPage;

        $notes = $this->Note_model->get_notes($user_id, $perPage, $offset);
        $total = $this->Note_model->count_notes($user_id);

        echo json_encode([
            'data'    => $notes,
            'total'   => $total,
            'page'    => $page,
            'perPage' => $perPage,
        ]);
    }

    function create()
    {
        $this->output->set_content_type('application/json');
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $title   = $this->input->post('title', true);
        $content = $this->input->post('content', true);

        if (!$title || !$content) {
            echo json_encode(['success' => false, 'message' => 'Title and content are required']);
            return;
        }

        $data = [
            'title'      => $title,
            'content'    => $content,
            'user_id'    => $user_id,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $id = $this->Note_model->create($data);
        if ($id) {
            $data['id'] = $id;
            echo json_encode(['success' => true, 'note' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Insert failed']);
        }
    }

    function delete($id = null)
    {
        $this->output->set_content_type('application/json');
        $id = $id ?? (int) $this->input->post('id') ?: (int) $this->input->get('id');
        $user_id = $this->session->userdata('user_id');

        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid id']);
            return;
        }

        $ok = $this->Note_model->delete($id, $user_id);
        echo json_encode(['success' => (bool) $ok]);
    }

    function edit($id = null)
    {
        $this->output->set_content_type('application/json');
        $id = $id ?? (int) $this->input->get('id');
        $user_id = $this->session->userdata('user_id');

        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid id']);
            return;
        }

        if ($this->input->method() === 'post') {
            $title   = $this->input->post('title', true);
            $content = $this->input->post('content', true);
            if (!$title || !$content) {
                echo json_encode(['success' => false, 'message' => 'Title and content are required']);
                return;
            }

            $ok = $this->Note_model->update($id, $user_id, [
                'title'   => $title,
                'content' => $content,
            ]);

            echo json_encode(['success' => (bool) $ok]);
            return;
        }

        $note = $this->Note_model->get_one($id, $user_id);
        if (!$note) {
            echo json_encode(['success' => false, 'message' => 'Note not found']);
            return;
        }

        echo json_encode(['success' => true, 'note' => $note]);
    }
}
