<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->model('affiliate_model');
		$this->load->model('setting_model');
		$this->load->model('user_model');
		$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = [];
		$data['pageName'] = 'Referral';
		$userId = $this->userInfo['user_id'];
		$data['link_sponsor'] = base_url('auth/register?sponsor='.$userId);
		$data['refs'] = [];

		$refs = $this->affiliate_model->getAll($this->userInfo['user_id']);
		$affBonus = $this->setting_model->getAll();
		foreach ($refs as $ref) {
			$refUser = $this->user_model->getUserDetailByUserId($ref['ref_id']);
			if (!empty($refUser)) {
				$refUser[0]['created'] = $ref['created_at'];
				$refUser[0]['affBonus'] = $affBonus[0]['aff_bonus'];
				$data['refs'][] = $refUser[0];
			}
		}

		$this->layout->view('referral/index', $data);
	}
}
