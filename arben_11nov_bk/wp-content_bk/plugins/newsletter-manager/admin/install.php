<?php

function em_install(){
	
	$pluginName = 'xyz-wp-newsletter/xyz-wp-newsletter.php';
	if (is_plugin_active($pluginName)) {
		wp_die( "The plugin Newsletter Manager cannot be activated because you are using the premium version of this plugin. Back to <a href='".admin_url()."plugins.php'>Plugin Installation</a>." );
	}
	
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	
	
	/*update attachment table name field*/
	if(xyz_em_plugin_get_version() == '1.2.2'){
		
		if(get_option('xyz_em_attachments_fix') != 1 ){
			$wpdb->query("UPDATE ".$wpdb->prefix."xyz_em_attachment SET name= CONCAT(id,'_',name)");
			add_option('xyz_em_attachments_fix',1);
		}
		
		
	}
	/*update attachment table name field*/
	
	
	
	if(get_option('xyz_credit_link') == ""){
			add_option("xyz_credit_link",0);
	}
	
	add_option('xyz_em_tinymce_filter',0);
	add_option("xyz_em_hesl",100);
	add_option("xyz_em_dss",'Pending');
	add_option("xyz_em_defaultEditor",'HTML Editor');
	add_option("xyz_em_dse",'admin@yoursite.com');
	add_option("xyz_em_dsn",'Admin');
	add_option("xyz_em_enableWelcomeEmail",'True');
	add_option("xyz_em_enableUnsubNotification",'True');
	add_option("xyz_em_hourly_email_sent_count",0);
	add_option("xyz_em_hourly_reset_time",0);
	
	add_option("xyz_em_cronStartTime",0);
	add_option("xyz_em_CronEndTime",0);
	
	add_option('xyz_em_afterSubscription','');
	add_option('xyz_em_emailConfirmation','');
	add_option('xyz_em_redirectAfterLink','');
	add_option('xyz_em_limit',20);
	add_option('xyz_em_widgetName','Subscribe');
	
	add_option('xyz_em_sendViaSmtp',0);
	add_option('xyz_em_SmtpDebug',0);
	
	
	$xyz_em_email_address = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_em_email_address"');
	if(count($xyz_em_email_address) > 0){
		$wpdb->query("RENAME TABLE xyz_em_email_address TO ".$wpdb->prefix."xyz_em_email_address");
	}else{
			$queryEmailAddress = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_em_email_address (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			`create_time` int(30) NOT NULL,
			`last_update_time` int(30) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
			$wpdb->query($queryEmailAddress);
	}
	$xyz_em_address_list_mapping = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_em_address_list_mapping"');
	if(count($xyz_em_address_list_mapping) > 0){
		$wpdb->query("RENAME TABLE xyz_em_address_list_mapping TO ".$wpdb->prefix."xyz_em_address_list_mapping");
	}else{
			$queryMapping = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_em_address_list_mapping (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`ea_id` bigint(20) NOT NULL,
			`el_id` int(11) NOT NULL,
			`create_time` int(30) NOT NULL,
			`last_update_time` int(30) NOT NULL,
			`status` int(1) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
			$wpdb->query($queryMapping);
	}
	$xyz_em_additional_field_value = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_em_additional_field_value"');
	if(count($xyz_em_additional_field_value) > 0){
		$wpdb->query("RENAME TABLE xyz_em_additional_field_value TO ".$wpdb->prefix."xyz_em_additional_field_value");
	}else{
			$queryFieldValues = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_em_additional_field_value (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`ea_id` int(11) NOT NULL,
			`field1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
			$wpdb->query($queryFieldValues);
	}
	$xyz_em_email_campaign = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_em_email_campaign"');
	if(count($xyz_em_email_campaign) > 0){
		$wpdb->query("RENAME TABLE xyz_em_email_campaign TO ".$wpdb->prefix."xyz_em_email_campaign");
	}else{
			$queryCampaign = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."xyz_em_email_campaign (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`type` int(1) NOT NULL,
			`subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`body` longtext COLLATE utf8_unicode_ci NOT NULL,
			`alt_body` longtext COLLATE utf8_unicode_ci NOT NULL,
			`list_id` int(11) NOT NULL,
			`campaign_template_id` int(11) NOT NULL,
			`status` int(2) NOT NULL,
			`batch_size` int(11) NOT NULL,
			`sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`sender_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`sender_email_id` int(11) NOT NULL,
			`last_send_mapping_id` int(11) NOT NULL,
			`send_count` int(11) NOT NULL,
			`last_fired_time` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			`unsubscription_link` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
			`start_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			`track_count` int(20) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
			$wpdb->query($queryCampaign);
	}
	
	$group_flag=0;
	$tblcolums = mysql_query("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_em_email_campaign");
	while ($row = mysql_fetch_array($tblcolums)){
		if( $row['Field']=="end_time"){
			$group_flag=1;
		}
	}
	if($group_flag==0){
		mysql_query("ALTER TABLE ".$wpdb->prefix."xyz_em_email_campaign ADD (`end_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL )");
		echo mysql_error();
	
	}
	
	
	$xyz_em_attachment = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_em_attachment"');
	if(count($xyz_em_attachment) > 0){
		$wpdb->query("RENAME TABLE xyz_em_attachment TO ".$wpdb->prefix."xyz_em_attachment");
	}else{
			$queryAttachment = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_em_attachment (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`campaigns_id` int(11) NOT NULL,
					`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
			$wpdb->query($queryAttachment);
	}
	$xyz_em_sender_email_address = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_em_sender_email_address"');
	if(count($xyz_em_sender_email_address) > 0){
		$wpdb->query("RENAME TABLE xyz_em_sender_email_address TO ".$wpdb->prefix."xyz_em_sender_email_address");
	}else{
			$querySenderEmailAddress = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."xyz_em_sender_email_address (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `authentication` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `port` int(11) NOT NULL,
			  `security` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `set_default` int(1) NOT NULL,
			  `status` int(1) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
			$wpdb->query($querySenderEmailAddress);
	}
	
	$xyz_em_additional_field_info = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_em_additional_field_info"');
	if(count($xyz_em_additional_field_info) > 0){
		$wpdb->query("RENAME TABLE xyz_em_additional_field_info TO ".$wpdb->prefix."xyz_em_additional_field_info");
	}else{
			$queryFieldInfo = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_em_additional_field_info (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`type` int(1) NOT NULL,
			`default_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`options` longtext COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
			$wpdb->query($queryFieldInfo);
	}
	
	$infoCount = $wpdb->get_results( 'SELECT default_value FROM '.$wpdb->prefix.'xyz_em_additional_field_info' ) ;
	if(count($infoCount) == 0){
		$wpdb->insert($wpdb->prefix.'xyz_em_additional_field_info',array('field_name'=>"Name",'type'=>"0",'default_value'=>"User",'options'=>""),array('%s','%d','%s','%s'));	
	}
	
	
	$xyz_em_email_template = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_em_email_template"');
	if(count($xyz_em_email_template) > 0){
		$wpdb->query("RENAME TABLE xyz_em_email_template TO ".$wpdb->prefix."xyz_em_email_template");
	}else{
			$queryemailTemplate = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_em_email_template (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`subject` text COLLATE utf8_unicode_ci NOT NULL,
			`message` text COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
			$wpdb->query($queryemailTemplate);
	}
	$emailTemplateWelcomeCount = $wpdb->get_results( 'SELECT subject FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=1' ) ;
	if(count($emailTemplateWelcomeCount) == 0){
		
		$wpdb->insert($wpdb->prefix.'xyz_em_email_template',array('id'=>1,'subject'=>"Subscription Active",'message'=>"<p>Hi {field1},</p>\r\n<p>Thank you for subscribing to our list.<br />\r\nYour subscription is active now.</p>\r\n<p>Regards<br />\r\nYoursite.com<br />\r\n&nbsp;</p>"),
				array('%d','%s','%s'));
		
	}
	
	$emailTemplateWelcomeCount = $wpdb->get_results( 'SELECT subject FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=2' ) ;
	if(count($emailTemplateWelcomeCount) == 0){
	
		$wpdb->insert($wpdb->prefix.'xyz_em_email_template',array('id'=>2,'subject'=>"Email Unsubscribed",'message'=>"<p>Hi {field1},</p>\r\n<p>Your email address has been successfully unsubscribed from our list.</p>\r\n<p>Regards<br />\r\nYoursite.com</p>"),
				array('%d','%s','%s'));
	
	}
	
	$emailTemplateWelcomeCount = $wpdb->get_results( 'SELECT subject FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=3' ) ;
	if(count($emailTemplateWelcomeCount) == 0){
	
		$wpdb->insert($wpdb->prefix.'xyz_em_email_template',array('id'=>3,'subject'=>"Subscription Pending",'message'=>'<p>Hi {field1},</p><p>Thank you for subscribing to our list. <br />You are one click away from activating your subscription.<br />Just click the link below to  activate your subscription <br /><i><a href="{confirmation_link}">Confirm now</a></i></p><p>Regards<br />Yoursite.com</p>'),
				array('%d','%s','%s'));
	
	}
	
	
// 	add_option('xyz_em_afterSubscription','');
// 	add_option('xyz_em_emailConfirmation','');
// 	add_option('xyz_em_redirectAfterLink','');
	
	$the_page_unsubscribe = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key='xyz_em_unsubscribe_page' AND meta_value='1'");
		
	if (!$the_page_unsubscribe)
	{
		// Create post object
		$_p = array();
		$_p['post_title']     = "Email Unsubscribed";
		$_p['post_content']   = '[xyz_em_unsubscribe]';
		$_p['post_status']    = 'publish';
		$_p['post_type']      = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status']    = 'closed';
		$_p['post_category'] = array(1); // the default 'Uncatrgorised'
	
		// Insert the post into the database
		$post_id = wp_insert_post($_p);
		$meta_key = 'xyz_em_unsubscribe_page';
		$meta_value = 1;
		add_post_meta($post_id, $meta_key, $meta_value);
		
		$unsubscribeLink = get_permalink( $post_id );
		update_option('xyz_em_redirectAfterLink',$unsubscribeLink);
	}else{
		$the_page_unsubscribe = $the_page_unsubscribe[0];
		$pageIdUnsubscribe = $the_page_unsubscribe->post_id;
// 		$unsubscribeLink = get_permalink( $pageIdUnsubscribe );
// 		update_option('xyz_em_redirectAfterLink',$unsubscribeLink);
		$wpdb->update($wpdb->prefix.'posts', array('post_status'=>'publish'), array('id'=>$pageIdUnsubscribe));
	}
	
	
	$the_page_thanks = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key='xyz_em_thanks_page' AND meta_value='2'");
	
	if (!$the_page_thanks)
	{
		// Create post object
		$_p = array();
		$_p['post_title']     = "Email Subscribed";
		$_p['post_content']   = '[xyz_em_thanks]';
		$_p['post_status']    = 'publish';
		$_p['post_type']      = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status']    = 'closed';
		$_p['post_category'] = array(1); // the default 'Uncatrgorised'
	
		// Insert the post into the database
		$post_id = wp_insert_post($_p);
		$meta_key = 'xyz_em_thanks_page';
		$meta_value = 2;
		add_post_meta($post_id, $meta_key, $meta_value);
		
		$thanksLink = get_permalink( $post_id );
		update_option('xyz_em_afterSubscription',$thanksLink);
		
	}else{
		$the_page_thanks = $the_page_thanks[0];
		$pageIdThanks = $the_page_thanks->post_id;
// 		$thanksLink = get_permalink( $pageIdThanks );
// 		update_option('xyz_em_afterSubscription',$thanksLink);
		$wpdb->update($wpdb->prefix.'posts', array('post_status'=>'publish'), array('id'=>$pageIdThanks));
	}
	
	
	$the_page_confirm = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key='xyz_em_confirm_page' AND meta_value='3'");
	
	if (!$the_page_confirm)
	{
		// Create post object
		$_p = array();
		$_p['post_title']     = "Subscription Confirmed";
		$_p['post_content']   = '[xyz_em_confirm]';
		$_p['post_status']    = 'publish';
		$_p['post_type']      = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status']    = 'closed';
		$_p['post_category'] = array(1); // the default 'Uncatrgorised'
	
		// Insert the post into the database
		$post_id = wp_insert_post($_p);
		$meta_key = 'xyz_em_confirm_page';
		$meta_value = 3;
		add_post_meta($post_id, $meta_key, $meta_value);
		
		$confirmLink = get_permalink( $post_id );
		update_option('xyz_em_emailConfirmation',$confirmLink);
	}else{
		$the_page_confirm = $the_page_confirm[0];
		$pageIdConfirm = $the_page_confirm->post_id;
// 		$confirmLink = get_permalink( $pageIdConfirm );
// 		update_option('xyz_em_emailConfirmation',$confirmLink);
		$wpdb->update($wpdb->prefix.'posts', array('post_status'=>'publish'), array('id'=>$pageIdConfirm));
	}
	
	
	
	//Bug fix:
	$wpdb->query( 'delete from '.$wpdb->prefix.'xyz_em_address_list_mapping WHERE ea_id=0' ) ;
	
	
}

register_activation_hook(XYZ_EM_PLUGIN_FILE,'em_install');

?>