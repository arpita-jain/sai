/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Interface script for the MoPublication Wordpress plugin
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

jQuery(document).ready(function(){
 
    moPub_showAdManagementOption();
    showAddThisOption();
    showDisqusOption();
    
    jQuery('.iconOption').click(function(){
        
        var iconVal = jQuery(this).attr('alt');
        jQuery('#addPageIcon').val();

        jQuery('.iconOption').removeClass("img_icons_selected");
        jQuery(this).addClass("img_icons_selected");
        
        jQuery('#addPageIcon').val(iconVal);
        
    });
    
    jQuery('#frm_ad_status').change(function() {
        moPub_showAdManagementOption();
    });

    jQuery('#frm_addthis_account').change(function () {
       showAddThisOption();
    });

    jQuery('#frm_countries').change(function () {
       showCountriesOption();
    });

    jQuery('#frm_analytics_active').change(function () {
       showAnalyticsOption();
    });
    
    jQuery('#frm_comment_option').change(function(){
        showDisqusOption();
    });
    
    jQuery(document).resize();

});

function moPub_showAdManagementOption()
{
    jQuery('.ad_management').hide();
    var selectedCategory = jQuery('#frm_ad_status').val();
    jQuery("#"+selectedCategory).show();
}

function showDisqusOption() {
    
    if ( jQuery('#frm_comment_option').val() == 'disqus') {
        
        jQuery('#comment_disqus_options').show();
        
    } else {
        
        jQuery('#comment_disqus_options').hide();
        
    }
    
}

function showAddThisOption()
{
    if ( jQuery('#frm_addthis_account').val() == 'none' )
    {
        jQuery('#addthis_my_account').hide();
        jQuery('#addthis_mopub').hide();
        jQuery('#addthis_twitter').hide();
        
    } 
    if ( jQuery('#frm_addthis_account').val() == 'my_own' ) 
    {
        jQuery('#addthis_mopub').hide();
        jQuery('#addthis_my_account').show();
        jQuery('#addthis_twitter').show();
    }
    if ( jQuery('#frm_addthis_account').val() == 'mopub' ) 
    {
        jQuery('#addthis_my_account').hide();
        jQuery('#addthis_mopub').show();
        jQuery('#addthis_twitter').show();
    }
}

function showCountriesOption()
{
    if ( jQuery('#frm_countries').val() == 'all' )
    {
        jQuery('#countries_select').hide();
    } else {
        jQuery('#countries_select').show();
    }
}

function showAnalyticsOption()
{
    if ( jQuery('#frm_analytics_active').val() == 'true' )
    {
        jQuery('#mopub_options_analytics').show();
        jQuery('#mopub_options_analytics_off').hide();
    } else {
        jQuery('#mopub_options_analytics').hide();
        jQuery('#mopub_options_analytics_off').show();
    }
}

jQuery(function ($) {

    $('#select_all_countries').change (function () {
        //Check/uncheck all the list's checkboxes
        $('input.country').attr('checked', $(this).is(':checked'));
        //Remove the faded state
        $(this).removeClass('some_selected');
    });

    $('input.country').change (function () {
        if ($('input.country:checked').length == 0) {
            $('#select_all_countries').removeClass('some_selected').attr('checked', false);
        } else if ($('input.country:not(:checked)').length == 0) {
            $('#select_all_countries').removeClass('some_selected').attr('checked', true);
        } else {
            $('#select_all_countries').addClass('some_selected').attr('checked', true);
        }
    });

});

