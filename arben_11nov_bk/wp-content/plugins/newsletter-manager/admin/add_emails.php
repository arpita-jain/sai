<?php
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
if(isset($_POST['xyz_em_emails'])){
if ($_POST['xyz_em_emails']!= ""){
	
	global $wpdb;
	
	$xyz_em_emails = $_POST['xyz_em_emails'];
	
	$string = preg_replace("/[\n\r]/"," ",$xyz_em_emails);
	
	$res = preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",$string,$matches);
	$time = time();
	if ($res) {
		
		$emailAddFlag = 0;
		foreach(array_unique($matches[0]) as $email){
			
			
		$email_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_address WHERE email="'.$email.'" LIMIT 0,1' ) ;
			if(count($email_count) == 0){
				$wpdb->insert($wpdb->prefix.'xyz_em_email_address', array('email' => $email,'create_time' => $time,'last_update_time' => $time ),array('%s','%d','%d'));
				
				$lastid = $wpdb->insert_id;
				
				$wpdb->insert($wpdb->prefix.'xyz_em_address_list_mapping', array('ea_id' => $lastid,'el_id' => 1, 'create_time' => $time,'last_update_time' => $time,'status' => 1),array('%d','%d','%d','%d','%d'));
				$emailAddFlag = 1;
			}
			
		}
		if($emailAddFlag == 1){
			header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails&emailmsg=4'));
			exit();
		}
	
	}else{
	
?>
<div class="system_notice_area_style0" id="system_notice_area">
	No emails found. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php

		
	}

}else{

?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please enter atleast one email. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php 

}
}

?>

<div>

	<h2>Add Emails</h2>
	<form method="post">
		<table class="widefat" style="width:98%;" >

			<tr valign="top" class="alternate">
				<td scope="row"><label for="xyz_em_emails">Enter email address</label>
				</td>
				<td>
					<textarea name="xyz_em_emails"  id="xyz_em_emails"></textarea>
				</td>
			</tr>

			<tr>
				<td  scope="row"></td>
				<td >
				<div style="height:50px;"><input style="margin:10px 0 20px 0;" id="submit_em" class="button-primary bottonWidth" type="submit" value=" Add Emails " /></div>
				</td>
			</tr>
			
			<tr>
			<td colspan="2" id="bottomBorderNone">
			
			<b>Note :</b> You can input any unformatted text here. Only valid email address formats will be extracted from your input.
			
			</td></tr>
			
		</table>
	</form>

</div>
