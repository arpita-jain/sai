<?php
$api_url = 'http://wpbpshop.com/wpbpshop-updates';
$plugin_slug = BUATP_DIR;

add_filter('pre_set_site_transient_update_plugins', 'buatp_check_for_plugin_update',1,1);
function buatp_check_for_plugin_update($checked_data) {
         
	global $api_url, $plugin_slug;
	//var_dump($checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php']); 
	//Comment out these two lines during testing.
	if (empty($checked_data->checked))
            return $checked_data;
	
	$args = array(
		'slug' => $plugin_slug,
		'version' => $checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php'],
	);
	$request_string = array(
			'body' => array(
				'action' => 'basic_check', 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	// Start checking for an update
	$raw_response = wp_remote_post($api_url, $request_string);
	
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);
	
	if (is_object($response) && !empty($response)) // Feed the update data into WP updater
		$checked_data->response[$plugin_slug .'/'. $plugin_slug .'.php'] = $response;
	
	return $checked_data;
}


// Take over the Plugin info screen
add_filter('plugins_api', 'buatp_plugin_api_call', 10, 3);

function buatp_plugin_api_call($def, $action, $args) {
	global $plugin_slug, $api_url;
	
	if ($args->slug != $plugin_slug)
		return false;
	
	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$plugin_slug .'/'. $plugin_slug .'.php'];
	$args->version = $current_version;
	
	$request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	$request = wp_remote_post($api_url, $request_string);
	
	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}
	
	return $res;
}

function buatp_udate_notice(){
    $update_list = get_option('_site_transient_update_plugins',true);
    if(!$update_list)
        return;
    if(!is_object($update_list->response['buddypress-user-account-type-pro/buddypress-user-account-type-pro.php']))
        return;
    $buatp_info = $update_list->response['buddypress-user-account-type-pro/buddypress-user-account-type-pro.php'];
    $update_url = admin_url().'update-core.php';
    if(is_multisite())
        $update_url = admin_url().'network/update-core.php';
    $html = '<div id="buatp_update">
            <p>BuddyPress User Account Type PRO version <strong>'.$buatp_info->new_version.'</strong> released.
               You are using version '.$update_list->checked['buddypress-user-account-type-pro/buddypress-user-account-type-pro.php'].
            ' Please <a href="'.$update_url.'">update</a> it to enjoy new features.
            </p>
            </div>';
    echo $html;
}
add_action('buatp_notices','buatp_udate_notice');
?>