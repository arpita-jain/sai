<?php
/**
 * Outbox page
 */
function rwpm_outbox()
{
    global $wpdb, $current_user;

    // if view message
    
    if (isset($_GET['page']) && 'rwpm_outbox'== $_GET['page'] && isset($_GET['action']) && 'view' == $_GET['action'] && !empty($_GET['id']))
    {
        $id = $_GET['id'];
        check_admin_referer("rwpm-view_outbox_msg_$id");
        // select message information
        $msg = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $id . '" LIMIT 1');
        $msg->sender = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->sender'");
        ?>
    <div class="wrap">
        <h2><?php _e('Outbox \ View Message', 'pm4wp'); ?></h2>

        <p><a href="?page=rwpm_outbox"><?php _e('Back to outbox', 'pm4wp'); ?></a></p>
        <table class="widefat fixed" cellspacing="0">
            <thead>
            <tr>
                <th class="manage-column" width="20%"><?php _e('Info', 'pm4wp'); ?></th>
                <th class="manage-column"><?php _e('Message', 'pm4wp'); ?></th>
                <th class="manage-column" width="15%"><?php _e('Action', 'pm4wp'); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php printf(__('<b>Recipient</b>: %s<br /><b>Date</b>: %s', 'pm4wp'), $msg->sender, $msg->date); ?></td>
                <td><?php printf(__('<p><b>Subject</b>: %s</p><p>%s</p>', 'pm4wp'), stripcslashes($msg->subject), nl2br(stripcslashes($msg->content))); ?></td>
                <td>
						<span class="delete">
							<a class="delete"
                               href="<?php echo wp_nonce_url("?page=rwpm_outbox&action=delete&id=$msg->id", 'rwpm-delete_outbox_msg_' . $msg->id); ?>"><?php _e('Delete', 'pm4wp'); ?></a>
		</span>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th class="manage-column" width="20%"><?php _e('Info', 'pm4wp'); ?></th>
                <th class="manage-column"><?php _e('Message', 'pm4wp'); ?></th>
                <th class="manage-column" width="15%"><?php _e('Action', 'pm4wp'); ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
    <?php
        // don't need to do more!
        return;
    }

    // if delete message
    if (isset($_GET['action']) && 'delete' == $_GET['action'] && !empty($_GET['id'])) {
        $id = $_GET['id'];

        if (!is_array($id)) {
            check_admin_referer("rwpm-delete_outbox_msg_$id");
            $id = array($id);
        } else {
            check_admin_referer("rwpm-bulk-action_outbox");
        }
        $error = false;
        foreach ($id as $msg_id) {
            // check if the recipient has deleted this message
            $recipient_deleted = $wpdb->get_var('SELECT `deleted` FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '" LIMIT 1');
            // create corresponding query for deleting message
            if ($recipient_deleted == 2) {
                $query = 'DELETE from ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '"';
            } else {
                $query = 'UPDATE ' . $wpdb->prefix . 'pm SET `deleted` = "1" WHERE `id` = "' . $msg_id . '"';
            }

            if (!$wpdb->query($query)) {
                $error = true;
            }
        }
        if ($error) {
            $status = __('Error. Please try again.', 'pm4wp');
        } else {
            $status = _n('Message deleted.', 'Messages deleted.', count($id), 'pm4wp');
        }
    }

    // show all messages
    $msgs = $wpdb->get_results('SELECT `id`, `recipient`, `subject`, `date` FROM ' . $wpdb->prefix . 'pm WHERE `sender` = "' . $current_user->user_login . '" AND `deleted` != 1 ORDER BY `date` DESC');
    ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>

<div class="wrap">
    <h2><?php _e('Outbox', 'pm4wp'); ?></h2>
    <?php
    if (!empty($status)) {
        echo '<div id="message" class="updated fade"><p>', $status, '</p></div>';
    }
    if (empty($msgs)) {
        echo '<p>', __('You have no items in outbox.', 'pm4wp'), '</p>';
    } else {
        $n = count($msgs);
        echo '<p>', sprintf(_n('You wrote %d private message.', 'You wrote %d private messages.', $n, 'pm4wp'), $n), '</p>';
        ?>
        <form action="" method="get">
            <?php wp_nonce_field('rwpm-bulk-action_outbox'); ?>
            <input type="hidden" name="action" value="delete"/> <input type="hidden" name="page" value="rwpm_outbox"/>

            <div class="tablenav">
                <input type="submit" class="button-secondary" value="<?php _e('Delete Selected', 'pm4wp'); ?>"/>
            </div>

            <table class="widefat fixed" cellspacing="0">
                <thead>
                <tr>
                    <th class="manage-column check-column"><input type="checkbox"/></th>
                    <th class="manage-column" width="10%"><?php _e('Recipient', 'pm4wp'); ?></th>
                    <th class="manage-column"><?php _e('Subject', 'pm4wp'); ?></th>
                    <th class="manage-column" width="20%"><?php _e('Date', 'pm4wp'); ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($msgs as $msg) {
                        $msg->recipient = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->recipient'");
                        ?>
                    <tr>
                        <th class="check-column"><input type="checkbox" name="id[]" value="<?php echo $msg->id; ?>"/>
                        </th>
                        <td><?php echo $msg->recipient; ?></td>
                        <td>
                            <?php
                            echo '<a href="', wp_nonce_url("?page=rwpm_outbox&action=view&id=$msg->id", 'rwpm-view_outbox_msg_' . $msg->id), '">', stripcslashes($msg->subject), '</a>';
                            ?>
                            <div class="row-actions">
							<span>
								<a href="<?php echo wp_nonce_url("?page=rwpm_outbox&action=view&id=$msg->id", 'rwpm-view_outbox_msg_' . $msg->id); ?>"><?php _e('View', 'pm4wp'); ?></a>
							</span>
							<span class="delete">
								| <a class="delete"
                                     href="<?php echo wp_nonce_url("?page=rwpm_outbox&action=delete&id=$msg->id", 'rwpm-delete_outbox_msg_' . $msg->id); ?>"><?php _e('Delete', 'pm4wp'); ?></a>
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
                    <th class="manage-column check-column"><input type="checkbox"/></th>
                    <th class="manage-column"><?php _e('Recipient', 'pm4wp'); ?></th>
                    <th class="manage-column"><?php _e('Subject', 'pm4wp'); ?></th>
                    <th class="manage-column"><?php _e('Date', 'pm4wp'); ?></th>
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


//front message iutbox function

function rwpm_front_message_outbox()
{
    global $wpdb, $current_user;

    // if view message
    
    if (isset($_GET['page']) && 'rwpm_front_message_outbox'== $_GET['page'] && isset($_GET['action']) && 'view' == $_GET['action'] && !empty($_GET['id']))
    {
        $id = $_GET['id'];

        //check_admin_referer("rwpm-view_outbox_msg_$id");

        // select message information
        $msg = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $id . '" LIMIT 1');
        $msg->recipient = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->recipient'");
        ?>
    <div class="msgcontainer">
        <h2><?php _e('Outbox \ View Message', 'pm4wp'); ?></h2>
	<div class="link_div"><span class="back_to_inbox"><a href="?page_id=437&page=rwpm_front_message_outbox"><?php _e( 'Back to outbox', 'pm4wp' ); ?></a></span>
	     <span class="delete">
		<a class="delete_outbox_mail" href="javascript:void(0)"><?php _e( 'Delete', 'pm4wp' ); ?></a>
	     </span>
	</div>
	<input type="hidden" id="delete_outbox_hidden" value="<?php echo wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=delete&id=$msg->id", 'rwpm-delete_outbox_msg_' . $msg->id ); ?>">
	<div class="msg_info">
		<span><b>Sender</b>:-</span><?php printf( __($msg->recipient));?><span><b>&nbsp;&nbsp;Date</b>:-</span><?php printf( __($msg->date));?><br/>
		<span><b>Subject</b>:-</span><?php printf( __($msg->subject));?><br/>
		<div class="message_content"><?php echo nl2br( stripcslashes( $msg->content )); ?></div>
	</div>     
   </div>
    <?php
        // don't need to do more!
        return;
    }

    // if delete message
    if (isset($_GET['action']) && 'delete' == $_GET['action'] && !empty($_GET['id'])) {
        $id = $_GET['id'];

        if (!is_array($id)) {
            //check_admin_referer("rwpm-delete_outbox_msg_$id");
            $id = array($id);
        } else {
           // check_admin_referer("rwpm-bulk-action_outbox");
        }
        $error = false;
        foreach ($id as $msg_id) {
            // check if the recipient has deleted this message
            $recipient_deleted = $wpdb->get_var('SELECT `deleted` FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '" LIMIT 1');
            // create corresponding query for deleting message
            if ($recipient_deleted == 2) {
                $query = 'DELETE from ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '"';
            } else {
                $query = 'UPDATE ' . $wpdb->prefix . 'pm SET `deleted` = "1" WHERE `id` = "' . $msg_id . '"';
            }

            if (!$wpdb->query($query)) {
                $error = true;
            }
        }
        if ($error) {
            $status = __('Error. Please try again.', 'pm4wp');
        } else {
            $status = _n('Message deleted.', 'Messages deleted.', count($id), 'pm4wp');
        }
    }
    // show all messages
    $msgs = $wpdb->get_results('SELECT `id`, `recipient`, `subject`,`content`,`content_doc`, `date` FROM ' . $wpdb->prefix . 'pm WHERE `sender` = "' . $current_user->user_login . '" AND `deleted` != 1 ORDER BY `date` DESC');
    ?>
<div class="msgcontainer">
    <h2><?php _e('Outbox', 'pm4wp'); ?></h2>
    <?php
    if (!empty($status)) {
        echo '<div id="message" class="updated fade"><p>', $status, '</p></div>';
    }
    if (empty($msgs)) {
        echo '<div class="message_outbox">', __('You have no items in outbox.', 'pm4wp'), '</div>';
    } else {
        $n = count($msgs);
        echo '<div class="message_outbox">', sprintf(_n('You requested %d CV/Quotes', 'You requested %d CV/Quotes', $n, 'pm4wp'), $n), '</div>';
        ?>
	
 <script>
function showhide(small,big){
    //alert(small+' '+big);
	$('#'+small).hide();
	$('#'+big).show();
	//$(".show_thisjob").show();
	}
	function hideshow(small,big){
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
        <form id="outbox_form" action="" method="get">
	    <input type="hidden" name="page_id" value="437"/>
	    	<input type="hidden" name="page" id="pagename1" value="rwpm_front_message_outbox" />
		<input type="hidden" name="action" value="delete"/>
            <?php //wp_nonce_field('rwpm-bulk-action_outbox'); ?>
	        <?php
	        $small_class_name=0;
	        $big_class_name=0;
		$button_view=0;
		$button_hide=0;
               foreach ($msgs as $msg) {
               $msg->recipient = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->recipient'");
	       $small_class_name++;
	       $big_class_name++;
	       $button_view++;
	       $button_hide++;
	       $showbutton="view_link".$button_view;
	       $hidebutton="hide_link".$button_hide;
	       $final_s_class="show_small_div".$small_class_name;
	       $final_b_class="show_big_div".$big_class_name;
?>
<div class="msg" id="<?php echo $final_s_class; ?>">
    <div class="msgtitle check-column"><input id="checkinput1" class="checkboxmsg1" type="checkbox" name="id[]" value="<?php echo $msg->id; ?>"/>	       <span><?php echo $msg->recipient; ?></span>
    </div>
    <div class="msgdesc">
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=view&id=$msg->id", 'rwpm-delete_outbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
						<span class="asds"><?php
							if ( $msg->read )
							{
								$cont=stripcslashes( $msg->content );
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
						</div><!--close msgdesc-->
						<div class="msgtime"><?php $dtObj = new DateTime( $msg->date );
							echo $dtObj->format('h:i A').PHP_EOL;?>
						</div>
							
						<div class="read-more-job-btn">
						<span style=" margin-right: 15px;">
						<a href="javascript:void(0);" id="<?php echo $showbutton ?>" onclick="showhide('<?php echo $final_s_class; ?>','<?php echo $final_b_class;?>'); return false;">View</a>
						</span><span>
						<a href="javascript:void(0);" onclick="printDiv('<?php echo $final_b_class1;?>'); return false;">Print</a>
						</span><!--close read-more-job-btn-->
						</div>
						
					</div>
					<!--For big div-->
					 <div class="msg" id="<?php echo $final_b_class; ?>" style="display: none;" >
						<div class="msgtitle check-column"><input id="checkinput1" class="checkboxmsg1" type="checkbox" name="id[]" value="<?php echo $msg->id; ?>"/>						
						<span><?php echo $msg->recipient; ?></span></div>
						<div class="msgdesc">
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=view&id=$msg->id", 'rwpm-delete_outbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
						<span><?php
							if ( $msg->read )
							{
								echo  stripcslashes( $msg->content );
								echo  stripcslashes( $msg->content_doc );
							}
							else
							{
								echo '<b>'. stripcslashes( $msg->content ).'</b>';
								echo '<b>'. stripcslashes( $msg->content_doc ).'</b>';
							}
							?></span>	
						</div>
						<div class="msgtime"><?php $dtObj = new DateTime( $msg->date );
							echo $dtObj->format('h:i A').PHP_EOL;?></div>
							    <div class="read-more-job-btn"><span style=" margin-right: 15px;"><a href="javascript:void(0);" id="<?php echo $hidebutton ?>" onclick="hideshow('<?php echo $final_s_class; ?>','<?php echo $final_b_class;?>'); return false;" >Hide</a></span>
							    <span><a href="javascript:void(0);" onclick="printDiv('<?php echo $final_b_class1;?>'); return false;">Print</a></span>
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
/********************mobile view inbox**********/
function rwpm_front_message_outbox_mobile()
{
    global $wpdb, $current_user;

    // if view message
    
    if (isset($_GET['page']) && 'rwpm_front_message_outbox'== $_GET['page'] && isset($_GET['action']) && 'view' == $_GET['action'] && !empty($_GET['id']))
    {
        $id = $_GET['id'];

        //check_admin_referer("rwpm-view_outbox_msg_$id");

        // select message information
        $msg = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $id . '" LIMIT 1');
        $msg->recipient = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->recipient'");
        ?>
    <div class="msgcontainer">
        <h2><?php _e('Outbox \ View Message', 'pm4wp'); ?></h2>
	<div class="link_div"><span class="back_to_inbox"><a href="?page_id=437&page=rwpm_front_message_outbox"><?php _e( 'Back to outbox', 'pm4wp' ); ?></a></span>
	     <span class="delete">
		<a class="delete_outbox_mail" href="javascript:void(0)"><?php _e( 'Delete', 'pm4wp' ); ?></a>
	     </span>
	</div>
	<input type="hidden" id="delete_outbox_hidden" value="<?php echo wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=delete&id=$msg->id", 'rwpm-delete_outbox_msg_' . $msg->id ); ?>">
	<div class="msg_info">
		<span><b>Sender</b>:-</span><?php printf( __($msg->recipient));?><span><b>&nbsp;&nbsp;Date</b>:-</span><?php printf( __($msg->date));?><br/>
		<span><b>Subject</b>:-</span><?php printf( __($msg->subject));?><br/>
		<div class="message_content"><?php echo nl2br( stripcslashes( $msg->content )); ?></div>
	</div>     
   </div>
    <?php
        // don't need to do more!
        return;
    }

    // if delete message
    if (isset($_GET['action']) && 'delete' == $_GET['action'] && !empty($_GET['id'])) {
        $id = $_GET['id'];

        if (!is_array($id)) {
            //check_admin_referer("rwpm-delete_outbox_msg_$id");
            $id = array($id);
        } else {
           // check_admin_referer("rwpm-bulk-action_outbox");
        }
        $error = false;
        foreach ($id as $msg_id) {
            // check if the recipient has deleted this message
            $recipient_deleted = $wpdb->get_var('SELECT `deleted` FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '" LIMIT 1');
            // create corresponding query for deleting message
            if ($recipient_deleted == 2) {
                $query = 'DELETE from ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '"';
            } else {
                $query = 'UPDATE ' . $wpdb->prefix . 'pm SET `deleted` = "1" WHERE `id` = "' . $msg_id . '"';
            }

            if (!$wpdb->query($query)) {
                $error = true;
            }
        }
        if ($error) {
            $status = __('Error. Please try again.', 'pm4wp');
        } else {
            $status = _n('Message deleted.', 'Messages deleted.', count($id), 'pm4wp');
        }
    }
    // show all messages
    $msgs = $wpdb->get_results('SELECT `id`, `recipient`, `subject`,`content`,`content_doc`, `date` FROM ' . $wpdb->prefix . 'pm WHERE `sender` = "' . $current_user->user_login . '" AND `deleted` != 1 ORDER BY `date` DESC');
    ?>
<div class="msgcontainer">
    <h2><?php _e('Outbox', 'pm4wp'); ?></h2>
    <?php
    if (!empty($status)) {
        echo '<div id="message" class="updated fade"><p>', $status, '</p></div>';
    }
    if (empty($msgs)) {
        echo '<div class="message_outbox">', __('You have no items in outbox.', 'pm4wp'), '</div>';
    } else {
        $n = count($msgs);
        echo '<div class="message_outbox">', sprintf(_n('You requested %d CV/Quotes', 'You requested %d CV/Quotes', $n, 'pm4wp'), $n), '</div>';
        ?>
	
 <script>
function showhide(small,big){
    //alert(small+' '+big);
	$('#'+small).hide();
	$('#'+big).show();
	//$(".show_thisjob").show();
	}
	function hideshow(small,big){
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

        <form id="outbox_form" action="" method="get">
	    <input type="hidden" name="page_id" value="437"/>
	    	<input type="hidden" name="page" id="pagename1" value="rwpm_front_message_outbox" />
		<input type="hidden" name="action" value="delete"/>
            <?php //wp_nonce_field('rwpm-bulk-action_outbox'); ?>
	        <?php
	        $small_class_name=0;
	        $big_class_name=0;
		$button_view=0;
		$button_hide=0;
               foreach ($msgs as $msg) {
               $msg->recipient = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$msg->recipient'");
	       $small_class_name++;
	       $big_class_name++;
	       $button_view++;
	       $button_hide++;
	       $showbutton="view_link".$button_view;
	       $hidebutton="hide_link".$button_hide;
	       $final_s_class="show_small_div".$small_class_name;
	       $final_b_class="show_big_div".$big_class_name;
?>
<div class="msg" id="<?php echo $final_s_class; ?>">
    <div class="msgtitle check-column"><input id="checkinput1" class="checkboxmsg1" type="checkbox" name="id[]" value="<?php echo $msg->id; ?>"/>	       <span><?php echo $msg->recipient; ?></span>
    </div>
    <div class="msgdesc">
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=view&id=$msg->id", 'rwpm-delete_outbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
						<span class="asds"><?php
							if ( $msg->read )
							{
								$cont=stripcslashes( $msg->content );
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
						</div><!--close msgdesc-->
						<div class="msgtime"><?php $dtObj = new DateTime( $msg->date );
							echo $dtObj->format('h:i A').PHP_EOL;?>
						</div>
							
						<div class="read-more-job-btn">
						<span style=" margin-right: 15px;">
						<a href="javascript:void(0);" id="<?php echo $showbutton ?>" onclick="showhide('<?php echo $final_s_class; ?>','<?php echo $final_b_class;?>'); return false;">View</a>
						</span><span>
						<a href="javascript:void(0);" onclick="printDiv('<?php echo $final_b_class1;?>'); return false;">Print</a>
						</span><!--close read-more-job-btn-->
						</div>
						
					</div>
					<!--For big div-->
					 <div class="msg" id="<?php echo $final_b_class; ?>" style="display: none;" >
						<div class="msgtitle check-column"><input id="checkinput1" class="checkboxmsg1" type="checkbox" name="id[]" value="<?php echo $msg->id; ?>"/>						
						<span><?php echo $msg->recipient; ?></span></div>
						<div class="msgdesc">
							<?php
							if ( $msg->read )
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=view&id=$msg->id", 'rwpm-view_inbox_msg_' . $msg->id ), '">', stripcslashes( $msg->subject ), '</a>';
							}
							else
							{
								echo '<a href="', wp_nonce_url( "?page_id=437&page=rwpm_front_message_outbox&action=view&id=$msg->id", 'rwpm-delete_outbox_msg_' . $msg->id ), '"><b>', stripcslashes( $msg->subject ), '</b></a>';
							}
							?>
						<span><?php
							if ( $msg->read )
							{
								echo  stripcslashes( $msg->content );
								echo  stripcslashes( $msg->content_doc );
							}
							else
							{
								echo '<b>'. stripcslashes( $msg->content ).'</b>';
								echo '<b>'. stripcslashes( $msg->content_doc ).'</b>';
							}
							?></span>	
						</div>
						<div class="msgtime"><?php $dtObj = new DateTime( $msg->date );
							echo $dtObj->format('h:i A').PHP_EOL;?></div>
							    <div class="read-more-job-btn"><span style=" margin-right: 15px;"><a href="javascript:void(0);" id="<?php echo $hidebutton ?>" onclick="hideshow('<?php echo $final_s_class; ?>','<?php echo $final_b_class;?>'); return false;" >Hide</a></span>
							    <span><a href="javascript:void(0);" onclick="printDiv('<?php echo $final_b_class1;?>'); return false;">Print</a></span>
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