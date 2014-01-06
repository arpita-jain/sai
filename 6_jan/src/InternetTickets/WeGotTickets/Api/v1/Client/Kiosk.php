<?php

namespace InternetTickets\WeGotTickets\Api\v1\Client;

use InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper;
use InternetTickets\WeGotTickets\Api\v1\Wrapper\DummyWrapper;

class Kiosk
{
    /**
     * Creates the default implementation of the library
     * 
     * @return Kiosk
     */
    public static function create()
    {
        return new self(new DummyWrapper());
    }

    /**
     * @var Wrapper
     */
    private $wrapper;

    /**
     * @param Wrapper $wrapper
     */
    public function __construct(Wrapper $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    /**
     * @param string $reservationId
     */
    public function releaseTickets($reservationId)
    {
        $this->wrapper->releaseTickets($reservationId);
    }

    /**
     * @param string $reservationId
     * @param LineItem[] $lineItems
     */
    public function reserveTickets($reservationId, array $lineItems)
    {
        $this->wrapper->reserveTickets($reservationId, $this->convertLineItems($lineItems));
    }

    /**
     * @param string $reservationId
     * @param LineItem[] $lineItems
     */
    public function transactTickets($reservationId, array $lineItems)
    {
        $this->wrapper->transactTickets($reservationId, $this->convertLineItems($lineItems));
    }

    /**
     * @param string $reservationId
     * @param LineItem[] $lineItems
     */
    public function refundTickets($reservationId, array $lineItems)
    {
        $this->wrapper->refundTickets($reservationId, $this->convertLineItems($lineItems));
    }

    /**
     * @param array $ticketTypeIds
     * @return PriceAndStock[]
     */
    public function fetchPriceAndStockFor(array $ticketTypeIds)
    {
        $ticketTypes = $this->wrapper->fetchTicketTypes($ticketTypeIds);
        $priceAndStock = array();
        foreach ($ticketTypes as $ticketType) {
            $priceAndStock[] = new PriceAndStock(
                $ticketType['id'],
                $ticketType['price'],
                $ticketType['stock_available']
            );
        }
        return $priceAndStock;
    }

    public function fetchVenues()
    {
                $VanuesData = $this->wrapper->fetchVenues();
                return $VanuesData;
    }
    
        public function fetchEvents()
    {
                $eventsData = $this->wrapper->fetchEvents();
                return $eventsData;
    }
    
    
    /**
     * @return array
     */
    public function fetchAllData()
    {
        $venuesData = $this->wrapper->fetchVenues();
        $venues = array();
        foreach ($venuesData as $venueData) {
            $venue = new Venue(
                $venueData['id'],
                $venueData['name'],
                $venueData['address'],
                $venueData['town'],
                $venueData['county'],
                $venueData['postcode'],
                $venueData['country'],
                $venueData['website'],
                $venueData['telephone']
            );
            $venues[] = $venue;
        }
        $eventsData = $this->wrapper->fetchEvents();
        $events = array();
        foreach ($eventsData as $eventData) {
            $event = new Event(
                $eventData['id'],
                $eventData['venue_id'],
                $eventData['title'],
                $eventData['status'],
                $eventData['date'],
                $eventData['description'],
                $eventData['time'],
                $eventData['age_limit']
            );
            $events[] = $event;
        }
        $ticketTypesData = $this->wrapper->fetchTicketTypes();
        $ticketTypes = array();
        foreach ($ticketTypesData as $ticketTypeData) {
            $ticketTypes[] = new TicketType(
                $ticketTypeData['id'],
                $ticketTypeData['event_id'],
                $ticketTypeData['type'],
                $ticketTypeData['price'],
                $ticketTypeData['currency'],
                $ticketTypeData['on_sale'],
                $ticketTypeData['stock_unsold'],
                $ticketTypeData['stock_available']
            );
        }
        return array(
            'venues' => $venues,
            'events' => $events,
            'tickettypes' => $ticketTypes,
        );
    }

    /**
     * @param array $lineItems
     * @return array
     */
    protected function convertLineItems(array $lineItems)
    {
        $lineItemsData = array();
        foreach ($lineItems as $lineItem) {
            $lineItemsData[] = array(
                'ticketTypeId' => $lineItem->ticketTypeId(),
                'price' => $lineItem->price(),
                'quantity' => $lineItem->quantity(),
            );
        }
        return $lineItemsData;
    }
}
