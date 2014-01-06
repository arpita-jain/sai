<?php 
/*
Plugin Name: MoPublication
Plugin URI: http://www.mopublication.com
Description: Power your own mobile app.
Author: Grenade Technologies
Version: 1.5.4
Author URI: http://www.grenadeco.com
License: GPLv2 or later
*/

/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

$mopub_settings_page_id = '';
$moPubPath = dirname(__FILE__);
$pluginMode = 2;
$pluginName = 'MoPublication';
$pluginDirectory = 'mopublication';
$pluginMainFile = 'mopublication.php';
$faqLink = 'http://support.mopublication.com';
$contactLink = 'http://www.mopublication.com/contact/';

include_once 'includes/customfields.php';
include_once 'includes/customfunctions.php';
include_once 'includes/ajax.php';
include_once 'includes/help.php';
include_once 'includes/promo_widget.php';
include_once 'includes/promo_settings.php';

/**
 * Add a MoPublication option to the Wordpress admin menu
 */
function mopub_admin_menu() {
    
    global $pluginName, $mopub_settings_page_id;
    
    $mopub_settings_page_id = add_menu_page(
        $pluginName.' Settings',
        $pluginName,
        'administrator',
        __FILE__,
        'mopub_settings_page',
        plugins_url('/images/icon.png', __FILE__)
    );

    // Add help tab when page loads
    add_action('load-'.$mopub_settings_page_id, 'mopub_admin_add_help_tab');
}

add_action('admin_menu', 'mopub_admin_menu');

/**
 *  Emails a copy of the config file to MoPublication, as backup;
 *
 */
function moPubEmailConfig() {

    $config = get_option('frm_config_file');
    $subject = get_site_url().' - Configuration File' ;

    if (wp_mail( 'setup@mopublication.com', $subject, $config)) {
        echo true;
    } else {
        echo false;
    }

	exit();
}
add_action('wp_ajax_moPubEmailConfig', 'moPubEmailConfig');

/**
 * AJAX return list of pages 
 */
function moPubGetPages() {
    
    $pages = get_pages();
    $returnPages = array();
    
    $x = 0;
    foreach ($pages as $page) {
        
        $cleanPostTitle  = str_replace(' ', '_',$page->post_title);

        //exclude pages that are already in DB 
        if(get_option('frm_checkbox_'.$page->ID) === false) {
        
            $returnPages[$x] = (array)$page;
            $returnPages[$x]['post_title_clean'] = $cleanPostTitle;

            $x++;
        
        }
    }
    
    echo json_encode($returnPages);

	exit();
}
add_action('wp_ajax_moPubGetPages', 'moPubGetPages');

/**
 * Register Tab Option
 */
function mopubSaveTab() {
    
    $x = 0;
    foreach($_POST['options'] as $option) {
        
      update_option($option, $_POST['values'][$x]);
      
      $x++;
      
    }
    
	exit();
}
add_action('wp_ajax_mopubSaveTab', 'mopubSaveTab');

/**
 * Check if dynamic page option exists, add if it doesn't 
 */
function moPubAddPage() {
    
    $page = get_post($_POST['ID']);
    
    $newPage = array(0 => array("name" => $page->post_title, "type" => "page", "link" => getPermalinkStructure()."type=mobile&article_id=".urlencode($page->ID), "ID" => $page->ID, "icon" => $_POST['itemIcon']));
    
    addToTabsOrder($newPage);
    
    add_option('frm_checkbox_'.$page->ID, '');
    
    $tabOrder = json_decode(get_option('mopub_tabs_order'), true);
    
    foreach($tabOrder as $tab){
        
        if($tab[ID] == $_POST['ID']) {
            
            echo json_encode($tab);
            exit();
            
        }
        
    }
    
    exit();
}
add_action('wp_ajax_moPubAddPage', 'moPubAddPage');

/**
 * Check if dynamic page option exists, add if it doesn't 
 */
function updatePagesOrder() {
    
    $oldTabOrder = json_decode(get_option('mopub_tabs_order'), true);
    $newTabOrder = array();
    
    foreach($_POST['order'] as $orderItem) {
        
        foreach ($oldTabOrder as $tab) {
            
            if($tab['TABID'] == $orderItem) {
                
                $newTabOrder[] = $tab;
                break;
            }
            
        } 
        
    }
    
    echo json_encode($newTabOrder);
    exit();
}
add_action('wp_ajax_updatePagesOrder', 'updatePagesOrder');

function mopubDeletePage() {
    
    delete_option('frm_checkbox_'.$_POST['ID']);
    removeTabFromOrder('ID', $_POST['ID']);
    
    echo get_option('mopub_tabs_order');
    
    exit();
}
add_action('wp_ajax_mopubDeletePage', 'mopubDeletePage');

/**
 * Register all the Settings used to save the app config data
 */
include 'includes/register-settings.php';
add_action( 'admin_init', 'mopub_register_settings' );

/**
 *  Scripts that we load only on the MoPublication settings page
 */
function mopub_settings_print_scripts()
{
    
    global $pluginDirectory, $pluginMainFile;
    
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'jquery-ui-droppable' );
    wp_enqueue_script( 'jquery-ui-position' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-tabs' );
    wp_enqueue_script( 'jquery-ui-dialog' );

    wp_enqueue_script( 'jquery-minicolors',  plugins_url('/'.$pluginDirectory.'/js/jquery.miniColors.min.js') );

    wp_enqueue_script( 'mopub-ajax',        plugins_url('/'.$pluginDirectory.'/js/ajax.js') );
    wp_enqueue_script( 'mopub-interface',   plugins_url('/'.$pluginDirectory.'/js/interface.js') );
    
    $timestamp = time();
    wp_localize_script('mopub-interface', 'WPULRS', array( 'siteurl' => get_option('siteurl'), 'permalinkstructure' => getPermalinkStructure(), 'key' => md5(get_option('mopub_salt').$timestamp), 't' => $timestamp ));
    
    wp_enqueue_script( 'mopub-validation',  plugins_url('/'.$pluginDirectory.'/js/validation.js') );
    wp_enqueue_script( 'mopub-tooltips',    plugins_url('/'.$pluginDirectory.'/js/tooltips.js') );

}

if ( isset($_GET['page']) && $_GET['page'] == $pluginDirectory.'/'.$pluginMainFile )
{
    add_action('admin_head', 'mopub_admin_head');
    add_action('admin_footer', 'mopub_admin_foot');

    add_action('admin_print_scripts', 'mopub_settings_print_scripts');
}

/**
 *  Header stuff that we include only on the MoPublication settings page
 */
function mopub_admin_head()
{
    global $pluginDirectory;

    wp_enqueue_style( 'mopub-style', plugins_url('/'.$pluginDirectory.'/style.css') );
    wp_enqueue_style( 'mopub-miniColors', plugins_url('/'.$pluginDirectory.'/css/jquery.miniColors.css') );

    include 'js/validation-appname.php';
    include 'css/demo.php';
}

/**
 *  Scripts that must be loaded in the footer
 */
function mopub_admin_foot() {
    
    global $pluginDirectory;

    wp_enqueue_script( 'mopub-footer',       plugins_url('/'.$pluginDirectory.'/js/footer.js') );
    
}

/**
 *  Scripts that we want to load everywhere
 *  (not just the MoPublication settings page)
 */
function mopub_admin_print_scripts() {
    
    wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
    
}

function mopub_admin_print_styles() {
    
	wp_enqueue_style('thickbox');
    
}

add_action('admin_print_scripts', 'mopub_admin_print_scripts');
add_action('admin_print_styles', 'mopub_admin_print_styles');

function mopub_xml_template($template)
{
	if ( is_page('mopubxml') )
    {
        $template = dirname( __FILE__ ) . '/templates/feed.php';
    }
	return $template;
}

add_filter('template_include', 'mopub_xml_template', 1, 1);

function mopub_mobile_template($template)
{
	
	return $template;
}

add_filter('template_include', 'mopub_mobile_template', 1, 1);


function mopub_settings_page() {
    
    global $pluginMode, $moPubPath, $pluginName, $pluginDirectory;
    settings_fields( 'mopub-settings' );

	if(!($page = get_page_by_title('mopubxml'))) {
	    global $user_ID;
	    $new_post = array(
	        'post_title' => 'mopubxml',
	        'post_content' => 'DO NOT REMOVE THIS PAGE! Your awesome '.$pluginName.' iPhone app makes use of it.',
	        'post_status' => 'publish',
	        'post_date' => date('Y-m-d H:i:s'),
	        'post_author' => $user_ID,
	        'post_type' => 'page',
	    );
	    $post_id = wp_insert_post( $new_post );

        if( !$post_id )
            wp_die('Error creating template page');
        else
			update_post_meta( $post_id, '_wp_page_template', 'feed.php' );
	}

    if($page->post_status == 'trash') {

        $post_update = array();
        $post_update['ID'] = $page->ID;
        $post_update['post_status'] = 'publish';

        $post_id = wp_update_post( $post_update );

        if( !$post_id ) {
            wp_die('Error creating template page');
        }
    }

	include 'includes/options.php';
    
}

add_filter('upload_mimes', 'custom_upload_mimes');

function custom_upload_mimes ( $existing_mimes=array() ) {
 
    // Add file extension 'extension' with mime type 'mime/type'
    $existing_mimes['extension'] = 'mime/type';

    // add as many as you like e.g. 

    $existing_mimes['AAC'] = 'audio/x-aac'; 
    $existing_mimes['MP3'] = 'audio/mpeg';  ; 
    $existing_mimes['mov'] = 'video/quicktime'; 
    $existing_mimes['mp4'] = 'video/mp4'; 
    $existing_mimes['mpv'] = 'application/x-project'; 
    $existing_mimes['3gp'] = 'video/3gpp'; 


    // remove items here if desired ...

    // and return the new full result
    return $existing_mimes;

 
}

function mopubInit() {
    
    add_filter('get_pages','excludeMopubPages');
    
    //Adds and sets the the salt value, does nothing if the value already exists
    $salt = md5(site_url().time());
    add_option('mopub_salt', $salt);

}

/**
 * Removes MoPub pages from menu items
 */
function excludeMopubPages($pages) {
    

    
    //Exclude MoPub page
    $mopubPage = get_page_by_title('mopubxml');
    $pagesToExclude = array($mopubPage->ID);

    $x = 0;
    foreach($pages as $page) {
        
        if(in_array($page->ID, $pagesToExclude)) {
            
            unset($pages[$x]);
            
        }
       $x++;     
    }
    
    return $pages;
}

add_action( 'init', 'mopubInit' );


function deactivateMoPublication() {
    
    //delete mopub page
    $mopubPage = get_page_by_title('mopubxml');
    wp_delete_post( $mopubPage->ID, TRUE );
    
}

function uninstallMoPublication() {
    
    //delete mopub page
    $mopubPage = get_page_by_title('mopubxml');
    wp_delete_post( $mopubPage->ID, TRUE );
    
    //delete options
    delete_option( 'frm_general_appname' );
    delete_option( 'frm_general_iconname' );
    delete_option( 'frm_border_color' );
    delete_option( 'frm_viewer_background' );
    delete_option( 'frm_topbar_background' );
    delete_option( 'frm_topbar_logo' );
    delete_option( 'frm_menu_background_color' );
    delete_option( 'frm_menu_textcolor' );
    delete_option( 'frm_menu_active_background_color' );
    delete_option( 'frm_menu_textcolor_inactive' );
    delete_option( 'frm_images_splash' );
    delete_option( 'frm_images_appicon' );
    delete_option( 'frm_video_cat' );
    delete_option( 'frm_audio_cat' );
    delete_option( 'frm_type_title_color' );
    delete_option( 'frm_type_meta_color' );
    delete_option( 'frm_type_link_color' );
    delete_option( 'frm_type_text_color' );
    delete_option( 'frm_type_font_type' );
    delete_option( 'frm_menu_bottom_order' );
    delete_option( 'frm_menu_top_order' );
    delete_option( 'frm_checkbox_search' );
    delete_option( 'frm_checkbox_videos' );
    delete_option( 'frm_checkbox_audio' );
    delete_option( 'frm_checkbox_categories' );
    delete_option( 'frm_checkbox_tags' );
    delete_option( 'frm_checkbox_about' );
    delete_option( 'frm_checkbox_latest' );
    delete_option( 'frm_checkbox_contact' );
    delete_option( 'frm_cat_checkbox_uncategorized' );
    delete_option( 'frm_cat_checkbox_all' );
    delete_option( 'frm_about_about' );
    delete_option( 'frm_contact_email' );
    delete_option( 'frm_contact_intro' );
    delete_option( 'frm_analytics_active' );
    delete_option( 'frm_addthis_account' );
    delete_option( 'frm_addthis_appid' );
    delete_option( 'frm_addthis_pubid' );
    delete_option( 'frm_addthis_username' );
    delete_option( 'frm_addthis_twittername' );
    delete_option( 'frm_addthis_shareurl' );
    delete_option( 'frm_ad_status' );
    delete_option( 'frm_ad_network' );
    delete_option( 'frm_ad_pubid' );
    delete_option( 'frm_ad_code_splash_iphone' );
    delete_option( 'frm_ad_code_pslash_ipad' );
    delete_option( 'frm_ad_code_iphone_top' );
    delete_option( 'frm_ad_code_iphone_bottom' );
    delete_option( 'frm_ad_code_ipad_top' );
    delete_option( 'frm_ad_code_ipad_bottom' );
    delete_option( 'frm_ad_image_iphone_splash' );
    delete_option( 'frm_ad_image_ipad_splash' );
    delete_option( 'frm_ad_url_iphone_splash' );
    delete_option( 'frm_ad_url_ipad_splash' );
    delete_option( 'frm_ad_image_iphone_top' );
    delete_option( 'frm_ad_url_iphone_top' );
    delete_option( 'frm_ad_image_iphone_bottom' );
    delete_option( 'frm_ad_url_iphone_bottom' );
    delete_option( 'frm_ad_image_ipad_top' );
    delete_option( 'frm_ad_url_ipad_top' );
    delete_option( 'frm_ad_image_ipad_bottom' );
    delete_option( 'frm_ad_image_ipad_bottom' );
    delete_option( 'frm_admob_id' );
    delete_option( 'frm_config_file' );
    delete_option( 'frm_language' );
    delete_option( 'frm_countries' );
    delete_option( 'frm_countries_select' );
    delete_option( 'frm_category_primary' );
    delete_option( 'frm_category_secondary' );
    delete_option( 'frm_age_fantasy_violence' );
    delete_option( 'frm_age_realistic_violence' );
    delete_option( 'frm_age_sexual' );
    delete_option( 'frm_age_profanity' );
    delete_option( 'frm_age_drug' );
    delete_option( 'frm_age_mature' );
    delete_option( 'frm_age_gambling' );
    delete_option( 'frm_age_horror' );
    delete_option( 'frm_age_graphic_sexual' );
    delete_option( 'frm_app_description' );
    delete_option( 'frm_app_keywords' );
    delete_option( 'frm_analytics_pubid' );
    delete_option( 'frm_ad_code_splash_ipad' );
    delete_option( 'frm_ad_url_ipad_bottom' );
    delete_option( 'frm_age_graphic_violence' );

    delete_option( 'frm_layout' );

    delete_option( 'frm_disqus_user_api_key' );
    delete_option( 'frm_disqus_api_key' );
    delete_option( 'frm_disqus_short_name' );
    delete_option( 'frm_comment_option' );
    delete_option( 'frm_comment_support' );
    delete_option( 'frm_protect_xml' );
    delete_option( 'frm_strict_filtering' );
    delete_option( 'frm_checkbox_2' );
    delete_option( 'mopub_mobile_template' );
    delete_option( 'mopub_mobile_template_gentime' );
    
    delete_option( 'mopub_salt' );
    
    //delete all page tabs
    $tabs = get_option( 'mopub_tabs_order' );
    
    foreach($tabs as $tab) {
        
      delete_option('frm_checkbox_'.$tab['ID']); 
        
    }
    
    delete_option( 'mopub_tabs_order' );
}

function plugin_get_version() {
    
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
    
}

register_deactivation_hook(__FILE__, 'deactivateMoPublication');
register_uninstall_hook(__FILE__, 'uninstallMoPublication');




