<?php

namespace InternetTickets\WeGotTickets\Api\v1\Client;


class PriceAndStock {
    private $ticketTypeId;
    private $price;
    private $stock;

    function __construct($ticketTypeId, $price, $stock)
    {
        $this->price = $price;
        $this->stock = $stock;
        $this->ticketTypeId = $ticketTypeId;
    }

    /**
     * @return mixed
     */
    public function price()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function stock()
    {
        return $this->stock;
    }

    /**
     * @return mixed
     */
    public function ticketTypeId()
    {
        return $this->ticketTypeId;
    }

} 