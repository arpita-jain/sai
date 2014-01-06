<?php

global $wpdb;

$update  = $_POST['update'];
$message = '';


$setFName      = array( $_POST['fnameShow'], $_POST['fnameReq'] );
$setLName      = array( $_POST['lnameShow'], $_POST['lnameReq'] );
$setAddress    = array( $_POST['addressShow'], $_POST['addressReq'] );
$setAddress2   = array( $_POST['address2Show'], $_POST['address2Req'] );
$setCity       = array( $_POST['cityShow'], $_POST['cityReq'] );
$setState      = array( $_POST['stateShow'], $_POST['stateReq'] );
$setZip        = array( $_POST['zipShow'], $_POST['zipReq'] );
$setPNumber    = array( $_POST['pnumberShow'], $_POST['pnumberReq'] );
$setSNumber    = array( $_POST['snumberShow'], $_POST['snumberReq'] );
$setEmail      = array( $_POST['emailShow'], $_POST['emailReq'] );
$setAttachment = array( $_POST['attachmentShow'], $_POST['attachmentReq'] );
$setCover      = array( $_POST['coverShow'], $_POST['coverReq'] );
$setResume     = array( $_POST['resumeShow'], $_POST['resumeReq'] );

$inputFieldsArray = array( 'fname' => $setFName, 'lname' => $setLName, 'address' => $setAddress, 'address2' => $setAddress2, 
						   'city' => $setCity, 'state' => $setState, 'zip' => $setZip, 'pnumber' => $setPNumber, 'snumber' => $setSNumber,
						   'email' => $setEmail, 'attachment' => $setAttachment, 'cover' => $setCover, 'resume' => $setResume );


if ( $update ){
	
	update_option( 'resume_input_fields', $inputFieldsArray );
	
	$message = '<div class="updated fade" id="message"><p>' . __( 'Input Fields have been updated.' ) . '</p></div>';
	
}

?>

<div class="wrap alternate">
	
    <div id="icon-rsjp-input" class="icon32"></div>
    <h2><?php _e( 'Input Fields' ); ?></h2>
    <?php echo $message; ?>
    <br class="a_break" style="clear: both;"/>
    <p><?php _e( 'Select which fields you would like to display on the Resume Form.' ); ?></p>
    <form name="inputFields" enctype="multipart/form-data" action="" method="post">
    <table class="widefat">
        <thead>
            <tr>
                <th scope="col"><?php _e( 'Field Name' ); ?></th>
                <th scope="col"><?php _e( 'Display' ); ?></th>
                <th scope="col"><?php _e( 'Required' ); ?></th>
            </tr>
        </thead>
        <tbody>
        	<tr>
            	<td><p><?php _e( 'First Name' ); ?></p></td>
                <td><input type="checkbox" name="fnameShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'fname', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="fnameReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'fname', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'Last Name' ); ?></p></td>
                <td><input type="checkbox" name="lnameShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'lname', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="lnameReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'lname', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'Address' ); ?></p></td>
                <td><input type="checkbox" name="addressShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'address', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="addressReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'address', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'Suite/Apt' ); ?></p></td>
                <td><input type="checkbox" name="address2Show" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'address2', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="address2Req" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'address2', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'City' ); ?></p></td>
                <td><input type="checkbox" name="cityShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'city', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="cityReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'city', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'State' ); ?></p></td>
                <td><input type="checkbox" name="stateShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'state', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="stateReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'state', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'Zip Code' ); ?></p></td>
                <td><input type="checkbox" name="zipShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'zip', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="zipReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'zip', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'Primary Number' ); ?></p></td>
                <td><input type="checkbox" name="pnumberShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'pnumber', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="pnumberReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'pnumber', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'Secondary Number' ); ?></p></td>
                <td><input type="checkbox" name="snumberShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'snumber', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="snumberReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'snumber', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'Email' ); ?></p></td>
                <td><input type="checkbox" name="emailShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'email', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="emailReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'email', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <!--<tr>
            	<td><p><?php _e( 'Attachments' ); ?></p></td>
                <td><input type="checkbox" name="attachmentShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'attachment', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="attachmentReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'attachment', 1 ), 1, 'check' ); ?> /></td>
            </tr>-->
            <tr>
            	<td><p><?php _e( 'Cover Letter' ); ?></p></td>
                <td><input type="checkbox" name="coverShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'cover', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="coverReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'cover', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            <tr>
            	<td><p><?php _e( 'Resume' ); ?></p></td>
                <td><input type="checkbox" name="resumeShow" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'resume', 0 ), 1, 'check' ); ?> /></td>
                <td><input type="checkbox" name="resumeReq" value="1" <?php echo checkIt( grabContents( get_option( 'resume_input_fields' ), 'resume', 1 ), 1, 'check' ); ?> /></td>
            </tr>
            
        </tbody>
        
             
    </table>
    <br />
        <input type="submit" name="update" value="<?php _e( 'Save Input Fields' ); ?>" class="button-primary" /></td>
    </form>
    
 
</div>