<?php

/*
template name: payapl return
*/
//print_r($_POST);
require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
wp_redirect('http://constructionmates.co.uk');
wp_redirect('http://constructionmates.co.uk');
global $wpdb;
$tbl_name = $wpdb->prefix.'paypalsetting';
$results = $wpdb->get_results("select * from $tbl_name");
echo $plgpath = $results[0]->returnurl;
//echo "<pre>";
//print_r($_POST); die;
if($_POST)
{
$tbl_name1 = $wpdb->prefix.'paypal';
$data = array('txn_id'=>$_POST['txn_id'],'payer_email'=>$_POST['payer_email'], 'status'=>$_POST['address_status']);
$where = array("id"=>$_POST['item_number']);
$row_affected =$wpdb->update($tbl_name1,$data,$where);
}

wp_redirect($plgpath);