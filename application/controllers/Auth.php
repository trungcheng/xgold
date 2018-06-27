<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('layouts/auth');
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->load->model('usercoin_model');
        $this->load->model('affiliate_model');
        $this->load->model('mail_model');
        $this->load->model('setting_model');
        $this->load->helper('setting_helper');
        $this->load->library('Curl');
        $this->load->library('Mandrill');
        $this->load->config('mandrill');
    }

    // private function _create_captcha()
    // {
    //     $this->load->helper('captcha');
    //     $options = array(
    //         'img_path' => FCPATH.'assets/images/captcha/',
    //         'img_url' => site_url().'assets/images/captcha/',
    //         'img_width' => '160',
    //         'img_height' => '38',
    //         'word_length'   => 5,
    //         'font_size'     => 20
    //         // 'expiration' => 7200
    //     );
    //     //now we will create the captcha by using the helper function create_captcha()
    //     $cap = create_captcha($options);
    //     $image = $cap['image'];
    //     $this->session->set_userdata('captchaword', $cap['word']);
    //     // we will return the image html code
    //     return $image;
    // }

    // public function refreshCaptcha() {
    //     // Captcha configuration
    //     $this->load->helper('captcha');
    //     $config = array(
    //         'img_path'      => FCPATH.'assets/images/captcha/',
    //         'img_url'       => site_url().'assets/images/captcha/',
    //         'img_width'     => '160',
    //         'img_height'    => '38',
    //         'word_length'   => 5,
    //         'font_size'     => 20
    //     );
    //     $captcha = create_captcha($config);
    //     // Unset previous captcha and set new captcha word
    //     $this->session->unset_userdata('captchaword');
    //     $this->session->set_userdata('captchaword', $captcha['word']);
    //     // Display captcha image
    //     echo json_encode(['data' => $captcha['image']]);
    // }

    // public function check_captcha($string)
    // {
    //     if ($string==$this->session->userdata('captchaword')) {
    //         return true;
    //     } else {
    //         $this->form_validation->set_message('check_captcha', 'Wrong captcha code');
    //         return false;
    //     }
    // }

    public function login()
    {
        // var_dump($this->user_model->hash('12345678'));die;
        if (!empty($this->input->get('usid'))) {
            $verificationCode = urldecode(base64_decode($this->input->get('usid')));
            $this->user_model->setVerificationCode($verificationCode);
            $result = $this->user_model->activate();
            if ($result['status']) {
                $this->createUserCoin($result['userId']);
                $this->session->set_flashdata('success', 'Confirm the registration success');
            } else {
                $this->session->set_flashdata('error', 'Confirm the registration failed');
            }
        }
        $data = [];
        $data['pageName'] = 'Login';
        // $data['image'] = $this->_create_captcha();
        $this->load->library('recaptcha');
        //Store the captcha HTML for correct MVC pattern use.
        $data['recaptcha_html'] = $this->recaptcha->render();

        $this->layout->auth('login', $data);
    }

	public function register()
	{
		$data = [];
        if ($this->input->get('sponsor')) {
            $data['sponsor'] = $this->input->get('sponsor');
        }
        $data['pageName'] = 'Register';
        $this->load->library('recaptcha');
        //Store the captcha HTML for correct MVC pattern use.
        $data['recaptcha_html'] = $this->recaptcha->render();
        // $data['image'] = $this->_create_captcha();
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
        $this->load->library('recaptcha');

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        // $this->form_validation->set_rules('captcha', 'captcha', 'trim|callback_check_captcha|required');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->login();
        } else {
            // Catch the user's answer
            $captcha_answer = $this->input->post('g-recaptcha-response');
            // Verify user's answer
            $response = $this->recaptcha->verifyResponse($captcha_answer);
            // Processing ...
            if ($response['success']) {
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
                            'email' => $result['email'],
                            'is_admin' => $result['is_admin']
                        );
                        $this->session->set_userdata('ci_session_key_generate', TRUE);
                        $this->session->set_userdata('ci_seesion_key', $authArray);
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata('error', 'Please access to your email to confirm the registration');
                        redirect('auth/login');
                    }
                } else {
                    redirect('auth/login?msg=1');
                }
            } else {
                $this->session->set_flashdata('error', 'Incorrect captcha');
                redirect('auth/login');
            }
        }
    }

	// action create user method
    public function actionCreate() {
        $this->load->library('recaptcha');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('retypePassword', 'Password Confirmation', 'trim|required|matches[password]');
        // $this->form_validation->set_rules('captcha', 'captcha', 'trim|callback_check_captcha|required');
        // $this->form_validation->set_rules('phone', 'Phone', 'required');
        // $this->form_validation->set_rules('birthday', 'Date of Birth(DD-MM-YYYY)', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->register();
        } else {
            // Catch the user's answer
            $captcha_answer = $this->input->post('g-recaptcha-response');
            // Verify user's answer
            $response = $this->recaptcha->verifyResponse($captcha_answer);
            // Processing ...
            if ($response['success']) {
                $data = $this->input->post();
                $verificationCode = uniqid();
                $verificationLink = site_url() . 'auth/login?usid=' . urlencode(base64_encode($verificationCode));

                $this->load->library('encrypt');
                // $mailData = array(
                //     'topMsg' => $data['email'],
                //     'bodyMsg' => 'Congratulations, your registration has been successfully submitted.', 
                //     'thanksMsg' => 'Thanks for your cooperation!', 
                //     'verificationLink' => $verificationLink
                // );
                $setting = $this->setting_model->getAll();
                $registerTemp = json_decode($setting[0]['register_temp']);
                $temp = str_replace('xxx@gmail.com', $data['email'], $registerTemp->content);
                $temp = str_replace('http://link', $verificationLink, $temp);

                $this->mail_model->setMailTo($data['email']);
                $this->mail_model->setMailFrom($registerTemp->from);
                $this->mail_model->setMailSubject($registerTemp->subject);
                // $this->mail_model->setMailContent($mailData);
                // $this->mail_model->setTemplateName('register_temp');
                // $this->mail_model->setTemplatePath('mail/');
                $chkStatus = $this->mail_model->sendMail(get_setting(), $temp);
                if ($chkStatus) {
                    $this->user_model->setUserID('XGOLD'.substr(md5($data['email'].time()), 0, 9));
                    $this->user_model->setEmail($data['email']);
                    $this->user_model->setAddress($data['address']);
                    $this->user_model->setPassword($data['password']);
                    $this->user_model->setMobile($data['phone']);
                    $this->user_model->setActive(false);
                    $this->user_model->setAvatar(base_url('assets/v2/images/users/no-avatar.jpg'));
                    $this->user_model->setVerificationCode($verificationCode);
                    $this->user_model->setIsAdmin(false);
                    $chk = $this->user_model->create();
                    if ($chk) {
                        // create ref
                        if ($data['sponsor'] !== null && $data['sponsor'] !== '') {
                            $user = $this->user_model->getUserDetailByEmail($data['email']);
                            $sponsor = $this->user_model->getUserDetailByUserId($data['sponsor']);
                            if (!empty($sponsor)) {
                                $this->affiliate_model->create($user[0]['user_id'], $data['sponsor']);
                            }
                        }

                        $this->session->set_flashdata('success', 'Congratulations! Please check your email to confirm the registration');
                        redirect('auth/login');
                    } else {
                        $this->session->set_flashdata('error', 'Can not create user! Maybe this user already existed.');
                        redirect('auth/register');
                    }
                } else {
                    $this->session->set_flashdata('error', 'The error occurred when sent mail process');
                    redirect('auth/register');
                }
            } else {
                $this->session->set_flashdata('error', 'Incorrect captcha');
                redirect('auth/register');
            }
        }
    }
 
    // public function actionChangePwd() {
    //     $this->form_validation->set_rules('change_pwd_password', 'Password', 'trim|required|min_length[8]');
    //     $this->form_validation->set_rules('change_pwd_confirm_password', 'Password Confirmation', 'trim|required|matches[change_pwd_password]');
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->changepwd();
    //     } else {
    //         $change_pwd_password = $this->input->post('change_pwd_password');
    //         $sessionArray = $this->session->userdata('ci_seesion_key');
    //         $this->user_model->setUserID($sessionArray['user_id']);
    //         $this->user_model->setPassword($change_pwd_password);
    //         $status = $this->user_model->changePassword();
    //         if ($status == TRUE) {
    //             redirect('profile');
    //         }
    //     }
    // }
 
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
                // $mailData = array(
                //     'topMsg' => $email,
                //     'bodyMsg' => 'We heard that you lost your Xgold password. Sorry about that !<br>But don’t worry! We are already reset a new password for you.', 
                //     'thanksMsg' => 'Thanks for your cooperation!', 
                //     'newPassword' => $pass,
                //     'loginLink' => $loginLink
                // );

                // $mandrill_ready = NULL;
                // try {
                //     $obj =& get_instance();
                //     $this->mandrill->init($obj->config->item('mandrill_api_key'));
                //     $mandrill_ready = TRUE;
                // } catch (Mandrill_Exception $e) {
                //     $mandrill_ready = FALSE;
                // }
                // if ($mandrill_ready) {
                //     //Send us some email!
                //     $email = array(
                //         'html' => '<p>This is my message<p>', //Consider using a view file
                //         'text' => 'This is my plaintext message',
                //         'subject' => 'This is my subject',
                //         'from_email' => 'cio@bitgamecoins.com',
                //         'from_name' => 'Bitgamecoins',
                //         'to' => array(array('email' => 'huydth65@gmail.com' ))
                //     );

                //     $result = $this->mandrill->messages_send($email);
                //     if ($result) {
                //         redirect('auth/forgotpwd?msg=2');
                //     } else {
                //         redirect('auth/forgotpwd?msg=1');
                //     }
                // }

                $setting = $this->setting_model->getAll();
                $resetTemp = json_decode($setting[0]['reset_password_temp']);
                $temp = str_replace('xxx@gmail.com', $email, $resetTemp->content);
                $temp = str_replace('ABCDEFGH', $pass, $temp);
                $temp = str_replace('http://link', $loginLink, $temp);

                $this->mail_model->setMailTo($email);
                $this->mail_model->setMailFrom($resetTemp->from);
                $this->mail_model->setMailSubject($resetTemp->subject);
                // var_dump($temp);die;
                // $this->mail_model->setMailContent($mailData);
                // $this->mail_model->setTemplateName('resetpwd_temp');
                // $this->mail_model->setTemplatePath('mail/');
                $chkStatus = $this->mail_model->sendMail(get_setting(), $temp);
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

    public function createUserCoin($userId) {
        $token = $this->curl->getToken();
        $cbs = $this->curl->createAddress($token);
        foreach ($cbs as $cb) {
            $coinName = '';
            switch ($cb->currency) {
                case 'btc':
                    $coinName = 'Bitcoin';
                    break;
                case 'eth':
                    $coinName = 'Ethereum';
                    break;
                case 'ltc':
                    $coinName = 'Litecoin';
                    break;
                case 'token':
                    $coinName = 'Bitgame';
                    break;
                default:
                    $coinName = 'Bitcoin Cash';
                    break;
            }
            $data = [
                'user_id' => $userId,
                'coin_addr' => $cb->address,
                'coin_type' => $cb->currency,
                'coin_name' => $coinName,
                'balance' => 0.0
            ];
            $this->usercoin_model->create($data);
        }
    }

}
