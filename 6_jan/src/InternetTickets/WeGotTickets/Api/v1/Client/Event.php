<?php

namespace InternetTickets\WeGotTickets\Api\v1\Client;

class Event
{
    private $id;
    private $venueId;
    private $title;
    private $status;
    private $date;
    private $description;
    private $time;
    private $ageLimit;

    function __construct( $id, $venueId, $title, $status, $date, $description, $time, $ageLimit)
    {
        $this->date = $date;
        $this->description = $description;
        $this->id = $id;
        $this->status = $status;
        $this->time = $time;
        $this->title = $title;
        $this->venueId = $venueId;
        $this->ageLimit =$ageLimit;
    }

    /**
     * @return mixed
     */
    public function ageLimit()
    {
        return $this->ageLimit;
    }

    /**
     * @return \DateTime
     */
    public function date()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
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
    public function status()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function time()
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function venueId()
    {
        return $this->venueId;
    }

}
