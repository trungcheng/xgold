<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('layouts/template');
        // $this->load->model('user_model');
        // $this->load->library('Curl');
    }

	public function index()
	{
		// $result = $this->mongo_db->get('users');
		// var_dump($result);die;
		$this->load->view('pages/dashboard');
	}
}
