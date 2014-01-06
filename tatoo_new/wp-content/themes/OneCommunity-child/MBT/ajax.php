<?php

function mbt_xprofile_screen_edit_profile() {
	
	$output 			= array();
	$output['error'] 	= 1;
	$output['message'] 	= null;

	$bp = buddypress();

	global $current_user;

	get_currentuserinfo();

	$user_id = $current_user->ID;

	// No errors
	$errors = false;

	// Check to see if any new information has been submitted
	if ( isset( $_POST['field_ids'] ) ) {

		// Check the nonce
		check_admin_referer( 'bp_xprofile_edit' );

		// Check we have field ID's
		if ( empty( $_POST['field_ids'] ) ) {
			$output['message'] = 'Field ids missing!';
			echo json_encode($output);
			exit;
		}

		// Explode the posted field IDs into an array so we know which
		// fields have been submitted
		$posted_field_ids = explode( ',', $_POST['field_ids'] );
		$is_required      = array();

		// Loop through the posted fields formatting any datebox values
		// then validate the field
		foreach ( (array) $posted_field_ids as $field_id ) {
			if ( !isset( $_POST['field_' . $field_id] ) ) {

				if ( !empty( $_POST['field_' . $field_id . '_day'] ) && !empty( $_POST['field_' . $field_id . '_month'] ) && !empty( $_POST['field_' . $field_id . '_year'] ) ) {
					// Concatenate the values
					$date_value =   $_POST['field_' . $field_id . '_day'] . ' ' . $_POST['field_' . $field_id . '_month'] . ' ' . $_POST['field_' . $field_id . '_year'];

					// Turn the concatenated value into a timestamp
					$_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $date_value ) );
				}

			}

			$is_required[$field_id] = xprofile_check_is_required_field( $field_id );
			if ( $is_required[$field_id] && empty( $_POST['field_' . $field_id] ) ) {
				$errors = true;
			}
		}

		// There are errors
		if ( !empty( $errors ) ) {
			$output['message'] = __( 'Please make sure you fill in all required fields in this profile field group before saving.', 'buddypress' );
			echo json_encode($output);
			exit;
		// No errors
		} else {

			// Reset the errors var
			$errors = false;

			// Now we've checked for required fields, lets save the values.
			foreach ( (array) $posted_field_ids as $field_id ) {

				// Certain types of fields (checkboxes, multiselects) may come through empty. Save them as an empty array so that they don't get overwritten by the default on the next edit.
				if ( empty( $_POST['field_' . $field_id] ) ) {
					$value = array();
				} else {
					$value = $_POST['field_' . $field_id];
				}

				if ( !xprofile_set_field_data( $field_id, $user_id, $value, $is_required[$field_id] ) ) {
					$errors = true;
				} else {
					do_action( 'xprofile_profile_field_data_updated', $field_id, $value );
				}

				// Save the visibility level
				$visibility_level = !empty( $_POST['field_' . $field_id . '_visibility'] ) ? $_POST['field_' . $field_id . '_visibility'] : 'public';
				xprofile_set_field_visibility_level( $field_id, $user_id, $visibility_level );
			}

			do_action( 'xprofile_updated_profile', $user_id, $posted_field_ids, $errors );

			// Set the feedback messages
			if ( !empty( $errors ) ) {
				$output['message'] = __( 'There was a problem updating some of your profile information, please try again.', 'buddypress' );
				echo json_encode($output);
				exit;
			} else {
				$output['message'] 	= __( 'Changes saved.', 'buddypress' );
				$output['error']	= 0;
				echo json_encode($output);
				exit;
			}
		}
	}

	$output['message'] = 'Post object not found!';
	echo json_encode($output);
	exit;
}

add_action('wp_ajax_save_xprofile_data', 'mbt_xprofile_screen_edit_profile');
add_action('wp_ajax_nopriv_save_xprofile_data', 'mbt_xprofile_screen_edit_profile');