<?php
/**
 * Description
 */
namespace InternetTickets\WeGotTickets\Api\v1\Wrapper;

interface Wrapper
{
    public function fetchTicketTypes($ticketTypeIds = array());

    public function releaseTickets($reservationId);

    public function fetchVenues();

    public function reserveTickets($reservationId, $lineItems);

    public function refundTickets($transactionId, $lineItems);

    public function fetchEvents();

    public function transactTickets($reservationId, $lineItems);
}