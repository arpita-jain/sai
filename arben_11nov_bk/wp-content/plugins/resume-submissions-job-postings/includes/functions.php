<?php
// Functions

// Display a submit button when the shortcode is set
function rsjpSubmitFormInclude( $job ){
	include( 'submit-button.php' );
}

// Set states into an array
function stateList(){
	$stateList = array( 'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 
					    'District Of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 
					    'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 
					    'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 
					    'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 
					    'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 
					    'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming' );

	return $stateList;
}

// Put a list into selection  
function arrayToSelect( $options, $selected = '', $optgroup = NULL, $blank ){
	if ( $blank )
		echo '<option value="">- - ' . __( 'Select' ) . ' - -</option>';
	foreach ( $options as $value ) {
		if ( is_object( $value ) ){
			$optValue = $value->title;
		} else {
			$optValue = $value;
		}
		if ( $selected == $optValue ){
			$set = 'selected="selected"';
		} else {
			$set = '';
		}
		$returnStatement .= '<option value="' . $optValue . '" ' . $set . '>' . $optValue . '</option>';
	}
	return $returnStatement;
}

// Checks the input and returns the correct syntax
function checkIt( $field, $set, $type ) {
	switch( $type ){
		case 'radio'  :
		case 'check'  :
					  $language = 'checked="checked"';
					  break;
		case 'select' :
					  $language = 'selected="selected"';
					  break;
	}
	if ( $field == $set ){
		$selected = $language;
	} else {
		$selected = '';
	}
	return $selected;
}


// Replace the shortcodes with the variables
function replaceShortCode( $text, $array){
	$shortCodes = array( '%fname%', '%lname%', '%address%', '%address2%', '%city%', '%state%', '%zip%', '%pnumber%', 
						 '%pnumbertype%', '%snumber%', '%snumberType%', '%email%', '%job%', '%cover%', '%resume%', '%siteName%' );
	$variables  = array( $array->fname, $array->lname, $array->address, $array->address2, $array->city, $array->state, $array->zip, $array->pnumber, 
						 $array->pnumbertype, $array->snumber, $array->snumberType, $array->email, $array->job, $array->cover, $array->resume, get_option( 'blogname' ) );
	
	$newText = str_replace( $shortCodes, $variables, $text );
	
	return $newText;
}

// Set the TinyMce settings easily
function setTinySetting( $name, $rows, $media, $tiny, $tags ) {
	$settings = array(
					'wpautop' => settype( get_option( 'resume_use_wpautop' ), boolean ),
					'media_buttons' => $media,
					'textarea_rows' => $rows,
					'textarea_name' => $name,
					'teeny' => true,
					'tinymce' => $tiny,
					'quicktags' => $tags
					);

	return $settings;
}


// Grab the contents of the specific field in the array
function grabContents( $array, $field, $sub ){
	
	$value = $array[$field][$sub];
	
	return $value;	
}

// Display the form * if the field is required
function displayRequired( $value ){
	
	if ( $value == 1 ) {
		$display = '<span style="color:#CC0000; font-weight:bold;">*</span>';
	} else {
		$display = '';
	}
	
	return $display;
}

// Checks to make sure all the required fields are filled out
function formErrorCheck( $fields ) {
	
	$array = get_option( 'resume_input_fields' );

	foreach ( $array as $item => $key) {
		
		switch($item){
			case 'fname':
						if ( !$fields['fname'] && $key[1] == 1 )
							$error = true;
						break;
			case 'lname':
						if ( !$fields['lname'] && $key[1] == 1 )
							$error = true;
						break;
			case 'address':
						if ( !$fields['address'] && $key[1] == 1 )
							$error = true;
						break;
			case 'address2':
						if ( !$fields['address2'] && $key[1] == 1 )
							$error = true;

						break;
			case 'city':
						if ( !$fields['city'] && $key[1] == 1 )
							$error = true;
						break;
			case 'state':
						if ( !$fields['state'] && $key[1] == 1 )
							$error = true;
						break;
			case 'zip':
						if ( !$fields['zip'] && $key[1] == 1 )
							$error = true;
						break;
			case 'pnumber':
						if ( ( !$fields['pnumber'] || !$fields['pnumbertype'] ) && $key[1] == 1 )
							$error = true;
						break;
			case 'snumber':
						if ( ( !$fields['snumber'] || !$fields['snumbertype'] ) && $key[1] == 1 )
							$error = true;
						break;
			case 'email':
						if ( !$fields['email'] && $key[1] == 1 )
							$error = true;
						break;
			case 'attachment':
						if ( !$fields['attachment'][0]['name'][0] && $key[1] == 1 )
							$error = true;
						break;
			case 'cover':
						if ( !$fields['cover'] && $key[1] == 1 )
							$error = true;
						break;
			case 'resume':
						if ( !$fields['resume'] && $key[1] == 1 )
							$error = true;
						break;
		}
		
	}
	
	return $error;	
}

// Grab Extension from file
function getExtension( $str ) {
	$i = strrpos( $str, '.' );
	if ( !$i ) { 
		return ''; 
	}
	$l = strlen( $str ) - $i;
	$ext = substr( $str, $i+1, $l );
	return $ext;
}

// Upload user attachments
//function uploadAttachments( $files, $input ){
//	$uploadDir = WP_CONTENT_DIR . '/uploads/rsjp/attachments/';
//	$count     = 1;
//	 
//	foreach( $_FILES[$input]['error'] as $key => $error ){
//		if ( $error == UPLOAD_ERR_OK ) {
//			$tmpName  = $_FILES[$input]['tmp_name'][$key];
//			$ext      = getExtension( $_FILES[$input]['name'][$key] );
//			$name     = md5( date( 'Y-m-d H:i:s' ) ) . '-' . $count . '.' . $ext;
//			$moveFile = move_uploaded_file( $tmpName, $uploadDir . $name );
//			
//			// Double check the allowed file types
//			$attachSet = get_option( 'resume_attachments' );
//			$allowed   = strpos( $attachSet['allowed'], $ext );
//			if ( $allowed === false ){
//				$dbInsert = 'Error';
//				return $dbInsert;
//			}
//			if ( $moveFile ){
//				if ( $count > 1 ) {
//					$sep = ',';
//				} else {
//					$sep = '';
//				}
//				$dbInsert .= $sep . $name;
//				$count++;
//			} else {
//				echo 'Count not upload file ' . $_FILES[$input]['name'][$key] . '.<br/>';
//			}
//		}
//	}
//	
//	return  $dbInsert;
//}

// Delete file from the set folder in the rsjp in the wp-contents/uploads folder
function deleteFileFromUpload( $files, $folder ){
	foreach( $files as $file ){
		if ( $file ){
			if ( !( @unlink( WP_CONTENT_DIR . '/uploads/rsjp/' . $folder . '/' . $file ) ) ) {
				$message = '<p style="color:#A83434;"><b>' . __( 'Could not delete the attached file(s).' ) . '</b></p>';
				$deleted = false;
			} else {
				$message = '<p style="color:#369B38;"><b>' . __( 'Attached file(s) were successfully deleted.' ) . '</b></p>';
				$deleted = true;
			}
		}
	}	
	
	return array( $message, $deleted );
}

// Export Submissions List to CSV
function exportSubToCSV() {
	global $wpdb;
	
	$exportEntries = $wpdb->get_results( 'SELECT * FROM ' . SUBTABLE . ' ORDER BY lname ASC, fname ASC, pubdate DESC' );				
	$getFile       = fopen( resume_get_plugin_dir( 'path' ) . '/base-files/submission-entries.csv', 'w' );
	
	fputcsv( $getFile, array( __( 'First Name' ), __( 'Last Name' ), __( 'Address' ), __( 'Suite/Apt' ), __( 'City' ), __( 'State' ), 
							  __( 'Zip Code' ), __( 'Primary Number' ), __( 'Secondary Number' ), __( 'Email' ), __( 'Job' ), __( 'Attachments' ), __( 'Submit Date' )  ), ',' );
	foreach ( $exportEntries as $entry ) {
		$newline     = " \r\n";
		$attachments = explode( ',', $entry->attachment );
		
		foreach ( $attachments as $attachment ) {
			$attachedNames .= $attachment . $newline;
		}
		$getJobArg = array( 'numberposts'     => 1,
							'post_type'       => 'rsjp_job_postings',
							'name' => $entry->job ); 
		$getJob = get_posts( $getJobArg );
		fputcsv( $getFile, array( $entry->fname, $entry->lname, $entry->address, $entry->address2, 
								  $entry->city, $entry->state, $entry->zip, $entry->pnumber, $entry->snumber, 
								  $entry->email, $getJob[0]->post_title, $attachedNames, date( 'm/d/Y', strtotime( $entry->pubdate ) ) ), ',' );
		
		wp_reset_postdata();
	}
	fclose( $getFile );
}

// Export Submission to PDF
function exportSubToPDF( $id ) {
	global $wpdb;
	include( 'create-submission-pdf.php' );
	
	return $saveFile;
}
?>