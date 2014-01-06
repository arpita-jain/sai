<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Class Description
 * Project Name: wegottickets
 * Class name : auth
 * File name auth.php
 */

class Auth extends CI_Controller {

    function __construct() { 
       parent::__construct();
        $this->load->model('Model_admin');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->isLoggedIn();
    }

    public function isLoggedIn() {
        if ($this->session->userdata('admin_logged_in') === TRUE) {
            redirect("admin");
        }
    }

    public function index() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $data = array();
        if ($this->form_validation->run() == TRUE) {
            $login = $this->Model_admin->logged_in();
            if (count($login) > 0) {
                $newdata = array(
                    'admin_id' => $login['id'],
                    'admin_firstname' => $login['first_name'],
                    'admin_lastname' => $login['last_name'],
                    'admin_email' => $login['email'],
                    'admin_logged_in' => TRUE,
                    'admin_type' => $login['user_type'],
                ); 
                if ($login['user_type'] == 4) {
                    if ($this->Model_admin->testAuthentication()) {
                        $this->session->set_userdata($newdata);
                        $this->Model_admin->setLastLogin();
                        $this->Model_admin->setRememberMe();
                        redirect("admin");
                    }
                } else {
                    $this->session->set_userdata($newdata);
                    $this->Model_admin->setLastLogin();
                    $this->Model_admin->setRememberMe();
                    redirect("admin");
                }
            } else { 
                $this->session->set_userdata('loginerror', 'Sorry wrong username or password found');
            }
        }

        $this->load->view('admin/login', $data);
    }

    public function sendPassword() {
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $success = $this->Model_admin->sendPassword();
            if ($success) {
                $result['success'] = "Your password has been sent to mentioned email address";
            } else {
                $result['error'] = "Sorry this email does not exist in database !";
            }
        } else {
            $result['error'] = validation_errors();
        }

        echo json_encode($result);
    }

}

/*
  .::File Details::.
  End of file auth.php
  Created By : Jaswant Singh
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  Location: ./application/Controllers/auth.php
  Created At : 15 Nov, 2013  2:06:12 PM
 */
?>