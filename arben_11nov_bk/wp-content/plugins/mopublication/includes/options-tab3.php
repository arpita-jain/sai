<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Tab 3: External Integration options
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */
?>

<div class="inner">

    <h3>Statistics</h3>

    <!-- Start Textbox -->

    <div class="frm_row">

        <div class="frm_left">
            <label>Use Google Analytics?</label>
        </div>

        <div class="frm_right">
            <select name="frm_analytics_active" id="frm_analytics_active" class="mp_input">
                <option value="false" <?php if (get_option('frm_analytics_active') == 'false') {
                    echo ' selected="selected"';
                } ?>>No
                </option>
                <option value="true" <?php if (get_option('frm_analytics_active') == 'true') {
                    echo ' selected="selected"';
                } ?>>Yes
                </option>
            </select>

        </div>

        <div class="clear"></div>

        <div id="mopub_options_analytics"
             style="display: <?php echo get_option('frm_analytics_active') == 'true' ? 'block' : 'none' ; ?>;">

            <br>

            <div class="frm_left">
                <label>Web Property ID (UA Number)</label>
            </div>

            <div class="frm_right">
                <input type="text" class="mopub_text mp_input" name="frm_analytics_pubid" id="frm_analytics_pubid"
                       value="<?php echo get_option('frm_analytics_pubid'); ?>"/>
                <p class="description">This is shown in your Google Analytics account. <a href="http://support.google.com/analytics/bin/answer.py?hl=en&answer=1032385" title="Google Analytics Web Property ID" target="blank">Click here</a> if you need help finding it.</p>
            </div>

        </div>

        <div id="mopub_options_analytics_off"
             style="display: <?php echo get_option('frm_analytics_active') == 'true' ? 'none' : 'block' ; ?>;">

            <div class="frm_left">
                &nbsp;
            </div>

            <div class="frm_right">
                <p class="description">Note: You need a Google Analytics account to access data<br>on app usage. You can create a <a href="http://www.google.com/analytics" title="Google Analytics" target="blank">free account here</a>.</p>
            </div>

        </div>

        <div class="clear"></div>

    </div>

    <!-- End Textbox -->

    <div class="clear"></div>

    <h3>Social Sharing</h3>


    <div class="frm_row">
        <div class="frm_left">
            <div class="frm_left_left">
                <label>Sharing Option</label>
            </div>
            <div class="frm_left_right">
                <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="tooltip">
                    <p>The default option allows social sharing and bookmarking of your content.</p>
                    If you would like to see stats on sharing, you should choose 'Use my own AddThis account'.
                </div>
            </div>
        </div>

        <div class="frm_right">
            <select name="frm_addthis_account" id="frm_addthis_account" class="mp_input">
                <option value="mopub" <?php if (get_option('frm_addthis_account') == 'mopub') {
                    echo ' selected="selected"';
                } ?>>Default
                </option>
                <option value="my_own" <?php if (get_option('frm_addthis_account') == 'my_own') {
                    echo ' selected="selected"';
                } ?>>Use my own AddThis account
                </option>
                <option value="none" <?php if (get_option('frm_addthis_account') == 'none') {
                    echo ' selected="selected"';
                } ?>>No sharing
                </option>
            </select>
        </div>

        <div class="clear"></div>

    </div>


    <div id="addthis_my_account" class="addthis" style="display: none">

        <div class="frm_row">
            <div class="frm_left">
                <div class="frm_left_left">
                    <label>Application ID</label>
                </div>
                <div class="frm_left_right">
                    <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="tooltip">
                        The Application ID which you can find inside the profile section
                        of your AddThis account
                    </div>
                </div>
            </div>
            <div class="frm_right">
                <input type="text" class="mopub_text mp_input" name="frm_addthis_appid" id="frm_addthis_appid"
                       value="<?php echo get_option('frm_addthis_appid'); ?>"/>
            </div>
            <div class="clear"></div>
        </div>

        <div class="frm_row">
            <div class="frm_left">
                <div class="frm_left_left">
                    <label>Publisher ID</label>
                </div>
                <div class="frm_left_right">
                    <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="tooltip">This is your AddThis Publisher ID</div>
                </div>
            </div>
            <div class="frm_right">
                <input type="text" class="mopub_text mp_input" name="frm_addthis_pubid" id="frm_addthis_pubid"
                       value="<?php echo get_option('frm_addthis_pubid'); ?>"/>
            </div>
            <div class="clear"></div>
        </div>

        <div class="frm_row">
            <div class="frm_left">
                <div class="frm_left_left">
                    <label>Username</label>
                </div>
                <div class="frm_left_right">
                    <div class="tooltip">The username that you use to log into your AddThis account</div>
                    <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </div>
            </div>
            <div class="frm_right">
                <input type="text" class="mopub_text mp_input" name="frm_addthis_username" id="frm_addthis_username"
                       value="<?php echo get_option('frm_addthis_username'); ?>"/>
                <p class="description">
                    You can create a username by accessing the <a href="http://www.addthis.com/forum/" target="_blank">AddThis Forum</a>
                </p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div id="addthis_twitter" style="display: none">
        <div class="frm_row">
            <div class="frm_left">
                <div class="frm_left_left">
                    <label>Twitter Username</label>
                </div>
                <div class="frm_left_right">
                    <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="tooltip">Enter your Twitter username/handle if you have a Twitter account</div>
                </div>
            </div>
            <div class="frm_right">
                @ <input type="text" class="mopub_text mp_input" name="frm_addthis_twittername" id="frm_addthis_twittername"
                       value="<?php echo get_option('frm_addthis_twittername'); ?>"/>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div id="addthis_mopub" class="addthis" style="display: none">
        <div class="frm_row">
        </div>
    </div>
    <div class="clear"></div>
    

    <h3>Ad Management </h3>

    <!-- Start Select -->

    <div class="frm_row">

        <div class="frm_left">
            <label>Select Option</label>
        </div>

        <div class="frm_right">
            <select name="frm_ad_status" id="frm_ad_status" class="mp_input">
                <option value="none" <?php if (get_option('frm_ad_status') == 'none') {
                    echo ' selected="selected"';
                } ?>>None
                </option>
                <option value="custom_ad" <?php if (get_option('frm_ad_status') == 'custom_ad') {
                    echo ' selected="selected"';
                } ?>>Custom Ad
                </option>
                <option value="ad_embed_code" <?php if (get_option('frm_ad_status') == 'ad_embed_code') {
                    echo ' selected="selected"';
                } ?>>Ad Server
                </option>
               <option value="admob" <?php if (get_option('frm_ad_status') == 'admob') {
                    echo ' selected="selected"';
                } ?>>Admob
                </option>
            </select>
        </div>

        <div class="clear"></div>
    </div>

    <!-- End Select -->

    <div class="clear"></div>

    <div id="ad_embed_code" class="ad_management" style="display: none">
        <h3>Ad Embed Code</h3>
        <div class="clear"></div>
        <div class="frm_row">
        <p class="description">Paste the relevant embed code into the desired positions.
            <br>Google DFP, ADTECH and OpenX are currently supported.</p>
        </div>
        <div class="clear"></div>
        <!-- End Textbox -->
        <h4>iPhone</h4>
        <!-- Start Textbox -->
        
        <div class="frm_row">

            <div class="frm_left">
                <label>Splash Page</label>
            </div>

            <div class="frm_right">
                <textarea name="frm_ad_code_splash_iphone" id="frm_ad_code_splash_iphone"
                          class="large-text mp_input"><?php echo get_option('frm_ad_code_splash_iphone'); ?></textarea>
                          <p class="description">Low-res: 320 x 416 pixels / Hi-res: 640 x 832 pixels</p>
            </div>

            <div class="clear"></div>

        </div>
        
        <div class="frm_row">

            <div class="frm_left">
                <label>Top</label>
            </div>

            <div class="frm_right">
                <textarea name="frm_ad_code_iphone_top" id="frm_ad_code_iphone_top"
                          class="large-text mp_input"><?php echo get_option('frm_ad_code_iphone_top'); ?></textarea>
                          <p class="description">Low-res: 320 x 80 pixels / Hi-res: 640 x 160 pixels</p>
            </div>

            <div class="clear"></div>

        </div>

        <!-- End Textbox -->
        
        <!-- Start Textbox -->
        <div class="frm_row">

            <div class="frm_left">
                <label>Bottom</label>
            </div>

            <div class="frm_right">
                <textarea name="frm_ad_code_iphone_bottom" id="frm_ad_code_iphone_bottom"
                          class="large-text mp_input"><?php echo get_option('frm_ad_code_iphone_bottom'); ?></textarea>
                          <p class="description">Low-res: 320 x 80 pixels / Hi-res: 640 x 160 pixels</p>
            </div>

            <div class="clear"></div>

        </div>

        <!-- End Textbox -->

        <div class="clear"></div>
        <h4>iPad</h4>
        
        <div class="frm_row">

            <div class="frm_left">
                <label>Splash Page</label>
            </div>

            <div class="frm_right">
                <textarea name="frm_ad_code_splash_ipad" id="frm_ad_code_splash_ipad"
                          class="large-text mp_input"><?php echo get_option('frm_ad_code_splash_ipad'); ?></textarea>
                          <p class="description">Low-res: 768 x 960 pixels / Hi-res: 1536 x 1920 pixels</p>
            </div>

            <div class="clear"></div>

        </div>
        
        <!-- Start Textbox -->

        <div class="frm_row">

            <div class="frm_left">
                <label>Top</label>
            </div>

            <div class="frm_right">
                <textarea name="frm_ad_code_ipad_top" id="frm_ad_code_ipad_top"
                          class="large-text mp_input"><?php echo get_option('frm_ad_code_ipad_top'); ?></textarea>
                          <p class="description">Low-res: 728 x 90 pixels / Hi-res: 1456 x 180 pixels</p>
            </div>

            <div class="clear"></div>

        </div>

        <!-- End Textbox -->
        
                <!-- Start Textbox -->

        <div class="frm_row">

            <div class="frm_left">
                <label>Bottom</label>
            </div>

            <div class="frm_right">
                <textarea name="frm_ad_code_ipad_bottom" id="frm_ad_code_ipad_bottom"
                          class="large-text mp_input"><?php echo get_option('frm_ad_code_ipad_bottom'); ?></textarea>
                          <p class="description">Low-res: 728 x 90 pixels / Hi-res: 1456 x 180 pixels</p>
            </div>

            <div class="clear"></div>

        </div>

        <!-- End Textbox -->
        
        
    </div>

    <div id="custom_ad" class="ad_management" style="display: none">
        <h3>Custom Ad</h3>
        <div class="clear"></div>
        <div class="frm_row">
        <p class="description">Upload your own custom banners and enter a destination URL for the clickthrough</p>
        </div>
        <div class="clear"></div>
        <!-- start iphonecustomad -->
        <div class="customAdItem">
            <h4>iPhone</h4>
            <!--start destination url -->
            <div class="frm_row">
                <div class="frm_left">
                    <label>Splash Destination URL</label>
                </div>
                <div class="frm_right">
                    <input type="text" class="mopub_text mp_input" name="frm_ad_url_iphone_splash" id="frm_ad_url_iphone_splash" value="<?php echo get_option('frm_ad_url_iphone_splash'); ?>"/>
                </div>
                <div class="clear"></div>
            </div>
            <!--end destination url -->
            <div class="clear"></div>
            <!--start banner advert-->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Splash Banner Advert</label>
                </div>

                <div class="frm_right">
                    <input id="frm_ad_image_iphone_splash_min_width" type="hidden" value="320"/>
                    <input id="frm_ad_image_iphone_splash_min_height" type="hidden" value="416"/>
                    <input id="frm_ad_image_iphone_splash_allowed_types" type="hidden" value="png,jpg,jpeg,gif"/>

                    <input id="frm_ad_image_iphone_splash" class="mopub_upload mp_input" type="text" size="36" name="frm_ad_image_iphone_splash"
                        value="<?php echo get_option('frm_ad_image_iphone_splash'); ?>"/>
                    <input id="frm_ad_image_iphone_splash_btn" class="button upload_image_button" type="button" value="Upload Image"/>
                    <?php if (esc_url(get_option('frm_ad_image_iphone_splash'))) {
                    echo " <a href='" . get_option('frm_ad_image_iphone_splash') . "' target='_blank'>View Image</a>";
                } ?>
                    <div class="clear"></div>
                    <div class="ad_display_iphone_splash">
                        <img src="<?php if (get_option('frm_ad_image_iphone_splash') == '') {
                            echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');
                        } else {
                            echo get_option('frm_ad_image_iphone_splash');
                        } ?>" width="235px" />
                    </div>
                    <p class="description">Low-res: 320 x 416 pixels / Hi-res: 640 x 832 pixels.<br />Allowed formats: png, jpg, gif.</p>
                </div>

                <div class="clear"></div>
            </div>
            <!--end banner advert-->
            <!--start destination url -->
            <div class="frm_row">
                <div class="frm_left">
                    <label>Top Ad Destination URL</label>
                </div>
                <div class="frm_right">
                    <input type="text" class="mopub_text mp_input" name="frm_ad_url_iphone_top" id="frm_ad_url_iphone_top" value="<?php echo get_option('frm_ad_url_iphone_top'); ?>"/>
                </div>
                <div class="clear"></div>
            </div>
            <!--end destination url -->
            <!--start banner advert-->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Top Ad Banner Advert</label>
                </div>

                <div class="frm_right">
                    <input id="frm_ad_image_iphone_top_min_width" type="hidden" value="640"/>
                    <input id="frm_ad_image_iphone_top_min_height" type="hidden" value="160"/>
                    <input id="frm_ad_image_iphone_top_allowed_types" type="hidden" value="png, jpg, jpeg, gif"/>

                    <input id="frm_ad_image_iphone_top" class="mopub_upload mp_input" type="text" size="36" name="frm_ad_image_iphone_top"
                        value="<?php echo get_option('frm_ad_image_iphone_top'); ?>"/>
                    <input id="frm_ad_image_iphone_top_btn" class="button upload_image_button" type="button" value="Upload Image"/>
                    <?php if (esc_url(get_option('frm_ad_image_iphone_top'))) {
                    echo " <a href='" . get_option('frm_ad_image_iphone_top') . "' target='_blank'>View Image</a>";
                } ?>
                    <div class="clear"></div>
                    <div class="ad_display_iphone_top">
                        <img src="<?php if (get_option('frm_ad_image_iphone_top') == '') {
                            echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');
                        } else {
                            echo get_option('frm_ad_image_iphone_top');
                        } ?>" width="235px" height="59px"/>
                    </div>
                    <p class="description">Low-res: 320 x 80 pixels / Hi-res: 640 x 160 pixels.<br />Allowed formats: png, jpg, gif.</p>
                </div>

                <div class="clear"></div>

            </div>
            <!--end banner advert-->
            <!--start destination advert -->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Bottom Ad Destination URL</label>
                </div>

                <div class="frm_right">
                    <input type="text" class="mopub_text mp_input" name="frm_ad_url_iphone_bottom" id="frm_ad_url_iphone_bottom"
                        value="<?php echo get_option('frm_ad_url_iphone_bottom'); ?>"/>
                </div>

                <div class="clear"></div>

            </div>
            <!--end destination advert -->
            <!--start banner advert-->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Bottom Banner Advert</label>
                </div>

                <div class="frm_right">
                    <input id="frm_ad_image_iphone_bottom_min_width" type="hidden" value="640"/>
                    <input id="frm_ad_image_iphone_bottom_min_height" type="hidden" value="160"/>
                    <input id="frm_ad_image_iphone_bottom_allowed_types" type="hidden" value="png,jpg,jpeg,gif"/>

                    <input id="frm_ad_image_iphone_bottom" class="mopub_upload mp_input" type="text" size="36" name="frm_ad_image_iphone_bottom"
                        value="<?php echo get_option('frm_ad_image_iphone_bottom'); ?>"/>
                    <input id="frm_ad_image_iphone_bottom_btn" class="button upload_image_button" type="button" value="Upload Image"/>
                    <?php if (esc_url(get_option('frm_ad_image_iphone_bottom'))) {
                    echo " <a href='" . get_option('frm_ad_image_iphone_bottom') . "' target='_blank'>View Image</a>";
                } ?>
                    <div class="clear"></div>
                    <div class="ad_display_iphone_bottom">
                        <img src="<?php if (get_option('frm_ad_image_iphone_bottom') == '') {
                            echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');
                        } else {
                            echo get_option('frm_ad_image_iphone_bottom');
                        } ?>" width="235px" height="59px"/>
                    </div>
                    <p class="description">Low-res: 320 x 80 pixels / Hi-res: 640 x 160 pixels.<br />Allowed formats: png, jpg, gif.</p>
                </div>

                <div class="clear"></div>

            </div>
            <!--end banner advert-->
        </div>
        <!-- end iphonecustomad -->
        <!-- start ipadcustomad -->
        <div class="customAdItem">
            <h4>iPad</h4>
            <!--start destination url -->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Splash Destination URL</label>
                </div>

                <div class="frm_right">
                    <input type="text" class="mopub_text mp_input" name="frm_ad_url_ipad_splash" id="frm_ad_url_ipad_splash"
                        value="<?php echo get_option('frm_ad_url_ipad_splash'); ?>"/>
                </div>

                <div class="clear"></div>
            </div>
            <!--end destination url -->
            <!--start banner advert -->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Splash Banner Advert</label>
                </div>

                <div class="frm_right">
                    <input id="frm_ad_image_ipad_splash_min_width" type="hidden" value="1456"/>
                    <input id="frm_ad_image_ipad_splash_min_height" type="hidden" value="1920"/>
                    <input id="frm_ad_image_ipad_splash_allowed_types" type="hidden" value="png, jpg, jpeg, gif"/>

                    <input id="frm_ad_image_ipad_splash" class="mopub_upload mp_input" type="text" size="36" name="frm_ad_image_ipad_splash"
                        value="<?php echo get_option('frm_ad_image_ipad_splash'); ?>"/>
                    <input id="frm_ad_image_ipad_splash_btn" class="button upload_image_button" type="button" value="Upload Image"/>
                    <?php if (esc_url(get_option('frm_ad_image_ipad_splash'))) {
                    echo " <a href='" . get_option('frm_ad_image_ipad_splash') . "' target='_blank'>View Image</a>";
                } ?>
                    <div class="clear"></div>
                    <div class="ad_display_ipad_splash">
                        <img src="<?php if (get_option('frm_ad_image_ipad_splash') == '') {
                            echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');
                        } else {
                            echo get_option('frm_ad_image_ipad_splash');
                        } ?>" width="235px"  />
                    </div>
                    <p class="description">Low-res: 768 x 960 pixels / Hi-res: 1536 x 1920 pixels.<br />Allowed formats: png, jpg, gif.</p>
                </div>

                <div class="clear"></div>

            </div>
            <!--end banner advert -->
            <!--start destination url -->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Top Ad Destination URL</label>
                </div>

                <div class="frm_right">
                    <input type="text" class="mopub_text mp_input" name="frm_ad_url_iphone_top" id="frm_ad_url_ipad_top"
                        value="<?php echo get_option('frm_ad_url_iphone_top'); ?>"/>
                </div>

                <div class="clear"></div>

            </div>
            <!--end destination url -->
            <!--start banner advert -->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Top Ad Banner Advert</label>
                </div>

                <div class="frm_right">
                    <input id="frm_ad_image_ipad_top_min_width" type="hidden" value="1456"/>
                    <input id="frm_ad_image_ipad_top_min_height" type="hidden" value="180"/>
                    <input id="frm_ad_image_ipad_top_allowed_types" type="hidden" value="png, jpg, jpeg, gif"/>

                    <input id="frm_ad_image_ipad_top" class="mopub_upload mp_input" type="text" size="36" name="frm_ad_image_ipad_top"
                        value="<?php echo get_option('frm_ad_image_ipad_top'); ?>"/>
                    <input id="frm_ad_image_ipad_top_btn" class="button upload_image_button" type="button" value="Upload Image"/>
                    <?php if (esc_url(get_option('frm_ad_image_ipad_top'))) {
                    echo " <a href='" . get_option('frm_ad_image_ipad_top') . "' target='_blank'>View Image</a>";
                } ?>
                    <div class="clear"></div>
                    <div class="ad_display_ipad_top">
                        <img src="<?php if (get_option('frm_ad_image_ipad_top') == '') {
                            echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');
                        } else {
                            echo get_option('frm_ad_image_ipad_top');
                        } ?>" width="235px" height="59px"/>
                    </div>
                    <p class="description">Low-res: 728 x 90 pixels / Hi-res: 1456 x 180 pixels.<br />Allowed formats: png, jpg, gif.</p>
                </div>

                <div class="clear"></div>

            </div>
            <!--end banner advert -->
            <!--start destination url -->
            <div class="frm_row">

                <div class="frm_left">
                    <label>Bottom Ad Destination URL</label>
                </div>

                <div class="frm_right">
                    <input type="text" class="mopub_text mp_input" name="frm_ad_url_ipad_bottom" id="frm_ad_url_ipad_bottom"
                        value="<?php echo get_option('frm_ad_url_ipad_bottom'); ?>"/>
                </div>

                <div class="clear"></div>

            </div> 
            <!--end destination url -->
            <!--start banner advert -->
            <div class="frm_row">

                        <div class="frm_left">
                            <label>Bottom Ad Banner Advert</label>
                        </div>

                        <div class="frm_right">
                            <input id="frm_ad_image_ipad_bottom_min_width" type="hidden" value="1456"/>
                            <input id="frm_ad_image_ipad_bottom_min_height" type="hidden" value="180"/>
                            <input id="frm_ad_image_ipad_bottom_allowed_types" type="hidden" value="png, jpg, jpeg, gif"/>

                            <input id="frm_ad_image_ipad_bottom" class="mopub_upload mp_input" type="text" size="36" name="frm_ad_image_ipad_bottom"
                                value="<?php echo get_option('frm_ad_image_ipad_bottom'); ?>"/>
                            <input id="frm_ad_image_ipad_bottom_btn" class="button upload_image_button" type="button" value="Upload Image"/>
                            <?php if (esc_url(get_option('frm_ad_image_ipad_bottom'))) {
                            echo " <a href='" . get_option('frm_ad_image_ipad_bottom') . "' target='_blank'>View Image</a>";
                        } ?>
                            <div class="clear"></div>
                            <div class="ad_display_ipad_bottom">
                                <img src="<?php if (get_option('frm_ad_image_ipad_bottom') == '') {
                                    echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');
                                } else {
                                    echo get_option('frm_ad_image_ipad_bottom');
                                } ?>" width="235px" height="59px"/>
                            </div>
                            <p class="description">Low-res: 728 x 90 pixels / Hi-res: 1456 x 180 pixels.<br />Allowed formats: png, jpg, gif.</p>
                        </div>

                        <div class="clear"></div>

            </div>      
            <!--end banner advert -->
        </div>
        <!-- start ipadcustomad -->
    </div>    
    <div id="admob" class="ad_management" style="display: none">
        <h3>AdMob</h3>
        <div class="clear"></div>
        <div class="frm_row">
        <p class="description">Enter your AdMob publisher ID to start serving ads from the AdMob network</p>
        </div>
        <div class="clear"></div>
         <!-- Start Textbox -->
        <div class="frm_row">
            
            <div class="frm_left">
                <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <label>AdMob ID</label>

                <div class="tooltip">Your unique ID supplied by AdMob</div>
            </div>
            <div class="frm_right">
                <input type="text" class="mopub_text mp_input" name="frm_admob_id" id="frm_admob_id"
                       value="<?php echo get_option('frm_admob_id'); ?>"/>
            </div>
            <div class="clear"></div>
        </div>
        <!-- End Textbox -->
        <div class="clear"></div>
    </div>
    <div class="frm_row">

        <a href="#tab-2" class="button tabnav">Previous</a>
        <a href="#tab-app-store" class="button tabnav">Next</a>

    </div>


    <div class="clear"></div>

</div>
