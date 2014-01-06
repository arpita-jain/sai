<?php

namespace spec\InternetTickets\WeGotTickets\Api\v1\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KioskSpec extends ObjectBehavior
{
    const DEFAULT_PRICE = 1000;
    const DEFAULT_TICKET_TYPE_ID = 1;
    const DEFAULT_EVENT_ID = 1;
    const DEFAULT_LINE_ITEM_QTY = 2;
    const DEFAULT_STATUS = 1;

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $wrapper
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\LineItem $lineItem
     */
    function let($wrapper, $lineItem)
    {
        $this->beConstructedWith($wrapper);
        $lineItem->price()->willReturn(self::DEFAULT_PRICE);
        $lineItem->ticketTypeId()->willReturn(self::DEFAULT_TICKET_TYPE_ID);
        $lineItem->quantity()->willReturn(self::DEFAULT_LINE_ITEM_QTY);
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $wrapper
     */
    function it_should_release_a_reservation($wrapper)
    {
        $wrapper->releaseTickets('reservation_id')->shouldBeCalled();
        $this->releaseTickets('reservation_id');
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $wrapper
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\LineItem $lineItem
     */
    function it_should_reserve_some_tickets($wrapper, $lineItem)
    {
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $wrapper->reserveTickets('reservation_id',
            array(
                array(
                    'ticketTypeId' => self::DEFAULT_TICKET_TYPE_ID,
                    'price' => self::DEFAULT_PRICE,
                    'quantity' => self::DEFAULT_LINE_ITEM_QTY,
                )
            )
        )->shouldBeCalled();
        $this->reserveTickets('reservation_id', array($lineItem));
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $wrapper
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\LineItem $lineItem
     */
    function it_should_transact_some_tickets($wrapper, $lineItem)
    {
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $wrapper->transactTickets('reservation_id',
            array(
                array(
                    'ticketTypeId' => self::DEFAULT_TICKET_TYPE_ID,
                    'price' => self::DEFAULT_PRICE,
                    'quantity' => self::DEFAULT_LINE_ITEM_QTY,
                )
            )
        )->shouldBeCalled();
        $this->transactTickets('reservation_id', array($lineItem));
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $wrapper
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\LineItem $lineItem
     */
    function it_should_refund_some_tickets($wrapper, $lineItem)
    {
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $wrapper->refundTickets('reservation_id',
            array(
                array(
                    'ticketTypeId' => self::DEFAULT_TICKET_TYPE_ID,
                    'price' => self::DEFAULT_PRICE,
                    'quantity' => self::DEFAULT_LINE_ITEM_QTY,
                )
            )
        )->shouldBeCalled();
        $this->refundTickets('reservation_id', array($lineItem));
    }

    /**
     * @param Subject $priceAndStock
     * @param int $ticketTypeId
     * @param int $price
     * @param int $stock
     */
    protected function priceAndStockObjectMatches(Subject $priceAndStock, $ticketTypeId, $price, $stock)
    {
        $priceAndStock->shouldHaveType('InternetTickets\WeGotTickets\Api\v1\Client\PriceAndStock');
        $priceAndStock->ticketTypeId()->shouldBe($ticketTypeId);
        $priceAndStock->price()->shouldBe($price);
        $priceAndStock->stock()->shouldBe($stock);
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $wrapper
     */
    function it_should_fetch_price_and_stock($wrapper)
    {
        $wrapper->fetchTicketTypes(array(self::DEFAULT_TICKET_TYPE_ID))->willReturn(
            array(
                array(
                    'id' => self::DEFAULT_TICKET_TYPE_ID,
                    'eventId' => self::DEFAULT_EVENT_ID,
                    'type' => 'STANDARD',
                    'price' => self::DEFAULT_PRICE,
                    'currency' => 'GBP',
                    'status' => self::DEFAULT_STATUS,
                    'stock' => 10,
                )
            )
        );
        $pricesAndStocks = $this->fetchPriceAndStockFor(array(self::DEFAULT_TICKET_TYPE_ID));
        $this->priceAndStockObjectMatches($pricesAndStocks[0], self::DEFAULT_TICKET_TYPE_ID, self::DEFAULT_PRICE, 10);
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $wrapper
     */
    function it_should_fetch_price_and_stock_for_multiple_ticket_types($wrapper)
    {
        $wrapper->fetchTicketTypes(array(1, 2))->willReturn(
            array(
                array(
                    'id' => 1,
                    'eventId' => self::DEFAULT_EVENT_ID,
                    'type' => 'STANDARD',
                    'price' => self::DEFAULT_PRICE,
                    'currency' => 'GBP',
                    'status' => self::DEFAULT_STATUS,
                    'stock' => 10,
                ),
                array(
                    'id' => 2,
                    'eventId' => self::DEFAULT_EVENT_ID,
                    'type' => 'CHILD',
                    'price' => 800,
                    'currency' => 'GBP',
                    'status' => self::DEFAULT_STATUS,
                    'stock' => 5,
                )
            )
        );
        $pricesAndStocks = $this->fetchPriceAndStockFor(array(1, 2));
        $this->priceAndStockObjectMatches($pricesAndStocks[0], 1, self::DEFAULT_PRICE, 10);
        $this->priceAndStockObjectMatches($pricesAndStocks[1], 2, 800, 5);
    }

    /**
     * @param $allDataWrapper
     */
    protected function setUpAllDataWrapper($allDataWrapper)
    {
        $allDataWrapper->fetchVenues()->shouldBeCalled()->willReturn(array());
        $allDataWrapper->fetchEvents()->shouldBeCalled()->willReturn(array());
        $allDataWrapper->fetchTicketTypes()->shouldBeCalled()->willReturn(array());
        $this->beConstructedWith($allDataWrapper);
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_fetch_venue_and_event_and_tickettype_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $this->fetchAllData();
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_an_array_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $this->fetchAllData()->shouldBeArray();
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_venues_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $this->fetchAllData()->shouldHaveKey('venues');
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_events_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $this->fetchAllData()->shouldHaveKey('events');
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_ticket_types_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $this->fetchAllData()->shouldHaveKey('tickettypes');
    }

    /**
     * @param Subject $venue
     * @param int $id
     * @param string $name
     */
    protected function venueObjectMatches(Subject $venue, $id, $name)
    {
        $venue->shouldHaveType('InternetTickets\WeGotTickets\Api\v1\Client\Venue');
        $venue->id()->shouldBe($id);
        $venue->name()->shouldBe($name);
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_a_venue_object_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $allDataWrapper->fetchVenues()->willReturn(
            array(
                array(
                    'id' => 1,
                    'name' => 'Venue name',
                    'address' => '',
                    'town' => '',
                    'county' => '',
                    'postcode' => '',
                    'country' => '',
                    'website' => '',
                    'telephone' => '',
                )
            )
        );

        $returnValue = $this->fetchAllData();
        $venues = $returnValue['venues'];
        $this->venueObjectMatches($venues[0], self::DEFAULT_TICKET_TYPE_ID, 'Venue name');
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_multiple_venue_objects_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $allDataWrapper->fetchVenues()->willReturn(
            array(
                array(
                    'id' => 1,
                    'name' => 'Venue name',
                    'address' => '',
                    'town' => '',
                    'county' => '',
                    'postcode' => '',
                    'country' => '',
                    'website' => '',
                    'telephone' => '',
                ),
                array(
                    'id' => 2,
                    'name' => 'Another venue name',
                    'address' => '',
                    'town' => '',
                    'county' => '',
                    'postcode' => '',
                    'country' => '',
                    'website' => '',
                    'telephone' => '',
                )
            )
        );

        $returnValue = $this->fetchAllData();
        $venues = $returnValue['venues'];
        $this->venueObjectMatches($venues[0], 1, 'Venue name');
        $this->venueObjectMatches($venues[1], 2, 'Another venue name');
    }

    /**
     * @param Subject $event
     * @param int $id
     * @param string $title
     */
    protected function eventObjectMatches(Subject $event, $id, $title)
    {
        $event->shouldHaveType('InternetTickets\WeGotTickets\Api\v1\Client\Event');
        $event->id()->shouldBe($id);
        $event->title()->shouldBe($title);
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_an_event_object_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $allDataWrapper->fetchEvents()->willReturn(
            array(
                array(
                    'id' => self::DEFAULT_EVENT_ID,
                    'venueId' => 1,
                    'title' => 'Oxford Literary Event',
                    'status' => self::DEFAULT_STATUS,
                    'date' => '2013-11-01',
                    'description' => 'An author speaking about stuff what he wrote.',
                    'time' => '3pm',
                    'ageLimit' => '14+',
                )
            )
        );
        $returnValue = $this->fetchAllData();
        $events = $returnValue['events'];
        $this->eventObjectMatches($events[0], self::DEFAULT_EVENT_ID, 'Oxford Literary Event');
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_multiple_event_objects_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $allDataWrapper->fetchEvents()->willReturn(
            array(
                array(
                    'id' => 1,
                    'venueId' => 1,
                    'title' => 'Oxford Literary Event',
                    'status' => self::DEFAULT_STATUS,
                    'date' => '2013-11-01',
                    'description' => 'An author speaking about stuff what he wrote.',
                    'time' => '3pm',
                    'ageLimit' => '14+',
                ),
                array(
                    'id' => 2,
                    'venueId' => 1,
                    'title' => 'Another Oxford Literary Event',
                    'status' => self::DEFAULT_STATUS,
                    'date' => '2013-11-02',
                    'description' => 'An author not speaking about stuff what he wrote.',
                    'time' => '3pm',
                    'ageLimit' => 'All ages',
                )
            )
        );
        $returnValue = $this->fetchAllData();
        $events = $returnValue['events'];
        $this->eventObjectMatches($events[0], 1, 'Oxford Literary Event');
        $this->eventObjectMatches($events[1], 2, 'Another Oxford Literary Event');
    }

    /**
     * @param Subject $ticketType
     * @param int $id
     * @param string $type
     * @param int $price
     */
    protected function ticketTypeObjectMatches(Subject $ticketType, $id, $type, $price)
    {
        $ticketType->shouldHaveType('InternetTickets\WeGotTickets\Api\v1\Client\TicketType');
        $ticketType->id()->shouldBe($id);
        $ticketType->type()->shouldBe($type);
        $ticketType->price()->shouldBe($price);
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_a_tickettype_object_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $allDataWrapper->fetchTicketTypes()->willReturn(
            array(
                array(
                    'id' => self::DEFAULT_TICKET_TYPE_ID,
                    'eventId' => self::DEFAULT_EVENT_ID,
                    'type' => 'STANDARD',
                    'price' => self::DEFAULT_PRICE,
                    'currency' => 'GBP',
                    'status' => self::DEFAULT_STATUS,
                    'stockUnsold' => 10,
                    'stockAvailable' => 9,
                )
            )
        );
        $returnValue = $this->fetchAllData();
        $ticketTypes = $returnValue['tickettypes'];
        $this->ticketTypeObjectMatches($ticketTypes[0], self::DEFAULT_TICKET_TYPE_ID, 'STANDARD', self::DEFAULT_PRICE);
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Wrapper\Wrapper $allDataWrapper
     */
    function it_should_return_multiple_tickettype_objects_when_asked_for_all_data($allDataWrapper)
    {
        $this->setUpAllDataWrapper($allDataWrapper);
        $allDataWrapper->fetchTicketTypes()->willReturn(
            array(
                array(
                    'id' => 1,
                    'eventId' => self::DEFAULT_EVENT_ID,
                    'type' => 'STANDARD',
                    'price' => self::DEFAULT_PRICE,
                    'currency' => 'GBP',
                    'status' => self::DEFAULT_STATUS,
                    'stockUnsold' => 10,
                    'stockAvailable' => 9,
                ),
                array(
                    'id' => 2,
                    'eventId' => self::DEFAULT_EVENT_ID,
                    'type' => 'CHILD',
                    'price' => 800,
                    'currency' => 'GBP',
                    'status' => self::DEFAULT_STATUS,
                    'stockUnsold' => 8,
                    'stockAvailable' => 7,
                )
            )
        );
        $returnValue = $this->fetchAllData();
        $ticketTypes = $returnValue['tickettypes'];
        $this->ticketTypeObjectMatches($ticketTypes[0], 1, 'STANDARD', self::DEFAULT_PRICE);
        $this->ticketTypeObjectMatches($ticketTypes[1], 2, 'CHILD', 800);
    }

}
