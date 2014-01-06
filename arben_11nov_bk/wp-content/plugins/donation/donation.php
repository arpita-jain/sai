<?php
/* plugin name: Donation
Plugin URI: http://codex.wordpress.org/Writing_a_Plugin
Description: This plugin can be use for demo .
Version: The Plugin's Version Number, e.g.: 2.0
Author: Sandeep Pateriya
Author URI: http://www.cisin.com
License: A "Slug" license name e.g. GPL2
*/

function create_table() // for create table
{
    global $wpdb;
    //global $version = 3.0;
    $table_name = $wpdb->prefix . "paypalsetting";
   $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    email varchar(255)  NOT NULL,
    testmode int(255)  NOT NULL,
    amount int(255)  NOT NULL,
    returnurl varchar(255)  NOT NULL,
    currencycode varchar(255)  NOT NULL,
    UNIQUE KEY id (id)
    );";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    $table_name = $wpdb->prefix . "paypal";
   $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    payer_email varchar(255)  NOT NULL,
    txn_id varchar(255)  NOT NULL,
    status varchar(255)  NOT NULL,
    amount varchar(255)  NOT NULL,
     UNIQUE KEY id (id)
    );";
     dbDelta( $sql );
 //add_option( "version", $version );    
}
register_activation_hook( __FILE__, 'create_table' );   // for create table


/* For creating menu and page*/

/** Step 2 (from text above). */
add_action( 'admin_menu', 'createMenu' );

/** Step 1. */
function createMenu() {

	add_menu_page( 'My Plugin Options Menu', 'Donation', 'manage_options', 'donation', 'my_plugin_options_menu' );
	//add_submenu_page( 'donation', 'new', 'New', 'manage_options', 'newform', 'newentry' );
}

/** Step 3. */
function my_plugin_options_menu() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include_once 'admin_donation.php';
}

function getFrontPaypal()
{
    include_once 'myform.php';
}
add_shortcode('frontDonation','getFrontPaypal');

function getFrontPaypalMobile()
{
    include_once 'myform_mobile.php';
}
add_shortcode('frontDonationMobile','getFrontPaypalMobile');