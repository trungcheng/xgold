<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->model('user_model');
		$this->load->model('usercoin_model');
		$this->load->model('transaction_model');
		$this->load->model('event_model');
		$this->load->model('setting_model');
		$this->load->model('affiliate_model');
		$this->load->library('Curl');
		$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function btc()
	{
		$data = [];
		$data['pageName'] = 'Bitcoin Wallet';

		$this->layout->view('finance/btc', $data);
	}

	public function eth()
	{
		$data = [];
		$data['pageName'] = 'Ethereum Wallet';

		$this->layout->view('finance/eth', $data);
	}

	public function ltc()
	{
		$data = [];
		$data['pageName'] = 'Litecoin Wallet';

		$this->layout->view('finance/ltc', $data);
	}

	public function bch()
	{
		$data = [];
		$data['pageName'] = 'Bitcoin Cash Wallet';

		$this->layout->view('finance/bch', $data);
	}

	public function submitDeposit()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$keys = ['fromAddr', 'toAddr', 'amount', 'tranId', 'coinType'];
		
		foreach ($request as $key => $value) {
		    if (!in_array($key, $keys) || $value == '') {
		    	$json = [
		    		'status' => false, 
		    		'message' => $key.' is required and not empty',
		    		'type' => 'error'
		    	];
		    	goto a;
		    }
		}

		$bonusEvents = $this->event_model->getSelectedEvents();
		$totalBonus = 0;
		if (!empty($bonusEvents)) {
            foreach ($bonusEvents as $event) {
                $currentDate = new DateTime(date('Y-m-d h:i:s'));
                $fromDate = new DateTime($event['from_date']);
                $toDate = new DateTime($event['to_date']);
                if ($fromDate <= $currentDate && $currentDate <= $toDate) {
                	$totalBonus += intval($event['bonus']);
                }
            }
        }

		$now = new DateTime();
		$time = new \MongoDB\BSON\UTCDateTime($now->getTimestamp() * 1000);
		$data = [
			'user_id' => $this->userInfo['user_id'],
			'from_addr' => $request->fromAddr,
			'to_addr' => $request->toAddr,
			'total' => $request->amount,
			'fee' => 0,
			'subtotal' => 0,
			'coin_type' => $request->coinType,
			'buy_by' => $request->coinType,
			'amount_currency_buy' => $request->amount,
			'bonus' => $totalBonus,
			'status' => 1,
			'trans_fee' => 0,
			'trans_id' => $request->tranId,
			'trans_type' => 2,
			'refund_for_trans' => 0,
			'created_at' => $time
		];
		$this->transaction_model->create($data);

		$json = [
    		'status' => true, 
    		'message' => 'Confirm success',
    		'type' => 'success'
    	];

		a:

		echo json_encode($json);
	}

	public function submitWithdraw()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$keys = ['fromAddr', 'toAddr', 'amount', 'coinType'];
		
		foreach ($request as $key => $value) {
		    if (!in_array($key, $keys) || $value == '') {
		    	$json = [
		    		'status' => false, 
		    		'message' => $key.' is required and not empty',
		    		'type' => 'error'
		    	];
		    	goto a;
		    }
		}

		// $now = new DateTime();
		// $time = new \MongoDB\BSON\UTCDateTime($now->getTimestamp() * 1000);
		// $data = [
		// 	'user_id' => $this->userInfo['user_id'],
		// 	'from_addr' => $request->fromAddr,
		// 	'to_addr' => $request->toAddr,
		// 	'total' => $request->amount,
		// 	'fee' => 0,
		// 	'subtotal' => 0,
		// 	'coin_type' => $request->coinType,
		// 	'buy_by' => $request->coinType,
		// 	'amount_currency_buy' => $request->amount,
		// 	'bonus' => $totalBonus,
		// 	'status' => 1,
		// 	'trans_fee' => 0,
		// 	'trans_id' => $request->tranId,
		// 	'trans_type' => 3,
		// 	'refund_for_trans' => 0,
		// 	'created_at' => $time
		// ];
		// $this->transaction_model->create($data);

		$json = [
    		'status' => false, 
    		'message' => 'This function has been blocked',
    		'type' => 'error'
    	];

		a:

		echo json_encode($json);
	}

	public function job()
    {
        echo "Cronjob started...";

        $transactions = $this->transaction_model->getPendingTransactions();
        if (!empty($transactions)) {
            foreach ($transactions as $tran) {
                if ($tran['trans_id'] !== '') {
                    $token = $this->curl->getToken();
                    $check = $this->curl->checkTransaction($tran['trans_id'], $token);
                    if ($check && $check->code == 200) {
                        $data = [
                            'status' => $check->status,
                            'from_addr' => $check->from,
                            'to_addr' => $check->to,
                            'trans_fee' => $check->fee
                        ];
                        $this->transaction_model->update($tran['trans_id'], $data);
                        if ($check->status == 'success') {
                            if ($tran['trans_type'] == 2 && $check->type == 2) {
                                // deposit
                                $userCoin = $this->usercoin_model->getCoinAddrUser($tran['user_id']);
                                foreach ($userCoin as $item) {
                                    if ($item['coin_type'] === $tran['coin_type'] && $item['coin_type'] === $check->symbol) {

                                        if ($tran['bonus'] == 0) {
                                            $balance = $item['balance'] + $check->amount;
                                        } else {
                                            $balance = $item['balance'] + $check->amount + ($check->amount * $tran['bonus'] / 100);
                                        }
                                        // +coin
                                        $this->usercoin_model->updateBalance($tran['user_id'], $item['coin_type'], $balance);
                                        // +affiliate bonus
                                        $affs = $this->affiliate_model->getAll($tran['user_id']);
                                        if (!empty($affs)) {
                                            foreach ($affs as $aff) {
                                                $bonus = $this->setting_model->getAll();
                                                $userCoin = $this->usercoin_model->getCoinAddrUserToken($aff['ref_id']);
                                                $balanceUpdate = $userCoin[0]['balance'] + (($check->amount) * ($bonus[0]['aff_bonus']) / 100);
                                                $this->usercoin_model->updateBalance($aff['ref_id'], $item['coin_type'], $balanceUpdate);
                                            }
                                        }

                                    }
                                }
                            }
                            if ($tran['trans_type'] == 3 && $check->type == 4) {
                                // withdraw
                            }
                        }
                    }
                }
            }
        }

        echo "Cronjob finished...";
    }

}