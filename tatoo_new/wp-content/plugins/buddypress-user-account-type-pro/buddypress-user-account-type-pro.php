<?php

/**
 * Plugin Name: BuddyPress user account type PRO
 * Plugin URI:  http://wpbpshop.com/buddypress-user-account-type-pro
 * Description: Categories you buddypress users and manage
 * Author:      wp.bp.shop
 * Author URI:  http://wpbpshop.com
 * Version:     1.0.4
 * Text Domain: buddypress
 * License:     GPLv2 or later (license.txt)
 */

define('BUATP_VERSION','1.0.4');
define('BUATP_ROOT',dirname(__FILE__).'/');
define('BUATP_INC',BUATP_ROOT.'include/');
define('BUATP_LIB',BUATP_ROOT.'lib/');
define('BUATP_TEMPLATE',BUATP_ROOT.'templates/');
define('BUATP_DIR',basename(dirname(__FILE__)));

register_activation_hook( __FILE__,'buatp_activate');
register_deactivation_hook( __FILE__,'buatp_deactivate');

function buatp_activate() { }
function buatp_deactivate() { }

/*
 * Check if buddypress is installed or not
 */
function buatp_checker() {
    if(!is_plugin_active('buddypress/bp-loader.php')):
        echo '<div class="error"><p>';
        echo __('You must need to install and active <b><a href="'.site_url().'/wp-admin/plugin-install.php?tab=search&type=term&s=buddypress&plugin-search-input=Search+Plugins">
        Buddypress</strong></a> to use <strong>Buddypress User Account Type PRO </b> plugin','buatp');
        echo '</p></div>';
    endif;
}
add_action('admin_notices', 'buatp_checker');

/*
 * Loads all BuddyPress User Account type PRO files only if BuddyPress is installed
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(is_plugin_active('buddypress/bp-loader.php')):

require_once (  BUATP_INC.'buatp-ajax.php'       );
require_once (  BUATP_INC.'buatp-functions.php'  );
require_once (  BUATP_INC.'buatp-hooks.php'      );
require_once (  BUATP_INC.'buatp-updater.php'    );

// BUATP custom
if( file_exists( WP_PLUGIN_DIR.'/buatp-custom.php'   ))
    require_once ( WP_PLUGIN_DIR.'/buatp-custom.php' );

// Including admin settings files
if(is_admin()) {
    require_once (  BUATP_INC.'admin/buatp-options.class.php'   );
    require_once (  BUATP_INC.'admin/buatp-admin-pages.php'     );   
}

function buatp_script_loader(){
    wp_enqueue_script(
		'buat-admin-js',
		plugins_url('/lib/js/admin.js', __FILE__),
                array('jquery')
	);
    wp_localize_script( 'buat-admin-js', 'buatpJsVars', array( 'buatpAjaxUrl' => site_url().'/wp-admin/admin-ajax.php') );
 
}
add_action('wp_enqueue_scripts', 'buatp_script_loader');
add_action('admin_enqueue_scripts','buatp_script_loader');

function buatp_style_loader(){
    wp_register_style( 'buatp-style', plugins_url('/lib/css/style.css', __FILE__) );
    wp_enqueue_style( 'buatp-style' );
    if( is_admin() || is_network_admin()) {
    wp_register_style( 'buatp-admin-style', plugins_url('/lib/css/admin-style.css', __FILE__) );
    wp_enqueue_style( 'buatp-admin-style' );
    }
}
add_action( 'wp_enqueue_scripts', 'buatp_style_loader' );
add_action('admin_enqueue_scripts','buatp_style_loader');
endif;  
?>