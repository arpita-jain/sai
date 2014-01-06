/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  JavaScript
 *  For the live app demo, responsive resize handling
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

jQuery(function() {
    
    jQuery('.categoriesToInclude').click(function(){
       updateCategoriesOrder();
    });
    
    
    //Workout if 'all' should be checked or not
    var categoryOrder = jQuery('#frm_menu_bottom_order').val();
    if (categoryOrder == '') {
        jQuery('#frm_cat_checkbox_all').attr('checked', 'checked');
    }
    
    jQuery( "#pagessortable" ).sortable({
        update: function ()
        {
            updatePagesOrder();
        }
    });

    jQuery('.tabsToInclude').live("click", function()
    { 
        updatePagesOrder(); 
    });
    
    jQuery( "#pagessortable" ).disableSelection();

    jQuery( "#categoriessortable" ).sortable({
        update: function ()
        {
            updateCategoriesOrder();
        }
    });

    jQuery( "#categoriessortable" ).disableSelection();
    
});

function updateCategoriesOrder() {

    var demoMenu = '';
    var i = 0;
    var order = '';
    jQuery('#categoriessortable').find('li').each( function () {

        var itemClass = "";
        if(i == 0)
        {
            itemClass = 'current';
        } else {
           itemClass = 'inactive'; 
        }

        var cb = jQuery(this).find(":checkbox")[0];
        
        if (cb.checked) {
            var catName = jQuery(this).attr("id");
            catName = catName.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
            catName = catName.replace(/-/g, ' ');

            demoMenu = demoMenu + "<li class="+ itemClass +"><a href='#'><span>" + catName + "</span></a></li>";
            i++;
        }

        order = order + jQuery(this).attr("id") + ", ";

    });

    jQuery('#frm_menu_bottom_order').val(order);
    jQuery("#demo_menu_items").html(demoMenu);
}

jQuery(document).ready(function(){
    
   setPageLayout();
   
   var dirty = false;
   jQuery('input').live("change", function()
    { 
        dirty = true;
    });
   
   var oldDemoBody = jQuery(".demo_body").html();
    
   jQuery('.showPreview').live("click", function()
    {
        var pageID = jQuery(this).attr('alt');
        
        /*if(dirty == true) {
            
            alert('There are some unsaved changes, these wont be shown in the preview until saved.');
            
        }*/
        
        jQuery('.previewOptions').html('Preview');
        jQuery('.previewOptions').removeClass('closePreview');
        jQuery('.previewOptions').addClass('showPreview');
        
        jQuery(this).removeClass('showPreview');
        jQuery(this).addClass('closePreview');
        
        jQuery(this).html('Close preview');
        
        jQuery(".demo_body").html('<iframe src="'+WPULRS.permalinkstructure+'type=mobile&article_id='+pageID+'&key='+WPULRS.key+'&t='+WPULRS.t+'" height="250" width="255"></iframe>');
         
        return false;
            
    });
    
    jQuery('.closePreview').live("click", function()
    {   
        jQuery(this).removeClass('closePreview');
        jQuery(this).addClass('showPreview');
        
        jQuery(this).html('Preview');
        
        jQuery(".demo_body").html(oldDemoBody);
        
        setPageLayout();
        
        return false;
    });

    jQuery('#tabs .panel').hide();
    jQuery('#tabs .panel:first').show();
    jQuery('#tabs ul.tabs li:first').addClass('active');
    jQuery('.tabnav').click(function(){
        
        jQuery('html, body').animate({scrollTop: 0}, 'fast');
        jQuery('#tabs ul.tabs li').removeClass('active');

        jQuery('#tabs ul.tabs li'+jQuery(this).attr('href')+'-panel').addClass('active');

        var currentTab = jQuery(this).attr('href');
        jQuery('#tabs .panel').hide();
        jQuery(currentTab).show();

        return false;
        
    });

    var bodywidth = jQuery("body").width();
    if(bodywidth < 1200 ) {
        jQuery('.mopub_wrap').addClass('narrow');

    }
    else
    {
        jQuery('.mopub_wrap').removeClass('narrow');
    }

    /**
     * Update the font family in app preview if the selection is changed
     */
    jQuery('input[name=frm_type_font_type]').change(function() {
        jQuery('.mopub_demo .viewer').css('font-family', jQuery(this).closest('div.font-style').css('font-family'));
    })

    /**
     * Update the layout style in app preview if the selection is changed
     */
    jQuery('input[name=frm_layout]').change(function() {
        jQuery('.mopub_demo .viewer').removeClass('plain');
        jQuery('.mopub_demo .viewer').removeClass('featured');
        jQuery('.mopub_demo .viewer').removeClass('page');
        jQuery('.mopub_demo .viewer').removeClass('grid');
        jQuery('.mopub_demo .viewer').addClass(jQuery(this).attr("value"));
        jQuery('.mopub_demo .viewer').addClass(jQuery(this).attr("value"));
         
        setPageLayout();
         
    })

    /**
     * Show / hide the example ad depending on Ad setting
     */
    jQuery('#frm_ad_status').change(function() {

        var defaultImagePath = jQuery('#demoAdvertDefault').attr('src');
        var defaultCustomImagePath = jQuery('#demoAdvertCustomDefault').attr('src');
        
        if (jQuery('#frm_ad_status').val() == 'none') {
            
            jQuery('.mopub_demo .ad_display').hide();
            jQuery('#demoAdvertTemp').hide();
            jQuery('#demoAdvert').hide();
            jQuery('#demo_ad_embed_code').hide();
            jQuery('#demo_ad_embed_code_temp').html('');
            
        }
        if(jQuery('#frm_ad_status').val() == 'custom_ad'){
            
            jQuery('#demo_ad_embed_code').hide();
            jQuery('#demo_ad_embed_code_temp').hide();
            jQuery('.mopub_demo .ad_display').show();
            jQuery('#demoAdvert').hide();
            jQuery('#demoAdvertTemp').show();
            jQuery('#demoAdvertTemp').attr('src', defaultCustomImagePath);
            jQuery('#demo_ad_embed_code_temp').html('');
            
        }
        if(jQuery('#frm_ad_status').val() == 'ad_embed_code') {
            jQuery('#demo_ad_embed_code_temp').html('');
            var adCode = jQuery('#frm_ad_code_iphone_top').val();
            jQuery('.mopub_demo .ad_display').show();
            jQuery('#demoAdvertTemp').hide();
            jQuery('#demoAdvert').hide();
            jQuery('#demo_ad_embed_code_temp').show();
            jQuery('#demo_ad_embed_code_temp').html("Press 'Save Changes' to preview your banner.");
            
            return false; 
        }
        if(jQuery('#frm_ad_status').val() == 'admob'){
            
            jQuery('#demoAdvert').hide();
            jQuery('.mopub_demo .ad_display').show();
            jQuery('#demoAdvertTemp').show();
            jQuery('#demo_ad_embed_code').hide();
            jQuery('#demo_ad_embed_code_temp').hide();
            jQuery('#demoAdvertTemp').attr('src', defaultImagePath);
            jQuery('#demo_ad_embed_code_temp').html('');
            
        }
        
        return false; 
    })
    
    jQuery("#frm_topbar_background, #frm_menu_background_color, #frm_menu_textcolor, #frm_menu_textcolor_inactive, #frm_menu_active_background_color," +
    "#frm_type_title_color, #frm_type_meta_color, #frm_type_link_color, #frm_type_text_color, #frm_border_color," +
    "#frm_viewer_background, #frm_menu_active_background_color").miniColors({
    change: function(hex, rgb) {

        switch (this.id)
        {
            case 'frm_topbar_background':
                jQuery('.demo_topbar').css('background-color', hex);
                dirty = true;
                break;

            case 'frm_menu_background_color':
                jQuery('.demo_menu').css('background-color', hex);
                dirty = true;
                break;

            case 'frm_menu_textcolor':
                jQuery('.demo_menu .current a').css('color', hex);
                dirty = true;
                break;

            case 'frm_menu_textcolor_inactive':
                jQuery('.demo_menu .inactive a').css('color', hex);
                dirty = true;
                break;

            case 'frm_type_title_color':
                jQuery('.demo_article h3 a').css('color', hex);
                dirty = true;
                break;

            case 'frm_type_meta_color':
                jQuery('.demo_article .meta').css('color', hex);
                dirty = true;
                break;

            case 'frm_type_link_color':
                jQuery('.demo_body p a').css('color', hex);
                dirty = true;
                break;

            case 'frm_type_text_color':
                jQuery('.demo_body').css('color', hex);
                dirty = true;
                break;

            case 'frm_border_color':
                jQuery('.demo_article').css('border-color', hex);
                dirty = true;
                break;

            case 'frm_viewer_background':
                jQuery('.mopub_demo .demo_body').css('background-color', hex);
                dirty = true;
                break;

            case 'frm_menu_active_background_color':
                jQuery('.mopub_demo #demo_menu_items .current a').css('background-color', hex);
                dirty = true;
                break;

        }

    }
});

});

jQuery(window).resize(function() {
    var bodywidth = jQuery("body").width();
    if(bodywidth < 1200 ) {
        jQuery('.mopub_wrap').addClass('narrow');
        jQuery('.frm_left .show_tooltip').css('display', 'inline');
        jQuery('.frm_left .show_tooltip').css('float', 'none');
        jQuery('.frm_left_right').css('float', 'none');
        jQuery('.frm_left_right').css('display', 'inline');
    }
    else
    {
        jQuery('.mopub_wrap').removeClass('narrow');
        jQuery('.frm_left .show_tooltip').css('display', 'inline');
        jQuery('.frm_left .show_tooltip').css('float', 'right');
        jQuery('.frm_left_right').css('float', 'right');
        jQuery('.frm_left_right').css('display', 'block');
    }
});

function setPageLayout() {
    var imageurl = 'url('+jQuery('.demo_body .demo_article_1 img').attr('src')+')'; 
    jQuery('.demo_body .demo_article_1 .imageview').css('background-image', imageurl);
    jQuery('.demo_body .demo_article_1 .imageview').css('background-size', 'cover');
    jQuery('.demo_body .demo_article_1 .imageview').css('background-position', 'center center');
    jQuery('.demo_body .demo_article_1 .imageview').css('background-repeat', 'no-repeat'); 
    jQuery('.demo_body .demo_article_1 .imageview').css('top', '0'); 
    jQuery('.demo_body .demo_article_1 .imageview').css('right', '0'); 
    jQuery('.demo_body .demo_article_1 .imageview').css('bottom', '0'); 
    jQuery('.demo_body .demo_article_1 .imageview').css('left', '0'); 
    
}

    function updatePagesOrder(liveItem) {
        
        var order = new Array();
        var demoMenu = '';
        var i = 1;
        var xcount = 0;
        var more = false;
        var numChecked = 0;

        //workout the number of tabs that have been checked
        jQuery('#pagessortable').find('li').each( function () {
            var cb = jQuery(this).find(":checkbox")[0];
            if (cb.checked) {
                numChecked++;
            }
        });
        
        jQuery('#pagessortable').find('li').each( function () {

            var cb = jQuery(this).find(":checkbox")[0];
            
            if(numChecked > 5) {
                
                if (cb.checked && i < 5 && more == false)
                {
                    demoMenu = demoMenu + '<li class="icon_'+ jQuery(this).children().children().attr("alt") +'"><a>'+ jQuery(this).children().children().attr("title") +'</a></li>';
                    i++;
                }

                if(i == 5 && more == false)
                {
                    demoMenu = demoMenu + '<li class="icon_more"><a href="#">More</a></li>';
                    more = true;
                }

            } else {

                if (cb.checked) {
                    demoMenu = demoMenu + '<li class="icon_'+ jQuery(this).children().children().attr("alt") +'"><a href="#">'+ jQuery(this).children().children().attr("title") +'</a></li>';
                    i++;
                }
                
            }

            order[xcount] = jQuery(this).attr("id");
            xcount++;
        });

        jQuery.post(ajaxurl, {action: "updatePagesOrder", order: order}, function(response)
        {   
            jQuery('#mopub_tabs_order').val(response);
        });
        
        //console.log(demoMenu);
        
        jQuery("#tab_menu_items").html(demoMenu);

    }
