<?php

namespace InternetTickets\WeGotTickets\Api\v1\Client;

class Venue
{
    private $id;
    private $name;
    private $address;
    private $town;
    private $county;
    private $postcode;
    private $country;
    private $website;
    private $telephone;

    function __construct($id, $name, $address, $town, $county, $country, $postcode, $telephone, $website)
    {
        $this->address = $address;
        $this->country = $country;
        $this->county = $county;
        $this->id = $id;
        $this->name = $name;
        $this->postcode = $postcode;
        $this->telephone = $telephone;
        $this->town = $town;
        $this->website = $website;
    }


    /**
     * @return array
     */
    public function address()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function country()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function county()
    {
        return $this->county;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function postcode()
    {
        return $this->postcode;
    }

    /**
     * @return string
     */
    public function telephone()
    {
        return $this->telephone;
    }

    /**
     * @return string
     */
    public function town()
    {
        return $this->town;
    }

    /**
     * @return string
     */
    public function website()
    {
        return $this->website;
    }

}
