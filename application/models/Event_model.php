<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Event_model extends CI_Model
{

    // Declaration of a variables
    private $_eventID;
    private $_name;
    private $_from_date;
    private $_to_date;
    private $_bonus;
    private $_is_selected;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setEventID($eventID) {
        $this->_eventID = $eventID;
    }

    public function setName($name) {
        $this->_name = $name;
    }

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

    public function getSelectedEvents()
    {
        return $this->mongo_db->where('is_selected', true)
            // ->where_lte('from_date', date('Y-m-d h:i:s'))
            // ->where_gte('to_date', date('Y-m-d h:i:s'))
            ->get('events');
    }

    public function create()
    {
        $data = [
            'event_id' => $this->_eventID,
            'name' => $this->_name,
            'from_date' => $this->_from_date,
            'to_date' => $this->_to_date,
            'bonus' => $this->_bonus,
            'is_selected' => $this->_is_selected
        ];
        $query = $this->mongo_db->where('name', $this->_name)->get('events');
        if (empty($query)) {
            $this->mongo_db->insert('events', $data);
            return true;
        }

        return false;
    }

    public function update($data, $eventId) {
        $this->mongo_db->set($data)
            ->where('event_id', $eventId)
            ->update('events');
        return true;
    }

    public function delete($eventId) {
        return $this->mongo_db->where('event_id', $eventId)->delete('events');
    } 

    public function getEventDetailByEventId($eventId) {
        $query = $this->mongo_db->where('event_id', $eventId)->get('events');
        return $query;
    }

}
