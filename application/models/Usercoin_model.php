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
    private $_coin_name;
    private $_balance;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Curl');
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

    public function setCoinName($coinName) {
        $this->_coin_name = $coinName;
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

    public function getCoinAddrUserWithoutToken($userId)
    {
        return $this->mongo_db->where('user_id', $userId)
            ->where_ne('coin_type', 'token')
            ->get('user_coin');
    }

    public function getCoinAddrUserToken($userId)
    {
        return $this->mongo_db->where('user_id', $userId)
            ->where('coin_type', 'token')
            ->get('user_coin');
    }

    public function getCoinAddrByUserAndName($userId, $name)
    {
        return $this->mongo_db->where('user_id', $userId)
            ->where('coin_name', $name)
            ->get('user_coin');
    }

    public function getCoinAddrByAddressAndType($address, $type)
    {
        return $this->mongo_db->where('coin_addr', $address)
            ->where('coin_type', $type)
            ->get('user_coin');
    }

    public function getCoinAddrByUserAndType($userId, $type)
    {
        return $this->mongo_db->where('user_id', $userId)
            ->where('coin_type', $type)
            ->get('user_coin');
    }

    public function create($data)
    {
        return $this->mongo_db->insert('user_coin', $data);
    }

    public function update($userId, $type, $addr)
    {
        $this->mongo_db->set(['coin_addr' => $addr])
            ->where('user_id', $userId)
            ->where('coin_type', $type)
            ->update('user_coin');
        return true;
    }

    public function updateBalance($userId, $type, $balance) 
    {
        $this->mongo_db->set(['balance' => $balance])
            ->where('user_id', $userId)
            ->where('coin_type', $type)
            ->update('user_coin');
        return true;
    }

    public function delete($userId) 
    {
        return $this->mongo_db->where('user_id', $userId)->deleteAll('user_coin');
    }

}
