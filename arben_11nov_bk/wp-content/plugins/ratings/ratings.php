<?php
/*
Plugin Name: cis_ratings
Plugin URI: http://www.cisin.com
Description: A simple rating with comments plugin 
Author: deevan
*/


function createTab() // for create table
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rating";
    $sql = "CREATE TABLE $table_name (
    id int(255) NOT NULL AUTO_INCREMENT,
    rating int(255)  NOT NULL,
    comment varchar(1000)  NOT NULL,
    fromuser varchar(255) ,
    aboutuser varchar(255),
    UNIQUE KEY id (id)
    );";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
   
}
register_activation_hook( __FILE__, 'createTab' );   // for create table
require_once(dirname(__FILE__) . '/rating_comment_form.php');
?>