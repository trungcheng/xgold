<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->model('setting_model');
		$this->load->model('user_model');
		$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = [];
		$data['pageName'] = 'Setting';
		$data['setting'] = $this->setting_model->getAll();

		$this->layout->view('setting/index', $data);
	}

	public function update()
	{
		$data = $this->input->post('Setting');
		if (!empty($data)) {
			$this->setting_model->update($data);
			$this->session->set_flashdata('success', 'Update success');
			redirect('setting/index');
		}
	}

}
