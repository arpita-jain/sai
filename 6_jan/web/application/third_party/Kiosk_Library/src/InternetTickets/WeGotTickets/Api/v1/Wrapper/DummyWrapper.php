<?php

namespace InternetTickets\WeGotTickets\Api\v1\Wrapper;

class DummyWrapper implements Wrapper
{
    public function fetchTicketTypes($ticketTypeIds = array())
    {
        $ticketTypes = array(
            array(
                'id' => 34965,
                'event_id' => 100845,
                'type' => 'STANDARD',
                'price' => 1250,
                'currency' => 'GBP',
                'on_sale' => 1,
                'stock_unsold' => 13,
                'stock_available' => 12,
            ),
            array(
                'id' => 34966,
                'event_id' => 100845,
                'type' => 'CONCESSION',
                'price' => 850,
                'currency' => 'GBP',
                'on_sale' => 1,
                'stock_unsold' => 11,
                'stock_available' => 5,
            ),


            array(
                'id' => 34967,
                'event_id' => 100846,
                'type' => 'STANDARD',
                'price' => 1250,
                'currency' => 'GBP',
                'on_sale' => 0,
                'stock_unsold' => 15,
                'stock_available' => 10,
            ),
            array(
                'id' => 34968,
                'event_id' => 100846,
                'type' => 'CONCESSION',
                'price' => 950,
                'currency' => 'GBP',
                'on_sale' => 1,
                'stock_unsold' => 23,
                'stock_available' => 23,
            ),


            array(
                'id' => 34969,
                'event_id' => 100847,
                'type' => 'STANDARD',
                'price' => 1300,
                'currency' => 'GBP',
                'on_sale' => 1,
                'stock_unsold' => 5,
                'stock_available' => 2,
            ),
            array(
                'id' => 34970,
                'event_id' => 100847,
                'type' => 'CONCESSION',
                'price' => 850,
                'currency' => 'GBP',
                'on_sale' => 0,
                'stock_unsold' => 0,
                'stock_available' => 0,
            ),


            array(
                'id' => 34971,
                'event_id' => 100848,
                'type' => 'STANDARD',
                'price' => 2100,
                'currency' => 'GBP',
                'on_sale' => 1,
                'stock_unsold' => 43,
                'stock_available' => 41,
            ),
        );
        
        if (count($ticketTypeIds) > 0) {
            $ticketTypes = array_filter($ticketTypes, function($item) use($ticketTypeIds) {
                return in_array($item['id'], $ticketTypeIds);
            });
        }
        
        return $ticketTypes;
    }

    public function releaseTickets($reservationId)
    {
        // Dummy
    }

    public function fetchVenues()
    {
        return array(
            array(
                'id' => 5004,
                'name' => 'Christ Church - Blue Boar Lecture Hall',
                'address' => array(
                    'St Aldates',
                ),
                'town' => 'Oxford',
                'county' => 'Oxfordshire',
                'country' => 'GB',
                'postcode' => 'OX1 1DP',
                'website' => 'http://www.chch.ox.ac.uk/',
                'telephone' => '01865 276150'
            ),
            array(
                'id' => 5005,
                'name' => 'Sheldonian Theatre',
                'address' => array(
                    'Broad St',
                ),
                'town' => 'Oxford',
                'county' => 'Oxfordshire',
                'country' => 'GB',
                'postcode' => 'OX1 3AZ',
                'website' => 'http://www.ox.ac.uk/subsite/sheldonian_theatre/sheldonian_theatre/',
                'telephone' => '01865 277299'
            ),
            array(
                'id' => 5006,
                'name' => 'The Radcliffe Camera',
                'address' => array(
                    'Radcliffe Square',
                ),
                'town' => 'Oxford',
                'county' => 'Oxfordshire',
                'country' => 'GB',
                'postcode' => 'OX1 3BG',
                'website' => 'http://www.bodleian.ox.ac.uk/bodley',
                'telephone' => '01865 277162'
            ),
        );
    }

    public function reserveTickets($reservationId, $lineItems)
    {
        // Dummy
    }

    public function refundTickets($transactionId, $lineItems)
    {
        // Dummy
    }

    public function fetchEvents()
    {
        return array(
            array(
                'id' => 100845,
                'venue_id' => '5004',
                'title' => 'Robert Douglas-Fairhurst - Charles Kingsley\'s The Water-Babies',
                'status' => 1,
                'date' => '2013-04-01',
                'description' => 'Academic and writer Robert Douglas-Fairhurst introduces a new edition of Charles Kingsley\'s
                        children\'s fantasy, The Water-Babies, to mark the 150th anniversary of its first publication.
                        The work is both one of the strangest and most powerful children’s books ever published.
                        Douglas-Fairhurst explores the genesis and context of Kingsley\'s tale, including its linguistic
                        oddities and multiple genres, its delight in nature and scientific discovery,
                        and its romance and mythic symbolism.',
                'time' => '12pm',
                'age_limit' => 'No age limit'
            ),
            array(
                'id' => 100846,
                'venue_id' => '5004',
                'title' => 'Ros Asquith - Letters from an Alien Schoolboy translated by Ros Asquith',
                'status' => 1,
                'date' => '2013-04-01',
                'description' => 'Did you know that aliens from the planet Faa are living on earth disguised as humans?
                        And very funny they find us too! Ros Asquith has been monitoring them.
                        Join her for this special event and find out what the aliens have been up to.
                        Ros will show you how to draw aliens too.
                        Asquith is one of the funniest writers for children and Letters from an Alien Schoolboy was
                        shortlisted for the Roald Dahl Funny Book Prize. The great-granddaughter of Herbert Asquith,
                        she is also a cartoonist for The Guardian.',
                'time' => '4pm',
                'age_limit' => 'No age limit'
            ),
            array(
                'id' => 100847,
                'venue_id' => '5005',
                'title' => 'Calder Walton - Empire of Secrets: Espionage at the End of Empire',
                'status' => 1,
                'date' => '2013-04-02',
                'description' => 'Intelligence historian Calder Walton ranges from wartime espionage through shady communications
                        with African dictators to violent counter insurgencies fought in the jungles of Malaya and
                        Kenya as he chronicles the work of British secret services in the final days of empire and
                        during the Cold War. He uncovers CIA plots, covert activities in the colonies, KGB assassinations,
                        and failed coups sponsored by the British and Americans. Walton is among a new generation of
                        young intelligence historians. This, his first book, is based on recently declassified intelligence
                        records and is full of events straight out of a spy novel.',
                'time' => '2pm',
                'age_limit' => 'No age limit'
            ),
            array(
                'id' => 100848,
                'venue_id' => '5006',
                'title' => ' Ian Goldin - Divided Nations: Why Global Governance is Failing, and What We Can Do About it',
                'status' => 0,
                'date' => '2013-04-03',
                'description' => 'Former vice-president of the World Bank Professor Ian Goldin looks at the challenges facing
                        the world as a consequence of rapid globalisation. The deeper interconnections brought about by
                        urbanisation, development of technology and the rise of the Internet have brought great advantages,
                        but, Goldin argues, they also bring new challenges that spill across national boundaries.
                        He asks whether existing structures like the UN and the World Bank can deal with climate change,
                        finance, pandemics, cyber security and migration, or whether we a radical new approach.',
                'time' => '6pm',
                'age_limit' => '12+'
            ),
        );
    }

    public function transactTickets($reservationId, $lineItems)
    {
        // Dummy
    }

}