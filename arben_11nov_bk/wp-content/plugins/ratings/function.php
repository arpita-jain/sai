<?php
session_start();

function getData()
{
    global $wpdb;
    $aboutuser = $_SESSION["rating_aboutname"];
    $user = wp_get_current_user();
    $userid = $user->ID;
    $tbl_name=$wpdb->prefix.'rating';
    $query = "SELECT * FROM ".$tbl_name." where fromuser=".$userid." and aboutuser='".$aboutuser."'";
    $myrows = $wpdb->get_results( $query );
    return $myrows;
}

function getDataId()
{
    global $wpdb;
    $aboutuser = $_SESSION["rating_aboutname"];
    
    $userid = $_REQUEST['id'];
    $tbl_name=$wpdb->prefix.'rating';
    $query = "SELECT * FROM ".$tbl_name." where fromuser=".$userid." and aboutuser='".$aboutuser."'";
    $myrows = $wpdb->get_results( $query );
    return $myrows;
}