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
            $result = $this->user_model->activate();
            if ($result) {
                $this->session->set_flashdata('success', 'Confirm the registration success');
            } else {
                $this->session->set_flashdata('error', 'Confirm the registration failed');
            }
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
        // Check form  validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'User Name/Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->login();
        } else {
            //Field validation succeeded.  Validate against database
            $email = $this->input->post('email');
            $password = $this->input->post('password');
 
            $this->user_model->setEmail($email);
            $this->user_model->setPassword($password);
            //query the database
            $result = $this->user_model->login();
            if ($result) {
                if ($result['active']) {
                    $authArray = array(
                        'user_id' => $result['user_id'],
                        'username' => $result['username'],
                        'email' => $result['email']
                    );
                    $this->session->set_userdata('ci_session_key_generate', TRUE);
                    $this->session->set_userdata('ci_seesion_key', $authArray);
                    redirect('dashboard/index');
                } else {
                    $this->session->set_flashdata('error', 'We need access to your email to confirm the registration');
                    redirect('auth/login');
                }
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
            $verificationCode = uniqid();
            $verificationLink = site_url() . 'auth/login?usid=' . urlencode(base64_encode($verificationCode));
            $this->user_model->setUserID(md5($data['email']));
            $this->user_model->setRefID($data['sponsor']);
            $this->user_model->setEmail($data['email']);
            $this->user_model->setUserName($data['username']);
            $this->user_model->setPassword($data['password']);
            $this->user_model->setMobile($data['phone']);
            $this->user_model->setActive(false);
            $this->user_model->setAvatar(base_url('assets/v2/images/users/no-avatar.jpg'));
            $this->user_model->setVerificationCode($verificationCode);
            $chk = $this->user_model->create();
            if ($chk) {
                $this->load->library('encrypt');
                $mailData = array(
                    'topMsg' => $data['username'],
                    'bodyMsg' => 'Congratulations, your registration has been successfully submitted.', 
                    'thanksMsg' => 'Thanks for your cooperation!', 
                    'verificationLink' => $verificationLink
                );
                $this->mail_model->setMailTo($data['email']);
                $this->mail_model->setMailFrom('Xgold');
                $this->mail_model->setMailSubject('[Xgold] - Verify the registration');
                $this->mail_model->setMailContent($mailData);
                $this->mail_model->setTemplateName('register_temp');
                $this->mail_model->setTemplatePath('mail/');
                $chkStatus = $this->mail_model->sendMail();
                if ($chkStatus) {
                    $this->session->set_flashdata('success', 'Register success, please check your email to confirm');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Can not send mail to user');
                    redirect('auth/register');
                }
            } else {
                $this->session->set_flashdata('error', 'Can not create user');
                redirect('auth/register');
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
            $this->user_model->setUserID($sessionArray['user_id']);
            $this->user_model->setPassword($change_pwd_password);
            $status = $this->user_model->changePassword();
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
            $loginLink = site_url() . 'auth/login';
            $email = $this->input->post('forgot_email');
            $this->user_model->setEmail($email);
            $pass = $this->generateRandomPassword(8);
            $this->user_model->setPassword($pass);
            $status = $this->user_model->updateForgotPassword();
            if ($status) {
                $this->load->library('encrypt');
                $mailData = array(
                    'topMsg' => $email,
                    'bodyMsg' => 'We heard that you lost your Xgold password. Sorry about that !<br>But don’t worry! We are already reset a new password for you.', 
                    'thanksMsg' => 'Thanks for your cooperation!', 
                    'newPassword' => $pass,
                    'loginLink' => $loginLink
                );
                $this->mail_model->setMailTo($email);
                $this->mail_model->setMailFrom('Xgold');
                $this->mail_model->setMailSubject('[Xgold] - Reset your password');
                $this->mail_model->setMailContent($mailData);
                $this->mail_model->setTemplateName('resetpwd_temp');
                $this->mail_model->setTemplatePath('mail/');
                $chkStatus = $this->mail_model->sendMail();
                if ($chkStatus) {
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
        $alphabets = range('A', 'Z');
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
