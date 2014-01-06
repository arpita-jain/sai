<?php 
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$smtpMessage = '';
if(isset($_GET['smtpmsg'])){
	$smtpMessage = $_GET['smtpmsg'];
}
if($smtpMessage == 1){

	?>
<div class="system_notice_area_style1" id="system_notice_area">
	SMTP account successfully blocked.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php 
}
if($smtpMessage == 2){

	?>
<div class="system_notice_area_style1" id="system_notice_area">
SMTP account successfully activated.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
if($smtpMessage == 3){

	?>
<div class="system_notice_area_style0" id="system_notice_area">
SMTP account not exist.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
if($smtpMessage == 4){

	?>
<div class="system_notice_area_style0" id="system_notice_area">
Default SMTP account can not block.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
if($smtpMessage == 5){

	?>
<div class="system_notice_area_style1" id="system_notice_area">
SMTP account successfully deleted.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
if($smtpMessage == 6){

	?>
<div class="system_notice_area_style0" id="system_notice_area">
Default SMTP account can not delete.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
?>

<div >

<h2>SMTP Account List</h2>
	<form method="post">
			<?php 
			global $wpdb;
			$pageno = '';
			$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
			$limit = get_option('xyz_em_limit');			
			$offset = ( $pagenum - 1 ) * $limit;
			
			$entries = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."xyz_em_sender_email_address  ORDER BY id DESC LIMIT $offset, $limit" );
			?>
			
			<input class="button-primary cfm_bottonWidth" id="submit_em"
				style="cursor: pointer; margin-bottom:10px;" type="button"
				name="textFieldButton2" value="Add New SMTP Account"
				 onClick='document.location.href="<?php echo admin_url('admin.php?page=newsletter-manager-manage-smtp&action=add-smtp');?>"'>
			
			
			<table class="widefat" style="width: 99%; margin: 0 auto">
				<thead>
					<tr>
						<th scope="col" style="">Email Address</th>
						<th scope="col" style="">Status</th>
						<th scope="col" colspan="3" style="text-align: center;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if( count($entries)>0 ) {
						if(isset($_GET['pagenum'])){
							$pageno = $_GET['pagenum'];
						}
						if($pageno == ""){
							$pageno = 1;
						}
						
						$count=1;
						$class = '';
						foreach( $entries as $entry ) {
							$class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
							?>
					<tr <?php echo $class; ?>>
						<td><?php 
						echo $entry->user;
						
						if($entry->set_default == 1){
							echo "   (Default SMTP Account)";
						}
						?></td>
						
						<td>
							<?php 
								if($entry->status == 0){
									echo "Block";	
								}elseif ($entry->status == 1){
								echo "Active";	
								}
							
							?>
						</td>
						
						
					<?php 

				if($entry->status == 0){

					?>	
						
					
						<td style="text-align: center;"><a
							href='<?php echo admin_url('admin.php?page=newsletter-manager-manage-smtp&action=smtp-block&id='.$entry->id.'&status=1&pageno='.$pageno); ?>'><img
								id="img" title="Block Account"
								src="<?php echo plugins_url('newsletter-manager/images/active.png')?>">
						</a>
						</td>
				<?php 

				}elseif ($entry->status == 1){

					?>
					
				<td style="text-align: center;"><a
							href='<?php echo admin_url('admin.php?page=newsletter-manager-manage-smtp&action=smtp-activate&id='.$entry->id.'&status=0&pageno='.$pageno); ?>'><img
								id="img" title="Block Account"
								src="<?php echo plugins_url('newsletter-manager/images/unsubscribe.png')?>">
						</a>
						</td>	
					
					<?php 
				}
				?>
						<td style="text-align: center;"><a
							href='<?php echo admin_url('admin.php?page=newsletter-manager-manage-smtp&action=smtp-edit&id='.$entry->id.'&status=0&pageno='.$pageno); ?>'><img
								id="img" title="Edit Account"
								src="<?php echo plugins_url('newsletter-manager/images/edit.png')?>">
						</a>
						</td>
						<td style="text-align: center;" ><a
							href='<?php echo admin_url('admin.php?page=newsletter-manager-manage-smtp&action=smtp-delete&id='.$entry->id.'&pageno='.$pageno); ?>'
							onclick="javascript: return confirm('Please click \'OK\' to confirm ');"><img
								id="img" title="Delete Account"
								src="<?php echo plugins_url('newsletter-manager/images/delete.png')?>">
						</a></td>
					</tr>
					<?php
					$count++;
						}
					} else { ?>
					<tr>
						<td colspan="5" id="bottomBorderNone">SMTP account not found</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<input class="button-primary cfm_bottonWidth" id="submit_em"
				style="cursor: pointer; margin-top:10px; margin-bottom:10px;" type="button"
				name="textFieldButton2" value="Add New SMTP Account"
				 onClick='document.location.href="<?php echo admin_url('admin.php?page=newsletter-manager-manage-smtp&action=add-smtp');?>"'>
			<?php
			
			
			
			$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM ".$wpdb->prefix."xyz_em_sender_email_address" );
			$num_of_pages = ceil( $total / $limit );

			$page_links = paginate_links( array(
					'base' => add_query_arg( 'pagenum','%#%'),
	    'format' => '',
	    'prev_text' =>  '&laquo;',
	    'next_text' =>  '&raquo;',
	    'total' => $num_of_pages,
	    'current' => $pagenum
			) );



			if ( $page_links ) {
				echo '<div class="tablenav" style="width:99%"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
			}

			?>


	</form>

</div>