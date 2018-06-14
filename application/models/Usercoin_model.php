<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Usercoin_model extends CI_Model
{

    // Declaration of a variables
    private $_userID;
    private $_coin_addr;
    private $_coin_type;
    private $_balance;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setUserID($userID) {
        $this->_userID = $userID;
    }

    public function setCoinAddr($coinAddr) {
        $this->_coin_addr = $coinAddr;
    }

    public function setCoinType($coinType) {
        $this->_coin_type = $coinType;
    }

    public function setBalance($balance) {
        $this->_balance = $balance;
    }

    // get all user coins
    public function getAll()
    {
        return $this->mongo_db->get('user_coin');
    }

    public function getCoinAddrUser($userId)
    {
        return $this->mongo_db->where('user_id', $userId)->get('user_coin');
    }

    public function create($userId)
    {
        $types = ['xgold','btc','eth','ltc','bch'];
        foreach ($types as $type) {
            $data = [
                'user_id' => $userId,
                'coin_addr' => '',
                'coin_type' => $type,
                'balance' => 0.00
            ];
            $this->mongo_db->insert('user_coin', $data);
        }
    }

    public function update($userId, $type, $addr) {
        $this->mongo_db->set(['coin_addr' => $addr])
            ->where('user_id', $userId)
            ->where('coin_type', $type)
            ->update('user_coin');
        return true;
    }

}
