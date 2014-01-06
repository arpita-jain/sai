<?php

function change_album_to_portfolio($name) {
	return 'Portfolio';
}
add_filter( 'bp_album_nav_item_name', 'change_album_to_portfolio' );


function make_profile_links_target_blank( $value, $type, $id ) {
	return str_replace('rel="nofollow"', 'rel="nofollow" target="_blank"', $value);
	//echo $type;
	//echo $id;
}
add_filter( 'bp_get_the_profile_field_value', 'make_profile_links_target_blank', 10, 3 );

function remove_xprofile_links() {
	remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2 );
}
add_action( 'bp_init', 'remove_xprofile_links' );


function mbt_change_validation_email( $message, $user_id, $activate_url ) {
	$user_info = get_userdata( $user_id );
	$username = $user_info->user_login;
	$message = sprintf( __( "Thanks for registering! To complete the activation of your account please click the following link:\n\n%1\$s\n\nYour username is: %2\$s\n", 'buddypress' ), $activate_url, $username );
	return $message;
}
add_filter('bp_core_signup_send_validation_email_message', 'mbt_change_validation_email', 10, 3);	
 
function mbt_apply_shortcode_to_activity( $content ) {
	return do_shortcode($content);
}
add_filter('bp_get_activity_parent_content', 'mbt_apply_shortcode_to_activity');


function mbt_apply_user_type_icon( $img, $params, $item_id, $avatar_dir, $css_id, $html_width, $html_height, $avatar_folder_url, $avatar_folder_dir ) {
	$type = mbt_get_user_type( $item_id );
	$type = ($type != -1 ) ? $type : '';
	if ( $type == 'artist' ) {
		$type = mbt_show_sub_user_type( $item_id, true );
	} else if ( $type == 'guest' ) {
		$user_data = get_userdata( $item_id );
		if ( $user_data->user_login == 'administrator' ) {
			$type = 'admin';
		}
	}
	$new_image = '<div class="mbt_avatar">' . $img . '<div class="mbt_user_type ' . $type . '" title="'. ucfirst($type) . '">' . substr(ucfirst($type), 0, 1). '</div></div>';
	return $new_image;
}
add_filter( 'bp_core_fetch_avatar', 'mbt_apply_user_type_icon', 10, 9 );


function mbt_show_categories_rtmedia( $tabs ) {
	global $rtmedia_query;
        $album = '';
        if ( $rtmedia_query && is_rtmedia_album () ) {
            $album = '<input class="rtmedia-current-album" type="hidden" name="rtmedia-current-album" value="' . $rtmedia_query->media_query[ 'album_id' ] . '" />';
        } elseif ( is_rtmedia_album_enable () && $rtmedia_query && is_rtmedia_gallery () ) {

            if ( $rtmedia_query->query[ 'context' ] == 'profile' ) {
                $album = '<select name="album" class="rtmedia-user-album-list">' . rtmedia_user_album_list () . '</select>';
            }
            if ( $rtmedia_query->query[ 'context' ] == 'group' ) {
                $album = '<select name="album" class="rtmedia-user-album-list">' . rtmedia_group_album_list () . '</select>';
            }
        }
	$args = array(
		'hide_empty'	=> 0,
		'hierarchical'	=> 1
	);   
	$media_categories = get_terms( MBT_MEDIA_TAXONOMY, $args );
	foreach ( $media_categories as $category ) { 
		$option .= '<label><input type="checkbox" value="' . $category->term_id . '">' . $category->name . '</label>';
	}
	$category = null;
	if ( count($media_categories) > 0 ) {
		$category = '<h3> Choose Category</h3><div id="rtmedia-categories-list">' .$option . '</div>';
	}
	$tabs['file_upload']['default'] = array( 
		'title' 	=> __ ( 'File Upload', 'rtmedia' ), 
		'content' 	=> '<div id="rtmedia-upload-container" ><div id="drag-drop-area" class="drag-drop">' . $category .'<br />' . $album . '<input id="rtMedia-upload-button" value="' . __ ( "Upload", "rtmedia" ) . '" type="button" class="rtmedia-upload-input rtmedia-file" /></div><table id="rtMedia-queue-list"><tbody></tbody></table></div>' 
	);
	return $tabs;
}
add_filter( 'rtmedia_upload_tabs', 'mbt_show_categories_rtmedia' );


function mbt_attach_media_categories() {
	return MBT_MEDIA_TAXONOMY;
}
add_filter( 'mc_taxonomy', 'mbt_attach_media_categories' );