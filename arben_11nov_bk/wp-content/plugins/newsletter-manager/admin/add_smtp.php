<?php

global $wpdb;
if($_POST){

$_POST=xyz_trim_deep($_POST);
$_POST = stripslashes_deep($_POST);

if (($_POST['xyz_em_SmtpHostName']!= "") && ($_POST['xyz_em_SmtpEmailAddress'] != "") && ($_POST['xyz_em_SmtpPassword'] != "") && 
		($_POST['xyz_em_SmtpPortNumber']!= "") && ($_POST['xyz_em_SmtpSecuirity']!= "")){
			
	
	
// 		if(is_email($_POST['xyz_em_SmtpEmailAddress'])){
			
			$xyz_em_SmtpAuthentication = $_POST['xyz_em_SmtpAuthentication'];
			$xyz_em_SmtpHostName = $_POST['xyz_em_SmtpHostName'];
			$xyz_em_SmtpEmailAddress = $_POST['xyz_em_SmtpEmailAddress'];
			$xyz_em_SmtpPassword = $_POST['xyz_em_SmtpPassword'];
			$xyz_em_SmtpPortNumber = $_POST['xyz_em_SmtpPortNumber'];
			$xyz_em_SmtpSecuirity = $_POST['xyz_em_SmtpSecuirity'];
			
			if(isset($_POST['xyz_em_SmtpSetDefault']) && $_POST['xyz_em_SmtpSetDefault'] == "on"){
				$xyz_em_SmtpSetDefault = 1;
				$wpdb->query('UPDATE '.$wpdb->prefix.'xyz_em_sender_email_address SET set_default="0"');
			}else{
				$xyz_em_SmtpSetDefault = 0;
			}
			
			$xyz_em_smtpAccountCount = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE user="'.$xyz_em_SmtpEmailAddress.'"  LIMIT 0,1' ) ;
			if(count($xyz_em_smtpAccountCount) == 0){
			
			$wpdb->insert($wpdb->prefix.'xyz_em_sender_email_address', 
			array('authentication'=>$xyz_em_SmtpAuthentication,'host'=>$xyz_em_SmtpHostName,'user'=>$xyz_em_SmtpEmailAddress,
			'password'=>$xyz_em_SmtpPassword,'port'=>$xyz_em_SmtpPortNumber,'security'=>$xyz_em_SmtpSecuirity,'set_default'=>$xyz_em_SmtpSetDefault,
			'status'=>1),array('%s','%s','%s','%s','%s','%s','%d','%d'));
			


?>


<div class="system_notice_area_style1" id="system_notice_area">
	SMTP account successfully added. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>


<?php

			}else{
				?>
				<div class="system_notice_area_style0" id="system_notice_area">
				SMTP username already exist. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
				</div>
				<?php
			}
			
		/*}else{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please enter a valid email. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php		
		}*/

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
<h2>Add SMTP Account</h2>
	<form method="post">
	<div style="float: left;width: 99%">
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpAuthentication">Authentication<span style="color:red;">*</span> </label>
				</td>
				<td><select name="xyz_em_SmtpAuthentication" id="xyz_em_SmtpAuthentication">
						<option value="true"
						<?php if(isset($_POST['xyz_em_SmtpAuthentication']) && $_POST['xyz_em_SmtpAuthentication']=='true') { echo 'selected';} ?>>True</option>
						<option value="false"
						<?php if(isset($_POST['xyz_em_SmtpAuthentication']) && $_POST['xyz_em_SmtpAuthentication']=='false') { echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
			
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpHostName">Host Name<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpHostName" type="text"
					id="xyz_em_SmtpHostName" value="<?php if(isset($_POST['xyz_em_SmtpHostName']) ){echo esc_attr($_POST['xyz_em_SmtpHostName']);}else{echo "localhost";} ?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpEmailAddress">SMTP Username<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpEmailAddress" type="text"
					id="xyz_em_limit" value="<?php if(isset($_POST['xyz_em_SmtpEmailAddress']) ){echo esc_attr($_POST['xyz_em_SmtpEmailAddress']);}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpPassword">Password<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpPassword" type="password"
					id="xyz_em_SmtpPassword" value="<?php if(isset($_POST['xyz_em_SmtpPassword']) ){echo esc_attr($_POST['xyz_em_SmtpPassword']);}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpPortNumber">Port Number<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpPortNumber" type="text"
					id="xyz_em_SmtpPortNumber" value="<?php if(isset($_POST['xyz_em_SmtpPortNumber']) ){echo esc_attr($_POST['xyz_em_SmtpPortNumber']);}else{echo "25";}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpSecuirity">Secuirity<span style="color:red;">*</span> </label>
				</td>
				<td ><input  name="xyz_em_SmtpSecuirity" type="text"
					id="xyz_em_SmtpSecuirity" value="<?php if(isset($_POST['xyz_em_SmtpSecuirity']) ){echo esc_attr($_POST['xyz_em_SmtpSecuirity']);}else{echo "notls";}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_SmtpSetDefault">Set as Default</label>
				</td>
				<td ><input  name="xyz_em_SmtpSetDefault" type="checkbox"
					id="xyz_em_SmtpSetDefault" <?php if(isset($_POST['xyz_em_SmtpSetDefault']) && $_POST['xyz_em_SmtpSetDefault']== "on" ){?>checked="checked"<?php }?>/>
				</td>
			</tr>
			<tr>
				<td scope="row" class=" settingInput" id="bottomBorderNone"></td>
				<td colspan=2 id="bottomBorderNone" >
				<div style="height:50px;"><input style="margin:10px 0 20px 0;" id="submit_em" class="button-primary bottonWidth" type="submit" value="Create" /></div>
				
				</td>
			</tr>
			
	</table>
</div>
</form>
</div>