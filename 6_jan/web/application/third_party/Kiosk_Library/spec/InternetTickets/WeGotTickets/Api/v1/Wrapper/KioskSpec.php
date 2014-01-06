<?php
namespace spec\InternetTickets\WeGotTickets\Api\v1\Wrapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class KioskSpec extends ObjectBehavior
{
    const DEFAULT_PRICE = 1000;
    const DEFAULT_TICKET_TYPE_ID = 1;
    const DEFAULT_LINE_ITEM_QTY = 2;
    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function let($restClient)
    {
        $this->beConstructedWith($restClient);
    }

    function it_should_release_a_reservation()
    {
        $this->shouldNotThrow('Exception')->duringReleaseTickets('unique_id');
    }

    function it_should_throw_an_exception_when_releasing_an_invalid_reservation_id()
    {
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\InvalidIdException')
            ->duringReleaseTickets('invalid id');
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_the_rest_client_when_releasing_a_reservation($restClient)
    {
        $restClient->put('/reservations/unique_id', array())->shouldBeCalled();
        $this->releaseTickets('unique_id');

    }

    function it_should_reserve_some_tickets()
    {
        $lineItem = $this->defaultLineItem();
        $this->shouldNotThrow('Exception')->duringReserveTickets('unique_id', array($lineItem));
    }

    function it_should_throw_an_exception_when_reserving_an_invalid_reservation_id()
    {
        $lineItem = $this->defaultLineItem();
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\InvalidIdException')
            ->duringReserveTickets('invalid id', array($lineItem));
    }

    function it_should_throw_an_exception_when_reserving_an_empty_reservation()
    {
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\NoLineItemsProvidedException')
            ->duringReserveTickets('unique_id', array());
    }

    function it_should_throw_an_exception_when_reserving_anything_other_than_line_items()
    {
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\InvalidLineItemException')
            ->duringReserveTickets('unique_id', array('string'));
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_the_rest_client_when_reserving_some_tickets($restClient)
    {
        $lineItem = $this->defaultLineItem();
        $restClient->put('/reservations/unique_id', array($lineItem))->shouldBeCalled();
        $this->reserveTickets('unique_id', array($lineItem));
    }

    function it_should_transact_some_tickets()
    {
        $lineItem = $this->defaultLineItem();
        $this->shouldNotThrow('Exception')->duringTransactTickets('unique_id', array($lineItem));
    }

    function it_should_throw_an_exception_when_transacting_an_invalid_reservation_id()
    {
        $lineItem = $this->defaultLineItem();
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\InvalidIdException')
            ->duringTransactTickets('invalid id', array($lineItem));
    }

    function it_should_throw_an_exception_when_transacting_an_empty_reservation()
    {
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\NoLineItemsProvidedException')
            ->duringTransactTickets('unique_id', array());
    }

    function it_should_throw_an_exception_when_transacting_anything_other_than_line_items()
    {
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\InvalidLineItemException')
            ->duringTransactTickets('unique_id', array('string'));
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_the_rest_client_when_transacting_some_tickets($restClient)
    {
        $lineItem = $this->defaultLineItem();
        $restClient->post('/transactions/unique_id', array($lineItem))->shouldBeCalled();
        $this->transactTickets('unique_id', array($lineItem));
    }

    function it_should_refund_some_tickets()
    {
        $lineItem = $this->defaultLineItem();
        $this->shouldNotThrow('Exception')->duringRefundTickets('unique_id', array($lineItem));
    }

    function it_should_throw_an_exception_when_refunding_an_invalid_transaction_id()
    {
        $lineItem = $this->defaultLineItem();
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\InvalidIdException')
            ->duringRefundTickets('invalid id', array($lineItem));
    }

    function it_should_throw_an_exception_when_refunding_zero_line_items()
    {
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\NoLineItemsProvidedException')
            ->duringRefundTickets('unique_id', array());
    }

    function it_should_throw_an_exception_when_refunding_anything_other_than_line_items()
    {
        $this->shouldThrow('InternetTickets\WeGotTickets\Api\v1\Wrapper\Exceptions\InvalidLineItemException')
            ->duringRefundTickets('unique_id', array('string'));
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_the_rest_client_when_refunding_some_tickets($restClient)
    {
        $lineItem = $this->defaultLineItem();
        $restClient->post('/refunds/unique_id', array($lineItem))->shouldBeCalled();
        $this->refundTickets('unique_id', array($lineItem));
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_the_rest_client_when_fetching_venues($restClient)
    {
        $restClient->get('/venues')->shouldBeCalled();
        $this->fetchVenues();
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_return_venue_data_when_fetching_venues($restClient)
    {
        $restClient->get('/venues')->willReturn(
            array(
                'venue data'
            )
        );
        $this->fetchVenues()->shouldReturn(
            array(
                'venue data'
            )
        );
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_the_rest_client_when_fetching_events($restClient)
    {
        $restClient->get('/events')->shouldBeCalled();
        $this->fetchEvents();
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_return_event_data_when_fetching_events($restClient)
    {
        $restClient->get('/events')->willReturn(
            array('event data')
        );
        $this->fetchEvents()->shouldReturn(
            array('event data')
        );
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_the_rest_client_when_fetching_ticket_types($restClient)
    {
        $restClient->get('/tickettypes', array('query'=>array()))->shouldBeCalled();
        $this->fetchTicketTypes();
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_call_return_tickettype_data_when_fetching_ticket_types($restClient)
    {
        $restClient->get('/tickettypes', array('query' => array()))->willReturn(
            array('ticket type data')
        );
        $this->fetchTicketTypes()->shouldReturn(
            array('ticket type data')
        );
    }

    /**
     * @param \InternetTickets\WeGotTickets\Api\v1\Client\Rest $restClient
     */
    function it_should_pass_ticket_type_ids_to_rest_client_when_fetching_ticket_types($restClient)
    {
        $restClient->get('/tickettypes', array('query' => array(1)))->shouldBeCalled();
        $this->fetchTicketTypes(array(1));

    }

    /**
     * @return array
     */
    protected function defaultLineItem()
    {
        $lineItem = array(
            'ticketTypeId' => self::DEFAULT_TICKET_TYPE_ID,
            'price' => self::DEFAULT_PRICE,
            'quantity' => self::DEFAULT_LINE_ITEM_QTY,
        );
        return $lineItem;
    }

}
