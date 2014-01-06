<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Create the XML configuration file sent to Grenade
 *  for processing
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

$cleanCat_arr = array();

if (!isset($cat_arr))
{
    include_once 'get_categories.php';
}

foreach ($cat_arr as $cat)
{
    if(!empty($cat))
    {
        if (get_option('frm_cat_checkbox_' . str_replace(" ", "-", $cat))) {
            $cleanCat_arr[] = $cat;
        }
    }
}

//To do inner loop for 'all'
$cleanCat_arrSelected = $cleanCat_arr;

foreach ($cleanCat_arrSelected as $key => $catItem)
{
    if($catItem == 'all')
    {
        //remove 'all' item
        unset($cleanCat_arrSelected[$key]);
    }
}

?>

<moPublication_config>
    <cms>WordPress</cms>
    <company_logo_full><![CDATA[<?php echo get_option('frm_topbar_logo'); ?>]]></company_logo_full>
    <company_logo><![CDATA[<?php echo basename(get_option('frm_topbar_logo')); ?>]]></company_logo>
    <app_icon><![CDATA[<?php echo get_option('frm_images_appicon'); ?>]]></app_icon>
    <app_display_name><![CDATA[<?php echo get_option('frm_general_appname'); ?>]]></app_display_name>
    <app_icon_name><![CDATA[<?php echo get_option('frm_general_iconname'); ?>]]></app_icon_name>
    <app_site_url><![CDATA[<?php echo get_site_url(); ?>]]></app_site_url>
    <google_analytics_id><![CDATA[<?php echo get_option('frm_analytics_pubid'); ?>]]></google_analytics_id>
    
    <font><![CDATA[<?php echo get_option('frm_type_font_type'); ?>]]></font>
    
    <listing_type><![CDATA[<?php echo get_option('frm_layout'); ?>]]></listing_type>
    
    <!-- AddThis -->
    <addthis_account><![CDATA[<?php echo get_option('frm_addthis_account'); ?>]]></addthis_account>
    <addthis_app_id><![CDATA[<?php echo get_option('frm_addthis_account') == 'my_own' ? get_option('frm_addthis_appid') : ''; ?>]]></addthis_app_id>
    <addthis_pub_id><![CDATA[<?php echo get_option('frm_addthis_account') == 'my_own' ? get_option('frm_addthis_pubid') : ''; ?>]]></addthis_pub_id>
    <addthis_username><![CDATA[<?php echo get_option('frm_addthis_account') == 'my_own' ? get_option('frm_addthis_username') : ''; ?>]]></addthis_username>
    <addthis_twitter_callback><![CDATA[<?php echo get_option('frm_addthis_account') == 'my_own' || 'mopub' ? get_option('frm_addthis_twittername') : ''; ?>]]></addthis_twitter_callback>
    <addthis_share_url><![CDATA[<?php echo getPermalinkStructure() . 'type=share&article_id='; ?>]]></addthis_share_url>

    <!-- Ads -->
    <admob_publisher_id><![CDATA[<?php 
    if(get_option('frm_ad_status') == 'admob') { 
        echo get_option('frm_admob_id');
    }
    ?>]]></admob_publisher_id>
    <content_iphone_ad_top><![CDATA[<?php
        if(get_option('frm_ad_status') == 'custom_ad') {

            $iphoneAdImageTop = get_option('frm_ad_image_iphone_top');
            if(!empty($iphoneAdImageTop)) {
                echo "<a href='".get_option('frm_ad_url_iphone_top')."'><img src='".$iphoneAdImageTop."' /></a>";
            }

        } else if(get_option('frm_ad_status') == 'ad_embed_code') {
           echo  get_option('frm_ad_code_iphone_top');
        }
    ?>]]></content_iphone_ad_top>
    <content_iphone_ad_bottom><![CDATA[<?php
        if(get_option('frm_ad_status') == 'custom_ad') {

            $iphoneAdImageBottom = get_option('frm_ad_image_iphone_bottom');
            if(!empty($iphoneAdImageBottom)) {
                echo "<a href='".get_option('frm_ad_url_iphone_bottom')."'><img src='".$iphoneAdImageBottom."' /></a>";
            }

        } else if(get_option('frm_ad_status') == 'ad_embed_code') {
           echo  get_option('frm_ad_code_iphone_bottom');
        }
    ?>]]></content_iphone_ad_bottom>
    <content_ipad_ad_top><![CDATA[<?php
        if(get_option('frm_ad_status') == 'custom_ad') {

            $ipadAdImageTop = get_option('frm_ad_image_ipad_top');
            if(!empty($ipadAdImageTop)) {
                echo "<a href='".get_option('frm_ad_url_ipad_top')."'><img src='".$ipadAdImageTop."' /></a>";
            }

        } else if(get_option('frm_ad_status') == 'ad_embed_code') {
           echo  get_option('frm_ad_code_ipad_top');
        }
    ?>]]></content_ipad_ad_top>
    <content_ipad_ad_bottom><![CDATA[<?php
        if(get_option('frm_ad_status') == 'custom_ad') {

            $ipadAdImageBottom = get_option('frm_ad_image_ipad_bottom');
            if(!empty($ipadAdImageBottom)) {
                echo "<a href='".get_option('frm_ad_url_iphone_bottom')."'><img src='".$ipadAdImageBottom."' /></a>";
            }

        } else if(get_option('frm_ad_status') == 'ad_embed_code') {
           echo  get_option('frm_ad_code_ipad_bottom');
        }
    ?>]]></content_ipad_ad_bottom>
    <iphone_launch_ad><![CDATA[<?php
        if(get_option('frm_ad_status') == 'custom_ad') {

            $iphoneAdImageSplash = get_option('frm_ad_image_iphone_splash');
            if(!empty($iphoneAdImageSplash)) {
                echo "<a href='".get_option('frm_ad_url_iphone_splash')."'><img src='".$iphoneAdImageSplash."' /></a>";
            }

        } else if(get_option('frm_ad_status') == 'ad_embed_code') {
           echo  get_option('frm_ad_code_splash_iphone');
        }
    ?>]]></iphone_launch_ad>
    <ipad_launch_ad><![CDATA[<?php
        if(get_option('frm_ad_status') == 'custom_ad') {

            $iphoneAdImageSplash = get_option('frm_ad_image_ipad_splash');
            if(!empty($iphoneAdImageSplash)) {
                echo "<a href='".get_option('frm_ad_url_ipad_splash')."'><img src='".$iphoneAdImageSplash."' /></a>";
            }

        } else if(get_option('frm_ad_status') == 'ad_embed_code') {
           echo  get_option('frm_ad_code_splash_ipad');
        }
    ?>]]></ipad_launch_ad>

    <!-- Top Navigation Bar -->
    <?php $navbar = hex2rgb(get_option('frm_topbar_background'));?>
    <navbar_R_val><![CDATA[<?php echo $navbar['red']; ?>]]></navbar_R_val>
    <navbar_G_val><![CDATA[<?php echo $navbar['green']; ?>]]></navbar_G_val>
    <navbar_B_val><![CDATA[<?php echo $navbar['blue']; ?>]]></navbar_B_val>

    <!-- Sections Bar -->
    <?php $sections = hex2rgb(get_option('frm_menu_background_color')); ?>
    <sections_bar_R_val><![CDATA[<?php echo $sections['red'];?>]]></sections_bar_R_val>
    <sections_bar_G_val><![CDATA[<?php echo $sections['green'];?>]]></sections_bar_G_val>
    <sections_bar_B_val><![CDATA[<?php echo $sections['blue'];?>]]></sections_bar_B_val>
    <?php $sections_inactive = hex2rgb(get_option('frm_menu_textcolor_inactive')); ?>
    <sections_inactive_R_val><![CDATA[<?php echo $sections_inactive['red'];?>]]></sections_inactive_R_val>
    <sections_inactive_G_val><![CDATA[<?php echo $sections_inactive['green'];?>]]></sections_inactive_G_val>
    <sections_inactive_B_val><![CDATA[<?php echo $sections_inactive['blue'];?>]]></sections_inactive_B_val>
    <?php $sections_active = hex2rgb(get_option('frm_menu_textcolor')); ?>
    <sections_active_R_val><![CDATA[<?php echo $sections_active['red'];?>]]></sections_active_R_val>
    <sections_active_G_val><![CDATA[<?php echo $sections_active['green'];?>]]></sections_active_G_val>
    <sections_active_B_val><![CDATA[<?php echo $sections_active['blue'];?>]]></sections_active_B_val>
    <?php $sections_active_background = hex2rgb(get_option('frm_menu_active_background_color')); ?>
    <section_button_back_R_val><![CDATA[<?php echo $sections_active_background['red'];?>]]></section_button_back_R_val>
    <section_button_back_G_val><![CDATA[<?php echo $sections_active_background['green'];?>]]></section_button_back_G_val>
    <section_button_back_B_val><![CDATA[<?php echo $sections_active_background['blue'];?>]]></section_button_back_B_val> 
     
    <!--content-->
    <?php $listingBackground = hex2rgb(get_option('frm_viewer_background'));?>
    <listing_background_R_val><![CDATA[<?php echo $listingBackground['red'];?>]]></listing_background_R_val>
    <listing_background_G_val><![CDATA[<?php echo $listingBackground['green'];?>]]></listing_background_G_val>
    <listing_background_B_val><![CDATA[<?php echo $listingBackground['blue'];?>]]></listing_background_B_val>
    
    <!--Border-->
    <?php $listingBorder = hex2rgb(get_option('frm_border_color'));?>
    <listing_border_R_val><![CDATA[<?php echo $listingBorder['red'];?>]]></listing_border_R_val>
    <listing_border_G_val><![CDATA[<?php echo $listingBorder['green'];?>]]></listing_border_G_val>
    <listing_border_B_val><![CDATA[<?php echo $listingBorder['blue'];?>]]></listing_border_B_val>
    
    <?php 
        
        $tabOrder = json_decode(get_option('mopub_tabs_order'), true);
        
        $tab_order = '';
        
        $lastItem = 0;
        foreach($tabOrder as $tab) {

            if (get_option('frm_checkbox_' . $tab['ID'])) {

                $lastItem++;

            }

        }
        
        $x = 0;
        foreach ($tabOrder as $tab) {
            
            if (get_option('frm_checkbox_' . $tab['ID'])) {

                    $x++;

                    $tab_order .=  trim($tab['ID']);  

                    if($x != $lastItem) {

                        $tab_order .= "|";

                    } 

            }
        }
        
    ?>
    <tab_order><![CDATA[<?php echo $tab_order; ?>]]></tab_order>
    <!-- Static Pages -->
    <static_page_names><![CDATA[<?php echo $static_page_names; ?>]]></static_page_names>
    <static_page_ids><![CDATA[<?php echo $static_page_ids; ?>]]></static_page_ids>
    <static_page_icons><![CDATA[<?php echo $static_page_icons; ?>]]></static_page_icons>
    <static_page_urls><![CDATA[<?php echo $static_page_urls; ?>]]></static_page_urls>
    
    
    <!-- Colors -->
    <?php $listing_headline = hex2rgb(get_option('frm_type_title_color')); ?>
    <standard_listing_headline_R_val><![CDATA[<?php echo $listing_headline['red'];?>]]></standard_listing_headline_R_val>
    <standard_listing_headline_G_val><![CDATA[<?php echo $listing_headline['green'];?>]]></standard_listing_headline_G_val>
    <standard_listing_headline_B_val><![CDATA[<?php echo $listing_headline['blue'];?>]]></standard_listing_headline_B_val>

    <?php $listing_abstract = hex2rgb(get_option('frm_type_text_color')); ?>
    <standard_listing_abstract_R_val><![CDATA[<?php echo $listing_abstract['red'];?>]]></standard_listing_abstract_R_val>
    <standard_listing_abstract_G_val><![CDATA[<?php echo $listing_abstract['green'];?>]]></standard_listing_abstract_G_val>
    <standard_listing_abstract_B_val><![CDATA[<?php echo $listing_abstract['blue'];?>]]></standard_listing_abstract_B_val>

    <?php $listing_pubdate = hex2rgb(get_option('frm_type_meta_color')); ?>
    <standard_listing_pubdate_R_val><![CDATA[<?php echo $listing_pubdate['red'];?>]]></standard_listing_pubdate_R_val>
    <standard_listing_pubdate_G_val><![CDATA[<?php echo $listing_pubdate['green'];?>]]></standard_listing_pubdate_G_val>
    <standard_listing_pubdate_B_val><![CDATA[<?php echo $listing_pubdate['blue'];?>]]></standard_listing_pubdate_B_val>

    <article_view_headline_R_val><![CDATA[<?php echo $listing_headline['red'];?>]]></article_view_headline_R_val>
    <article_view_headline_G_val><![CDATA[<?php echo $listing_headline['green'];?>]]></article_view_headline_G_val>
    <article_view_headline_B_val><![CDATA[<?php echo $listing_headline['blue'];?>]]></article_view_headline_B_val>

    <article_view_subheadline_R_val><![CDATA[<?php echo $listing_headline['red'];?>]]></article_view_subheadline_R_val>
    <article_view_subheadline_G_val><![CDATA[<?php echo $listing_headline['green'];?>]]></article_view_subheadline_G_val>
    <article_view_subheadline_B_val><![CDATA[<?php echo $listing_headline['blue'];?>]]></article_view_subheadline_B_val>

    <article_view_author_R_val><![CDATA[<?php echo $listing_pubdate['red'];?>]]></article_view_author_R_val>
    <article_view_author_G_val><![CDATA[<?php echo $listing_pubdate['green'];?>]]></article_view_author_G_val>
    <article_view_author_B_val><![CDATA[<?php echo $listing_pubdate['blue'];?>]]></article_view_author_B_val>

    <article_view_publishdate_R_val><![CDATA[<?php echo $listing_pubdate['red'];?>]]></article_view_publishdate_R_val>
    <article_view_publishdate_G_val><![CDATA[<?php echo $listing_pubdate['green'];?>]]></article_view_publishdate_G_val>
    <article_view_publishdate_B_val><![CDATA[<?php echo $listing_pubdate['blue'];?>]]></article_view_publishdate_B_val>

    <?php $link = hex2rgb(get_option('frm_type_link_color')); ?>
    <article_view_link_R_val><![CDATA[<?php echo $link['red'];?>]]></article_view_link_R_val>
    <article_view_link_G_val><![CDATA[<?php echo $link['green'];?>]]></article_view_link_G_val>
    <article_view_link_B_val><![CDATA[<?php echo $link['blue'];?>]]></article_view_link_B_val>

    <search_bar_R_val><![CDATA[<?php echo $navbar['red']; ?>]]></search_bar_R_val>
    <search_bar_G_val><![CDATA[<?php echo $navbar['green']; ?>]]></search_bar_G_val>
    <search_bar_B_val><![CDATA[<?php echo $navbar['blue']; ?>]]></search_bar_B_val>

    <search_results_per_page><![CDATA[8]]></search_results_per_page>

    <!-- Feeds -->
    <search_feed><![CDATA[<?php echo getPermalinkStructure().'type=search&querystring='; ?>]]></search_feed>
    <search_view_feed><![CDATA[<?php echo getPermalinkStructure().'type=article&article_id='; ?>]]></search_view_feed>

    <tab1_section_titles><![CDATA[<?php 
       foreach ($cleanCat_arr as $keyInner => $element)
        {  
           if(!empty($element)) {
               $element = ucwords(str_replace("-", " ", $element));
                if (get_option('frm_cat_checkbox_' . str_replace(" ", "-", $element))) {
                        reset($cleanCat_arr);
                        if ($keyInner === key($cleanCat_arr)) {
                                echo $element;
                        } else {
                                echo '|'.$element;
                        }
                }
           }
        } 
    ?>]]></tab1_section_titles>
    <tab1_section_feeds><![CDATA[<?php 
       foreach ($cleanCat_arr as $keyInner => $element)
        {
           if(!empty($element)) {
                if (get_option('frm_cat_checkbox_' . str_replace(" ", "-", $element))) {
                        reset($cleanCat_arr);
                        
                        if($element == 'all') {
                            
                            echo getPermalinkStructure().'type=cat&cat=';
                            
                            foreach ($cleanCat_arrSelected as $keyInnerAll => $elementAll) {
                                
                                if(!empty($elementAll)) {
                                    
                                    $elementAll = ucwords(str_replace("-", " ", $elementAll));
                                    
                                    if (get_option('frm_cat_checkbox_' . str_replace(" ", "-", $elementAll))) {

                                        reset($cleanCat_arrSelected);
                                        
                                        if ($keyInnerAll === key($cleanCat_arrSelected)) {
                                            
                                            echo urlencode($elementAll);
                                            
                                        } else {
                                            
                                            echo '_mo_'.urlencode($elementAll);
                                            
                                        }
                                    
                                    }
                                
                                }
                                
                            }
                            
                        } else {
							
							$element = ucwords(str_replace("-", " ", $element));
							
                            if ($keyInner === key($cleanCat_arr)) {
                                    echo getPermalinkStructure().'type=cat&cat='.urlencode($element);
                            } else {
                                    echo '|'.getPermalinkStructure().'type=cat&cat='.urlencode($element);
                            }
                        
                        }
                }
           }
        } 
    ?>]]></tab1_section_feeds>
    <tab1_article_view_feeds><![CDATA[<?php 
        foreach ($cat_arr as $keyInner => $element)
        {
          if(!empty($element)) {
                if (get_option('frm_cat_checkbox_' . str_replace(" ", "-", $element))) {
                  if ( isset($not_first['article_view_feed']) ) {
                      echo '|';
                  }
                  echo getPermalinkStructure(). 'type=article&article_id=';
                  $not_first['article_view_feed'] = true;
              }
          }
        }
    ?>]]></tab1_article_view_feeds>
    
    <category_listing_feed><![CDATA[<?php echo getPermalinkStructure().'type=cat_list'; ?>]]></category_listing_feed>

    <topic_listing_feed><![CDATA[<?php echo getPermalinkStructure().'type=tag_list'; ?>]]></topic_listing_feed>

    <about_page_content><![CDATA[<?php echo nl2br(strip_tags(get_option('frm_about_about'))); ?>]]></about_page_content>
    <contact_page_email><![CDATA[<?php echo get_option('frm_contact_email'); ?>]]></contact_page_email>
    <contact_page_content><![CDATA[<?php echo nl2br(strip_tags(get_option('frm_contact_intro'))); ?>]]></contact_page_content>

    <?php // App store requirements ?>
    <app_language><![CDATA[<?php echo get_option('frm_language'); ?>]]></app_language>
    <app_countries><![CDATA[<?php echo get_option('frm_countries'); ?>]]></app_countries>
    <app_countries_select><![CDATA[<?php
        if (is_array($countries_select = get_option('frm_countries_select'))) {
            echo implode(';', array_keys($countries_select));
        }
        ?>]]></app_countries_select>
    <app_category_primary><![CDATA[<?php echo get_option('frm_category_primary'); ?>]]></app_category_primary>
    <app_category_secondary><![CDATA[<?php echo get_option('frm_category_secondary'); ?>]]></app_category_secondary>
    <app_age_fantasy_violence><![CDATA[<?php echo get_option('frm_age_fantasy_violence'); ?>]]></app_age_fantasy_violence>
    <app_age_realistic_violence><![CDATA[<?php echo get_option('frm_age_realistic_violence'); ?>]]></app_age_realistic_violence>
    <app_age_sexual><![CDATA[<?php echo get_option('frm_age_sexual'); ?>]]></app_age_sexual>
    <app_age_profanity><![CDATA[<?php echo get_option('frm_age_profanity'); ?>]]></app_age_profanity>
    <app_age_drug><![CDATA[<?php echo get_option('frm_age_drug'); ?>]]></app_age_drug>
    <app_age_mature><![CDATA[<?php echo get_option('frm_age_mature'); ?>]]></app_age_mature>
    <app_age_gambling><![CDATA[<?php echo get_option('frm_age_gambling'); ?>]]></app_age_gambling>
    <app_age_horror><![CDATA[<?php echo get_option('frm_age_horror'); ?>]]></app_age_horror>
    <app_age_graphic_violence><![CDATA[<?php echo get_option('frm_age_graphic_violence'); ?>]]></app_age_graphic_violence>
    <app_age_graphic_sexual><![CDATA[<?php echo get_option('frm_age_graphic_sexual'); ?>]]></app_age_graphic_sexual>
    <app_description><![CDATA[<?php echo get_option('frm_app_description'); ?>]]></app_description>
    <?php 
        $appKeyword = get_option('frm_app_keywords'); 
    ?>
    <app_keywords><![CDATA[<?php echo str_replace(' ', '', $appKeyword) ?>]]></app_keywords>
    
    <?php
        $catVideo = get_option('frm_video_cat');
        $catAudio = get_option('frm_audio_cat');
    ?>
    
    <video_listing_feed><![CDATA[<?php echo getPermalinkStructure().'type=cat&cat='.urlencode($catVideo);?>]]></video_listing_feed>
    <video_view_feed><![CDATA[<?php echo getPermalinkStructure().'type=article&article_id=';?>]]></video_view_feed>
    <audio_listing_feed><![CDATA[<?php echo getPermalinkStructure().'type=cat&cat='.urlencode($catAudio);?>]]></audio_listing_feed>
    <audio_view_feed><![CDATA[<?php echo getPermalinkStructure().'type=article&article_id=';?>]]></audio_view_feed>
    
    <config_generation_timestamp><?php echo time(); ?></config_generation_timestamp>
    <amember_user_id><![CDATA[]]></amember_user_id> 
    <config_plugin_version><![CDATA[<?php echo plugin_get_version(); ?>]]></config_plugin_version>
    <?php 
        $frm_protect_xml = get_option('frm_protect_xml');
    ?>
    <plugin_use_xml_protection><![CDATA[<?php echo $frm_protect_xml; ?>]]></plugin_use_xml_protection>
    <plugin_salt><![CDATA[<?php
    if($frm_protect_xml == 'yes') {
        echo get_option('mopub_salt'); 
    }
    ?>]]></plugin_salt>
    
    <?php 
        
        $frm_comment_option = get_option('frm_comment_option');
    
    ?>
    <!--comments -->
    <comment_url><![CDATA[<?php echo getPermalinkStructure() . 'type=comment'; ?>]]></comment_url>
    <comment_option><![CDATA[<?php echo $frm_comment_option; ?>]]></comment_option>
    <disqus_short_name><![CDATA[<?php
        if($frm_comment_option == 'disqus') {
            echo get_option('frm_disqus_short_name');
        }
    ?>]]></disqus_short_name>
    <disqus_api_key><![CDATA[<?php 
        if($frm_comment_option == 'disqus') {
            echo get_option('frm_disqus_api_key'); 
        }
    ?>]]></disqus_api_key>
    <disqus_user_api_key><![CDATA[<?php 
        if($frm_comment_option == 'disqus') {
            echo get_option('frm_disqus_user_api_key'); 
        }
    ?>]]></disqus_user_api_key>
    
</moPublication_config>
