<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Transaction_model extends CI_Model
{

    // Declaration of a variables
    private $_userID;
    private $_fromAddr;
    private $_toAddr;
    private $_total;
    private $_fee;
    private $_subtotal;
    private $_coin_type;
    private $_buy_by;
    private $_amount_currency_buy;
    private $_bonus;
    private $_status;
    private $_trans_fee;
    private $_trans_id;
    private $_trans_type;
    private $_refund_for_trans;

    public function __construct()
    {
        parent::__construct();
    }

    // get all refs
    public function getAll()
    {
        return $this->mongo_db->get('transactions');
    }

    public function create($data)
    {
        $this->mongo_db->insert('transactions', $data);
        return true;
    }

    public function getTokenTransactions($userId)
    {
        return $this->mongo_db->where('user_id', $userId)
            ->where('coin_type', 'token')
            ->get('transactions');
    }

}
