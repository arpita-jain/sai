<?php
/*
template name: payapl return
*/
print_r($_POST);

$plgpath = site_url();
if($_POST)
{
require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
$tbl_name = $wpdb->prefix.'paypal';
//$data['key_word'] = $_POST['keyword'];
//$data['description'] = $_POST['description'];
$data = array('txn_id'=>$_POST['txn_id'],'payer_email'=>$_POST['payer_email'], 'amount'=>$_POST['payment_gross'], 'status'=>$_POST['address_status']);
$row_affected =$wpdb->insert($tbl_name,$data);
}
wp_redirect($plgpath);