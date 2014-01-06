<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Class Description
 * Project Name: wegottickets
 * Class name : Kiosk
 * File name kiosk.php
 */

class Kiosk extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Model_KioskLibraries');
        $this->load->model('Model_kiosk');
        $this->isLoggedIn();
    }

    public function isLoggedIn() {
        if ($this->session->userdata('admin_logged_in') != TRUE) {
            redirect("kiosklogin");
        }
    }

    public function index() {
        $data['title'] = "Home | WeGotTickets";
        //For Total No of Events
        $data = $this->Model_KioskLibraries->getTicketById();
        $data['event'] = $data;
        foreach($data['event'] as $event)
        {
            $event_id[]= $event['eventId'];
            
        }
        $event_count['event_count']=count($event_id);
        $this->session->set_userdata($event_count);
        $data['venue'] = $this->Model_KioskLibraries->getAllVenues();
        foreach($data['venue'] as $venue)
        {
            $venue_id[]= $venue['id'];
        }
        $venue_count['venue_count']=count(array_unique($venue_id));
        $this->session->set_userdata($venue_count);
        $this->load->view('site/home', $data);
    }
    
    //Showing All Event Dates
    public function event_dates() {
        $data['title'] = "Events | WeGotTickets";
        $data = $this->Model_KioskLibraries->geteventDate();       
        $data['tickete'] = ($data);   
        foreach($data['tickete'] as $row)
        {
          $date[]=$row['date'];
        }
        $data['eventdate']=array_unique($date);
        $this->load->view('site/eventDate', $data);
    }

    //Showing All Events
    public function events() {
        $data['title'] = "Events | WeGotTickets";
        $data = array();
        $data = $this->Model_KioskLibraries->getTicketById();
        $data['event'] = $data;
        $this->load->view('site/event', $data);
    }

    //Showing All Venues
    public function venues() {
        $data['title'] = "Venues | WeGotTickets";
        $data = array();
        $data = $this->Model_KioskLibraries->getAllVenues();
        $data['tickete'] = $data;
        
        $sort= array();
        foreach ($data['tickete'] as $key => $val)
        {
            $sort[] = $val['name'];
        } 
        array_multisort($sort,$data['tickete']);

        $this->load->view('site/venues', $data);
    }

    //Showing Tickets With All Filters
    public function ticket() {
        $data['title'] = "Ticket | WeGotTickets";
        $eventsdate_chk = "";
        $venue_chk = "";
        $event_chk = "";
        $eventsdate_chk = $this->session->userdata('eventdate');
        $venue_chk = $this->session->userdata('venueId');
        $event_chk = $this->session->userdata('eventId');
        $ticketsData = array();
        $data = array();
        $NoOfCount = array();
        $i = 0;
        $data = $this->Model_KioskLibraries->getTicketById();
        $events = array();
        if (!$event_chk && !$venue_chk && !$eventsdate_chk) {
            foreach ($data as $row) {
                $events[] = $row;
            }
        } else {

            foreach ($data as $row) {
                //If all filters as set
                if ($event_chk && $venue_chk && $eventsdate_chk) {
                    if (in_array($row['date'], $eventsdate_chk) && in_array($row['eventId'], $event_chk) && in_array($row['venueId'], $venue_chk)) {
                        $events[] = $row;
                        
                    }
                } elseif ($eventsdate_chk && $event_chk) {

                    //If date and event filters set
                    if (in_array($row['date'], $eventsdate_chk) && in_array($row['eventId'], $event_chk)) {
                        $events[] = $row;
                    }
                } elseif ($eventsdate_chk && $venue_chk) {
                    //If data and vanue filters set
                    if (in_array($row['date'], $eventsdate_chk) && in_array($row['venueId'], $venue_chk)) {
                        $events[] = $row;
                    }
                } elseif ($event_chk && $venue_chk) {

                    //If event and venue filters set
                    if (in_array($row['eventId'], $event_chk) && in_array($row['venueId'], $venue_chk)) {
                        $events[] = $row;
                    }
                } elseif ($eventsdate_chk) {

                    //If date filter set
                    if (in_array($row['date'], $eventsdate_chk)) {
                        $events[] = $row;
                    }
                } elseif ($event_chk) {

                    //If event filter set
                    if (in_array($row['eventId'], $event_chk)) {
                        $events[] = $row;
                    }
                } elseif ($venue_chk) {

                    //If venue filter set
                    if (in_array($row['venueId'], $venue_chk)) {
                        $events[] = $row;
                    }
                }
            }
        }

        $eventData['events'] = $events;
        $this->load->view('site/ticket', $eventData);
    }


//Showing Tickets in basket
    public function basket() {
        $data['title'] = "Basket | WeGotTickets";
        if ($this->session->userdata('ticket_id') != "") {
            $basket = $this->session->userdata('ticket_id');
            $data = $this->Model_KioskLibraries->addTickettoBasket($basket);
            $data['basket'] = $data;
        }

        $this->load->view('site/basket', $data);
    }

    //For CheckOut
    public function checkout() {
        $data['title'] = "Check Out | WeGotTickets";
        if ($this->session->userdata('ticket_id') != "") {
            $datacheckout = $this->Model_KioskLibraries->checkoutProcess();
            $data['basket'] = $datacheckout;
        }
        $this->load->view('site/checkout', $data);
    }

    public function customerOrder() {
        $data['title'] = "Customer Order | WeGotTickets";
        $data['order']=$this->Model_KioskLibraries->getCustomerinfo();
        $this->load->view('site/customerorder',$data);
    }

    public function Admin() {
        $data['title'] = "Admin | WeGotTickets";
        $this->load->view('site/adminscreen');
    }
    
    

    public function Delivery() {
        $data['title'] = "Ticket Delivery | WeGotTickets";
        if ($this->session->userdata('ticket_id') != "") {
            $datacheckout = $this->Model_KioskLibraries->checkoutProcess();
            $data['basket'] = $datacheckout;
        }
        $this->load->view('site/ticketdelivery', $data);
    }

    public function OrderDetail() {
       $data['title'] = "Ticket Order | WeGotTickets";
       $customer_id=$_REQUEST['id'];
       $data['order']=$this->Model_KioskLibraries->getOrderDetail($customer_id);
       $this->load->view('site/ticket_order_detail',$data);
    }
    
    //For Print ticket
     public function printTicket($id=0) {
        $data['title'] = "PrintTicket | WeGotTickets";
        $orders = array();
        $customer_id=$id;
        $data['order']=$this->Model_KioskLibraries->getOrderDetail($customer_id);
        foreach($data['order'] as $row)
        {
             foreach($row['tickets'] as $tickete)
                    {
                     $event_id[]=$tickete['event_id'];
                     $venue_id[]=$tickete['venue_id'];
                    }
        }
         $kioskdata = $this->Model_KioskLibraries->getTicketById();
         foreach ($kioskdata as $row) {
              if (in_array($row['eventId'], $event_id)) {
                  $orders[]= $row['event_name'];
                  $orders[]= $row['vanu_name'];
              }
         }
         $data['orderData']=$orders;
         $data['orderData']=$data['order'];
         $this->load->view('site/printticket',$data);
    }
    
    //Send Email to customer 
    public function CustomerEmail() {
        $data['title'] = "Ticket Order | WeGotTickets";
        $customer_id=$_REQUEST['Id'];
        $result ="Your Email has been sent successfully";
        $data['order']=$this->Model_KioskLibraries->getOrderDetail($customer_id);
        foreach ($data['order'] as $row)
        {
            $email=$row['email'];
        }
        $this->load->library('email');
        $this->email->from('your@example.com', 'Your Name');
        $this->email->to('$email');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->send();
        echo json_encode($result);
    }
    
    //Refund Tickets
    public function RefundTickets() {
       $data['title'] = "Ticket Order | WeGotTickets";
       $result ="Your Email has been sent successfully";
       $Items=$_REQUEST['items'];
       $transactionId=$_REQUEST['Id'];
       $data['order']=$this->Model_KioskLibraries->refundTickets($transactionId, $Items);
      echo json_encode($result);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect("kiosklogin");
    }

    public function addtobasket() {
        $result = array();
        $foo = $this->Model_kiosk->addtobasket();
        if ($foo != "") {
            $result['success'] = $foo;
        }
        echo json_encode($result);
    }

    public function clear_basket() {
        $this->session->unset_userdata('ticket_id');
        $this->session->unset_userdata('event_id');
        $this->session->unset_userdata('venue_id');       
        redirect(site_url() . "kiosk/basket");
    }

    public function addFiltersByDate() {
        $data = array();
        $data['eventdate'] = $_REQUEST['eventdate'];
        $this->session->set_userdata($data);
         echo json_encode($data);
    }

    public function addFiltersByVenue() {
        $data = array();
        $data['venueId'] = $_REQUEST['venueId'];
        $this->session->set_userdata($data);
    }

    public function addFiltersByEvent() {
        $data = array();
        $data['eventId'] = $_REQUEST['eventId'];
        $this->session->set_userdata($data);
    }

    public function removeFiltersByVenue() {
        $data = array();
        $data['venueId'] = $this->session->set_userdata('venueId');
        $this->session->unset_userdata($data);
        redirect("kiosk/venues");
    }

    public function removeFiltersByDate() {
        $data = array();
        $data['eventdate'] = $this->session->set_userdata('eventdate');
        $this->session->unset_userdata($data);
        redirect("kiosk/event_dates");
    }

    public function removeFiltersByEvent() {
        $data = array();
        $data['eventId'] = $this->session->set_userdata('eventId');
        $this->session->unset_userdata($data);
        redirect("kiosk/events");
    }

    public function addTicketToBasket() {
        $data = array();
        $data['ticketId'] = $_REQUEST['ticketId'];
        $this->session->set_userdata($data);
    }
    
    //Search by events or venues
    public function searchOnTickets() {
        $data = array();
        $searchval= $_REQUEST['search_text'];
        $input = preg_quote($searchval, '~'); // don't forget to quote input string!
        $data = $this->Model_KioskLibraries->getTicketById();
        foreach ($data as $event) {
        $events[]= $event['event_name'];
        $venues[]= $event['vanu_name'];
        }
        $result1 = preg_grep('~' . $input . '~', $events);
        $result = preg_grep('~' . $input . '~', $venues);
        foreach ($data as $row) {
           if( (in_array($row['event_name'], $result1))|| (in_array($row['vanu_name'], $result)) ) {
                        $eventlist[] = $row;
                    }
       }
      
        $data['events'] = $eventlist;
        $this->load->view('site/ticket', $data);
    }
    
    public function searchOnCustomers() {
        $data = array();
        $searchval= $_REQUEST['search_text'];
        $input = preg_quote($searchval, '~'); // don't forget to quote input string!
        $data['order']=$this->Model_KioskLibraries->getCustomerinfo();
        foreach ( $data['order'] as $row) {
        $fname[]= $row['firstname'];
        $lname[]= $row['lastname'];
        $email[]= $row['email'];
        }
        $result1 = preg_grep('~' . $input . '~', $fname);
        $result2 = preg_grep('~' . $input . '~', $lname);
        $result3 = preg_grep('~' . $input . '~', $email);
        foreach ($data['order'] as $row2) {
           if( (in_array($row2['firstname'], $result1))|| (in_array($row2['lastname'], $result2))|| (in_array($row2['email'], $result3))  ) {
                        $orderData[] = $row2;
                    }
       }
      
        $data['order'] = $orderData;
        $this->load->view('site/customerorder', $data);
    }
}

/*
  .::File Details::.
  End of file kiosk.php
  Created By : Mayank awasthi
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  Location: ./application/Controller/kiosk.php
  Created At : 25 Nov, 2013  5:45:10 PM
 */
?>