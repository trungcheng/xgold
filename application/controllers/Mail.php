<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->model('setting_model');
		$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function register()
	{
		$data = [];
		$data['pageName'] = 'Register template';
		$data['setting'] = $this->setting_model->getAll();

		$this->layout->view('mail/register', $data);
	}

	public function updateRegister()
	{
		$data = $this->input->post();
		// var_dump($data);die;
		var_dump(htmlentities($data['content']));die;
		if (!empty($data)) {
			$records = [
				'from' => $data['from'],
				'subject' => $data['subject'],
				'content' => htmlentities($data['content'])
			];
			$this->setting_model->update(['register_template' => json_encode($records)]);
			$this->session->set_flashdata('success', 'Update success');
			redirect('mail/register');
		}
	}

	public function reset()
	{
		$data = [];
		$data['pageName'] = 'Reset password template';
		$data['setting'] = $this->setting_model->getAll();

		$this->layout->view('mail/reset', $data);
	}

	public function updateReset()
	{
		$data = $this->input->post();
		if (!empty($data)) {
			$records = [
				'from' => $data['from'],
				'subject' => $data['subject'],
				'content' => htmlentities($data['content'])
			];
			$this->setting_model->update(['reset_password_template' => json_encode($records)]);
			$this->session->set_flashdata('success', 'Update success');
			redirect('mail/reset');
		}
	}

	public function withdraw()
	{
		$data = [];
		$data['pageName'] = 'Withdraw confirm template';
		$data['setting'] = $this->setting_model->getAll();

		$this->layout->view('mail/withdraw', $data);
	}

	public function updateWithdraw()
	{
		$data = $this->input->post();
		if (!empty($data)) {
			$records = [
				'from' => $data['from'],
				'subject' => $data['subject'],
				'content' => htmlentities($data['content'])
			];
			$this->setting_model->update(['withdraw_confirm_template' => json_encode($records)]);
			$this->session->set_flashdata('success', 'Update success');
			redirect('mail/withdraw');
		}
	}

}
