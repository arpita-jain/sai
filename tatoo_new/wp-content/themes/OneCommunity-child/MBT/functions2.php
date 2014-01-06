<?php

function mbt_get_user_type( $user_id = null ) {
	global $current_user, $wpdb;

	get_currentuserinfo();

	if ( is_user_logged_in() && $user_id == null ) {
		$user_id = $current_user->ID;
	}

	$result = $wpdb->get_results( "SELECT XD.value FROM {$wpdb->base_prefix}bp_xprofile_data AS XD JOIN {$wpdb->base_prefix}bp_xprofile_fields AS XF ON XF.id = XD.field_id WHERE XF.type = 'selectbox' AND XF.name = 'User Type' AND user_id = '{$user_id}'" );

	if ( count($result) > 0 ) {
		return strtolower($result[0]->value);
	}
	
	/* if no type found return -1 */
	return -1;
}


function mbt_get_message_count() {
	if( bp_is_active( 'messages' ) ) {
		return messages_get_unread_count();
	}
}


function mbt_get_user_avatar($width = 88, $height = 88) {
	if ( bp_is_active( 'xprofile' ) ) {
		?>
		<a href="<?php echo bp_loggedin_user_domain(); ?>"><?php bp_loggedin_user_avatar( 'type=full&width=' . $width . '&height=' . $height ); ?></a>
		<?php
	}
}

function mbt_get_url_segments() {
	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
	return $segments;
}

function mbt_jobs_to_application() {
	
	$segments = mbt_get_url_segments();
	if ( is_array($segments) ) {
		if ( $segments[2] == 'employer' && ($segments[3] == 'panel' || $segments[3] == 'panel-expired' ) )  {
			add_filter( 'the_title', 'mbt_jobs_to_application_filter' );
		}
	}
}

function mbt_jobs_to_application_filter($title) {
	return 'Applications';
}


function mbt_get_current_page_url() {
	$path	= $_SERVER['REQUEST_URI'];
	$URI	= site_url( $path );
	return $URI;
}


function mbt_get_current_page_uri() {
	return $_SERVER['REQUEST_URI'];
}


function mbt_is_login_page() {
	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function mbt_is_activate_page() {
	if ( preg_match( "/activate(.*)/", mbt_get_current_page_uri() ) )  { return true; }
	return in_array($GLOBALS['pagenow'], array('wp-activate.php', 'activate'));
}

function mbt_is_signup_page() {
	if ( str_replace('/', '', mbt_get_current_page_uri()) == 'signup' ) { return true; }
	return in_array($GLOBALS['pagenow'], array('wp-signup.php', 'signup'));
}

function mbt_is_ajax_request() {
	if ( mbt_get_current_page_uri() == 'wp-admin/admin-ajax.php' ) { return true; }
	return in_array($GLOBALS['pagenow'], array('admin-ajax.php'));
}

function mbt_get_page_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

function mbt_load_links_bp() {
	global $bp, $my_links;
	
	if ( count( $bp->bp_nav ) > 0 ) {
		foreach ($bp->bp_nav as $nav) {
			$my_links[$nav['slug']] = $nav['link'];
		}
	}
}

function mbt_activity_to_news() {
	global $bp;
	
	if ( count( $bp->bp_nav ) > 0 ) {
		foreach ($bp->bp_nav as &$nav) {
			if ( $nav['screen_function'] == 'bp_activity_screen_my_activity' ) {
				$nav['name'] = 'News';
				break;
			}
		}
	}
}

function mbt_media_to_portfolio() {
	global $bp;

	if ( count( $bp->bp_nav ) > 0 ) {
		foreach ($bp->bp_nav as &$nav) {
			if ( $nav['slug'] == 'media' ) {
				$displayed_type = mbt_get_user_type($bp->displayed_user->id);
				$logged_type 	= mbt_get_user_type($bp->loggedin_user->id);
				if ( $displayed_type == 'studio' || $displayed_type == 'artist' ) {
					$nav['name'] = str_replace('Media', 'Portfolio ', $nav['name']);
				} else {
					$nav['name'] = str_replace('Media', 'Photos ', $nav['name']);
				}
				break;
			}
		}
	}
}

function mbt_regenerate_activity_images() {
	$upload_dir 	= wp_upload_dir();
	$uploads_bpfp 	= $upload_dir['basedir'] . '/bpfb';
	$uploads_url 	= $upload_dir['baseurl'] . '/bpfb';
	$dir = scandir( $uploads_bpfp );	
	$img_extensions = array('jpg', 'png', 'gif', 'jpeg', 'bmp', 'tiff', 'bmp');
	foreach ($dir as $item) {
		$parts = explode('.', $item);
		$extension = $parts[count($parts) - 1];
		if ( in_array($extension, $img_extensions) ) {
			$image_path		= $uploads_bpfp . '/' . $item;
			$image_size 	= getimagesize( $image_path );
			$image_width 	= $image_size[0];
			$image_height 	= $image_size[1];
			if ( $image_width > MBT_MAX_IMAGE_WIDTH || $image_height > MBT_MAX_IMAGE_HEIGHT ) {
				/* Regenerate Full image */
				//echo $item . '<br />';
				$full_image = $uploads_url . '/' . trim($item);
				if (function_exists('wp_get_image_editor')) { // New way of resizing the image
					$image = wp_get_image_editor( $image_path );
					if (!is_wp_error($image)) {
						$thumb_filename  = $image->generate_filename('full');
						$image->resize(MBT_MAX_IMAGE_WIDTH, MBT_MAX_IMAGE_HEIGHT, false);
						$image->save($thumb_filename);
					}
				}
			}
		}
	}
	echo 'Regenerating Images... <br /><br />';
	echo ('Images regenerated!');
}

function mbt_fix_artist_resume_bug() {
	global $bp, $wpdb;
	if (!$bp->displayed_user->id) return;
	$displayed_type = mbt_get_user_type($bp->displayed_user->id);
	$logged_type 	= mbt_get_user_type($bp->loggedin_user->id);
	if ( $displayed_type == 'artist' ) {
		$displayed_user_id = $bp->displayed_user->id;
		$result = $wpdb->get_results( "SELECT id FROM wpjb_resume WHERE user_id = {$displayed_user_id}" );
		if ( count( $result ) < 1 ) {
			/* Resume not exists, create a blank entry */
			if ( $displayed_user_id != 0 ) {
				$wpdb->insert( 'wpjb_resume', array('user_id' => $displayed_user_id, 'category_id' => serialize(array()) ) );
			}
		}
	}
	if (!$bp->loggedin_user->id) return;
	/* Fixing for logged in user too */
	if ( $logged_type == 'artist' ) {
		$logged_user_id = $bp->loggedin_user->id;
		$result = $wpdb->get_results( "SELECT id FROM wpjb_resume WHERE user_id = {$logged_user_id}" );
		if ( count( $result ) < 1 ) {
			/* Resume not exists, create a blank entry */
			if ( $logged_user_id != 0 ) {
				$wpdb->insert( 'wpjb_resume', array('user_id' => $logged_user_id, 'category_id' => serialize(array()) ) );
			}
		}
	}
}

function mbt_fix_category_ids() {
	global $wpdb;
	/* Fixes the seralization problem for wpdb_resume and wpjb_job to make it compatible with multiple categories */
	$results = $wpdb->get_results("SELECT id, category_id FROM wpjb_resume");
	foreach ( (array)$results as $row) {
		$category_id = $row->category_id;
		if ( !is_serialized( $category_id ) ) {
			if ( $category_id == null ) {
				$serialized = maybe_serialize( array() );
			} else {
				$serialized = maybe_serialize( array($category_id => $category_id) );
			}
			$wpdb->update('wpjb_resume', array('category_id' => $serialized), array( 'id' => $row->id ));
		}
	}

	$results = $wpdb->get_results("SELECT id, job_category FROM wpjb_job");
	foreach ( (array)$results as $row) {
		$job_category = $row->job_category;
		if ( !is_serialized( $job_category ) ) {
			if ( $job_category == null ) {
				$serialized = maybe_serialize( array() );
			} else {
				$serialized = maybe_serialize( array($job_category => $job_category) );
			}
			$wpdb->update('wpjb_job', array('job_category' => $serialized), array( 'id' => $row->id ));
		}
	}
}

function mbt_assign_default_subtype_artists() {
	/* Assigns artists with a default sub type if not assigned already */
	$all_users = get_users();
	foreach ((array)$all_users as $user) {
		if ( mbt_get_user_type($user->ID) == 'artist' ) {
			if ( get_user_meta( $user->ID, 'sub_type', true ) == null ) {
				update_usermeta( $user->ID, 'sub_type', 't_artist' );
			}
		}
	}
}

function mbt_is_user_online($user_id, $time=5){
	global $wp, $wpdb;
	/* time is in minutes */
	$user_login = $wpdb->get_var( "
		SELECT u.user_login FROM $wpdb->users u JOIN $wpdb->usermeta um ON um.user_id = u.ID 
		WHERE  u.ID = $user_id 
		AND um.meta_key = 'last_activity'
		AND DATE_ADD( um.meta_value, INTERVAL $time MINUTE ) >= UTC_TIMESTAMP()"
		);
	if(isset($user_login) && $user_login !=""){
		return true;
	}
	else {return false;}
}

function mbt_get_sub_user_type( $user_id = null ) {
	global $current_user, $wpdb;

	get_currentuserinfo();

	if ( is_user_logged_in() && $user_id == null ) {
		$user_id = $current_user->ID;
	}

	$result = get_user_meta( $user_id, 'sub_type', true );
	
	return $result;
}

function mbt_show_sub_user_type ( $user_id = null, $just_value = false ) {
	$type = mbt_get_sub_user_type( $user_id );
	if ( $type == 'p_artist' || $type == 't_artist' ) {
		$other_settings['artist_sub_type'] 	= 'New Type';
		$other_settings['artist_sub_type2'] = 'New Type';
		$other_settings		= get_site_option('other_settings', $other_settings);
		if ( $type == 'p_artist') {
			$value 	= $other_settings['artist_sub_type'];
		} else {
			$value 	= $other_settings['artist_sub_type2'];
		}
		if ( $just_value ) {
			return $value;
		}
		return '<span class="artist_sub_type">(' . $value . ')</span>';
	}
}

function mbt_profile_groups_exclude_from_tab(){
	global $bp, $profile_template;
	$settings_profile_data = get_option('buatp_profile_data_setting',false);
	if(!$settings_profile_data)
		return false;
	$user_id = $bp->displayed_user->id;
	/* Commented for Admin group */
	/*if(current_user_can('create_users'))
		return;*/
	$user_type = buatp_get_user_type($user_id);
	$excluded = $settings_profile_data['buatp_exclude_groups_for_'.$user_type];
	if(!$excluded)
		return;
	$groups = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
	foreach($groups as $key => $profile_group) {
		if( in_array($profile_group->id, (array)$excluded) ) {
			unset($groups[$key]);
		}
	}
	$groups = array_values($groups);
	wp_cache_set( 'xprofile_groups_inc_empty', $groups, 'bp' );
	return $groups;
}

function mbt_bp_adminbar_notifications( $count_only = false ) {
	global $bp;

	if ( !is_user_logged_in() )
		return false;

	//mbt_remove_unused_notifications();
	$notifications = bp_core_get_notifications_for_user( $bp->loggedin_user->id, 'object' );
	// print_rr($notifications);

	$to_show_notifications = array();
	if ( count( $notifications ) > 0 && !empty($notifications) ) {
		foreach ( $notifications as $notification ) {
			$parts = explode('/', $notification->href);
			/* skip messages notifications */
			if ( $parts[count($parts) - 2] == 'inbox' ) { continue; }
			if ( !empty($notification->content) ) {
				$to_show_notifications[] = $notification;
			}
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
}


function mbt_bp_core_new_nav_item( $args = '' ) {
	global $bp;

	$defaults = array(
		'name'                    => false, // Display name for the nav item
		'slug'                    => false, // URL slug for the nav item
		'item_css_id'             => false, // The CSS ID to apply to the HTML of the nav item
		'show_for_displayed_user' => true,  // When viewing another user does this nav item show up?
		'site_admin_only'         => false, // Can only site admins see this nav item?
		'position'                => 99,    // Index of where this nav item should be positioned
		'screen_function'         => false, // The name of the function to run when clicked
		'default_subnav_slug'     => false  // The slug of the default subnav item to select when clicked
		);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	// If we don't have the required info we need, don't create this subnav item
	if ( empty( $name ) || empty( $slug ) )
		return false;

	// If this is for site admins only and the user is not one, don't create the subnav item
	if ( !empty( $site_admin_only ) && !bp_current_user_can( 'bp_moderate' ) )
		return false;

	if ( empty( $item_css_id ) )
		$item_css_id = $slug;

	$bp->bp_nav[$slug] = array(
		'name'                    => $name,
		'slug'                    => $slug,
		'link'                    => $slug,
		'css_id'                  => $item_css_id,
		'show_for_displayed_user' => $show_for_displayed_user,
		'position'                => $position,
		'screen_function'         => &$screen_function,
		'default_subnav_slug'     => $default_subnav_slug
		);

	/**
	 * If this nav item is hidden for the displayed user, and
	 * the logged in user is not the displayed user
	 * looking at their own profile, don't create the nav item.
	 */
	if ( empty( $show_for_displayed_user ) && !bp_user_has_access() )
		return false;

	/**
	 * If the nav item is visible, we are not viewing a user, and this is a root
	 * component, don't attach the default subnav function so we can display a
	 * directory or something else.
	 */
	if ( ( -1 != $position ) && bp_is_root_component( $slug ) && !bp_displayed_user_id() )
		return;

	// Look for current component
	if ( bp_is_current_component( $slug ) || bp_is_current_item( $slug ) ) {

		// The requested URL has explicitly included the default subnav
		// (eg: http://example.com/members/membername/activity/just-me/)
		// The canonical version will not contain this subnav slug.
		if ( !empty( $default_subnav_slug ) && bp_is_current_action( $default_subnav_slug ) && !bp_action_variable( 0 ) ) {
			unset( $bp->canonical_stack['action'] );
		} elseif ( ! bp_current_action() ) {

			// Add our screen hook if screen function is callable
			if ( is_callable( $screen_function ) ) {
				add_action( 'bp_screens', $screen_function, 3 );
			}

			if ( !empty( $default_subnav_slug ) ) {
				$bp->current_action = apply_filters( 'bp_default_component_subnav', $default_subnav_slug, $r );
			}
		}
	}

	do_action( 'bp_core_new_nav_item', $r, $args, $defaults );
}

add_action( 'after_setup_theme', 'twentyeleven_setup' );

if ( ! function_exists( 'twentyeleven_setup' ) ):

function twentyeleven_setup() {

	// Add support for custom headers.
	$custom_header_support = array(
		// The default header text color.
		'default-text-color' => '000',
		// The height and width of our custom header.
		'width' => apply_filters( 'twentyeleven_header_image_width', 1240 ),
		'height' => apply_filters( 'twentyeleven_header_image_height', 200 ),
		// Support flexible heights.
		'flex-height' => false,
		// Random image rotation by default.
		'random-default' => true,
		// Callback for styling the header.
		'wp-head-callback' => 'twentyeleven_header_style',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'twentyeleven_admin_header_style',
		// Callback used to display the header preview in the admin.
		'admin-preview-callback' => 'twentyeleven_admin_header_image',
		'uploads' => true,
	);

	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
		add_custom_background();
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// Add Twenty Eleven's custom image sizes.
	// Used for large feature (header) images.
	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	// Used for featured posts if a large-feature doesn't exist.
	add_image_size( 'small-feature', 500, 300 );

}
endif; // twentyeleven_setup

if ( ! function_exists( 'twentyeleven_header_style' ) ) :

function twentyeleven_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( $text_color == HEADER_TEXTCOLOR )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $text_color ) :
	?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // twentyeleven_header_style

if ( ! function_exists( 'twentyeleven_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in twentyeleven_setup().
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
endif; // twentyeleven_admin_header_style

if ( ! function_exists( 'twentyeleven_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in twentyeleven_setup().
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_admin_header_image() { ?>
	<div id="headimg">
		<?php
		$color = get_header_textcolor();
		$image = get_header_image();
		if ( $color && $color != 'blank' )
			$style = ' style="color:#' . $color . '"';
		else
			$style = ' style="display:none"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // twentyeleven_admin_header_image

function change_category_arg() {
    global $wp_taxonomies;
    if ( ! taxonomy_exists('category') )
        return false;

	$wp_taxonomies['category']->update_count_callback = '_update_generic_term_count';
}
add_action( 'init', 'change_category_arg' );


function mbt_remove_unused_notifications() {
	global  $wpdb;
	$result = $wpdb->get_results( "DELETE FROM {$wpdb->base_prefix}bp_notifications WHERE component_action='activity_liked'" );
}
