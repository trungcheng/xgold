<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistical extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->model('user_model');
		$this->load->model('transaction_model');
		$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = [];
		$data['pageName'] = 'Statistical';

		$this->layout->view('statistical/index', $data);
	}

	public function countDataByDateRange()
	{
		$transactions = $this->transaction_model->countToken();
		var_dump($transactions);die;
	}

}