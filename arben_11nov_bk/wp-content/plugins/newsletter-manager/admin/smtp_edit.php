<?php
global $wpdb;

if($_POST){

$_POST=xyz_trim_deep($_POST);
$_POST = stripslashes_deep($_POST);

if (($_POST['xyz_em_SmtpHostName']!= "") && ($_POST['xyz_em_SmtpEmailAddress'] != "") && ($_POST['xyz_em_SmtpPassword'] != "") && 
		($_POST['xyz_em_SmtpPortNumber']!= "") && ($_POST['xyz_em_SmtpSecuirity']!= "")){
			
			$xyz_em_SmtpAuthentication = $_POST['xyz_em_SmtpAuthentication'];
			$xyz_em_SmtpHostName = $_POST['xyz_em_SmtpHostName'];
			$xyz_em_SmtpEmailAddress = $_POST['xyz_em_SmtpEmailAddress'];
			$xyz_em_SmtpPassword = $_POST['xyz_em_SmtpPassword'];
			$xyz_em_SmtpPortNumber = $_POST['xyz_em_SmtpPortNumber'];
			$xyz_em_SmtpSecuirity = $_POST['xyz_em_SmtpSecuirity'];
			$xyz_em_hiddenSmtpId = $_POST['xyz_em_hiddenSmtpId'];
			
			$blockedAccount_em = 0;
			
			if($_POST['xyz_em_SmtpSetDefault']=="on"){
				
				$xyz_em_SmtpSetDefault = 1;
				
				$queryDefaultChecking = $wpdb->get_results( 'SELECT status FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE id="'.$xyz_em_hiddenSmtpId.'"' ) ;
				$queryDefaultChecking = $queryDefaultChecking[0];
				if($queryDefaultChecking->status == 1){
					$wpdb->query('UPDATE '.$wpdb->prefix.'xyz_em_sender_email_address SET set_default="0"');
				}else{
					$blockedAccount_em = 1;
				}
			}else{
				$xyz_em_SmtpSetDefault = 0;
			}
			
			$xyz_em_smtpAccountCount = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE user="'.$xyz_em_SmtpEmailAddress.'"  AND id!="'.$xyz_em_hiddenSmtpId.'"  LIMIT 0,1' ) ;
			if(count($xyz_em_smtpAccountCount) == 0){
				
				if($blockedAccount_em == 0){
					$wpdb->update($wpdb->prefix.'xyz_em_sender_email_address', 
					array('authentication'=>$xyz_em_SmtpAuthentication,'host'=>$xyz_em_SmtpHostName,'user'=>$xyz_em_SmtpEmailAddress,'password'=>$xyz_em_SmtpPassword,
					'port'=>$xyz_em_SmtpPortNumber,'security'=>$xyz_em_SmtpSecuirity,'set_default'=>$xyz_em_SmtpSetDefault), array('id'=>$xyz_em_hiddenSmtpId));
				}elseif($blockedAccount_em == 1){
					$wpdb->update($wpdb->prefix.'xyz_em_sender_email_address',
							array('authentication'=>$xyz_em_SmtpAuthentication,'host'=>$xyz_em_SmtpHostName,'user'=>$xyz_em_SmtpEmailAddress,'password'=>$xyz_em_SmtpPassword,
									'port'=>$xyz_em_SmtpPortNumber,'security'=>$xyz_em_SmtpSecuirity), array('id'=>$xyz_em_hiddenSmtpId));
				}
				?>
				
				
				<div class="system_notice_area_style1" id="system_notice_area">
				SMTP account successfully updated. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
				</div>
				
				
				<?php
			}else{
				?>
				<div class="system_notice_area_style0" id="system_notice_area">
				Email address already exist. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
				</div>
				<?php
				
			}

}else{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please fill all fields. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php 
}
}
?>

<div>

<?php 

$_GET = stripslashes_deep($_GET);
$xyz_em_SmtpId = intval($_GET['id']);
$xyz_em_pageno = intval($_GET['pageno']);

if($xyz_em_SmtpId=="" || !is_numeric($xyz_em_SmtpId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp'));
	exit();
}

$xyz_em_details = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE id="'.$xyz_em_SmtpId.'"' ) ;

$campCount = count($xyz_em_details);
if($campCount==0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-smtp&smtpmsg=3'));
	exit();
}else{
	
	$xyz_em_details = $xyz_em_details[0];

}

?>


<h2>Edit SMTP Account</h2>
	<form method="post">
	<div style="float: left;width: 99%">
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpAuthentication">Authentication<span style="color:red;">*</span> </label>
				</td>
				<td><select name="xyz_em_SmtpAuthentication" id="xyz_em_SmtpAuthentication">
						<option value="true"
						<?php if(isset($_POST['xyz_em_SmtpAuthentication']) && $_POST['xyz_em_SmtpAuthentication']=='true') { echo 'selected';}elseif($xyz_em_details->authentication =="true"){echo 'selected';} ?>>True</option>
						<option value="false"
						<?php if(isset($_POST['xyz_em_SmtpAuthentication']) && $_POST['xyz_em_SmtpAuthentication']=='false') { echo 'selected';}elseif($xyz_em_details->authentication=="false"){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
			
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpHostName">Host Name<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpHostName" type="text"
					id="xyz_em_SmtpHostName" value="<?php if(isset($_POST['xyz_em_SmtpHostName']) ){echo esc_attr($_POST['xyz_em_SmtpHostName']);}else{echo esc_attr($xyz_em_details->host);} ?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpEmailAddress">SMTP Username<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpEmailAddress" type="text"
					id="xyz_em_limit" value="<?php if(isset($_POST['xyz_em_SmtpEmailAddress']) ){echo esc_attr($_POST['xyz_em_SmtpEmailAddress']);}else{echo esc_attr($xyz_em_details->user);}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpPassword">Password<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpPassword" type="password"
					id="xyz_em_SmtpPassword" value="<?php if(isset($_POST['xyz_em_SmtpPassword']) ){echo esc_attr($_POST['xyz_em_SmtpPassword']);}else{echo esc_attr($xyz_em_details->password);}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpPortNumber">Port Number<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpPortNumber" type="text"
					id="xyz_em_SmtpPortNumber" value="<?php if(isset($_POST['xyz_em_SmtpPortNumber']) ){echo esc_attr($_POST['xyz_em_SmtpPortNumber']);}else{echo esc_attr($xyz_em_details->port);}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpSecuirity">Secuirity<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpSecuirity" type="text"
					id="xyz_em_SmtpSecuirity" value="<?php if(isset($_POST['xyz_em_SmtpSecuirity']) ){echo esc_attr($_POST['xyz_em_SmtpSecuirity']);}else{echo esc_attr($xyz_em_details->security) ;}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpSetDefault">Set as Default</label>
				</td>
				<td ><input  name="xyz_em_SmtpSetDefault" type="checkbox"
					id="xyz_em_SmtpSetDefault" <?php if(isset($_POST['xyz_em_SmtpSetDefault']) && $_POST['xyz_em_SmtpSetDefault']== "on" ){?>checked="checked"<?php }elseif($xyz_em_details->set_default == 1){?>checked="checked"<?php }?>/>
				</td>
			</tr>
			<tr>
				<td scope="row" class=" settingInput" id="bottomBorderNone"></td>
				<td colspan=2 id="bottomBorderNone" >
				<div style="height:50px;"><input style="margin:10px 0 20px 0;" id="submit_em" class="button-primary bottonWidth" type="submit" value="Update" /></div>
				
				</td>
			</tr>
			
	</table>
	<input type="hidden" name="xyz_em_hiddenSmtpId" value="<?php if(isset($_POST['xyz_em_hiddenSmtpId']) ){echo esc_attr($_POST['xyz_em_hiddenSmtpId']);}else{echo $xyz_em_details->id;}?>"/>
</div>
</form>
</div>