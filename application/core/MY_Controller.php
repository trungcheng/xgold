<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');
        $ci_session_key_generate = $this->session->userdata('ci_session_key_generate');
        $ci_seesion_key = $this->session->userdata('ci_seesion_key');
        if (!$ci_session_key_generate || !isset($ci_seesion_key['user_id'])) {
            // Prevent infinite loop by checking that this isn't the login controller
            redirect(base_url('auth/login'));
        }
        if ($this->uri->segment(1) == 'setting' || $this->uri->segment(1) == 'user' || $this->uri->segment(1) == 'event' || $this->uri->segment(1) == 'statistical') {
            if (!$ci_seesion_key['is_admin']) {
                redirect(base_url('dashboard/index'));
            }
        }

        $setting = $this->setting_model->getAll();
        $global_data = array('message' => $setting[0]['notification']);
        $this->load->vars($global_data);
    }
}
