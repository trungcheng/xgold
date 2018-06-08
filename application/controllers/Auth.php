<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('layouts/auth');
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->load->model('mail_model');
    }

    public function login()
    {
        if (!empty($this->input->get('usid'))) {
            $verificationCode = urldecode(base64_decode($this->input->get('usid')));
            $this->user_model->setVerificationCode($verificationCode);
            $this->user_model->activate();
        }
        $data = [];
        $data['pageName'] = 'Login';
        $this->layout->auth('login', $data);
    }

	public function register()
	{
		$data = [];
        if ($this->input->get('ref_id')) {
            $data['ref_id'] = $this->input->get('ref_id');
        }
        $data['pageName'] = 'Register';
        $this->layout->auth('register', $data);
	}

    public function forgotpwd()
    {
        $data = [];
        $data['pageName'] = 'Forgot password';
        $this->layout->auth('forgot_password', $data);
    }

    // action login method
    public function doLogin() {
        // var_dump($this->user_model->getAll());die;
        // Check form  validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'User Name/Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->login();
        } else {
            $sessArray = array();
            //Field validation succeeded.  Validate against database
            $email = $this->input->post('email');
            $password = $this->input->post('password');
 
            $this->user_model->setEmail($email);
            $this->user_model->setPassword($password);
            //query the database
            $result = $this->user_model->login();

            if ($result) {
                $authArray = array(
                    'user_id' => $result['user_id'],
                    'username' => $result['username'],
                    'email' => $result['email']
                );
                $this->session->set_userdata('ci_session_key_generate', TRUE);
                $this->session->set_userdata('ci_seesion_key', $authArray);
                redirect('dashboard/index');
            } else {
                redirect('auth/login?msg=1');
            }
        }
    }

	// action create user method
    public function actionCreate() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('retypePassword', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        // $this->form_validation->set_rules('birthday', 'Date of Birth(DD-MM-YYYY)', 'required');
 
        if ($this->form_validation->run() == FALSE) {
            $this->register();
        } else {
            $data = $this->input->post();
            $timeStamp = time();
            $active = false;
            $verificationCode = uniqid();
            $verificationLink = site_url() . 'signin?usid=' . urlencode(base64_encode($verificationCode));
            $this->user_model->setUserID(md5($data['email']).$timeStamp);
            $this->user_model->setRefID($data['sponsor']);
            $this->user_model->setEmail($data['email']);
            $this->user_model->setUserName($data['username']);
            $this->user_model->setPassword($data['password']);
            $this->user_model->setMobile($data['phone']);
            $this->user_model->setActive($active);
            $this->user_model->setAvatar(base_url('assets/v2/images/users/no-avatar.jpg'));
            $this->user_model->setVerificationCode($verificationCode);
            $chk = $this->user_model->create();
            if ($chk) {
                $this->load->library('encrypt');
                $mailData = array('topMsg' => 'Hi', 'bodyMsg' => 'Congratulations, Your registration has been successfully submitted.', 'thanksMsg' => SITE_DELIMETER_MSG, 'delimeter' => SITE_DELIMETER, 'verificationLink' => $verificationLink);
                $this->mail->setMailTo($data['email']);
                $this->mail->setMailFrom('Xgold');
                $this->mail->setMailSubject('User Registeration!');
                $this->mail->setMailContent($mailData);
                $this->mail->setTemplateName('verification');
                $this->mail->setTemplatePath('mailTemplate/');
                $chkStatus = $this->mail->sendMail('smtp');
                if ($chkStatus === TRUE) {
                    redirect('auth/login');
                } else {
                    echo 'Error';
                }
            } else {
                echo 'Loi';
            }
        }
    }
 
    public function actionChangePwd() {
        $this->form_validation->set_rules('change_pwd_password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('change_pwd_confirm_password', 'Password Confirmation', 'trim|required|matches[change_pwd_password]');
        if ($this->form_validation->run() == FALSE) {
            $this->changepwd();
        } else {
            $change_pwd_password = $this->input->post('change_pwd_password');
            $sessionArray = $this->session->userdata('ci_seesion_key');
            $this->auth->setUserID($sessionArray['user_id']);
            $this->auth->setPassword($change_pwd_password);
            $status = $this->auth->changePassword();
            if ($status == TRUE) {
                redirect('profile');
            }
        }
    }
 
    //action forgot password method
    public function actionForgotPassword() {
        $this->form_validation->set_rules('forgot_email', 'Your Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to Forgot Password page
            $this->forgotpassword();
        } else {
            $login = site_url() . 'signin';
            $email = $this->input->post('forgot_email');
            $this->auth->setEmail($email);
            $pass = $this->generateRandomPassword(8);
            $this->auth->setPassword($pass);
            $status = $this->auth->updateForgotPassword();
            if ($status == TRUE) {
                $this->load->library('encrypt');
                $mailData = array('topMsg' => 'Hi', 'bodyMsg' => 'Your password has been reset successfully!.', 'thanksMsg' => SITE_DELIMETER_MSG, 'delimeter' => SITE_DELIMETER, 'loginLink' => $login, 'pwd' => $pass, 'username' => $email);
                $this->mail->setMailTo($email);
                $this->mail->setMailFrom(MAIL_FROM);
                $this->mail->setMailSubject('Forgot Password!');
                $this->mail->setMailContent($mailData);
                $this->mail->setTemplateName('sendpwd');
                $this->mail->setTemplatePath('mailTemplate/');
                $chkStatus = $this->mail->sendMail(MAILING_SERVICE_PROVIDER);
                if ($chkStatus === TRUE) {
                    redirect('auth/forgotpwd?msg=2');
                } else {
                    redirect('auth/forgotpwd?msg=1');
                }
            } else {
                redirect('auth/forgotpwd?msg=1');
            }
        }
    }
 
    //generate random password
    public function generateRandomPassword($length = 10) {
        $alphabets = range('a', 'z');
        $numbers = range('0', '9');
        $final_array = array_merge($alphabets, $numbers);
        $password = '';
        while ($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }
        return $password;
    }
 
    //logout method
    public function logout() {
        $this->session->unset_userdata('ci_seesion_key');
        $this->session->unset_userdata('ci_session_key_generate');
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('auth/login');
    }
}
