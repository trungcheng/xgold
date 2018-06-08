<?php

/**
 * @author trungdn
 * @copyright 2017
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
    public function sendMail($data) {

        //Load email library
        $this->load->library('email');

        if (!empty($data) && $data == 'smtp') {
            //SMTP & mail configuration
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => '465',
                'smtp_user' => 'trungs1bmt@gmail.com',
                'smtp_pass' => 'hajimemashitee',
                'mailtype' => 'text',
                'charset' => 'utf-8',
            );

            $fullPath = $this->_templatePath . $this->_templateName;
            $this->email->initialize($config);
            // $this->email->set_mailtype(MAILTYPE);
            $this->email->set_newline("\r\n");

            //Email content
            $mailMessage = $this->load->view($fullPath, $this->_mailContent, TRUE);
            $this->email->to($this->_mailTo);
            $this->email->from($this->_mailFrom);
            $this->email->subject($this->_mailSubject);
            $this->email->message($mailMessage);
            //Send email
            if ($this->email->send()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}
?>