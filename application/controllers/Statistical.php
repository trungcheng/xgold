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
		$data = [];

		foreach ($transactions as $tran) {
            // $mongoDate = new \MongoDB\BSON\UTCDateTime($tran['created_at']['$date']);
            $tran['_id']['time'] = date('Y-m-d H:i:s', strtotime($tran['_id']['time'] . "+7 hours"));
            $data[] = $tran;
        }

		echo json_encode(['data' => $data]);die;
	}

}