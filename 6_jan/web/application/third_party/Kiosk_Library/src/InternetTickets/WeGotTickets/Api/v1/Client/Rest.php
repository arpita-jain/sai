<?php
/**
 * Description
 * 
 * @author Nils Luxton <nils.luxton@wegottickets.com>
 * @version $Id:$
 */

namespace InternetTickets\WeGotTickets\Api\v1\Client;


interface Rest {

    public function get($resource, $data = array());
    public function post($resource, $data);
    public function put($resource, $data);
}