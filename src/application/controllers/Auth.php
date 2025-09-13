<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input   $input
 * @property User_model $User_model
 */
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            redirect('notes');
        }
        $this->load->view('login');
    }

    public function login() {
        $username = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));

        if (!$username || !$password) {
            $this->session->set_flashdata('error', 'Username and password are required.');
            redirect('auth');
            return;
        }

        $user = $this->User_model->get_by_username($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'User not found.');
            redirect('auth');
            return;
        }

        if ($user['password'] === $password) {
            $this->session->set_userdata([
                'user_id'  => $user['id'],
                'username' => $user['username']
            ]);
            redirect('notes');
            return;
        } else {
            $this->session->set_flashdata('error', 'Incorrect password.');
            redirect('auth');
            return;
        }
    }

    public function ajax_login() {
        if ($this->input->method() !== 'post') {
            show_error('Invalid method', 405);
        }

        $username = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));

        if (!$username || !$password) {
            exit("Username and password are required.");
        }

        $user = $this->User_model->get_by_username($username);

        if ($user && $user['password'] === $password) {
            $this->session->set_userdata([
                'user_id'  => $user['id'],
                'username' => $user['username']
            ]);
            exit("OK");
        }

        exit("Invalid username or password.");
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}