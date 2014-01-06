/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Media upload handling
 *
 *  adapted from http://www.webmaster-source.com/2010/01/08/using-the-wordpress-uploader-in-your-plugin-or-theme/
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

jQuery(document).ready(function() {
    var $input = null;
    jQuery('.upload_image_button').click(function()
    {
        var input_id = this.id.slice(0, -4);  //remove last 4 characters i.e. '_btn'
        $input = jQuery('#' + input_id);
        tb_show('', 'media-upload.php?TB_iframe=true');
        window.send_to_editor = function(html)
        {
            $html = jQuery(html);
            url = $html.attr('href');

            if ( ! validateFileType(input_id, url) ) {
                tb_remove();
                var allowed_types = jQuery('#' + input_id + '_allowed_types').val();
                alert('The file you selected did not match any of the allowed file types. (' + allowed_types + ')');
                return false;
            }

            //if this is an image, get the size as well
            var $img = jQuery($html.children('img'));
            if ($img.length > 0)
            {
                document.image_sizes = document.image_sizes || {};  //create if not already existing
                document.image_sizes[url] = { 'width' : $img.attr('width'), 'height' : $img.attr('height') };

                if ( ! validateImageSize(input_id, url) ) {
                    tb_remove();
                    alert('The image you selected did not meet the minimum size requirements.' + "\n\n" +
                        "Make sure you are selecting 'Full Size' before clicking Insert into Post.");
                    return false;
                }
            }

            //insert url into form field
            $input.val(url);

            //populate images in demo if appropriate
            if (input_id == 'frm_topbar_logo') {
                jQuery(".demo_topbar img").attr("src", url);
            }
            if (input_id == 'frm_ad_image_iphone_splash') {
                jQuery(".ad_display_iphone_splash img").attr("src", url);
            }
            if (input_id == 'frm_ad_image_ipad_splash') {
                jQuery(".ad_display_ipad_splash img").attr("src", url);
            }
            if (input_id == 'frm_ad_image_iphone_top') {
                jQuery(".ad_display_iphone_top img").attr("src", url);
            }
            if (input_id == 'frm_ad_image_iphone_bottom') {
                jQuery(".ad_display_iphone_bottom img").attr("src", url);
            }
            if (input_id == 'frm_ad_image_ipad_top') {
                jQuery(".ad_display_ipad_top img").attr("src", url);
            }
            if (input_id == 'frm_ad_image_ipad_bottom') {
                jQuery(".ad_display_ipad_bottom img").attr("src", url);
            }
            
            tb_remove();
        };
        return false;
    });

    jQuery('.mopub_upload').click(function() {
        jQuery(this).parent().find('input[type="button"]').click();
    });

});


function validateImageSize(element, url)
{
    var $min_height = jQuery('#' + element + '_min_height');
    var $min_width  = jQuery('#' + element + '_min_width');

    if ( $min_height.length == 0 || $min_width.length == 0 ) {
        return true;  // minimums not defined, so validation should pass.
    }

    if ( typeof document.image_sizes[url] == 'undefined' ) {
        return true;  // could not read size of uploaded image
    }

    if ( parseInt(document.image_sizes[url].width) < parseInt($min_width.val()) ) {
        //alert( parseInt(document.image_sizes[url].width) + ' < ' + parseInt($min_width.val()) );
        return false;
    }

    if ( parseInt(document.image_sizes[url].height) < parseInt($min_height.val()) ) {
        //alert( parseInt(document.image_sizes[url].height) + ' .. < ' + parseInt($min_height.val()) );
        return false;
    }

    return true;
}


function validateFileType(element, url)
{
    var $allowed = jQuery('#' + element + '_allowed_types');

    if ( $allowed.length == 0 ) {
        return true;  // file type not restricted, so validation should pass
    }

    var ext = url.substr(url.lastIndexOf('.') + 1).toUpperCase();

    if ( $allowed.val().toUpperCase().indexOf(ext) == -1 ) {
        return false;   // file extension wasn't found in the allowed list
    }

    return true;
}

