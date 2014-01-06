<?php
	global $my_links;

	mbt_activity_to_news();
	mbt_load_links_bp();
	mbt_media_to_portfolio();
	mbt_fix_artist_resume_bug();
	mbt_jobs_to_application();
	
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ) ?>; charset=<?php bloginfo( 'charset' ) ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="shortcut icon" href="<?php echo of_get_option('favicon_path', 'http://www.demo1.diaboliquedesign.com/4/favicon.gif' ); ?>" />
		<?php do_action( 'bp_head' ) ?>

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css" />

		<?php
			if ( is_singular() && bp_is_blog_page() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );

			wp_head();
		?>

<!--[if IE 9]>
<style type="text/css">
nav ul ul { top:26px; }
</style>
<![endif]-->

<script>
  document.createElement('header');
  document.createElement('section');
  document.createElement('article');
  document.createElement('aside');
  document.createElement('nav');
  document.createElement('footer');
</script>
<script>
jQuery.fn.preload = function() {
	this.each(function(){
		jQuery('<img/>')[0].src = this;
	});
}

// Usage:
var stylesheet_directory_uri = '<?php echo get_stylesheet_directory_uri(); ?>';
var MBT_images = stylesheet_directory_uri + '/MBT/images/';
jQuery([ MBT_images + 'notification-hover.png', MBT_images + 'settings-icon-hover.png', MBT_images + 'message-hover.png']).preload();
</script>

<?php echo of_get_option('analytics', ' ' ); ?>

	</head>

	<body <?php body_class() ?> id="bp-default">

	<div class="mbt_bar">
		<div id="container">
			<section class="links fleft">
				<div class="logo fleft"><a href="<?php echo home_url(); ?>" title="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>"><img src="<?php echo of_get_option('logo_path', 'http://www.demo1.diaboliquedesign.com/4/logo.png' ); ?>" alt="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>" /><img src="<?php echo get_stylesheet_directory_uri(); ?>/MBT/images/beta.png" class="beta_tag" alt="" /></a></div>
				<div class="adminbar_links fleft">
					<a href="/tatoo/jobs/">Job Zone</a>
					<a href="/tatoo/members/">Members</a>
					<a href="/tatoo/explore/">Explore</a>
				</div>
			</section>
			<section class="searchbar fleft">
				<form action="/" method="get">
					<input type="text" name="s" placeholder="Search Request" value="<?php echo $_GET['s']; ?>" /> 
				</form>
			</section>
			<?php if ( is_user_logged_in() ) : ?>
			<section class="user_btns fleft">
				<?php 
				$user_type = mbt_get_user_type();
				if ( $user_type == 'studio' ) : ?>
					<a href="/jobs/add">Post a job</a>
				<?php elseif ( $user_type == 'artist' ) : ?>
					<a href="/resumes/my-resume">My Resume</a>
				<?php endif; ?>
			</section>
			<section class="settings fright" style="position:relative;">
				<?php
					$notification_count = mbt_bp_adminbar_notifications( true );
					$messages_count = mbt_get_message_count();
				?>
				<?php mbt_get_user_avatar(48, 48); ?>
				<a href="<?php echo $my_links['messages']; ?>" class="action_btn"><i class="messages_icon"></i></a>
				<?php if ($messages_count > 0) : ?>
					<span class="count <?php if ($messages_count > 0) { echo 'active'; } ?>"><?php echo $messages_count; ?></span>
				<?php endif; ?>
				<span class="divider"></span>
				<a href="javascript:void(null)" class="action_btn notification_btn"><i class="notification_icon"></i></a>
				<?php if ($notification_count > 0) : ?>
					<span class="count <?php if ($notification_count > 0) { echo 'active'; } ?>"><a href="<?php echo $my_links['messages']; ?>"><?php echo $notification_count; ?></a></span>
				<?php endif; ?>
				<span class="divider"></span>
				<a class="setting_btn action_btn" href="javascript:void(null)"><i class="settings_icon"></i></a>
			</section>
			<div id="mbt_notification_box" class="mbt_bar_box">
				<div id="arrow"></div>
				<ol class="mbt_bar_menu">
					<?php mbt_bp_adminbar_notifications()?>
				</ol>
			</div>
			<div id="mbt_settings_box" class="mbt_bar_box">
				<div id="arrow"></div>
				<ol class="mbt_bar_menu">
					<li><a href="<?php echo $my_links['news']; ?>">My Activity</a></li>
					<li><a href="<?php echo $my_links['profile']; ?>">My Profile</a></li>
					<li><a href="<?php echo $my_links['settings']; ?>">My Settings</a></li>
					<li><hr /></li>
					<li><a href="<?php echo wp_logout_url(); ?>">Logout</a></li>
				</ol>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<script>
		jQuery(document).ready(function() {
			fix_dropdown_menu();	
		});

		jQuery(window).resize( function() {
			fix_dropdown_menu()	
		});

		function fix_dropdown_menu() {
			var scrollTop					= jQuery(window).scrollTop(),
			    elementOffset_setting		= jQuery('.setting_btn').offset().top,
			    elementOffset_notification	= jQuery('.notification_btn').offset().top,
			    top_distance_setting		= (elementOffset_setting - scrollTop),
			    top_distance_notification	= (elementOffset_notification - scrollTop);

			var setting_btn_right 		= jQuery(window).width() - (jQuery('.setting_btn').offset().left + jQuery('.setting_btn').width());
			var notification_btn_right 	= jQuery(window).width() - (jQuery('.notification_btn').offset().left + jQuery('.notification_btn').width());
			jQuery('#mbt_settings_box').css('right', (setting_btn_right - 3) + 'px');
			jQuery('#mbt_settings_box').css('top', (top_distance_setting + 45) + 'px');

			jQuery('#mbt_notification_box').css('right', (notification_btn_right - 5) + 'px');
			jQuery('#mbt_notification_box').css('top', (top_distance_notification + 47) + 'px');
		}
	</script>
	


	<?php do_action( 'bp_before_header' ) ?>
	<?php
	/*
	<div id="header-very-top">
	<nav>
				
			<?php 
			wp_nav_menu( array(
			 'theme_location' => 'primary-menu',
			 'container' =>false,
			 'menu_class' => 'nav',
			 'echo' => true,
			 'before' => '',
			 'after' => '',
			 'link_before' => '',
			 'link_after' => '',
			 'depth' => 0,)
			);
			 ?>
	</nav>



	<div id="navigation-320">
	<form name="site-menu" action="" method="post">
		<?php 	
		wp_nav_menu_select(
    		array(
       			'theme_location' => 'select-menu'
    			)
		);
		?>
	</form>
	</div>


	<div id="top-bar-right">
	 	<?php get_search_form(); ?> 
        	</div><!--top-bar-right ends-->

	</div><!-- #header-very-top -->	
	*/
	?>

<div class="clear"></div>

<div id="main">

<header style="display:none;">

	<div id="header-left">
		<div id="logo"><a href="<?php echo home_url(); ?>" title="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>"><img src="<?php echo of_get_option('logo_path', 'http://www.demo1.diaboliquedesign.com/4/logo.png' ); ?>" alt="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>" /></a></div>
	</div><!-- #header-left -->

<div id="header-right">
	<div id="header-right-1">
		<a class="tile tile-forum" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-24a', 'forums' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-forum.png" alt="<?php echo of_get_option('t-24', 'FORUM' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-24', 'FORUM' ); ?></span></a>
		<a class="tile tile-groups" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-23a', 'groups' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-groups.png" alt="<?php echo of_get_option('t-23', 'GROUPS' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-23', 'GROUPS' ); ?></span></a>
		<a class="tile tile-help" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-28a', 'about-us' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-info.png" alt="<?php echo of_get_option('t-28', 'ABOUT US' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-28', 'ABOUT US' ); ?></span></a>
		<a class="tile tile-activities" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-27a', 'activity' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-activities.png" alt="<?php echo of_get_option('t-27', 'ACTIVITY' ); ?>" /><span class="tile-title">NEWS</span></a>
	</div><!-- #header-right-1 -->

<div id="header-right-2">
<div class="tile2">	<?php if ( is_user_logged_in() ) : ?>
			<div id="tile-user">
				<div class="tile-avatar"><a href="<?php echo bp_loggedin_user_domain() ?>"><?php bp_loggedin_user_avatar( 'type=full&width=88&height=88' ) ?></a></div>

				<div class="tile-username"><?php echo of_get_option('t-7', 'Hello' ); ?><br /><?php echo bp_core_get_userlink( bp_loggedin_user_id() ); ?></div>
				<div class="tile-logout"><a href="<?php echo wp_logout_url( bp_get_root_domain() ) ?>"><?php _e( 'Log Out', 'buddypress' ) ?></a></div>
				<a class="tile-messages" href="<?php echo bp_loggedin_user_domain() ?>messages"><?php echo messages_get_unread_count(); ?></a>
			</div>
		
		<?php else : ?>

			<div id="tile-user">
				<div class="tile-avatar"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/avatar.gif" alt="Avatar" width="88" height="88" /></div>
				<div class="tile-username"><?php echo of_get_option('t-7', 'Hello' ); ?><br /><?php echo of_get_option('t-22', 'Guest' ); ?></div>
				<span class="tile-title"><a href="<?php echo home_url(); ?>/login"><?php _e( 'Log In', 'buddypress' ); ?></a> <?php if ( bp_get_signup_allowed() ) : ?><span class="tile-register"><?php echo of_get_option('t-6', 'or' ); ?>&nbsp;<a href="<?php echo home_url(); ?>/signup"><?php echo of_get_option('t-36', 'Sign Up' ); ?></a></span><?php endif; ?></span>
			</div> 

	<?php endif; ?>
</div><!-- .tile2 -->

	<div class="header-right-2-bottom">
		<a class="tile tile-users" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-26a', 'members' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-members.png" alt="<?php echo of_get_option('t-26', 'MEMBERS' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-26', 'MEMBERS' ); ?></span></a>
		<a class="tile tile-blog" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-25a', 'blog' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-blog.png" alt="<?php echo of_get_option('t-25', 'BLOG' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-25', 'BLOG' ); ?></span></a>
		
	</div><!-- .header-right-2-bottom -->
</div><!-- .header-right-2 -->
</div><!-- #header-right -->


<?php do_action( 'bp_header' ) ?>
</header>

<?php
	// Check to see if the header image has been removed
	$header_image = get_header_image();
	if ( $header_image ) :
		// Compatibility with versions of WordPress prior to 3.4.
		if ( function_exists( 'get_custom_header' ) ) {
			// We need to figure out what the minimum width should be for our featured image.
			// This result would be the suggested width if the theme were to implement flexible widths.
			$header_image_width = get_theme_support( 'custom-header', 'width' );
		} else {
			$header_image_width = HEADER_IMAGE_WIDTH;
		}

		// Compatibility with versions of WordPress prior to 3.4.
		if ( function_exists( 'get_custom_header' ) ) {
			$header_image_width  = get_custom_header()->width;
			$header_image_height = get_custom_header()->height;
		} else {
			$header_image_width  = HEADER_IMAGE_WIDTH;
			$header_image_height = HEADER_IMAGE_HEIGHT;
		}
	?>
		<div style="margin-bottom: 5px;"><img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" /></div>
	<?php endif; ?>

<div id="container">