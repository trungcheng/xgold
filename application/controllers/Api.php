<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once("application/libraries/REST_Controller.php");

class Api extends REST_Controller
{
    public $userInfo;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');
        $this->load->model('event_model');
        $this->load->model('user_model');
        $this->load->model('transaction_model');
        $this->load->model('usercoin_model');
        $this->load->model('affiliate_model');
        $this->load->library('Curl');
        $this->userInfo = $this->session->userdata('ci_seesion_key');
    }

    public function getAllSetting_get()
    {
        $setting = $this->setting_model->getCoinRate();
        $this->set_response([
            'status' => true,
            'data' => $setting
        ], REST_Controller::HTTP_OK);
    }

    public function getEventBonus_get()
    {
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

        $this->set_response([
            'status' => true,
            'bonus' => $totalBonus
        ], REST_Controller::HTTP_OK);
    }

    public function getCoinsWithoutToken_get()
    {
        $coins = $this->usercoin_model->getCoinAddrUserWithoutToken($this->userInfo['user_id']);

        $this->set_response([
            'status' => true,
            'data' => $coins
        ], REST_Controller::HTTP_OK);
    }

    public function getTokenTransaction_get()
    {
        $transactions = $this->transaction_model->getTokenTransactions($this->userInfo['user_id']);
        $data = [];

        foreach ($transactions as $tran) {
            $mongoDate = new \MongoDB\BSON\UTCDateTime($tran['created_at']['$date']);
            $tran['time'] = $mongoDate->toDateTime()->modify('+7 hour')->format('Y-m-d H:i:s');
            $data[] = $tran;
        }

        $this->set_response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function getTransactions_get()
    {
        $type = $this->input->get('coinType');
        $transactions = $this->transaction_model->getTransactions($this->userInfo['user_id'], $type);
        $data = [];

        foreach ($transactions as $tran) {
            $mongoDate = new \MongoDB\BSON\UTCDateTime($tran['created_at']['$date']);
            $tran['time'] = $mongoDate->toDateTime()->modify('+7 hour')->format('Y-m-d H:i:s');
            $data[] = $tran;
        }

        $this->set_response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function getRefs_get()
    {
        $data = [];
        $refs = $this->affiliate_model->getAll($this->userInfo['user_id']);
        $affBonus = $this->setting_model->getAll();
        foreach ($refs as $ref) {
            $refUser = $this->user_model->getUserDetailByUserId($ref['ref_id']);
            if (!empty($refUser)) {
                $refUser[0]['created'] = $ref['created_at'];
                $refUser[0]['affBonus'] = $affBonus[0]['aff_bonus'];
                $data[] = $refUser[0];
            }
        }

        $this->set_response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function getRefTransaction_get($userId)
    {
        $transactions = $this->transaction_model->getTokenTransactions($userId);
        $data = [];

        foreach ($transactions as $tran) {
            $mongoDate = new \MongoDB\BSON\UTCDateTime($tran['created_at']['$date']);
            $tran['time'] = $mongoDate->toDateTime()->modify('+7 hour')->format('Y-m-d H:i:s');
            $data[] = $tran;
        }

        $this->set_response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function getCoinAddr_get()
    {
        $coinName = $this->input->get('name');
        $userCoin = $this->usercoin_model->getCoinAddrByUserAndName($this->userInfo['user_id'], $coinName);

        $this->set_response([
            'status' => true,
            'data' => (!empty($userCoin)) ? $userCoin[0] : []
        ], REST_Controller::HTTP_OK);
    }

    public function confirm_get()
    {
        if (!empty($this->input->get('wCode')) && !empty($this->input->get('wid'))) {
            $userId = $this->input->get('wid');
            $wCode = urldecode(base64_decode($this->input->get('wCode')));
            $result = $this->user_model->confirm($userId, $wCode);
            if ($result['status']) {
                $data = [
                    'currency' => $this->input->get('currency'),
                    'from' => $this->input->get('from'),
                    'to' => $this->input->get('to'),
                    'amount' => $this->input->get('amount'),
                    'note' => $this->input->get('note')
                ];

                foreach ($data as $item) {
                    if (!$item || $item == '' || $item == null) {
                        $this->set_response([
                            'status' => false,
                            'message' => 'Confirm failed, data invalid'
                        ], REST_Controller::HTTP_OK); 
                    }
                }

                $token = $this->curl->getToken();
                $send = $this->curl->send($token, $data);
                if ($send->code == 200 && $send->is_success) {
                    $now = new DateTime();
                    $time = new \MongoDB\BSON\UTCDateTime($now->getTimestamp() * 1000);
                    $data = [
                        'user_id' => $userId,
                        'from_addr' => $data['from'],
                        'to_addr' => $data['to'],
                        'total' => $data['amount'],
                        'fee' => 0,
                        'subtotal' => 0,
                        'coin_type' => $data['currency'],
                        'buy_by' => $data['currency'],
                        'amount_currency_buy' => $data['amount'],
                        'bonus' => 0,
                        'status' => 1,
                        'trans_fee' => 0,
                        'trans_id' => $send->trans_id,
                        'trans_type' => 3,
                        'refund_for_trans' => 0,
                        'created_at' => $time
                    ];
                    $this->transaction_model->create($data);

                    $this->set_response([
                        'status' => true,
                        'message' => 'Confirm success, back to system to check history'
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->set_response([
                        'status' => false,
                        'message' => $send->msg
                    ], REST_Controller::HTTP_OK);    
                }
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => 'Confirm failed, user not found, back to system to withdraw again'
                ], REST_Controller::HTTP_OK);
            }
        } else {
            $this->set_response([
                'status' => false,
                'message' => 'Confirm failed, no data provided, back to system to withdraw again'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function updateCoinAddr_get() 
    {
        try {
            $userId = $this->input->get('uid');
            $token = $this->curl->getToken();
            $cbs = $this->curl->createAddress($token);
            $this->usercoin_model->delete($userId);
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
                    'balance' => 10.0
                ];
                $this->usercoin_model->create($data);
            }

            $this->set_response([
                'status' => true,
                'message' => 'Update success'
            ], REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response([
                'status' => false,
                'message' => $e->getMessage()
            ], REST_Controller::HTTP_OK);
        }
    }

}
