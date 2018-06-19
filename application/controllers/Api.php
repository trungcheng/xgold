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

        $this->set_response([
            'status' => true,
            'data' => $transactions
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

        $this->set_response([
            'status' => true,
            'data' => $transactions
        ], REST_Controller::HTTP_OK);
    }
}
