/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Ajax calls script for the MoPublication Wordpress plugin
 *  using sneaky / clever method on
 *  http://stackoverflow.com/questions/10873537/saving-wordpress-settings-api-options-with-ajax
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

jQuery(function ($) {

    $('#mopub_save_ajax').click(function()
    {
        mopub_do_save(false);
    });

})

function mopub_do_save(do_submit) {

    jQuery('#mopub_save_ajax').attr('disabled', 'disabled');
    jQuery('#mopub_save_ajax').val('Saving...');

    data = jQuery("#mopub_config").serialize();
    
    saveTabs();

    jQuery.post('options.php', data, function(response) {   //note posting to options.php

    }).error( function() {
        alert('There was a problem saving your changes. Please try again.');

    }).success( function() {
        jQuery('#mopub_save_ajax').removeAttr('disabled');
        jQuery('#mopub_save_ajax').val('Save Changes');

        if (do_submit) {
            jQuery('#alert').html('Changes saved. Submitting...').show();
        }
        
        //update the page template
        jQuery.post(ajaxurl, {action: "generateMobileTemplate", forceRefresh: 'true'});
        
        //update the contents of the config file using another ajax call
        jQuery.post(ajaxurl, {action: "mopub_get_config_xml"}, function(response)
        {
            jQuery("#frm_config_file").val(response);
            jQuery("#config_file").val(response);

            // save into the db again!! because the frm_config_file now has correct value
            data = jQuery("#mopub_config").serialize();
            jQuery.post('options.php', data, function(response) {

                if (do_submit) {

                    jQuery.post(ajaxurl, { action: 'moPubEmailConfig' }, function(response)
                    {
                        //finally do the submission
                        jQuery("#submitApp").submit();
                    });
                }
            });
        });

        if (!do_submit) {
            jQuery('#alert').html('Changes saved.').show();
            jQuery('#alert').delay(2800).fadeOut();
        }

    });

}

/**
 * Loops throug the tabs and saves them.
 */
function saveTabs() {
    
    var ids = new Array();
    var xcount = 0;

    jQuery('#pagessortable').find('li').each( function () {
        
        ids[xcount] = jQuery(this).attr("alt");
        
        xcount++;
        
    });
    
    var length = ids.length,
    element = null;
    var zcount = 0
    var options = new Array();
    var values = new Array();
    
    for (var i = 0; i < length; i++) {
        
        option = ids[i];

        var value = '';
        if(jQuery('#'+option).is(':checked')) {

            value = 'on';

        }
        
        options[zcount] = option;
        values[zcount] = value;
        zcount++;
    
    }
    
    jQuery.post(ajaxurl, { action: 'mopubSaveTab', options: options, values: values }, function(response)
    {
        
        
        
    });
    
}