<?php
//***** Installer *****
global $wp_version, $wpdb;

if ( version_compare( $wp_version, '3.0', '<' ) ) {
	require_once( ABSPATH . 'wp-admin/upgrade.php' );
} else {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
}
//***Installer variables***
$resume_db_version = "2.5.3";
//***Installer****
if( $wpdb->get_var( 'SHOW TABLES LIKE "' . SUBTABLE . '"' ) != SUBTABLE ) {
	$sql = 'CREATE TABLE ' . SUBTABLE . ' (
		  id int(12) NOT NULL auto_increment,
		  fname varchar(150) NOT NULL,
		  lname varchar(250) NOT NULL,
		  address varchar(500) NOT NULL,
		  address2 varchar(350) NOT NULL,
		  city varchar(150) NOT NULL,
		  state varchar(200) NOT NULL,
		  zip varchar(100) NOT NULL,
		  pnumber varchar(50) NOT NULL,
		  pnumbertype varchar(15) NOT NULL,
		  snumber varchar(50) NOT NULL,
		  snumbertype varchar(15) NOT NULL,
		  email varchar(300) NOT NULL,
		  job varchar(300) NOT NULL,
		  attachment text NOT NULL,
		  cover text NOT NULL,
		  resume text NOT NULL,
		  pubdate datetime NOT NULL,
		  PRIMARY KEY  (id)
		);';
	dbDelta( $sql );
}	


add_option( 'resume_widget_title', 'Resume Submission' );

add_option( 'resume_db_version', $resume_db_version );

// For Settings
add_option( 'resume_captcha', 'Disabled' );
add_option( 'resume_captcha_private_key', '' );
add_option( 'resume_captcha_public_key', '' );
add_option( 'resume_captcha_options', array( 'theme' => 'red', 'lang' => 'en' ) );
add_option( 'resume_form_page', '' );
add_option( 'resume_jobs_page', '' );
add_option( 'resume_use_wpautop', 'true' );
add_option( 'resume_use_tinymce', 'true' );
add_option( 'resume_use_tinymce_qt', 'false' );
add_option( 'resume_thank_you_text', '<p style="color:#008f07;"><b>Thank you for your submission.</b></p>
<p style="color:#008f07;">Your resumé is now stored in our database for future reference.</p>
<p style="color:#008f07;">If you have any questions, please feel free to contact us.</p>' );
add_option( 'resume_attachments', array( 'num' => 3, 'allowed' => 'pdf|doc|docx', 'delete' => 'Enabled' ) );
add_option( 'resume_pdf_base_file', resume_get_plugin_dir( 'path' ) . '/base-files/submission-entry.pdf' );
add_option( 'resume_state_list', array( 'use' => 'US', 'list' => array( 'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 
																		'District Of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 
																		'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 
																		'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 
																		'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 
																		'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 
																		'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming' ) ) );
add_option( 'resume_send_admin_email_to', get_option( 'admin_email' ) );
add_option( 'resume_email_user_from', get_option( 'admin_email' ) );
add_option( 'resume_send_email_to_user', 'Enabled' );
add_option( 'resume_user_email_subject', 'Thank You For Submitting Resume' );
add_option( 'resume_user_email_copy', '<p>Dear %fname%,</p>
<p>We at %siteName% appreciate your interests with us.</p>
<p>If you have met our qualifications, we will contact for further information.</p>
<br/>' );

// Set Input Fields
add_option( 'resume_input_fields', array( 'fname' => array( 1, 1 ), 'lname' => array( 1, 1 ), 'address' => array( 1, 1 ), 'address2' => array( 1, 1 ), 
										  'city' => array( 1, 1 ), 'state' => array( 1, 1 ), 'zip' => array( 1, 1 ), 'pnumber' => array( 1, 1 ), 'snumber' => array( 1, 1 ),
										  'email' => array( 1, 1 ), 'attachment' => array( 1, 0 ), 'cover' => array( 1, 1 ), 'resume' => array( 1, 1 ) ) );



// Remove Old Settings
delete_option( 'resume_show_job_search' );


// Create rsjb upload folder
if( !is_dir( WP_CONTENT_DIR . '/uploads/rsjp/' ) ) {
	mkdir( WP_CONTENT_DIR . '/uploads/rsjp/', 0777, true );
}
if( !is_dir( WP_CONTENT_DIR . '/uploads/rsjp/attachments/' ) ) {
	mkdir( WP_CONTENT_DIR . '/uploads/rsjp/attachments/', 0777, true );
}
if( !is_dir( WP_CONTENT_DIR . '/uploads/rsjp/pdfs/' ) ) {
	mkdir( WP_CONTENT_DIR . '/uploads/rsjp/pdfs/', 0777, true );
}


//***Upgrader***
$installed_ver = get_option( 'resume_db_version' );
if( $installed_ver != $resume_db_version ) {
	
	update_option( 'resume_db_version', $resume_db_version );

	
}
//***** End Installer *****
?>