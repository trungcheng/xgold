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
		$data = [];
		$data['pageName'] = 'Users';

		$this->layout->view('user/index', $data);
	}

	public function getAll()
	{
		$data = $this->user_model->getAll($this->userInfo['user_id']);
		echo json_encode(['data' => $data]);
	}

	public function update()
	{
		try {
			$postdata = file_get_contents("php://input");
	    	$request = json_decode($postdata);
	    	$data = [
	    		'email' => $request->email,
	    		'address' => $request->address,
	    		'mobile' => $request->mobile,
	    		'is_admin' => ($request->selectedOption == 'Admin') ? true : false
	    	];
	    	$this->user_model->update($data, $request->user_id);
			echo json_encode(['status' => true, 'message' => 'Update user success']);
		} catch (Exception $e) {
			echo json_encode(['status' => true, 'message' => $e->getMessage()]);
		}
	}

}
