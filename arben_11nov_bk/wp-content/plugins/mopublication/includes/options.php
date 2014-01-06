<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Options
 *
 *  Saving via Ajax
 *  - http://zerosignalproductions.com/wordpress/a-solution-for-using-ajax-in-wordpress-admin
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

include_once 'get_categories.php';

?>

<div class="wrap">
    <form method="post" action="options.php" id="mopub_config">

        <!-- Start hidden fields -->
        
        <input type="hidden" name="frm_menu_bottom_order" id="frm_menu_bottom_order"
               value="<?php echo get_option('frm_menu_bottom_order'); ?>"/>
        
        <input type="hidden" value='<?php echo get_option('mopub_tabs_order'); ?>' id="mopub_tabs_order" name="mopub_tabs_order" />
        
        <!-- End hidden fields -->

        <?php settings_fields('mopub-settings'); ?>
        <?php if(get_bloginfo('version') < 3.3) :?>
            <div id="message" class="error" style="padding: 10px;"><?php echo $pluginName; ?> requires WordPress version 3.3 or higher. Please upgrade!</div>
        <?php endif; ?>
        <h2><?php echo $pluginName; ?> <span class="headerExtra">Applify your WordPress website</span></h2>

        <div class="operations">
            <div id="alert" style="display: none;"></div>
            <input type="button" id="mopub_save_ajax" class="button-primary headerButton" class="regular-text"
                   value="<?php _e('Save Changes') ?>"/>
        </div>

        <div class="clear"></div>


        <div class="mopub_wrap">

            <!-- <div class="mopub_message">Your changes have been saved.</div> -->

            <div class="mopub_content">


                <div id="tabs">

                    <div class="mopub_demo">
                        <div class="phone">
                            <div class="viewer <?php echo get_option('frm_layout'); ?>">
                                <?php include "mopub-demo.php" ?>
                            </div>
                        </div>
                    </div>

                    <ul class="tabs">
                        <li id="tab-1-panel"><a href="#tab-1" class="tabnav"><span class="tab1"><em
                            class="num">1</em></span>Customize</a></li>
                        <li id="tab-2-panel"><a href="#tab-2" class="tabnav"><span class="tab2"><em
                            class="num">2</em></span>Content Management</a></li>
                        <li id="tab-3-panel"><a href="#tab-3" class="tabnav"><span class="tab3"><em
                            class="num">3</em></span>Third-Party Integration</a></li>
                        <li id="tab-app-store-panel"><a href="#tab-app-store" class="tabnav"><span class="tab4"><em
                            class="num">4</em></span>Advanced</a></li>
                        <li id="tab-5-panel"><a href="#tab-5" class="tabnav"><span class="tab5"></span>Finished!</a>
                        </li>
                        <li id="tab-4-panel" class="config"><a href="#tab-4" class="tabnav"><span class="tab4"></span>Configuration
                            Settings</a></li>
                    </ul>

                    <div id="tab-1" class="panel">
                        <?php include "options-tab1.php"; ?>
                    </div>

                    <div id="tab-2" class="panel">
                        <?php include "options-tab2.php"; ?>
                    </div>

                    <div id="tab-3" class="panel">
                        <?php include "options-tab3.php"; ?>
                    </div>

                    <div id="tab-app-store" class="panel">
                        <?php include "options-app-store.php"; ?>
                    </div>

                    <?php
                    $includepages = '';
                    if (get_option('frm_checkbox_search') == 'on') {
                        $includepages .= "search,";
                    }
                    if (get_option('frm_checkbox_videos') == 'on') {
                        $includepages .= "videos,";
                    }
                    if (get_option('frm_checkbox_audio') == 'on') {
                        $includepages .= "audio,";
                    }
                    if (get_option('frm_checkbox_categories') == 'on') {
                        $includepages .= "categories,";
                    }
                    if (get_option('frm_checkbox_tags') == 'on') {
                        $includepages .= "tags,";
                    }
                    if (get_option('frm_checkbox_about') == 'on') {
                        $includepages .= "about,";
                    }
                    ?>

                    <div id="tab-4" class="panel">
                        <div class="inner">

                            <h3>Configuration File</h3>

                            <!-- Start Textbox -->

                            <div class="frm_row">

                                <div class="">
                                    <textarea name="frm_config_file" id="frm_config_file" class="large-text"
                                              style="height:800px; width:80%">
                                        <?php include "config-xml.php"; ?>
                                    </textarea>
                                </div>

                                <div class="clear"></div>

                            </div>

                            <!-- End Textbox -->

                        </div>
                    </div>
                    <input type="hidden" id="site_wordpress_permalink" name="site_wordpress_permalink"
                           value="<?php echo get_permalink(); ?>"/>

                </form><!-- mopub_config -->

                <div id="tab-5" class="panel">

                    <?php include('options-finished.php'); ?>

                </div>

            </div>

            <div class="clear"></div>

        </div>

        <div class="clear"></div>

    </div>


</div><!-- wrap -->
 
