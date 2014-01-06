<?php

global $wpdb;
// Load the options

$xyz_em_SmtpFlag = 0;

if($_POST){
	
// 	echo "hesl:".$_POST['xyz_em_hesl']."<br/>";
// 	echo "dsel:".$_POST['xyz_em_dse']."<br/>";
// 	echo "dsn:".$_POST['xyz_em_dsn']."<br/>";
// 	echo "dsubname:".$_POST['xyz_em_dsubname']."<br/>";die;
$_POST=xyz_trim_deep($_POST);
$_POST = stripslashes_deep($_POST);

if (($_POST['xyz_em_hesl']!= "") && ($_POST['xyz_em_dse'] != "") && ($_POST['xyz_em_dsn'] != "") && ($_POST['xyz_em_dsubname']!= "") 
		&& ($_POST['xyz_em_afterSubscription']!= "") && ($_POST['xyz_em_emailConfirmation']!= "") && ($_POST['xyz_em_redirectAfterLink']!= "") ){
			$xyz_em_hesl = abs(intval($_POST['xyz_em_hesl']));
			
			$xyz_em_sendViaSmtp = $_POST['xyz_em_sendViaSmtp'];
			
			if($xyz_em_sendViaSmtp == 1){
			
				$checkSMTP = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."xyz_em_sender_email_address WHERE set_default='1'");
				if(count($checkSMTP) == 0){
					$xyz_em_SmtpFlag = 1;
				}
			
			}
			if($xyz_em_SmtpFlag != 1){
			
	
	if ( $xyz_em_hesl > 0 ){
		if(is_email($_POST['xyz_em_dse'])){
			
			$xyz_em_filter = $_POST['xyz_em_filter'];

			$xyz_em_dss = $_POST['xyz_em_dss'];
			$xyz_em_defaultEditor = $_POST['xyz_em_defaultEditor'];
			$xyz_em_dse = $_POST['xyz_em_dse'];
			$xyz_em_dsn = $_POST['xyz_em_dsn'];
			$xyz_em_enableWelcomeEmail = $_POST['xyz_em_enableWelcomeEmail'];
			$xyz_em_enableUnsubNotification = $_POST['xyz_em_enableUnsubNotification'];
			
			$xyz_em_afterSubscription = strip_tags($_POST['xyz_em_afterSubscription']);
			$xyz_em_emailConfirmation = strip_tags($_POST['xyz_em_emailConfirmation']);
			$xyz_em_redirectAfterLink = strip_tags($_POST['xyz_em_redirectAfterLink']);
			
			$xyz_em_limit = abs(intval($_POST['xyz_em_limit']));
			
			$xyz_em_widgetName = $_POST['xyz_em_widgetName'];
			
			$xyz_em_credit = $_POST['xyz_em_credit'];
			
			
			$xyz_em_SmtpDebug = $_POST['xyz_em_SmtpDebug'];
			
			if ( $xyz_em_limit > 0  ){

			update_option('xyz_em_tinymce_filter',$xyz_em_filter);
			update_option('xyz_em_hesl',$xyz_em_hesl);
			update_option('xyz_em_dss',$xyz_em_dss);
			update_option('xyz_em_defaultEditor',$xyz_em_defaultEditor);
			update_option('xyz_em_dse',$xyz_em_dse);
			update_option('xyz_em_dsn',$xyz_em_dsn);
			update_option('xyz_em_enableWelcomeEmail',$xyz_em_enableWelcomeEmail);
			update_option('xyz_em_enableUnsubNotification',$xyz_em_enableUnsubNotification);
			
			update_option('xyz_em_afterSubscription',$xyz_em_afterSubscription);
			update_option('xyz_em_emailConfirmation',$xyz_em_emailConfirmation);
			update_option('xyz_em_redirectAfterLink',$xyz_em_redirectAfterLink);
			
			update_option('xyz_em_limit',$xyz_em_limit);
			
			update_option('xyz_em_widgetName',$xyz_em_widgetName);
			
			update_option('xyz_credit_link',$xyz_em_credit);
			
			update_option('xyz_em_sendViaSmtp',$xyz_em_sendViaSmtp);
			update_option('xyz_em_SmtpDebug',$xyz_em_SmtpDebug);
			
			
			
			$xyz_em_dsubname = $_POST['xyz_em_dsubname'];
			$wpdb->update($wpdb->prefix.'xyz_em_additional_field_info', array('default_value'=>$xyz_em_dsubname), array('field_name'=>"Name"));
			
			$xyz_em_subject1 = $_POST['xyz_em_subject1'];
			$xyz_em_message1 = $_POST['xyz_em_message1'];
			$wpdb->update($wpdb->prefix.'xyz_em_email_template', array('subject'=>$xyz_em_subject1,'message'=>$xyz_em_message1), array('id'=>1));
			
			$xyz_em_subject2 = $_POST['xyz_em_subject2'];
			$xyz_em_message2 = $_POST['xyz_em_message2'];
			$wpdb->update($wpdb->prefix.'xyz_em_email_template', array('subject'=>$xyz_em_subject2,'message'=>$xyz_em_message2), array('id'=>2));
			
			$xyz_em_subject3 = $_POST['xyz_em_subject3'];
			$xyz_em_message3 = $_POST['xyz_em_message3'];
			$wpdb->update($wpdb->prefix.'xyz_em_email_template', array('subject'=>$xyz_em_subject3,'message'=>$xyz_em_message3), array('id'=>3));
			


?>


<div class="system_notice_area_style1" id="system_notice_area">
	Settings updated successfully. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>


<?php
			}else{
?>

	<div class="system_notice_area_style0" id="system_notice_area">
	Pagination Limit must be a positive whole number. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php 
			}
		}else{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please enter a valid email. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php		
		}
	}else{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Email sending limit must be a positive whole number. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php		
	}
}else{

	?>
	<div class="system_notice_area_style0" id="system_notice_area">
	Please set a default SMTP account. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
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

if(get_option('xyz_em_tinymce_filter')=="1"){
	require( dirname( __FILE__ ) . '/tinymce_filters.php' );
}

?>

<div>

	<h2>Settings</h2>
	<form method="post">
	<div style="float: left;width: 49%">
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 0px 15px 10px;">
	<legend >General</legend>
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row" ><label for="xyz_em_filter">Tiny MCE filters to prevent auto removal of  &lt;br&gt; and &lt;p&gt; tags </label>
				</td>
				<td><select name="xyz_em_filter" id="xyz_em_filter">
						<option value="1"
						<?php if(isset($_POST['xyz_em_filter']) && $_POST['xyz_em_filter']=='1') { echo 'selected';}elseif(get_option('xyz_em_tinymce_filter')=="1"){echo 'selected';} ?>>Enable</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_filter']) && $_POST['xyz_em_filter']=='0') { echo 'selected';}elseif(get_option('xyz_em_tinymce_filter')=="0"){echo 'selected';} ?>>Disable</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_defaultEditor">HTML Campaign Editor </label>
				</td>
				<td><select name="xyz_em_defaultEditor" id="xyz_em_defaultEditor">
						<option value="HTML Editor"
						<?php if(isset($_POST['xyz_em_defaultEditor']) && $_POST['xyz_em_defaultEditor']=='HTML Editor') { echo 'selected';}elseif(get_option('xyz_em_defaultEditor')=="HTML Editor"){echo 'selected';} ?>>HTML Editor</option>
						<option value="Text Editor"
						<?php if(isset($_POST['xyz_em_defaultEditor']) && $_POST['xyz_em_defaultEditor']=='Text Editor') { echo 'selected';}elseif(get_option('xyz_em_defaultEditor')=="Text Editor"){echo 'selected';} ?>>Text Editor</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_em_credit">Credit link to author</label>
				</td>
				<td><select name="xyz_em_credit" id="xyz_em_credit">
						<option value="em"
						<?php if(isset($_POST['xyz_em_credit']) && $_POST['xyz_em_credit']=='em') { echo 'selected';}elseif(get_option('xyz_credit_link')=="em"){echo 'selected';} ?>>Enable</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_credit']) && $_POST['xyz_em_credit']!='em') { echo 'selected';}elseif(get_option('xyz_credit_link')!="em"){echo 'selected';} ?>>Disable</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_em_limit">Pagination Limit</label>
				</td>
				<td id="bottomBorderNone"><input  name="xyz_em_limit" type="text"
					id="xyz_em_limit" value="<?php if(isset($_POST['xyz_em_limit']) ){echo abs(intval($_POST['xyz_em_limit']));}else{print(get_option('xyz_em_limit'));} ?>" />
				</td>
			</tr>
			
	</table>
	</fieldset>
	
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 0px 15px 10px;">
	<legend>Email Sending Settings</legend>
	<table class="widefat"  style="width:99%;">
		<tr valign="top">
				<td scope="row" ><label for="xyz_em_sendViaSmtp">Send via SMTP</label>
				</td>
				<td><select name="xyz_em_sendViaSmtp" id="xyz_em_sendViaSmtp">
						<option value="1"
						<?php if(isset($_POST['xyz_em_sendViaSmtp']) && $_POST['xyz_em_sendViaSmtp']=='1') { echo 'selected';}elseif(get_option('xyz_em_sendViaSmtp')=="1"){echo 'selected';} ?>>True</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_sendViaSmtp']) && $_POST['xyz_em_sendViaSmtp']=='0') { echo 'selected';}elseif(get_option('xyz_em_sendViaSmtp')=="0"){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_em_SmtpDebug">SMTP Debug</label>
				</td>
				<td><select name="xyz_em_SmtpDebug" id="xyz_em_SmtpDebug">
						<option value="2"
						<?php if(isset($_POST['xyz_em_SmtpDebug']) && $_POST['xyz_em_SmtpDebug']=='2') { echo 'selected';}elseif(get_option('xyz_em_SmtpDebug')=="2"){echo 'selected';} ?>>True</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_SmtpDebug']) && $_POST['xyz_em_SmtpDebug']=='0') { echo 'selected';}elseif(get_option('xyz_em_SmtpDebug')=="0"){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
		<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_hesl">Hourly Email Sending Limit</label>
				</td>
				<td><input  name="xyz_em_hesl" type="text"
					id="xyz_em_hesl" value="<?php if(isset($_POST['xyz_em_hesl']) ){echo abs(intval($_POST['xyz_em_hesl']));}else{ print(get_option('xyz_em_hesl')); }?>" />
				</td>
			</tr>
	<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_dse">Default Sender Email</label>
				</td>
				<td><input name="xyz_em_dse" type="text" id="xyz_em_dse"
					value="<?php if(isset($_POST['xyz_em_dse']) ){echo esc_attr($_POST['xyz_em_dse']);}else{print(esc_attr(get_option('xyz_em_dse')));} ?>" /></td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_dsn">Default Sender Name</label>
				</td>
				<td><input name="xyz_em_dsn" type="text" id="xyz_em_dsn"
					value="<?php if(isset($_POST['xyz_em_dsn']) ){echo esc_attr($_POST['xyz_em_dsn']);}else{print(esc_attr(get_option('xyz_em_dsn')));} ?>" /></td>
			</tr>
			<tr valign="top">
				<td scope="row" id="bottomBorderNone" class=" settingInput"><label for="xyz_em_dse">Default Subscriber Name</label>
				</td>
				<td id="bottomBorderNone" ><input name="xyz_em_dsubname" type="text" id="xyz_em_dsubname"
					value="<?php
						if(isset($_POST['xyz_em_dsubname']) ){
							echo esc_attr($_POST['xyz_em_dsubname']);
						}else{
							global $wpdb;							
							$defaultValue = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_additional_field_info WHERE field_name="Name" ' ) ;
							$defaultValue = $defaultValue[0];
							echo esc_attr($defaultValue->default_value);
						}
					 ?>" /></td>
			</tr>	
			
	</table>
	</fieldset>
	
	
	
	</div>
	<div style="float: left;width: 49%;margin-left: 10px">
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Subscription</legend>
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row"  class="settingInput"><label for="xyz_em_hesl">Opt-in Form Title</label>
				</td>
				<td  ><input  name="xyz_em_widgetName" type="text"
					id="xyz_em_widgetName" value="<?php if(isset($_POST['xyz_em_widgetName'])){echo esc_attr($_POST['xyz_em_widgetName']);}else{ echo esc_attr(get_option('xyz_em_widgetName')); }?>" />
				</td>
			</tr>
	<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_dss">Opt-in Mode</label>
				</td>
				<td><select name="xyz_em_dss" id="xyz_em_dss" onchange="change_opt_in()">
						<option value="Active"
						<?php if(isset($_POST['xyz_em_dss']) && $_POST['xyz_em_dss']=='Active'){ echo 'selected';}elseif(get_option('xyz_em_dss')=="Active"){echo 'selected';} ?>>Single Opt-in</option>
						<option value="Pending"
						<?php if(isset($_POST['xyz_em_dss']) && $_POST['xyz_em_dss']=='Pending'){ echo 'selected';}elseif(get_option('xyz_em_dss')=="Pending"){echo 'selected';} ?>>Double Opt-in</option>

				</select>
				</td>
			</tr>	
			<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_afterSubscription">Page to be
						redirected after subscription (absolute path)</label></td>
				<td><input id="input" name="xyz_em_afterSubscription" type="text"
					id="xyz_em_afterSubscription"
					value="<?php if(isset($_POST['xyz_em_afterSubscription']) ) echo strip_tags($_POST['xyz_em_afterSubscription']); else echo get_option('xyz_em_afterSubscription');//echo esc_attr(plugins_url("newsletter-manager/thanks.php"));?>" />
				</td>
			</tr>
			<tr valign="top" id="email_confirm_page_tr">
				<td scope="row"  class=" settingInput"><label for="xyz_em_emailConfirmation">Page to be
						redirected after email confirmation <br/>(absolute path)</label></td>
				<td  ><input id="input" name="xyz_em_emailConfirmation" type="text"
					id="xyz_em_emailConfirmation"
					value="<?php if(isset($_POST['xyz_em_emailConfirmation']) ) echo strip_tags($_POST['xyz_em_emailConfirmation']); else echo get_option('xyz_em_emailConfirmation');//echo esc_attr(plugins_url("newsletter-manager/confirm.php"));?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_em_enableWelcomeEmail">Enable
						Subscription Activation Email (Welcome mail)</label>
				</td>
				<td id="bottomBorderNone"><select name="xyz_em_enableWelcomeEmail"
					id="xyz_em_enableWelcomeEmail">
						<option value="True"
						<?php if(isset($_POST['xyz_em_enableWelcomeEmail']) && $_POST['xyz_em_enableWelcomeEmail']=='True'){ echo 'selected';}elseif(get_option('xyz_em_enableWelcomeEmail')=='True'){echo 'selected';}?>>True</option>
						<option value="False"
						<?php if(isset($_POST['xyz_em_enableWelcomeEmail']) && $_POST['xyz_em_enableWelcomeEmail']=='False'){ echo 'selected';}elseif(get_option('xyz_em_enableWelcomeEmail')=='False'){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
	</table>
	</fieldset>
	
	
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Unsubscription</legend>
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row"  class=" settingInput"><label for="xyz_em_redirectAfterLink">Page to be redirected after unsubscription <br/>(absolute path)</label>
				</td>
				<td  ><input id="input" name="xyz_em_redirectAfterLink" type="text"
					id="xyz_em_redirectAfterLink"
					value="<?php if(isset($_POST['xyz_em_redirectAfterLink']) ) echo strip_tags($_POST['xyz_em_redirectAfterLink']); else echo get_option('xyz_em_redirectAfterLink');//echo esc_attr(plugins_url("newsletter-manager/unsubscribe.php"));?>" />
				</td>
			</tr>	
		<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_em_enableUnsubNotification">Enable
						Email on Unsubscription</label>
				</td>
				<td id="bottomBorderNone"><select name="xyz_em_enableUnsubNotification"
					id="xyz_em_enableUnsubNotification">
						<option value="True"
						<?php if(isset($_POST['xyz_em_enableUnsubNotification']) && $_POST['xyz_em_enableUnsubNotification']=='True'){ echo 'selected';}elseif(get_option('xyz_em_enableUnsubNotification')=="True"){echo 'selected';}?>>True</option>
						<option value="False"
						<?php if(isset($_POST['xyz_em_enableUnsubNotification']) && $_POST['xyz_em_enableUnsubNotification']=='False'){ echo 'selected';}elseif(get_option('xyz_em_enableUnsubNotification')=="False"){echo 'selected';}?>>False</option>

				</select>
				</td>
			</tr>
			
	</table>
	</fieldset>
	
	</div>
	<div style="clear: both"></div>
	
	
	
	
	
	
	
	
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 0px 15px 10px;">
	<legend>Notification Messages</legend>
	<table class="widefat"  style="width:99%;">

			<tr>
			<td colspan="2"><b>Note :</b> You can use <b>{field1}</b> in the following messages in order to refer to the name of a subscriber.
			</td>
			</tr>
	
				<?php
						
				$xyz_em_template3 = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=3') ;
				$xyz_em_template3 = $xyz_em_template3[0];
						
			?>
			
			<tr valign="top" id="confirm_sub_tr">
				<td scope="row" class=" settingInput" style="width:30%"><label for="xyz_em_subject3">Email Confirmation Subject</label>
				</td>
				<td><input  name="xyz_em_subject3" type="text"
					id="xyz_em_subject3" value="<?php 
					if(isset($_POST['xyz_em_subject3']) ){echo esc_attr($_POST['xyz_em_subject3']);}else{echo esc_attr($xyz_em_template3->subject);}
					?>" />
				</td>
			</tr>
			<tr valign="top" id="confirm_body_tr">
				<td scope="row"  class=" settingInput"><label for="xyz_em_message2">Email Confirmation Message</label>
				</td>
				<td >
				
					<?php 
					
					if(get_option('xyz_em_defaultEditor') == "Text Editor"){
					
					?>
				
					<textarea name="xyz_em_message3" type="text" id="xyz_em_message3" style="width:100%;margin-left:0px;"><?php

					if(isset($_POST['xyz_em_message3']) ){echo esc_textarea($_POST['xyz_em_message3']);}else{echo esc_textarea( $xyz_em_template3->message);} ?></textarea>
					<?php 
					
					}elseif(get_option('xyz_em_defaultEditor') == "HTML Editor"){
						if(isset($_POST['xyz_em_message3']) ){
							the_editor(($_POST['xyz_em_message3']),'xyz_em_message3');
						}else{
							the_editor(($xyz_em_template3->message),'xyz_em_message3');
						}					
					}
					?>
				
				</td>
			</tr>	
	
	
	<?php
						
				$xyz_em_template1 = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=1') ;
				$xyz_em_template1 = $xyz_em_template1[0];
						
			?>
			
			
			<tr valign="top">
				<td scope="row" class="settingInput"><label for="xyz_em_subject1">Subscription Activation Subject</label>
				</td>
				<td><input  name="xyz_em_subject1" type="text"
					id="xyz_em_subject1" value="<?php
					
					
						if(isset($_POST['xyz_em_subject1']) ){echo esc_attr($_POST['xyz_em_subject1']);}else{echo esc_attr($xyz_em_template1->subject);}
					
					
					?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_message1">Subscription Activation Message</label>
				</td>
				<td>
				
					<?php 
					
					if(get_option('xyz_em_defaultEditor') == "Text Editor"){
					
					?>
				
					<textarea name="xyz_em_message1" type="text" id="xyz_em_message1" style="width:100%;margin-left:0px;"><?php

					if(isset($_POST['xyz_em_message1']) ){echo esc_textarea($_POST['xyz_em_message1']);}else{echo esc_textarea($xyz_em_template1->message);} ?></textarea>
					<?php 
					
					}elseif(get_option('xyz_em_defaultEditor') == "HTML Editor"){
						if(isset($_POST['xyz_em_message1']) ){
							the_editor(($_POST['xyz_em_message1']),'xyz_em_message1');
						}else{
							the_editor(($xyz_em_template1->message),'xyz_em_message1');
						}					
					}
					?>
				</td>
			</tr>	
			
			<?php
						
				$xyz_em_template2 = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=2') ;
				$xyz_em_template2 = $xyz_em_template2[0];
						
			?>
			
			<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_subject2">Email Unsubscription Subject</label>
				</td>
				<td><input  name="xyz_em_subject2" type="text"
					id="xyz_em_subject2" value="<?php 
					//if($xyz_em_subject2 != ""){echo $xyz_em_subject2;}else{echo esc_attr($xyz_em_template2->subject);}
					if(isset($_POST['xyz_em_subject2']) ){
						echo esc_attr($_POST['xyz_em_subject2']);
					}else{echo esc_attr($xyz_em_template2->subject);
					}
					?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput"  id="bottomBorderNone"><label for="xyz_em_message2">Email Unsubscription Message</label>
				</td>
				<td  id="bottomBorderNone">
				
					<?php 
					
					if(get_option('xyz_em_defaultEditor') == "Text Editor"){
					
					?>
				
					<textarea name="xyz_em_message2" type="text" id="xyz_em_message2" style="width:100%;margin-left:0px;"><?php

					if(isset($_POST['xyz_em_message2']) ){echo esc_textarea($_POST['xyz_em_message2']);}else{echo esc_textarea($xyz_em_template2->message);} ?></textarea>
					<?php 
					
					}elseif(get_option('xyz_em_defaultEditor') == "HTML Editor"){
						if(isset($_POST['xyz_em_message2'])){
							the_editor(($_POST['xyz_em_message2']),'xyz_em_message2');
						}else{
							the_editor(($xyz_em_template2->message),'xyz_em_message2');
						}					
					}
					?>
				
				</td>
			</tr>
	</table>
	</fieldset>
	
	
	
	
	
		
	
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Others</legend>
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row"  class=" settingInput" style="width:30%"><label >Cron job command</label>
				</td>
				<td  > wget <?php echo plugins_url().'/newsletter-manager/cron.php'; ?></td>
			</tr>	
				<tr valign="top">
				<td scope="row"  class=" settingInput"><label >Shortcode to be used in page after subscription</label>
				</td>
				<td  >[xyz_em_thanks]</td>
			</tr>	
							<tr valign="top">
				<td scope="row"  class=" settingInput"><label >Shortcode to be used in page after email confirmation</label>
				</td>
				<td  >[xyz_em_confirm]</td>
			</tr>	
						<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label >Shortcode to be used in page after unsubscription</label>
				</td>
				<td id="bottomBorderNone">[xyz_em_unsubscribe]				</td>
			</tr>
			
	</table>
	</fieldset>
	
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Note</legend>
		<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td colspan=2 id="bottomBorderNone">
					To link contact request emails to Newsletter Manager, use
					 Contact Form Manager (free) Version 1.3 / XYZ WP Contact Form (premium) Version 1.1 
				</td>
			</tr>
		</table>
	</fieldset>
	
	
	
	<fieldset style=" width:98%;padding:10px 0px 15px 10px;">
	<legend></legend>
	<table class="widefat"  style="width:99%; margin-top:10px;">
			<tr>
				<td colspan=2 id="bottomBorderNone" style="text-align: center;">
				<div style="height:50px;"><input style="margin:10px 0 20px 0;" id="submit_em" class="button-primary bottonWidth" type="submit" value=" Update Settings " /></div>
				
				</td>
			</tr>
			
		</table>
		</fieldset>
	</form>

</div>
<script type="text/javascript">
function change_opt_in()
{
	sel_opt_in=document.getElementById('xyz_em_dss').options[document.getElementById('xyz_em_dss').options.selectedIndex].value;
	if(sel_opt_in=='Active')
	{
		document.getElementById('email_confirm_page_tr').style.display='none';
		//document.getElementById('confirm_sub_tr').style.display='none';
		//document.getElementById('confirm_body_tr').style.display='none';
			}
	else
	{
		document.getElementById('email_confirm_page_tr').style.display='';
		//document.getElementById('confirm_sub_tr').style.display='';
		//document.getElementById('confirm_body_tr').style.display='';
	}
}
change_opt_in()	
</script>