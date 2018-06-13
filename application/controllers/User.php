<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->library('form_validation');
		$this->load->model('user_model');
    	$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = $this->user_model->getUserDetailByUserId($this->userInfo['user_id']);
		$userCoin = $this->usercoin_model->getCoinAddrUser($this->userInfo['user_id']);
		$data['coinAddr'] = $userCoin;
		$data['pageName'] = 'Users';

		$this->layout->view('user/index', $data);
	}

}
