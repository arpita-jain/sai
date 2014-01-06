<?php
/**
*  MoPublication plugin for WordPress
*  http://www.mopublication.com
*
*  App name validation
*  Connects to the Grenade web service
*
*  (c) 2012 Grenade Technologies, South Africa
*  http://www.grenadeco.com
*/
?>

<script>

jQuery(document).ready(function () {

    jQuery('#frm_general_appname').focusout(function () {

        var appName = jQuery('#frm_general_appname').val();

        jQuery('#appNameStatus').html(" Looking up app name...");
        jQuery('#frm_general_appname').css("background", "#FFF").css("color", "#000");
        
        if(appName != '') { 
            
            checkAppName(appName);
            
        } else {
            
            jQuery('#appNameStatus').html(" An app name is required.");
            jQuery('#appNameStatus').removeClass();
            jQuery('#frm_general_appname').css("background", "red").css("color", "#FFF");
            
        }
        
    });
    
    //Removed for now
    /*jQuery('#frm_general_iconname').focusout(function () {

        var iconName = jQuery('#frm_general_iconname').val();
            
        iconName = encodeURI(iconName);
        iconName = iconName.replace(/'/g, "\\'");

        jQuery('#iconNameStatus').html(" Looking up icon name...");
        jQuery('#frm_general_iconname').css("background", "#FFF").css("color", "#000");
        checkIconName(iconName);
    });*/

});

function checkAppName(appName) {
    
    appName = encodeURI(appName);
    appName = appName.replace(/'/g, "\\'");
    
    if(appName == 'appName') {
        
        jQuery('#appNameStatus').html(" An app name is required.");
        jQuery('#appNameStatus').removeClass();
        jQuery('#frm_general_appname').css("background", "red").css("color", "#FFF");
        
    } else {

        jQuery.getJSON("http://www.mopublication.com/service/app_name_service.php?&location=<?php echo home_url(); ?>&appname="+appName+"&callback=?",
            function(data){

                var objReturn = data;

                if (objReturn.appExists == 'yes') {

                    jQuery('#appNameStatus').html(" An app already exists with this name.");
                    jQuery('#appNameStatus').removeClass();
                    jQuery('#frm_general_appname').css("background", "red").css("color", "#FFF");

                }

                if (objReturn.appExists == 'no') {

                    jQuery('#appNameStatus').html(" This app name is valid.");
                    jQuery('#appNameStatus').removeClass();
                    jQuery('#frm_general_appname').css("background", "greenyellow");

                }

                if (objReturn.appExists == 'empty') {

                    jQuery('#appNameStatus').html(" An app name is required.");
                    jQuery('#appNameStatus').removeClass();
                    jQuery('#frm_general_appname').css("background", "red").css("color", "#FFF");

                }

                if (objReturn.message) {

                    jQuery('#appNameStatus').html(objReturn.message);
                    jQuery('#appNameStatus').removeClass();
                    jQuery('#frm_general_appname').css("background", "red").css("color", "#FFF");

                }


            });

    }
}

function checkIconName(iconName) {
    
    iconName = encodeURI(iconName);
    iconName = iconName.replace(/'/g, "\\'");
    
    if(iconName == '') {
        
        jQuery('#iconNameStatus').html(" An icon name is required.");
        jQuery('#iconNameStatus').removeClass();
        jQuery('#frm_general_iconname').css("background", "red").css("color", "#FFF");
        
    } else {

        jQuery.getJSON("http://www.mopublication.com/service/app_name_service.php?&location=<?php echo home_url(); ?>&appname="+iconName+"&callback=?",
            function(data){

            var objReturn = data;

            if (objReturn.appExists == 'yes') {

                jQuery('#iconNameStatus').html(" An app already exists with this name.");
                jQuery('#iconNameStatus').removeClass();
                jQuery('#frm_general_iconname').css("background", "red").css("color", "#FFF");

            }

            if (objReturn.appExists == 'no') {

                jQuery('#iconNameStatus').html(" This icon name is valid.");
                jQuery('#iconNameStatus').removeClass();
                jQuery('#frm_general_iconname').css("background", "greenyellow");

            }

            if (objReturn.appExists == 'empty') {

                jQuery('#iconNameStatus').html(" An icon name is required.");
                jQuery('#iconNameStatus').removeClass();
                jQuery('#frm_general_iconname').css("background", "red").css("color", "#FFF");

            }

        });

    }
}

</script>