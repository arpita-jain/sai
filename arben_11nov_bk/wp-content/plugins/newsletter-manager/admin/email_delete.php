<?php
global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$xyz_em_search = '';
if(isset($_GET['search']))
	$xyz_em_search = trim($_GET['search']);
$xyz_em_emailId = absint($_GET['id']);
$xyz_em_pageno = absint($_GET['pageno']);
if($xyz_em_emailId=="" || !is_numeric($xyz_em_emailId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails'));
	exit();

}
$emailCount = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_address WHERE id="'.$xyz_em_emailId.'" LIMIT 0,1' ) ;

if(count($emailCount) == 0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails'));
	exit();
}else{
	
	$wpdb->query( 'DELETE FROM  '.$wpdb->prefix.'xyz_em_address_list_mapping  WHERE ea_id="'.$xyz_em_emailId.'" ' ) ;
	$wpdb->query( 'DELETE FROM  '.$wpdb->prefix.'xyz_em_additional_field_value  WHERE ea_id="'.$xyz_em_emailId.'" ' ) ;
	$wpdb->query( 'DELETE FROM  '.$wpdb->prefix.'xyz_em_email_address  WHERE id="'.$xyz_em_emailId.'" ' ) ;

	//$wpdb->query('ANALYZE TABLE '.$wpdb->prefix.'xyz_em_email_address');
	if($xyz_em_search=='')
		header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails&emailmsg=3&pagenum='.$xyz_em_pageno));
	else
		header("Location:".admin_url('admin.php?page=newsletter-manager-searchemails&search='.$xyz_em_search));
	
	exit();

}
?>
