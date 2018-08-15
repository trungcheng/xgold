<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $ci_session_key_generate = $this->session->userdata('ci_session_key_generate');
        $ci_seesion_key = $this->session->userdata('ci_seesion_key');
        if (!$ci_session_key_generate || !isset($ci_seesion_key['user_id'])) {
            // Prevent infinite loop by checking that this isn't the login controller
            redirect(base_url('auth/login'));
        }
        $user = $this->user_model->getUserDetailByUserId($ci_seesion_key['user_id']);
        $global_data = [
            'avatarUser' => $user[0]['avatar']
        ];
        $this->load->vars($global_data);
    }
}
