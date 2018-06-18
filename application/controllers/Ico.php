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
		$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = [];
		$data['pageName'] = 'Ico';

		$this->layout->view('ico/index', $data);
	}

	public function getTransaction()
	{
		$transactions = $this->transaction_model->getTokenTransactions($this->userInfo['user_id']);
		echo json_encode(['data' => $transactions]);
	}

	public function buy()
	{
		try {
			$postdata = file_get_contents("php://input");
		    $request = json_decode($postdata);
		    if ($request && $request->amount !== 0) {
		    	
		    	$userCoin = $this->usercoin_model->getCoinAddrUser($this->userInfo['user_id']);
		    	
		    	foreach ($userCoin as $item) {
		    		if ($item['coin_type'] === strtolower($request->currency) && $item['coin_addr'] === $request->fromAddress) {
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
					        if ($request->amount * $totalBonus === $request->bonusTotal) {
								$tokenBalance = $userToken[0]['balance'] + $request->amount + $request->bonusTotal;
		    				} else {
		    					$tokenBalance = $userToken[0]['balance'] + $request->amount;
		    				}
		    				// +token
		    				$this->usercoin_model->updateBalance($this->userInfo['user_id'], 'token', $tokenBalance);
		    				// add transaction
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
		    					'created_at' => date('Y-m-d h:i:s')
		    				];
		    				$this->transaction_model->create($data);

		    				// check affiliate bonus
		    				

		    				echo json_encode(['status' => true, 'message' => 'Buy token has been processed']);
		    			} else {
		    				echo json_encode(['status' => false, 'message' => 'Your '.$item['coin_name'].' balance is not enough to buy']);
		    			}
		    		}
		    	}
		    } else {
		    	echo json_encode(['status' => false, 'message' => 'Please input token number']);
			}
		} catch (Exception $e) {
			echo json_encode(['status' => false, 'message' => $e->getMessage()]);
		}
	}

}