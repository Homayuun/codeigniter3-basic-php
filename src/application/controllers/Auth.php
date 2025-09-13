<?php
class Auth extends CI_Controller {

    public function login() {
        if ($this->input->method() === 'post') {
            $this->load->model('User_model');
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->get_by_username($username);

            if ($user && $user['password'] === $password) { 
                $this->session->set_userdata([
                    'user_id' => $user['id'],
                    'username' => $user['username']
                ]);
                echo "OK";
            } else {
                echo "Invalid username or password";
            }
            return;
        }

        $this->load->view('login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}