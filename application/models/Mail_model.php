<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Mail_model extends CI_Model {

    // Declaration of a variables
    private $_mailTo;
    private $_mailFrom;
    private $_mailSubject;
    private $_mailContent;
    private $_templateName;
    private $_templatePath;

    //Declaration of a methods
    public function setMailTo($mailTo) {
        $this->_mailTo = $mailTo;
    }

    public function setMailFrom($mailFrom) {
        $this->_mailFrom = $mailFrom;
    }

    public function setMailSubject($mailSubject) {
        $this->_mailSubject = $mailSubject;
    }

    public function setMailContent($mailContent) {
        $this->_mailContent = $mailContent;
    }

    public function setTemplateName($templateName) {
        $this->_templateName = $templateName;
    }

    public function setTemplatePath($templatePath) {
        $this->_templatePath = $templatePath;
    }

    // smtpMail
    public function sendMail($setting, $temp) {

        $this->load->library('Mandrill');
        $this->load->config('mandrill');

        $mandrill_ready = NULL;
        try {
            $obj =& get_instance();
            $this->mandrill->init($obj->config->item('mandrill_api_key'));
            $mandrill_ready = TRUE;
        } catch (Mandrill_Exception $e) {
            $mandrill_ready = FALSE;
        }
        if ($mandrill_ready) {
            //Send us some email!
            $temp = html_entity_decode($temp);
            $temp = preg_replace('/\s+/', ' ', $temp);
            $email = array(
                'html' => $temp, //Consider using a view file
                'text' => 'This is my plaintext message',
                'subject' => $this->_mailSubject,
                'from_email' => $this->_mailFrom,
                'from_name' => 'Bitgamecoins',
                'to' => array(array('email' => $this->_mailTo ))
            );

            $result = $this->mandrill->messages_send($email);
            if ($result) {
                return true;
            }
        }

        return false;

        // $this->load->library('email');

        // $config = [];
        // $config['protocol']     = 'smtp';
        // $config['smtp_host']    = 'smtp.mandrillapp.com';
        // $config['smtp_port']    = '587';
        // $config['smtp_user']    = $setting[0]['mail_sender'];
        // $config['smtp_pass']    = $setting[0]['pass_mail_sender'];
        // $config['charset']      = 'utf-8';
        // $config['mailtype']     = 'html';
        // $config['wordwrap']     = true;

        // $this->email->initialize($config);
        // $this->email->set_mailtype("html");
        // $this->email->set_newline("\r\n");
        //$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        //$this->email->set_header('Content-type', 'text/html');
        //Email content
        // $fullPath = $this->_templatePath . $this->_templateName;
        // $mailMessage = $this->load->view($fullPath, $this->_mailContent, TRUE);
        // $this->email->to($this->_mailTo);
        // $this->email->from($this->_mailFrom);
        // $this->email->subject($this->_mailSubject);

        // $temp = html_entity_decode($temp);
        // $temp = preg_replace('/\s+/', ' ', $temp);

        // $this->email->message($temp);
        //Send email
        // if ($this->email->send()) {
        //     return true;
        // }
        // $this->email->send();
        // var_dump($this->email->print_debugger());die;

        // return false;
    }

}
?>