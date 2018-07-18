<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ico extends MY_Controller {

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
		$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = [];
		$data['pageName'] = 'Ico';

		$this->layout->view('ico/index', $data);
	}

	public function buy()
	{
		try {
			$postdata = file_get_contents("php://input");
		    $request = json_decode($postdata);
		    if ($request && $request->amount !== 0) {
		    	$userCoins = $this->usercoin_model->getCoinAddrUser($this->userInfo['user_id']);
		    	$flag = false;
		    	$item = [];
		    	foreach ($userCoins as $coin) {
		    		if ($coin['coin_type'] == strtolower($request->currency) && $coin['coin_addr'] == $request->fromAddress) {
		    			$flag = true;
		    			$item = $coin;
		    		}
		    	}
		    	if ($flag) {
		    		if ($item['balance'] >= $request->value) {
	    				$item['balance'] = $item['balance'] - $request->value;
	    				// +-coin
	    				$this->usercoin_model->updateBalance($this->userInfo['user_id'], $item['coin_type'], $item['balance']);
						$userToken = $this->usercoin_model->getCoinAddrUserToken($this->userInfo['user_id']);
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
				        if ($totalBonus == 0) {
				        	$tokenBalance = $userToken[0]['balance'] + $request->amount;
				        } else {
				        	$tokenBalance = $userToken[0]['balance'] + $request->amount + ($request->amount * $totalBonus / 100);
				        }
	    				// +token
	    				$this->usercoin_model->updateBalance($this->userInfo['user_id'], 'token', $tokenBalance);
	    				// add transaction
	    				$now = new DateTime();
	    				$time = new \MongoDB\BSON\UTCDateTime($now->getTimestamp() * 1000);
	    				$data = [
	    					'user_id' => $this->userInfo['user_id'],
	    					'from_addr' => $request->fromAddress,
	    					'to_addr' => '',
	    					'total' => $request->amount,
	    					'fee' => 0,
	    					'subtotal' => 0,
	    					'coin_type' => 'token',
	    					'buy_by' => $item['coin_type'],
	    					'amount_currency_buy' => $request->value,
	    					'bonus' => $totalBonus,
	    					'status' => 1,
	    					'trans_fee' => 0,
	    					'trans_id' => '',
	    					'trans_type' => 1,
	    					'refund_for_trans' => 0,
	    					'created_at' => $time
	    				];
	    				$this->transaction_model->create($data);
	    				// +affiliate bonus
	    				$affs = $this->affiliate_model->getAll($this->userInfo['user_id']);
	    				if (!empty($affs)) {
	    					foreach ($affs as $aff) {
	    						$bonus = $this->setting_model->getAll();
	    						$userCoin = $this->usercoin_model->getCoinAddrUserToken($aff['ref_id']);
	    						$balanceUpdate = $userCoin[0]['balance'] + (($request->amount) * ($bonus[0]['aff_bonus']) / 100);
	    						$this->usercoin_model->updateBalance($aff['ref_id'], 'token', $balanceUpdate);
	    					}
	    				}
	    				$response = [
	    					'status' => true,
	    					'data' => $tokenBalance,
	    					'message' => 'Buy token has been processed'
	    				];
	    			} else {
	    				$response = [
	    					'status' => false, 
	    					'message' => 'Your '.$item['coin_name'].' balance is not enough to buy'
	    				];
	    			}
		    	} else {
	    			$response = [
	    				'status' => false, 
	    				'message' => 'Please input currency address to buy token'
	    			];
	    		}
		    } else {
		    	$response = [
		    		'status' => false, 
		    		'message' => 'Please input token number'
		    	];
			}

			echo json_encode($response);
		} catch (Exception $e) {
			echo json_encode(['status' => false, 'message' => $e->getMessage()]);
		}
	}

}