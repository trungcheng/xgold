<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Exchangerate_model extends CI_Model
{

    // Declaration of a variables
    private $_coin_type;
    private $_rate;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setCoinType($type) {
        $this->_coin_type = $type;
    }
 
    public function setRate($rate) {
        $this->_rate = $rate;
    }

    // get all
    public function getAll()
    {
        return $this->mongo_db->get('exchange_rate');
    }

}
