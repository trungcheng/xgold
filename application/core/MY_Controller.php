<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('user_model');
        // Check that the user is logged in
        // $this->session->set_userdata('uid', 1);
        if ($this->session->userdata('uid') == null || $this->session->userdata('uid') < 1) {
            // Prevent infinite loop by checking that this isn't the login controller
            redirect('http://coin.xyz/auth/login');
        }
    }
}
