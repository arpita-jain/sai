<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once '../vendor/autoload.php';

use InternetTickets\WeGotTickets\Api\v1\Client\Kiosk as Kiosk;
use InternetTickets\WeGotTickets\Api\v1\Client;

class Model_KioskLibraries extends CI_Model {

    var $kiosk;

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->kiosk = Kiosk::factory('d85e6abe-f89f-417e-97af-8797d36aacd7', 'MySecret');
    }

    public function getAllData() {
        $data = $this->kiosk->fetchAllData();
        return $data;
    }

    ///Update all tables from api - created by jaswant
    public function updateStockPrice() {

        $this->db->query("CREATE TABLE IF NOT EXISTS `tickettypes` (
          `id` int(10) NOT NULL AUTO_INCREMENT,
          `eventId` int(10) NOT NULL,
          `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `price` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `currency` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `onsale` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `stockUnsold` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `stockAvailable` int(10) NOT NULL,
          `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
        ");

        $this->db->truncate('tickettypes');
        $data = $this->kiosk->fetchAllData();

        //Fill data into tickettypes table
        foreach ($data['tickettypes'] as $tickettypes) {
            $dataz = array(
                'id' => $tickettypes->id(),
                'eventId' => $tickettypes->eventId(),
                'type' => $tickettypes->type(),
                'price' => $tickettypes->price(),
                'currency' => $tickettypes->currency(),
                'onsale' => $tickettypes->onsale(),
                'stockUnsold' => $tickettypes->stockUnsold(),
                'stockAvailable' => $tickettypes->stockAvailable()
            );
            $this->db->insert('tickettypes', $dataz);
        }
    }

    ///Update all tables from api - created by jaswant
    public function reFillDataTables() {

        $this->db->query("CREATE TABLE IF NOT EXISTS `venues` (
          `id` int(10) NOT NULL AUTO_INCREMENT,
          `name` int(11) NOT NULL,
          `address` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
          `town` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `county` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `telephone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
          `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `status` int(1) NOT NULL DEFAULT '1',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");


        $this->db->query("CREATE TABLE IF NOT EXISTS `tickettypes` (
          `id` int(10) NOT NULL AUTO_INCREMENT,
          `eventId` int(10) NOT NULL,
          `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `price` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `currency` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `onsale` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `stockUnsold` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `stockAvailable` int(10) NOT NULL,
          `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
        ");

        $this->db->query("CREATE TABLE IF NOT EXISTS `events` (
          `id` int(10) NOT NULL AUTO_INCREMENT,
          `venueId` int(10) NOT NULL,
          `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
          `status` int(1) NOT NULL DEFAULT '1',
          `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `description` text COLLATE utf8_unicode_ci NOT NULL,
          `time` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `ageLimit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
        ");

        $this->db->truncate('venues');
        $this->db->truncate('events');
        $this->db->truncate('tickettypes');
        $data = $this->kiosk->fetchAllData();


        //Fill data into venues table
        foreach ($this->kiosk->fetchVenues() as $venue) {
            $datax = array(
                'id' => $venue['id'],
                'name' => $venue['name'],
                'address' => json_encode($venue['address']),
                'town' => $venue['town'],
                'county' => $venue['county'],
                'postcode' => $venue['postcode'],
                'country' => $venue['country'],
                'website' => $venue['website'],
                'telephone' => $venue['telephone']
            );
            $this->db->insert('venues', $datax);
        }


        //Fill data into events table
        foreach ($this->kiosk->fetchEvents() as $event) {
            $datay = array(
                'id' => $event['id'],
                'venueId' => $event['venue_id'],
                'title' => $event['title'],
                'status' => $event['status'],
                'date' => $event['date'],
                'description' => $event['description'],
                'time' => $event['time'],
                'ageLimit' => $event['age_limit']
            );
            $this->db->insert('events', $datay);
        }

        //Fill data into tickettypes table
        foreach ($data['tickettypes'] as $tickettypes) {
            $dataz = array(
                'id' => $tickettypes->id(),
                'eventId' => $tickettypes->eventId(),
                'type' => $tickettypes->type(),
                'price' => $tickettypes->price(),
                'currency' => $tickettypes->currency(),
                'onsale' => $tickettypes->onsale(),
                'stockUnsold' => $tickettypes->stockUnsold(),
                'stockAvailable' => $tickettypes->stockAvailable()
            );
            $this->db->insert('tickettypes', $dataz);
        }
    }

    /*
     * input type  array of ticket IDs
     * output  Returns array all tickets for respective ticket ids
     */

    public function fetchTicketTypes($ticketTypeIds = array()) {
        $data = $this->kiosk->fetchTicketTypes($ticketTypeIds);
        return $data;
    }

    public function releaseTickets($id) {
        $data = $this->kiosk->releaseTickets($id);
        return $data;
    }

    public function getAllVenues() {
        $data = $this->kiosk->fetchVenues();
        return $data;
    }

    public function reserveTickets($reservationId, $lines) {
        foreach ($lines as $line) {
            $this->load->model('Model_lineitems');
            $this->Model_lineitems->setLine($line);
            $this->kiosk->reserveTickets($reservationId, array($this->Model_lineitems));
        }
    }

    public function refundTickets($transactionId, $Items) {
        foreach ($Items as $line) {
            $this->load->model('Model_lineitems');
            $this->Model_lineitems->setLine($line);
            $this->kiosk->refundTickets($transactionId, array($this->Model_lineitems));
        }
        return true;
    }

    public function refundOneTicket($transaction,$Item) {
        $this->load->model('Model_lineitems');
        $this->Model_lineitems->setLine($Item);
        $this->kiosk->refundTickets($transaction, array($this->Model_lineitems));
        return true;
    }

    public function getAllEvents() {
        $data = $this->kiosk->fetchEvents();
        return $data;
    }

    public function transactTickets($reservationId, $Items) {
        foreach ($Items as $line) {
            $this->load->model('Model_lineitems');
            $this->Model_lineitems->setLine($line);
            $this->kiosk->transactTickets($reservationId, array($this->Model_lineitems));
        }
    }

// for  display ticket accroding to event and venue id 
    public function getTicketById() {
        $data = array();
        $i = 0;
        $kioskData = $this->Model_KioskLibraries->getAllData();
        foreach ($kioskData['tickettypes'] as $tickettypes) {
            $data[$i]['id'] = $tickettypes->id();
            $data[$i]['eventId'] = $tickettypes->eventId();
            foreach ($kioskData['events'] as $event) {
                if ($event->id() == $data[$i]['eventId']) {
                    $data[$i]['venueId'] = $event->venueId();
                    $data[$i]['event_name'] = $event->title();
                    $date = $event->date();
                    $formatdate = date('d-m-Y', strtotime($date));
                    $data[$i]['date'] = $formatdate;
                    $data[$i]['time'] = $event->time();
                    foreach ($kioskData['venues'] as $venues) {
                        if ($venues->id() == $data[$i]['venueId']) {
                            $data[$i]['vanu_name'] = $venues->name();
                        }
                    }
                }
            }

            $data[$i]['type'] = $tickettypes->type();
            $data[$i]['price'] = $tickettypes->price();
            $data[$i]['onsale'] = $tickettypes->onsale();
            $data[$i]['stockUnsold'] = $tickettypes->stockUnsold();
            $data[$i]['stockAvailable'] = $tickettypes->stockAvailable();
            $i++;
        }

        return $data;
    }

    public function getEventById($id) {
        $EventData = array();
        $Eventsdata = $this->getAllEvents();
        foreach ($Eventsdata as $Event) {
            if ($Event['id'] == $id) {
                $EventData = $Event;
            }
        }
        return $EventData;
    }

    public function getVanueById($id) {
        $VanueData = array();
        $Vanuesdata = $this->getAllVanues();
        foreach ($Vanuesdata['venuetypes'] as $Vanue) {
            if ($Vanue->id == $id) {
                $VanueData = $Vanue;
            }
        }
        return $VanueData;
    }

    // for ticket add to basket = ========//
    public function addTickettoBasket($id) {
        $ticketID = array();
        $i = 0;
        foreach ($id as $ticketval) {
            $ticketID[$i] = $ticketval;
            $i++;
        }
        $i = 0;
        $kioskData = $this->Model_KioskLibraries->getAllData();
        foreach ($kioskData['tickettypes'] as $tickettypes) {
            if (in_array($tickettypes->id(), $ticketID)) {
                $data[$i]['id'] = $tickettypes->id();
                $data[$i]['eventId'] = $tickettypes->eventId();
                $data[$i]['type'] = $tickettypes->type();
                $data[$i]['price'] = $tickettypes->price();
                $data[$i]['onsale'] = $tickettypes->onsale();
                $data[$i]['stockUnsold'] = $tickettypes->stockUnsold();
                $data[$i]['stockAvailable'] = $tickettypes->stockAvailable();
                foreach ($kioskData['events'] as $event) {
                    if ($event->id() == $data[$i]['eventId']) {
                        $data[$i]['venueId'] = $event->venueId();
                        $data[$i]['event_name'] = $event->title();
                        $data[$i]['date'] = $event->date();
                        $data[$i]['time'] = $event->time();
                        foreach ($kioskData['venues'] as $venues) {
                            if ($venues->id() == $data[$i]['venueId']) {
                                $data[$i]['vanu_name'] = $venues->name();
                            }
                        }
                    }
                }
                $i++;
            }
        }
        return $data;
    }

    //..... for checkout process in admin section........//
    public function checkoutProcess() {
        $i = 0;
        $qty = $this->input->post('qty');
        foreach ($this->input->post('tickets') as $id) {
            $i++;
        }
        $data = array('');
        $basket = $this->session->userdata('ticket_id');
        $i = 0;
        $ticketsID = array();
        $ticketID = array();
        foreach ($basket as $ticketval) {
            $ticketID[$i] = $ticketval;
            $i++;
        }
        $i = 0;
        $kioskData = $this->Model_KioskLibraries->getAllData();
        foreach ($kioskData['tickettypes'] as $tickettypes) {
            if (in_array($tickettypes->id(), $ticketID)) {
                $data[$i]['id'] = $tickettypes->id();
                $data[$i]['eventId'] = $tickettypes->eventId();
                $data[$i]['type'] = $tickettypes->type();
                $data[$i]['price'] = $tickettypes->price();
                $data[$i]['onsale'] = $tickettypes->onsale();
                $data[$i]['stockUnsold'] = $tickettypes->stockUnsold();
                $data[$i]['stockAvailable'] = $tickettypes->stockAvailable();
                foreach ($kioskData['events'] as $event) {
                    if ($event->id() == $data[$i]['eventId']) {
                        $data[$i]['venueId'] = $event->venueId();
                        $data[$i]['event_name'] = $event->title();
                        $data[$i]['date'] = $event->date();
                        $data[$i]['time'] = $event->time();
                        $data[$i]['qty'] = $qty[$i];
                        foreach ($kioskData['venues'] as $venues) {
                            if ($venues->id() == $data[$i]['venueId']) {
                                $data[$i]['vanu_name'] = $venues->name();
                            }
                        }
                    }
                }
                $i++;
            }
        }
        return $data;
    }

// get all event date//
    public function geteventDate() {
        $ticketsData = array();
        $data = array();
        $i = 0;
        $kioskData = $this->Model_KioskLibraries->getAllData();
        foreach ($kioskData['tickettypes'] as $tickettypes) {
            $data[$i]['id'] = $tickettypes->id();
            $data[$i]['eventId'] = $tickettypes->eventId();
            foreach ($kioskData['events'] as $event) {
                if ($event->id() == $data[$i]['eventId']) {
                    $data[$i]['venueId'] = $event->venueId();
                    $data[$i]['event_name'] = $event->title();
                    $data[$i]['date'] = $event->date();
                    $data[$i]['time'] = $event->time();
                    $data[$i]['description'] = $event->description();
                    ;
                    foreach ($kioskData['venues'] as $venues) {
                        if ($venues->id() == $data[$i]['venueId']) {
                            $data[$i]['vanu_name'] = $venues->name();
                        }
                    }
                }
            }
            $data[$i]['type'] = $tickettypes->type();
            $data[$i]['price'] = $tickettypes->price();
            $data[$i]['onsale'] = $tickettypes->onsale();
            $data[$i]['stockUnsold'] = $tickettypes->stockUnsold();
            $data[$i]['stockAvailable'] = $tickettypes->stockAvailable();
            $i++;
        }
        return ($data);
    }

    public function getCustomerinfo() {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from('customer as C');
        $query = $this->db->get();
        $userdata = array();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as $row) {
                $this->db->select('ticket_id');
                $this->db->from('basket_tickets');
                $this->db->where('user_id', $row['id']);
                $query1 = $this->db->get();
                $tickets = $query1->result_array();
                $row['tickets'] = $tickets;
                $userdata[] = $row;
            }
            return $userdata;
        } else {
            return array();
        }
    }

    public function getOrderDetail($id) {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $userdata = array();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as $row) {
                $this->db->select('ticket_id,price,event_id,venue_id');
                $this->db->from('basket_tickets');
                $this->db->where('user_id', $row['id']);
                $query1 = $this->db->get();
                $tickets = $query1->result_array();
                $row['tickets'] = $tickets;
                $userdata[] = $row;
            }
            return $userdata;
        } else {
            return array();
        }
    }

}

?> 