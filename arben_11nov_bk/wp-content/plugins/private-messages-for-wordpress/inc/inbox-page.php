<?php
/**
 * Inbox page
 */
function rwpm_inbox()
{
	global $wpdb, $current_user;

// if view message
	
	if (isset($_GET['action']) && 'view' == $_GET['action'] && !empty($_GET['id']))
	{
		$id = $_GET['id'];

		check_admin_referer( "rwpm-view_inbox_msg_$id" );

		// mark message as read
		$wpdb->update( $wpdb->prefix . 'pm', array( 'read' => 1 ), array( 'id' => $id ) );

		// select message information
		$msg = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $id . '" LIMIT 1' );
		$msg->sender = $wpdb->get_var( "SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->sender'" );
		?>
	<div class="wrap">
		<h2><?php _e( 'Inbox \ View Message', 'pm4wp' ); ?></h2>

		<p><a href="?page=rwpm_inbox"><?php _e( 'Back to inbox', 'pm4wp' ); ?></a></p>
		<table class="widefat fixed" cellspacing="0">
			<thead>
			<tr>
				<th class="manage-column" width="20%"><?php _e( 'Info', 'pm4wp' ); ?></th>
				<th class="manage-column"><?php _e( 'Message', 'pm4wp' ); ?></th>
				<th class="manage-column" width="15%"><?php _e( 'Action', 'pm4wp' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><?php printf( __( '<b>Sender</b>: %s<br /><b>Date</b>: %s', 'pm4wp' ), $msg->sender, $msg->date ); ?></td>
				<td><?php printf( __( '<p><b>Subject</b>: %s</p><p>%s</p>', 'pm4wp' ), stripcslashes( $msg->subject ) , nl2br( stripcslashes( $msg->content ) ) ); ?></td>
				<td>
						<span class="delete">
							<a class="delete"
								href="<?php echo wp_nonce_url( "?page=rwpm_inbox&action=delete&id=$msg->id", 'rwpm-delete_inbox_msg_' . $msg->id ); ?>"><?php _e( 'Delete', 'pm4wp' ); ?></a>
						</span>
						<span class="reply">
							| <a class="reply"
							href="<?php echo wp_nonce_url( "?page=rwpm_send&recipient=$msg->sender&id=$msg->id&subject=Re: " . stripcslashes( $msg->subject ), 'rwpm-reply_inbox_msg_' . $msg->id ); ?>"><?php _e( 'Reply', 'pm4wp' ); ?></a>
						</span>
				</td>
			</tr>
			</tbody>
			<tfoot>
			<tr>
				<th class="manage-column" width="20%"><?php _e( 'Info', 'pm4wp' ); ?></th>
				<th class="manage-column"><?php _e( 'Message', 'pm4wp' ); ?></th>
				<th class="manage-column" width="15%"><?php _e( 'Action', 'pm4wp' ); ?></th>
			</tr>
			</tfoot>
		</table>
	</div>
	<?php
// don't need to do more!
		return;
	}

	// if mark messages as read
	if ( isset( $_GET['action'] ) && 'mar' == $_GET['action'] && !empty( $_GET['id'] ) )
	{
		$id = $_GET['id'];

		if ( !is_array( $id ) )
		{
			check_admin_referer( "rwpm-mar_inbox_msg_$id" );
			$id = array( $id );
		}
		else
		{
			check_admin_referer( "rwpm-bulk-action_inbox" );
		}
		$n = count( $id );
		$id = implode( ',', $id );
		if ( $wpdb->query( 'UPDATE ' . $wpdb->prefix . 'pm SET `read` = "1" WHERE `id` IN (' . $id . ')' ) )
		{
			$status = _n( 'Message marked as read.', 'Messages marked as read', $n, 'pm4wp' );
		}
		else
		{
			$status = __( 'Error. Please try again.', 'pm4wp' );
		}
	}

	// if delete message
	if ( isset( $_GET['action'] ) && 'delete' == $_GET['action'] && !empty( $_GET['id'] ) )
	{
		$id = $_GET['id'];

		if ( !is_array( $id ) )
		{
			check_admin_referer( "rwpm-delete_inbox_msg_$id" );
			$id = array( $id );
		}
		else
		{
			check_admin_referer( "rwpm-bulk-action_inbox" );
		}

		$error = false;
		foreach ( $id as $msg_id )
		{
			// check if the sender has deleted this message
			$sender_deleted = $wpdb->get_var( 'SELECT `deleted` FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '" LIMIT 1' );

			// create corresponding query for deleting message
			if ( $sender_deleted == 1 )
			{
				$query = 'DELETE from ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '"';
			}
			else
			{
				$query = 'UPDATE ' . $wpdb->prefix . 'pm SET `deleted` = "2" WHERE `id` = "' . $msg_id . '"';
			}

			if ( !$wpdb->query( $query ) )
			{
				$error = true;
			}
		}
		if ( $error )
		{
			$status = __( 'Error. Please try again.', 'pm4wp' );
		}
		else
		{
			$status = _n( 'Message deleted.', 'Messages deleted.', count( $id ), 'pm4wp' );
		}
	}

	// show all messages which have not been deleted by this user (deleted status != 2)
	$msgs = $wpdb->get_results( 'SELECT `id`, `sender`, `subject`, `read`, `date` FROM ' . $wpdb->prefix . 'pm WHERE `recipient` = "' . $current_user->user_login . '" AND `deleted` != "2" ORDER BY `date` DESC' );
	?>
<div class="wrap">
	<h2><?php _e( 'Inbox', 'pm4wp' ); ?></h2>
	<?php
	if ( !empty( $status ) )
	{
		echo '<div id="message" class="updated fade"><p>', $status, '</p></div>';
	}
	if ( empty( $msgs ) )
	{
		echo '<p>', __( 'You have no items in inbox.', 'pm4wp' ), '</p>';
	}
	else
	{
		$n = count( $msgs );
		$num_unread = 0;
		foreach ( $msgs as $msg )
		{
			if ( !( $msg->read ) )
			{
				$num_unread++;
			}
		}
		echo '<p>', sprintf( _n( 'You have %d job respond (%d unread).', 'You have %d job respond (%d unread).', $n, 'pm4wp' ), $n, $num_unread ), '</p>';
		?>
		<form action="" method="get">
			<?php wp_nonce_field( 'rwpm-bulk-action_inbox' ); ?>
			<input type="hidden" name="page" value="rwpm_inbox" />

			<div class="tablenav">
				<select name="action">
					<option value="-1" selected="selected"><?php _e( 'Bulk Action', 'pm4wp' ); ?></option>
					<option value="delete"><?php _e( 'Delete', 'pm4wp' ); ?></option>
					<option value="mar"><?php _e( 'Mark As Read', 'pm4wp' ); ?></option>
				</select> <input type="submit" class="button-secondary" value="<?php _e( 'Apply', 'pm4wp' ); ?>" />
			</div>

			<table class="widefat fixed" cellspacing="0">
				<thead>
				<tr>
					<th class="manage-column check-column"><input type="checkbox" /></th>
					<th class="manage-column" width="10%"><?php _e( 'Sender', 'pm4wp' ); ?></th>
					<th class="manage-column"><?php _e( 'Subject', 'pm4wp' ); ?></th>
					<th class="manage-column" width="20%"><?php _e( 'Date', 'pm4wp' ); ?></th>
				</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $msgs as $msg )
					{
						$msg->sender = $wpdb->get_var( "SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->sender'" );
						?>
					<tr>
						<th class="check-column"><input type="checkbox" name="id[]" value="<?php echo $msg->id; ?>" />
						</th>
						<td><?php echo $msg->sender; ?></td>
						<td>
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page=rwpm_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page=rwpm_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
							<div class="row-actions">
							<span>
								<a href="<?php echo wp_nonce_url( "?page=rwpm_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ); ?>"><?php _e( 'View', 'pm4wp' ); ?></a>
							</span>
								<?php
								if ( !( $msg->read ) )
								{
									?>
									<span>
								| <a href="<?php echo wp_nonce_url( "?page=rwpm_inbox&action=mar&id=$msg->id", 'rwpm-mar_inbox_msg_' . $msg->id ); ?>"><?php _e( 'Mark As Read', 'pm4wp' ); ?></a>
							</span>
									<?php

								}
								?>
								<span class="delete">
								| <a class="delete"
									href="<?php echo wp_nonce_url( "?page=rwpm_inbox&action=delete&id=$msg->id", 'rwpm-delete_inbox_msg_' . $msg->id ); ?>"><?php _e( 'Delete', 'pm4wp' ); ?></a>
							</span>
							<span class="reply">
								| <a class="reply"
								href="<?php echo wp_nonce_url( "?page=rwpm_send&recipient=$msg->sender&id=$msg->id&subject=Re: " . stripcslashes( $msg->subject ), 'rwpm-reply_inbox_msg_' . $msg->id ); ?>"><?php _e( 'Reply', 'pm4wp' ); ?></a>
							</span>
							</div>
						</td>
						<td><?php echo $msg->date; ?></td>
					</tr>
						<?php

					}
					?>
				</tbody>
				<tfoot>
				<tr>
					<th class="manage-column check-column"><input type="checkbox" /></th>
					<th class="manage-column"><?php _e( 'Sender', 'pm4wp' ); ?></th>
					<th class="manage-column"><?php _e( 'Subject', 'pm4wp' ); ?></th>
					<th class="manage-column"><?php _e( 'Date', 'pm4wp' ); ?></th>
				</tr>
				</tfoot>
			</table>
		</form>
		<?php

	}
	?>
</div>
<?php
}

function rwpm_frontend_inbox()
{
	global $wpdb, $current_user;

// if view message
	
	if (isset($_GET['page']) && 'rwpm_frontend_inbox'== $_GET['page'] && isset($_GET['action']) && 'view' == $_GET['action'] && !empty($_GET['id']))
	{
		$id = $_GET['id'];
			
			//echo "dsfdfdssfd"; die("dsfddf");
		//check_admin_referer( "rwpm-view_inbox_msg_$id" );

		// mark message as read
		$wpdb->update( $wpdb->prefix . 'pm', array( 'read' => 1 ), array( 'id' => $id ) );

		// select message information
		$msg = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $id . '" LIMIT 1' );
		$msg->sender = $wpdb->get_var( "SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->sender'" );
		?>
	<div class="msgcontainer">
		<h2><?php _e( 'Inbox\View Message', 'pm4wp' ); ?></h2>

	<div class="link_div"><span class="back_to_inbox"><a href="?page_id=437&page=rwpm_frontend_inbox"><?php _e( 'Back to inbox', 'pm4wp' ); ?></a></span>
	     <span class="delete">
		<a class="delete" id="delete_inbox_mail" href="javascript:void(0)"><?php _e( 'Delete', 'pm4wp' ); ?></a>
	     </span>
	     <span class="reply">
		<a class="reply" href="<?php echo wp_nonce_url( "?page_id=437&page=rwpm_front_message_send&recipient=$msg->sender&id=$msg->id&subject=Re: " . stripcslashes( $msg->subject ), 'rwpm-reply_inbox_msg_' . $msg->id ); ?>"><?php _e( 'Reply', 'pm4wp' ); ?></a>
	     </span>
	</div>
	<input type="hidden" id="delete_inbox_hidden" value="<?php echo wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=delete&id=$msg->id", 'rwpm-delete_inbox_msg_' . $msg->id ); ?>">
	<div class="msg_info">
		<span><b>Sender</b>:-</span><?php printf( __($msg->sender));?><span>&nbsp;&nbsp;<b>Date</b>:-</span><?php printf( __($msg->date));?><br/>
		<span><b>Subject</b>:-</span><?php printf( __($msg->subject));?><br/>
		<div class="message_content"><?php echo nl2br( stripcslashes( $msg->content )); ?></div>
	</div>
	</div>
	<?php
// don't need to do more!
		return;
	}

	// if mark messages as read
	if ( isset( $_GET['action'] ) && 'mar' == $_GET['action'] && !empty( $_GET['id'] ) )
	{
		$id = $_GET['id'];

		if ( !is_array( $id ) )
		{
			check_admin_referer( "rwpm-mar_inbox_msg_$id" );
			$id = array( $id );
		}
		else
		{
			check_admin_referer( "rwpm-bulk-action_inbox" );
		}
		$n = count( $id );
		$id = implode( ',', $id );
		if ( $wpdb->query( 'UPDATE ' . $wpdb->prefix . 'pm SET `read` = "1" WHERE `id` IN (' . $id . ')' ) )
		{
			$status = _n( 'Message marked as read.', 'Messages marked as read', $n, 'pm4wp' );
		}
		else
		{
			$status = __( 'Error. Please try again.', 'pm4wp' );
		}
	}

	// if delete message
	if ( isset($_GET['page']) && 'rwpm_frontend_inbox'== $_GET['page'] && isset( $_GET['action'] ) && 'delete' == $_GET['action'] && !empty( $_GET['id'] ) )
	{
		$id = $_GET['id'];
		
		if ( !is_array( $id ) )
		{
			//check_admin_referer( "rwpm-delete_inbox_msg_$id" );
			$id = array( $id );
		}
		else
		{
			//check_admin_referer( "rwpm-bulk-action_inbox" );
		}

		$error = false;
		foreach ( $id as $msg_id )
		{
			// check if the sender has deleted this message
			$sender_deleted = $wpdb->get_var( 'SELECT `deleted` FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '" LIMIT 1' );

			// create corresponding query for deleting message
			if ( $sender_deleted == 1 )
			{
				$query = 'DELETE from ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '"';
			}
			else
			{
				$query = 'UPDATE ' . $wpdb->prefix . 'pm SET `deleted` = "2" WHERE `id` = "' . $msg_id . '"';
			}

			if ( !$wpdb->query( $query ) )
			{
				$error = true;
			}
		}
		if ( $error )
		{
			$status = __( 'Error. Please try again.', 'pm4wp' );
		}
		else
		{
			$status = _n( 'Message deleted.', 'Messages deleted.', count( $id ), 'pm4wp' );
			wp_redirect(site_url()."?page_id=437&page=rwpm_frontend_inbox",'301'); exit;
		}
	}

	// show all messages which have not been deleted by this user (deleted status != 2)
	$msgs = $wpdb->get_results( 'SELECT `id`, `sender`, `subject`, `read`, `content` ,`content_doc` , `date` FROM ' . $wpdb->prefix . 'pm WHERE `recipient` = "' . $current_user->user_login . '" AND `deleted` != "2" ORDER BY `date` DESC' );
	?>
	<div class="msgcontainer">
	<h2><?php _e( 'Inbox', 'pm4wp' ); ?></h2>
	<?php
	if ( !empty( $status ) )
	{
		echo '<div id="message" class="updated fade"><p>', $status, '</p></div>';
	}
	if ( empty( $msgs ) )
	{
		echo '<p>', __( 'You have no items in inbox.', 'pm4wp' ), '</p>';
	}
	else
	{
		$n = count( $msgs );
		$num_unread = 0;
		foreach ( $msgs as $msg )
		{
			if ( !( $msg->read ) )
			{
				$num_unread++;
			}
		}
		echo '<div class="unread_msg">', sprintf( _n( 'You have %d job respond (%d unread).', 'You have %d job respond (%d unread).', $n, 'pm4wp' ), $n, $num_unread ), '</div>';
		?>
		 <script>
function showhide_inbox(small,big){
    //alert(small+' '+big);
	$('#'+small).hide();
	$('#'+big).show();
	//$(".show_thisjob").show();
	}
	function hideshow_inbox(small,big){
	$('#'+small).show();
	$('#'+big).hide();
	
 }
</script>
<script>
function printDiv(divName) {
	//alert(divName);
   var printContents = document.getElementById(divName).innerHTML;     
   var originalContents = document.body.innerHTML;       
   document.body.innerHTML = printContents;      
   window.print();      
   document.body.innerHTML = originalContents;
   }

</script>
		<form  id="inbox_form" action="" method="get">
			<?php // wp_nonce_field( 'rwpm-bulk-action_inbox' ); ?>
			    <input type="hidden" name="page_id" value="437"/>
			<input type="hidden" name="page" id="pagename" value="rwpm_frontend_inbox" />
					<input type="hidden" name="action" value="delete"/>
					<?php
					 $small_class_name1=0;
					 $big_class_name1=0;
					foreach ( $msgs as $msg )
					{
						$msg->sender = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->sender'" );
						$small_class_name1++;
						$big_class_name1++;
						$final_s_class1="show_small_div_inbox".$small_class_name1;
						$final_b_class1="show_big_div_inbox".$big_class_name1;
						?>
					<div class="msg" id="<?php echo $final_s_class1; ?>">
						<div class="msgtitle"><input type="checkbox"  class="checkboxmsg"  name="id[]" value="<?php echo $msg->id; ?>" />						
						<span><?php echo $msg->sender; ?></span></div>
						<div class="msgdesc">
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
						<span><?php if ( $msg->read ){	$cont=stripcslashes( $msg->content );
								$small_cont=substr($cont, 0, 40);
								echo '<b>'. $small_cont.'</b>';
						}
						else
							{
								$cont=stripcslashes( $msg->content );
								$small_cont=substr($cont, 0, 40);
								echo '<b>'. $small_cont.'</b>';
							}
							?></span>	
						</div>
						<div class="msgtime"><?php $dtObj = new DateTime( $msg->date );
								echo $dtObj->format('h:i A').PHP_EOL;?></div>
								<div class="read-more-job-btn"><span style=" margin-right: 15px;"><a href="javascript:void(0);" id="view_link" onclick="showhide_inbox('<?php echo $final_s_class1; ?>','<?php echo $final_b_class1;?>'); return false;">View</a></span>
								<span><a href="javascript:void(0);" onclick="printDiv('<?php echo $final_b_class1;?>'); return false;">Print</a></span>
						</div>
						
					</div>
					
					<div class="msg" id="<?php echo $final_b_class1; ?>" name="big_div" style="display:none;">
						<div class="msgtitle"><input type="checkbox"  class="checkboxmsg"  name="id[]" value="<?php echo $msg->id; ?>" />						
						<span><?php echo $msg->sender; ?></span></div>
						<div class="msgdesc">
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
						<span><?php if ( $msg->read ){	echo  stripcslashes( $msg->content); } else
							{
								echo '<b>'. stripcslashes( $msg->content ).'</b>';
								echo '<b>'. stripcslashes( $msg->content_doc ).'</b>';
								//echo '<b>'. stripcslashes( $msg->content ).'</b>';
							}
							?></span>	
						</div>
						<div class="msgtime"><?php $dtObj = new DateTime( $msg->date );
								echo $dtObj->format('h:i A').PHP_EOL;?></div>
								<div class="read-more-job-btn"><span style=" margin-right: 15px;"><a href="javascript:void(0);" id="hide_link" onclick="hideshow_inbox('<?php echo $final_s_class1; ?>','<?php echo $final_b_class1;?>'); return false;" >Hide</a></span>
								<span style="margin-left: 10px;">
						<span><a href="javascript:void(0);" onclick="printDiv('<?php echo $final_b_class1;?>'); return false;">Print</a></span>
						</span>
						</div>
					</div>
<?php
}
?>
		</form>
		<?php
	}
	?>
</div>
<?php
}

/**************mobile view inbox****************/
function rwpm_frontend_inbox_mobile()
{
	global $wpdb, $current_user;

// if view message
	
	if (isset($_GET['page']) && 'rwpm_frontend_inbox'== $_GET['page'] && isset($_GET['action']) && 'view' == $_GET['action'] && !empty($_GET['id']))
	{
		$id = $_GET['id'];
			
			//echo "dsfdfdssfd"; die("dsfddf");
		//check_admin_referer( "rwpm-view_inbox_msg_$id" );

		// mark message as read
		$wpdb->update( $wpdb->prefix . 'pm', array( 'read' => 1 ), array( 'id' => $id ) );

		// select message information
		$msg = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $id . '" LIMIT 1' );
		$msg->sender = $wpdb->get_var( "SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->sender'" );
		?>
	<div class="msgcontainer">
		<h2><?php _e( 'Inbox\View Message', 'pm4wp' ); ?></h2>

	<div class="link_div"><span class="back_to_inbox"><a href="?page_id=437&page=rwpm_frontend_inbox"><?php _e( 'Back to inbox', 'pm4wp' ); ?></a></span>
	     <span class="delete">
		<a class="delete" id="delete_inbox_mail" href="javascript:void(0)"><?php _e( 'Delete', 'pm4wp' ); ?></a>
	     </span>
	     <span class="reply">
		<a class="reply" href="<?php echo wp_nonce_url( "?page_id=437&page=rwpm_front_message_send&recipient=$msg->sender&id=$msg->id&subject=Re: " . stripcslashes( $msg->subject ), 'rwpm-reply_inbox_msg_' . $msg->id ); ?>"><?php _e( 'Reply', 'pm4wp' ); ?></a>
	     </span>
	</div>
	<input type="hidden" id="delete_inbox_hidden" value="<?php echo wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=delete&id=$msg->id", 'rwpm-delete_inbox_msg_' . $msg->id ); ?>">
	<div class="msg_info">
		<span><b>Sender</b>:-</span><?php printf( __($msg->sender));?><span>&nbsp;&nbsp;<b>Date</b>:-</span><?php printf( __($msg->date));?><br/>
		<span><b>Subject</b>:-</span><?php printf( __($msg->subject));?><br/>
		<div class="message_content"><?php echo nl2br( stripcslashes( $msg->content )); ?></div>
	</div>
	</div>
	<?php
// don't need to do more!
		return;
	}

	// if mark messages as read
	if ( isset( $_GET['action'] ) && 'mar' == $_GET['action'] && !empty( $_GET['id'] ) )
	{
		$id = $_GET['id'];

		if ( !is_array( $id ) )
		{
			check_admin_referer( "rwpm-mar_inbox_msg_$id" );
			$id = array( $id );
		}
		else
		{
			check_admin_referer( "rwpm-bulk-action_inbox" );
		}
		$n = count( $id );
		$id = implode( ',', $id );
		if ( $wpdb->query( 'UPDATE ' . $wpdb->prefix . 'pm SET `read` = "1" WHERE `id` IN (' . $id . ')' ) )
		{
			$status = _n( 'Message marked as read.', 'Messages marked as read', $n, 'pm4wp' );
		}
		else
		{
			$status = __( 'Error. Please try again.', 'pm4wp' );
		}
	}

	// if delete message
	if ( isset($_GET['page']) && 'rwpm_frontend_inbox'== $_GET['page'] && isset( $_GET['action'] ) && 'delete' == $_GET['action'] && !empty( $_GET['id'] ) )
	{
		$id = $_GET['id'];
		
		if ( !is_array( $id ) )
		{
			//check_admin_referer( "rwpm-delete_inbox_msg_$id" );
			$id = array( $id );
		}
		else
		{
			//check_admin_referer( "rwpm-bulk-action_inbox" );
		}

		$error = false;
		foreach ( $id as $msg_id )
		{
			// check if the sender has deleted this message
			$sender_deleted = $wpdb->get_var( 'SELECT `deleted` FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '" LIMIT 1' );

			// create corresponding query for deleting message
			if ( $sender_deleted == 1 )
			{
				$query = 'DELETE from ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '"';
			}
			else
			{
				$query = 'UPDATE ' . $wpdb->prefix . 'pm SET `deleted` = "2" WHERE `id` = "' . $msg_id . '"';
			}

			if ( !$wpdb->query( $query ) )
			{
				$error = true;
			}
		}
		if ( $error )
		{
			$status = __( 'Error. Please try again.', 'pm4wp' );
		}
		else
		{
			$status = _n( 'Message deleted.', 'Messages deleted.', count( $id ), 'pm4wp' );
			wp_redirect(site_url()."?page_id=437&page=rwpm_frontend_inbox",'301'); exit;
		}
	}

	// show all messages which have not been deleted by this user (deleted status != 2)
	$msgs = $wpdb->get_results( 'SELECT `id`, `sender`, `subject`, `read`, `content` ,`content_doc` , `date` FROM ' . $wpdb->prefix . 'pm WHERE `recipient` = "' . $current_user->user_login . '" AND `deleted` != "2" ORDER BY `date` DESC' );
	?>
	<div class="msgcontainer">
	<h2><?php _e( 'Inbox', 'pm4wp' ); ?></h2>
	<?php
	if ( !empty( $status ) )
	{
		echo '<div id="message" class="updated fade"><p>', $status, '</p></div>';
	}
	if ( empty( $msgs ) )
	{
		echo '<p>', __( 'You have no items in inbox.', 'pm4wp' ), '</p>';
	}
	else
	{
		$n = count( $msgs );
		$num_unread = 0;
		foreach ( $msgs as $msg )
		{
			if ( !( $msg->read ) )
			{
				$num_unread++;
			}
		}
		echo '<div class="unread_msg">', sprintf( _n( 'You have %d job respond (%d unread).', 'You have %d job respond (%d unread).', $n, 'pm4wp' ), $n, $num_unread ), '</div>';
		?>
		 <script>
function showhide_inbox(small,big){
    //alert(small+' '+big);
	$('#'+small).hide();
	$('#'+big).show();
	//$(".show_thisjob").show();
	}
	function hideshow_inbox(small,big){
	$('#'+small).show();
	$('#'+big).hide();
	
 }
</script>
<script>
function printDiv(divName) {
	//alert(divName);
   var printContents = document.getElementById(divName).innerHTML;     
   var originalContents = document.body.innerHTML;       
   document.body.innerHTML = printContents;      
   window.print();      
   document.body.innerHTML = originalContents;
   }

</script>
		
		<form  id="inbox_form" action="" method="get">
			<?php // wp_nonce_field( 'rwpm-bulk-action_inbox' ); ?>
			    <input type="hidden" name="page_id" value="437"/>
			<input type="hidden" name="page" id="pagename" value="rwpm_frontend_inbox" />
					<input type="hidden" name="action" value="delete"/>
					<?php
					 $small_class_name1=0;
					 $big_class_name1=0;
					foreach ( $msgs as $msg )
					{
						$msg->sender = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->sender'" );
						$small_class_name1++;
						$big_class_name1++;
						$final_s_class1="show_small_div_inbox".$small_class_name1;
						$final_b_class1="show_big_div_inbox".$big_class_name1;
						?>
					<div class="msg" id="<?php echo $final_s_class1; ?>">
						<div class="msgtitle"><input type="checkbox"  class="checkboxmsg"  name="id[]" value="<?php echo $msg->id; ?>" />						
						<span><?php echo $msg->sender; ?></span></div>
						<div class="msgdesc">
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
						<span><?php if ( $msg->read ){	$cont=stripcslashes( $msg->content );
								$small_cont=substr($cont, 0, 40);
								echo '<b>'. $small_cont.'</b>';
						}
						else
							{
								$cont=stripcslashes( $msg->content );
								$small_cont=substr($cont, 0, 40);
								echo '<b>'. $small_cont.'</b>';
							}
							?></span>	
						</div>
						<div class="msgtime"><?php $dtObj = new DateTime( $msg->date );
								echo $dtObj->format('h:i A').PHP_EOL;?></div>
								<div class="read-more-job-btn"><span style=" margin-right: 15px;"><a href="javascript:void(0);" id="view_link" onclick="showhide_inbox('<?php echo $final_s_class1; ?>','<?php echo $final_b_class1;?>'); return false;">View</a></span>
								<span><a href="javascript:void(0);" onclick="printDiv('<?php echo $final_b_class1;?>'); return false;">Print</a></span>
						</div>
					</div>
					<div class="msg" id="<?php echo $final_b_class1; ?>" name="big_div" style="display:none;">
						<div class="msgtitle"><input type="checkbox"  class="checkboxmsg"  name="id[]" value="<?php echo $msg->id; ?>" />						
						<span><?php echo $msg->sender; ?></span></div>
						<div class="msgdesc">
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_frontend_inbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
						<span><?php if ( $msg->read ){	echo  stripcslashes( $msg->content); } else
							{
								echo '<b>'. stripcslashes( $msg->content ).'</b>';
								echo '<b>'. stripcslashes( $msg->content_doc ).'</b>';
								//echo '<b>'. stripcslashes( $msg->content ).'</b>';
							}
							?></span>	
						</div>
						<div class="msgtime"><?php $dtObj = new DateTime( $msg->date );
								echo $dtObj->format('h:i A').PHP_EOL;?></div>
								<div class="read-more-job-btn"><span style=" margin-right: 15px;"><a href="javascript:void(0);" id="hide_link" onclick="hideshow_inbox('<?php echo $final_s_class1; ?>','<?php echo $final_b_class1;?>'); return false;" >Hide</a></span>
								<span style="margin-left: 10px;">
						<span><a href="javascript:void(0);" onclick="printDiv('<?php $final_b_class1;?>'); return false;">Print</a></span>
						</span>
						</div>
					</div>
<?php
}
?>
		</form>

		
		<?php
	}
	?>
</div>
<?php
}

?>