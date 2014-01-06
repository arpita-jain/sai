<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Class Description
 * Project Name: wegottickets
 * Class name : admins
 * File name admins.php
 */

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Model_admin');
        $this->load->model('Model_KioskLibraries');
        $this->load->helper('cookie');
        $this->isLoggedIn();
        $this->setTotalItems();
    }

    public function isLoggedIn() {
        if ($this->session->userdata('admin_logged_in') != TRUE) {
            redirect("auth");
        }
    }

    public function setTotalItems() {
        $row = $this->Model_admin->getTotalItems();
        $this->session->set_userdata('totalitems', $row[0]['totalitems']);
    }

    public function clearcart() {
        $this->Model_admin->clearcart();
        redirect("admin/tickets");
    }

    public function removeitem($id) {
        $this->Model_admin->removeitem($id);
        redirect("admin/basket");
    }

    public function index() {
        $data['users'] = $this->Model_admin->getStatistics();
        $this->load->view('admin/header');
        if ($this->session->userdata('admin_type') == 4) {
            redirect("admin/tickets");
        } else {
            $this->load->view('admin/dashboard', $data);
        }
        $this->load->view('admin/footer');
    }

    public function emailticket($id, $sec) {
        $newsec = md5($id . "jaswant.s@cisinlabs.com");
        if ($newsec == $sec) {
            $this->load->library('mPDF');
            $data['ticketinfo'] = $this->Model_admin->getTicketInfo($id);
            $html = "";
            foreach ($data['ticketinfo']['itemsinfo'] as $item) {
                $temp = array();
                $temp['ticketinfo']['itemsinfo'] = $item;
                $temp['ticketinfo']['customerinfo'] = $data['ticketinfo']['customerinfo'];
                $temp['ticketinfo']['orderinfo'] = $data['ticketinfo']['orderinfo'];
                $html.= $this->load->view('admin/ticket', $temp, true);
            }
            $stylesheet = file_get_contents(base_url() . 'assets/admin/css/style.css');
            $this->mpdf->WriteHTML($stylesheet, 1);
            $this->mpdf->WriteHTML($html, 2);
            $this->mpdf->Output("assets/files/Ticket_" . $id . ".pdf");
            $this->load->library('email');
            $this->email->from('jaswant.s@cisinlabs.com', 'Cyber infrastructure');
            $this->email->to($data['ticketinfo']['customerinfo']['email']);
            $this->email->subject('Event Ticket');
            $this->email->message('Please find your ticket and present at the time of event with ticket.');
            $this->email->attach("assets/files/Ticket_" . $id . ".pdf");
            if ($this->email->send()) {
                $this->session->set_userdata("success_ack", "Thanks your ticket for reserved event has been sent to your email");
            } else {
                $this->session->set_userdata("error_ack", "Sorry ticket could not be email, please try again");
            }
            redirect("admin");
        } else {
            redirect("admin/tickets");
        }
    }

    public function downloadticket($id, $sec) {
        $newsec = md5($id . "jaswant.s@cisinlabs.com");
        if ($newsec == $sec) {
            $this->load->library('mPDF');
            $data['ticketinfo'] = $this->Model_admin->getTicketInfo($id);
            $html = "";
            foreach ($data['ticketinfo']['itemsinfo'] as $item) {
                $temp = array();
                $temp['ticketinfo']['itemsinfo'] = $item;
                $temp['ticketinfo']['customerinfo'] = $data['ticketinfo']['customerinfo'];
                $temp['ticketinfo']['orderinfo'] = $data['ticketinfo']['orderinfo'];
                $html.= $this->load->view('admin/ticket', $temp, true);
            }
            $stylesheet = file_get_contents(base_url() . 'assets/admin/css/style.css');
            $this->mpdf->WriteHTML($stylesheet, 1);
            $this->mpdf->WriteHTML($html, 2);
            $this->mpdf->Output($data['ticketinfo']['orderinfo']['order_id'] . ".pdf", "D");
        } else {
            redirect("admin/tickets");
        }
    }

    public function printoneticket($id, $transaction_id, $sec) {
        $newsec = md5($id . $transaction_id);
        if ($newsec == $sec) {
            $this->load->library('mPDF');
            $data['ticketinfo'] = $this->Model_admin->getOneTicketInfo($id, $transaction_id);
            $html = "";
            foreach ($data['ticketinfo']['itemsinfo'] as $item) {
                $temp = array();
                $temp['ticketinfo']['itemsinfo'] = $item;
                $temp['ticketinfo']['customerinfo'] = $data['ticketinfo']['customerinfo'];
                $temp['ticketinfo']['orderinfo'] = $data['ticketinfo']['orderinfo'];
                $html.= $this->load->view('admin/ticket', $temp, true);
            }
            $stylesheet = file_get_contents(base_url() . 'assets/admin/css/style.css');
            $this->mpdf->WriteHTML($stylesheet, 1);
            $this->mpdf->WriteHTML($html, 2);
            $this->mpdf->Output();
        } else {
            redirect("admin/tickets");
        }
    }

    public function printticket($id, $sec) {
        $newsec = md5($id . "jaswant.s@cisinlabs.com");
        if ($newsec == $sec) {
            $this->load->library('mPDF');
            $data['ticketinfo'] = $this->Model_admin->getTicketInfo($id);
            $html = "";
            foreach ($data['ticketinfo']['itemsinfo'] as $item) {
                $temp = array();
                $temp['ticketinfo']['itemsinfo'] = $item;
                $temp['ticketinfo']['customerinfo'] = $data['ticketinfo']['customerinfo'];
                $temp['ticketinfo']['orderinfo'] = $data['ticketinfo']['orderinfo'];
                $html.= $this->load->view('admin/ticket', $temp, true);
            }
            $stylesheet = file_get_contents(base_url() . 'assets/admin/css/style.css');
            $this->mpdf->WriteHTML($stylesheet, 1);
            $this->mpdf->WriteHTML($html, 2);
            $this->mpdf->Output();
        } else {
            redirect("admin/tickets");
        }
    }

    public function viewticket($id, $sec) {
        $newsec = md5($id . "jaswant.s@cisinlabs.com");
        if ($newsec == $sec) {
            $data['ticketinfo'] = $this->Model_admin->getTicketInfo($id);
            $this->load->view('admin/invoice', $data);
        } else {
            redirect("admin/tickets");
        }
    }

    public function administrators() {
        if ($this->session->userdata("admin_type") > 0) {
            redirect("admin");
        }
        $data['admins'] = $this->Model_admin->getAdmins();
        $this->load->view('admin/header');
        $this->load->view('admin/admins', $data);
        $this->load->view('admin/footer');
    }

    public function supervisors() {
        if ($this->session->userdata("admin_type") > 2) {
            redirect("admin");
        }
        $data['admins'] = $this->Model_admin->getSupervisors();
        $this->load->view('admin/header');
        $this->load->view('admin/supervisors', $data);
        $this->load->view('admin/footer');
    }

    public function addkiosk() {
        $this->form_validation->set_rules('kiosk_name', 'Kiosk Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        if ($this->form_validation->run() === TRUE) {
            $this->Model_admin->addKiosk();
        }
        redirect("admin/kiosks");
    }

    public function kiosks() {

        if ($this->session->userdata("admin_type") > 3) {
            redirect("admin");
        }
        $data['kiosks'] = $this->Model_admin->getKiosks();
        $this->load->view('admin/header');
        $this->load->view('admin/kiosks', $data);
        $this->load->view('admin/footer');
    }

    public function kioskgroups() {
        if ($this->session->userdata("admin_type") > 2) {
            redirect("admin");
        }
        $data['admins'] = $this->Model_admin->getSupervisors();
        $data['groups'] = $this->Model_admin->getAllGroups();
        $this->load->view('admin/header');
        $this->load->view('admin/kioskgroup', $data);
        $this->load->view('admin/footer');
    }

    public function viewEventDetail() {
        $data['test'] = $_REQUEST['id'];
        $this->load->view('admin/header');
        $this->load->view('admin/events', $data);
        $this->load->view('admin/footer');
    }

    public function masters() {
        if ($this->session->userdata("admin_type") > 1) {
            redirect("admin");
        }
        $data['admins'] = $this->Model_admin->getMasters();
        $this->load->view('admin/header');
        $this->load->view('admin/masters', $data);
        $this->load->view('admin/footer');
    }

    public function users() {
        if ($this->session->userdata("admin_type") > 3) {
            redirect("admin");
        }
        $data['admins'] = $this->Model_admin->getUsers();
        $this->load->view('admin/header');
        $this->load->view('admin/users', $data);
        $this->load->view('admin/footer');
    }

    public function assignedkiosks($id = 0, $sec) {

        $newsec = md5($id . "jaswant.s@cisinlabs.com");
        if ($newsec == $sec) {

            if ($this->session->userdata("admin_type") > 3) {
                redirect("admin");
            }

            if (isset($_POST['kiosks'])) {
                $this->Model_admin->removeKiosks($_POST['kiosks'], $id);
            }

            $data['kiosks'] = $this->Model_admin->getAssignedKiosks($id);
            $data['group_id'] = $id;
            $this->load->view('admin/header');
            $this->load->view('admin/assigned', $data);
            $this->load->view('admin/footer');
        } else {
            redirect("admin/kioskgroups");
        }
    }

    public function unassignedkiosks($id = 0, $sec) {
        $newsec = md5($id . "jaswant.s@cisinlabs.com");
        if ($newsec == $sec) {
            if ($this->session->userdata("admin_type") > 3) {
                redirect("admin");
            }

            if (isset($_POST['kiosks'])) {
                $this->Model_admin->setKiosks($_POST['kiosks'], $id);
            }

            $data['kiosks'] = $this->Model_admin->getUnassignedKiosks($id);
            $data['group_id'] = $id;
            $this->load->view('admin/header');
            $this->load->view('admin/unassigned', $data);
            $this->load->view('admin/footer');
        } else {
            redirect("admin/kioskgroups");
        }
    }

    public function adminprofile() {
        $data['profile'] = $this->Model_admin->getAdminprofile();
        $this->load->view('admin/header');
        $this->load->view('admin/profile', $data);
        $this->load->view('admin/footer');
    }

    public function logout() {
        $this->Model_admin->clearcart();
        $newdata = array(
            'admin_id' => '',
            'admin_firstname' => '',
            'admin_lastname' => '',
            'admin_email' => '',
            'admin_logged_in' => FALSE,
            'admin_type' => ''
        );
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect("auth");
    }

    public function basket() {
        $data = array('');
        $data['basket'] = $this->Model_admin->getBasketItems();
        $this->load->view('admin/header');
        $this->load->view('admin/basket', $data);
        $this->load->view('admin/footer');
    }

    public function customers() {
        $data['customers'] = $this->Model_admin->getOrdersinfo();
        $this->load->view('admin/header');
        $this->load->view('admin/customer', $data);
        $this->load->view('admin/footer');
    }

    public function placeOrder() {
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile');
        $this->form_validation->set_rules('housenumber', 'House Number', 'required');
        $this->form_validation->set_rules('street', 'Street', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('postcode', 'Postcode', 'required');
        if ($this->form_validation->run() === TRUE) {
            $transactionId = $this->Model_admin->placeOrder();
            $items = $this->Model_admin->getBasket();

            try {
                $this->Model_KioskLibraries->reserveTickets($transactionId, $items);
            } catch (Exception $ex) {
                $this->session->set_userdata("error_ack", "Reservation Error:-" . $ex->getMessage());
                redirect("admin");
            }
            try {
                $this->Model_KioskLibraries->transactTickets($transactionId, $items);
                $this->Model_admin->clearcart();
            } catch (Exception $ex) {
                $this->session->set_userdata("error_ack", "Transaction Error:-" . $ex->getMessage());
                redirect("admin");
            }

            $sec = md5($transactionId . "jaswant.s@cisinlabs.com");
            redirect('admin/viewticket/' . $transactionId . "/" . $sec);
        } else {
            redirect("admin/basket");
        }
    }

    public function checkout() {
        if (isset($_POST['tickets'])) {
            $data['tickets'] = $this->Model_admin->getTicketsByid($this->input->post('tickets'));
            $data['qty'] = $this->input->post('qty');
            $this->Model_admin->updateBasket();
            $this->load->view('admin/header');
            $this->load->view('admin/checkout', $data);
            $this->load->view('admin/footer');
        } else {
            redirect("admin/basket");
        }
    }

    public function order($id = 0) {
        if ($id != "") {
            $data['order'] = $this->Model_admin->getCustomerOrder($id);
            $this->load->view('admin/header');
            $this->load->view('admin/order', $data);
            $this->load->view('admin/footer');
        }
    }

    // get all orderbyTickets  //  
    public function ordertickets($id, $sec) {
        $newsec = md5($id . "jaswant.s@cisinlabs.com");
        if ($newsec == $sec) {
            $data['ordertickets'] = $this->Model_admin->getOrdertickets($id);
            $this->load->view('admin/header');
            $this->load->view('admin/ordertickets', $data);
            $this->load->view('admin/footer');
        } else {
            redirect("admin/tickets");
        }
    }

//Get all event - created by jaswant
    public function events() {
        $data['events'] = $this->Model_admin->getAllEvents();
        $this->load->view('admin/header');
        $this->load->view('admin/events', $data);
        $this->load->view('admin/footer');
    }

//Get all venues - created by jaswant
    public function venues() {
        $data['venues'] = $this->Model_admin->getAllVenues();
        $this->load->view('admin/header');
        $this->load->view('admin/venues', $data);
        $this->load->view('admin/footer');
    }

//Get all tickets - created by jaswant
    public function tickets() {
        $data['tickets'] = $this->Model_admin->getAllTickets();
        $this->load->view('admin/header');
        $this->load->view('admin/tickets', $data);
        $this->load->view('admin/footer');
    }

    public function refund($transactionId, $sec) {
        $newsec = md5($transactionId . "jaswant.s@cisinlabs.com");
        if ($newsec == $sec) {
            $items = $this->Model_admin->getrefundvalues($transactionId);
            try {
                $this->Model_KioskLibraries->refundTickets($transactionId, $items);
                $this->session->set_userdata("success_ack", "Your request to refund ticket order has been sent..");
            } catch (Exception $ex) {
                $this->session->set_userdata("error_ack", "Refund Ticket Error:-" . $ex->getMessage());
            }
            redirect("admin");
        } else {
            redirect("admin/tickets");
        }
    }

    public function refundoneticket($ticketid, $transactionId, $sec) {
        $newsec = md5($ticketid . $transactionId);
        if ($newsec == $sec) {
            $item = $this->Model_admin->getonerefundvalue($transactionId, $ticketid);
            try {
                $this->Model_KioskLibraries->refundOneTicket($transactionId, $item);
                $this->session->set_userdata("success_ack", "Your request to refund ticket order has been sent..");
            } catch (Exception $ex) {
                $this->session->set_userdata("error_ack", "Refund Ticket Error:-" . $ex->getMessage());
            }
            redirect("admin");
        } else {
            redirect("admin/tickets");
        }
    }

    function kiosks_report() {

        $kiosksTokan = $this->uri->segment(3); //die("Testing......");
        $data['kioskReport'] = $this->Model_admin->getGroupsTickets($kiosksTokan);
        $this->load->view('admin/header');
        $this->load->view('admin/kiosks_report', $data);
        $this->load->view('admin/footer');
    }

    function order_detail() {
        $order_id = $this->uri->segment(3);
        $data['orderDetail'] = $this->Model_admin->getOrderdTickets($order_id);
        $this->load->view('admin/header');
        $this->load->view('admin/order_detail', $data);
        $this->load->view('admin/footer');
    }

    public function printticketquantity($id, $sec) {   
        $newsec = md5($id .     $id);        
        if ($newsec == $sec) {
            $this->load->library('mPDF');
            $data['tickequantity'] = $this->Model_admin->getTicketquantity($id);           
            $html = "";
            foreach ($data['tickequantity'] as $item) {                
                $temp = array();
                $temp['tickequantity']= $item;               
                $html.= $this->load->view('admin/ticketlist', $temp, true);
            }
            $stylesheet = file_get_contents(base_url() . 'assets/admin/css/style.css');
            $this->mpdf->WriteHTML($stylesheet, 1);
            $this->mpdf->WriteHTML($html, 2);
            $this->mpdf->Output();
        } else {
            redirect("admin/tickets");
        }
    }

     public function kioskgroupsReport(){
	$group_id = $this->uri->segment(3);
        $data['groupReport'] = $this->Model_admin->getkioskgroupsOrder($group_id);
	$this->load->view('admin/header');
        $this->load->view('admin/kioskgroup_detailz', $data);
        $this->load->view('admin/footer');
     }

}

/*
  .::File Details::.
  End of file admins.php
  Created By : Mayank Awasthi
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  Location: ./application/Controllers/admins.php
  Created At : 15 Nov, 2013  1:45:20 PM
 */
?>
