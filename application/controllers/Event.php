<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller {

	public $userInfo;

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
		$this->load->library('form_validation');
		$this->load->model('event_model');
    	$this->userInfo = $this->session->userdata('ci_seesion_key');
    }

	public function index()
	{
		$data = [];
		$data['pageName'] = 'Events';

		$this->layout->view('event/index', $data);
	}

	public function getAll()
	{
		$data = $this->event_model->getAll();
		echo json_encode(['data' => $data]);
	}

	public function create()
	{
		try {
			$postdata = file_get_contents("php://input");
	    	$request = json_decode($postdata);
	    	if (!isset($request->name) || !isset($request->from_date) || !isset($request->to_date) || !isset($request->bonus)) {
	    		echo json_encode(['status' => false, 'message' => 'Data invalid']);
	    	} else {
	    		if ($request->from_date <= $request->to_date) {
		            $this->event_model->setEventID(md5($request->name.time()));
		            $this->event_model->setName($request->name);
		            $this->event_model->setFromDate($request->from_date);
		            $this->event_model->setToDate($request->to_date);
		            $this->event_model->setBonus($request->bonus);
		            $this->event_model->setSelected(($request->selectedOption == 'Yes') ? true : false);
			    	$chk = $this->event_model->create();
			    	if ($chk) {
						echo json_encode(['status' => true, 'message' => 'Add event success']);
					} else {
						echo json_encode(['status' => false, 'message' => 'This event already existed']);
					}
				} else {
					echo json_encode(['status' => false, 'message' => 'From date is not bigger than to date']);
				}	
	    	}
		} catch (Exception $e) {
			echo json_encode(['status' => false, 'message' => $e->getMessage()]);
		}
	}

	public function update()
	{
		try {
			$postdata = file_get_contents("php://input");
	    	$request = json_decode($postdata);
	    	if (!isset($request->name) || !isset($request->from_date) || !isset($request->to_date) || !isset($request->bonus)) {
	    		echo json_encode(['status' => false, 'message' => 'Data invalid']);
	    	} else {
	    		if ($request->from_date <= $request->to_date) {
			    	$data = [
			    		'name' => $request->name,
			    		'from_date' => $request->from_date,
			    		'to_date' => $request->to_date,
			    		'bonus' => $request->bonus,
			    		'is_selected' => ($request->selectedOption == 'Yes') ? true : false
			    	];
			    	$this->event_model->update($data, $request->event_id);
					echo json_encode(['status' => true, 'message' => 'Update event success']);
				} else {
					echo json_encode(['status' => false, 'message' => 'From date is not bigger than to date']);
				}
			}
		} catch (Exception $e) {
			echo json_encode(['status' => false, 'message' => $e->getMessage()]);
		}
	}

	public function delete()
	{
		$postdata = file_get_contents("php://input");
	    $request = json_decode($postdata);
	    $event = $this->event_model->getEventDetailByEventId($request->event_id);
	    if (!empty($event)) {
	    	$this->event_model->delete($request->event_id);
	    	echo json_encode(['status' => true, 'message' => 'Delete event success', 'type' => 'success']);
	    } else {
	    	echo json_encode(['status' => false, 'message' => 'Event not found', 'type' => 'error']);
	    }
	}

}
