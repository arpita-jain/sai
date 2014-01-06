<?php
/*
Plugin Name: Resume Submissions & Job Postings
Plugin URI: http://www.geerservices.com/wordpress-plugins/resume-jobs/
Description: Allows the admin to create and show job postings. Users can submit their resume in response to a posting or for general purposes. 
Version: 2.5.3
Author: Keith Andrews (GSI)
Author URI: http://www.geerservices.com
License: GPL2
*/


global $wpdb;

define( 'MANAGEMENT_PERMISSION', 'edit_pages' ); //The minimum privilege required to manage plugin.
define( 'SUBTABLE', $wpdb->prefix . 'rsjp_submissions' );
define( 'JOBTABLE', $wpdb->prefix . 'rsjp_job_postings' );

date_default_timezone_set( get_option( 'timezone_string' ) );


//Installer
function resume_install () {

	require_once( dirname( __FILE__ ) . '/installer.php' );

}

register_activation_hook( __FILE__, 'resume_install' );


// Create widget for displaying job postings
include( 'includes/widget.php' );


// BOF Resume Submissions Menu 
add_action( 'admin_menu', 'resume_submission_menu' );

function resume_submission_menu() {		
	add_menu_page( __( 'RSJP Resumes' ), __( 'RSJP Resumes' ), MANAGEMENT_PERMISSION, 'rsjp-submissions', 'resume_view_all', resume_get_plugin_dir( 'go' ) . '/images/icons/menu-icon.png', 25 );		
	add_submenu_page( 'rsjp-submissions', __( 'Resume Submissions' ), __( 'Resume Submissions' ), MANAGEMENT_PERMISSION, 'rsjp-submissions', 'resume_view_all' );						
	add_submenu_page( 'rsjp-submissions', __( 'Input Fields' ), __( 'Input Fields' ), MANAGEMENT_PERMISSION, 'rsjp-input-fields', 'resume_input_fields' );
	add_submenu_page( 'rsjp-submissions', __( 'Settings' ), __( 'Settings' ), MANAGEMENT_PERMISSION, 'rsjp-settings', 'resume_settings' );
}


// Inlcude the page that builds the custom post type for the Job Postings
include( 'rsjp-job-postings.php' );


//Return path to plugin directory (url/path)
function resume_get_plugin_dir( $type ) {
	if( !defined( 'WP_CONTENT_URL' ) )
		define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
	if( !defined('WP_CONTENT_DIR') )
		define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	if( $type == 'path' ) { 
		return WP_CONTENT_DIR . '/plugins/' . plugin_basename( dirname( __FILE__ ) ); 
	} else { 
		return WP_CONTENT_URL . '/plugins/' . plugin_basename( dirname( __FILE__ ) ); 
	}

}

function resume_add_menu_favorite( $actions ) {
	$actions['admin.php?page=rsjp-submissions'] = array( 'Resume Submission', 'manage_options' );
	return $actions;
}

add_filter( 'favorite_actions', 'resume_add_menu_favorite' ); //Favorites Menu


if( is_admin() ) { 
	add_action( 'admin_menu', 'resume_submission_menu' ); //Admin pages
}

	
// Set i18n
function resume_load_textdomain() {
	load_plugin_textdomain( 'resume-submissions-job-postings', false, resume_get_plugin_dir( 'path' ) . '/languages/' );
}
add_action( 'init', 'resume_load_textdomain' );


// Add widget to Dashboard
function rsjp_dashboard_widget_function() {
	include( 'includes/dashboard-widget.php' );
} 

function rsjp_dashboard() {
	wp_add_dashboard_widget( 'rsjp_dashboard_widget', __( 'RSJP - Recently Submitted Resumes' ), 'rsjp_dashboard_widget_function' );	
} 

add_action( 'wp_dashboard_setup', 'rsjp_dashboard' );

// Function for adding the Multi-File attachment script
function multiFileScript() {
	wp_deregister_script( 'jqueryMultiFile' );
	wp_register_script( 'jqueryMultiFile', resume_get_plugin_dir( 'go' ) . '/includes/jQuery/jquery.multi-file.js' );
	wp_enqueue_script( 'jqueryMultiFile' );
} 

// Function for adding the settings script
function rsjpSettingsScript() {
	//if ( is_page( get_option( 'resume_form_page' ) ) ){
		wp_deregister_script( 'jqueryRSJPSettings' );
		wp_register_script( 'jqueryRSJPSettings', resume_get_plugin_dir( 'go' ) . '/includes/jQuery/settings.js' );
		wp_enqueue_script( 'jqueryRSJPSettings' );
	//}
}


// Functions for styling
function admin_register_resume_style( $hook ) {
	if( $hook == 'toplevel_page_rsjp-submissions' || $hook == 'rsjp-resumes_page_rsjp-job-postings' || $hook == 'rsjp-resumes_page_rsjp-input-fields' 
	    || $hook == 'rsjp-resumes_page_rsjp-settings' || $hook == 'rsjp-resumes_page_rsjp-extra-fields' || $hook == 'edit.php' || $hook == 'post-new.php' || $hook == 'post.php' )
	    wp_enqueue_style( 'resume-admin-custom', plugins_url( '/css/resume-admin-styles.css', __FILE__ ) );
}
function addStyles ( $hook ){
	wp_enqueue_style( 'resume-style', resume_get_plugin_dir( 'go' ) . '/css/resume-styles.css' );	
}

// Add functions to head
add_action( 'admin_enqueue_scripts', 'admin_register_resume_style' );
add_action( 'wp_enqueue_scripts', 'addStyles' );
wp_enqueue_script( 'jquery' );
add_action( 'wp_enqueue_scripts', 'multiFileScript' );
if( $hook == 'rsjp-resumes_page_rsjp-settings' ){
	wp_enqueue_script( 'jquery' );
	add_action( 'wp_footer', 'rsjpSettingsScript' );
}


// Bring in the functions
include( 'includes/functions.php' );
	
// Create Pages
// Main 'View All' Page
function resume_view_all(){
	include( 'includes/submissions.php' );
}

// Input Fields Page
function resume_input_fields(){
	include( 'includes/input-fields.php' );
}

// Settings Page
function resume_settings(){
	include( 'includes/settings.php' );
}

// Form Page
function rsjpFormInclude(){
	 if(get_template()=="constructionmatesss_mob") {
		include( 'includes/form1.php' );
	 }else{
	include( 'includes/form.php' );}
}
function resumeForm_handler(){
	ob_start();
	
	rsjpFormInclude();
	
	$output = ob_get_contents();;
	ob_end_clean();
	
	return $output;
}

// Jobs Page
function rsjpJobsInclude( $orderby, $order, $archive, $limit ){
	include( 'includes/display-jobs.php' );
}
function jobsDisplay_handler( $atts ){
	ob_start();
	
	extract( shortcode_atts( array (
			 'orderby' => 'post_date',
			 'order'   => 'DESC',
			 'archive' => 'Hide',
			 'limit'   => 1000
    ), $atts ) );
	
	rsjpJobsInclude( $orderby, $order, $archive, $limit );
	
	$output = ob_get_contents();;
	ob_end_clean();
	
	return $output;
}

// Resume Display Page
function rsjpDisplayInclude( $condition, $limit ){
	include( 'includes/display-resumes.php' );
}
function resumeDisplay_handler( $atts ){
	ob_start();
	
	extract( shortcode_atts( array (
			 'email' => '',
			 'id'    => '',
			 'job' => '',
			 'limit' => 1000
    ), $atts ) );
	
	if( $email )
		$condition = 'WHERE email = "' . $email . '"';
	if( $id )
		$condition = 'WHERE id = "' . $email . '"';
	if( $job )
		$condition = 'WHERE job = "' . $job . '"';
	
	rsjpDisplayInclude( $condition, $limit );
	
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}

// Resume Display Page
function rsjpSubmit_handler( $atts ){
	global $post;
	
	$jobID = get_the_ID();
	$postInfo = get_post( $jobID ); 
	$slug = $postInfo->post_name;

	ob_start();
	
	extract( shortcode_atts( array (
			 'job' => $slug
    ), $atts ) );
	
	rsjpSubmitFormInclude( $job );
	
	$output = ob_get_contents();;
	ob_end_clean();
	
	return $output;
}

// Add the shortcodes
add_shortcode( 'resumeForm', 'resumeForm_handler' );
add_shortcode( 'jobPostings', 'jobsDisplay_handler' );
add_shortcode( 'resumeDisplay', 'resumeDisplay_handler' );
add_shortcode( 'rsjpSubmit', 'rsjpSubmit_handler' );


/*  Copyright 2012  Keith Andrews  (email : keith@geerservices.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>