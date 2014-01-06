<?php
require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
global $wpdb;
$tbl_name = $wpdb->prefix.'postmeta';
$current_user = wp_get_current_user();
$uid  = $current_user->ID;
$type = $_REQUEST['type'];
switch($type)
{
    case 'upload':
        $cat = $_REQUEST['cat'];
        $query = "select a.*, b.* from $tbl_name as a, $tbl_name as b where a.meta_key = 'user' and a.meta_value =$uid and b.meta_value='".$cat."' and a.post_id=b.post_id";
        $results = $wpdb->get_results($query);
        $cnt = count($results);
        if($cnt >= 5)
        {
            echo 1;
        }
        else
        {
        echo 0;
        }
        break;
    case 'beforeupload':
        $cat = $_REQUEST['cat'];
        $query = "select a.*, b.* from $tbl_name as a, $tbl_name as b where a.meta_key = 'user' and a.meta_value =$uid and b.meta_value='".$cat."' and a.post_id=b.post_id";
        $results = $wpdb->get_results($query);
        $cnt = count($results);
        echo $bel = 5-$cnt;
        break;
}


die;