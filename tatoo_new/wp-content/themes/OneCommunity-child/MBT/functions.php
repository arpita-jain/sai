<?php

//require_once( 'database/DB_classes.php' );
require_once( 'shortcodes.php' );
require_once( 'functions2.php' );
require_once( 'actions.php' );
require_once( 'filters.php' );
require_once( 'ajax.php' );
//require_once( 'admin_side.php' );
require_once( 'widgets/widget.php' );

define( 'SCRIPT_IDS', 'MBT-');
define( 'THEME_STYLESHEET_URI', get_stylesheet_directory_uri() );
define( 'THEME_ANTICACHE', '1.0.1'); //rand(0, 10000));
define( 'MBT_LANG', 'mbt_lang');

define( 'MBT_MAX_IMAGE_WIDTH', 750);
define( 'MBT_MAX_IMAGE_HEIGHT', 650);
define( 'MBT_MEDIA_TAXONOMY', 'media_taxonomy');

global $my_links;

$my_links = array();

function mbt_force_login() {
	if ( mbt_is_ajax_request() ) { return; }
	/* If not admin request then redirect user on homepage other than admins */
	if ( is_admin() ) { if ( !current_user_can( 'manage_options' ) ) { wp_redirect( site_url( ) ); } }
	
	if ( mbt_is_activate_page() ) { return; }
	if ( !mbt_is_login_page() && !is_user_logged_in() && !mbt_is_signup_page() ) { 
		auth_redirect();
	}
}

mbt_force_login();
MBT_init();

/*if ( is_admin() ) {
	if ( !current_user_can( 'manage_options' ) ) {
		wp_redirect( site_url( ) );
	} 
}*/

function MBT_init() {
	add_action( 'init', 'load_mbt_styles', 100000 );
	add_action( 'init', 'load_mbt_scripts' );
	add_action( 'init', 'mbt_register_taxonomies' );
	//add_action( 'init', 'mbt_flush_rewrite', 999 );
	add_action( 'template_redirect', 'mbt_template_redirect', 1);
	//add_action( 'wp_head', 'load_mbt_js_variables' );
	add_action( 'wp_print_styles', 'mbt_print_styles' );
	add_action( 'wp_print_scripts', 'mbt_print_scripts' );
	add_filter( 'wp_mail_from', 'mbt_mail_from' );
	add_filter( 'rewrite_rules_array', 'mbt_add_rewrite_rules' );
	add_filter( 'query_vars', 'mbt_query_vars' );
	//add_action( 'init', 'load_thickbox' );

	//add_image_size( 'product_thumbnail', $width = 70, $height = 60, $crop = true );
	add_image_size( 'photo_small', $width = 60, $height = 60, $crop = true );
	add_image_size( 'photo_thumb_medium', $width = 100, $height = 100, $crop = true );
	add_image_size( 'photo_thumb', $width = 150, $height = 150, $crop = true );

	//mbt_register_sidebars();
	//mbt_register_menu_locations();
	if ( !is_admin() && !mbt_is_login_page() && !mbt_is_signup_page() ) {
		wp_register_style( 'myStyle', get_stylesheet_directory_uri() . '/myStyle.css', array(), bp_get_version() );
		wp_enqueue_style( 'myStyle' );
	}
}

function mbt_template_redirect( $args ) {
	global $pagename;
	/* To remove template redirection when /explore/{pagenum}/{media_categories} */
	remove_action('template_redirect','redirect_canonical');
}

function mbt_add_rewrite_rules( $rules ) {
	global $wp_query;
	$new_rules = array();
	$new_rules ['explore/([^/]+)/([^/]+)/?$']	= 'index.php?pagename=explore&page=$matches[1]&media_category=$matches[2]';
	$new_rules ['explore/([^/]+)/?$']			= 'index.php?pagename=explore&page=$matches[1]&media_category=';

	$rules = array_merge($new_rules, $rules);
	
	return $rules;
}

function mbt_query_vars( $vars ) {
	if ( !in_array('media_category', $vars) ) {
		$vars[] = 'media_category';
	}
	return $vars;
}

function mbt_flush_rewrite() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function mbt_register_taxonomies() {
	$args = array(
		'hierarchical' => 1
	);
	register_taxonomy( MBT_MEDIA_TAXONOMY, 'attachment', $args );

}
 
function mbt_mail_from($old) {
	return get_bloginfo( 'admin_email' );
}

function mbt_print_styles() {
	if ( mbt_is_signup_page() ) {
		wp_dequeue_style( 'responsive' );
		wp_dequeue_style( 'font' );
		wp_dequeue_style( 'OneByOne' );
		wp_dequeue_style( 'OneByOneResponsive' );
		wp_dequeue_style( 'Animate' );
		wp_dequeue_style( 'myStyle' );
		wp_dequeue_style( 'rtmedia-magnific' );
		wp_dequeue_style( 'rtmedia-main' );
		wp_dequeue_style( 'rtmedia-mecss' );
		wp_dequeue_style( 'buatp-style' );
	}
}

function mbt_print_scripts() {
	if ( mbt_is_signup_page() ) {
		
		wp_dequeue_script('OneByOneMin');
		wp_dequeue_script('Touchwipe');
		wp_dequeue_script('jQFunctions');
		wp_dequeue_script('plupload-all');
		wp_dequeue_script('rtmedia-backbone');
	}
	wp_dequeue_script('QuicksandBold');
	wp_dequeue_script('Cufon');
}

function mbt_register_menu_locations() {
	register_nav_menu( 'logged_in_top_menu', 'Logged in top menu' );
	register_nav_menu( 'logged_out_top_menu', 'Logged out top menu' );
}

function mbt_register_sidebars() {
	register_sidebar(array(
		'name'			=> esc_html__('Product Page Sidebar', MBT_LANG),
		'id'			=> 'product-page-sidebar',
		'description'	=> esc_html__('Shown on Single Product Page', MBT_LANG),
		'before_widget'	=> '<div id="%1$s" class="product_page_sidebar %2$s substitute_widget_class">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3 class="sidebar_title">',
		'after_title'	=> '</h3>',
	));

}

function load_mbt_styles() {
	if ( !is_admin() ) {
		wp_enqueue_style( "MBT", THEME_STYLESHEET_URI . "/MBT/css/MBT.css", null, THEME_ANTICACHE );
		wp_enqueue_style( "TEST", THEME_STYLESHEET_URI . "/MBT/css/test.css", null, THEME_ANTICACHE );
		wp_enqueue_style( "jquery-ui", "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css", null, THEME_ANTICACHE );
		
	}

	if ( is_admin() ) {
		wp_enqueue_style( "MBT", THEME_STYLESHEET_URI . "/MBT/css/MBT_admin.css", null, THEME_ANTICACHE );
	}
}

function load_mbt_scripts() {
	if ( !is_admin() ) {
		wp_enqueue_script( SCRIPT_IDS . "base", THEME_STYLESHEET_URI . "/MBT/js/MBT.js", array("jquery"), THEME_ANTICACHE, true );
		wp_enqueue_script('jquery-ui',	'http://code.jquery.com/ui/1.10.3/jquery-ui.js',array( 'jquery' ));
	}
}

function load_mbt_js_variables() {
?>
	<script>
		var home_url = '<?php echo home_url(); ?>';
		var MBT_ajax_url = '<?php echo home_url(); ?>/wp-admin/admin-ajax.php';
		var THEME_STYLESHEET_URI = '<?php echo THEME_STYLESHEET_URI; ?>';
	</script>
<?php
}


function load_thickbox() {
	if ( !is_admin() ) {
		add_thickbox();
	}
}

if ( !function_exists('print_rr') ) {
	function print_rr($arr) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
}




