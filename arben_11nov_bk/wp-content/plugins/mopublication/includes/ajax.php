<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  AJAX call functions
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */


function mopub_get_config_xml()
{
    include 'config-xml.php';
    exit;
}

add_action('wp_ajax_mopub_get_config_xml', 'mopub_get_config_xml');
