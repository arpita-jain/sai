<?php
global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
$xyz_em_SmtpId = intval($_GET['id']);
$xyz_em_SmtpStatus = intval($_GET['status']);
$xyz_em_pageno = intval($_GET['pageno']);

if($xyz_em_SmtpId=="" || !is_numeric($xyz_em_SmtpId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp'));
	exit();
}
$campCount = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE id="'.$xyz_em_SmtpId.'"' ) ;
if(count($campCount) == 0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp&smtpmsg=3'));
	exit();
}else{
	
	$xyz_em_default = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE id="'.$xyz_em_SmtpId.'"' ) ;
	$xyz_em_default = $xyz_em_default[0];
	
	if($xyz_em_default->set_default != 1){
	
		if($xyz_em_SmtpStatus == 0){
			$wpdb->update($wpdb->prefix.'xyz_em_sender_email_address', array('status'=>$xyz_em_SmtpStatus), array('id'=>$xyz_em_SmtpId));
			header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp&smtpmsg=1&pagenum='.$xyz_em_pageno));
			exit();
		}elseif($xyz_em_SmtpStatus == 1){
			
			$wpdb->update($wpdb->prefix.'xyz_em_sender_email_address', array('status'=>$xyz_em_SmtpStatus), array('id'=>$xyz_em_SmtpId));	
			header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp&smtpmsg=2&pagenum='.$xyz_em_pageno));
			exit();
			
		}
		
	}else{
		header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp&smtpmsg=4'));
		exit();
	}
}
?>