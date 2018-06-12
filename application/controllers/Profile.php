<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->layout->setLayout('layouts/template');
    }

	public function index()
	{
		$data = [];
		$data['pageName'] = 'Profile';
		$this->layout->view('profile/index', $data);
	}

	public function password()
	{
		$data = [];
		$data['pageName'] = 'Change password';
		$this->layout->view('profile/password', $data);
	}
}
