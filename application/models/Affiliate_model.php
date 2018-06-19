<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Affiliate_model extends CI_Model
{

    // Declaration of a variables
    private $_userID;
    private $_refID;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setUserID($userID) {
        $this->_userID = $userID;
    }
 
    public function setRefID($refID) {
        $this->_refID = $refID;
    }

    // get all refs
    public function getAll($userId)
    {
        return $this->mongo_db->where('user_id', $userId)->get('affiliates');
    }

    public function getAffiliate($refId)
    {
        return $this->mongo_db->where('ref_id', $refId)->get('affiliates');
    }

    public function create($userId, $refId)
    {
        return $this->mongo_db->insert('affiliates', [
            'user_id' => $userId,
            'ref_id' => $refId,
            'created_at' => date('Y-m-d h:i:s')
        ]);
    }

}
