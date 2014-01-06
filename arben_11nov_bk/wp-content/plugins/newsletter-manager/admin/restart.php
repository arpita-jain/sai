<?php
global $wpdb;

if($_POST){

$_POST=xyz_trim_deep($_POST);
$_POST = stripslashes_deep($_POST);

	if ($_POST['campaignRestart']!= ""){
				
		if($_POST['xyz_em_hiddenPageNumber'] == 0){
			$xyz_em_hiddenPageNumber = 1;
		}else{
			$xyz_em_hiddenPageNumber = $_POST['xyz_em_hiddenPageNumber'];
		}
		
		$xyz_em_campId = absint($_POST['xyz_em_hiddenCampId']);
		$xyz_em_pageno = absint($xyz_em_hiddenPageNumber);
		$xyz_em_restartCondition = absint($_POST['campaignRestart']);
		
		if($xyz_em_campId=="" || !is_numeric($xyz_em_campId)){
			header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns'));
			exit();
		
		}
		$emailCount = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_campaign WHERE id="'.$xyz_em_campId.'" ' ) ;
		
		if(count($emailCount) == 0){
			header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns'));
			exit();
		}else{
		
			$startTime = time();
			$last_send_mapping_id = 0;
			$send_count = 0;
			$last_fired_time = 0;
		
			if($xyz_em_restartCondition == 1){

				$wpdb->update($wpdb->prefix.'xyz_em_email_campaign', array('last_send_mapping_id'=>$last_send_mapping_id, 'send_count'=>$send_count, 'start_time'=>$startTime,'last_fired_time'=>$last_fired_time,'status'=>-1), array('id'=>$xyz_em_campId));
		
			}elseif($xyz_em_restartCondition == 2){
		
				$wpdb->update($wpdb->prefix.'xyz_em_email_campaign', array('last_send_mapping_id'=>$last_send_mapping_id, 'send_count'=>$send_count, 'start_time'=>$startTime,'last_fired_time'=>$last_fired_time,'status'=>1), array('id'=>$xyz_em_campId));
		
			}
			
			header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns&campmsg=1&pagenum='.$xyz_em_pageno));
			exit();
		}
		
				
	}else{
	?>
	<div class="system_notice_area_style0" id="system_notice_area">
		Please select any restart condition. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
	</div>
	<?php 
	}
}
?>

<div>

<?php 

$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$xyz_em_campId = absint($_GET['id']);
$xyz_em_pageno = absint($_GET['pageno']);

if($xyz_em_campId=="" || !is_numeric($xyz_em_campId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns'));
	exit();

}
$emailCount = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_campaign WHERE id="'.$xyz_em_campId.'" ' ) ;

if(count($emailCount) == 0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns'));
	exit();
}else{
?>


<h2>Campaign Restart Option</h2>
	<form method="post">
	<div style="float: left;width: 99%">
	<table class="widefat"  style="width:99%;">
		<tr>
			<td style="border-top:none;border-bottom:none;">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-top:none;border-bottom:none;"><input type="radio" name="campaignRestart"
				value="1" />Make campaign pending and reset the statistics</td>
		</tr>
		<tr>
			<td style="border-top:none;border-bottom:none;">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-top:none;border-bottom:none;"><input checked="checked" type="radio" name="campaignRestart"
				value="2" />Make campaign active and reset the statistics</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2 id="bottomBorderNone" >
			<div style="height:50px;"><input style="margin:10px 0 20px 0;" id="submit_em" type="submit" value="Update" />
			<a href="javascript:history.back(-1);" style="margin:10px 0 20px 30px;" id="submit_em" >Exit</a></div>
			
			</td>
		</tr>
	</table>
	<input type="hidden" name="xyz_em_hiddenCampId" value="<?php if(isset($_POST['"xyz_em_hiddenCampId"']) ){echo esc_attr($_POST['"xyz_em_hiddenCampId"']);}else{echo $xyz_em_campId;}?>"/>
	<input type="hidden" name="xyz_em_hiddenPageNumber" value="<?php if(isset($_POST['xyz_em_hiddenPageNumber']) ){echo esc_attr($_POST['xyz_em_hiddenPageNumber']);}else{echo $xyz_em_pageno;}?>"/>
</div>
</form>
</div>
<?php 
}
?>