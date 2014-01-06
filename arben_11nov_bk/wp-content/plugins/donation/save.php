<?php

//print_r($_POST);
if($_POST)
{
require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
 $plgpath = site_url().'/wp-admin/admin.php?page=donation';
$tbl_name = $wpdb->prefix.'paypalsetting';

$data = array('email'=>$_POST['email'],'testmode'=>$_POST['testmode'], 'amount'=>$_POST['amount'], 'returnurl'=>$_POST['returnurl'], 'currencycode'=>$_POST['currencycode']);

if($_POST[id] == 1)
{
   // echo "in";die;
     $where=array("id" =>1);
    $row_affected = $wpdb->update( $tbl_name, $data, $where );
}
else
{
    $row_affected =$wpdb->insert($tbl_name,$data);
}
}
wp_redirect($plgpath);