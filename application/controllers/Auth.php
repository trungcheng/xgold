<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('layouts/auth');
        // $this->load->model('user_model');
        // $this->load->library('Curl');
    }

	public function login()
	{
		$this->load->view('login');
	}

	public function register()
	{
		$this->load->view('register');
	}

	public function post_login()
    {
        // $this->load->model('user', '', true);
        // if ($this->user->authenticate($this->input->post('username'), $this->input->post('password')))
        // {
        //     $this->session->set_userdata('loggedin', true);
        //     header('Location: /');
        // }
        // else
        // {
        //     header('Location: /auth/login');
        // }
    }

    public function post_register()
    {

    }

    public function logout()
    {
        // $this->session->unset_userdata('loggedin');
        header('Location: /');
    }
}
