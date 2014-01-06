<?php
/*
	Plugin Name: Mindblaze
	Plugin URI: http://mindblazetech.com
	Description: Mindblaze Plugin for system modifications
	Version: 0.1
	Author: <code>Hassan Asad</code>
	Author URI: http://mindblazetech.com
	License: This plugin is licensed for the use of boysclub.
*/


class mbt_system {

	var $aSlug 						    = 'mbt-system';
	var $plugin_url 					= null;
	var $plugin_path 					= null;
	
	
	function __construct() {		
		global $blog_id, $bp;

		$this->plugin_url 	= plugins_url( '', __FILE__ );
		$this->plugin_path 	= plugin_dir_path( __FILE__ );

		/* network setting */
		//add_action( 'network_admin_menu', array(&$this, 'network_init') );
		add_action( 'admin_menu', array(&$this, '_admin_init') );
		register_activation_hook( __FILE__, array( $this, '_activate') );

		add_action( 'login_enqueue_scripts', array( $this, 'login_stylesheets') );
		add_action( 'login_footer', array( $this, 'login_footer') );
		//add_action( 'mbt_after_login_form', array( $this, 'after_login_form') );
		
		add_action( 'mbt_login_heading', array( $this, 'login_heading') );
		add_action( 'init', array( $this, 'load_thickbox') );

		/* Redirecting from wp-signup.php and buddypress registration pages to /signup */
		add_action( 'signup_header', array( $this, 'signup_redirect' ), 1 );
		add_filter( 'bp_get_signup_page', array( $this, 'bp_signup_page') );
		add_filter( 'wp_signup_location', array( $this, 'bp_signup_page') );	/* wordpress signup filter */

		
		/* url rewriting */
		//add_action( 'init', array(&$this, 'flush_rewrite'), 999 );
		//add_filter( 'rewrite_rules_array', array(&$this, '_add_rewrite_rules') );
		//add_filter( 'query_vars', array(&$this, '_query_vars') );
		add_action( 'parse_request', array(&$this, '_parse_request'));
		/* end */

			
		/*if ( !is_admin() ) {
			wp_deregister_script( 'jquery-ui-min' );
			wp_register_script( 'jquery-ui-min', plugins_url( 'js/jquery-ui-1.10.1.custom.min.js', __FILE__ ),array( 'jquery' ), '1.10.1', true );
			wp_enqueue_script( 'jquery-ui-min' );
			
			wp_deregister_script( 'jquery-ui-timepicker' );
			wp_register_script( 'jquery-ui-timepicker', plugins_url( 'js/jquery.ui.timepicker.js', __FILE__ ),array( 'jquery-ui-min' ), '1.8.17', false );
			wp_enqueue_script( 'jquery-ui-timepicker' );
			
			
			//add colorbox css
			wp_enqueue_style( 'colorbox',  plugins_url( 'css/colorbox.css', __FILE__ ) );
			// add colorbox js
			wp_deregister_script( 'colorbox' );
			wp_register_script( 'colorbox', plugins_url( 'js/jquery.colorbox-min.js', __FILE__ ), array('jquery'), '1.3.16', false);
			wp_enqueue_script( 'colorbox' );		
		}
			
				
		if( !is_admin() ) {
			wp_enqueue_style( 'fundraiser_system_style',  plugins_url( 'css/style.css', __FILE__ ) );
		} else {
			wp_enqueue_style( 'fundraiser_system_admin',  plugins_url( 'css/admin.css', __FILE__ ) );
		}*/
	}


	function _activate() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}


	function _admin_init() {
		add_menu_page( 'MBT System', 'MBT System', 'administrator', $this->aSlug, array(&$this, '_settings'),	$this->plugin_url . '/images/icon.png' );
		add_submenu_page( $this->aSlug, 'Settings', 'Settings', 'administrator', $this->aSlug, array(&$this, '_settings') );
	}


	function load_thickbox() {
		add_thickbox();
	}


	function login_stylesheets() {
		$login_settings = get_site_option('login_page_setting');
		$background = $login_settings['background'];
		if ( !empty($background) ) {
		?>
		<style type="text/css">
			body.login {
				background: url("<?php echo $background; ?>") no-repeat;
				background-size: cover;
				background-position: 50% 50%;
			}

			body.login:before {
				content: '';
				position: fixed;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				background: rgba(0,0,0,0.2) url('<?php echo $this->plugin_url; ?>/images/full_page_vignette.png');
				background-size: 100% 100%;
				opacity: .5;
			}
		</style>
		<?php
		}
    	echo '<link rel="stylesheet" id="custom_wp_admin_css"  href="' . $this->plugin_url . '/css/login-style.css?anti-cache=1" type="text/css" media="all" />';
	}

	function after_login_form() {
		?>
		<div class="below_login_form">
			<label>OR</label>
			<?php
			global $opt_jfb_hide_button;
			 if( !get_option($opt_jfb_hide_button) ) {
			 	if ( function_exists('jfb_output_facebook_btn') ) {
					jfb_output_facebook_btn();
					jfb_output_facebook_init(); /* This is output in wp_footer as of 1.5.4 */
					jfb_output_facebook_callback(); /* This is output in wp_footer as of 1.9.0 */
				}
			}
			?>
		</div>
		<?php
	}


	function login_footer() {
		$login_settings = get_site_option('login_page_setting');
		?>
		<div class="fullscreen_post_footer">
			<div id="signup_teaser">
				<h2 id="signup_heading"><?php echo $login_settings['footer_text']; ?><a href="/signup" class="link_button" title="Sign up">Sign up</a></h2>
			</div>
		</div>
		<?php
	}


	function login_heading() {
		echo '<div class="signup_top_links">
			<a href="#TB_inline?width=400&height=410&inlineId=about" class="no-underline no-bold thickbox" title="About">About</a><span>|</span>
			<a href="#TB_inline?width=400&height=410&inlineId=privacy" class="no-underline no-bold thickbox" title="Privacy">Privacy</a><span>|</span>
			<a href="#TB_inline?width=400&height=410&inlineId=terms" class="no-underline no-bold thickbox" title="Terms">Terms</a><span>
		</div> <div id="logo" class="loginpage-logo"><img src="'. $this->plugin_url . '/images/logo_small.png" alt="" /></div>';
		?>
		

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
		<?php

		$login_settings = get_site_option('login_page_setting');

		echo '<h1 id="login_heading_one">' . $login_settings['logo_text'] . '</h1>';
	}

	

	function signup_redirect() {
		wp_redirect( '/signup' );
		exit;
	}


	function bp_signup_page( $page ) {
		return site_url( 'signup' );
	}
	

	function _settings() {
		add_thickbox();
		?>
		<?php
		$update_flag 	= 0;
		$message 		= null;
		$errors 		= array();
		if (isset($_POST['login_register_submit'])) { 
			$update_flag = 1;
			$message = 'Settings Saved!';
			
			$login['logo_text']			= $_POST['login-logo-text'];
			$login['footer_text'] 		= $_POST['login-footer-text'];
			$login['background'] 		= $_POST['login-background'];
			
			$signup['signup_heading']	= $_POST['signup-heading'];
			$signup['signup_text'] 		= $_POST['signup-text'];
			$signup['background'] 		= $_POST['signup-background'];

			$other['artist_sub_type']	= $_POST['artist_sub_type'];
			$other['artist_sub_type2']	= $_POST['artist_sub_type2'];

			update_site_option('login_page_setting', $login);
			update_site_option('signup_page_setting', $signup);
			update_site_option('other_settings', $other);

		}

		$login_def['logo_text']			= 'Login Logo Text';
		$login_def['footer_text'] 		= 'Footer Default Text';
		$login_def['background']		= '';
		
		$signup_def['signup_heading']	= 'Signup Logo Text';
		$signup_def['signup_text'] 		= 'Signup caption text';
		$signup_def['background'] 		= '';

		$other_def['artist_sub_type'] 	= 'New Type';
		$other_def['artist_sub_type2'] 	= 'New Type';
		
		$login_settings 	= get_site_option('login_page_setting', $login_def);
		$signup_settings 	= get_site_option('signup_page_setting', $signup_def);
		$other_settings		= get_site_option('other_settings', $other_def);
		?>

		<style>
			.media-single label {
				display:inline-block;
				width:120px;
			}
			.media-single input[type=text] {
				width:462px;
			}

			input.icon_url { width:370px !important; } 
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function() {

				jQuery(".image_btn").live('click', function(){
					currentlyselected = jQuery(this).attr('rel');
					var icon_url_obj;
					jQuery(this).parent().find('input.icon_url').each( function(index, element) {
						icon_url_obj = jQuery(this);
					});
					tb_show('', 'media-upload.php?type=image&amp;type=image&amp;TB_iframe=true');   
					window.send_to_editor = function(html) {
						imgurl = jQuery('img',html).attr('src');
						icon_url_obj.val(imgurl);
						tb_remove();
					}
					return false;
				});

			});
		</script>
		<div class="wrap">
			<h2>Login &amp; Register Page Settings</h2>
			<?php
			if ( $update_flag == 1 ) {
				echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>' . $message . '</strong></p></div>';
			}
			?>
			<form id="media-single-form" class="media-upload-form" action="" method="post">
				<input type="hidden" name="login_register_submit" id="login_register_submit" value="1" />

				<p class="submit"><input type="submit" value="Save" class="button-primary" name="save"></p>

				<div class="media-single">
					<h2>Login Page Setting</h2>
					<p>
						<label for="login-logo-text"><span class="alignleft">Login Logo Text</span></label>
						<input type="text" aria-required="true" value="<?php echo $login_settings['logo_text'];?>" name="login-logo-text" id="login-logo-text" class="text">
					</p>
					<p>
						<label for="login-footer-text"><span class="alignleft">Login Footer Text</span></label>
						<input type="text" value="<?php echo $login_settings['footer_text'];?>" name="login-footer-text" id="login-footer-text" class="text">
					</p>
					<p>
						<label for="login-background"><span class="alignleft">Login Background</span></label>
						<input readonly="readonly" type="text" value="<?php echo $login_settings['background'];?>" id="login-background" name="login-background" class="text icon_url"> 
						<input type="button" rel="new" name="image-new" id="image-new" value="Choose File" class="image_btn button-secondary" />
					</p>
				</div>
				<br /><br />

				<div class="media-single">
					<h2>Signup Page Setting</h2>
					<p>
						<label for="signup-heading"><span class="alignleft">Signup Heading</span></label>
						<input type="text" aria-required="true" value="<?php echo $signup_settings['signup_heading'];?>" name="signup-heading" id="signup-heading" class="text">
					</p>
					<p>
						<label for="signup-text"><span class="alignleft">Signup Text</span></label>
						<input type="text" value="<?php echo $signup_settings['signup_text'];?>" name="signup-text" id="signup-text" class="text">
					</p>
					<p>
						<label for="signup-background"><span class="alignleft">Signup Background</span></label>
						<input readonly="readonly" type="text" value="<?php echo $signup_settings['background'];?>" id="signup-background" name="signup-background" class="text icon_url"> 
						<input type="button" rel="new" name="image-signup" id="image-signup" value="Choose File" class="image_btn button-secondary" />
					</p>

				</div>

				<div class="media-single">
					<h2>Artist Sub type</h2>

					<p>
						<label for="artist_sub_type"><span class="alignleft">Sub Type</span></label>
						<input type="text" aria-required="true" value="<?php echo $other_settings['artist_sub_type'];?>" name="artist_sub_type" id="artist_sub_type" class="text" />
					</p>

					<p>
						<label for="artist_sub_type2"><span class="alignleft">Sub Type 2</span></label>
						<input type="text" aria-required="true" value="<?php echo $other_settings['artist_sub_type2'];?>" name="artist_sub_type2" id="artist_sub_type2" class="text" />
					</p>
				</div>

				<p class="submit"><input type="submit" value="Save" class="button-primary" name="save"></p>
			</form>
		</div> 
		<?php
	}


	function _parse_request($wp) {
		if( array_key_exists('pagename', $wp->query_vars) || array_key_exists('name', $wp->query_vars)) {
			if ( $wp->query_vars['pagename'] == 'signup' || $wp->query_vars['name'] == 'signup' ) {
				$this->df_disable_admin_bar();
				global $mbt_plugin_url;
				$mbt_plugin_url = $this->plugin_url;
				load_template( $this->plugin_path . 'templates/signup.php' );
				exit;
			}
		}
	}

	
	/* Disable Admin Bar for everyone */
	function df_disable_admin_bar() {
		
		// for the admin page
		remove_action('admin_footer', 'wp_admin_bar_render', 1000);
		// for the front-end
		remove_action('wp_footer', 'wp_admin_bar_render', 1000);
		
		// css override for the admin page
		function remove_admin_bar_style_backend() { 
			echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
		}	  
		add_filter('admin_head','remove_admin_bar_style_backend');
		
		// css override for the frontend
		function remove_admin_bar_style_frontend() {
			echo '<style type="text/css" media="screen">
			html { margin-top: 0px !important; }
			* html body { margin-top: 0px !important; }
			</style>';
		}
		add_filter('wp_head','remove_admin_bar_style_frontend', 99);
  	}

	
	function __cron_jobs() {
		$cron = _get_cron_array();
		$schedules = wp_get_schedules();
		$date_format = 'M j, Y @ G:i:s';
	?>
		<div class="wrap" id="cron-gui">
			<h2>Cron Events Scheduled</h2>

			<table class="widefat fixed">
				<thead>
					<tr>
						<th scope="col">Next Run (GMT/UTC)</th>
						<th scope="col">Schedule</th>
						<th scope="col">Hook Name</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $cron as $timestamp => $cronhooks ) { ?>
						<?php foreach ( (array) $cronhooks as
							$hook => $events ) { ?>
							<?php foreach ( (array) $events as $event ) { ?>
								<tr>
									<td><?php echo date_i18n( $date_format,	wp_next_scheduled( $hook ) ); ?></td>
									<td>
										<?php
										if ( $event[ 'schedule' ] ) {
											echo $schedules[$event[ 'schedule' ]][ 'display' ];
										} else { echo 'One-time'; }
										?>
									</td>
									<td><?php echo $hook; ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<br />
		<br />
	<?php
		echo 'Current Time : ' . date('M j, Y @ G:i:s', time());
	}
}


$mbt_system = new mbt_system();