<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 */
class Common
{
    public function __construct()
    {
        // parent::__construct();
        $this->_CIA = & get_instance();
       // $this->_CIA->load->model('product/product_model');
        $this->_CIA->load->library('layout');
    }
    
    /**
     * @author dinh thanh
     * @copyright 2017
     */
    
     public function loadMail()
     {
         $this->_CIA->config->load('email');
         $config = $this->_CIA->config->item('mail');
         $this->_CIA->load->library('PHPMailer/phpmailer');
         $this->_CIA->phpmailer->IsSMTP();
         $this->_CIA->phpmailer->SMTPAuth = true;
         $this->_CIA->phpmailer->SMTPSecure = $config['SMTPSecure'];
         $this->_CIA->phpmailer->Host = $config['host'];
         $this->_CIA->phpmailer->Port = $config['port'];
         $this->_CIA->phpmailer->Username = $config['username'];
         $this->_CIA->phpmailer->Password = $config['password'];
         $this->_CIA->phpmailer->SetFrom($config['username'], $config['contentFrom']);
         $this->_CIA->phpmailer->CharSet = $config['charset'];
     }
    /*End*/
 

 public function clear_sumbol($text)
 {
     if (!$text) {
         return false;
     }
     $text = strtolower($text);
     $text = str_replace("à", "a", $text);
     $text = str_replace("á", "a", $text);
     $text = str_replace("â", "a", $text);
     $text = str_replace("ợ", "o", $text);
     $text = str_replace("ư", "u", $text);
     return $text;
 }
 
    public function date_ranger($from, $to)
    {
        $mkFrom = strtotime($from);
        $mkTo = strtotime($to);
        $ranger = $mkTo - $mkFrom;
        return ceil($ranger/(24*60*60));
    }
 
    public function status_update($from, $to)
    {
        if ($this->date_ranger($from, $to) <=7) {
            return "<img src='".base_url("public/images/newupdate.png")."' />";
        }
        return;
    }
 
    public function status_new($from, $to)
    {
        if ($this->date_ranger($from, $to) <=7) {
            return "<img src='".base_url("public/images/new.gif")."' />";
        }
        return;
    }
 
    public function locdau($str)
    {
        $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
        "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
        ,"ế","ệ","ể","ễ",
        "ì","í","ị","ỉ","ĩ",
        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
        "ỳ","ý","ỵ","ỷ","ỹ",
        "đ",
        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
        "Ì","Í","Ị","Ỉ","Ĩ",
        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
        "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
        "Đ",
        "“","”"
        );
        
        $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
        "e","e","e","e","e","e","e","e","e","e","e",
        "i","i","i","i","i",
        "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
        "u","u","u","u","u","u","u","u","u","u","u",
        "y","y","y","y","y",
        "d",
        "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
        "E","E","E","E","E","E","E","E","E","E","E",
        "I","I","I","I","I",
        "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
        "U","U","U","U","U","U","U","U","U","U","U",
        "Y","Y","Y","Y","Y",
        "D",
        "","");
        return str_replace($marTViet, $marKoDau, $str);
    }
}
