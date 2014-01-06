<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once '../vendor/autoload.php';

use InternetTickets\WeGotTickets\Api\v1\Client;
use InternetTickets\WeGotTickets\Api\v1\Client\Kiosk as Kiosk;

class Model_LineItems  implements Client\LineItem {

    private $_price;
    private $_ticketTypeId;
    private $_quantity;
    private $kiosk;

    function __construct() {
        $this->kiosk = Kiosk::factory('d85e6abe-f89f-417e-97af-8797d36aacd7', 'MySecret');
    }

    function setLine($line) {
        $this->_price = $line->price;
        $this->_ticketTypeId = $line->item_id;
        $this->_quantity = $line->quantity;
    }

    function ticketTypeId() {
        return $this->_ticketTypeId;
    }

    function price() {
        return $this->_price;
    }

    function quantity() {
        return $this->_quantity;
    }

}

?>