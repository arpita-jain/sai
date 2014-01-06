<?php
	/* One time sync functions */
	//mbt_fix_category_ids();
	//mbt_assign_default_subtype_artists();
	//mbt_remove_unused_notifications();
	//mbt_regenerate_activity_images();


	global $bp;

	if ( !is_user_logged_in() )
		return false;

	//mbt_remove_unused_notifications();
	$notifications = bp_core_get_notifications_for_user( $bp->loggedin_user->id, 'object' );
	// print_rr($notifications);

	$to_show_notifications = array();
	if ( count( $notifications ) > 0 && !empty($notifications) ) {
		foreach ( $notifications as $notification ) {
			print_rr($notification);
			$parts = explode('/', $notification->href);
			/* skip messages notifications */
			if ( $parts[count($parts) - 2] == 'inbox' ) { continue; }
			//if ( !empty($notification->content) ) {
				$to_show_notifications[] = $notification;
			//}
		}
	}

	if ( $count_only == true ) {
		return count($to_show_notifications);
	}

	if ( count($to_show_notifications) > 0 ) {
		$counter = 0;
		foreach ( $to_show_notifications as $notification ) {
			$alt = ( 1 == $counter % 2 ) ? ' class="alt"' : '';
			echo '<li' . $alt . '><a href="' . $notification->href . '">' . $notification->content . '</a></li>';

			$counter++;
		}
	} else {
		echo '<li>' . __( 'You have no new notification.', 'buddypress' ) . '</li>';
	}