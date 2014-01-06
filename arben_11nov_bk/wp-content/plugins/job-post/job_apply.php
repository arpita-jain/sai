<?php
echo  "cistest";
echo  $_REQUEST['job_id'];
global $wpdb;
     $job_id=$_REQUEST['job_id'];
    echo  $user_recepitent_id = $wpdb->get_var("SELECT user_id FROM wp_jobpost where id=$job_id");
    echo  $job_title = $wpdb->get_var("SELECT job_type FROM wp_jobpost where id=$job_id");
    echo  $sender = $wpdb->get_var( "SELECT user_login FROM $wpdb->users WHERE id = '$user_recepitent_id' LIMIT 1" );      
?>