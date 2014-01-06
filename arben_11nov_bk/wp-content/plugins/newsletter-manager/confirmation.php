<?php 
require( dirname( __FILE__ ) . '../../../../wp-load.php' );
require_once ABSPATH . WPINC . '/class-phpmailer.php';
$phpmailer = new PHPMailer();
$phpmailer->CharSet=get_option('blog_charset');

global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
$xyz_em_emailId = absint($_GET['eId']);
$xyz_em_listId = absint($_GET['lId']);

$xyz_em_both = $_GET['both'];


$xyz_em_email = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_address WHERE id="'.$xyz_em_emailId.'" ') ;
$xyz_em_email = $xyz_em_email[0];

$combine = $xyz_em_emailId.$xyz_em_listId.$xyz_em_email->email;
$combineValue = md5($combine);


$xyz_em_url = base64_decode($_GET['appurl']);
if($xyz_em_url=='')
	$xyz_em_url=get_option('xyz_em_emailConfirmation');

if($combineValue == $xyz_em_both){
	
$xyz_em_statusWelcomeFlag = 0;
if(($xyz_em_emailId != "") && ($xyz_em_listId != "") && ($xyz_em_url != "")){
	$xyz_em_mapping = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_address_list_mapping WHERE el_id="'.$xyz_em_listId.'" AND ea_id="'.$xyz_em_emailId.'" ') ;
	$xyz_em_mapping = $xyz_em_mapping[0];
	if(($xyz_em_mapping->status == 0) || ($xyz_em_mapping->status == -1)){
		$xyz_em_statusWelcomeFlag = 1;
	}
	$time = time();
	$wpdb->update($wpdb->prefix.'xyz_em_address_list_mapping',array('status'=>1,'last_update_time'=>$time),array('ea_id'=>$xyz_em_emailId,'el_id'=>$xyz_em_listId));

	if(get_option('xyz_em_enableWelcomeEmail') == "True"){
		if($xyz_em_statusWelcomeFlag == 1){
				
			$xyz_em_template = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id="1" ') ;
			$xyz_em_template = $xyz_em_template[0];
				$xyz_em_senderName = get_option('xyz_em_dsn');
			
			if(get_option('xyz_em_sendViaSmtp') == 1){
			
			
			
				$xyz_em_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE 	set_default ="1"' ) ;
				$xyz_em_SmtpDetails = $xyz_em_SmtpDetails[0];
			
				$phpmailer->IsSMTP();
				$phpmailer->Host = $xyz_em_SmtpDetails->host;
				$phpmailer->SMTPDebug = get_option('xyz_em_SmtpDebug');
				if($xyz_em_SmtpDetails->authentication=='true')
					$phpmailer->SMTPAuth = TRUE;
				
				$phpmailer->SMTPSecure = $xyz_em_SmtpDetails->security;
				$phpmailer->Port = $xyz_em_SmtpDetails->port;

				$phpmailer->Username = $xyz_em_SmtpDetails->user;
				$phpmailer->Password = $xyz_em_SmtpDetails->password;
				
				if(is_email(get_option('xyz_em_dse'))){
					$phpmailer->From     = get_option('xyz_em_dse');
				}else{
					$phpmailer->From     = $xyz_em_SmtpDetails->user;
				}
				
				$phpmailer->FromName = $xyz_em_senderName;
			
				$phpmailer->AddReplyTo($xyz_em_SmtpDetails->user,$xyz_em_senderName);
			
			}else{
			
				$phpmailer->IsMail();
				$xyz_em_senderEmail = get_option('xyz_em_dse');
				
				$phpmailer->From     = $xyz_em_senderEmail;
				$phpmailer->FromName = $xyz_em_senderName;
				
				$phpmailer->AddReplyTo($xyz_em_senderEmail,$xyz_em_senderName);
				
			}
			
			$xyz_em_message = $xyz_em_template->message;
			
			$xyz_em_messageToSend = nl2br($xyz_em_message);
			
			

			
			
			$xyz_em_fieldInfoDetails = $wpdb->get_results( 'SELECT default_value FROM '.$wpdb->prefix.'xyz_em_additional_field_info WHERE field_name="Name"' ) ;
			$xyz_em_fieldInfoDetails = $xyz_em_fieldInfoDetails[0];
			
			$xyz_em_fieldValueDetails = $wpdb->get_results( 'SELECT field1 FROM '.$wpdb->prefix.'xyz_em_additional_field_value WHERE ea_id="'.$xyz_em_emailId.'"' ) ;
			$xyz_em_fieldValueDetails = $xyz_em_fieldValueDetails[0];
			
			if($xyz_em_fieldValueDetails->field1 != ""){
			
				$xyz_em_messageToSend =  str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_messageToSend);
				$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_template->subject);
			
			}else{
				$xyz_em_messageToSend =  str_replace("{field1}",$xyz_em_fieldInfoDetails->default_value,$xyz_em_messageToSend);
				$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->default_value,$xyz_em_template->subject);
			}
			
			$phpmailer->Subject = $xyz_em_subject;
			
			$phpmailer->MsgHTML($xyz_em_messageToSend);
			
			$phpmailer->AddAddress($xyz_em_email->email);
			
			$sent = $phpmailer->Send();
			
			if($sent == FALSE) {
			
// 				echo  "Mailer Error: " .$phpmailer->ErrorInfo;
			
			} elseif($sent == TRUE) {}
		}
	}
	if(strpos($xyz_em_url,'?') > 0)
	{
		$xyz_em_url = $xyz_em_url."&result=success";
	
	}else{
		$xyz_em_url = $xyz_em_url."?result=success";
	}
	
	if($xyz_em_statusWelcomeFlag == 1)
		$xyz_em_url = $xyz_em_url."&confirm=true"; // need to confirm.
	else
		$xyz_em_url = $xyz_em_url."&confirm=false"; // already confirmed.
	
	header("Location:".$xyz_em_url);
	exit();
	

}else{
	
	if(strpos($xyz_em_url,'?') > 0)
	{
		$xyz_em_url = $xyz_em_url."&result=failure";
	
	}else{
		$xyz_em_url = $xyz_em_url."?result=failure";
	}
	
	header("Location:".$xyz_em_url);
	exit();
}

}else{
	
	
	if(strpos($xyz_em_url,'?') > 0)
		header("Location:".$xyz_em_url."&result=failure");
	else
		header("Location:".$xyz_em_url."?result=failure");
	exit();
}


?>