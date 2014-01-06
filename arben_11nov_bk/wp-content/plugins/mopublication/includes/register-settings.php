<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Register all the WordPress settings for MoPublication plugin
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

function mopub_register_settings() {

    // general
    register_setting( 'mopub-settings', 'frm_general_appname' );
    register_setting( 'mopub-settings', 'frm_general_iconname' );
    register_setting( 'mopub-settings', 'frm_border_color' );
    register_setting( 'mopub-settings', 'frm_viewer_background' );

    // topbar
    register_setting( 'mopub-settings', 'frm_topbar_background' );
    register_setting( 'mopub-settings', 'frm_topbar_logo' );

    // menu
    register_setting( 'mopub-settings', 'frm_menu_background_color' );
    register_setting( 'mopub-settings', 'frm_menu_textcolor' );
    register_setting( 'mopub-settings', 'frm_menu_active_background_color' );
    register_setting( 'mopub-settings', 'frm_menu_textcolor_inactive' );

    // images
    register_setting( 'mopub-settings', 'frm_images_splash' );
    register_setting( 'mopub-settings', 'frm_images_appicon' );

    // Multimedia categories
    register_setting( 'mopub-settings', 'frm_video_cat' );
    register_setting( 'mopub-settings', 'frm_audio_cat' );

    // type
    register_setting( 'mopub-settings', 'frm_type_title_color' );
    register_setting( 'mopub-settings', 'frm_type_meta_color' );
    register_setting( 'mopub-settings', 'frm_type_link_color' );
    register_setting( 'mopub-settings', 'frm_type_text_color' );
    register_setting( 'mopub-settings', 'frm_type_font_type' );

    // Bottom Menu
    register_setting( 'mopub-settings', 'frm_menu_bottom_order' );
    register_setting( 'mopub-settings', 'frm_menu_top_order' );

    //system tabs
    register_setting( 'mopub-settings', 'frm_checkbox_search' );
    register_setting( 'mopub-settings', 'frm_checkbox_videos' );
    register_setting( 'mopub-settings', 'frm_checkbox_audio' );
    register_setting( 'mopub-settings', 'frm_checkbox_categories' );
    register_setting( 'mopub-settings', 'frm_checkbox_tags' );
    register_setting( 'mopub-settings', 'frm_checkbox_about' );
    register_setting( 'mopub-settings', 'frm_checkbox_latest' );
    register_setting( 'mopub-settings', 'frm_checkbox_contact' );
    
    register_setting( 'mopub-settings', 'frm_layout' );
    register_setting( 'mopub-settings', 'mopub_tabs_order' );
    
    // top Menu
    $categories = get_categories(array('child_of' => 0,'orderby' => 'title','order' => 'ASC'));

    foreach($categories as $category) {
        $field = strtolower($category->name);
        $field = str_replace(" ", "-", $field);
        register_setting( 'mopub-settings', 'frm_cat_checkbox_'.$field );
    }
    register_setting( 'mopub-settings', 'frm_cat_checkbox_all' );

    // About
    register_setting( 'mopub-settings', 'frm_about_about' );

    // Contact
    register_setting( 'mopub-settings', 'frm_contact_email' );
    register_setting( 'mopub-settings', 'frm_contact_intro' );

    //Google Analytics
    register_setting( 'mopub-settings', 'frm_analytics_active' );
    register_setting( 'mopub-settings', 'frm_analytics_pubid' );

    register_setting( 'mopub-settings', 'frm_addthis_account' );
    register_setting( 'mopub-settings', 'frm_addthis_appid' );
    register_setting( 'mopub-settings', 'frm_addthis_pubid' );
    register_setting( 'mopub-settings', 'frm_addthis_username' );
    register_setting( 'mopub-settings', 'frm_addthis_twittername' );
    register_setting( 'mopub-settings', 'frm_addthis_shareurl' );

    // Ads
    register_setting( 'mopub-settings', 'frm_ad_status' );
    register_setting( 'mopub-settings', 'frm_ad_network' );
    register_setting( 'mopub-settings', 'frm_ad_pubid' );
    register_setting( 'mopub-settings', 'frm_ad_code_splash_iphone' );
    register_setting( 'mopub-settings', 'frm_ad_code_splash_ipad' );
    register_setting( 'mopub-settings', 'frm_ad_code_iphone_top' );
    register_setting( 'mopub-settings', 'frm_ad_code_iphone_bottom' );
    register_setting( 'mopub-settings', 'frm_ad_code_ipad_top' );
    register_setting( 'mopub-settings', 'frm_ad_code_ipad_bottom' );
    register_setting( 'mopub-settings', 'frm_ad_image_iphone_splash' );
    register_setting( 'mopub-settings', 'frm_ad_image_ipad_splash' );
    register_setting( 'mopub-settings', 'frm_ad_url_iphone_splash' );
    register_setting( 'mopub-settings', 'frm_ad_url_ipad_splash' );
    register_setting( 'mopub-settings', 'frm_ad_image_iphone_top' );
    register_setting( 'mopub-settings', 'frm_ad_url_iphone_top' );
    register_setting( 'mopub-settings', 'frm_ad_image_iphone_bottom' );
    register_setting( 'mopub-settings', 'frm_ad_url_iphone_bottom' );
    register_setting( 'mopub-settings', 'frm_ad_image_ipad_top' );
    register_setting( 'mopub-settings', 'frm_ad_url_ipad_top' );
    register_setting( 'mopub-settings', 'frm_ad_image_ipad_bottom' );
    register_setting( 'mopub-settings', 'frm_ad_url_ipad_bottom' );
    register_setting( 'mopub-settings', 'frm_admob_id' );
    
    // Config file
    register_setting( 'mopub-settings', 'frm_config_file' );
    register_setting( 'mopub-settings', 'site_wordpress_url');

    // App store

    register_setting( 'mopub-settings', 'frm_language' );
    register_setting( 'mopub-settings', 'frm_countries' );
    register_setting( 'mopub-settings', 'frm_countries_select' );
    register_setting( 'mopub-settings', 'frm_category_primary' );
    register_setting( 'mopub-settings', 'frm_category_secondary' );

    register_setting( 'mopub-settings', 'frm_age_fantasy_violence' );
    register_setting( 'mopub-settings', 'frm_age_realistic_violence' );
    register_setting( 'mopub-settings', 'frm_age_sexual' );
    register_setting( 'mopub-settings', 'frm_age_profanity' );
    register_setting( 'mopub-settings', 'frm_age_drug' );
    register_setting( 'mopub-settings', 'frm_age_mature' );
    register_setting( 'mopub-settings', 'frm_age_gambling' );
    register_setting( 'mopub-settings', 'frm_age_horror' );
    register_setting( 'mopub-settings', 'frm_age_graphic_violence' );
    register_setting( 'mopub-settings', 'frm_age_graphic_sexual' );

    register_setting( 'mopub-settings', 'frm_app_description' );
    register_setting( 'mopub-settings', 'frm_app_keywords' );
    
    //XML feed
    register_setting( 'mopub-settings', 'frm_protect_xml' );
    
    //Content
    register_setting( 'mopub-settings', 'frm_strict_filtering' );
    
    //Comments
    register_setting( 'mopub-settings', 'frm_comment_support' );
    register_setting( 'mopub-settings', 'frm_comment_option' );
    register_setting( 'mopub-settings', 'frm_disqus_short_name' );
    register_setting( 'mopub-settings', 'frm_disqus_api_key' );
    register_setting( 'mopub-settings', 'frm_disqus_user_api_key' );
    
    

}
