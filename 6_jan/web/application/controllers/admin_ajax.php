<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Class Description
 * Project Name: wegottickets
 * Class name : admin_ajax
 * File name admin_ajax.php
 */

class Admin_ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->model('Model_admin');
        $this->load->model('Model_KioskLibraries');
        $this->isLoggedIn();
    }

    public function isLoggedIn() {
        if ($this->session->userdata('admin_logged_in') != TRUE) {
            redirect("auth");
        }
    }

    ///Admin Actions
    public function delAdmins() {
        echo $this->Model_admin->delAdmins();
    }

    public function viewAdmin() {
        echo $this->Model_admin->viewAdmin();
    }

    public function updateKiosk() {
        $this->form_validation->set_rules('kiosk_name', 'Kiosk Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('upd_id', 'Update ID', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        $foo = 0;
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->updateKiosk();
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }

        echo json_encode($result);
    }

    public function addKiosk() {
        $this->form_validation->set_rules('kiosk_name', 'Kiosk Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->addKiosk();
        } else {
            $foo = 0;
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }

        echo json_encode($result);
    }

    public function addAdmin() {
        $this->form_validation->set_rules('username', 'Username name', 'required');
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->addAdmin();
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }

        echo json_encode($result);
    }

    public function editAdmin() {
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('id', 'ID', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->editAdmin();
        }

        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }
        echo json_encode($result);
    }

    //End of Admin actions
    ///Master Actions
    public function delMasters() {
        echo $this->Model_admin->delMasters();
    }

    public function viewMaster() {
        echo $this->Model_admin->viewMaster();
    }

    public function addMaster() {
        $this->form_validation->set_rules('username', 'User name', 'required');
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->addMaster();
        }

        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }

        echo json_encode($result);
    }

    public function editMaster() {
        $this->form_validation->set_rules('username', 'User name', 'required');
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('id', 'ID', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->editMaster();
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }

        echo json_encode($result);
    }

    //End of Master actions
    ///Supervisors Actions
    public function delSupervisors() {
        echo $this->Model_admin->delSupervisors();
    }

    public function viewSupervisor() {
        echo $this->Model_admin->viewSupervisor();
    }

    public function addSupervisor() {
        $this->form_validation->set_rules('username', 'User name', 'required');
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $foo = "";
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->addSupervisor();
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }

        echo json_encode($result);
    }

    public function editSupervisor() {
        $this->form_validation->set_rules('username', 'User name', 'required');
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('id', 'ID', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->editSupervisor();
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error:" . validation_errors();
        }

        echo json_encode($result);
    }

    //Add Group-
    public function addGroup() {
        $this->form_validation->set_rules('group_name', 'Group name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('supervisor', 'Supervisor', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');

        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->addGroup();
        } else {
            $foo = 0;
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error: " . validation_errors();
        }
        echo json_encode($result);
    }

    //Edit Group-
    public function editGroup() {
        $this->form_validation->set_rules('group_name', 'Group name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('supervisor', 'Supervisor', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('upd_id', 'ID', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->editGroup();
        } else {
            $foo = 0;
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error: " . validation_errors();
        }
        echo json_encode($result);
    }

    //View Group- created by arpita
    public function viewGroup() {
        $result1 = $this->Model_admin->viewGroup($this->input->post('id'));
        echo json_encode($result1);
    }

    //View Group- created by arpita
    public function viewKiosk() {
        $result = $this->Model_admin->viewKiosk($this->input->post('id'));
        echo json_encode($result);
    }

    //Delete Supervisors-
    public function delGroup() {
        echo $this->Model_admin->delGroup();
    }

    ///Users Actions
    public function delUsers() {
        echo $this->Model_admin->delUsers();
    }

    public function viewUser() {
        echo $this->Model_admin->viewUser();
    }

    //View Event Detail By Id
    public function ViewDetail() {
        $result = $this->Model_admin->viewEventDetail($this->input->post('eventId'));
        echo json_encode($result);
    }

    //View Assigned Supervisor LIst
    public function AsignedSupervisor() {
        $result = $this->Model_admin->AssignedSupervisor($this->input->post('Id'));
        echo json_encode($result);
    }

    public function addUser() {
        $foo = "";
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        $this->form_validation->set_rules('username', 'User name', 'required');
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->addUser();
        }

        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }

        echo json_encode($result);
    }

    public function addcustomer() {
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile');
        $this->form_validation->set_rules('housenumber', 'House Number', 'required');
        $this->form_validation->set_rules('street', 'Street', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('county', 'county', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('postcode', 'Postcode', 'required');
        //if ($this->form_validation->run() === TRUE) {
        $result = "test";
        //}

        echo json_encode($result);
    }

    public function editUser() {
        $this->form_validation->set_rules('username', 'User name', 'required');
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('id', 'ID', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            $foo = $this->Model_admin->editUser();
        }
        if (trim($foo) == 1) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }

        echo json_encode($result);
    }

    //End of Users actions
    //start admin profile
    public function editprofile() {
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            echo $this->Model_admin->editProfile();
        } else {
            $result['error'] = validation_errors();
        }
        redirect(site_url() . "admin/index");
        echo $result;
    }

    //end admin profile
    // set user status ---------
    public function setuserstatus() {

        if ($_REQUEST['id'] != "" && $_REQUEST['status'] != "") {
            $status = $this->Model_admin->setuserstatus();
        }
        echo json_encode($status);
    }

    public function setAdminStatus() {

        if ($_REQUEST['id'] != "" && $_REQUEST['status'] != "") {
            $status = $this->Model_admin->setAdminStatus();
        }
        echo json_encode($status);
    }

    public function addtobasket() {
        echo $this->Model_admin->addtobasket();
    }

    public function clear_basket() {
        $this->session->unset_userdata('ticket_id');
        $this->session->unset_userdata('event_id');
        $this->session->unset_userdata('venue_id');
        $this->session->unset_userdata('price');
        redirect(site_url() . "admin/basket");
    }

    // for mail to customer  //
    public function MailToCustomer() {
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $result = array();
        $result['success'] = "";
        if ($this->form_validation->run() === TRUE) {

            $this->email->from('support@cisinlabs.com', 'Jaswant Singh Jatav');
            $this->email->to($this->input->post('email'));
            $this->email->subject($this->input->post('subject'));
            $this->email->message("<div style='padding:5px 10px ; border:1px dashed #fff; background:#39F; font:12px Arial, Helvetica, sans-serif; color:#fff;'>
            <p><strong>Dear Applicant,</strong></p>            
             '" . $this->input->post('message') . "'           
            <p><strong>Admin,Wegotticket.com</strong></p>
            </div>");
            $this->email->send();
            $result['success'] = "Mail send successfully";
        }
        echo json_encode($result);
    }

// for display customer information purchase by ticket //
    public function viewCustomer() {
        echo $this->Model_admin->viewCustomer();
    }

    // for create kiosk group  //    
    public function assignGroup() {
        echo $this->Model_admin->assignGroup();
    }

// for show customer information //
    public function CustomerInfo() {
        echo $this->Model_admin->CustomerInfo();
    }

    public function editCustomer() {
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('housenumber', 'House Number', 'required');
        $this->form_validation->set_rules('street', 'Street', 'required');
        $this->form_validation->set_rules('county', 'County', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('postcode', 'Postcode', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('id', 'ID', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($this->form_validation->run() === TRUE) {
            echo $this->Model_admin->editCustomer();
        } else {
            $result['error'] = validation_errors();
        }
        echo json_encode($result);
    }

    // for unassignGroup .//  
    public function unassignGroup() {
        echo $this->Model_admin->unassignGroup();
    }

    //Update all tables -created by jaswant
    public function updateDataTables() {
        $this->Model_KioskLibraries->reFillDataTables();
    }

    //Update tickets tables -created by jaswant
    public function updateStockPrice() {
        $this->Model_KioskLibraries->updateStockPrice();
    }

    // update basket  quantity  //
    // update basket  quantity  //
    public function updatequantity() {
        $updquantity = $this->Model_admin->updatequantity();       
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($updquantity) {
            $result['success'] = "Successfully";
        } else {
            $result['error'] = "Error";
        }
        echo json_encode($result);
    }

    // delete kiosk group //
    public function delKiosks() {
        echo $this->Model_admin->delKiosks();
    }

    public function setkioskstatus() {
        if ($_REQUEST['id'] != "" && $_REQUEST['status'] != "") {
            $status = $this->Model_admin->setkioskstatus();
        }
        echo json_encode($status);
    }
    public function setgroupstatus() {
        if ($_REQUEST['id'] != "" && $_REQUEST['status'] != "") {
            $status = $this->Model_admin->setgroupstatus();
        }
        echo json_encode($status);
    }

     //Show Event Detail With tickets on More
    public function getTicketByEventId() {        
        echo $this->Model_admin->getTicketByEventId();

    }

}

/*
  .::File Details::.
  End of file admin_ajax.php
  Created By : Mayank awasthi
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  Location: ./application/Controllers/admin_ajax.php
  Created At : 15 Nov, 2013  1:45:20 PM
 */
?>

