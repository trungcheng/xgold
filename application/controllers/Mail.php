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
		$setting = $this->setting_model->getAll();
		$registerTemp = json_decode($setting[0]['register_temp']);
		$data['temp'] = $registerTemp;

		$this->layout->view('mail/register', $data);
	}

	public function updateRegister()
	{
		$data = $this->input->post();
		if (!empty($data) && $data['from'] && $data['subject'] && $data['content']) {
			$records = [
				'from' => $data['from'],
				'subject' => $data['subject'],
				'content' => htmlentities($data['content'])
			];
			$this->setting_model->update(['register_temp' => json_encode($records)]);
			$this->session->set_flashdata('success', 'Update success');
			redirect('mail/register');
		} else {
			$this->session->set_flashdata('error', 'Data not enough');
			redirect('mail/register');
		}
	}

	public function reset()
	{
		$data = [];
		$data['pageName'] = 'Reset password template';
		$setting = $this->setting_model->getAll();
		$resetTemp = json_decode($setting[0]['reset_password_temp']);
		$data['temp'] = $resetTemp;

		$this->layout->view('mail/reset', $data);
	}

	public function updateReset()
	{
		$data = $this->input->post();
		if (!empty($data) && $data['from'] && $data['subject'] && $data['content']) {
			$records = [
				'from' => $data['from'],
				'subject' => $data['subject'],
				'content' => htmlentities($data['content'])
			];
			$this->setting_model->update(['reset_password_temp' => json_encode($records)]);
			$this->session->set_flashdata('success', 'Update success');
			redirect('mail/reset');
		} else {
			$this->session->set_flashdata('error', 'Data not enough');
			redirect('mail/reset');
		}
	}

	public function withdraw()
	{
		$data = [];
		$data['pageName'] = 'Withdraw confirm template';
		$setting = $this->setting_model->getAll();
		$withdrawTemp = json_decode($setting[0]['withdraw_confirm_temp']);
		$data['temp'] = $withdrawTemp;

		$this->layout->view('mail/withdraw', $data);
	}

	public function updateWithdraw()
	{
		$data = $this->input->post();
		if (!empty($data) && $data['from'] && $data['subject'] && $data['content']) {
			$records = [
				'from' => $data['from'],
				'subject' => $data['subject'],
				'content' => htmlentities($data['content'])
			];
			$this->setting_model->update(['withdraw_confirm_temp' => json_encode($records)]);
			$this->session->set_flashdata('success', 'Update success');
			redirect('mail/withdraw');
		} else {
			$this->session->set_flashdata('error', 'Data not enough');
			redirect('mail/withdraw');
		}
	}

}
