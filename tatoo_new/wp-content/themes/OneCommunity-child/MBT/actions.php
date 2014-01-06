<?php

function mbt_assign_type($user_id) {

	if ( $user_id != null ) {
		$type = mbt_get_user_type($user_id);
		switch ($type) {
			case 'studio':
			update_user_meta($user_id, 'is_employer', 1);
			break;

			case 'artist':
			break;

			case -1:
			case 'guest':
			default:
			break;
		}
	}

}
add_action('bp_core_signup_user', 'mbt_assign_type', 10000);

function mbt_resume_nav() {
	global $bp, $wpdb, $current_user;

	get_currentuserinfo();

	$nav_item_name = apply_filters( 'bp_album_nav_item_name', __( 'Album', 'bp-album' ) );

	if ( mbt_get_user_type($bp->displayed_user->id) == 'artist' && $current_user->ID != $bp->displayed_user->id ) {
		$resume_id = $wpdb->get_var("SELECT id FROM wpjb_resume WHERE user_id = '{$bp->displayed_user->id}' LIMIT 1");
		mbt_bp_core_new_nav_item( array(
			'name' => 'Resume',
			'slug' => site_url('/resumes/view/' . $resume_id . '/'),
			'position' => 80,
			'show_for_displayed_user' => true
		) );
	}
	if ( mbt_get_user_type($bp->logged_user->id) == 'artist' && $current_user->ID == $bp->displayed_user->id ) {
		mbt_bp_core_new_nav_item( array(
			'name' => 'My Resume',
			'slug' => site_url('/resumes/my-resume'),
			'position' => 80,
			'show_for_displayed_user' => true
		) );
	}
}
add_action( 'bp_setup_nav', 'mbt_resume_nav' );


add_action( 'show_user_profile', 'mbt_artist_user_profile_fields' );
add_action( 'edit_user_profile', 'mbt_artist_user_profile_fields' );
add_action( 'edit_user_profile_update', 'mbt_artist_user_profile_fields_update');

function mbt_artist_user_profile_fields( $user ) { ?>
	<?php
	$user_id = $user->ID;
	if ( mbt_get_user_type($user_id) == 'artist' ) {
		$type = mbt_get_sub_user_type( $user_id );
		if ( $type == null ) {
			$type = 't_artist';
		}

		$other_options['artist_sub_type'] = 'New Type';
		$other_options['artist_sub_type2'] = 'New Type';
		$other_options = get_site_option('other_settings', $other_options);
		DEFINE( 'P_ARTIST', $other_options['artist_sub_type']);
		DEFINE( 'T_ARTIST', $other_options['artist_sub_type2']);

	?>
	<table class="form-table">
		<tbody>
			<tr>
				<th><label><?php _e('Artist Sub Type'); ?></label></th>
				<td>
					<input name="artist_sub_type" <?php checked( 'p_artist', $type ); ?> value="p_artist" type="radio" id="artist_sub_type_1" /> <label for= "artist_sub_type_1"><?php echo P_ARTIST; ?></label>
					&nbsp;&nbsp;&nbsp;
					<input name="artist_sub_type" <?php checked( 't_artist', $type ); ?> value="t_artist" type="radio" id="artist_sub_type_2" /> <label for= "artist_sub_type_2"><?php echo T_ARTIST; ?></label>
				</td>
			</tr>
		</tbody>
	</table>

<?php 
	}
}


 
function mbt_artist_user_profile_fields_update( $user_id ) {
	if ( current_user_can('edit_user', $user_id ) )	{
		if ( mbt_get_user_type( $user_id )  == 'artist' ) {
			update_usermeta( $user_id, 'sub_type', $_POST['artist_sub_type'] );
		}
	}
}


function mbt_search_fix($args) {
	if ( is_search() ) {
		remove_action( 'bp_template_redirect', 'bp_actions', 4 );
		remove_action( 'bp_template_redirect', 'bp_screens', 6 );
		remove_action( 'bp_template_redirect', 'bp_core_catch_no_access', 1 );
	}
}
add_action( 'template_redirect', 'mbt_search_fix', 1 );


function mbt_like_notification_callback() {
	global $bp;

	$bp->ac_notifier->notification_callback = 'mbt_ac_notifier_format_notifications';

}
add_action( 'ac_notifier_setup_globals', 'mbt_like_notification_callback' );


function mbt_ac_notifier_format_notifications( $action, $activity_id, $secondary_item_id, $total_items, $format='string' ) {
   
	global $bp;
	$glue='';
	$user_names = array();

	$activity = new BP_Activity_Activity( $activity_id );
	$link = ac_notifier_activity_get_permalink( $activity_id );

	//if it is the original poster, say your, else say %s's post
	if($activity->user_id == $bp->loggedin_user->id){
		$text = __("your");
		$also = "";
	} else {
		$text = sprintf(__("%s's"),  bp_core_get_user_displayname ($activity->user_id)); //somone's
		$also = " also";
	}
	$ac_action = 'new_activity_comment_'.$activity_id;
	$ac_action_like = 'activity_liked_'.$activity_id;

	switch ( $action ) {
		case $ac_action : 
			//if ( (int)$total_items > 1 ) {
			$users = ac_notifier_find_involved_persons($activity_id);
			$total_user = $count = count( $users );		//how many unique users have commented
			if( $count > 2 ){
				$users 	= array_slice( $users, $count - 2 );		//just show name of two poster, rest should be as and 'n' other also commeted
				$count 	= $count - 2;
				$glue 	= ", ";
			} else if ( $total_user == 2 )
				$glue 	= " and ";		//if there are 2 unique users , say x and y commented

			foreach( (array)$users as $user_id )
				$user_names[] = bp_core_get_user_displayname ($user_id);

			if(!empty($user_names))
				$commenting_users = join ($glue, $user_names);


			if($total_user>2)
				$text = $commenting_users." and ".$count." others".$also." commented on ".$text. " post";//can we change post to some meaningfull thing depending on the activity item ?
			else
				$text = $commenting_users.$also ." commented on ".$text. " post";

			if( $format == 'string' )
				return apply_filters( 'bp_activity_multiple_new_comment_notification', '<a href="' . $link. '">' . $text . '</a>');
			else {
				return array( 'link' => $link, 'text' => $text );
			}
		break;
		

		case $ac_action_like:
			/* Activity Liked Notification Format */
			$users = ac_notifier_find_involved_persons($activity_id);


			$total_user = $count = count( $users );		//how many unique users have commented
			if( $count > 2 ){
				$users 	= array_slice( $users, $count - 2 );		//just show name of two poster, rest should be as and 'n' other also commeted
				$count 	= $count - 2;
				$glue 	= ", ";
			} else if ( $total_user == 2 )
				$glue 	= " and ";		//if there are 2 unique users , say x and y commented

			foreach( (array)$users as $user_id )
				$user_names[] = bp_core_get_user_displayname ($user_id);

			if(!empty($user_names))
				$liking_users = join($glue, $user_names);


			if( $total_user > 2 ) {
				$other = ( $total_user > 3 ) ? 'others' : 'other';
				$text = $liking_users." and ".$count." " . $other . " liked your post";//can we change post to some meaningfull thing depending on the activity item ?
			} else {
				$text = $liking_users. " liked your post";
				
			}
			if($total_user) {
				if( $format == 'string' )
					return apply_filters( 'bp_activity_multiple_new_comment_notification', '<a href="' . $link. '">' . $text . '</a>');
				else {
					return array( 'link' => $link, 'text' => $text );
				}
			}
		break;
	}

	return false;
}


function mbt_ac_notifier_remove_notification( $activity, $has_access ) {
	global $bp;
	if($has_access)//if user can view this activity, remove notification(just a safeguard for hidden activity)
		bp_core_delete_notifications_by_item_id( $bp->loggedin_user->id, $activity->id, $bp->ac_notifier->id,  'activity_liked_'.$activity->id);

}
add_action("bp_activity_screen_single_activity_permalink", "mbt_ac_notifier_remove_notification", 10, 2);


/*
	-- RTMedia actions 
*/

function mbt_assign_category_rtmedia( $row_ids, $file_object, $uploaded ) {
	global $wpdb;

	/* Get selected categories from RTMedia Upload */
	$terms 		= $_POST['assign_category_values'];
	$categories = array();
	$categories = array_map('intval',explode(',', $terms)); 

	if ( count($categories) > 0 ) {
		if ( count($row_ids) ) {
			foreach ($row_ids as $row_id) {
				/* For each uploaded image, assign categories */
				$result = $wpdb->get_col("SELECT `media_id` FROM `{$wpdb->prefix}rt_rtm_media` WHERE id = {$row_id}");
				$media_id = $result[0];
				wp_set_object_terms( $media_id, $categories, MBT_MEDIA_TAXONOMY, false);
			}
		}
	}
}
add_action('rtmedia_after_add_media', 'mbt_assign_category_rtmedia', 10, 3);


function mbt_add_assign_category_field_rtmedia() {
	echo '<input type="hidden" id="assign_category_values" name="assign_category_values" value="" />';
}
add_action('rtmedia_after_uploader', 'mbt_add_assign_category_field_rtmedia' );


function mbt_add_edit_categories_rtmedia( $type ) {
    global $rtmedia_query;
    $media_terms = null;
	if ( $rtmedia_query->media[ 0 ]->media_type == 'photo' ) {
		/* Get Image details */
		$media_id 		= $rtmedia_query->media[ 0 ]->media_id;
		$id 			= $rtmedia_query->media[ 0 ]->id;
		$media_terms 	= wp_get_object_terms( $media_id, MBT_MEDIA_TAXONOMY, array('fields' => 'ids') );
	}
	$media_categories = get_terms( MBT_MEDIA_TAXONOMY, array('hide_empty' => 0 ) );
	if ( count($media_categories) ) {
		/* If any Media categories in system exist */
		foreach ( $media_categories as $category ) { 
			$checked = '';
			if ( in_array($category->term_id, $media_terms) === true ) {
				$checked = 'checked="checked"';
			}
			$option .= '<label><input type="checkbox" ' . $checked . ' name="assign_categories[]" value="' . $category->term_id . '">' . $category->name . '</label>';
		}
		$category = null;
		if ( count($media_categories) > 0 ) {
			$category = '<div class="rtmedia_edit_categories"><h3>Categories</h3>' .$option . '</div>';
		}
		echo $category;
	}
}
add_action('rtmedia_add_edit_fields', 'mbt_add_edit_categories_rtmedia', 1000);


function mbt_after_edit_save_categories_rtmedia( $row_id, $state = 0 ) {
	global $wpdb;
	if ( $state != 0 ) {
		$categories = $_REQUEST['assign_categories'];
		
		if ($categories) {
			$categories = array_map('intval',$categories);
		}
		
		if ( isset($row_id) ) {				
			/* For each uploaded image, assign categories */
			$result = $wpdb->get_col("SELECT `media_id` FROM `{$wpdb->prefix}rt_rtm_media` WHERE id = {$row_id}");
			$media_id = $result[0];
			wp_set_object_terms( $media_id, $categories, MBT_MEDIA_TAXONOMY, false);
		}
	}
	return;
}
add_action('rtmedia_after_update_media', 'mbt_after_edit_save_categories_rtmedia', 10, 2 );
