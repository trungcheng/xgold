<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Affiliatesetting_model extends CI_Model
{

    // Declaration of a variables
    private $_type;
    private $_bonus;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setType($type) {
        $this->_type = $type;
    }
 
    public function setBonus($bonus) {
        $this->_bonus = $bonus;
    }

    // get all
    public function getAll()
    {
        return $this->mongo_db->get('affiliate_setting');
    }

}
