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
		$this->load->model('usercoin_model');
		$this->load->library('Curl');
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

	public function create()
	{
		try {
			$postdata = file_get_contents("php://input");
		    $request = json_decode($postdata);
			if (!isset($request->email)) {
	    		echo json_encode(['status' => false, 'message' => 'Please input the email address', 'type' => 'error']);
	    	} else {
		    	$userId = 'BGMC'.substr(md5($request->email.time()), 0, 9);
		    	$this->user_model->setUserID($userId);
	            $this->user_model->setEmail($request->email);
	            $this->user_model->setAddress(isset($request->address) ? $request->address : '');
	            $this->user_model->setPassword('12345678');
	            $this->user_model->setMobile(isset($request->mobile) ? $request->mobile : '');
	            $this->user_model->setActive(true);
	            $this->user_model->setAvatar(base_url('assets/v2/images/users/no-avatar.jpg'));
	            $this->user_model->setVerificationCode('1');
	            $this->user_model->setIsAdmin(($request->selectedOption == 'Admin') ? true : false);
		    	$chk = $this->user_model->create();
		    	if ($chk) {
		    		// if ($request->selectedOption !== 'Admin') {
		    		$this->createUserCoin($userId);
		    		// }
					echo json_encode(['status' => true, 'message' => 'Add user success', 'type' => 'success']);
				} else {
					echo json_encode(['status' => false, 'message' => 'This user already existed', 'type' => 'error']);
				}
			}
		} catch (Exception $e) {
			echo json_encode(['status' => false, 'message' => $e->getMessage(), 'type' => 'error']);
		}
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
			echo json_encode(['status' => false, 'message' => $e->getMessage()]);
		}
	}

	public function delete()
	{
		$postdata = file_get_contents("php://input");
	    $request = json_decode($postdata);
	    $user = $this->user_model->getUserDetailByUserId($request->user_id);
	    if (!empty($user)) {
	    	$this->user_model->delete($request->user_id);
	    	echo json_encode(['status' => true, 'message' => 'Delete user success', 'type' => 'success']);
	    } else {
	    	echo json_encode(['status' => false, 'message' => 'User not found', 'type' => 'error']);
	    }
	}

	public function createUserCoin($userId) {
        $token = $this->curl->getToken();
        $cbs = $this->curl->createAddress($token);
        foreach ($cbs as $cb) {
            $coinName = '';
            switch ($cb->currency) {
                case 'btc':
                    $coinName = 'Bitcoin';
                    break;
                case 'eth':
                    $coinName = 'Ethereum';
                    break;
                case 'ltc':
                    $coinName = 'Litecoin';
                    break;
                case 'token':
                    $coinName = 'Bitgame';
                    break;
                default:
                    $coinName = 'Bitcoin Cash';
                    break;
            }
            $data = [
                'user_id' => $userId,
                'coin_addr' => $cb->address,
                'coin_type' => $cb->currency,
                'coin_name' => $coinName,
                'balance' => 0.0
            ];
            $this->usercoin_model->create($data);
        }
    }

}
