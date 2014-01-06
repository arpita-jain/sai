<?php

/*
 * Class Description
 * Project Name: wegottickets
 * Class name : Model_kiosk
 * File name model_kiosk.php
 */

class Model_kiosk extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('email');
    }

    public function addtobasket() {
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        $eventid = $_REQUEST['eventid'];
        $venueid = $_REQUEST['venueid'];
        $price = $_REQUEST['price'];
        $ticketdata = array(
            'event_id' => $eventid,
            'ticket_id' => $_REQUEST['ids'],
            'venue_id' => $venueid,
            'price' => $price,
        );
      $this->session->set_userdata($ticketdata);
      return $ticketdata;
    }

}

/*
  .::File Details::.
  End of file admin_ajax.php
  Created By : Mayank awasthi
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  Location: ./application/Model/admin_kiosk.php
  Created At : 30 Nov, 2013  5:45:10 PM
 */
?>
