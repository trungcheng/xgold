<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
    }

	public function index()
	{
		$data = [];
		$data['pageName'] = 'Dashboard';
		$this->layout->view('dashboard/index', $data);
	}
}
