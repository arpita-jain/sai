<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Tab 1: General Customization options
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */
?>
<div id="dialog" style="display: none;"></div>
<input type="hidden" id="site_wordpress_url" name="site_wordpress_url" value="<?php echo get_site_url(); ?>" />
<div class="inner">

<h3>General</h3>

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">
    <div class="frm_left">
        <div class="frm_left_left">
            <label>App Name *</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">The official name of your app</div>
        </div>
    </div>
    <div class="frm_right" id="appNameHolder">
        <input type="text" class="mopub_text mp_input" name="frm_general_appname" id="frm_general_appname"
               value="<?php echo get_option('frm_general_appname'); ?>" maxlength="50" /><span id="appNameStatus"></span>
    </div>
    <div class="clear"></div>
</div>

<div class="frm_row">
    <div class="frm_left">
        <div class="frm_left_left">
            <label>Icon Name *</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">Displays below your app on the home screen in iOS</div>
        </div>
    </div>
    <div class="frm_right" id="iconNameHolder">
        <input type="text" class="mopub_text mp_input" name="frm_general_iconname" id="frm_general_iconname"
               value="<?php echo get_option('frm_general_iconname'); ?>" maxlength="12" /><span id="iconNameStatus"></span>
    </div>
    <div class="clear"></div>
</div>


<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>Description *</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">A detailed description of your app as it will appear in the App Store</div>
        </div>
    </div>

    <div class="frm_right">
        <textarea name="frm_app_description" id="frm_app_description" cols="60"
                  rows="5" class="mp_textarea"><?php echo get_option('frm_app_description'); ?></textarea>
    </div>
</div>


<div class="clear"></div>

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>Keywords *</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">Used to categorize your app in the App Store</div>
        </div>
    </div>

    <div class="frm_right">
        <textarea name="frm_app_keywords" id="frm_app_keywords" cols="60"
                  rows="3" onKeyPress="limitText(this.form.frm_app_keywords, '',90);"><?php echo get_option('frm_app_keywords'); ?></textarea>
        <br>
        <p class="description">Separate multiple keywords with commas</p>
    </div>
</div>

<div class="clear"></div>


<!-- End Textbox -->

<!-- Start Textbox -->

<h3>Top Bar</h3>

<!-- End Textbox -->

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Background Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_topbar_background" id="frm_topbar_background" type="text"
               value="<?php if (get_option('frm_topbar_background') != "") {
                   echo get_option('frm_topbar_background');
               } else {
                   echo '#5585a0';
               } ?>" class="text mp_input" <?php if (get_option('frm_topbar_background') != "") {
            echo "style='background-color: #" . get_option('frm_topbar_background') . "'";
        } ?>  />


    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<h3>Menu</h3>

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Background Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_menu_background_color" id="frm_menu_background_color" type="text"
               value="<?php if (get_option('frm_menu_background_color') != "") {
                   echo get_option('frm_menu_background_color');
               } else {
                   echo '#333333';
               } ?>" class="text mp_input" <?php if (get_option('frm_menu_background_color') != "") {
            echo "style='background-color: #" . get_option('frm_menu_background_color') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Active Text Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_menu_textcolor" id="frm_menu_textcolor" type="text"
               value="<?php if (get_option('frm_menu_textcolor') != "") {
                   echo get_option('frm_menu_textcolor');
               } else {
                   echo '#ffffff';
               } ?>" class="text mp_input" <?php if (get_option('frm_menu_textcolor') != "") {
            echo "style='background-color: #" . get_option('frm_menu_textcolor') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Active Background Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_menu_active_background_color" id="frm_menu_active_background_color" type="text"
               value="<?php if (get_option('frm_menu_active_background_color') != "") {
                   echo get_option('frm_menu_active_background_color');
               } else {
                   echo '#5584a0';
               } ?>" class="text   mp_input" <?php if (get_option('frm_menu_active_background_color') != "") {
            echo "style='background-color: #" . get_option('frm_menu_active_background_color') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Inactive Text Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_menu_textcolor_inactive" id="frm_menu_textcolor_inactive" type="text"
               value="<?php if (get_option('frm_menu_textcolor_inactive') != "") {
                   echo get_option('frm_menu_textcolor_inactive');
               } else {
                   echo '#9c9c9c';
               } ?>" class="text mp_input" <?php if (get_option('frm_menu_textcolor_inactive') != "") {
            echo "style='background-color: #" . get_option('frm_menu_textcolor_inactive') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<h3>Layout Options</h3>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>Content Layout *</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">Will determine how content is displayed on listing views.</div>
        </div>
    </div>

    <div class="frm_right">

        <div class="layout_thumb plain">
            <label class="plain">
                <img src="<?php echo plugins_url(); ?>/mopublication/images/layouts/layout_plain.png" /><br />
                <input type="radio" value="plain" name="frm_layout"
                       class="mp_input" <?php if (get_option('frm_layout') == 'plain' or get_option('frm_layout') == '') {
                    echo 'checked';
                } ?>>
                <span>Default</span>
            </label>
        </div> 

        <div class="layout_thumb featured">
            <label class="featured">
                <img src="<?php echo plugins_url(); ?>/mopublication/images/layouts/layout_featured.png" /><br />
                <input type="radio" value="featured" name="frm_layout"
                       class="mp_input" <?php if (get_option('frm_layout') == 'featured') {
                    echo 'checked';
                } ?>>
                <span>Featured</span>
            </label>
        </div>

        <div class="layout_thumb page">
            <label class="page">
                <img src="<?php echo plugins_url(); ?>/mopublication/images/layouts/layout_page.png" /><br />
                <input type="radio" value="page" name="frm_layout"
                       class="mp_input" <?php if (get_option('frm_layout') == 'page') {
                    echo 'checked';
                } ?>>
                <span>Pages</span>
            </label>
        </div>

        <div class="layout_thumb grid">
            <label class="grid">
                <img src="<?php echo plugins_url(); ?>/mopublication/images/layouts/layout_grid.png" /><br />
                <input type="radio" value="grid" name="frm_layout"
                       class="mp_input" <?php if (get_option('frm_layout') == 'grid') {
                    echo 'checked';
                } ?>>
                <span>Grid</span>
            </label>
        </div>


    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<h3>Images</h3>


<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>Logo Image *</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">
                <p>Displayed at the top of your app.</p>
                Use a transparent PNG for best results.
            </div>
        </div>
    </div>

    <div class="frm_right">
        <?php
        /*
        // Don't put a minimum on the dimensions, just recommend the correct size
        <input id="frm_images_logo_min_width" type="hidden" value="620"/>
        <input id="frm_images_logo_min_height" type="hidden" value="71"/>
        <input id="frm_images_logo_allowed_types" type="hidden" value="png, jpg, jpeg"/>
        */
        ?>
        <input id="frm_topbar_logo" class="mopub_upload mp_input" type="text" size="36" name="frm_topbar_logo"
               value="<?php echo get_option('frm_topbar_logo'); ?>"/>
        <input id="frm_topbar_logo_btn" class="button upload_image_button" type="button" value="Upload Image"/>
        <?php if (esc_url(get_option('frm_topbar_logo'))) {
        echo " <a href='" . get_option('frm_topbar_logo') . "' target='_blank'>View Image</a>";
    } ?>

        <p class="description">Recommended size: 620 x 88 pixels. Allowed formats: png, jpg.</p>
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>App Icon *</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">
                <p>This is the icon that will be used for your app on the home screen in iOS and the App Store.</p>
                Please note Apple automatically rounds the corners.
            </div>
        </div>

    </div>

    <div class="frm_right">
        <?php
        /*
        // Removed checks because of users reporting that they can't upload pics
        <input id="frm_images_appicon_allowed_types" type="hidden" value="png, jpg, jpeg"/>
        <input id="frm_images_appicon_min_width" type="hidden" value="1024"/>
        <input id="frm_images_appicon_min_height" type="hidden" value="1024"/>
        */
        ?>

        <input id="frm_images_appicon" class="mopub_upload mp_input" type="text" size="36" name="frm_images_appicon"
               value="<?php echo get_option('frm_images_appicon'); ?>"/>
        <input id="frm_images_appicon_btn" class="button upload_image_button" type="button" value="Upload Image"/>
        <?php if (esc_url(get_option('frm_images_appicon'))) {
        echo " <a href='" . get_option('frm_images_appicon') . "' target='_blank'>View Image</a>";
    } ?>
        <p class="description">Recommended size: 1024 x 1024 pixels. Allowed formats: png, jpg.<br />Image must be square.</p>
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>


<h3>Content area</h3>

<!-- Start bordercolor -->

<div class="frm_row">

    <div class="frm_left">
        <label>Border Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_border_color" id="frm_border_color" type="text"
               value="<?php if (get_option('frm_border_color') != "") {
                   echo get_option('frm_border_color');
               } else {
                   echo '#c9c9c9';
               } ?>" class="text mp_input" <?php if (get_option('frm_border_color') != "") {
            echo "style='background-color: #" . get_option('frm_border_color') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Background Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_viewer_background" id="frm_viewer_background" type="text"
               value="<?php if (get_option('frm_viewer_background') != "") {
                   echo get_option('frm_viewer_background');
               } else {
                   echo '#ffffff';
               } ?>" class="text mp_input" <?php if (get_option('frm_viewer_background') != "") {
            echo "style='background-color: #" . get_option('frm_viewer_background') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<div class="clear"></div>


<h3>Typography</h3>

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Title Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_type_title_color" id="frm_type_title_color" type="text"
               value="<?php if (get_option('frm_type_title_color') != "") {
                   echo get_option('frm_type_title_color');
               } else {
                   echo '#365b70';
               } ?>" class="text mp_input" <?php if (get_option('frm_type_title_color') != "") {
            echo "style='background-color: #" . get_option('frm_type_title_color') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Date/Author Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_type_meta_color" id="frm_type_meta_color" type="text"
               value="<?php if (get_option('frm_type_meta_color') != "") {
                   echo get_option('frm_type_meta_color');
               } else {
                   echo '#a3a3a3';
               } ?>" class="text mp_input" <?php if (get_option('frm_type_meta_color') != "") {
            echo "style='background-color: #" . get_option('frm_type_meta_color') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Link Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_type_link_color" id="frm_type_link_color" type="text"
               value="<?php if (get_option('frm_type_link_color') != "") {
                   echo get_option('frm_type_link_color');
               } else {
                   echo '#365b70';
               } ?>" class="text mp_input" <?php if (get_option('frm_type_link_color') != "") {
            echo "style='background-color: #" . get_option('frm_type_link_color') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>Body Text Color *</label>
    </div>

    <div class="frm_right">
        <input name="frm_type_text_color" id="frm_type_text_color" type="text"
               value="<?php if (get_option('frm_type_text_color') != "") {
                   echo get_option('frm_type_text_color');
               } else {
                   echo '#707070';
               } ?>" class="text mp_input" <?php if (get_option('frm_type_text_color') != "") {
            echo "style='background-color: #" . get_option('frm_type_text_color') . "'";
        } ?>  />
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>Font *</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">This font will be used for all dynamic content in the app</div>
        </div>
    </div>

    <div class="frm_right">

        <div style="font-family: Helvetica, sans-serif;" class="font-style">
            <label class="helvetica">
                <input type="radio" value="helvetica" name="frm_type_font_type"
                       class="mp_input" <?php if (get_option('frm_type_font_type') == 'helvetica') {
                    echo 'checked';
                } ?>>
                <span>Helvetica (default)</span>
            </label>
        </div>

        <div style="font-family: Arial, sans-serif;" class="font-style">
            <label class="arial">
                <input type="radio" value="arial" name="frm_type_font_type"
                       class="mp_input" <?php if (get_option('frm_type_font_type') == 'arial') {
                    echo 'checked';
                } if (get_option('frm_type_font_type') == '') {
                    echo 'checked';
                } ?>>
                <span>Arial</span>
            </label>
        </div>

        <div style="font-family: Georgia, serif;" class="font-style">
            <label class="georgia">
                <input type="radio" value="georgia" name="frm_type_font_type"
                       class="mp_input" <?php if (get_option('frm_type_font_type') == 'georgia') {
                    echo 'checked';
                } ?>>
                <span>Georgia</span>
            </label>
        </div>

        <div style="font-family: Marion, serif;" class="font-style">
            <label class="marion">
                <input type="radio" value="marion" name="frm_type_font_type"
                       class="mp_input" <?php if (get_option('frm_type_font_type') == 'marion') {
                    echo 'checked';
                } ?>>
                <span>Marion</span>
            </label>
        </div>

        <div style="font-family: 'Trebuchet MS', sans-serif;" class="font-style">
            <label class="trebuchet_ms">
                <input type="radio" value="trebuchet ms" name="frm_type_font_type"
                       class="mp_input" <?php if (get_option('frm_type_font_type') == 'trebuchet ms') {
                    echo 'checked';
                } ?>>
                <span>Trebuchet MS</span>
            </label>
        </div>

        <div style="font-family: 'Times New Roman', serif;" class="font-style">
            <label class="times_new_roman">
                <input type="radio" value="times new roman" name="frm_type_font_type"
                       class="mp_input" <?php if (get_option('frm_type_font_type') == 'times new roman') {
                    echo 'checked';
                } ?>>
                <span>Times New Roman</span>
            </label>
        </div>

    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<div class="frm_row">

    <a href="#tab-2" class="button tabnav">Next</a> 

</div>


<div class="clear"></div>

</div>
