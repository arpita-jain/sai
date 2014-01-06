<?php

namespace InternetTickets\WeGotTickets\Api\v1\Client;


class TicketType {
    private $id;
    private $eventId;
    private $type;
    private $price;
    private $currency;
    private $onsale;
    private $stockUnsold;
    private $stockAvailable;

    function __construct($id, $eventId, $type, $price, $currency, $onsale, $stockUnsold, $stockAvailable)
    {
        $this->currency = $currency;
        $this->eventId = $eventId;
        $this->id = $id;
        $this->price = $price;
        $this->onsale = $onsale;
        $this->stockUnsold = $stockUnsold;
        $this->stockAvailable = $stockAvailable;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * @return mixed
     */
    public function eventId()
    {
        return $this->eventId;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function price()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function onsale()
    {
        return $this->onsale;
    }

    /**
     * @return int
     */
    public function stockUnsold()
    {
        return $this->stockUnsold;
    }

    /**
     * @return int
     */
    public function stockAvailable()
    {
        return $this->stockAvailable;
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

} 