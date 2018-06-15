<?php

function get_setting() {
    $ci =& get_instance();
    $ci->load->model('setting_model');
    return $ci->setting_model->getAll(); 
}