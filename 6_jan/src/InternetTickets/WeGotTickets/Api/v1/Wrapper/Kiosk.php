<?php
namespace InternetTickets\WeGotTickets\Api\v1\Wrapper;

use InternetTickets\WeGotTickets\Api\v1\Client\Rest;

class Kiosk implements Wrapper
{
    /**
     * @var \InternetTickets\WeGotTickets\Api\v1\Client\Rest
     */
    private $restClient;

    public function __construct(Rest $restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * @param $reservationId
     * @throws Exceptions\InvalidIdException
     */
    protected function validateReservationId($reservationId)
    {
        if (preg_match('/\W/', $reservationId)) {
            throw new Exceptions\InvalidIdException();
        }
    }

    public function releaseTickets($reservationId)
    {
        $this->validateReservationId($reservationId);
        $this->restClient->put('/reservations/' . $reservationId, array());
    }

    public function reserveTickets($reservationId, $lineItems)
    {
        $this->validateReservationId($reservationId);
        $this->validateLineItems($lineItems);
        $this->restClient->put('/reservations/' . $reservationId, $lineItems);
    }

    public function transactTickets($reservationId, $lineItems)
    {
        $this->validateReservationId($reservationId);
        $this->validateLineItems($lineItems);
        $this->restClient->post('/transactions/' . $reservationId, $lineItems);
    }

    public function refundTickets($transactionId, $lineItems)
    {
        $this->validateReservationId($transactionId);
        $this->validateLineItems($lineItems);
        $this->restClient->post('/refunds/' . $transactionId, $lineItems);
    }

    public function fetchVenues() {
        return $this->restClient->get('/venues');
    }

    public function fetchEvents() {
        return $this->restClient->get('/events');
    }

    public function fetchTicketTypes($ticketTypeIds = array()) {
        $ticketTypesQuery = $this->makeTicketTypesQuery($ticketTypeIds);
        return $this->restClient->get('/tickettypes', $ticketTypesQuery);
    }

    /**
     * Add key and validate ids of ticketTypes
     *
     * @param $ticketTypes
     * @return array
     * @throws Exceptions\InvalidIdException
     */

    protected function makeTicketTypesQuery($ticketTypes)
    {
        foreach ($ticketTypes as $ticketType) {
            if (!is_int($ticketType)) {
                throw new Exceptions\InvalidIdException();
            }
        }
        return array('query' => array_values($ticketTypes));
    }

    /**
     * @param $lineItems
     * @throws Exceptions\InvalidLineItemException
     * @throws Exceptions\NoLineItemsProvidedException
     */
    protected function validateLineItems($lineItems)
    {
        if (empty($lineItems)) {
            throw new Exceptions\NoLineItemsProvidedException();
        }
        foreach ($lineItems as $lineItem) {
            if ( ! is_array($lineItem)
                || ! array_key_exists('ticketTypeId', $lineItem)
                || ! array_key_exists('price', $lineItem)
                || ! array_key_exists('quantity', $lineItem)
            ) {
                throw new Exceptions\InvalidLineItemException();
            }
        }
    }

}
