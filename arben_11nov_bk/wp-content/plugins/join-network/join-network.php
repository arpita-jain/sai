<?php
/*Plugin Name: Join Network
Plugin URI: http://www.cisin.com/
Description: Allow Join Network on site
Author: CIS
Author URI: hhttp://www.cisin.com/
Version: 1.1
*/
global $wpdb;

/* Incldue Template File using type of group*/
require_once("inc.php");
/*Admin part is display here*/
if(is_admin())
{
     add_action('admin_menu','join_network_admin_menu');
   
     function join_network_admin_menu()
     {
         add_menu_page('join-network', 'Join Network', 'administrator', 'join-network/join-network.php', 'display_join_now_admin');
	 
         add_filter( 'plugin_action_links', 'plugin_action_links', 10, 2 );
     }   
    
}



/*Pluging custom link*/
function plugin_action_links( $links, $file )
{
		if ( $file == plugin_basename( __FILE__ ) )
			$links[] = '<a href="admin.php?page=join-network">' . __( 'Settings' , 'join-network') . '</a>';
	
		return $links;
}
/*display_join_now_admin function start here*/
function display_join_now_admin()
{
    require(CLASSES_PATH.'/joinnetworkform.php');
    $joinnowoption= new joinnetworkform();
//    foreach ( $rename_options as $old_name => $new_name ) {
//				$old_value = $displayform->joinow_get_option( $old_name );
//				$new_value = $displayform->joinow_get_option( $new_name );
//				if ( NULL === $new_value && NULL !== $old_value ) {
//					$displayform->joinow_set_option( $new_name, $old_value );
//					$displayform->joinow_unset_option( $old_name );
//					$updated = TRUE;
//				}
//			}
if ( isset( $_POST['update_settings'] ) ) {
				//check_admin_referer( 'register-plus-redux-update-settings' );
				update_settings();
				echo '<div id="message" class="updated"><p><strong>', __( 'Settings Saved', 'join-network' ), '</strong></p></div>', "\n";
			}

?>

<div class="wrap">

			<h2><?php _e( 'Join Now Form Settings', 'join-network' ) ?></h2>
			<form method="post">
				<?php //wp_nonce_field( 'register-plus-redux-update-settings' ); ?>
				<table class="form-table">
					<?php if ( !is_multisite() ) { ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'Custom Logo URL', 'register-plus-redux' ); ?></th>
						<td>
							<input type="text" name="custom_logo_url" id="custom_logo_url" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'custom_logo_url' ) ); ?>" style="width: 60%;" /><input type="button" class="button" name="upload_custom_logo_button" id="upload_custom_logo_button" value="<?php esc_attr_e( 'Upload Image', 'register-plus-redux' ); ?>" /><br />
							<?php _e( 'Custom Logo will be shown on Registration and Login Forms in place of the default Wordpress logo. For the best results custom logo should not exceed 350px width.', 'register-plus-redux' ); ?>
							<?php if ( $joinnowoption->joinow_get_option( 'custom_logo_url' ) ) { ?>
								<br /><img src="<?php echo esc_url( $joinnowoption->joinow_get_option( 'custom_logo_url' ) ); ?>" /><br />
								<?php if ( ini_get( 'allow_url_fopen' ) ) list( $custom_logo_width, $custom_logo_height ) = getimagesize( esc_url( $joinnowoption->joinow_get_option( 'custom_logo_url' ) ) ); ?>
								<?php if ( ini_get( 'allow_url_fopen' ) ) echo $custom_logo_width, 'x', $custom_logo_height, '<br />', "\n"; ?>
								<label><input type="checkbox" name="remove_logo" id="remove_logo" value="1" />&nbsp;<?php _e( 'Remove Logo', 'register-plus-redux' ); ?></label><br />
								<?php _e( 'You must Save Changes to remove logo.', 'register-plus-redux' ); ?>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'Email Verification', 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="checkbox" name="verify_user_email" id="verify_user_email" class="showHideSettings" value="1" <?php checked( $joinnowoption->joinow_get_option( 'verify_user_email' ), 1 ); ?> />&nbsp;<?php _e( 'Verify all new users email address...', 'register-plus-redux' ); ?></label><br />
							<?php _e( 'A verification code will be sent to any new users email address, new users will not be able to login or reset their password until they have completed the verification process. Administrators may authorize new users from the Unverified Users Page at their own discretion.', 'register-plus-redux' ); ?>
							<div id="verify_user_email_settings"<?php if ( $joinnowoption->joinow_get_option( 'verify_user_email' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<br /><?php _e( 'The following message will be shown to users after registering. You may include HTML in this message.', 'register-plus-redux' ); ?><br />
								<textarea name="message_verify_user_email" id="message_verify_user_email" rows="2" style="width: 60%; display: block;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'message_verify_user_email' ) ); ?></textarea>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Admin Verification', 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="checkbox" name="verify_user_admin" id="verify_user_admin" class="showHideSettings" value="1" <?php checked( $joinnowoption->joinow_get_option( 'verify_user_admin' ), 1 ); ?> />&nbsp;<?php _e( 'Moderate all new user registrations...', 'register-plus-redux' ); ?></label><br />
							<?php _e( 'New users will not be able to login or reset their password until they have been authorized by an administrator from the Unverified Users Page. If both verification options are enabled, users will not be able to login until an administrator authorizes them, regardless of whether they complete the email verification process.', 'register-plus-redux' ); ?>
							<div id="verify_user_admin_settings"<?php if ( $joinnowoption->joinow_get_option( 'verify_user_admin' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<br /><?php _e( 'The following message will be shown to users after registering (or verifying their email if both verification options are enabled). You may include HTML in this message.', 'register-plus-redux' ); ?><br />
								<textarea name="message_verify_user_admin" id="message_verify_user_admin" rows="2" style="width: 60%; display: block;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'message_verify_user_admin' ) ); ?></textarea>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Grace Period', 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="text" name="delete_unverified_users_after" id="delete_unverified_users_after" style="width:50px;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'delete_unverified_users_after' ) ); ?>" />&nbsp;<?php _e( 'days', 'register-plus-redux' ); ?></label><br />
							<?php _e( 'All unverified users will automatically be deleted after the Grace Period specified, to disable this process enter 0 to never automatically delete unverified users.', 'register-plus-redux' ); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Registration Redirect', 'register-plus-redux' ); ?></th>
						<td>
							<input type="text" name="registration_redirect_url" id="registration_redirect_url" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'registration_redirect_url' ) ); ?>" style="width: 60%;" /><br />
							<?php echo sprintf( __( 'By default, after registering, users will be sent to %s/wp-login.php?checkemail=registered, leave this value empty if you do not wish to change this behavior. You may enter another address here, however, if that address is not on the same domain, Wordpress will ignore the redirect.', 'register-plus-redux' ), home_url() ); ?><br />
						</td>
					</tr>
					<tr valign="top" class="disabled" style="display: none;">
						<th scope="row"><?php _e( 'Verification Redirect', 'register-plus-redux' ); ?></th>
						<td>
							<input type="text" name="verification_redirect_url" id="verification_redirect_url" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'verification_redirect_url' ) ); ?>" style="width: 60%;" /><br />
							<?php echo sprintf( __( 'By default, after verifying, users will be sent to %s/wp-login.php, leave this value empty if you do not wish to change this behavior. You may enter another address here, however, if that addresses is not on the same domain, Wordpress will ignore the redirect.', 'register-plus-redux' ), home_url() ); ?><br />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Autologin user', 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="checkbox" name="autologin_user" id="autologin_user" value="1" <?php checked( $joinnowoption->joinow_get_option( 'autologin_user' ), 1 ); ?>/>&nbsp;<?php _e( 'Autologin user after registration.', 'register-plus-redux' ); ?></label><br />
							<?php echo sprintf( __( 'Works if Email Verification and Admin Verification are turned off. By default users will be sent to %s, to change this behavior, set up Registration Redirect field above.', 'register-plus-redux' ), admin_url() ); ?>
						</td>
					</tr>						
				</table>
				<?php if ( !is_multisite() ) { ?>
				<h3 class="title"><?php _e( 'Registration Form', 'register-plus-redux' ); ?></h3>
				<p><?php _e( 'Select which fields to show on the Registration Form. Users will not be able to register without completing any fields marked required.', 'register-plus-redux' ); ?></p>
				<?php } else { ?>
				<h3 class="title"><?php _e( 'Signup Form', 'register-plus-redux' ); ?></h3>
				<p><?php _e( 'Select which fields to show on the Signup Form. Users will not be able to signup without completing any fields marked required.', 'register-plus-redux' ); ?></p>
				<?php } ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Use Email as Username', 'register-plus-redux' ); ?></th>
						<td><label><input type="checkbox" name="username_is_email" id="username_is_email" value="1" <?php checked( $joinnowoption->joinow_get_option( 'username_is_email' ), 1 ); ?> />&nbsp;<?php _e( 'New users will not be asked to enter a username, instead their email address will be used as their username.', 'register-plus-redux' ); ?></label></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Confirm Email', 'register-plus-redux' ); ?></th>
						<td><label><input type="checkbox" name="double_check_email" id="double_check_email" value="1" <?php checked( $joinnowoption->joinow_get_option( 'double_check_email' ), 1 ); ?> />&nbsp;<?php _e( 'Require new users to enter e-mail address twice during registration.', 'register-plus-redux' ); ?></label></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Profile Fields', 'register-plus-redux' ); ?></th>
						<td>
							<table>
								<thead valign="top">
									<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"></td>
									<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><?php _e( 'Show', 'register-plus-redux' ); ?></td>
									<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><?php _e( 'Require', 'register-plus-redux' ); ?></td>
								</thead>
								<tbody>
									<tr valign="center">
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><?php _e( 'First Name', 'register-plus-redux' ); ?></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="show_fields[]" id="show_fields[]" value="first_name" <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && in_array( 'first_name', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'checked="checked"'; ?> class="modifyNextCellCheckbox" /></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="required_fields[]" id="required_fields[]" value="first_name" <?php if ( is_array( $joinnowoption->joinow_get_option( 'required_fields' ) ) && in_array( 'first_name', $joinnowoption->joinow_get_option( 'required_fields' ) ) ) echo 'checked="checked"'; ?> <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && !in_array( 'first_name', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'disabled="disabled"'; ?> /></td>
									</tr>
									<tr valign="center">
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><?php _e( 'Last Name', 'register-plus-redux' ); ?></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="show_fields[]" id="show_fields[]" value="last_name" <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && in_array( 'last_name', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'checked="checked"'; ?> class="modifyNextCellCheckbox" /></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="required_fields[]" id="required_fields[]" value="last_name" <?php if ( is_array( $joinnowoption->joinow_get_option( 'required_fields' ) ) && in_array( 'last_name', $joinnowoption->joinow_get_option( 'required_fields' ) ) ) echo 'checked="checked"'; ?> <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && !in_array( 'last_name', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'disabled="disabled"'; ?> /></td>
									</tr>
									<tr valign="center">
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><?php _e( 'Website', 'register-plus-redux' ); ?></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="show_fields[]" id="show_fields[]" value="user_url" <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && in_array( 'user_url', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'checked="checked"'; ?> class="modifyNextCellCheckbox" /></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="required_fields[]" id="required_fields[]" value="user_url" <?php if ( is_array( $joinnowoption->joinow_get_option( 'required_fields' ) ) && in_array( 'user_url', $joinnowoption->joinow_get_option( 'required_fields' ) ) ) echo 'checked="checked"'; ?> <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && !in_array( 'user_url', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'disabled="disabled"'; ?> /></td>
									</tr>
									<tr valign="center">
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><?php _e( 'AIM', 'register-plus-redux' ); ?></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="show_fields[]" id="show_fields[]" value="aim" <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && in_array( 'aim', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'checked="checked"'; ?> class="modifyNextCellCheckbox" /></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="required_fields[]" id="required_fields[]" value="aim" <?php if ( is_array( $joinnowoption->joinow_get_option( 'required_fields' ) ) && in_array( 'aim', $joinnowoption->joinow_get_option( 'required_fields' ) ) ) echo 'checked="checked"'; ?> <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && !in_array( 'aim', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'disabled="disabled"'; ?> /></td>
									</tr>
									<tr valign="center">
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><?php _e( 'Yahoo IM', 'register-plus-redux' ); ?></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="show_fields[]" id="show_fields[]" value="yahoo" <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && in_array( 'yahoo', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'checked="checked"'; ?> class="modifyNextCellCheckbox" /></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="required_fields[]" id="required_fields[]" value="yahoo" <?php if ( is_array( $joinnowoption->joinow_get_option( 'required_fields' ) ) && in_array( 'yahoo', $joinnowoption->joinow_get_option( 'required_fields' ) ) ) echo 'checked="checked"'; ?> <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && !in_array( 'yahoo', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'disabled="disabled"'; ?> /></td>
									</tr>
									<tr valign="center">
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><?php _e( 'Jabber / Google Talk', 'register-plus-redux' ); ?></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="show_fields[]" id="show_fields[]" value="jabber" <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && in_array( 'jabber', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'checked="checked"'; ?> class="modifyNextCellCheckbox" /></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="required_fields[]" id="required_fields[]" value="jabber" <?php if ( is_array( $joinnowoption->joinow_get_option( 'required_fields' ) ) && in_array( 'jabber', $joinnowoption->joinow_get_option( 'required_fields' ) ) ) echo 'checked="checked"'; ?> <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && !in_array( 'jabber', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'disabled="disabled"'; ?> /></td>
									</tr>
									<tr valign="center">
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><?php _e( 'About Yourself', 'register-plus-redux' ); ?></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="show_fields[]" id="show_fields[]" value="about" <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && in_array( 'about', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'checked="checked"'; ?> class="modifyNextCellCheckbox" /></td>
										<td align="center" style="padding-top: 0px; padding-bottom: 0px;"><input type="checkbox" name="required_fields[]" id="required_fields[]" value="about" <?php if ( is_array( $joinnowoption->joinow_get_option( 'required_fields' ) ) && in_array( 'about', $joinnowoption->joinow_get_option( 'required_fields' ) ) ) echo 'checked="checked"'; ?> <?php if ( is_array( $joinnowoption->joinow_get_option( 'show_fields' ) ) && !in_array( 'about', $joinnowoption->joinow_get_option( 'show_fields' ) ) ) echo 'disabled="disabled"'; ?> /></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'User Set Password', 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="checkbox" name="user_set_password" id="user_set_password" value="1" <?php checked( $joinnowoption->joinow_get_option( 'user_set_password' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Require new users enter a password during registration...', 'register-plus-redux' ); ?></label><br />
							<div id="password_settings"<?php if ( $joinnowoption->joinow_get_option( 'user_set_password' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<label><?php _e( 'Minimum password length: ', 'register-plus-redux' ); ?><input type="text" name="min_password_length" id="min_password_length" style="width:50px;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'min_password_length' ) ); ?>" /></label><br />
								<label><input type="checkbox" name="disable_password_confirmation" id="disable_password_confirmation" value="1" <?php checked( $joinnowoption->joinow_get_option( 'disable_password_confirmation' ), 1 ); ?>/>&nbsp;<?php _e( 'Do not require users to confirm password.', 'register-plus-redux' ); ?></label><br />
								<label><input type="checkbox" name="show_password_meter" id="show_password_meter" value="1" <?php checked( $joinnowoption->joinow_get_option( 'show_password_meter' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Show password strength meter...', 'register-plus-redux' ); ?></label>
								<div id="meter_settings"<?php if ( $joinnowoption->joinow_get_option( 'show_password_meter' ) == FALSE ) echo ' style="display: none;"'; ?>>
									<table>
										<tr>
											<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="message_empty_password"><?php _e( 'Empty', 'register-plus-redux' ); ?></label></td>
											<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="message_empty_password" id="message_empty_password" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_empty_password' ) ); ?>" /></td>
										</tr>
										<tr>
											<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="message_short_password"><?php _e( 'Short', 'register-plus-redux' ); ?></label></td>
											<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="message_short_password" id="message_short_password" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_short_password' ) ); ?>" /></td>
										</tr>
										<tr>
											<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="message_bad_password"><?php _e( 'Bad', 'register-plus-redux' ); ?></label></td>
											<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="message_bad_password" id="message_bad_password" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_bad_password' ) ); ?>" /></td>
										</tr>
										<tr>
											<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="message_good_password"><?php _e( 'Good', 'register-plus-redux' ); ?></label></td>
											<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="message_good_password" id="message_good_password" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_good_password' ) ); ?>" /></td>
										</tr>
										<tr>
											<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="message_strong_password"><?php _e( 'Strong', 'register-plus-redux' ); ?></label></td>
											<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="message_strong_password" id="message_strong_password" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_strong_password' ) ); ?>" /></td>
										</tr>
										<tr>
											<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="message_mismatch_password"><?php _e( 'Mismatch', 'register-plus-redux' ); ?></label></td>
											<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="message_mismatch_password" id="message_mismatch_password" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_mismatch_password' ) ); ?>" /></td>
										</tr>
									</table>
								</div>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Invitation Code', 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="checkbox" name="enable_invitation_code" id="enable_invitation_code" value="1" <?php checked( $joinnowoption->joinow_get_option( 'enable_invitation_code' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Use invitation codes to track or authorize new user registration...', 'register-plus-redux' ); ?></label>
							<div id="invitation_code_settings"<?php if ( $joinnowoption->joinow_get_option( 'enable_invitation_code' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<label><input type="checkbox" name="require_invitation_code" id="require_invitation_code" value="1" <?php checked( $joinnowoption->joinow_get_option( 'require_invitation_code' ), 1 ); ?> />&nbsp;<?php _e( 'Require new user enter one of the following invitation codes to register.', 'register-plus-redux' ); ?></label><br />
								<label><input type="checkbox" name="invitation_code_case_sensitive" id="invitation_code_case_sensitive" value="1" <?php checked( $joinnowoption->joinow_get_option( 'invitation_code_case_sensitive' ), 1 ); ?> />&nbsp;<?php _e( 'Enforce case-sensitivity of invitation codes.', 'register-plus-redux' ); ?></label><br />
								<label><input type="checkbox" name="invitation_code_unique" id="invitation_code_unique" value="1" <?php checked( $joinnowoption->joinow_get_option( 'invitation_code_unique' ), 1 ); ?> />&nbsp;<?php _e( 'Each invitation code may only be used once.', 'register-plus-redux' ); ?></label><br />
								<label><input type="checkbox" name="enable_invitation_tracking_widget" id="enable_invitation_tracking_widget" value="1" <?php checked( $joinnowoption->joinow_get_option( 'enable_invitation_tracking_widget' ), 1 ); ?> />&nbsp;<?php _e( 'Show Invitation Code Tracking widget on Dashboard.', 'register-plus-redux' ); ?></label><br />
								<div id="invitation_code_bank">
								<?php
									$invitation_code_bank = get_option( 'register_plus_redux_invitation_code_bank-rv1' );
									if ( is_array( $invitation_code_bank ) ) {
										$size = sizeof( $invitation_code_bank );
										for ( $x = 0; $x < $size; $x++ ) {
											echo "\n", '<div class="invitation_code"';
											if ( $x > 5 ) echo ' style="display: none;"';
											echo '><input type="text" name="invitation_code_bank[]" id="invitation_code_bank[]" value="', esc_attr( $invitation_code_bank[$x] ) , '" />&nbsp;<img src="', plugins_url( 'images\minus-circle.png', __FILE__ ), '" alt="', esc_attr__( 'Remove Code', 'register-plus-redux' ), '" title="', esc_attr__( 'Remove Code', 'register-plus-redux' ), '" class="removeInvitationCode" style="cursor: pointer;" /></div>';
										}
										if ( $size > 5 ) {
											echo '<div id="showHiddenInvitationCodes" style="cursor: pointer;">', sprintf( _n( 'Show %d hidden invitation code', 'Show %d hidden invitation codes', ( $size - 5 ), 'register-plus-redux' ), ( $size - 5 ) ), '</div>';
											//echo '<div id="showHiddenInvitationCodes" style="cursor: pointer;">', sprintf( __( 'Show %d hidden invitation codes', 'register-plus-redux' ), ( $size - 5 ) ), '</div>';
										}
									}
								?>
								</div>
								<img src="<?php echo plugins_url( 'images\plus-circle.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Add Code', 'register-plus-redux' ) ?>" title="<?php esc_attr_e( 'Add Code', 'register-plus-redux' ) ?>" id="addInvitationCode" style="cursor: pointer;" />&nbsp;<?php _e( 'Add a new invitation code', 'register-plus-redux' ) ?><br />
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Disclaimer', 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="checkbox" name="show_disclaimer" id="show_disclaimer" value="1" <?php checked( $joinnowoption->joinow_get_option( 'show_disclaimer' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Show Disclaimer during registration...', 'register-plus-redux' ); ?></label>
							<div id="disclaimer_settings"<?php if ( $joinnowoption->joinow_get_option( 'show_disclaimer' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<table width="60%">
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; width: 40%;">
											<label for="message_disclaimer_title"><?php _e( 'Disclaimer Title', 'register-plus-redux' ); ?></label>
										</td>
										<td style="padding-top: 0px; padding-bottom: 0px;">
											<input type="text" name="message_disclaimer_title" id="message_disclaimer_title" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_disclaimer_title' ) ); ?>" style="width: 100%;" />
										</td>
									</tr>
									<tr>
										<td colspan="2" style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label for="message_disclaimer"><?php _e( 'Disclaimer Content', 'register-plus-redux' ); ?></label><br />
											<textarea name="message_disclaimer" id="message_disclaimer" style="width: 100%; height: 160px; display: block;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'message_disclaimer' ) ); ?></textarea>
										</td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label><input type="checkbox" name="require_disclaimer_agree" id="require_disclaimer_agree" class="enableDisableText" value="1" <?php checked( $joinnowoption->joinow_get_option( 'require_disclaimer_agree' ), 1 ); ?> />&nbsp;<?php _e( 'Require Agreement', 'register-plus-redux' ); ?></label>
										</td>
										<td style="padding-top: 0px; padding-bottom: 0px;">
											<input type="text" name="message_disclaimer_agree" id="message_disclaimer_agree" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_disclaimer_agree' ) ); ?>" <?php if ( $joinnowoption->joinow_get_option( 'require_disclaimer_agree' ) == FALSE ) echo 'readonly="readonly"'; ?> style="width: 100%;" />
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'License Agreement' , 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="checkbox" name="show_license" id="show_license" value="1" <?php checked( $joinnowoption->joinow_get_option( 'show_license' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Show License Agreement during registration...', 'register-plus-redux' ); ?></label>
							<div id="license_settings"<?php if ( $joinnowoption->joinow_get_option( 'show_license' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<table width="60%">
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; width: 40%;">
											<label for="message_license_title"><?php _e( 'License Agreement Title', 'register-plus-redux' ); ?></label>
										</td>
										<td style="padding-top: 0px; padding-bottom: 0px;">
											<input type="text" name="message_license_title" id="message_license_title" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_license_title' ) ); ?>" style="width: 100%;" />
										</td>
									</tr>
									<tr>
										<td colspan="2" style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label for="message_license"><?php _e( 'License Agreement Content', 'register-plus-redux' ); ?></label><br />
											<textarea name="message_license" id="message_license" style="width: 100%; height: 160px; display: block;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'message_license' ) ); ?></textarea>
										</td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label><input type="checkbox" name="require_license_agree" id="require_license_agree" class="enableDisableText" value="1" <?php checked( $joinnowoption->joinow_get_option( 'require_license_agree' ), 1 ); ?> />&nbsp;<?php _e( 'Require Agreement', 'register-plus-redux' ); ?></label>
										</td>
										<td style="padding-top: 0px; padding-bottom: 0px;">
											<input type="text" name="message_license_agree" id="message_license_agree" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_license_agree' ) ); ?>" <?php if ( $joinnowoption->joinow_get_option( 'require_license_agree' ) == FALSE ) echo 'readonly="readonly"'; ?> style="width: 100%;" />
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Privacy Policy', 'register-plus-redux' ); ?></th>
						<td>
							<label><input type="checkbox" name="show_privacy_policy" id="show_privacy_policy" value="1" <?php checked( $joinnowoption->joinow_get_option( 'show_privacy_policy' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Show Privacy Policy during registration...', 'register-plus-redux' ); ?></label>
							<div id="privacy_policy_settings"<?php if ( $joinnowoption->joinow_get_option( 'show_privacy_policy' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<table width="60%">
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; width: 40%;">
											<label for="message_privacy_policy_title"><?php _e( 'Privacy Policy Title', 'register-plus-redux' ); ?></label>
										</td>
										<td style="padding-top: 0px; padding-bottom: 0px;">
											<input type="text" name="message_privacy_policy_title" id="message_privacy_policy_title" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_privacy_policy_title' ) ); ?>" style="width: 100%;" />
										</td>
									</tr>
									<tr>
										<td colspan="2" style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label for="message_privacy_policy"><?php _e( 'Privacy Policy Content', 'register-plus-redux' ); ?></label><br />
											<textarea name="message_privacy_policy" id="message_privacy_policy" style="width: 100%; height: 160px; display: block;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'message_privacy_policy' ) ); ?></textarea>
										</td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label><input type="checkbox" name="require_privacy_policy_agree" id="require_privacy_policy_agree" class="enableDisableText" value="1" <?php checked( $joinnowoption->joinow_get_option( 'require_privacy_policy_agree' ), 1 ); ?> />&nbsp;<?php _e( 'Require Agreement', 'register-plus-redux' ); ?></label>
										</td>
										<td style="padding-top: 0px; padding-bottom: 0px;">
											<input type="text" name="message_privacy_policy_agree" id="message_privacy_policy_agree" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'message_privacy_policy_agree' ) ); ?>" <?php if ( $joinnowoption->joinow_get_option( 'require_privacy_policy_agree' ) == FALSE ) echo 'readonly="readonly"'; ?> style="width: 100%;" />
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Use Default Style Rules', 'register-plus-redux' ); ?></th>
						<td><label><input type="checkbox" name="default_css" id="default_css" value="1" <?php checked( $joinnowoption->joinow_get_option( 'default_css' ), 1 ); ?> />&nbsp;<?php _e( 'Apply default Wordpress styling to all fields.', 'register-plus-redux' ); ?></label></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Required Fields Style Rules', 'register-plus-redux' ); ?></th>
						<td><input type="text" name="required_fields_style" id="required_fields_style" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'required_fields_style' ) ); ?>" style="width: 60%;" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Required Fields Asterisk', 'register-plus-redux' ); ?></th>
						<td><label><input type="checkbox" name="required_fields_asterisk" id="required_fields_asterisk" value="1" <?php checked( $joinnowoption->joinow_get_option( 'required_fields_asterisk' ), 1 ); ?> />&nbsp;<?php _e( 'Add asterisk to left of all required field\'s name.', 'register-plus-redux' ); ?></label></td>
					</tr>
					<?php if ( !is_multisite() ) { ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'Starting Tabindex', 'register-plus-redux' ); ?></th>
						<td>
							<input type="text" name="starting_tabindex" id="starting_tabindex" style="width:50px;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'starting_tabindex' ) ); ?>" /><br />
							<?php _e( 'The first field added will have this tabindex, the tabindex will increment by 1 for each additional field. Enter 0 to remove all tabindex\'s.', 'register-plus-redux' ); ?>
						</td>
					</tr>
					<?php } ?>
				</table>
				<h3 class="title"><?php _e( 'Additional Fields', 'register-plus-redux' ); ?></h3>
				<p><?php _e( 'Enter additional fields to show on the User Profile and/or Registration Pages. Additional fields will be shown after existing profile fields on User Profile, and after selected profile fields on Registration Page but before Password, Invitation Code, Disclaimer, License Agreement, or Privacy Policy (if any of those fields are enabled). Options must be entered for Select, Checkbox, and Radio fields. Options should be entered with commas separating each possible value. For example, a Radio field named "Gender" could have the following options, "Male,Female".', 'register-plus-redux' ); ?></p>
				<table id="meta_fields" style="padding-left: 0px; width: 90%;">
					<tbody class="fields">
						<?php
						$redux_usermeta = get_option( 'register_plus_redux_usermeta-rv2' );
						if ( is_array( $redux_usermeta ) ) {
							foreach ( $redux_usermeta as $index => $meta_field ) {
								echo "\n", '<tr><td>';
		
								echo "\n", '<table>';
	
								echo "\n", '<tr class="label"><td><img src="', plugins_url( 'images\arrow-move.png', __FILE__ ), '" alt="', esc_attr__( 'Reorder', 'register-plus-redux' ), '" title="', esc_attr__( 'Drag to Reorder', 'register-plus-redux' ), '" class="sortHandle" style="cursor: move;" />&nbsp;<input type="text" name="label[', $index, ']" id="label[', $index, ']" value="', esc_attr( $meta_field['label'] ), '" />&nbsp;<span class="enableDisableFieldSettings" style="color:#0000FF; cursor: pointer;">', __( 'Show Settings', 'register-plus-redux' ), '</span></td></tr>';
								echo "\n", '<tr class="settings" style="display: none;"><td>';
		
								echo "\n", '<table>';
	
								echo "\n", '<tr><td>', __( 'Display', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><select name="display[', $index, ']" id="display[', $index, ']" class="enableDisableOptions" style="width: 100%;">';
								echo "\n", '<option value="textbox"', selected( $meta_field['display'], 'textbox', FALSE ), '>', __( 'Textbox Field', 'register-plus-redux' ), '</option>';
								echo "\n", '<option value="select"', selected( $meta_field['display'], 'select', FALSE ), '>', __( 'Select Field', 'register-plus-redux' ), '</option>';
								echo "\n", '<option value="checkbox"', selected( $meta_field['display'], 'checkbox', FALSE ), '>', __( 'Checkbox Fields', 'register-plus-redux' ), '</option>';
								echo "\n", '<option value="radio"', selected( $meta_field['display'], 'radio', FALSE ), '>', __( 'Radio Fields', 'register-plus-redux' ), '</option>';
								echo "\n", '<option value="textarea"', selected( $meta_field['display'], 'textarea', FALSE ), '>', __( 'Text Area', 'register-plus-redux' ), '</option>';
								echo "\n", '<option value="hidden"', selected( $meta_field['display'], 'hidden', FALSE ), '>', __( 'Hidden Field', 'register-plus-redux' ), '</option>';
								echo "\n", '<option value="text"', selected( $meta_field['display'], 'text', FALSE ), '>', __( 'Static Text', 'register-plus-redux' ), '</option>';
								echo "\n", '<option value="terms"', selected( $meta_field['display'], 'terms', FALSE ), '>', __( 'Terms', 'register-plus-redux' ), '</option>';
								echo "\n", '</select></td></tr>';
		
								echo "\n", '<tr><td>', __( 'Options', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><input type="text" name="options[', $index, ']" id="options[', $index, ']" value="', esc_attr( $meta_field['options'] ), '"'; if ( 'textbox' !== $meta_field['display'] && 'select' !== $meta_field['display'] && 'checkbox' !== $meta_field['display'] && 'radio' !== $meta_field['display'] ) echo ' readonly="readonly"'; echo ' style="width: 100%;" /></td></tr>';
		
								echo "\n", '<tr><td>', __( 'Database Key', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><input type="text" name="meta_key[', $index, ']" id="meta_key[', $index, ']" value="', esc_attr( $meta_field['meta_key'] ), '" style="width: 100%;" /></td></tr>';
		
								echo "\n", '<tr><td>', __( 'Show on Profile', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><input type="checkbox" name="show_on_profile[', $index, ']" id="show_on_profile[', $index, ']" value="1"', checked( $meta_field['show_on_profile'], 1 ), ' /></td></tr>';
		
								echo "\n", '<tr><td>', __( 'Show on Registration', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><input type="checkbox" name="show_on_registration[', $index, ']" id="show_on_registration[', $index, ']" value="1"', checked( $meta_field['show_on_registration'], 1 ), ' class="modifyNextRowCheckbox" /></td></tr>';
		
								echo "\n", '<tr><td>', __( 'Required Field', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><input type="checkbox" name="require_on_registration[', $index, ']" id="require_on_registration[', $index, ']" value="1"', checked( $meta_field['require_on_registration'], 1 ), ' ', disabled( empty( $meta_field['show_on_registration'] ), TRUE, FALSE ), ' /></td></tr>';
		
								echo "\n", '<tr><td>', __( 'Show Datepicker', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><input type="checkbox" name="show_datepicker[', $index, ']" id="show_datepicker[', $index, ']" value="1"', checked( $meta_field['show_datepicker'], 1 ), ' ', disabled( $meta_field['display'] === 'textbox', FALSE, FALSE ), ' /></td></tr>';

								echo "\n", '<tr><td>', __( 'Terms Content', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><textarea name="terms_content[', $index, ']" id="terms_content[', $index, ']" style="width: 100%; height: 160px; display: block;">', esc_textarea( $meta_field['terms_content'] ),'</textarea></td></tr>';

								echo "\n", '<tr><td>', __( 'Terms Agreement Text', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><input type="text" name="terms_agreement_text[', $index, ']" id="terms_agreement_text[', $index, ']" value="', esc_attr( $meta_field['terms_agreement_text'] ), '"'; if ( 'terms' !== $meta_field['display'] ) echo ' readonly="readonly"'; echo ' style="width: 100%;" /></td></tr>';

								echo "\n", '<tr><td>', __( 'Revised', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><input type="text" name="date_revised[', $index, ']" id="date_revised[', $index, ']" class="datepicker" value="', date( "m/d/Y", $meta_field['date_revised'] ), '"'; if ( 'terms' !== $meta_field['display'] ) echo ' readonly="readonly"'; echo ' style="width: 100%;" /></td></tr>';

								echo "\n", '<tr><td>', __( 'Actions', 'register-plus-redux' ), '</td>';
								echo "\n", '<td><img src="', plugins_url( 'images\question.png', __FILE__ ), '" alt="', esc_attr__( 'Help', 'register-plus-redux' ), '" title="', esc_attr__( 'No help available', 'register-plus-redux' ), '" class="helpButton" style="cursor: pointer;" />';
								echo "\n", '<img src="', plugins_url( 'images\minus-circle.png', __FILE__ ), '" alt="', esc_attr__( 'Remove', 'register-plus-redux' ), '" title="', esc_attr__( 'Remove Field', 'register-plus-redux' ), '" class="removeButton" style="cursor: pointer;" /></td></tr>';
								echo "\n", '</table>';
		
								echo "\n", '</td></tr>';
								echo "\n", '</table>';
		
								echo "\n", '</td></tr>';
							}
						}
						?>
					</tbody>
				</table>				
				<h3 class="title"><?php _e( 'Autocomplete URL', 'register-plus-redux' ); ?></h3>
				<p><?php _e( 'You can create a URL to autocomplete specific fields for the user. Additional fields use the database key. Included below are available keys and an example URL.', 'register-plus-redux' ); ?></p>
				<p><code>user_login user_email first_name last_name user_url aim yahoo jabber description invitation_code<?php if ( is_array( $redux_usermeta ) ) { foreach ( $redux_usermeta as $meta_field ) echo ' ', $meta_field['meta_key']; } ?></code></p>
				<p><code>http://www.radiok.info/wp-login.php?action=register&user_login=radiok&user_email=radiok@radiok.info&first_name=Radio&last_name=K&user_url=www.radiok.info&aim=radioko&invitation_code=1979&middle_name=Billy</code></p>
				<?php if ( !is_multisite() ) { ?>
				<h3 class="title"><?php _e( 'New User Message Settings', 'register-plus-redux' ); ?></h3>
				<table class="form-table"> 
					<tr valign="top">
						<th scope="row"><label><?php _e( 'New User Message', 'register-plus-redux' ); ?></label></th>
						<td>
							<label><input type="checkbox" name="disable_user_message_registered" id="disable_user_message_registered" value="1" <?php checked( $joinnowoption->joinow_get_option( 'disable_user_message_registered' ), 1 ); ?> />&nbsp;<?php _e( 'Do NOT send user an email after they are registered', 'register-plus-redux' ); ?></label><br />
							<label><input type="checkbox" name="disable_user_message_created" id="disable_user_message_created" value="1" <?php checked( $joinnowoption->joinow_get_option( 'disable_user_message_created' ), 1 ); ?> />&nbsp;<?php _e( 'Do NOT send user an email when created by an administrator', 'register-plus-redux' ); ?></label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label><?php _e( 'Custom New User Message', 'register-plus-redux' ); ?></label></th>
						<td>
							<label><input type="checkbox" name="custom_user_message" id="custom_user_message" value="1" <?php checked( $joinnowoption->joinow_get_option( 'custom_user_message' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Enable...', 'register-plus-redux' ); ?></label>
							<div id="custom_user_message_settings"<?php if ( $joinnowoption->joinow_get_option( 'custom_user_message' ) == FALSE ) echo ' style="display: none;"'; ?>>

								<table width="60%">
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; width: 20%;"><label for="user_message_from_email"><?php _e( 'From Email', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="user_message_from_email" id="user_message_from_email" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'user_message_from_email' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="user_message_from_name"><?php _e( 'From Name', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="user_message_from_name" id="user_message_from_name" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'user_message_from_name' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="user_message_subject"><?php _e( 'Subject', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="user_message_subject" id="user_message_subject" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'user_message_subject' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td colspan="2" style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label for="user_message_body"><?php _e( 'User Message', 'register-plus-redux' ); ?></label><br />
											<textarea name="user_message_body" id="user_message_body" style="width: 95%; height: 160px;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'user_message_body' ) ); ?></textarea><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /><br />
											<strong><?php _e( 'Replacement Keywords', 'register-plus-redux' ); ?>:</strong> <?php echo $joinnowoption->replace_keywords( NULL, NULL ); ?><br />
											<label><input type="checkbox" name="send_user_message_in_html" id="send_user_message_in_html" value="1" <?php checked( $joinnowoption->joinow_get_option( 'send_user_message_in_html' ), 1 ); ?> />&nbsp;<?php _e( 'Send as HTML', 'register-plus-redux' ); ?></label><br />
											<label><input type="checkbox" name="user_message_newline_as_br" id="user_message_newline_as_br" value="1" <?php checked( $joinnowoption->joinow_get_option( 'user_message_newline_as_br' ), 1 ); ?> />&nbsp;<?php _e( 'Convert new lines to &lt;br /&gt; tags (HTML only)', 'register-plus-redux' ); ?></label>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label><?php _e( 'Custom Verification Message', 'register-plus-redux' ); ?></label></th>
						<td>
							<label><input type="checkbox" name="custom_verification_message" id="custom_verification_message" value="1" <?php checked( $joinnowoption->joinow_get_option( 'custom_verification_message' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Enable...', 'register-plus-redux' ); ?></label>
							<div id="custom_verification_message_settings"<?php if ( $joinnowoption->joinow_get_option( 'custom_verification_message' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<table width="60%">
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; width: 20%;"><label for="verification_message_from_email"><?php _e( 'From Email', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="verification_message_from_email" id="verification_message_from_email" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'verification_message_from_email' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="verification_message_from_name"><?php _e( 'From Name', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="verification_message_from_name" id="verification_message_from_name" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'verification_message_from_name' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="verification_message_subject"><?php _e( 'Subject', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="verification_message_subject" id="verification_message_subject" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'verification_message_subject' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td colspan="2" style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label for="verification_message_body"><?php _e( 'User Message', 'register-plus-redux' ); ?></label><br />
											<textarea name="verification_message_body" id="verification_message_body" style="width: 95%; height: 160px;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'verification_message_body' ) ); ?></textarea><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /><br />
											<strong><?php _e( 'Replacement Keywords', 'register-plus-redux' ); ?>:</strong> <?php echo $joinnowoption->replace_keywords( NULL, NULL ); ?><br />
											<label><input type="checkbox" name="send_verification_message_in_html" id="send_verification_message_in_html" value="1" <?php checked( $joinnowoption->joinow_get_option( 'send_verification_message_in_html' ), 1 ); ?> />&nbsp;<?php _e( 'Send as HTML', 'register-plus-redux' ); ?></label><br />
											<label><input type="checkbox" name="verification_message_newline_as_br" id="verification_message_newline_as_br" value="1" <?php checked( $joinnowoption->joinow_get_option( 'verification_message_newline_as_br' ), 1 ); ?> />&nbsp;<?php _e( 'Convert new lines to &lt;br /&gt; tags (HTML only)', 'register-plus-redux' ); ?></label>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label><?php _e( 'Summary', 'register-plus-redux' ); ?></label></th>
						<td>
							<span id="user_message_summary"></span>
						</td>
					</tr>
				</table>
				<h3 class="title"><?php _e( 'Admin Notification Settings', 'register-plus-redux' ); ?></h3>
				<table class="form-table"> 
					<tr valign="top">
						<th scope="row"><label><?php _e( 'Admin Notification', 'register-plus-redux' ); ?></label></th>
						<td>
							<label><input type="checkbox" name="disable_admin_message_registered" id="disable_admin_message_registered" value="1" <?php checked( $joinnowoption->joinow_get_option( 'disable_admin_message_registered' ), 1 ); ?> />&nbsp;<?php _e( 'Do NOT send administrator an email whenever a new user registers', 'register-plus-redux' ); ?></label><br />
							<label><input type="checkbox" name="disable_admin_message_created" id="disable_admin_message_created" value="1" <?php checked( $joinnowoption->joinow_get_option( 'disable_admin_message_created' ), 1 ); ?> />&nbsp;<?php _e( 'Do NOT send administrator an email whenever a new user is created by an administrator', 'register-plus-redux' ); ?></label><br />
							<label><input type="checkbox" name="admin_message_when_verified" id="admin_message_when_verified" value="1" <?php checked( $joinnowoption->joinow_get_option( 'admin_message_when_verified' ), 1 ); ?> />&nbsp;<?php _e( 'Send administrator an email after a new user is verified', 'register-plus-redux' ); ?></label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label><?php _e( 'Custom Admin Notification', 'register-plus-redux' ); ?></label></th>
						<td>
							<label><input type="checkbox" name="custom_admin_message" id="custom_admin_message" value="1" <?php checked( $joinnowoption->joinow_get_option( 'custom_admin_message' ), 1 ); ?> class="showHideSettings" />&nbsp;<?php _e( 'Enable...', 'register-plus-redux' ); ?></label>
							<div id="custom_admin_message_settings"<?php if ( $joinnowoption->joinow_get_option( 'custom_admin_message' ) == FALSE ) echo ' style="display: none;"'; ?>>
								<table width="60%">
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; width: 20%;"><label for="admin_message_from_email"><?php _e( 'From Email', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="admin_message_from_email" id="admin_message_from_email" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'admin_message_from_email' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="admin_message_from_name"><?php _e( 'From Name', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="admin_message_from_name" id="admin_message_from_name" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'admin_message_from_name' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;"><label for="admin_message_subject"><?php _e( 'Subject', 'register-plus-redux' ); ?></label></td>
										<td style="padding-top: 0px; padding-bottom: 0px;"><input type="text" name="admin_message_subject" id="admin_message_subject" style="width: 90%;" value="<?php echo esc_attr( $joinnowoption->joinow_get_option( 'admin_message_subject' ) ); ?>" /><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /></td>
									</tr>
									<tr>
										<td colspan="2" style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px;">
											<label for="admin_message_body"><?php _e( 'Admin Message', 'register-plus-redux' ); ?></label><br />
											<textarea name="admin_message_body" id="admin_message_body" style="width: 95%; height: 160px;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'admin_message_body' ) ); ?></textarea><img src="<?php echo plugins_url( 'images\arrow-return-180.png', __FILE__ ); ?>" alt="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" title="<?php esc_attr_e( 'Restore Default', 'register-plus-redux' ); ?>" class="default" style="cursor: pointer;" /><br />
											<strong><?php _e( 'Replacement Keywords', 'register-plus-redux' ); ?>:</strong> <?php echo $joinnowoption->replace_keywords( NULL, NULL ); ?><br />
											<label><input type="checkbox" name="send_admin_message_in_html" id="send_admin_message_in_html" value="1" <?php checked( $joinnowoption->joinow_get_option( 'send_admin_message_in_html' ), 1 ); ?> />&nbsp;<?php _e( 'Send as HTML', 'register-plus-redux' ); ?></label><br />
											<label><input type="checkbox" name="admin_message_newline_as_br" id="admin_message_newline_as_br" value="1" <?php checked( $joinnowoption->joinow_get_option( 'admin_message_newline_as_br' ), 1 ); ?> />&nbsp;<?php _e( 'Convert new lines to &lt;br /&gt; tags (HTML only)', 'register-plus-redux' ); ?></label>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label><?php _e( 'Summary', 'register-plus-redux' ); ?></label></th>
						<td>
							<span id="admin_message_summary"></span>
						</td>
					</tr>
				</table>
				<?php } ?>
				<h3 class="title"><?php _e( 'Custom CSS for Register & Login Pages', 'register-plus-redux' ); ?></h3>
				<p><?php _e( 'CSS Rule Example:', 'register-plus-redux' ); ?>&nbsp;<code>#user_login { font-size: 20px; width: 100%; padding: 3px; margin-right: 6px; }</code></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="custom_registration_page_css"><?php _e( 'Custom Register CSS', 'register-plus-redux' ); ?></label></th>
						<td><textarea name="custom_registration_page_css" id="custom_registration_page_css" style="width:60%; height:160px;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'custom_registration_page_css' ) ); ?></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="custom_login_page_css"><?php _e( 'Custom Login CSS', 'register-plus-redux' ); ?></label></th>
						<td><textarea name="custom_login_page_css" id="custom_login_page_css" style="width:60%; height:160px;"><?php echo esc_textarea( $joinnowoption->joinow_get_option( 'custom_login_page_css' ) ); ?></textarea></td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'join-network' ); ?>" name="update_settings" id="update_settings" />
					<?php if ( !is_multisite() ) { ?>
						<a href="<?php echo site_url('wp-login.php?action=register'); ?>" target="_blank" class="button"><?php esc_attr_e( 'Preview Registration Page', 'join-network' ); ?></a>
					<?php } else { ?>
						<a href="<?php echo network_site_url('wp-signup.php'); ?>" target="_blank" class="button"><?php esc_attr_e( 'Preview Signup Page', 'join-network' ); ?></a>
					<?php } ?>
				</p>
			</form>
</div>
<?php
	    
			// Load defaults for any options
			foreach ( $joinnowoption->default_options() as $option => $default_value ) {
				if ( NULL === $joinnowoption->joinow_get_option( $option ) ) {
					$joinnowoption->joinow_set_option( $option, $default_value );
					$updated = TRUE;
				}
     }
}
/*display_join_now_admin function end here*/


function getbt_search()
{
    // echo ABSPATH .'wp-content/plugins/join-network/tb_search.php';
     $theme=$_GET['theme'];
	 if($theme=='handheld'){
	   require_once(TEMPLATE_PATH.'/tb_search_mobile.php');
	 }else{
    require_once(TEMPLATE_PATH.'/tb_search.php');
	 }
}
add_shortcode('bt_search','getbt_search');
/* Js file for front end start here*/
function frontend_jsfile()
{  
      /* Link our already registered script to a page */
     // All js file find in js folder      
      wp_enqueue_script('jquery19',plugins_url('/js/jquery-1.9.1.min.js' , __FILE__ ));
      wp_enqueue_script('validationjs',plugins_url('/js/jquery.validate.pack.js' , __FILE__ ));
      wp_enqueue_script('validationjs2',plugins_url('/js/joinnowform-validation.js' , __FILE__ ));
      wp_enqueue_script('validationjs3',plugins_url('/js/jquery-ui.js' , __FILE__ ));
      wp_enqueue_script('validationjs4',plugins_url('/js/jquery.mCustomScrollbar.concat.min.js' , __FILE__ )); 
    
}
add_action('wp_enqueue_scripts','frontend_jsfile');
/* end here */
/* css file for front end start here*/
function frontend_cssfile()
{  
      /* Link our already registered style to a page */
      wp_enqueue_style('joinnowcss',plugins_url('/css/join-now.css' , __FILE__ ));
     wp_enqueue_style('joinnowcss1',plugins_url('/css/jquery-ui.css' , __FILE__ ));
}
/* css file for front end end here*/
add_action('wp_print_styles','frontend_cssfile');
function check_verification_code( /*.string.*/ $get_code ) {
			global $wpdb;
			
			$code = preg_replace('/[^a-z0-9]/i', '', $get_code );
			
			if ( empty( $code ) || !is_string( $code ) || $code !== $get_code )
				return new WP_Error('invalid_code', __('Invalid verification code'));
			
			$user_id = (int) $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'email_verification_code' AND meta_value = %s;", $get_code ) );
			
			if ( empty( $user_id ) )
				return new WP_Error('invalid_key', __('Invalid verification code'));
			
			return $user_id;
}
function joinnow_login_form_verifyemail() {
 
			  require(CLASSES_PATH.'/joinnetworkform.php');
			  $joinnowoption= new joinnetworkform();
			//global $register_plus_redux;
			global $errors;
			global $wpdb;
			if ( isset( $_GET['verification_code'] ) ) {
			 $_GET['verification_code'];
			 	$user_id = check_verification_code( (string) $_GET['verification_code'] );			
				$user = get_userdata( $user_id );
				$user_password = get_user_meta( $user_id, 'stored_user_password', TRUE );
				   if ( !is_multisite() ) {
					$user->set_role( (string) get_option( 'default_role' ) );
					$user->remove_role( 'joinnow_unverified' );
				   }
				   else {
						       	$user->set_role( (string) get_option( 'default_role' ) );
							$user->remove_role( 'joinnow_unverified' );
				   }
					     delete_user_meta( $user_id, 'email_verification_code' );
					     delete_user_meta( $user_id, 'email_verification_sent' );
					     
					     $joinnowoption->send_welcome_user_mail( $user_id, $user_password );
					    // $joinnowoption->send_admin_mail( $user_id, $user_password );
					       do_action('my_verified');
					      // die('===');
					       update_user_meta( $user_id, 'email_verified', gmdate( 'Y-m-d H:i:s' ) );
					//     if ( '1' !== $joinnowoption->joinow_get_option( 'disable_user_message_registered' ) ) {
					//	     $joinnowoption->send_welcome_user_mail( $user_id, $user_password );
					//     }
					//     if ( '1' === $joinnowoption->joinow_get_option( 'admin_message_when_verified' ) ) {
					//	     $joinnowoption->send_admin_mail( $user_id, $user_password );
					//     }
					//     if ( '1' === $joinnowoption->joinow_get_option( 'user_set_password' ) ) {
					//	     $errors->add( 'account_verified', sprintf( __( 'Thank you %s, your account has been verified, please login with the password you specified during registration.', 'join-network' ), $user->user_login ), 'message' );
					//     }
					//     else {
					//	     $errors->add( 'account_verified_checkemail', sprintf( __( 'Thank you %s, your account has been verified, your password will be emailed to you.', 'join-network' ), $user->user_login ), 'message' );
					//     }
					//     
					//     $errors->add( 'admin_review', __( 'Your account will be reviewed by an administrator and you will be notified when it is activated.', 'join-network' ), 'message' );
					//      echo "tere";
					   
					}
				
				else {
					$errors->add( 'invalid_verification_code', __( 'Invalid verification code.', 'join-network' ), 'error' );
				}
				//login_header( __('Verify Email', 'join-network' ), '', $errors);
				//login_footer();
				//exit();
			}

add_action( 'login_form_verifyemail', 'joinnow_login_form_verifyemail', 10, 0 );
function joinnow_signup_finished()
{     
     $joinnowoption= new joinnetworkform();
     if ( '1' === $joinnowoption->joinow_get_option( 'verify_user_email' ) && $joinnowoption->joinow_get_option( 'message_verify_user_email' ) ) {
				?>
				<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#join_now_msg").html("<?php echo $joinnowoption->joinow_get_option( 'message_verify_user_email' ) ?>");
				});
				</script>
				<?php
     }
}
add_action( 'signup_finished','joinnow_signup_finished', 10, 0 );
function joinnow_my_verified()
{
      ?><script type="text/javascript">
				$(document).ready(function() {
					
					$("#verified_mesg").html("Your account has been verified");
				
				});
				</script>
				<?php
				
    
}
add_action('my_verified','joinnow_my_verified', 10, 0 );

/* end here */
/* display_join_network() function start here*/
function display_join_network()
{
    // You can find js file in frontend_jsfile function
    require(CLASSES_PATH.'/joinnetworkform.php');
    $displayform= new joinnetworkform();
    //find function in joinnetworkform.php   
    $displayform->displayForm();    
    if(!empty($_POST))
    {
     $userid=$displayform->insert_join_now_user(&$_POST);
     
     $myAv = new simple_local_avatars();
     $myAv->edit_user_profile_update($userid);
     if($userid)
     {
	  $userid = base64_encode($userid);
    // echo $userid;die;
      wp_redirect(site_url().'/?page_id=1375&id='.$userid);
     }
   //  do_action( 'signup_finished' ); // comment sandeep
    }
    
}
//short code for display join network form
add_shortcode("display_join_network","display_join_network");
/* display_join_network() function end here*/
function update_settings() {
			// require(CLASSES_PATH.'/joinnetworkform.php');
			 $joinnowoption2= new joinnetworkform();
			$options = array();
			$redux_usermeta = array();
			$_POST = stripslashes_deep( (array) $_POST );
			if ( isset( $_POST['custom_logo_url'] ) && !isset( $_POST['remove_logo'] ) ) $options['custom_logo_url'] = esc_url_raw( (string) $_POST['custom_logo_url'] );
			$options['verify_user_email'] = isset( $_POST['verify_user_email'] ) ? '1' : '0';
			$options['message_verify_user_email'] = isset( $_POST['message_verify_user_email'] ) ? wp_kses_post( (string) $_POST['message_verify_user_email'] ) : '';
			$options['verify_user_admin'] = isset( $_POST['verify_user_admin'] ) ? '1' : '0';
			$options['message_verify_user_admin'] = isset( $_POST['message_verify_user_admin'] ) ? wp_kses_post( (string) $_POST['message_verify_user_admin'] ) : '';
			$options['delete_unverified_users_after'] = isset( $_POST['delete_unverified_users_after'] ) ? absint( (string) $_POST['delete_unverified_users_after'] ) : '0';
			$options['registration_redirect_url'] = isset( $_POST['registration_redirect_url'] ) ? esc_url_raw( (string) $_POST['registration_redirect_url'] ) : '';
			$options['verification_redirect_url'] = isset( $_POST['verification_redirect_url'] ) ? esc_url_raw( (string) $_POST['verification_redirect_url'] ) : '';
			$options['autologin_user'] = isset( $_POST['autologin_user'] ) ? '1' : '0';
			$options['username_is_email'] = isset( $_POST['username_is_email'] ) ? '1' : '0';
			$options['double_check_email'] = isset( $_POST['double_check_email'] ) ? '1' : '0';
			if ( isset( $_POST['show_fields'] ) && is_array( $_POST['show_fields'] ) ) $options['show_fields'] = (array) $_POST['show_fields'];
			if ( isset( $_POST['required_fields'] ) && is_array( $_POST['required_fields'] ) ) $options['required_fields'] = (array) $_POST['required_fields'];
			$options['user_set_password'] = isset( $_POST['user_set_password'] ) ? '1' : '0';
			$options['min_password_length'] = isset( $_POST['min_password_length'] ) ? absint( $_POST['min_password_length'] ) : 0;
			$options['disable_password_confirmation'] = isset( $_POST['disable_password_confirmation'] ) ? '1' : '0';
			$options['show_password_meter'] = isset( $_POST['show_password_meter'] ) ? '1' : '0';
			$options['message_empty_password'] = isset( $_POST['message_empty_password'] ) ? wp_kses_data( (string) $_POST['message_empty_password'] ) : '';
			$options['message_short_password'] = isset( $_POST['message_short_password'] ) ? wp_kses_data( (string) $_POST['message_short_password'] ) : '';
			$options['message_bad_password'] = isset( $_POST['message_bad_password'] ) ? wp_kses_data( (string) $_POST['message_bad_password'] ) : '';
			$options['message_good_password'] = isset( $_POST['message_good_password'] ) ? wp_kses_data( (string) $_POST['message_good_password'] ) : '';
			$options['message_strong_password'] = isset( $_POST['message_strong_password'] ) ? wp_kses_data( (string) $_POST['message_strong_password'] ) : '';
			$options['message_mismatch_password'] = isset( $_POST['message_mismatch_password'] ) ? wp_kses_data( (string) $_POST['message_mismatch_password'] ) : '';
			$options['enable_invitation_code'] = isset( $_POST['enable_invitation_code'] ) ? '1' : '0';
			if ( isset( $_POST['invitation_code_bank'] ) && is_array( $_POST['invitation_code_bank'] ) ) $invitation_code_bank = (array) $_POST['invitation_code_bank'];
			$options['require_invitation_code'] = isset( $_POST['require_invitation_code'] ) ? '1' : '0';
			$options['invitation_code_case_sensitive'] = isset( $_POST['invitation_code_case_sensitive'] ) ? '1' : '0';
			$options['invitation_code_unique'] = isset( $_POST['invitation_code_unique'] ) ? '1' : '0';
			$options['enable_invitation_tracking_widget'] = isset( $_POST['enable_invitation_tracking_widget'] ) ? '1' : '0';
			$options['show_disclaimer'] = isset( $_POST['show_disclaimer'] ) ? '1' : '0';
			$options['message_disclaimer_title'] = isset( $_POST['message_disclaimer_title'] ) ? sanitize_text_field( (string) $_POST['message_disclaimer_title'] ) : '';
			$options['message_disclaimer'] = isset( $_POST['message_disclaimer'] ) ? wp_kses_post( (string) $_POST['message_disclaimer'] ) : '';
			$options['require_disclaimer_agree'] = isset( $_POST['require_disclaimer_agree'] ) ? '1' : '0';
			$options['message_disclaimer_agree'] = isset( $_POST['message_disclaimer_agree'] ) ? sanitize_text_field( (string) $_POST['message_disclaimer_agree'] ) : '';
			$options['show_license'] = isset( $_POST['show_license'] ) ? '1' : '0';
			$options['message_license_title'] = isset( $_POST['message_license_title'] ) ? sanitize_text_field( (string) $_POST['message_license_title'] ) : '';
			$options['message_license'] = isset( $_POST['message_license'] ) ? wp_kses_post( (string) $_POST['message_license'] ) : '';
			$options['require_license_agree'] = isset( $_POST['require_license_agree'] ) ? '1' : '0';
			$options['message_license_agree'] = isset( $_POST['message_license_agree'] ) ? sanitize_text_field( (string) $_POST['message_license_agree'] ) : '';
			$options['show_privacy_policy'] = isset( $_POST['show_privacy_policy'] ) ? '1' : '0';
			$options['message_privacy_policy_title'] = isset( $_POST['message_privacy_policy_title'] ) ? sanitize_text_field( (string) $_POST['message_privacy_policy_title'] ) : '';
			$options['message_privacy_policy'] = isset( $_POST['message_privacy_policy'] ) ? wp_kses_post( (string) $_POST['message_privacy_policy'] ) : '';
			$options['require_privacy_policy_agree'] = isset( $_POST['require_privacy_policy_agree'] ) ? '1' : '0';
			$options['message_privacy_policy_agree'] = isset( $_POST['message_privacy_policy_agree'] ) ? sanitize_text_field( (string) $_POST['message_privacy_policy_agree'] ) : '';
			$options['disable_user_message_registered'] = isset( $_POST['disable_user_message_registered'] ) ? '1' : '0';
			$options['disable_user_message_created'] = isset( $_POST['disable_user_message_created'] ) ? '1' : '0';
			$options['custom_user_message'] = isset( $_POST['custom_user_message'] ) ? '1' : '0';
			$options['user_message_from_email'] = isset( $_POST['user_message_from_email'] ) ? sanitize_text_field( (string) $_POST['user_message_from_email'] ) : '';
			$options['user_message_from_name'] = isset( $_POST['user_message_from_name'] ) ? sanitize_text_field( (string) $_POST['user_message_from_name'] ) : '';
			$options['user_message_subject'] = isset( $_POST['user_message_subject'] ) ? sanitize_text_field( (string) $_POST['user_message_subject'] ) : '';
			$options['user_message_body'] = isset( $_POST['user_message_body'] ) ? wp_kses_post( (string) $_POST['user_message_body'] ) : '';
			$options['send_user_message_in_html'] = isset( $_POST['send_user_message_in_html'] ) ? '1' : '0';
			$options['user_message_newline_as_br'] = isset( $_POST['user_message_newline_as_br'] ) ? '1' : '0';
			$options['custom_verification_message'] = isset( $_POST['custom_verification_message'] ) ? '1' : '0';
			$options['verification_message_from_email'] = isset( $_POST['verification_message_from_email'] ) ? sanitize_text_field( (string) $_POST['verification_message_from_email'] ) : '';
			$options['verification_message_from_name'] = isset( $_POST['verification_message_from_name'] ) ? sanitize_text_field( (string) $_POST['verification_message_from_name'] ) : '';
			$options['verification_message_subject'] = isset( $_POST['verification_message_subject'] ) ? sanitize_text_field( (string) $_POST['verification_message_subject'] ) : '';
			$options['verification_message_body'] = isset( $_POST['verification_message_body'] ) ? wp_kses_post( (string) $_POST['verification_message_body'] ) : '';
			$options['send_verification_message_in_html'] = isset( $_POST['send_verification_message_in_html'] ) ? '1' : '0';
			$options['verification_message_newline_as_br'] = isset( $_POST['verification_message_newline_as_br'] ) ? '1' : '0';
			$options['disable_admin_message_registered'] = isset( $_POST['disable_admin_message_registered'] ) ? '1' : '0';
			$options['disable_admin_message_created'] = isset( $_POST['disable_admin_message_created'] ) ? '1' : '0';
			$options['admin_message_when_verified'] = isset( $_POST['admin_message_when_verified'] ) ? '1' : '0';
			$options['custom_admin_message'] = isset( $_POST['custom_admin_message'] ) ? '1' : '0';
			$options['admin_message_from_email'] = isset( $_POST['admin_message_from_email'] ) ? sanitize_text_field( (string) $_POST['admin_message_from_email'] ) : '';
			$options['admin_message_from_name'] = isset( $_POST['admin_message_from_name'] ) ? sanitize_text_field( (string) $_POST['admin_message_from_name'] ) : '';
			$options['admin_message_subject'] = isset( $_POST['admin_message_subject'] ) ? sanitize_text_field( (string) $_POST['admin_message_subject'] ) : '';
			$options['admin_message_body'] = isset( $_POST['admin_message_body'] ) ? wp_kses_post( (string) $_POST['admin_message_body'] ) : '';
			$options['send_admin_message_in_html'] = isset( $_POST['send_admin_message_in_html'] ) ? '1' : '0';
			$options['admin_message_newline_as_br'] = isset( $_POST['admin_message_newline_as_br'] ) ? '1' : '0';			
			$joinnowoption2->joinow_update_options( $options );
			//if ( !empty( $invitation_code_bank ) ) update_option( 'register_plus_redux_invitation_code_bank-rv1', $invitation_code_bank );
			//if ( !empty( $redux_usermeta ) ) update_option( 'register_plus_redux_usermeta-rv2', $redux_usermeta );
}
    function joinnow_login_form()
     {
	 
	  ?>

<script type="text/javascript">
$(document).ready(function()
		  { siteurl ="http://constructionmates.co.uk/"
		  $('#log').focusout(function(){
		    
	          //alert("======");
		 username=$('#log').val();
	       //alert("username");
		 if(username!=""){
			 $.post(siteurl+"/ajax_rsponce.php", {username: ""+username+"",usertype: "usertype"},function(result_data){
                                   if(result_data!=0){
					result_arr=result_data.split("url=");
					$('#redirect_to').val(result_arr[1]);
					}
			  });
			      }
     });		    });
</script>
   <div class="job-type_field_main">
     <span style="color:green;font-size: 16px;" id="join_now_msg"></span>
        	<h3>Member Login </h3>
     <form name="login_form" method="post" action="<?php echo site_url( '/wp-login.php' ); ?>">
     <div class="memeber_field_main">
            	<div class="user_field user_field-rgt">
                	<div class="user-input_bg">
                    	<span> <label id="username_check"></label>
                        <input name="log" placeholder="User Name" type="text"  value="" id="log" />
                        </span>
                    </div>
                </div>
                <div class="user_field paswrd_field-rgt">
                	<div class="user-input_bg">
                    	<span>
                        <input name="pwd" placeholder="Password" type="password"  value="" required/>
                        </span>
                    </div>
                </div>
		
                <div class="join-login-btn">
	       <input type="hidden" value="" name="redirect_to" id="redirect_to">
              <input name="image" id="image" type="image" value="Login" src="<?php bloginfo('template_url')?>/images/join-login-btn.png" alt="Login" />	      
           
		</div>
     </form>
	   <?php echo do_shortcode('[display_join_network]'); ?>
  <?php
}
add_shortcode('joinnow_login_form','joinnow_login_form');

function show_profile_user()
{
     //global $current_user;
     // get_currentuserinfo();
     //
     // echo 'Username: ' . $current_user->user_login . "\n";
     // echo 'User email: ' . $current_user->user_email . "\n";
     // echo 'User first name: ' . $current_user->user_firstname . "\n";
     // echo 'User last name: ' . $current_user->user_lastname . "\n";
     // echo 'User display name: ' . $current_user->display_name . "\n";
     // echo 'User ID: ' . $current_user->ID . "\n";
     
     // You can find js file in frontend_jsfile function
    require(CLASSES_PATH.'/joinnetworkform.php');
    $displayform= new joinnetworkform();
    //find function in joinnetworkform.php
   // print_r($_POST); 
    $displayform->displayDashboard();
    if(!empty($_POST))
    {
     $displayform->insert_join_now_user(&$_POST);
     do_action( 'signup_finished' );
    }
}
add_shortcode('show_profile_user','show_profile_user');

//Show home owner page
function show_home_owner()
{
    // You can find js file in frontend_jsfile function
    require(CLASSES_PATH.'/joinnetworkform.php');
    $displayform= new joinnetworkform();
    //find function in joinnetworkform.php
   // print_r($_POST); 
    $displayform->displayHomeOwner();
    if(!empty($_POST))
    {
     $displayform->insert_join_now_user(&$_POST);
     do_action( 'signup_finished' );
    }
}
add_shortcode('show_home_owner','show_home_owner');

//show traders page
function show_traders()
{
    // You can find js file in frontend_jsfile function
    require(CLASSES_PATH.'/joinnetworkform.php');
    $displayform= new joinnetworkform();
    //find function in joinnetworkform.php
   // print_r($_POST); 
    $displayform->displayTraders();
    if(!empty($_POST['email_address']))
    {
     $displayform->insert_join_now_user(&$_POST);
     do_action( 'signup_finished' );
    }
}
add_shortcode('show_traders','show_traders');

//show Traders detail page
function show_trader_detail()
{
     require_once( ABSPATH . 'wp-content/plugins/ratings/ratings.php' );
     require_once( ABSPATH . 'wp-content/plugins/donation/donation.php' );
     // You can find js file in frontend_jsfile function
    require(CLASSES_PATH.'/joinnetworkform.php');
    $displayform= new joinnetworkform();
    //find function in joinnetworkform.php
   // print_r($_POST); 
    $displayform->displayTraderdetail();
    if(!empty($_POST))
    {
     $displayform->insert_join_now_user(&$_POST);
     do_action( 'signup_finished' );
    }
}
add_shortcode('show_trader_detail','show_trader_detail');

//trader action
function apply_trader_fromuser()
{
     global $wpdb;
     global $current_user;
     $sender=$current_user->data->user_login;
     $id=$current_user->data->ID;
     $trader_id=$_REQUEST['trader_id'];
     $status=$_REQUEST['check_status'];
     $requestdate=date("Y-m-d");
     $table_name="wp_trader_cv";
     $sql1  = "INSERT INTO `" . $table_name ."` VALUES ('','$id','$trader_id','$requestdate')";    
     $result1 = $wpdb->query($sql1);
     $all_meta_for_user = get_user_meta( $trader_id);
	       $rec=$all_meta_for_user['first_name'][0];
	        $pdf=".pdf";
	     //$attachment=site_url().'/wp-content/uploads/rsjp/pdfs/'.$sender.'.pdf';
	      $attachment_id_user = $wpdb->get_var("SELECT userid FROM wp_rsjp_submissions where userid='$id'");
	       $attachment_id = $wpdb->get_var("SELECT userid FROM wp_rsjp_submissions where userid='$trader_id'");
	       //print_r($doc_name);
	        if($status==1)
		    {
		    $retrieved_doc = $wpdb->get_var("SELECT doc_name FROM wp_mydoc where userid='$id' order by id desc");
		    $content_doc='<span class="downloadbg"><a href="'.site_url().'/wp-content/uploads/mydoc/'.$retrieved_doc.'">Download Doc</a></span>';
		    }
	       if(isset($attachment_id))
	       {  $content_inbox='<span class="msgbg">You are confirmed for CV request from '.$all_meta_for_user['first_name'][0].'</span><span class="downloadbg"><a href="'.site_url().'/wp-content/uploads/rsjp/pdfs/'.$rec.$pdf.'">Download CV</a></span>';
		   
	       }
	     else{
		     $content_inbox='<span class="msgbg">You are confirmed for CV request from '.$all_meta_for_user['first_name'][0].'</span>';
		   }
		   if(isset($attachment_id_user))
		   { $content='<span class="msgbg">'.$sender.' requested to '.$all_meta_for_user['first_name'][0].'for CV</span><span class="downloadbg"><a href="'.site_url().'/wp-content/uploads/rsjp/pdfs/'.$sender.$pdf.'">Download CV</a></span>';}
		   else{
		     $content='<span class="msgbg">'.$sender.' requested to '.$all_meta_for_user['first_name'][0].'</span>';
		   }
	    				$new_message = array(
					'id'        => NULL,
					'subject'   => $subject,
					'content'   => $content,
					'content_doc'=> $content_doc,
					'sender'    => $sender,
					'recipient' => $rec,
					'date'      => current_time( 'mysql' ),
					'read'      => 0,
					'deleted'   => 0
				);
				
	       	$new_message1 = array(
					'id'        => NULL,
					'subject'   => $subject,
					'content'   => $content_inbox,
					'sender'    => $rec,
					'recipient' => $sender,
					'date'      => current_time( 'mysql' ),
					'read'      => 0,
					'deleted'   => 0
				);
			      $wpdb->insert( $wpdb->prefix . 'pm', $new_message1, array( '%d', '%s', '%s','%s', '%s', '%s', '%s', '%d', '%d' ) );
				// insert into database
				if ( $wpdb->insert( $wpdb->prefix . 'pm', $new_message, array( '%d', '%s', '%s','%s', '%s', '%s', '%s', '%d', '%d' ) ) )
				{
					$numOK++;
					//unset( $_REQUEST['recipient'], $_REQUEST['subject'], $_REQUEST['content'] );

					// send email to user
					if ( $option['email_enable'] )
					{
						$sender = $wpdb->get_var( "SELECT display_name FROM $wpdb->users WHERE user_login = '$sender' LIMIT 1" );

						// replace tags with values
						$tags = array( '%BLOG_NAME%', '%BLOG_ADDRESS%', '%SENDER%', '%INBOX_URL%' );
						$replacement = array( get_bloginfo( 'name' ), get_bloginfo( 'admin_email' ), $sender, admin_url( 'admin.php?page=rwpm_inbox' ) );

						$email_name = str_replace( $tags, $replacement, $option['email_name'] );
						$email_address = str_replace( $tags, $replacement, $option['email_address'] );
						$email_subject = str_replace( $tags, $replacement, $option['email_subject'] );
						$email_body = str_replace( $tags, $replacement, $option['email_body'] );

						// set default email from name and address if missed
						if ( empty( $email_name ) )
							$email_name = get_bloginfo( 'name' );

						if ( empty( $email_address ) )
							$email_address = get_bloginfo( 'admin_email' );

						$email_subject = strip_tags( $email_subject );
						if ( get_magic_quotes_gpc() )
						{
							$email_subject = stripslashes( $email_subject );
							$email_body = stripslashes( $email_body );
						}
						$email_body = nl2br( $email_body );

						$recipient_email = $wpdb->get_var( "SELECT user_email from $wpdb->users WHERE display_name = '$rec'" );
						$mailtext = "<html><head><title>$email_subject</title></head><body>$email_body</body></html>";

						// set headers to send html email
						$headers = "To: $recipient_email\r\n";
						$headers .= "From: $email_name <$email_address>\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= 'Content-Type: ' . get_bloginfo( 'html_type' ) . '; charset=' . get_bloginfo( 'charset' ) . "\r\n";

						wp_mail( $recipient_email, $email_subject, $mailtext, $headers );
					}
				
			 }
				else
				{
					$numError++;
				}
}
add_action('wp_ajax_traderapply_action', 'apply_trader_fromuser');
add_action('wp_ajax_nopriv_traderapply_action', 'apply_trader_fromuser');

//show Builders page
function show_builders()
{
     // You can find js file in frontend_jsfile function
    require(CLASSES_PATH.'/joinnetworkform.php');
    $displayform= new joinnetworkform();

    //find function in joinnetworkform.php
   // print_r($_POST); 
    $displayform->displayBuilders();
    if(!empty($_POST['email_address']))
    {
     $displayform->insert_join_now_user(&$_POST);
     do_action( 'signup_finished' );
    }
}
add_shortcode('show_builders','show_builders');

//show Builders detail page
function show_builder_detail()
{
     // You can find js file in frontend_jsfile function
    require(CLASSES_PATH.'/joinnetworkform.php');
    $displayform= new joinnetworkform();
    //find function in joinnetworkform.php
   // print_r($_POST); 
    $displayform->displayBuilderdetail();
    if(!empty($_POST))
    {
     $displayform->insert_join_now_user(&$_POST);
     do_action( 'signup_finished' );
    }
}
add_shortcode('show_builder_detail','show_builder_detail');

//builder action
function apply_builder_fromuser()
{
     global $wpdb;
     global $current_user;
     $id=$current_user->data->ID;
     $sender=$current_user->data->user_login;
     $builder_id=$_REQUEST['builder_id'];
     $requestdate=date("Y-m-d");
     $table_name="wp_builder_cv";
     $sql1  = "INSERT INTO `" . $table_name ."` VALUES ('','$id','$builder_id','$requestdate')";
     $result1 = $wpdb->query($sql1);
     $all_meta_for_user = get_user_meta( $builder_id);
      //$user_recepitent_id = $wpdb->get_var("SELECT user_id FROM wp_jobpost where id=$job_id");
     // $job_title = $wpdb->get_var("SELECT job_title FROM wp_jobpost where id=$job_id");
      //$sender = $wpdb->get_var( "SELECT user_login FROM $wpdb->users WHERE id = '$user_recepitent_id' LIMIT 1" );
           //$retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where id='$job_id'");
	     //foreach ($retrieve_data as $retrieved_data){
	     // $Jt =  $retrieved_data->job_title;
	     //  $Jd = $retrieved_data->job_detail;
	     //  $Jl = $retrieved_data->job_location;
	     //  $Fn = $retrieved_data->file_name;
	     //  $Jty = $retrieved_data->job_type;
	     //  $Cn = $retrieved_data->contact;
	     //  $Pd = $retrieved_data->post_date;
	     // }
	     $rec=$all_meta_for_user['first_name'][0];
	     $content='<span>'.$sender.'requested to '.$all_meta_for_user['first_name'][0].'</span>'; 
	    				$new_message = array(
					'id'        => NULL,
					'subject'   => $subject,
					'content'   => $content,
					'sender'    => $sender,
					'recipient' => $rec,
					'date'      => current_time( 'mysql' ),
					'read'      => 0,
					'deleted'   => 0
				);
					$content1='<span>'.$sender.'requested to '.$all_meta_for_user['first_name'][0].'</span>'; 
	    				$new_message1 = array(
					'id'        => NULL,
					'subject'   => $subject,
					'content'   => $content,
					'sender'    => $rec,
					'recipient' => $sender,
					'date'      => current_time( 'mysql' ),
					'read'      => 0,
					'deleted'   => 0
				);
					$wpdb->insert( $wpdb->prefix . 'pm', $new_message1, array( '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d' ));
				// insert into database
				if ( $wpdb->insert( $wpdb->prefix . 'pm', $new_message, array( '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d' ) ) )
				{
					$numOK++;
					//unset( $_REQUEST['recipient'], $_REQUEST['subject'], $_REQUEST['content'] );

					// send email to user
					if ( $option['email_enable'] )
					{
						$sender = $wpdb->get_var( "SELECT display_name FROM $wpdb->users WHERE user_login = '$sender' LIMIT 1" );

						// replace tags with values
						$tags = array( '%BLOG_NAME%', '%BLOG_ADDRESS%', '%SENDER%', '%INBOX_URL%' );
						$replacement = array( get_bloginfo( 'name' ), get_bloginfo( 'admin_email' ), $sender, admin_url( 'admin.php?page=rwpm_inbox' ) );

						$email_name = str_replace( $tags, $replacement, $option['email_name'] );
						$email_address = str_replace( $tags, $replacement, $option['email_address'] );
						$email_subject = str_replace( $tags, $replacement, $option['email_subject'] );
						$email_body = str_replace( $tags, $replacement, $option['email_body'] );

						// set default email from name and address if missed
						if ( empty( $email_name ) )
							$email_name = get_bloginfo( 'name' );

						if ( empty( $email_address ) )
							$email_address = get_bloginfo( 'admin_email' );

						$email_subject = strip_tags( $email_subject );
						if ( get_magic_quotes_gpc() )
						{
							$email_subject = stripslashes( $email_subject );
							$email_body = stripslashes( $email_body );
						}
						$email_body = nl2br( $email_body );

						$recipient_email = $wpdb->get_var( "SELECT user_email from $wpdb->users WHERE display_name = '$rec'" );
						$mailtext = "<html><head><title>$email_subject</title></head><body>$email_body</body></html>";

						// set headers to send html email
						$headers = "To: $recipient_email\r\n";
						$headers .= "From: $email_name <$email_address>\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= 'Content-Type: ' . get_bloginfo( 'html_type' ) . '; charset=' . get_bloginfo( 'charset' ) . "\r\n";

						wp_mail( $recipient_email, $email_subject, $mailtext, $headers );
					}
				}
				else
				{
					$numError++;
				}
}
add_action('wp_ajax_builderapply_action', 'apply_builder_fromuser');
add_action('wp_ajax_nopriv_builderapply_action', 'apply_builder_fromuser');

function post_job_menu(){
     
if($_GET['action']=="verifyemail")
{
     do_action('login_form_verifyemail');
}     
     global $wpdb;
       if (is_user_logged_in()) {
	   global $current_user;
	  $id=$current_user->data->ID;
	  $all_meta_for_user = get_user_meta( $id);
	  $u=$all_meta_for_user['usertype'][0];
     if($u==1)
	  {
	wp_redirect(site_url().'?page_id=354', 301 ); exit();
		    }
	  elseif($u==3 || $u==4){
	  wp_redirect(site_url().'?page_id=1364', 301 );exit(); 
	  }
}
     ?>
<script type="text/javascript">
$(document).ready(function()
		  { siteurl ="http://constructionmates.co.uk/"
		  $('#log').focusout(function(){
		    
	          //alert("======");
		 username=$('#log').val();
	       //alert("username");
		 if(username!=""){
			 $.post(siteurl+"/ajax_rsponce.php", {username: ""+username+"",usertype: "usertype"},function(result_data){
                                   if(result_data!=0){
					result_arr=result_data.split("url=");
					$('#redirect_to').val(result_arr[1]);
					}
			  });
			      }
     });		    });
</script>

        <div class="job-type_field_main">
		<h3>To Post a Job You Need To Log In </h3>
<form name="login_form" method="post" action="<?php echo site_url( '/wp-login.php' ); ?>">
     <div class="memeber_field_main">
            	<div class="user_field user_field-rgt">
                	<div class="user-input_bg">
                    	<span> <label id="username_check"></label>
                        <input name="log" placeholder="User Name" type="text"  value="" id="log" />
                        </span>
                    </div>
                </div>
                <div class="user_field paswrd_field-rgt">
                	<div class="user-input_bg">
                    	<span>
                        <input name="pwd" placeholder="Password" type="password"  value="" required/>
                        </span>
                    </div>
                </div>
		
                <div class="join-login-btn">
	       <input type="hidden" value="" name="redirect_to" id="redirect_to">
              <input name="image" id="image" type="image" value="Login" src="<?php bloginfo('template_url')?>/images/join-login-btn.png" alt="Login" />	 
		</div>
	  </form>
	 
	<div class="join_now notmember"  id="index"> <h3>Not a member Yet</h3> <span>
          <a href="<?php echo site_url();?>?page_id=118"><input type="button" name="txtEmail" value="Join Now"></a>
          </span>
         </div>
 </div> 
<?php }
add_shortcode('post_job_menu','post_job_menu');
add_shortcode('home_login','home_login');
function home_login(){
 if($_GET['action']=="verifyemail")
{
     do_action('login_form_verifyemail');
}     
     global $wpdb;
       if (is_user_logged_in()) {
	wp_redirect(site_url().'?page_id=354', 301 ); exit;
}
     ?>
<script type="text/javascript">
$(document).ready(function()
		  { siteurl ="http://constructionmates.co.uk/"
		  $('#log').focusout(function(){
	          //alert("======");
		 username=$('#log').val();
	       //alert("username");
		 if(username!=""){
			 $.post(siteurl+"/ajax_rsponce.php", {username: ""+username+"",usertype: "usertype"},function(result_data){
                                   if(result_data!=0){
					result_arr=result_data.split("url=");
					$('#redirect_to').val(result_arr[1]);
					}
			  });
			      }
     });		    });
</script><form name="login_form" method="post" action="<?php echo site_url( '/wp-login.php' ); ?>">
     <div class="memeber_field_main">
            	<div class="user_field user_field-rgt">
                	<div class="user-input_bg">
                    	<span> <label id="username_check"></label>
                        <input name="log" placeholder="User Name" type="text"  value="" id="log" />
                        </span>
                    </div>
                </div>
                <div class="user_field paswrd_field-rgt">
                	<div class="user-input_bg">
                    	<span>
                        <input name="pwd" placeholder="Password" type="password"  value="" required/>
                        </span>
                    </div>
                </div>
		
                <div class="join-login-btn">
	       <input type="hidden" value="" name="redirect_to" id="redirect_to">
              <input name="image" id="image" type="image" value="Login" src="<?php bloginfo('template_url')?>/images/join-login-btn.png" alt="Login" />	 
		</div>
	  </form>
<?php }
// Check Autentication of user
function check_login() {
     global $wpdb;
$user = get_userdatabylogin($_POST['log']);

     	if(!username_exists($_POST['log'])) {
		return;
	}
        if(empty($user->roles))
	{
	//  echo "fsfsdfsd"; die("dfsddf");
	    return null;
	}
	if ( $user && wp_check_password( $_POST['pwd'], $user->data->user_pass, $user->ID) )
	{
	   
	  return $user;

	}
	else
	{
	  return ;
	} 
   
}
add_filter('authenticate', 'check_login', 100, 3);
// Login redirection of user
function my_login_redirect( $redirect_to, $request, $user ){
    //is there a user to check?
    global $user;
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if( in_array( "administrator", $user->roles ) ) {
            // redirect them to the default place
	    $redirect_to=site_url().'wp-admin/';
            return $redirect_to;
        } else {
	 if(($user->usertype==1)or($user->usertype==4)){
	        if (get_template()=="constructionmatesss_mob") {
		//$redirect_to=site_url().'?page_id=487&theme=handheld';
		$redirect_to=site_url().'?page_id=1465&theme=handheld';
		
		}else{
		   // $redirect_to=site_url().'?page_id=487';
		   $redirect_to=site_url().'?page_id=1465';
		}
           
	  }else{
	            if (get_template()=="constructionmatesss_mob") {
			  // $redirect_to=site_url().'?page_id=442&theme=handheld';
			$redirect_to=site_url().'?page_id=1465&theme=handheld';
		   }else{
	      // $redirect_to=site_url().'?page_id=442';
	      $redirect_to=site_url().'?page_id=1465';
		   }
	  }
	  return $redirect_to;
        }
    }
    else {
     if(($user->usertype==1)or($user->usertype==4)){
		  if (get_template()=="constructionmatesss_mob") {
	       //$redirect_to=site_url().'?page_id=487&theme=handheld';
	       $redirect_to=site_url().'?page_id=1465&theme=handheld';
		}
		else{
		  //  $redirect_to=site_url().'?page_id=487';
		  $redirect_to=site_url().'?page_id=1465';
		}
           
	  }else{
	        if (get_template()=="constructionmatesss_mob") {
		    // $redirect_to=site_url().'?page_id=442&theme=handheld';
		    $redirect_to=site_url().'?page_id=1465&theme=handheld';
		   }else{
	      // $redirect_to=site_url().'?page_id=442';
	      $redirect_to=site_url().'?page_id=1465';
		   }
	  }
     
        return $redirect_to;
    } 	
}
add_filter( 'login_redirect', 'my_login_redirect',10,3);
?>
<?php
function getWelcome()
{
	  global $wpdb;
	$userid= $_GET['id'];
	$userid = base64_decode($userid);
	$data = get_user_meta($userid);
	
	$dataname = $wpdb->get_var( "SELECT user_login FROM $wpdb->users WHERE ID = '$userid' " );
	//print_r($dataname);
	//echo "<pre>";
	//print_r($data);
	?>
	<div class="term-condition-txt">
	<div class="term-condition-rw">
	
	<p>welcome to http://constructionmates.co.uk</p>
	<P>Your username is:<?php echo $dataname; ?></P>
	<P>Your password is:<?php echo $data['stored_user_password'][0]; ?></P>
	
	<p>Please keep these details safe and if you like to amend or change your password, you can do this by log-in to your account after your account is active </p>
	<p>To activate your account please log in to your email provided during the registration and click <b>Activate  My Account</b>  then  enter  name and password as it shows  above.</p>
	<p>Your success is our priority and if you need help or advice on completing your profile visit        our FAQ page on our site for more info   email or contact us with your question comments and feedback.</p>
	<p>And once again Thank You   for Joining ConstructionMates.co.uk  </p>
	
	</div>
	</div>
	<?php
	
}
add_shortcode('welcome_user','getWelcome');
?>
