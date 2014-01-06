<?php

/*
 * Class Description
 * Project Name: wegottickets
 * Class name : Model_site
 * File name model_site.php
 */

class Model_site extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('email');
    }
  public function logged_in() {

        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
       // $this->db->where('email', $this->input->post('username'));
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));
        // $this->db->where('user_type', 1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
           return $query->row_array();
        }
    }
}