<?php
require_once ABSPATH . WPINC . '/class-phpmailer.php';
require_once ABSPATH . WPINC . '/class-smtp.php';

$phpmailer = new PHPMailer();
$phpmailer->CharSet=get_option('blog_charset');

global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$xyz_em_pageno = absint($_GET['pageno']);


if(isset($_POST['xyz_em_testMailId'])){
	if ($_POST['xyz_em_testMailId']!= ""){
$xyz_em_testEmail = $_POST['xyz_em_testMailId'];
$xyz_em_campId = absint($_POST['campId']);
if($xyz_em_campId=="" || !is_numeric($xyz_em_campId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns'));
	exit();
}
$xyz_em_campDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_campaign WHERE id="'.$xyz_em_campId.'" ' ) ;
if(count($xyz_em_campDetails)==0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns'));
	exit();
}else{
	if(is_email($xyz_em_testEmail)){
		$xyz_em_campDetails = $xyz_em_campDetails[0];
		
		$xyz_em_senderName = $xyz_em_campDetails->sender_name;
		
		if(get_option('xyz_em_sendViaSmtp') == 1){
			
			$fromEmail = '';
			
			if($xyz_em_campDetails->sender_email != ''){
				$fromEmail = $xyz_em_campDetails->sender_email;
			}
			
			if($xyz_em_campDetails->sender_email_id == 0){
				$xyz_em_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE 	set_default ="1"' ) ;
			}else{
				$xyz_em_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE 	id="'.$xyz_em_campDetails->sender_email_id.'"' ) ;
			}
			$xyz_em_SmtpDetails = $xyz_em_SmtpDetails[0];
			
			if($xyz_em_campDetails->sender_email == ''){
				$fromEmail = $xyz_em_SmtpDetails->user;
			}
			
			$phpmailer->IsSMTP();
			$phpmailer->Host = $xyz_em_SmtpDetails->host;
			$phpmailer->SMTPDebug = get_option('xyz_em_SmtpDebug');
			if($xyz_em_SmtpDetails->authentication=='true')
				$phpmailer->SMTPAuth = TRUE;
			
			$phpmailer->SMTPSecure = $xyz_em_SmtpDetails->security;
			$phpmailer->Port = $xyz_em_SmtpDetails->port;
			$phpmailer->Username = $xyz_em_SmtpDetails->user;
			$phpmailer->Password = $xyz_em_SmtpDetails->password;
			
			$phpmailer->From     = $fromEmail;
			$phpmailer->FromName = $xyz_em_senderName;
			//$phpmailer->SetFrom($xyz_em_senderEmail,$xyz_em_senderName); /* code changed */
			
			$phpmailer->AddReplyTo($xyz_em_SmtpDetails->user,$xyz_em_senderName);
			
		}else{
			$phpmailer->IsMail();
			
			$xyz_em_senderEmail = $xyz_em_campDetails->sender_email;
			
			$phpmailer->From     = $xyz_em_senderEmail;
			$phpmailer->FromName = $xyz_em_senderName;
			//$phpmailer->SetFrom($xyz_em_senderEmail,$xyz_em_senderName); /* code changed */
			
			$phpmailer->AddReplyTo($xyz_em_senderEmail,$xyz_em_senderName);
		}
		
		//$xyz_em_attachments = array();
		$xyz_em_attachmentDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_attachment WHERE campaigns_id="'.$xyz_em_campId.'" ' ) ;
		if($xyz_em_attachmentDetails){
		
			$xyz_em_dir = "uploads/xyz_em/attachments/";
			$xyz_em_targetfolder = realpath(dirname(__FILE__) . '/../../../')."/".$xyz_em_dir;
		
			foreach ($xyz_em_attachmentDetails as $xyz_em_attchDetail){
				$phpmailer->AddAttachment($xyz_em_targetfolder.$xyz_em_attchDetail->name);
			}
		}
		
		
		
		
		
		
		
		$type = $xyz_em_campDetails->type;
		$xyz_em_body 	 = $xyz_em_campDetails->body;
		$xyz_em_body =  str_replace("{field1}","Name",$xyz_em_body);
		
		$xyz_em_subject = str_replace("{field1}","Name",$xyz_em_campDetails->subject);
		
		$xyz_em_altBody = $xyz_em_campDetails->alt_body;
		$xyz_em_altBody = str_replace("{field1}","Name",$xyz_em_altBody);

		$phpmailer->Subject = $xyz_em_subject;

		$unsubscriptionLink = plugins_url("newsletter-manager/demo_unsubscription.php");
		
		$xyz_em_body = str_replace("{unsubscribe-url}",$unsubscriptionLink,$xyz_em_body);
		if($xyz_em_campDetails->type == 2){
			
			$linkAltBody =  str_replace("{unsubscribe-url}",$unsubscriptionLink,'Use the following link to unsubscribe {unsubscribe-url}.');
			$link =  str_replace("{unsubscribe-url}",$unsubscriptionLink,'<a href="{unsubscribe-url}">Click here</a> to unsubscribe.');
			
			$phpmailer->AltBody    =  str_replace("{unsubscribe-option}",$linkAltBody,$xyz_em_altBody);// optional, comment out and test
			
			$xyz_em_body = str_replace("{unsubscribe-option}",$link,$xyz_em_body);
			
			$phpmailer->MsgHTML($xyz_em_body);
		
		}elseif($xyz_em_campDetails->type == 1){
		
			$link =  str_replace("{unsubscribe-url}",$unsubscriptionLink,"Use the following link to unsubscribe {unsubscribe-url}.");
			$phpmailer->Body = str_replace("{unsubscribe-option}",$link,$xyz_em_body);
			$phpmailer->Body = $xyz_em_body;
			
		}
		
		$phpmailer->AddAddress($xyz_em_testEmail);
		
		$sent = $phpmailer->Send();
		
		if($sent == FALSE) {
			
			//echo  "Mailer Error: " .$phpmailer->ErrorInfo;
		
		} elseif($sent == TRUE) {
			
			header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns&campmsg=4&pagenum='.$xyz_em_pageno));
			exit();
			
		}
		
	}else{
		?>
		<div class="system_notice_area_style0" id="system_notice_area">
	Please enter a valid email.&nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
		
		
		<?php
		
	}
}

	}else{
		?>
		<div class="system_notice_area_style0" id="system_notice_area">
	Please fill fields.&nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
		
		
		<?php
		
	}
}

?>

<div>

	<h2>Send Test Mail</h2>
	<form method="post">
		<table class="widefat" style="width:98%;" >

			<tr valign="top">
				<td scope="row"><label for="xyz_em_testMailId">Enter email address</label>
				</td>
				<td>
					<input type="text" name="xyz_em_testMailId" value="<?php if(isset($_POST['xyz_em_testMailId'])) echo esc_attr($_POST['xyz_em_testMailId']); ?>">
				</td>
			</tr>

			<tr>
				<td scope="row" id="bottomBorderNone"></td>
				<td id="bottomBorderNone"><br> <input style="margin-bottom:15px;" class="button-primary bottonWidth" id="submit_em" type="submit" value="Send Test Mail" /></td>
			</tr>
		</table>
			<input type="hidden" name="campId"
				value="<?php echo absint($_GET['id']); ?>">
	</form>

</div>
