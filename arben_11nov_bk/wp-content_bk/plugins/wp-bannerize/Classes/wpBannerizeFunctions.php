<?php
/**
 * Wrap for allow to call a simple function from Wordpress envirorment
 *
 * @package         wpBannerize
 * @subpackage      wpBannerizeFunctions
 * @author          =undo= <g.fazioli@undolog.com>, <g.fazioli@saidmade.com>
 * @copyright       Copyright © 2008-2011 Saidmade Srl
 *
 */

/**
 * Comodity function for Show banner list
 *
 * @return void
 *
 * @param array|object $args [optional]
 *
 * @see WPBannerizeFrontend Class
 */
function wp_bannerize( $args = array () ) {
	global $wpBannerizeFrontend;
	echo $wpBannerizeFrontend->bannerize( $args );
}