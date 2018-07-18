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
		$this->load->model('affiliate_model');
		$this->load->model('usercoin_model');
    	$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{

		$data = $this->user_model->getUserDetailByUserId($this->userInfo['user_id']);
		$sponsor = $this->affiliate_model->getAll($this->userInfo['user_id']);
		if (!empty($sponsor)) {
			$data[0]['sponsor'] = $sponsor[0]['ref_id'];
		}
		$data[0]['pageName'] = 'Profile';

		$this->layout->view('profile/index', $data[0]);
	}

	public function password()
	{
		$data = $this->user_model->getUserDetailByUserId($this->userInfo['user_id']);
		$data[0]['pageName'] = 'Change password';

		$this->layout->view('profile/password', $data[0]);
	}

	public function updateInfo()
	{
		try {
			$dataProfile = $this->input->post('Profile');
			// $dataCoin = $this->input->post('Coin');
			// var_dump($dataCoin);die;
			if (!empty($dataProfile)) {
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
				if ($this->user_model->verifyHash($data['oldpass'], $user[0]['password'])) {
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

	public function uploadAvatar()
	{
		$response = [
			'image' => '',
			'status' => false,
			'message' => 'Upload failed'
		];

		if (!empty($_FILES['image'])) {
            if ($_FILES['image']['name'] !== '') {
                $config['upload_path'] = 'assets/images/uploads';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '2048';
                $config['file_name'] = time().'-'.$_FILES['image']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('image')) {
                    $response['message'] =  $this->upload->display_errors();
                } else {
                    $uploadData = $this->upload->data();
                    $imageUrl = base_url('/assets/images/uploads/'.$uploadData['file_name']);
                    $this->user_model->update(['avatar' => $imageUrl], $this->userInfo['user_id']);
                    $response['image'] = $imageUrl;
                	$response['status'] = true;
                	$response['message'] = 'Upload success';
                }
            }
        }

        echo json_encode($response);
	}
}
