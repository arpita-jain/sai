<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Tab 2: Content Management options
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */
?>

<div class="inner">

<div id="catMenu">
    <h3>Category Menu</h3>


    <!-- Start Textbox -->

    <div class="frm_row">

        <div class="frm_left">
            <div class="frm_left_left">
                <label>Select categories</label>
            </div>
            <div class="frm_left_right">
                <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="tooltip">
                    <p>These are your website categories that will be used as menu items in your app.</p>
                    You can select as many categories as you like, since the navigation scrolls horizontally.
                </div>
            </div>
        </div>

        <div class="frm_right">
            <p class="description">The order can be arranged by dragging the boxes up and down.</p>
            <ul id="categoriessortable">


                <?php
                foreach ($cat_arr as $field) {

                    echo '<li class="ui-state-default menu-item-handle" id="' . str_replace(" ", "-", ucfirst($field)) . '">';
                    if (get_option('frm_cat_checkbox_' . str_replace(" ", "-", $field))) {
                        $checked = "checked=\"checked\"";
                    } else {
                        $checked = "";
                    }
                    echo '<label> <input class="mp_input categoriesToInclude" type="checkbox" name="frm_cat_checkbox_' . strtolower(str_replace(" ", "-", $field)) . '" id="frm_cat_checkbox_' . strtolower(str_replace(" ", "-", $field)) . '" ' . $checked . ' /> ' . ucfirst(str_replace("-", " ", $field)) . '</label>';
                    echo '</li>';

                }

                ?>
            </ul>
        </div>

        <div class="clear"></div>

    </div>

    <!-- End Textbox -->
</div><!-- category menu -->
<div class="clear"></div>


<h3>Pages</h3>

<div class="clear"></div>

<!-- Start Checkbox -->

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>Select pages</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">
                Only the first 4 options will appear in the menu if more
                than 5 are selected (additional items are shown by tapping
                the "More" icon). Unsaved will not display in the preview.
            </div>
        </div>
    </div>

    <div class="frm_right">
        <p class="description">Arrange the page order by dragging the boxes up and down.</p>
        <ul id="pagessortable">
            <?php
            
             $systemTabs = getSystemTabs();   
             $tabOrder = json_decode(get_option('mopub_tabs_order'), true);
             
             //initialize
             if(empty($tabOrder)) {
                 
                $tabOrder =  addToTabsOrder($systemTabs);
                 
             } 
             
             foreach ($tabOrder as $tab) {

                echo '<li class="ui-state-default menu-item-handle" id="' . $tab['TABID'] . '" alt="frm_checkbox_' . $tab['ID'] . '" >';
                
                if (get_option('frm_checkbox_' . $tab['ID'])) {
                    $checked = "checked=\"checked\"";
                } else {
                    $checked = "";
                }
                
                echo '<label> <input type="checkbox" class="mp_input tabsToInclude" name="frm_checkbox_' . $tab['ID'] . '" id="frm_checkbox_' . $tab['ID'] . '" alt="'.$tab['icon'].'" title="'.$tab['name'].'"'; 
                
                if($tab['ID'] == 'about' || $tab['ID'] == 'latest') {
                    echo 'CHECKED DISABLED';
                } else {
                    echo  $checked;
                }

                echo ' /> ' . ucfirst($tab['name']);
                
                if($tab['type'] == 'page') {

                     echo '<div style="float:right;"><a href="#" alt="' . $tab['TABID'] . '-'.$tab['ID'].'" class="deletePage">DELETE</a><a href="#" class="previewOptions showPreview" alt="'.$tab['ID'].'">Preview</a> </div>';

                 }
                
                echo '</label></li>';

            }
                   
            ?>
            <input type="hidden" name="frm_checkbox_latest" value="1" />
            <input type="hidden" name="frm_checkbox_about" value="1" />
        </ul>
        
    </div>

    <div class="clear"></div>

</div>

<!-- End Checkbox -->

<div class="clear"></div>




<h3>Multimedia</h3>

<div class="clear"></div>

<!-- Start Select -->

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>Video Category</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">Category to use for pulling video content</div>
        </div>
    </div>

    <div class="frm_right">

        <select name="frm_video_cat" id="frm_video_cat" class="mp_input">
            <option value="">None</option>
            <?php
            $cats = get_categories();
            foreach ($cats as $cat) {
                ?>
                <option value="<?php echo $cat->cat_name; ?>" <?php if (get_option('frm_video_cat') == $cat->cat_name) {
                    echo "selected='selected'";
                } ?>>
                    <?php echo $cat->cat_name . ' (' . $cat->category_count . ')'; ?>
                </option>
                <?php
            }
            ?>

        </select>

    </div>

    <div class="clear"></div>
</div>

<!-- End Select -->

<div class="clear"></div>
<!-- Start Select -->

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>Audio Category</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">Category to use for pulling audio content</div>
        </div>
    </div>

    <div class="frm_right">
        <select name="frm_audio_cat" id="frm_audio_cat" class="mp_input">
            <option value="">None</option>
            <?php
            $cats = get_categories();
            foreach ($cats as $cat) {
                ?>
                <option value="<?php echo $cat->cat_name; ?>" <?php if (get_option('frm_audio_cat') == $cat->cat_name) {
                    echo "selected='selected'";
                } ?>>
                    <?php echo $cat->cat_name . ' (' . $cat->category_count . ')'; ?>
                </option>
                <?php
            }
            ?>

        </select>
    </div>

    <div class="clear"></div>
</div>

<!-- End Select -->

<div class="clear"></div>


<h3>About</h3>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <label>About Screen</label>
        <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <div class="tooltip">A brief description of your company which will appear on
            the "About" screen</div>
    </div>

    <div class="frm_right">
        <textarea name="frm_about_about" id="frm_about_about"
                  class="large-text mp_input"><?php echo get_option('frm_about_about'); ?></textarea>
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<h3>Contact</h3>

<!-- Start Textbox -->

<div class="frm_row">
    <div class="frm_left">
        <div class="frm_left_left">
            <label>Email Address</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">
                <p>Enter an email address if you want your app users to be able to contact you.</p>
                This will appear on the "Contact" screen if selected.
            </div>
        </div>
    </div>

    <div class="frm_right">
        <input type="text" class="mopub_text mp_input" name="frm_contact_email" id="frm_contact_email"
               value="<?php echo get_option('frm_contact_email'); ?>"/>
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<!-- Start Textbox -->

<div class="frm_row">

    <div class="frm_left">
        <div class="frm_left_left">
            <label>General Contact Information</label>
        </div>
        <div class="frm_left_right">
            <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="tooltip">
                <p>General information such as business address or telephone number.</p>
                This will appear on the "Contact" screen if selected.
            </div>
        </div>
    </div>

    <div class="frm_right">
        <textarea name="frm_contact_intro" id="frm_contact_intro" class="large-text mp_input"><?php echo get_option('frm_contact_intro'); ?></textarea>
    </div>

    <div class="clear"></div>

</div>

<!-- End Textbox -->

<div class="clear"></div>

<div class="frm_row">
    <a href="#tab-1" class="button tabnav">Previous</a>
    <a href="#tab-3" class="button tabnav">Next</a>
</div>

<div class="clear"></div>

</div>
