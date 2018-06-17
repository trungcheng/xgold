<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Log_model extends CI_Model
{

    // Declaration of a variables
    private $_userID;
    private $_action;
    private $_amount;
    private $_bonus;
    private $_buy_by;
    private $_status;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setUserID($userID) {
        $this->_userID = $userID;
    }

    public function setAction($action) {
        $this->_action = $action;
    }

    public function setAmount($amount) {
        $this->_amount = $amount;
    }

    public function setBonus($bonus) {
        $this->_bonus = $bonus;
    }
 
    public function setBuyby($buyBy) {
        $this->_buy_by = $buyBy;
    }

    public function setStatus($status) {
        $this->_status = $status;
    }

    // get all refs
    public function getAll()
    {
        return $this->mongo_db->get('logs');
    }

    public function create()
    {
        $data = [
            'user_id' => $this->_userID,
            'action' => $this->_action,
            'amount' => $this->_amount,
            'bonus' => $this->_bonus,
            'buy_by' => $this->_buy_by,
            'status' => $this->_status,
            'created_at' => date('Y-m-d h:i:s')
        ];
        $this->mongo_db->insert('logs', $data);
        return true;
    }

}
