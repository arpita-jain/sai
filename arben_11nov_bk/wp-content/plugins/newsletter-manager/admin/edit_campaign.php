<?php

if(get_option('xyz_em_tinymce_filter')=="1"){
	require( dirname( __FILE__ ) . '/tinymce_filters.php' );
}
// Load the options
global $wpdb;
$_GET = stripslashes_deep($_GET);
//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
if($_POST){
$_POST = stripslashes_deep($_POST);
$_POST = xyz_trim_deep($_POST);

$xyz_em_senderEmailFlag = 0;

// 		echo '<pre>';
// 		print_r($_POST);
// 		die;


	
	$xyz_em_pagenum = abs(intval($_POST['pageno']));
	
	$xyz_em_campId = intval($_POST['campId']);

	$email_type = $_POST['email_type'];

	if($email_type == 1){
		$xyz_em_bodyPlain = $_POST['xyz_em_bodyPlain'];
		$xyz_em_body = $xyz_em_bodyPlain;
	}
	if($email_type == 2){
		$xyz_em_page = $_POST['xyz_em_body'];
		$xyz_em_body = preg_replace("/<script.+?>.+?<\/script>/im","",$xyz_em_page);

	}
	
		$xyz_em_senderEmail = $_POST['xyz_em_senderEmail'];
		$xyz_em_senderEmailFlag = 0;
		
		if(get_option('xyz_em_sendViaSmtp') == 1){
			$xyz_em_senderEmailId = $_POST['xyz_em_senderEmailId'];
			if($xyz_em_senderEmail != ''){
				if(!is_email($xyz_em_senderEmail)){
					$xyz_em_senderEmailFlag = 1;
				}
			}
		}else{
			$xyz_em_senderEmailId = 0; //if smtp is off,  sender email id set to 0
		if(!is_email($xyz_em_senderEmail)){
			$xyz_em_senderEmailFlag = 1;
			}
		}
		
		$xyz_em_altBody = $_POST['xyz_em_altBody'];
	
	

	if (($_POST['xyz_em_campName']!= "")
			&& ($_POST['xyz_em_campSubject'] != "")
			&& ($xyz_em_body != "")
			&& ($_POST['xyz_em_batchSize'] != "")
			&& ($_POST['xyz_em_senderName'] != "")
			&& ($_POST['xyz_em_senderEmail'] != '')
			&& ($_POST['xyz_em_redirectAfterLink'] != "")){

		$xyz_em_campName = $_POST['xyz_em_campName'];



		$xyz_em_startTime = $_POST['xyz_em_startTime'];
		$xyz_em_hour = $_POST['xyz_em_hour'];
		$xyz_em_minute = $_POST['xyz_em_minute'];
		$xyz_em_second = 00;
		
		$endTimeCondition = $_POST['triggerEndTimeCondition'];
		
		$xyz_em_endTime = $_POST['xyz_em_endTime'];
		$xyz_em_hour_end = $_POST['xyz_em_hour_end'];
		$xyz_em_minute_end = $_POST['xyz_em_minute_end'];
		$xyz_em_second_end = 00;

		$xyz_em_campSubject = $_POST['xyz_em_campSubject'];
		
		$xyz_em_batchSize = abs(intval($_POST['xyz_em_batchSize']));
		$xyz_em_senderName = $_POST['xyz_em_senderName'];
		$xyz_em_redirectAfterLink = strip_tags($_POST['xyz_em_redirectAfterLink']);
		$xyz_em_senderEmail = $_POST['xyz_em_senderEmail'];



		if($xyz_em_startTime != ""){
			$startDateArray = explode('/',$xyz_em_startTime);
			// 				echo '<pre>';
			// 				print_r($startDateArray);

			$month = $startDateArray[0];
			$day = $startDateArray[1];
			$year = $startDateArray[2];

			if(($xyz_em_hour >= 0) && ($xyz_em_minute >=0)){

				$xyz_em_currentDateTime = mktime($xyz_em_hour,$xyz_em_minute,$xyz_em_second,$month,$day,$year);

			}else{
				$xyz_em_currentDateTime = mktime(0,0,0,$month,$day,$year);
			}

		}else{

			$xyz_em_currentDateTime = time();
		}
		
		$xyz_em_endDateTime = 0;
		
		if($endTimeCondition == 2){
			if($xyz_em_endTime != ""){
				$endDateArray = explode('/',$xyz_em_endTime);
				$month_end = $endDateArray[0];
				$day_end = $endDateArray[1];
				$year_end = $endDateArray[2];
			
				if(($xyz_em_hour_end >= 0) || ($xyz_em_minute_end >=0)){
			
					$xyz_em_endDateTime = mktime($xyz_em_hour_end,$xyz_em_minute_end,$xyz_em_second_end,$month_end,$day_end,$year_end);
			
				}else{
					$xyz_em_endDateTime = mktime(0,0,0,$month_end,$day_end,$year_end);
				}
			
			}
		}

		for($i = 1; $i <= 5; $i++){

			if($_FILES['xyz_em_uploadFile_'.$i]['name'] != ""){

				${
					$uploadFileName.$i} = $_FILES['xyz_em_uploadFile_'.$i]['name'];
					$extension = pathinfo(${
						$uploadFileName.$i});

			}

		}
		
		$endTimeConditionFlag = 0;
		if($endTimeCondition == 2){
			
			if($xyz_em_endDateTime < $xyz_em_currentDateTime){
				$endTimeConditionFlag = 1;
			}
		}

		if($endTimeConditionFlag == 0 ){
		
		if ($xyz_em_batchSize > 0){

			$xyz_em_campFlag = 0;
			if($xyz_em_senderEmailFlag != 1){

				$xyz_em_campaign_count = $wpdb->get_results( 'SELECT * FROM xyz_em_email_campaign WHERE name="'.$xyz_em_campName.'" AND id!="'.$xyz_em_campId.'" LIMIT 0,1' ) ;
				if(count($xyz_em_campaign_count) == 0){

					$wpdb->update($wpdb->prefix.'xyz_em_email_campaign',
							array('name'=>$xyz_em_campName,
									'type'=>$email_type,
									'subject'=>$xyz_em_campSubject,
									'body'=>$xyz_em_body,
									'alt_body'=>$xyz_em_altBody,
									'batch_size'=>$xyz_em_batchSize,
									'sender_name'=>$xyz_em_senderName,
									'sender_email'=>$xyz_em_senderEmail,
									'sender_email_id'=>$xyz_em_senderEmailId,
									'unsubscription_link'=>$xyz_em_redirectAfterLink,
									'start_time'=>$xyz_em_currentDateTime,
									'end_time'=>$xyz_em_endDateTime),
							array('id'=>$xyz_em_campId));


					$xyz_em_campLastid = $xyz_em_campId;
					if($xyz_em_campLastid != 0){
						for($i = 1; $i <= 5; $i++){

							if($_FILES['xyz_em_uploadFile_'.$i]['name'] != ""){

								$targetfolder = realpath(dirname(__FILE__) . '/../../../')."/uploads";
								if (!is_file($targetfolder) && !is_dir($targetfolder)) {
								
									mkdir($targetfolder) or die("Could not create directory " . $targetfolder);
									chmod($targetfolder, 0777); //make it writable
								}
								$targetfolder = realpath(dirname(__FILE__) . '/../../../')."/uploads/xyz_em";
								if (!is_file($targetfolder) && !is_dir($targetfolder)) {
								
									mkdir($targetfolder) or die("Could not create directory " . $targetfolder);
									chmod($targetfolder, 0777); //make it writable
								}
								
								
								$dir = "uploads/xyz_em/attachments";
								$targetfolder = realpath(dirname(__FILE__) . '/../../../')."/".$dir;
								if (!is_file($targetfolder) && !is_dir($targetfolder)) {

									mkdir($targetfolder) or die("Could not create directory " . $targetfolder);

									chmod($targetfolder, 0777); //make it writable
								}
								
								/* new file name creation*/
								$extension = strtolower(pathinfo($_FILES['xyz_em_uploadFile_'.$i]['name'], PATHINFO_EXTENSION));
								$file_name =  basename($_FILES['xyz_em_uploadFile_'.$i]['name'],'.'.$extension);
								
								$finalFileName = xyz_insert_file($targetfolder, $file_name, 0, $extension);
								
								/* insert new file name to attachment table*/
								$wpdb->insert($wpdb->prefix.'xyz_em_attachment', array('campaigns_id' => $xyz_em_campLastid,'name' => $finalFileName),array('%d','%s'));
								
								/* move file(with new file name) to attachment folder*/
								move_uploaded_file($_FILES['xyz_em_uploadFile_'.$i]["tmp_name"],$targetfolder."/".$finalFileName);
							}

						}
							
					}
					$xyz_em_campFlag = 1;

					}
					if($xyz_em_campFlag == 1){
						
						header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns&campmsg=2&pagenum='.$xyz_em_pagenum));
						exit();

				}else{
					?>
<div class="system_notice_area_style0" id="system_notice_area">
	Campaign name already exists.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
				}

			}else{
				?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please enter a valid sender email.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
			}


		}else{
			?>
<div class="system_notice_area_style0" id="system_notice_area">
	Batch size must be a positive integer.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php		
		}
		}else{
			?>
		<div class="system_notice_area_style0" id="system_notice_area">
			End date must be greater than start time .&nbsp;&nbsp;&nbsp;<span
				id="system_notice_area_dismiss">Dismiss</span>
		</div>
		<?php		
				}
	}else{
		?>
<div class="system_notice_area_style0" id="system_notice_area">
	Fill all fields.&nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
	}
}
?>


<!-- below for date picker -->


<script type="text/javascript">

var dp_cal_start;
var dp_cal_end;      
window.onload = function ()
{
dp_cal_start  = new Epoch('epoch_popup','popup',document.getElementById('startTime'));	

};


jQuery(document).ready(function(){

	if (jQuery("#triggerEndTimeConditionEnds").is(':checked')) {
		jQuery("#triggerEndTimeConditionDate").show();
		jQuery("#dateTimeLabel").show();
		dp_cal_end  = new Epoch('epoch_popup','popup',document.getElementById('endTime'));
	}else{
		jQuery("#triggerEndTimeConditionNeverEnds").attr("checked",true);
		jQuery("#triggerEndTimeConditionDate").hide();
		jQuery("#dateTimeLabel").hide();
	}
	
	jQuery("#triggerEndTimeConditionNeverEnds").click(function() {
		jQuery("#triggerEndTimeConditionDate").hide();
		jQuery("#dateTimeLabel").hide();
	});
	jQuery("#triggerEndTimeConditionEnds").click(function() {
		jQuery("#triggerEndTimeConditionDate").show();
		jQuery("#dateTimeLabel").show();
		dp_cal_end  = new Epoch('epoch_popup','popup',document.getElementById('endTime'));
	});
	
});

</script>

<link rel="stylesheet" href="<?php echo plugins_url("newsletter-manager/css/datepicker.css");?>" type="text/css"	media="screen" />

<!-- above for date picker -->





<script type="text/javascript">

	jQuery(document).ready(function() {
		jQuery('#collapseimg').hide();
		jQuery('#expandimg').show();
		jQuery('#attachments').hide();
		  // Handler for .ready() called.
		jQuery('#collapseimg').click(function() {
			jQuery('#attachments').hide(200);
			jQuery('#collapseimg').hide();
			jQuery('#expandimg').show();
			});
		jQuery('#expandimg').click(function() {
			jQuery('#attachments').show(200);
			jQuery('#expandimg').hide();
			jQuery('#collapseimg').show();
			});
			  
		});
	

</script>



<?php 

$xyz_em_campId = intval($_GET['id']);

if($_GET['pageno'] != ""){
	$xyz_em_pageno = abs(intval($_GET['pageno']));
}else{
	$xyz_em_pageno= 1;
}

if($xyz_em_campId=="" || !is_numeric($xyz_em_campId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-campaigns'));
	exit();

}
$campDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_campaign WHERE id="'.$xyz_em_campId.'" ' ) ;

if(count($campDetails)==0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-campaigns'));
	exit();
}else{

	if($campDetails){
		$details = $campDetails[0];

		?>


<div>

	<h2>Edit Campaign</h2>
	<form method="post" enctype="multipart/form-data">
		<table class="widefat" style="width:98%;">

			<tr valign="top">
				<td scope="row" class="td"><label for="xyz_em_campName">Campaign
						Name<span style="color:red;">*</span></label>
				</td>
				<td><input id="input" name="xyz_em_campName" type="text"
					id="xyz_em_campName"
					value="<?php if(isset($_POST['xyz_em_campName'])){ echo esc_attr($_POST['xyz_em_campName']);}else{ echo esc_attr($details->name); }?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row"><label for="email_type">Email Type</label>
				</td>
				<td><select class="select" name="email_type"
					id="email_type">
						<option value="1" <?php if(isset($_POST['email_type']) && $_POST['email_type']==1){echo 'selected';}elseif($details->type==1) echo 'selected'; ?>>Plain
							Text</option>
						<option value="2" <?php if(isset($_POST['email_type']) && $_POST['email_type']==2){echo 'selected';}elseif($details->type==2) echo 'selected';  ?>>HTML</option>

				</select>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>

					Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time
				</td>

			</tr>
			<tr>
				<td>Start Time</td>
				<td><input readonly="readonly" name="xyz_em_startTime"
					id="startTime" type="text"
					value="<?php if(isset($_POST['xyz_em_startTime']) && $_POST['xyz_em_startTime'] != ""){echo $_POST['xyz_em_startTime'];}else{ echo date("m/d/Y",$details->start_time);}?>" />
					 <select
					id="hour" name="xyz_em_hour" id="select">

						<?php 

						for($i = 0;$i<=23;$i++){

							?>
						<option value="<?php echo $i;?>"
						<?php if(isset($_POST['xyz_em_hour']) && $_POST['xyz_em_hour'] == $i){echo 'selected';}elseif(date("H", $details->start_time)==$i){ echo 'selected';}?>>
							<?php echo $i;?>
						</option>
						<?php 

						}

						?>
				</select>H <select id="minute" name="xyz_em_minute" id="select">

						<?php 

						for($i = 0;$i<=59;$i++){

							?>
						<option value="<?php echo $i;?>"
						<?php if(isset($_POST['xyz_em_minute']) && $_POST['xyz_em_minute'] == $i){echo 'selected';}elseif(date("i", $details->start_time)==$i){ echo 'selected';}?>>
							<?php echo $i;?>
						</option>
						<?php 

						}

						?>
				</select>M</td>
			</tr>
			
			
			<tr id="dateTimeLabel">
				<td>&nbsp;</td>
				<td><span style="padding-left:210px;">&nbsp;</span>
					Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time
				</td>

			</tr>
			
			
			<tr id="dateTriggerTr8">
				<td id="alignText">End Time</td>
				<td id="alignText">
					<div>
						<div style="float: left;padding-top: 3px; padding-bottom: 6px;">
							<input type="radio" name="triggerEndTimeCondition"
								id="triggerEndTimeConditionNeverEnds" value="1"	
								<?php if(isset($_POST['triggerEndTimeCondition']) && $_POST['triggerEndTimeCondition']==1){?>checked="checked"<?php }else{if($details->end_time == 0 ){?>checked="checked"<?php }}?>/>
							Never Ends
							<input type="radio" id="triggerEndTimeConditionEnds"
								name="triggerEndTimeCondition" id="specificdate" value="2" 
								<?php if(isset($_POST['triggerEndTimeCondition']) && $_POST['triggerEndTimeCondition']==2){?>checked="checked"<?php }else{if($details->end_time != 0 ){?>checked="checked"<?php }}?>/>
							Ends on a date
						</div>
						<div id="triggerEndTimeConditionDate"  >
							<div style="width: 100px; float:left;">
								&nbsp;&nbsp;&nbsp;<input readonly="readonly" name="xyz_em_endTime"
							id="endTime" type="text"
							value="<?php if(isset($_POST['xyz_em_endTime']) && $_POST['xyz_em_endTime'] != ""){echo $_POST['xyz_em_endTime'];}else{ echo date("m/d/Y",$details->end_time);}?>" />	
							</div>
							<div >
								<select id="hour_end" name="xyz_em_hour_end" id="select">
		
								<?php 
		
								for($i = 0;$i<=23;$i++){
		
									?>
								<option value="<?php echo $i;?>"
								<?php if(isset($_POST['xyz_em_hour_end']) && $_POST['xyz_em_hour_end'] == $i){echo 'selected';}elseif(date("H", $details->end_time)==$i){ echo 'selected';}?>>
								<?php echo $i;?>
								</option>
								<?php 
		
								}
		
								?>
						</select>H <select id="minute_end" name="xyz_em_minute_end" id="select">
		
								<?php 
		
								for($i = 0;$i<=59;$i++){
		
									?>
								<option value="<?php echo $i;?>"
								<?php if(isset($_POST['xyz_em_minute_end']) && $_POST['xyz_em_minute_end'] == $i){echo 'selected';}elseif(date("i", $details->end_time)==$i){ echo 'selected';}?>>
								<?php echo $i;?>
								</option>
								<?php 
		
								}
		
								?>
						</select>M
							</div>
						</div>
					</div>
				</td>
			</tr>
			
			
			<tr valign="top">
				<td scope="row"><label for="xyz_em_campSubject">Mail Subject<span style="color:red;">*</span></label>
				</td>
				<td><input id="input" name="xyz_em_campSubject" type="text"
					id="xyz_em_campSubject" value="<?php if(isset($_POST['xyz_em_campSubject'])){echo esc_attr($_POST['xyz_em_campSubject']);}else{ echo esc_attr($details->subject);} ?>" />
				</td>
			</tr>

			<tr>
				<td scope="row"><label for="xyz_em_body">Body Content<span style="color:red;">*</span></label></td>
				<td >
					<div id="htmlcamp">
						<?php 

						if(get_option('xyz_em_defaultEditor') == "Text Editor"){


							?>
						<textarea class="areaSize"  name="xyz_em_body"><?php

							if(isset($_POST['xyz_em_body'])){
								echo esc_textarea($_POST['xyz_em_body']);
							}else{
							echo esc_textarea($details->body); 
							}
							?></textarea>
						<?php 
							
						}else if(get_option('xyz_em_defaultEditor') == "HTML Editor"){

							if(isset($_POST['xyz_em_body'])){
								the_editor($_POST['xyz_em_body'],'xyz_em_body');
							}else{
								the_editor($details->body,'xyz_em_body');
							}
						}

						?>

					</div><br />
					<div id="plainText">

						<textarea class="areaSize" name="xyz_em_bodyPlain"><?php 
							if(isset($_POST['xyz_em_bodyPlain'])){
								echo esc_textarea($_POST['xyz_em_bodyPlain']);
							}else{
								echo esc_textarea($details->body);
							}
							 ?></textarea>

					</div><br />
					<div class="campCreateDiv5">
						<b>{field1}</b>&nbsp;-&nbsp;Name.
					</div>
					<div class="campCreateDiv5">
						<b>{unsubscribe-url}</b> - Will be replaced with
					unsubscription link.
					</div>
				</td>
			</tr>
			<tr class="campCreatTr1" id="altHtml">
				<td scope="row"><label for="xyz_em_altBody">Alternate Body Content</label></td>
				<td ><textarea id="textarea" name="xyz_em_altBody">
					<?php

					if(isset($_POST['xyz_em_altBody'])){
						echo esc_textarea($_POST['xyz_em_altBody']);
					}else{
						echo esc_textarea($details->alt_body);
					}
					 ?>
					
									</textarea> <br /> <br />
					<div class="campCreateDiv5">
						<b>{field1}</b>&nbsp;-&nbsp;Name.
					</div>
					<div class="campCreateDiv9">
						<b>{unsubscribe-option}</b> - Will be replaced with Unsubscription
						link.
					</div>
				</td>
			</tr>

			<tr valign="top">
				<td scope="row"><label for="xyz_em_batchSize">Batch Size<span style="color:red;">*</span></label>
				</td>
				<td><input id="input" name="xyz_em_batchSize" type="text"
					id="xyz_em_batchSize"
					value="<?php if(isset($_POST['xyz_em_batchSize']) ) echo abs(intval($_POST['xyz_em_batchSize']));else echo $details->batch_size; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row"><label for="xyz_em_senderName">Sender Name<span style="color:red;">*</span></label>
				</td>
				<td><input id="input" name="xyz_em_senderName" type="text"
					id="xyz_em_senderName"
					value="<?php if(isset($_POST['xyz_em_senderName']) ) echo esc_attr($_POST['xyz_em_senderName']);else echo esc_attr($details->sender_name); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row"><label for="xyz_em_redirectAfterLink">Redirection
						link after unsubscription</label>
				</td>
				<td><input id="input" name="xyz_em_redirectAfterLink" type="text"
					id="xyz_em_redirectAfterLink"
					value="<?php if(isset($_POST['xyz_em_redirectAfterLink']) ) echo strip_tags($_POST['xyz_em_redirectAfterLink']);else echo ($details->unsubscription_link); ?>" />
				</td>
			</tr>
			<?php 
			if(get_option('xyz_em_sendViaSmtp') == 1){
			?>
			<tr valign="top">
				<td scope="row"><label for="xyz_em_senderEmail">SMTP Account
				<span style="color:red;">*</span>
				</label>
				</td>
				<td>
				<?php 
					$xyz_em_getSenderdetails = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."xyz_em_sender_email_address");
				?>	
				<select name="xyz_em_senderEmailId">
				<?php 
					foreach ($xyz_em_getSenderdetails as $xyz_em_getSender){
				?>
				<option value="<?php echo $xyz_em_getSender->id;?>" <?php if($details->sender_email_id==$xyz_em_getSender->id){?>selected="selected"<?php }?>><?php echo $xyz_em_getSender->user;?></option>
				<?php 
				}
				?>
				</select>
				</td>
			</tr>
			<?php 
			}
			?>
			<tr valign="top">
				<td scope="row"><label for="xyz_em_senderEmail">Sender Email
				<?php 
				if(get_option('xyz_em_sendViaSmtp') != 1){
				?>
				<span style="color:red;">*</span>
				<?php 
				}
				?>
				</label>
				</td>
				<td>
				<input id="input" name="xyz_em_senderEmail" type="text"
					id="xyz_em_senderEmail"
					value="<?php if(isset($_POST['xyz_em_senderEmail'])) echo esc_attr($_POST['xyz_em_senderEmail']);else echo esc_attr($details->sender_email); ?>" />
				</td>
			</tr>
			
			
			
			
			<?php 

			$attachDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_attachment WHERE campaigns_id="'.$xyz_em_campId.'" ' ) ;
			if(count($attachDetails)>0){
				$i = 1;
				foreach ($attachDetails as $key => $attachmentDetails){
					?>
			<tr>
				<td scope="row">
						Attachment&nbsp;
						<?php echo $i;?>
				</td>
				<td>
							<?php echo $attachmentDetails->name."  ";?>
							<a
								href='<?php echo admin_url('admin.php?page=newsletter-manager-manage-campaigns&action=attachment_delete&id='.$attachmentDetails->id.'&campId='.$details->id); ?>'>Delete</a>
						
					</td>
			</tr>
			<?php 		
			$i++;
				}


			}


			?>

			<tr>
				<td>Add Attachments</td>

				<td>
					<p id="collapseimg">
						<button class="button-primary" type="button" id="submit_em">

							<div>Collapse</div>
						</button>
					</p>
					<p id="expandimg">
						<button class="button-primary" type="button" id="submit_em">

							<div>Expand</div>
						</button>
					</p>

				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div id="attachments">

						<table class="widefat">
							<?php 

							for($i = 1; $i <= 5; $i++){
									
								?>
							<tr>
								<td scope="row" style="width:350px;"><label >Attachment&nbsp;<?php echo $i;?>
								</label>
								</td>
								<td><input  type="file"
									name="xyz_em_uploadFile_<?php echo $i;?>" />
								</td>
							</tr>
							<?php }?>
						</table>
					</div>
				</td>
			</tr>


			<tr>
				<td scope="row"></td>
				<td>
				<div style="height:50px;"><input style="margin:10px 0 20px 0;" id="submit_em" class="button-primary bottonWidth" type="submit" value="Update Campaign" /></div>
				</td>
			</tr>
			<tr>
				<td id="bottomBorderNone" scope="row"><a
					href='javascript:history.back(-1);'>Go back </a>
			<input type="hidden" name="campId"				value="<?php echo $details->id; ?>">
				<input type="hidden" name="pageno"			value="<?php echo $xyz_em_pageno; ?>">
				</td>
			</tr>
		</table>
	</form>

</div>
<?php 

	}
}

?>
<script type="text/javascript">


function editor_change()
{
    if (jQuery("#email_type").val() == 1) {
        jQuery("#plainText").show();
        jQuery("#htmlcamp").hide();
        jQuery("#altHtml").hide();  
   }
   if (jQuery("#email_type").val() == 2) {
        jQuery("#plainText").hide();
        jQuery("#htmlcamp").show();
        jQuery("#altHtml").show();
  }

}

						
jQuery(document).ready(function() {

	jQuery("#email_type").change(function(){
		editor_change();
	});
	
	editor_change();
		  
	});	

</script>

