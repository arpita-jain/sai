<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Class Description
 * Project Name: wegottickets
 * Class name : testcontroller
 * File name testcontroller.php
 */

class Kiosklogin extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('Model_admin');
        $this->load->model('Model_KioskLibraries');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->database();
        $this->load->model('Model_site');
        $this->isLoggedIn();
    }

    public function isLoggedIn() {
        if ($this->session->userdata('admin_logged_in') === TRUE) {
            redirect("kiosk");
        }
    }

    public function testlib() {
        
        $data = $this->Model_KioskLibraries->getAllEvents();
        print_r($data['events']).'<br>';
        
    }

    public function index() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $data = array();
        if ($this->form_validation->run() === TRUE) {
            $login = $this->Model_site->logged_in();
            if (count($login) > 0) {
                $newdata = array(
                    'admin_id' => $login['id'],
                    'admin_firstname' => $login['first_name'],
                    'admin_email' => $login['email'],
                    'admin_logged_in' => TRUE,
                    'admin_type' => $login['user_type'],
                );
                $this->session->set_userdata($newdata);
                $this->Model_admin->setLastLogin();
                $this->Model_admin->setRememberMe();
                redirect("kiosk");
            } else {

                $this->session->set_userdata('loginerror', 'Sorry wrong username or password found');
            }
        }

        $this->load->view('site/login', $data);
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
  End of file Kiosklogin.php
  Created By : Mayank Awasthi
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  Location: ./application/Controllers/Kiosklogin.php
  Created At : 15 Nov, 2013  7:48:00 PM
 */
?>