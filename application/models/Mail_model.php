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
    public function sendMail($setting) {
        $this->load->library('email');

        $config = [];
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'smtp.mandrillapp.com';
        $config['smtp_port']    = '587';
        $config['smtp_timeout'] = '30';
        $config['smtp_user']    = $setting[0]['mail_sender'];
        $config['smtp_pass']    = $setting[0]['pass_mail_sender'];
        $config['smtp_crypto']  = 'tls';
        $config['charset']      = 'utf-8';
        $config['newline']      = '\r\n';
        $config['mailtype']     = 'html';

        $this->email->initialize($config);
        $this->email->set_mailtype('html');
        $this->email->set_newline("\r\n");
        //Email content
        $fullPath = $this->_templatePath . $this->_templateName;
        $mailMessage = $this->load->view($fullPath, $this->_mailContent, TRUE);
        $this->email->to($this->_mailTo);
        $this->email->from($this->_mailFrom);
        $this->email->subject($this->_mailSubject);
        $this->email->message($mailMessage);
        //Send email
        if ($this->email->send()) {
            return true;
        }

        // echo $this->email->print_debugger();
        return false;
    }

}
?>