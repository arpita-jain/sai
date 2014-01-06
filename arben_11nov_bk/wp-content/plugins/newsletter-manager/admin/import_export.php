<?php 
global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$errorEmpty = 0;
$limitFrom = 0;
$limitTo = 0;
$completedExport = 0;
$completeExportFlag = 0;
$from = 0;
$to = 0;
$total = 0;
$importmsg = '';
$exportmsg =0;
$batchsizeExport=0;
$exportNoActiveEmailmsg = '';
$execFlag = 0;
$createFile = '';

$xyz_em_exportbatchSize = '';
if(isset($_POST['xyz_em_exportbatchSize'])){
	$xyz_em_exportbatchSize = absint($_POST['xyz_em_exportbatchSize']);
}
if ($xyz_em_exportbatchSize > 0){
	$execFlag = 1;

}else{

	$execFlag =0;
	if(isset($_POST['xyz_em_exportbatchSize'])){
		$exportmsg=1;
	}
}

if(isset($_POST['exportForm'])=="exportForm" && $execFlag == 1){
	$nameofForm = $_POST['exportForm'];
	
	if(isset($_POST['limitFrom'])){
		$limitFrom = absint($_POST['limitFrom']);
	}
	if($limitFrom == ""){
		$limitFrom = 0;
	}

	$xyz_em_emailListId = 1;

		//echo "PPP:".$xyz_em_exportbatchSize."<br/>";

		$xyz_em_listId = 1;
		
		$xyz_em_status = $_POST['xyz_em_exportOption'];
		
		
		
		$exp_status_str= ($xyz_em_status == 2) ? "" : " and lm.status='".$xyz_em_status."' ";
		
		if(isset($_POST['xyz_em_exportCount'])){
			$xyz_em_exportCount = absint($_POST['xyz_em_exportCount']);
		}else{
		
				
			$xyz_em_mappingDetails = $wpdb->get_results('SELECT ea_id FROM '.$wpdb->prefix.'xyz_em_address_list_mapping lm WHERE  lm.el_id="'.$xyz_em_listId.'"'.$exp_status_str) ;
				
			
			//$xyz_em_mappingDetails = $wpdb->get_results('SELECT ea_id FROM '.$wpdb->prefix.'xyz_em_address_list_mapping WHERE  status="1" AND el_id="'.$xyz_em_listId.'"') ;
			
			$xyz_em_exportCount = count($xyz_em_mappingDetails);
			
		}
		$xyz_em_sendMailFlag = 0;

		if($xyz_em_exportCount>0){
			

			//$xyz_em_mappingDetails = $xyz_em_mappingDetails[0];

			$listName = "xyz_em_list";
				
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
			$dir = "uploads/xyz_em/export";
			$targetfolder = realpath(dirname(__FILE__) . '/../../../')."/".$dir;
			if (!is_file($targetfolder) && !is_dir($targetfolder)) {

				mkdir($targetfolder) or die("Could not create directory " . $targetfolder);

				chmod($targetfolder, 0777); //make it writable
			}
				
			//echo count($xyz_em_mappingDetails);die;
			$batchCount=ceil($xyz_em_exportCount/$xyz_em_exportbatchSize);
				
				
			$limitTo = $limitFrom +  $xyz_em_exportbatchSize;
			if($limitTo > $xyz_em_exportCount){
				$limitTo = $xyz_em_exportCount;
			}
			$currentBatch=($limitFrom==0)?1:(($limitFrom/$xyz_em_exportbatchSize) +1)  ;
				
			// 					echo "cb:".$currentBatch."<br/>";
			// 					echo "bc:".$batchCount."<br/>";
				
			if($currentBatch <= $batchCount){

				// 					echo 'SELECT ea.id,ea.email FROM '.$wpdb->prefix.'xyz_em_email_address ea INNER JOIN '.$wpdb->prefix.'xyz_em_address_list_mapping
				// 							lm ON  ea.id=lm.ea_id WHERE lm.el_id="'.$xyz_em_emailListId.'" AND lm.status="1"  LIMIT '.$limitFrom.','.$xyz_em_exportbatchSize;
				// 					die;

				$exportDetails = $wpdb->get_results('SELECT ea.id,ea.email FROM '.$wpdb->prefix.'xyz_em_email_address ea INNER JOIN '.$wpdb->prefix.'xyz_em_address_list_mapping
						lm ON  ea.id=lm.ea_id WHERE lm.el_id="'.$xyz_em_emailListId.'" '.$exp_status_str.'   LIMIT '.$limitFrom.','.$xyz_em_exportbatchSize);
				$exportEmail = $exportDetails[0];


				$xyz_em_fieldValueDetails = $wpdb->get_results( 'SELECT field1 FROM '.$wpdb->prefix.'xyz_em_additional_field_value WHERE ea_id="'.$exportEmail->id.'"' ) ;
				$xyz_em_fieldValueDetails = $xyz_em_fieldValueDetails[0];
					
				if($xyz_em_fieldValueDetails->field1 != ""){

					$xyz_em_name =  $xyz_em_fieldValueDetails->field1;

				}
				

				if($currentBatch == 1){
					$myFile = realpath(dirname(__FILE__) . '/../../../')."/uploads/xyz_em/export/".$listName.".csv";
					$fh = fopen($myFile, 'w') or die("can't open file");
				}else{
					$myFile = realpath(dirname(__FILE__) . '/../../../')."/uploads/xyz_em/export/".$listName.".csv";
					$fh = fopen($myFile, 'a') or die("can't open file");

				}
				// 												echo '<pre>';
				// 												print_r($exportDetails);die;

				foreach ($exportDetails as $exportDetail){


					$xyz_em_fieldValueDetails = $wpdb->get_results( 'SELECT field1 FROM '.$wpdb->prefix.'xyz_em_additional_field_value WHERE ea_id="'.$exportDetail->id.'"' ) ;
					$xyz_em_fieldValueDetails = $xyz_em_fieldValueDetails[0];

					if($xyz_em_fieldValueDetails->field1 != ""){

						$xyz_em_name =  $xyz_em_fieldValueDetails->field1;

					}else{
						$xyz_em_name =  '';
					}

					if($xyz_em_name == ""){
							
						$stringData = '"'.$exportDetail->email.'"';
							
					}else{

						$stringData = '"'.$exportDetail->email.'","'.$xyz_em_name.'"';
							
					}
					$stringData = $stringData."\n";
					fwrite($fh, $stringData);
					$from = $limitFrom+1;
					$to = $limitTo;
					$total = $xyz_em_exportCount;
				}
				// 					die;

				if($fh){
					fclose($fh);
				}

			}else{
				$completedExport = 1;
				$completeExportFlag = 1;

			}
			$limitFrom = $limitTo;
			$createFile = $createFile + 1;
			$exportmsg =0;
		}else{
			header("Location:".admin_url('admin.php?page=newsletter-manager-importexport&action=import_export&exportNoActiveEmailmsg=1'));
			exit();
		}
		if($completeExportFlag == 1){


			header("Location:".plugins_url("newsletter-manager/download.php?fileName=".$listName));
			exit();
		}

	if($completedExport != 1 && $errorEmpty !=1){
		?>

<div>
	<h2>Export Emails From List</h2>
	<table class="widefat" style="width: 98%;">

		<tr>
			<td>
				<h4>
					<?php 
					echo 'Exporting '.$from.' to '.$to.' of '.$total.'<br/>';
					?>
				</h4>
			</td>
		</tr>
		<?php 
			
		if($currentBatch == $batchCount){

			?>
		<tr>
			<td id="bottomBorderNone"><span
				style="font-size: 14px; font-weight: bold;">Exporting Completed!</span>
				<a
				href="<?php echo admin_url('admin.php?page=newsletter-manager-importexport');?>"><?php echo 'Go Back';?>
			</a>
			</td>
		</tr>
		<?php 

		}

		?>
	</table>
</div>

<form method="post" name="xyz_em_formExportHidden">

	<input type="hidden" name="xyz_em_exportbatchSize" id="batchSize"
		value="<?php echo $xyz_em_exportbatchSize;?>"> <input type="hidden"
		name="limitFrom" id="limitFrom" value="<?php echo $limitFrom;?>"> <input
		type="hidden" name="exportForm" value="exportForm">
		
		<input type="hidden" name="xyz_em_exportCount" id="xyz_em_exportCount"
		value="<?php echo $xyz_em_exportCount;?>">
		
		<input type="hidden" name="xyz_em_exportOption" value="<?php if(isset($_POST['xyz_em_exportOption'])) echo $_POST['xyz_em_exportOption'];else echo $xyz_em_status; ?>">

</form>
<?php 

if($exportmsg!=1 && $exportmsg!=2){

	?>

<script type="text/javascript">
	
	window.setTimeout("document.forms['xyz_em_formExportHidden'].submit()", 2000);
	</script>


<?php 
}
	}


}else{



	if($exportmsg == 1 ){
		?>
<div class="system_notice_area_style0" id="system_notice_area">
	Batch size must be a positive whole number.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php

	}
	if(isset($_GET['exportNoActiveEmailmsg'])){
		$exportNoActiveEmailmsg = $_GET['exportNoActiveEmailmsg'];
	}
	if($exportNoActiveEmailmsg == 1 ){
		?>
	<div class="system_notice_area_style0" id="system_notice_area">
	No emails for export.&nbsp;&nbsp;&nbsp;<span
	id="system_notice_area_dismiss">Dismiss</span>
	</div>
	<?php
	
	}
	
	?>

<div>

	<h2>Export Emails from List</h2>
	<form method="post" name="xyz_em_formExport">
		<table class="widefat" style="width: 98%;">
			<tr>
				<td colspan="2"><b>Export</b></td>
			</tr>
			<tr valign="top">
				<td scope="row" style="width:230px;"><label for="xyz_em_exportOption">Select Status of Emails<font
						color="red">*</font>
				</label>
				</td>
				<td>
					<select name="xyz_em_exportOption">
						<option value="2" <?php if(isset($_POST['xyz_em_exportOption']) && ($_POST['xyz_em_exportOption'] == 1)){echo "selected";}?>>Export All</option>
						<option value="1" <?php if(isset($_POST['xyz_em_exportOption']) && ($_POST['xyz_em_exportOption'] == 1)){echo "selected";}?>>Export Active</option>
						<option value="-1" <?php if(isset($_POST['xyz_em_exportOption']) && ($_POST['xyz_em_exportOption'] == -1)){echo "selected";}?>>Export Pending</option>
						<option value="0" <?php if(isset($_POST['xyz_em_exportOption']) && ($_POST['xyz_em_exportOption'] == 0)){echo "selected";}?>>Export Block</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row"><label for="xyz_em_exportbatchSize">Batch Size<font
						color="red">*</font>
				</label>
				</td>
				<td><input style="margin-right: 70px;" id="input"
					name="xyz_em_exportbatchSize" type="text"
					id="xyz_em_exportbatchSize"
					value="<?php if(isset($_POST['xyz_em_exportbatchSize'])) echo absint($_POST['xyz_em_exportbatchSize']);else echo "1000"; ?>" />
				</td>
			</tr>
			<tr valign="top" class="alternate">
				<td scope="row" id="bottomBorderNone"></td>
				<td id="bottomBorderNone">
					<div style="height: 50px;">
						<input style="margin: 10px 0 20px 0;" id="submit_em"
							class="button-primary bottonWidth" type="submit" value="Export" />
					</div>
				</td>
			</tr>
		</table>
		<input type="hidden" name="exportForm" value="exportForm">
	</form>

	<?php 

}

?>








	<?php 
	$emptyError = 0;
	$completed = 0;

	$status = "";
	$emailProcessed = 0;
	$lineFrom = 0;
	$lineTo = 0;
	$totalLines = 0;
	$ftellValue = 0;

	$xyz_em_number_lines = 0;
	$xyz_em_hiddenLineNumberFrom= 0;
	$xyz_em_uploadFile_import = 0;
	$xyz_em_totalLines = 0;
	$xyz_em_separatorChar = "";
	$xyz_em_enclosingChar = "";
	$ftellValue = 0;
	$submited = 0;
	$formName = '';
	
	$_POST=xyz_trim_deep($_POST);
	$_POST = stripslashes_deep($_POST);
	
	if(isset($_POST['importForm'])=="importForm" && isset($_POST['xyz_em_batchSize']) || ($emptyError == 1)){
		//if((isset($_POST['xyz_em_batchSize'])) && ($emptyError == 1)){
		$formName = $_POST['importForm'];

		$xyz_em_emailListId = 1;
		$xyz_em_number_lines =absint( $_POST['xyz_em_batchSize']);

		if ($xyz_em_number_lines > 0){
			$xyz_em_separatorChar = $_POST['xyz_em_separator'];
			$xyz_em_enclosingChar = $_POST['xyz_em_enclCharacter'];
			$submited = 0;
			if(isset($_POST['submited'])){
				$submited = $_POST['submited'];
			}
			if($submited != 1){
				$xyz_em_uploadFile_import = $_FILES['xyz_em_uploadFile_import']['name'];
					
				if($xyz_em_uploadFile_import == ""){
					header("Location:".admin_url('admin.php?page=newsletter-manager-importexport&action=import_export&importmsg=2&batchsize='.$xyz_em_number_lines));
					exit();
				}
					
			}else{
				$xyz_em_uploadFile_import = $_POST['xyz_em_uploadFile_import'];
			}

			$xyz_em_extension = pathinfo($xyz_em_uploadFile_import);

			if (($xyz_em_extension['extension'] == "txt") || ($xyz_em_extension['extension'] == "csv")){
				if($submited != 1){

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


					$dir = "uploads/xyz_em/import";
					$targetfolder = realpath(dirname(__FILE__) . '/../../../')."/".$dir;


					if (!is_file($targetfolder) && !is_dir($targetfolder)) {

						mkdir($targetfolder) or die("Could not create directory " . $targetfolder);
						//echo $targetfolder;die;

						chmod($targetfolder, 0777); //make it writable
					}
					move_uploaded_file($_FILES['xyz_em_uploadFile_import']["tmp_name"],$targetfolder."/".$_FILES['xyz_em_uploadFile_import']['name']);

				}

				$dir = "uploads/xyz_em/import/";
				$targetfolder = realpath(dirname(__FILE__) . '/../../../')."/".$dir;
				$file = $targetfolder.$xyz_em_uploadFile_import;

				$afterPost = 1;
				if(isset($_POST['xyz_em_hiddenLineNumber'])){
					$xyz_em_hiddenLineNumberFrom = absint($_POST['xyz_em_hiddenLineNumber']);
				}

				$xyz_em_lineCountTo = $xyz_em_hiddenLineNumberFrom + $xyz_em_number_lines;
				
				if(isset($_POST['xyz_em_totalLinesNumber'])){
					$xyz_em_totalLines = absint($_POST['xyz_em_totalLinesNumber']);
				}
				
				
				
				if($xyz_em_totalLines == 0){
					$xyz_em_totalLines = count(file($file));
				}
				
				if($xyz_em_lineCountTo > $xyz_em_totalLines)	{
					$xyz_em_lineCountTo = $xyz_em_totalLines;
				}

				$xyz_em_batchCount = ceil($xyz_em_totalLines/$xyz_em_number_lines);
				$xyz_em_currentBatch=($xyz_em_hiddenLineNumberFrom==0)?1:(($xyz_em_hiddenLineNumberFrom/$xyz_em_number_lines) +1);

				$fromCount = $xyz_em_hiddenLineNumberFrom;

				$xyz_em_hiddenLineNumberFrom = $xyz_em_lineCountTo;

				$flag = 0;
// 				echo "cBa:".$xyz_em_currentBatch."<br/>";
// 				echo "bat:".$xyz_em_batchCount."<br/>";
				if($xyz_em_currentBatch <= $xyz_em_batchCount){

					$email = "";
					$file = fopen($file,"r");
					$arr = array();
					
					if(isset($_POST['xyz_em_hiddenFtellValues'])){
						if($_POST['xyz_em_hiddenFtellValues'] != ""){
							fseek($file,$_POST['xyz_em_hiddenFtellValues']);
						}
					}
					
					
					for($i=0;$i<$xyz_em_number_lines && !feof($file);$i++){

						$lines= fgets($file);
						
						$lines= str_replace("\r\n", "\n", $lines);
						$lines= str_replace("\r", "\n", $lines);
						
						$string = preg_replace("/$xyz_em_enclosingChar/","",$lines);
						
						$fieldArray = explode("\n",$string);

						$errorFlag = 0;
						$customValues = array();
						for($j=0;$j<count($fieldArray);$j++){

							$emailDetailsArray = explode($xyz_em_separatorChar,$fieldArray[$j]);
							
							for($k=0;$k<count($emailDetailsArray);$k++){
								$res = preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",$emailDetailsArray[$k],$matches);
								if ($res) {

									$email = $matches[0][0];
									$flag = $flag+1;
								}else{
									$customValues[] =  $emailDetailsArray[$k];
									continue;
								}
							}
						}
						$customValues = array_filter($customValues);
						if($email != ""){
							$name = implode(',', $customValues);
							$insertStatus = email_insert($email,$name,$xyz_em_emailListId);
							$arr[$email] =  $insertStatus;

						}
						
						
						
						$status = $arr;
						$emailProcessed = $flag;
						$lineFrom = $fromCount+1;
						$lineTo = $xyz_em_lineCountTo;
						$totalLines = $xyz_em_totalLines;
						$ftellValue = ftell($file);
						$emptyError = 1;
						$completed = 2;

					
					}
				}else{
					unlink ($file);
					$emptyError = 2;
					$completed = 1;

				}

			}

		}else{
			header("Location:".admin_url('admin.php?page=newsletter-manager-importexport&action=import_export&importmsg=1&batchsize='.$xyz_em_number_lines));
			exit();
		}

		if($completed != 1 && $emptyError == 1){
			?>


	<div>
		<h2>Import Emails to List</h2>
		<table class="widefat" style="width: 98%;">
			<tr>
				<td colspan="3">
					<h3>
						<?php
						echo 'Number of Email Processed In Given Batch  : '.$emailProcessed .'<br/>';
						?>
					</h3>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<h4>
						<?php 
						echo 'Importing '.$lineFrom.' to '.$lineTo.' of '.$totalLines.'<br/>';
						?>
					</h4>
				</td>
			</tr>

			<?php 	


			foreach ($status as $key=>$value){
				?>
			<tr>
				<?php 
				if($value == 1){
				?>
				
				<td  style="width:100px;"><?php echo $key;?></td>
				<td style="width:10px;">:</td>
				<td style="width:200px;">Added to database</td>
				<?php 
				}
				if($value == 2){
				?>
				<td  style="width:100px;"><?php echo $key;?></td>
				<td style="width:10px;">:</td>
				<td style="width:200px;">Already present in database</td>
				<?php 
				}

				?>
			
			</tr>

			<?php 
			}
			?>


		</table>
	</div>



	<form method="post" name="xyz_em_formImportHidden">
		<input type="hidden" name="importForm" value=<?php echo $formName;?>>
		<input type="hidden" name="xyz_em_batchSize"
			value="<?php echo $xyz_em_number_lines;?>" /> <input type="hidden"
			name="xyz_em_hiddenLineNumber"
			value="<?php echo $xyz_em_hiddenLineNumberFrom;?>" /> <input
			type="hidden" name="xyz_em_uploadFile_import"
			value="<?php echo $xyz_em_uploadFile_import;?>" /> <input
			type="hidden" name="xyz_em_totalLinesNumber"
			value="<?php echo $xyz_em_totalLines;?>" /> <input type="hidden"
			name="xyz_em_separator" value="<?php echo esc_attr($xyz_em_separatorChar);?>" />

		<input type="hidden" name="xyz_em_enclCharacter"
			value='<?php echo esc_attr($xyz_em_enclosingChar);?>' /> <input type="hidden"
			name="xyz_em_hiddenFtellValues" value="<?php echo $ftellValue;?>" />
		<input type="hidden" name="submited" value="1" />




	</form>
	<script type="text/javascript">

	window.setTimeout("document.forms['xyz_em_formImportHidden'].submit()", 2000); 	

	</script>

	<?php
		}elseif($completed==1){

			?>
	<h2>Import Emails to List</h2>
	<table class="widefat" style="width: 98%;">
		<tr>
			<td id="bottomBorderNone"><span
				style="font-size: 14px; font-weight: bold;">Importing Completed!</span>
				<a
				href="<?php echo admin_url('admin.php?page=newsletter-manager-manage-emails');?>"><?php echo 'Go to List';?>
			</a>
			</td>
		</tr>
	</table>
	<?php
		}

	}else{
		if(isset($_GET['importmsg'])){
			$importmsg =$_GET['importmsg'];
		}

		if($importmsg == 1){
			?>
	<div class="system_notice_area_style0" id="system_notice_area">
		Number of lines per batch must be a positive number.&nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
	</div>
	<?php 	

		}
		if($importmsg == 2){
			?>
	<div class="system_notice_area_style0" id="system_notice_area">
		Please browse a file( csv / txt ).&nbsp;&nbsp;&nbsp;<span
			id="system_notice_area_dismiss">Dismiss</span>
	</div>
	<?php

		}


		?>

	<div style="height: 30px;">&nbsp;</div>
	<h2>Import Emails to List</h2>
	<form method="post" name="xyz_em_formImport"
		enctype="multipart/form-data">
		<table class="widefat" style="width: 98%;">
			<tr>
				<td colspan="2"><b>Import</b></td>
			</tr>

			<tr>
				<td scope="row"><label for="xyz_em_import">Import list format</label>
				</td>

				<td>
				<b>We can import emails via two different formats</b><br/><br/>
				1. [enclosing character]email 1[enclosing character][separator][enclosing character]name 1[enclosing character][new line]<br /> 
				2. [enclosing character]name 2[enclosing character][separator][enclosing character]email 2[enclosing character][new line]
				<br/><br/>
					Example 1:	"abc@xyzscripts.com","Abc"<br/>
					Example 2 : "Pqr","pqr@xyzscripts.com"<br/>&nbsp;
				</td>
			</tr>

			<tr valign="top">
				<td scope="row"><label for="xyz_em_uploadFile_import">Choose file
						for Import ( csv / txt ) </label>
				</td>
				<td><input class="file" id="input" type="file"
					name="xyz_em_uploadFile_import" />
				</td>
			</tr>

			<tr valign="top">
				<td scope="row"><label for="xyz_em_batchSize">Number of lines per
						batch<span style="color:red;">*</span>
				</label>
				</td>
				<td><input id="input" name="xyz_em_batchSize" type="text"
					id="xyz_em_batchSize"
					value="<?php if(isset($_GET['batchsize'])) echo absint($_GET['batchsize']);else echo "1000"; ?>" />
				</td>
			</tr>

			<tr valign="top">
				<td scope="row"><label for="xyz_em_separator">Separator Character </label>
				</td>
				<td><input id="input" name="xyz_em_separator" type="text"
					id="xyz_em_separator" value="," />
				</td>
			</tr>

			<tr valign="top">
				<td scope="row"><label for="xyz_em_enclCharacter">Enclosing
						Character </label>
				</td>
				<td><input id="input" name="xyz_em_enclCharacter" type="text"
					id="xyz_em_enclCharacter" value='"' />
				</td>
			</tr>

			<tr valign="top" class="alternate">
				<td id="bottomBorderNone" scope="row"><label for="xyz_em_import"></label>
				</td>
				<td id="bottomBorderNone">
					<div style="height: 50px;">
						<input style="margin: 10px 0 20px 0;" id="submit_em"
							class="button-primary bottonWidth" type="submit" value="Import" />
					</div>
				</td>
			</tr>
		</table>
		<input type="hidden" name="importForm" value="importForm">
	</form>

</div>
<?php 

	}




	function email_insert($email,$name,$emailListId){
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		

		$time = time();
		$xyz_em_email = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_email_address WHERE email="'.$email.'" ') ;

		if(count($xyz_em_email) > 0){

			$xyz_em_email = $xyz_em_email[0];

			$xyz_em_emailLastid = $xyz_em_email->id;
		}else{

			$wpdb->insert($wpdb->prefix.'xyz_em_email_address',array('email'=>$email,'create_time'=>$time,'last_update_time'=>$time),array('%s','%d','%d'));
			$xyz_em_emailLastid = $wpdb->insert_id;

			$wpdb->insert($wpdb->prefix.'xyz_em_additional_field_value',array('ea_id'=>$xyz_em_emailLastid,'field1'=>$name),array('%d','%s'));
		}
		return email_add_mapping($xyz_em_emailLastid,$emailListId);


	}

	function email_add_mapping($emailId,$emailListId){
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$time = time();

		$xyz_em_mapping = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_address_list_mapping WHERE ea_id="'.$emailId.'" AND el_id="'.$emailListId.'"' ) ;
		if(count($xyz_em_mapping) == 0){
			$wpdb->insert($wpdb->prefix.'xyz_em_address_list_mapping', array('ea_id' => $emailId,'el_id' => $emailListId, 'create_time' => $time,'last_update_time' => $time,'status' => 1),array('%d','%d','%d','%d','%d'));
			return 1;
		}else{
			return 2;
		}

	}

	?>
