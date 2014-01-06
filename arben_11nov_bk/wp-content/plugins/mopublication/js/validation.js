/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Client side validation
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

jQuery(document).ready(function() {

    jQuery('#mopub_save, #mopub_save_ajax').click(function() {
        if (validate_save()) {
            return true;
        } else {
            return false;
        }
    })

    jQuery('#mopub_submit').click(function()
    {
        if (! validate_submission() )
        {
            return false;
        }

        //save changes before submit
        //jQuery('#mopub_save_ajax').click();
        mopub_do_save(true);

    })

    jQuery('.mp_input, .mp_textarea, form#mopub_config input, form#mopub_config textarea').change(function() {
        jQuery('#mopub_save_ajax').val('Save changes');
        jQuery('#mopub_save_ajax').removeAttr('disabled');
    })

    jQuery('.mp_input, .mp_textarea, form#mopub_config input, form#mopub_config textarea').on('keypress', function() {
        jQuery('#mopub_save_ajax').val('Save changes');
        jQuery('#mopub_save_ajax').removeAttr('disabled');
    })

});


/**
 * Validate the form contents when we save
 */
function validate_save()
{
    //don't validate required fields here - rather do it on submission

    return true;
}


/**
 * Validate before we submit the configuration file to MoPublication
 */
function validate_submission()
{

    //create array of required fields which are missing
    var missing = [];

    if ( trim(jQuery('#frm_general_appname').val()) == "" )
    {
        missing.push('Customize: General > App Name');
    }
    
    if ( trim(jQuery('#frm_general_iconname').val()) == "" )
    {
        missing.push('Customize: General > Icon Name');
    }

    if ( trim(jQuery('#frm_app_description').val()) == "" )
    {
        missing.push('Customize: General > Description');
    }

    if ( trim(jQuery('#frm_app_keywords').val()) == "" )
    {
        missing.push('Customize: General > Keywords');
    }

    if ( trim(jQuery('#frm_border_color').val()) == "" )
    {
        missing.push('Customize: Content Area > Border Color');
    }

    if ( trim(jQuery('#frm_viewer_background').val()) == "" )
    {
        missing.push('Customize: Content Area > Background Color');
    }

    // == Top bar ==

    if ( trim(jQuery('#frm_topbar_background').val()) == "" )
    {
        missing.push('Customize: Top Bar > Background Color');
    }

    // == Menu ==

    if ( trim(jQuery('#frm_menu_background_color').val()) == "" )
    {
        missing.push('Customize: Menu > Background Color');
    }

    if ( trim(jQuery('#frm_menu_textcolor').val()) == "" )
    {
        missing.push('Customize: Menu > Text Color');
    }

    if ( trim(jQuery('#frm_menu_textcolor_inactive').val()) == "" )
    {
        missing.push('Customize: Menu > Text Color (inactive)');
    }

    // == Images ==

    if ( trim(jQuery('#frm_topbar_logo').val()) == "" )
    {
        missing.push('Customize: Images > Logo Image');
    }

    if ( trim(jQuery('#frm_images_appicon').val()) == "" )
    {
        missing.push('Customize: Images > App Icon');
    }

    // == Typography ==

    if ( trim(jQuery('#frm_type_title_color').val()) == "" )
    {
        missing.push('Customize: Typography > Title Color');
    }

    if ( trim(jQuery('#frm_type_meta_color').val()) == "" )
    {
        missing.push('Customize: Typography > Meta Color');
    }

    if ( trim(jQuery('#frm_type_link_color').val()) == "" )
    {
        missing.push('Customize: Typography > Link Color');
    }

    if ( trim(jQuery('#frm_type_text_color').val()) == "" )
    {
        missing.push('Customize: Typography > Text Color');
    }


    if ( missing.length > 0 )
    {
        var message = 'Hang on! Please fill in the required field(s):' + "\n\n";
        for (var j in missing) {
            message += missing[j] + "\n";
        }
        alert(message);
        return false;
    }

    // validate email
    if ( trim(jQuery('#frm_contact_email').val()) != "" && ! validateEmail(jQuery('#frm_contact_email').val()) )
    {
        alert('Your Contact Email address is not valid.');
        return false;
    }

    // check for minimum one tickbox per group
    if (
        ! jQuery('#frm_checkbox_pages').attr('checked') &&
        ! jQuery('#frm_checkbox_recent').attr('checked') &&
        ! jQuery('#frm_checkbox_categories').attr('checked') &&
        ! jQuery('#frm_checkbox_search').attr('checked') &&
        ! jQuery('#frm_checkbox_videos').attr('checked') &&
        ! jQuery('#frm_checkbox_audio').attr('checked') &&
        ! jQuery('#frm_checkbox_tags').attr('checked') &&
        ! jQuery('#frm_checkbox_archive').attr('checked') &&
        ! jQuery('#frm_checkbox_about').attr('checked')
        )
    {
        alert('You must select at least one Tab Menu item to display.');
        return false;
    }

    //Minimum one category checkbox
    $checkboxes = jQuery('input[id^=frm_cat_checkbox_][checked=checked]');
    if ($checkboxes.length < 1)
    {
        alert('You must select at least one Category to use.');
        return false;
    }

    // Advanced

    if ( jQuery('#frm_age_graphic_violence').val() != "none" || jQuery('#frm_age_graphic_sexual').val() != "none" )
    {
        alert("Your app may not contain Prolonged Graphic or Sadistic Realistic Violence or Graphic Sexual Content and Nudity. It will be rejected by the App Store.");
        return false;
    }

    // If videos tab has been selected then make the video category required 
    if (jQuery('#frm_checkbox_videos').attr('checked')) {
       
       var videoCat = jQuery('#frm_video_cat').val();
       
       if(videoCat == '') {
           
           alert("Please select video category.");
           return false;
           
       }
       
    }
    
    //if the user has selected the Disqus option then Disqus shortname is required.
    if(jQuery('#frm_comment_option').val() == 'disqus') {
        
        
        if(jQuery('#frm_disqus_short_name').val() == '') {
            
            alert('Disqus shortname is required.');
            return false;
        }
        
    }
    
    // If audio tab has been selected then make the audio category required 
    if (jQuery('#frm_checkbox_audio').attr('checked')) {
       
       var videoCat = jQuery('#frm_audio_cat').val();
       
       if(videoCat == '') {
           
           alert("Please select audio category.");
           return false;
           
       }
       
       
    }
    
    // Check that they have agreed to the Terms of Service

    if ( ! jQuery('#agree_terms').is(':checked') )
    {
        alert("Please agree to the Terms of Service.");
        return false;
    }

    //everything above has succeeded
    return true;
}

/**
 * Read here for why "validating e-mail addresses with regular expressions is probably a bad idea" :)
 * http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
 *
 * @param email
 * @return {Boolean}
 */
function validateEmail(email)
{
    var regex = /\S+@\S+\.\S+/;
    return regex.test(email);
}


/**
 *  Javascript trim, ltrim, rtrim
 *  http://www.webtoolkit.info/
 *
 *  Using this method instead of jQuery because of old jQuery ver in WordPress
 **/

function trim(str, chars) {
    return ltrim(rtrim(str, chars), chars);
}

function ltrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}

function rtrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}