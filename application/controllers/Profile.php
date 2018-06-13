<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$this->load->model('usercoin_model');
    	$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = $this->user_model->getUserDetailByUserId($this->userInfo['user_id']);
		$userCoin = $this->usercoin_model->getCoinAddrUser($this->userInfo['user_id']);
		$data['coinAddr'] = $userCoin;
		$data['pageName'] = 'Profile';

		$this->layout->view('profile/index', $data);
	}

	public function password()
	{
		$data = $this->user_model->getUserDetailByUserId($this->userInfo['user_id']);
		$data['pageName'] = 'Change password';

		$this->layout->view('profile/password', $data);
	}

	public function updateInfo()
	{
		try {
			$dataProfile = $this->input->post('Profile');
			$dataCoin = $this->input->post('Coin');
			// var_dump($dataCoin);die;
			if (!empty($dataProfile) && !empty($dataCoin)) {
				$this->user_model->update($dataProfile, $this->userInfo['user_id']);
				foreach ($dataCoin as $type => $addr) {
					$this->usercoin_model->update($this->userInfo['user_id'], $type, $addr);
				}
				$this->session->set_flashdata('success', 'Update info success');
			} else {
				$this->session->set_flashdata('error', 'No data provided');
			}
            redirect('profile');
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}
	}

	public function changePassword()
	{
		try {
			$this->form_validation->set_rules('Password[oldpass]', 'Old Password', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('Password[newpass]', 'New Password', 'trim|required|min_length[8]');
	        $this->form_validation->set_rules('Password[confirmnewpass]', 'New Password Confirmation', 'trim|required|matches[Password[newpass]]');
	        if ($this->form_validation->run() == FALSE) {
	            $this->password();
	        } else {
				$data = $this->input->post('Password');
				$user = $this->user_model->getUserDetailByUserId($this->userInfo['user_id']);
				if ($this->user_model->verifyHash($data['oldpass'], $user['password'])) {
					$this->user_model->update(
						['password' => $this->user_model->hash($data['newpass'])], 
						$this->userInfo['user_id']
					);
					$this->session->set_flashdata('success', 'Change password success');
				} else {
					$this->session->set_flashdata('error', 'Old password wrong');
				}
	            redirect('profile/password');
	        }
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}
	}
}
