<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class User_model extends CI_Model
{

    // Declaration of a variables
    private $_userID;
    private $_refID;
    private $_email;
    private $_userName;
    private $_password;
    private $_avatar;
    private $_mobile;
    private $_active;
    private $_verificationCode;

    public function __construct()
    {
        parent::__construct();
    }
 
    //Declaration of a methods
    public function setUserID($userID) {
        $this->_userID = $userID;
    }

    public function setRefID($refID) {
        $this->_refID = $refID;
    }
 
    public function setUserName($userName) {
        $this->_userName = $userName;
    }
 
    public function setEmail($email) {
        $this->_email = $email;
    }
 
    public function setPassword($password) {
        $this->_password = $password;
    }
 
    public function setAvatar($avatar) {
        $this->_avatar = $avatar;
    }
 
    public function setMobile($mobile) {
        $this->_mobile = $mobile;
    }
 
    public function setActive($active) {
        $this->_active = $active;
    }

    public function setVerificationCode($verificationCode) {
        $this->_verificationCode = $verificationCode;
    }

    // get all users
    public function getAll()
    {
        return $this->mongo_db->get('users');
    }

    // login method and password verify
    public function login() {
        $query = $this->mongo_db->or_where(['username' => $this->_email, 'email' => $this->_email])
            ->limit(1)->get('users');
        if (count($query) > 0) {
            if ($this->verifyHash($this->_password, $query[0]['password'])) {
                return $query[0];
            }
        }

        return false;
    }

    //create new user
    public function create() {
        $hash = $this->hash($this->_password);
        $data = array(
            'user_id' => $this->_userID,
            'ref_id' => $this->_refID,
            'email' => $this->_email,
            'username' => $this->_userName,
            'password' => $hash,
            'avatar' => $this->_avatar,
            'mobile' => $this->_mobile,
            'active' => $this->_active,
            'verification_code' => $this->_verificationCode,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        );
        $query = $this->mongo_db->or_where(['username' => $this->_userName, 'email' => $this->_email])->get('users');
        if (empty($query)) {
            $this->mongo_db->insert('users', $data);
            return true;
        }

        return false;
    }
 
    //update user
    public function update() {
        $data = array(
            'first_name' => $this->_firstName,
            'last_name' => $this->_lastName,
            'contact_no' => $this->_contactNo,
            'address' => $this->_address,
            'dob' => $this->_dob,
            'modified_date' => $this->_timeStamp,
        );
        $this->db->where('id', $this->_userID);
        $msg = $this->db->update('users', $data);
        if ($msg == 1) {
            return true;
        } else {
            return false;
        }
    }
 
    //change password
    public function changePassword() {
        $hash = $this->hash($this->_password);
        $data = array(
            'password' => $hash,
        );
        $this->db->where('id', $this->_userID);
        $msg = $this->db->update('users', $data);
        if ($msg == 1) {
            return true;
        } else {
            return false;
        }
    }
 
    // get User Detail
    public function getUserDetails() {
        $this->db->select(array('m.id as user_id', 'CONCAT(m.first_name, " ", m.last_name) as full_name', 'm.first_name', 'm.last_name', 'm.email', 'm.contact_no', 'm.address', 'm.dob'));
        $this->db->from('users as m');
        $this->db->where('m.id', $this->_userID);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
 
    // update Forgot Password
    public function updateForgotPassword() {
        $query = $this->mongo_db->where('email', $this->_email)->get('users');
        if (!empty($query)) {
            $hash = $this->hash($this->_password);
            $data = array(
                'password' => $hash,
            );
            $this->mongo_db->set($data)
                ->where('email', $this->_email)
                ->update('users');
            return true;
        }

        return false;
    }
 
    // active user
    public function activate() {
        $query = $this->mongo_db->where('verification_code', $this->_verificationCode)->get('users');
        if (!empty($query)) {
            $data = array(
                'active' => true,
                'verification_code' => 1
            );
            $this->mongo_db->set($data)
                ->where('user_id', $query[0]['user_id'])
                ->update('users');
            return true;
        }
        
        return false;
    }
 
    // password hash
    public function hash($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }
 
    // password verify
    public function verifyHash($password, $vpassword) {
        if (password_verify($password, $vpassword)) {
            return true;
        } else {
            return false;
        }
    }
}
