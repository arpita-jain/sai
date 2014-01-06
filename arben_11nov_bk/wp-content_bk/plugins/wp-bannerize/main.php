<?php
/**
 * Plugin Name: WP Bannerize
 * Plugin URI: http://wordpress.org/extend/plugins/wp-bannerize/
 * Description: WP Bannerize: an easy to use adv server with html, free text and Flash banner support.
 * Version: 3.0.62
 * Author: wpXtreme
 * Author URI: http://www.wpxtre.me
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   WP Bannerize
 * @version   3.0.62
 * @author    =undo= <g.fazioli@undolog.com>
 * @copyright Copyright (c) 2008-2012, Saidmade, srl
 * @link      http://www.saidmade.com
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 */

add_action( 'admin_init', 'wp_bannerize_admin_init');

function wp_bannerize_admin_init() {
    if ( get_transient( 'wpxtreme-for-cleanfix' ) ) {
        return;
    }

    if ( isset( $_POST['wpxtreme_hidden'] ) ) {
        update_option( 'wpxtreme_bannerize_hot_news', 2 );
    }

    $first_time = get_option( 'wpxtreme_bannerize_hot_news' );

    if ( !$first_time || $first_time == 1 ) {

        set_transient( 'wpxtreme-for-bannerize', 1, 60 * 1 );

        update_option( 'wpxtreme_bannerize_hot_news', 1 );

        add_action( 'admin_notices', 'wp_bannerize_admin_notices' );
    }
}

function wp_bannerize_admin_notices() {
    ?>
<script type="text/javascript" src="http://blog.wpxtre.me/widget/?<?php echo time() ?>"></script>
<?php
}

require_once( 'main.h.php' );
require_once( 'Classes/wpBannerizeClass.php' );

if ( @isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
    require_once( 'Classes/wpBannerizeAdmin.php' );
    $wpBannerizeAdmin = new WPBannerizeAdmin( __FILE__ );
    require_once( 'Classes/wpBannerizeAjax.php' );
} else {
    if ( is_admin() ) {
        require_once( 'Classes/wpBannerizeAdmin.php' );
        //
        $wpBannerizeAdmin = new WPBannerizeAdmin( __FILE__ );
        $wpBannerizeAdmin->register_plugin_settings( __FILE__ );
        register_activation_hook( __FILE__, array( &$wpBannerizeAdmin, 'pluginDidActive' ) );
        register_activation_hook( __FILE__, array( &$wpBannerizeAdmin, 'pluginDidDeactive' ) );
    } else {
        require_once( 'Classes/wpBannerizeFrontend.php' );
        $wpBannerizeFrontend = new WPBannerizeFrontend( __FILE__ );
        require_once( 'Classes/wpBannerizeFunctions.php' );
    }
}