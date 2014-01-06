<?php
	$signup_settings = get_site_option('signup_page_setting');
	global $mbt_plugin_url;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
	<title><?php bloginfo('name'); ?> &rsaquo; Sign up</title>
	<?php wp_head(); ?>
	<link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo $mbt_plugin_url; ?>/css/login-style.css" type="text/css" media="all" />
</head>
<body class="mysignup">
<style>
	<?php
		$background = $signup_settings['background'];
		if ( !empty($background) ) {
		?>
		html {
			height: 100%;
		}

		body {
			position: relative;
			background: url("<?php echo $background; ?>") no-repeat;
			background-size: cover;
			background-position: 50% 50%;
		}

		body:before {
			content: '';
			position: fixed;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			background: rgba(0,0,0,0.2) url('<?php echo $mbt_plugin_url; ?>/images/full_page_vignette.png');
			background-size: 100% 100%;
			opacity: .5;
			z-index: 0;
		}
	<?php
	}	
	?>
	div.success_message { 
		background: none repeat scroll 0 0 #555555;
    	border: 1px solid #ACACAC;
    	border-radius: 8px 8px 8px 8px;
    	box-shadow: 0 0px 2px 1px #CCCCCC inset;
    	color: #FFFFFF;
    	padding: 15px;
		margin-top:60px;
		display:none;
	}
</style>
<div class="signup_top_links">
	<a href="#TB_inline?width=400&height=410&inlineId=about" class="no-underline no-bold thickbox" title="About">About</a><span>|</span>
	<a href="#TB_inline?width=400&height=410&inlineId=privacy" class="no-underline no-bold thickbox" title="Privacy">Privacy</a><span>|</span>
	<a href="#TB_inline?width=400&height=410&inlineId=terms" class="no-underline no-bold thickbox" title="Terms">Terms</a><span>|</span>Already on <?php echo get_bloginfo('name'); ?>? <a href="/wp-login.php">Login</a>
</div>

<div id="logo" class="mylogo"><img src="<?php echo $mbt_plugin_url; ?>/images/logo_small.png" alt="Connect" /></div>



<div id="about" style="display:none;">
<?php
	$post = get_page(mbt_get_page_id_by_slug('about-us')); 
	$content = apply_filters('the_content', $post->post_content); 
	echo $content; 
?>
</div>

<div id="privacy" style="display:none;">
<?php
	$post = get_page(mbt_get_page_id_by_slug('privacy')); 
	$content = apply_filters('the_content', $post->post_content); 
	echo $content; 
?>
</div>

<div id="terms" style="display:none;">
<?php
	$post = get_page(mbt_get_page_id_by_slug('terms')); 
	$content = apply_filters('the_content', $post->post_content); 
	echo $content; 
?>
</div>

<div class="register_container">
	<h1 id="login_heading_one" style="margin-bottom: 10px"><?php echo $signup_settings['signup_heading']; ?></h1>
	<p><?php echo $signup_settings['signup_text']; ?></p>
	<div class="button_container">
		<a href="#TB_inline?width=350&height=450&inlineId=signupform" data-type="Studio" title="Sign up as a Studio" class="thickbox link_button">Studio</a>
		<a href="#TB_inline?width=350&height=470&inlineId=signupform" data-type="Artist" title="Sign up as an Artist" class="thickbox link_button">Artist</a>
		<a href="#TB_inline?width=350&height=450&inlineId=signupform" data-type="Guest" title="Sign up as a Guest" class="thickbox link_button">Guest</a>
	</div>
</div>

<div id="signupform" style="display: none;"><?php echo bp_ajax_register_form_function(); ?></div>

<div class="fullscreen_post_footer">
	<div class="bullets">
		<div><img src="<?php echo $mbt_plugin_url; ?>/images/connect.png" alt="Connect" /><span>Connect</span></div>
		<div><img src="<?php echo $mbt_plugin_url; ?>/images/discover.png" alt="Discover" /><span>Discover</span></div>
		<div><img src="<?php echo $mbt_plugin_url; ?>/images/share.png" alt="Share" /><span>Share</span></div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
