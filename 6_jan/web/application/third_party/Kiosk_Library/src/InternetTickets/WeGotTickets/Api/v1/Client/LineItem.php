<?php
namespace InternetTickets\WeGotTickets\Api\v1\Client;

interface LineItem
{
    function ticketTypeId();
    function price();
    function quantity();
}
