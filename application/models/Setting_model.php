<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Setting_model extends CI_Model
{

    // Declaration of a variables
    private $_aff_bonus;
    private $_btc_rate;
    private $_eth_rate;
    private $_ltc_rate;
    private $_bch_rate;
    private $_mail_sender;
    private $_pass_mail_sender;
    private $_notification;
    private $_token_wallet;
    private $_withdraw_fee;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setAffBonus($bonus) {
        $this->_aff_bonus = $bonus;
    }
 
    public function setBtcRate($rate) {
        $this->_btc_rate = $rate;
    }

    public function setEthRate($rate) {
        $this->_eth_rate = $rate;
    }

    public function setLtcRate($rate) {
        $this->_ltc_rate = $rate;
    }

    public function setBchRate($rate) {
        $this->_bch_rate = $rate;
    }

    public function setMailSender($mailSender) {
        $this->_mail_sender = $mailSender;
    }

    public function setPassMailSender($passMailSender) {
        $this->_pass_mail_sender = $passMailSender;
    }

    public function setNotification($notification) {
        $this->_notification = $notification;
    }

    public function setTokenWallet($tokenWallet) {
        $this->_token_wallet = $tokenWallet;
    }

    public function setWithdrawFee($withdrawFee) {
        $this->_withdraw_fee = $withdrawFee;
    }

    // get all
    public function getAll()
    {
        return $this->mongo_db->get('setting');
    }

    public function getCoinRate()
    {
        return $this->mongo_db->select(['btc_rate', 'eth_rate', 'ltc_rate', 'bch_rate'])->get('setting');
    }

    public function getWithdrawFee()
    {
        return $this->mongo_db->select(['withdraw_fee'])->get('setting');   
    }

    public function update($data)
    {
        return $this->mongo_db->set($data)->update('setting');
    }

}
