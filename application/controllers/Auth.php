<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('layouts/auth');
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->load->library('Curl');
    }

    public function login()
    {
        if (!empty($this->input->get('usid'))) {
            $verificationCode = utf8_decode(base64_decode($this->input->get('usid')));
            $this->user_model->setVerificationCode($verificationCode);
            $result = $this->user_model->activate();
            if ($result['status']) {
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
        $data['pageName'] = 'Register';
        $this->layout->auth('register', $data);
	}

    public function forgotpwd()
    {
        $data = [];
        $data['pageName'] = 'Forgot password';
        $this->layout->auth('forgot_password', $data);
    }

    public function resetpwd()
    {
        $data = [];
        $data['pageName'] = 'Reset password';
        $this->layout->auth('reset_password', $data);
    }

    // action login method
    public function doLogin() {
        // $this->load->library('recaptcha');

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        // $this->form_validation->set_rules('captcha', 'captcha', 'trim|callback_check_captcha|required');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->login();
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
 
            $this->user_model->setEmail($email);
            $this->user_model->setPassword($password);
            //query the database
            $result = $this->user_model->login();
            if ($result) {
                if ($result['active']) {
                    $authArray = array(
                        'user_id' => $result['id'],
                        'email' => $result['email'],
                        'is_admin' => $result['is_admin']
                    );
                    $this->session->set_userdata('ci_session_key_generate', TRUE);
                    $this->session->set_userdata('ci_seesion_key', $authArray);
                    redirect('user');
                } else {
                    $this->session->set_flashdata('error', 'Please access to your email to confirm the registration');
                    redirect('auth/login');
                }
            } else {
                redirect('auth/login?msg=1');
            }
        }
    }

	// action create user method
    public function actionCreate() {
        // $this->load->library('recaptcha');

        // $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        // $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        // $this->form_validation->set_rules('retypePassword', 'Password Confirmation', 'trim|required|matches[password]');
        // // $this->form_validation->set_rules('captcha', 'captcha', 'trim|callback_check_captcha|required');
        // // $this->form_validation->set_rules('phone', 'Phone', 'required');
        // // $this->form_validation->set_rules('birthday', 'Date of Birth(DD-MM-YYYY)', 'required');
        // if ($this->form_validation->run() == FALSE) {
        //     $this->register();
        // } else {
        //     $data = $this->input->post();
        //     $verificationCode = uniqid();
        //     $verificationLink = site_url() . 'auth/login?usid=' . utf8_encode(base64_encode($verificationCode));

        //     $this->load->library('encrypt');
        //     // $mailData = array(
        //     //     'topMsg' => $data['email'],
        //     //     'bodyMsg' => 'Congratulations, your registration has been successfully submitted.', 
        //     //     'thanksMsg' => 'Thanks for your cooperation!', 
        //     //     'verificationLink' => $verificationLink
        //     // );
        //     $setting = $this->setting_model->getAll();
        //     $registerTemp = json_decode($setting[0]['register_temp']);
        //     $temp = str_replace('xxx@gmail.com', $data['email'], $registerTemp->content);
        //     $temp = str_replace('http://link', $verificationLink, $temp);

        //     $this->mail_model->setMailTo($data['email']);
        //     $this->mail_model->setMailFrom($registerTemp->from);
        //     $this->mail_model->setMailSubject($registerTemp->subject);
        //     // $this->mail_model->setMailContent($mailData);
        //     // $this->mail_model->setTemplateName('register_temp');
        //     // $this->mail_model->setTemplatePath('mail/');
        //     $chkStatus = $this->mail_model->sendMail(get_setting(), $temp);
        //     if ($chkStatus) {
        //         $this->user_model->setUserID('BGC'.substr(md5($data['email'].time()), 0, 9));
        //         $this->user_model->setEmail($data['email']);
        //         $this->user_model->setAddress($data['address']);
        //         $this->user_model->setPassword($data['password']);
        //         $this->user_model->setMobile($data['phone']);
        //         $this->user_model->setActive(false);
        //         $this->user_model->setAvatar(base_url('assets/v2/images/users/no-avatar.jpg'));
        //         $this->user_model->setVerificationCode($verificationCode);
        //         $this->user_model->setIsAdmin(false);
        //         $chk = $this->user_model->create();
        //         if ($chk) {
        //             $user = $this->user_model->getUserDetailByEmail($data['email']);
        //             // create user coin address
        //             $this->createUserCoin($user[0]['user_id']);
        //             // create ref
        //             if ($data['sponsor'] !== null && $data['sponsor'] !== '') {
        //                 $checkUserSponsor = $this->affiliate_model->getUserSponsor($user[0]['user_id'], $data['sponsor']);
        //                 if (!empty($checkUserSponsor)) {
        //                     $this->affiliate_model->create($user[0]['user_id'], $data['sponsor']);
        //                 }
        //             }

        //             $this->session->set_flashdata('success', 'Congratulations! Please check your email to confirm the registration');
        //             redirect('auth/login');
        //         } else {
        //             $this->session->set_flashdata('error', 'Can not create user! Maybe this user already existed.');
        //             redirect('auth/register');
        //         }
        //     } else {
        //         $this->session->set_flashdata('error', 'The error occurred when sent mail process');
        //         redirect('auth/register');
        //     }
        // }
    }
 
    public function actionChangePwd() {
        // $data = $this->input->post();
        // if ($data['email'] && $data['usid']) {
        //     $this->session->set_userdata('reset_session', [
        //         'email' => $data['email'],
        //         'usid' => $data['usid']
        //     ]);
        // }
        // $this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|min_length[8]');
        // $this->form_validation->set_rules('cfnewpassword', 'New Password Confirmation', 'trim|required|matches[newpassword]');
        // if ($this->form_validation->run() == FALSE) {
        //     $this->resetpwd();
        // } else {
        //     $ss = $this->session->userdata('reset_session');
        //     if ($ss['email'] && $ss['usid']) {
        //         $verificationCode = utf8_decode(base64_decode($ss['usid']));
        //         $this->user_model->setVerificationCode($verificationCode);
        //         $user = $this->user_model->getUserDetailByEmailAndUsid($ss['email']);
        //         if ($user) {
        //             $data = [
        //                 'verification_code' => "1",
        //                 'password' => $this->user_model->hash($data['newpassword'])
        //             ];
        //             $this->user_model->update($data, $user[0]['user_id']);
                    
        //             redirect('auth/resetpwd?msg=2');
        //         } else {
        //             redirect('auth/resetpwd?msg=1');
        //         }
        //     } else {
        //         redirect('auth/resetpwd?msg=1');
        //     }
        // }
    }
 
    //action forgot password method
    public function actionForgotPassword() {
        // $this->form_validation->set_rules('forgot_email', 'Your Email', 'trim|required|valid_email');
        // if ($this->form_validation->run() == FALSE) {
        //     //Field validation failed.  User redirected to Forgot Password page
        //     $this->forgotpwd();
        // } else {
        //     $email = $this->input->post('forgot_email');
        //     $resetCode = uniqid();
        //     $hash = utf8_encode(base64_encode($resetCode));
        //     $resetLink = site_url() . 'auth/resetpwd?m='.$email.'&usid='.$hash;
        //     // $this->user_model->setEmail($email);
        //     // $pass = $this->generateRandomPassword(8);
        //     // $this->user_model->setPassword($pass);
        //     // $status = $this->user_model->updateForgotPassword();
        //     $status = $this->user_model->getUserDetailByEmail($email);
        //     if ($status) {
        //         $this->load->library('encrypt');
        //         // $mailData = array(
        //         //     'topMsg' => $email,
        //         //     'bodyMsg' => 'We heard that you lost your Xgold password. Sorry about that !<br>But don’t worry! We are already reset a new password for you.', 
        //         //     'thanksMsg' => 'Thanks for your cooperation!', 
        //         //     'newPassword' => $pass,
        //         //     'loginLink' => $loginLink
        //         // );

        //         $setting = $this->setting_model->getAll();
        //         $resetTemp = json_decode($setting[0]['reset_password_temp']);
        //         $temp = str_replace('xxx@gmail.com', $email, $resetTemp->content);
        //         // $temp = str_replace('ABCDEFGH', $pass, $temp);
        //         $temp = str_replace('http://link', $resetLink, $temp);

        //         $this->mail_model->setMailTo($email);
        //         $this->mail_model->setMailFrom($resetTemp->from);
        //         $this->mail_model->setMailSubject($resetTemp->subject);
        //         // var_dump($temp);die;
        //         // $this->mail_model->setMailContent($mailData);
        //         // $this->mail_model->setTemplateName('resetpwd_temp');
        //         // $this->mail_model->setTemplatePath('mail/');
        //         $chkStatus = $this->mail_model->sendMail(get_setting(), $temp);
        //         if ($chkStatus) {
        //             $this->user_model->updateVerificationCode($resetCode, $status[0]['user_id']);
        //             redirect('auth/forgotpwd?msg=2');
        //         } else {
        //             redirect('auth/forgotpwd?msg=1');
        //         }
        //     } else {
        //         redirect('auth/forgotpwd?msg=1');
        //     }
        // }
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
