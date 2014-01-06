<?php
global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
$xyz_em_SmtpId = intval($_GET['id']);
$xyz_em_pageno = intval($_GET['pageno']);

if($xyz_em_SmtpId=="" || !is_numeric($xyz_em_SmtpId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp'));
	exit();

}
$emailCount = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE id="'.$xyz_em_SmtpId.'" LIMIT 0,1' ) ;

if(count($emailCount) == 0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp&smtpmsg=3'));
	exit();
}else{
	
	
	$xyz_em_default = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE id="'.$xyz_em_SmtpId.'"' ) ;
	$xyz_em_default = $xyz_em_default[0];
	
	if($xyz_em_default->set_default != 1){
	
		$wpdb->query( 'DELETE FROM  '.$wpdb->prefix.'xyz_em_sender_email_address  WHERE id="'.$xyz_em_SmtpId.'" ' ) ;
		
		header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp&smtpmsg=5&pagenum='.$xyz_em_pageno));
		exit();
	}else{
		header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp&smtpmsg=6&pagenum='.$xyz_em_pageno));
		exit();
	}
}
?>