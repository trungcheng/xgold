<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
/** 
 * Layouts Class. PHP5 only. 
 * 
 */
class Layout {

	public $obj;
    public $layout;

    public function __construct($layout = "")
    {
        $this->obj = & get_instance();
        $this->ci = $this->obj;
        $this->load = $this->obj->load;
        $this->layout = $layout;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function view($view, $data=null, $return=false)
    {
        $loadedData = array();
        $loadedData['contents'] = $this->obj->load->view('pages/'.$view, $data, true);

        if ($return) {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        } else {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }

    public function auth($view, $data=null, $return=false)
    {
        $loadedData = array();
        $loadedData['auth_contents'] = $this->obj->load->view('auth/'.$view, $data, true);

        if ($return) {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        } else {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }
}