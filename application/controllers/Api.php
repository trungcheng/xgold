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

    public function depositCallBack_post()
    {
        $type = 'Transaction of';
        $postdata1 = file_get_contents("php://input");
        $postdata2 = $this->input->post();
        $data1 = json_decode($postdata1);
        $data2 = json_decode(json_encode($postdata2), FALSE);
        if (isset($data1->code) && !isset($data2->code)) {
            $data = $data1;
        } else {
            $data = $data2;
        }

        if (isset($data->code) && isset($data->amount) && isset($data->currency)) {
            if (isset($data->trx)) {
                // withdraw
                $type = 'Withdraw';
                $setting = $this->setting_model->getWithdrawFee();
                if (intval($setting[0]['withdraw_fee']) !== 0) {
                    $withDrawFee = ($data->amount * ($setting[0]['withdraw_fee'])) / 100;
                } else {
                    $withDrawFee = 0;
                }
                $transaction = $this->transaction_model->getPendingTransactionByTranId($data->trx);
                if (!empty($transaction)) {
                    $user = $this->usercoin_model->getCoinAddrByAddressAndType($data->from, $data->currency);
                    if ($data->status == 'success') {
                        // update transaction to success
                        $this->transaction_model->update($data->trx, [
                            'status' => 2
                        ]);

                        return $this->set_response([
                            'status' => true,
                            'message' => $type.' '.$data->currency.' success'
                        ], REST_Controller::HTTP_OK);
                    } else {
                        // update transaction to failed
                        $balance = ($user[0]['balance']) + ($data->amount) + $withDrawFee;
                        $this->usercoin_model->updateBalance($user[0]['user_id'], $user[0]['coin_type'], $balance);
                        $this->transaction_model->update($data->trx, [
                            'status' => 3
                        ]);

                        return $this->set_response([
                            'status' => true,
                            'message' => $type.' '.$data->currency.' failed'
                        ], REST_Controller::HTTP_OK);
                    }
                }
            } else {
                // deposit
                $type = 'Deposit';
                $user = $this->usercoin_model->getCoinAddrByAddressAndType($data->address, $data->currency);
                if (!empty($user)) {
                    // $bonusEvents = $this->event_model->getSelectedEvents();
                    // $totalBonus = 0;
                    // if (!empty($bonusEvents)) {
                    //     foreach ($bonusEvents as $event) {
                    //         $currentDate = new DateTime(date('Y-m-d h:i:s'));
                    //         $fromDate = new DateTime($event['from_date']);
                    //         $toDate = new DateTime($event['to_date']);
                    //         if ($fromDate <= $currentDate && $currentDate <= $toDate) {
                    //             $totalBonus += intval($event['bonus']);
                    //         }
                    //     }
                    // }

                    $now = new DateTime();
                    $time = new \MongoDB\BSON\UTCDateTime($now->getTimestamp() * 1000);
                    $dataTran = [
                        'user_id' => $user[0]['user_id'],
                        'from_addr' => '',
                        'to_addr' => $data->address,
                        'total' => $data->amount,
                        'fee' => 0,
                        'subtotal' => 0,
                        'coin_type' => $data->currency,
                        'buy_by' => $data->currency,
                        'amount_currency_buy' => $data->amount,
                        'bonus' => 0,
                        'status' => 2,
                        'trans_fee' => 0,
                        'trans_id' => '',
                        'trans_type' => 2,
                        'refund_for_trans' => 0,
                        'created_at' => $time
                    ];
                    $this->transaction_model->create($dataTran);

                    $balance = $user[0]['balance'] + $data->amount;
                    $this->usercoin_model->updateBalance($user[0]['user_id'], $data->currency, $balance);
                    
                    return $this->set_response([
                        'status' => true,
                        'message' => $type.' '.$data->currency.' success'
                    ], REST_Controller::HTTP_OK);
                }
            }
        }

        return $this->set_response([
            'status' => false,
            'message' => $type.' '.$data->currency.' failed'
        ], REST_Controller::HTTP_OK);
    }

    public function confirm_get()
    {
        if (!empty($this->input->get('wCode')) && !empty($this->input->get('wid'))) {
            $userId = $this->input->get('wid');
            $wCode = utf8_decode(base64_decode($this->input->get('wCode')));
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

                if ($data['currency'] !== 'token') {
                    $token = $this->curl->getToken();
                    $send = $this->curl->sendV1($token, $data);
                } else {
                    $setting = $this->setting_model->getAll();
                    $url = $setting[0]['link_api'];
                    $dataToken = [
                        'to_input' => $data['to'],
                        'value_input' => $data['amount'],
                        'from_input' => $setting[0]['from_addr'],
                        'contract_input' => $setting[0]['contract_addr'],
                        'gas_input' => '100000',
                        'API_KEY' => '1',
                        'password' => '12345678' 
                    ];
                    $send = $this->curl->sendV2($url, $dataToken);
                    $send->code = 200;
                    $send->is_success = $send->success;
                    $send->msg = 'Withdraw token failed';
                }
                
                if ($send->code == 200 && $send->is_success) {
                    $now = new DateTime();
                    $time = new \MongoDB\BSON\UTCDateTime($now->getTimestamp() * 1000);
                    $dataTran = [
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
                        'trans_id' => ($data['currency'] !== 'token') ? $send->trans_id : $send->receipt,
                        'trans_type' => 3,
                        'refund_for_trans' => 0,
                        'created_at' => $time
                    ];
                    $this->transaction_model->create($dataTran);

                    // tru luon
                    $setting = $this->setting_model->getWithdrawFee();
                    if (intval($setting[0]['withdraw_fee']) !== 0) {
                        $withDrawFee = ($data['amount'] * ($setting[0]['withdraw_fee'])) / 100;
                    } else {
                        $withDrawFee = 0;
                    }
                    $user = $this->usercoin_model->getCoinAddrByAddressAndType($data['from'], $data['currency']);
                    $balance = ($user[0]['balance']) - ($data['amount']) - $withDrawFee;
                    $this->usercoin_model->updateBalance($user[0]['user_id'], $user[0]['coin_type'], $balance);

                    return $this->set_response([
                        'status' => true,
                        'message' => 'Confirm success, back to system to check history'
                    ], REST_Controller::HTTP_OK);
                } else {
                    return $this->set_response([
                        'status' => false,
                        'message' => $send->msg
                    ], REST_Controller::HTTP_OK);    
                }
            } else {
                return $this->set_response([
                    'status' => false,
                    'message' => 'Confirm failed, user not found, back to system to withdraw again'
                ], REST_Controller::HTTP_OK);
            }
        } else {
            return $this->set_response([
                'status' => false,
                'message' => 'Confirm failed, no data provided, back to system to withdraw again'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function getAllSetting_get()
    {
        $setting = $this->setting_model->getCoinRate();
        return $this->set_response([
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

        return $this->set_response([
            'status' => true,
            'bonus' => $totalBonus
        ], REST_Controller::HTTP_OK);
    }

    public function getCoinsWithoutToken_get()
    {
        $coins = $this->usercoin_model->getCoinAddrUserWithoutToken($this->userInfo['user_id']);

        return $this->set_response([
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

        return $this->set_response([
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

        return $this->set_response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function getRefs_get()
    {
        $data = [];
        $refs = $this->affiliate_model->getAllRefOfCurrentUser($this->userInfo['user_id']);
        $affBonus = $this->setting_model->getAll();
        if (!empty($refs)) {
            foreach ($refs as $ref) {
                $affPerson = [];
                $user = $this->user_model->getUserDetailByUserId($ref['user_id']);
                $affPerson['email'] = $user[0]['email'];
                $affPerson['created'] = $ref['created_at'];
                $affPerson['affBonus'] = $affBonus[0]['aff_bonus'];
                $data[] = $affPerson;
            }
        }

        return $this->set_response([
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

        return $this->set_response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function getCoinAddr_get()
    {
        $coinType = $this->input->get('coinType');
        $userCoin = $this->usercoin_model->getCoinAddrByUserAndType($this->userInfo['user_id'], $coinType);

        return $this->set_response([
            'status' => true,
            'data' => (!empty($userCoin)) ? $userCoin[0] : []
        ], REST_Controller::HTTP_OK);
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

            return $this->set_response([
                'status' => true,
                'message' => 'Update success'
            ], REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            return $this->set_response([
                'status' => false,
                'message' => $e->getMessage()
            ], REST_Controller::HTTP_OK);
        }
    }

}
