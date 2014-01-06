<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ) ?>; charset=<?php bloginfo( 'charset' ) ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="shortcut icon" href="<?php echo of_get_option('favicon_path', 'http://www.demo1.diaboliquedesign.com/4/favicon.gif' ); ?>" />
		<?php do_action( 'bp_head' ) ?>

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

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

<?php echo of_get_option('analytics', ' ' ); ?>

	</head>

	<body <?php body_class() ?> id="bp-default">

	<?php do_action( 'bp_before_header' ) ?>
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

<div class="clear"></div>

<div id="main">

<header>

	<div id="header-left">
		<div id="logo"><a href="<?php echo home_url(); ?>" title="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>"><img src="<?php echo of_get_option('logo_path', 'http://www.demo1.diaboliquedesign.com/4/logo.png' ); ?>" alt="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>" /></a></div>
	</div><!-- #header-left -->

<div id="header-right">
	<div id="header-right-1">
		<a class="tile tile-forum" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-24a', 'forum' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-forum.png" alt="<?php echo of_get_option('t-24', 'FORUM' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-24', 'FORUM' ); ?></span></a>
		<a class="tile tile-groups" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-23a', 'groups' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-groups.png" alt="<?php echo of_get_option('t-23', 'GROUPS' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-23', 'GROUPS' ); ?></span></a>
		<a class="tile tile-help" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-28a', 'about-us' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-info.png" alt="<?php echo of_get_option('t-28', 'ABOUT US' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-28', 'ABOUT US' ); ?></span></a>
		<a class="tile tile-activities" href="<?php echo home_url(); ?>/<?php echo of_get_option('t-27a', 'activity' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-activities.png" alt="<?php echo of_get_option('t-27', 'ACTIVITY' ); ?>" /><span class="tile-title"><?php echo of_get_option('t-27', 'ACTIVITY' ); ?></span></a>
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
				<span class="tile-title"><a href="<?php echo home_url(); ?>/login"><?php _e( 'Log In', 'buddypress' ); ?></a> <?php if ( bp_get_signup_allowed() ) : ?><span class="tile-register"><?php echo of_get_option('t-6', 'or' ); ?>&nbsp;<a href="<?php echo home_url(); ?>/register"><?php echo of_get_option('t-36', 'Sign Up' ); ?></a></span><?php endif; ?></span>
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

<div id="container">