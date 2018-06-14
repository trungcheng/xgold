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
    private $_token_rate;

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

    public function setTokenRate($rate) {
        $this->_token_rate = $rate;
    }

    // get all
    public function getAll()
    {
        return $this->mongo_db->get('setting');
    }

}
