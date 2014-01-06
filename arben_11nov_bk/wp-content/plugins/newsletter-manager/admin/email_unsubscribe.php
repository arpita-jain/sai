<?php
global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$xyz_em_emailId = absint($_GET['id']);
$xyz_em_pageno = absint($_GET['pageno']);
$xyz_em_search = '';
if(isset($_GET['search']))
$xyz_em_search = trim($_GET['search']);
if($xyz_em_emailId=="" || !is_numeric($xyz_em_emailId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails'));
	exit();

}
$emailCount = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_address WHERE id="'.$xyz_em_emailId.'" ' ) ;

if(count($emailCount) == 0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails'));
	exit();
}else{
	$xyz_em_status = 0;
	$time = time();
	
	$wpdb->update($wpdb->prefix.'xyz_em_address_list_mapping', array('status'=>$xyz_em_status,'last_update_time'=>$time), array('ea_id'=>$xyz_em_emailId));
	
	//$wpdb->query( 'UPDATE  '.$wpdb->prefix.'xyz_em_address_list_mapping SET status="'.$xyz_em_status.'" WHERE ea_id="'.$xyz_em_emailId.'" ' ) ;
	if($xyz_em_search=='')
		header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails&emailmsg=2&pagenum='.$xyz_em_pageno));
	else
		header("Location:".admin_url('admin.php?page=newsletter-manager-searchemails&search='.$xyz_em_search));
	
	exit();

}
?>
