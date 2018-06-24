<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->model('usercoin_model');
		$this->load->model('transaction_model');
		$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = [];
		$dataTrans = [];
		$data['pageName'] = 'Dashboard';
		$walletTotal = $this->usercoin_model->getCoinAddrUser($this->userInfo['user_id']);
		foreach ($walletTotal as $key => $item) {
			if ($item['coin_type'] == 'token') unset($walletTotal[$key]);
		}
		$transactions = $this->transaction_model->getUserPendingTransactions($this->userInfo['user_id']);
		foreach ($transactions as $tran) {
            $mongoDate = new \MongoDB\BSON\UTCDateTime($tran['created_at']['$date']);
            $tran['time'] = $mongoDate->toDateTime()->modify('+7 hour')->format('Y-m-d H:i:s');
            $dataTrans[] = $tran;
        }
		$data['wallets'] = $walletTotal;
		$data['transactions'] = $dataTrans;

		$this->layout->view('dashboard/index', $data);
	}
}
