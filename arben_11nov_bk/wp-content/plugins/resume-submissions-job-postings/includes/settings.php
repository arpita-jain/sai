<?php
global $wpdb, $post;

// Resume Settings
$update  = $_POST['update'];
$message = '';
$wpPages = get_pages();

// Set the list array for the custom state option
if ( $_POST['useStateList'] == 'US' ){
	$saveList = stateList();
} else {
	$saveList = explode ( '|', $_POST['customStateList'] );
}

$captchaUse        = $_POST['captchaUse'];
$captchaPrivateKey = $_POST['captchaPrivateKey'];
$captchaPublicKey  = $_POST['captchaPublicKey'];
$captchaOptions    = array( 'theme' => $_POST['captchaTheme'], 'lang' => $_POST['captchaLang'] );
$formPage          = $_POST['formPage'];
$jobsPage          = $_POST['jobsPage'];
$showJobSearch     = $_POST['showJobSearch'];
$usewpautop        = $_POST['usewpautop'];
$useTinymce        = $_POST['useTinymce'];
$useTinymceQT      = $_POST['useTinymceQT'];
$attachments       = array( 'num' => $_POST['numAttachments'], 'allowed' => $_POST['allowedAttachments'], 'delete' => $_POST['deleteAttachments'] );
$customPDFBase     = $_POST['customPDFBase'];
$thankyoutext      = $_POST['thankyoutext'];
$stateList         = array( 'use' => $_POST['useStateList'], 'list' => $saveList );
$sendAdminEmailTo  = $_POST['sendAdminEmailTo'];
$emailUserFrom     = $_POST['emailUserFrom'];
$sendEmailToUser   = $_POST['sendEmailToUser'];
$userEmailSubject  = esc_html( $_POST['userEmailSubject'] );
$useremailcopy     = $_POST['useremailcopy'];

if ( $update ) {
	update_option( 'resume_captcha', $captchaUse );
	update_option( 'resume_captcha_private_key', $captchaPrivateKey );
	update_option( 'resume_captcha_public_key', $captchaPublicKey );
	update_option( 'resume_captcha_options', $captchaOptions );
	update_option( 'resume_form_page', $formPage );
	update_option( 'resume_jobs_page', $jobsPage );
	update_option( 'resume_show_job_search', $showJobSearch );
	update_option( 'resume_use_wpautop', $usewpautop );
	update_option( 'resume_use_tinymce', $useTinymce );
	update_option( 'resume_use_tinymce_qt', $useTinymceQT );
	update_option( 'resume_attachments', $attachments );
	update_option( 'resume_pdf_base_file', $customPDFBase );
	update_option( 'resume_thank_you_text', $thankyoutext );
	update_option( 'resume_state_list', $stateList );
	update_option( 'resume_send_admin_email_to', $sendAdminEmailTo );
	update_option( 'resume_email_user_from', $emailUserFrom );
	update_option( 'resume_send_email_to_user', $sendEmailToUser );
	update_option( 'resume_user_email_subject', $userEmailSubject );
	update_option( 'resume_user_email_copy', $useremailcopy );
	
	$message = '<div class="updated fade" id="message"><p>' . __( 'Settings have been updated.' ) . '</p></div>';
}

// If the wp_editor is not there, do not show the TinyMCE
if ( !function_exists( wp_editor ) ) {
	$tinymceOff = 'disabled="disabled"';
	$tinymceOffText = '<span style="font-size:10px; color:#CCC; font-style:italic; padding-left:10px;">' . __( 'Please upgrade to at least version 3.3 to use this feature.' ). '</span>';
} else {
	$tinymceOff = '';
	$tinymceOffText = '';
}

// Set the options to a varaible
$captchaOptions   = get_option( 'resume_captcha_options' );
$attachOptions    = get_option( 'resume_attachments' );
$stateListOptions = get_option( 'resume_state_list' );

// Get all of the states for the custom list
$stateCount = 0;
foreach ( $stateListOptions['list'] as $state ){
	$stateSep = ' | ';
	if ( $stateCount < 1 ) 
		$stateSep = '';
		
	$displayStateList .= $stateSep . $state;
	$stateCount++;
}
?>
<script language="javascript" type="text/javascript" src="<?php echo resume_get_plugin_dir( 'go' ); ?>/includes/jQuery/settings.js"></script>

<div class="wrap alternate">
	
    <div id="icon-rsjp-settings" class="icon32"></div>
    <h2><?php _e( 'Resume Settings' ); ?></h2>
    <?php echo $message; ?>
    <br class="a_break" style="clear: both;"/>
	
    <div id="rsjpLeftCol">
    	<div id="rsjpSettingsMenu">
        	<input type="image" value="Core" id="coreTab" src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/settings-menu/core.png" onclick='jsOpenSettings(this)' />
            <input type="image" value="reCaptcha" id="recaptchaTab" src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/settings-menu/recaptcha.png" onclick='jsOpenSettings(this)' />
            <input type="image" value="Attachments" id="attachmentsTab" src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/settings-menu/attachments.png" onclick='jsOpenSettings(this)' />
            <input type="image" value="Emailing" id="emailingTab" src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/settings-menu/emailing.png" onclick='jsOpenSettings(this)' />
            
        </div>
        <br />
        <form name='form' id='form' class='form' method='post' enctype="multipart/form-data">
        <table class="widefat" id="coreSettings">
        	<thead>
                <tr>
                    <th scope="col"><img src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/icons/core-options-icon-20.png" alt="Core Options" /><?php _e( 'Core Options' ); ?></th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><p><b><?php _e( 'Resume Form Page' ); ?>: </b></p></td>
                    <td align="left"><select name="formPage">
                                         <option value=""> -- Select -- </option>
                                         <?php 
                                         foreach ( $wpPages as $page ) {?>
                                             <option value="<?php echo get_page_link( $page->ID ); ?>" <?php echo checkIt( get_option( 'resume_form_page' ), get_page_link( $page->ID ), 'select' ); ?>><?php echo $page->post_title; ?></option>
                                             <?php
                                             }
                                         ?>
                                     </select></td>
                </tr>
                <tr>
                    <td width="150px"><p><b><?php _e( 'Display Jobs Page' ); ?>: </b></p></td>
                    <td align="left"><select name="jobsPage">
                                         <option value=""> -- Select -- </option>
                                         <?php 
                                         foreach ( $wpPages as $page ) {?>
                                             <option value="<?php echo get_page_link( $page->ID ); ?>" <?php echo checkIt( get_option( 'resume_jobs_page' ), get_page_link( $page->ID ), 'select' ); ?>><?php echo $page->post_title; ?></option>
                                             <?php
                                             }
                                         ?>
                                     </select></td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'Use wpautop()' ); ?>: </b></p></td>
                    <td align="left"><input type="radio" name="usewpautop" value="true" <?php echo checkIt( get_option( 'resume_use_wpautop' ), 'true', 'radio' ); ?> />Enabled 
                                     <input type="radio" name="usewpautop" value="false" <?php echo checkIt( get_option( 'resume_use_wpautop' ), 'false', 'radio' ); ?> />Disabled</td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'Use TinyMCE' ); ?>: </b></p></td>
                    <td align="left"><input type="radio" name="useTinymce" value="true" <?php echo checkIt( get_option( 'resume_use_tinymce' ), 'true', 'radio' ); ?> />Enabled 
                                     <input type="radio" name="useTinymce" value="false" <?php echo checkIt( get_option( 'resume_use_tinymce' ), 'false', 'radio' ); ?> />Disabled</td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'Use TinyMCE Quick Tags' ); ?>: </b></p></td>
                    <td align="left"><input type="radio" name="useTinymceQT" value="true" <?php echo checkIt( get_option( 'resume_use_tinymce_qt' ), 'true', 'radio' ); ?> />Enabled 
                                     <input type="radio" name="useTinymceQT" value="false" <?php echo checkIt( get_option( 'resume_use_tinymce_qt' ), 'false', 'radio' ); ?> />Disabled</td>
                </tr>
                <tr>
                    <td valign="top"><p><b><?php _e( 'PDF Base File' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='customPDFBase' size='100' value="<?php echo get_option( 'resume_pdf_base_file' ); ?>" /><br />
                                     <i style="font-size:10px;"><?php _e( 'Default' ); ?>: <?php echo resume_get_plugin_dir( 'path' ) . '/base-files/submission-entry.pdf'; ?></i></td>
                </tr>
                <tr>
                    <td valign="top"><p><b><?php _e( 'State List' ); ?>: </b></p></td>
                    <td align="left"><select name="useStateList" id="useStateList" onchange='jsOpenCustomList(this)'>
                                         <option value="US" <?php if ( $stateListOptions['use'] == 'US' ) echo 'selected="selected"';?>>US</option>
                                         <option value="<?php _e( 'Custom' ); ?>" <?php if ( $stateListOptions['use'] == 'Custom' ) echo 'selected="selected"';?>><?php _e( 'Custom' ); ?></option>
                                     </select></td>
                </tr>
                <tr id="customStateList">
                    <td valign="top"><p><b><?php _e( 'Custom State List' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='customStateList' size='100' <?php if ( $stateListOptions['use'] != 'US' ) echo 'value="' . $displayStateList . '"'; ?> /><br />
                                     <i style="font-size:10px;"><?php _e( 'Seperate with | Example: Florida | New York' ); ?></i></td>
                </tr>
                <tr>
                    <td valign="top"><p><b><?php _e( 'Thank You Text' ); ?>: </b></p></td>
                    <td align="left" height="250px"><?php wp_editor( get_option( 'resume_thank_you_text' ), 'thankyoutext', setTinySetting( 'thankyoutext', '15', false, true, true ) ); ?></td>
                </tr>
            </tbody>
        </table>
        <table class="widefat" id="recaptchaSettings">
        	<thead>
                <tr>
                    <th scope="col"><img src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/icons/recaptcha-icon-20.png" alt="reCaptcha" /><?php _e( 'reCaptcha' ); ?></th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="150px"><p><b><?php _e( 'Enable reCaptcha' ); ?>: </b></p></td>
                    <td align="left"><input type="radio" name="captchaUse" value="Enabled" <?php echo checkIt( get_option( 'resume_captcha' ), 'Enabled', 'radio' ); ?> />Enabled 
                                     <input type="radio" name="captchaUse" value="Disabled" <?php echo checkIt( get_option( 'resume_captcha' ), 'Disabled', 'radio' ); ?> />Disabled</td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'reCaptcha - Public Key' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='captchaPublicKey' size='60' value='<?php echo get_option( 'resume_captcha_public_key' ); ?>' /></td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'reCaptcha - Private Key' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='captchaPrivateKey' size='60' value='<?php echo get_option( 'resume_captcha_private_key' ); ?>' /></td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'Theme' ); ?>: </b></p></td>
                    <td align="left"><select name="captchaTheme">
                                         <option value="red" <?php if ( $captchaOptions['theme'] == 'red' ) echo 'selected="selected"';?>><?php _e( 'Red' ); ?></option>
                                         <option value="white" <?php if ( $captchaOptions['theme'] == 'white' ) echo 'selected="selected"';?>><?php _e( 'White' ); ?></option>
                                         <option value="blackglass" <?php if ( $captchaOptions['theme'] == 'blackglass' ) echo 'selected="selected"';?>><?php _e( 'Black Glass' ); ?></option>
                                         <option value="clean" <?php if ( $captchaOptions['theme'] == 'clean' ) echo 'selected="selected"';?>><?php _e( 'Clean' ); ?></option>
                                     </select></td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'Language' ); ?>: </b></p></td>
                    <td align="left"><select name="captchaLang">
                                         <option value="en" <?php if ( $captchaOptions['lang'] == 'en' ) echo 'selected="selected"';?>><?php _e( 'English' ); ?></option>
                                         <option value="nl" <?php if ( $captchaOptions['lang'] == 'nl' ) echo 'selected="selected"';?>><?php _e( 'Dutch' ); ?></option>
                                         <option value="fr" <?php if ( $captchaOptions['lang'] == 'fr' ) echo 'selected="selected"';?>><?php _e( 'French' ); ?></option>
                                         <option value="de" <?php if ( $captchaOptions['lang'] == 'de' ) echo 'selected="selected"';?>><?php _e( 'German' ); ?></option>
                                         <option value="pt" <?php if ( $captchaOptions['lang'] == 'pt' ) echo 'selected="selected"';?>><?php _e( 'Portuguese' ); ?></option>
                                         <option value="ru" <?php if ( $captchaOptions['lang'] == 'ru' ) echo 'selected="selected"';?>><?php _e( 'Russian' ); ?></option>
                                         <option value="es" <?php if ( $captchaOptions['lang'] == 'es' ) echo 'selected="selected"';?>><?php _e( 'Spanish' ); ?></option>
                                         <option value="tr" <?php if ( $captchaOptions['lang'] == 'tr' ) echo 'selected="selected"';?>><?php _e( 'Turkish' ); ?></option>
                                     </select></td>
                </tr>
            </tbody>
        </table>
        <table class="widefat" id="attachmentSettings">
        	<thead>
                <tr>
                    <th scope="col"><img src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/icons/attachments-icon-20.png" alt="Attachments" /><?php _e( 'Attachments' ); ?></th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="150px"><p><b><?php _e( 'Number of Attachments' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='numAttachments' size='40' value='<?php echo $attachOptions['num']; ?>' /></td>
                </tr>
                <tr>
                    <td valign="top"><p><b><?php _e( 'Allowed Attachments' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='allowedAttachments' size='40' value='<?php echo $attachOptions['allowed']; ?>' /><br />
                                     <i style="font-size:10px;"><?php _e( 'Seperate with | Example: pdf|docx' ); ?></i></td>
                </tr>
                <tr>
                    <td valign="top"><p><b><?php _e( 'Delete Attachments' ); ?>: </b></p></td>
                    <td align="left"><input type="radio" name="deleteAttachments" value="Enabled" <?php echo checkIt( $attachOptions['delete'], 'Enabled', 'radio' ); ?> />Enabled 
        
                                     <input type="radio" name="deleteAttachments" value="Disabled" <?php echo checkIt( $attachOptions['delete'], 'Disabled', 'radio' ); ?> />Disabled
                                     <br /><i style="font-size:10px;"><?php _e( 'Will delete the submission\'s attachment(s) when the submission is deleted' ); ?></i></td>
                </tr>
            </tbody>
        </table>
        <table class="widefat" id="emailingSettings">
        	<thead>
                <tr>
                    <th scope="col"><img src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/icons/emailing-icon-20.png" alt="Emailing" /><?php _e( 'Emailing' ); ?></th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="150px"><p><b><?php _e( 'Send Admin Email To' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='sendAdminEmailTo' size='40' value='<?php echo get_option( 'resume_send_admin_email_to' ); ?>' /></td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'Send User Email' ); ?>: </b></p></td>
                    <td align="left"><input type="radio" name="sendEmailToUser" value="Enabled" <?php echo $tinymceOff; ?> <?php echo checkIt( get_option( 'resume_send_email_to_user' ), 'Enabled', 'radio' ); ?> />Enabled 
                                     <input type="radio" name="sendEmailToUser" value="Disabled" <?php echo $tinymceOff; ?> <?php echo checkIt( get_option( 'resume_send_email_to_user' ), 'Disabled', 'radio' ); ?> />Disabled <?php _e( $tinymceOffText ); ?></td>
                </tr>    
                <tr>
                    <td><p><b><?php _e( 'Email User From' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='emailUserFrom' size='40' value='<?php echo get_option( 'resume_email_user_from' ); ?>' /></td>
                </tr>
                <tr>
                    <td><p><b><?php _e( 'User Email Subject' ); ?>: </b></p></td>
                    <td align="left"><input type='text' name='userEmailSubject' size='40' value='<?php echo get_option( 'resume_user_email_subject' ); ?>' /></td>
                </tr>
                <tr>
                    <td valign="top"><p><b><?php _e( 'User Email Copy' ); ?>: </b></p></td>
                    <td align="left" height="250px"><?php wp_editor( get_option( 'resume_user_email_copy' ), 'useremailcopy', setTinySetting( 'useremailcopy', '15', false, true, true ) ); ?></td>
                </tr>       
            </tbody>
        </table>
        <br />
        <input type="submit" value="Save Settings" name="update" class="button-primary" />
        </form>
	</div>
    
    
<!--    <div id="rsjpRightCol">
        <table class="widefat">
            <thead>
                <tr>
                    <th scope="col"><img src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/icons/questions-icon-20.png" alt="Helpful Hints" /><?php _e( 'Helpful Hints' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div id="resumeHints">
                        
                            <h3><?php _e( 'Adding Resume Form and Job Postings List to a Page' ); ?></h3>
                            <p><?php _e( 'In order to use this plugin correctly, the following shortcodes must be added to a page of your choosing.' ); ?></p>
                            <p><b><?php _e( 'To add the Resume Form' ); ?>:</b><br />
                            <code>[resumeForm]</code></p>
                            <p><b><?php _e( 'To add the Job Post Listings' ); ?>:</b><br />
                            <code>[jobPostings]</code></p>
                            <p><?php _e( 'Attributes' ); ?>: <code>orderby="<i>(post_date | post_title | etc..)</i>"</code>, <code>order="<i>(ASC | DESC)</i>"</code>, <code>archive="<i>(Show | Hide)</i>"</code>, <code>limit=""</code></p>
                            <p><b><?php _e( 'To show Resume Submissions' ); ?>:</b><br />
                            <code>[resumeDisplay]</code></p>
                            <p><?php _e( 'Attributes' ); ?>: <code>email=""</code>, <code>id=""</code>, <code>job="<i>(Job Posting Slug)</i>"</code>, <code>limit=""</code></p>
                            <p><?php _e( 'These will allow the admin to select which submissions they whould like to display. (Only choose one out of email, id, and job to use)' ); ?></p>
                            <p><i><code>email=''</code>, <code>id=''</code>, <code>job=''</code>, <code>limit=''</code></i></p> 
                            <br />
                                           
                            <h3><?php _e( 'User Email Copy Shortcodes' ); ?></h3>
                            <p><?php _e( 'The following shortcodes may be used in the "User Email Copy" field.' ); ?> <br />
                               <?php _e( 'If these are not used correctly, you will experience errors.' ); ?></p>
                            <p><i><code>%fname%</code>, <code>%lname%</code>, <code>%address%</code>, <code>%address2%</code>, <code>%city%</code>, <code>%state%</code>, <code>%zip%</code>, <code>%pnumber%</code>,<br />
                               <code>%pnumbertype%</code>, <code>%snumber%</code>, <code>%snumbertype%</code>, <code>%email%</code>, <code>%job%</code>, <code>%cover%</code>, <code>%resume%</code>, <code>%siteName%</code></i></p>
                            <br />
                            
                            <h3><?php _e( 'New Job Posting Format' ); ?></h3>
                            <p><?php _e( 'The way Job Postings are added has changed.' ); ?><br />
                               <?php _e( 'You can now add them just like you would a normal post or page.' ); ?> <br />
                               <?php _e( 'The "Archive" feature is still available as you will see a metabox with the checkbox in it.' ); ?><br />
                               <?php _e( 'The plugin will not recognize archived postings in it\'s other features.' ); ?></p>
                            <br />
                            
                            <h3><?php _e( 'Submit Resume Now Shortcode' ); ?></h3>
                            <p><?php _e( 'With the change to the Job Postings, the automatic form button has went away.' ); ?><br />
                               <?php _e( 'Instead you may add this shortcode to a posting to show the submit button.' ); ?> <br />
                               <code>[rsjpSubmit]</code></p>
                            <p><?php _e( 'Attributes' ); ?>: <code>job="<i>(Job Posting Slug)</i>"</code></p>
                            <p><?php _e( 'The attribute will allow you to hard code in a Job Posting, which gives you the ability to place anywhere on your site.' ); ?></p>
                            
                            <h3><?php _e( 'Attachments' ); ?></h3>
                            <p><?php _e( 'Submission attachments are stored in the' ); ?> <b>wp-content/uploads/rsjp/attachments/</b> <?php _e( 'folder.' ); ?><br />
                               <?php _e( 'The file names are renamed to the submission time which is md5 encoded.' ); ?><br />
                               <?php _e( 'We do this so no two files will be the same.' ); ?></p>
                            <br />
                            <h3><?php _e( 'How to Fix Possible Problems' ); ?></h3>
                            <p><?php _e( 'There may be times when something is not working right.' ); ?><br />
                               <?php _e( 'Here is how to fix some of those problems.' ); ?></p>
                            <br />
                            <p><b><?php _e( 'Problem' ); ?>:</b> <?php _e( 'The line breaks and styling in the forms are not carrying over.' ); ?></p>
                            <p><i><b><?php _e( 'Solution' ); ?>:</b> <?php _e( 'If it is not keeping the styles, switch the option "Use wpautop()" to Disabled. If this does not work, then I would look into adding the plugin "TinyMCE Advanced".' ); ?></i></p>
                            <br />
                            <p><b><?php _e( 'Problem' ); ?>:</b> <?php _e( 'I click on "Submit Resume for this Job", but nothing happens or the page is not found.' ); ?></p>
                            <p><i><b><?php _e( 'Solution' ); ?>:</b> <?php _e( 'Make sure to have the "Resume Form Page" field filled out to go to the page that has the Form shortcode in it.' ); ?></i></p>
                            <br />
                            <p><b><?php _e( 'Problem' ); ?>:</b> <?php _e( 'I cannot get the Captcha to work correctly.' ); ?></p>
                            <p><i><b><?php _e( 'Solution' ); ?>:</b> <?php _e( 'You must make sure that the Captcha Key fields are correctly filled out. Also, make sure that the url for those keys is the same url as this site.' ); ?></i></p>
                            <br />
                            <p><b><?php _e( 'Problem' ); ?>:</b> <?php _e( 'There is an error when downloading a Submission as a PDF.' ); ?></p>
                            <p><i><b><?php _e( 'Solution' ); ?>:</b> <?php _e( 'Make sure that the <b>PDF Base File</b> setting is calling the Document Root path and not the URL path.' ); ?></i></p>
                            
                            <br /> 
                            <p><b><?php _e( 'Problem' ); ?>:</b> <?php _e( 'When looking at a submission, I get a FPDI Error in the downloads box.' ); ?></p>
                            <p><i><b><?php _e( 'Solution' ); ?>:</b> <?php _e( 'The PDF that you use for the base file MUST be saved in the PDF/A format.' ); ?></i></p>
                            <br />                     
                            
                            <h3><?php _e( 'Report Bugs and Features Request' ); ?></h3>
                            <p><?php _e( 'If you would like to report any bugs or new features, please go to' ); ?> <a href="http://www.geerservices.com/" target="_blank">www.geerservices.com</a>.</p>
                            <p><?php _e( 'By reporting bugs or asking for other features, you are helping with the growth of this plugin.' ); ?></p>
                            <p><?php _e( 'If you would also like to donate to this plugin, ' ); ?><b><a href="http://www.geerservices.com/wordpress-plugins/resume-jobs" target="_blank"><?php _e( 'feel free' ); ?></a></b>!</p>
                            <br />
                            <center>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                <input type="hidden" name="cmd" value="_s-xclick" />
                                <input type="hidden" name="hosted_button_id" value="NK3VDD3C4SUXY" />
                                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" />
                                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                            </form>
                            </center>
                            <br />
                            <div style="width:300px; text-align:center; margin:0 auto;">
                                <p>Another <a href="http://www.geerservices.com" target="_blank">Geer Built&reg;</a> Project</p>
                                <a href="http://www.geerservices.com" target="_blank"><img src="<?php echo resume_get_plugin_dir( 'go' ); ?>/images/geer-built.png" /></a>
                            </div>
                        </div>    
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
-->
</div>