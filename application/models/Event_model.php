<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Event_model extends CI_Model
{

    // Declaration of a variables
    private $_from_date;
    private $_to_date;
    private $_bonus;
    private $_is_selected;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setFromDate($fromDate) {
        $this->_from_date = $fromDate;
    }
 
    public function setToDate($toDate) {
        $this->_to_date = $toDate;
    }

    public function setBonus($bonus) {
        $this->_bonus = $bonus;
    }

    public function setSelected($selected) {
        $this->_is_selected = $selected;
    }

    // get all refs
    public function getAll()
    {
        return $this->mongo_db->get('events');
    }

    public function create($data)
    {
        $data = [
            'from_date' => $data['fromDate'],
            'to_date' => $data['toDate'],
            'bonus' => $data['bonus'],
            'is_selected' => false
        ];
        return $this->mongo_db->insert('events', $data);
    }

}
