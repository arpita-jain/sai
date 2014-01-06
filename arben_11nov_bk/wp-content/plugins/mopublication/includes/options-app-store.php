<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  App Store submission options
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */
?>

<div class="inner">

    <h3>Language</h3>

    <div class="frm_row">

        <div class="frm_left">
            <label>Content Language</label>
        </div>

        <?php
        $languages = array(
            'English',
            'Australian English',
            'Brazilian Portuguese',
            'Canadian English',
            'Canadian French',
            'Danish',
            'Dutch',
            'English',
            'Finnish',
            'French',
            'German',
            'Greek',
            'Indonesian',
            'Italian',
            'Japanese',
            'Korean',
            'Latin American Spanish',
            'Malay',
            'Norwegian',
            'Portuguese',
            'Russian',
            'Simplified Chinese',
            'Spanish',
            'Swedish',
            'Thai',
            'Traditional Chinese',
            'Turkish',
            'UK English',
            'Vietnamese',
        )
        ?>

        <div class="frm_right">
            <select class="mp_input" name="frm_language" id="frm_language">
                <?php foreach ($languages as $language): ?>
                <option value="<?php echo $language ?>"
                    <?php if (get_option('frm_language') == $language): ?>selected<?php endif; ?> >
                    <?php echo $language ?></option>
                <?php endforeach; ?>
            </select>

        </div>

        <div class="clear"></div>

    </div>


    <h3>Countries</h3>

    <div class="frm_row">

        <div class="frm_left">
            <label>Publish to these App Stores</label>
        </div>

        <div class="frm_right">

            <select name="frm_countries" id="frm_countries" class="mp_input">
                <option value="all" <?php if (get_option('frm_countries') == 'all') {
                    echo ' selected="selected"';
                } ?>>All
                </option>
                <option value="selected" <?php if (get_option('frm_countries') == 'selected') {
                    echo ' selected="selected"';
                } ?>>Let Me Choose
                </option>
            </select>

            <ul style="display: <?php echo get_option('frm_countries') == 'selected' ? 'block' : 'none'; ?>"
                id="countries_select">

                <?php
                $countries = array(
                    "Albania",
                    "Algeria",
                    "Angola",
                    "Anguilla",
                    "Antigua and Barbuda",
                    "Argentina",
                    "Armenia",
                    "Australia",
                    "Austria",
                    "Azerbaijan",
                    "Bahamas",
                    "Bahrain",
                    "Barbados",
                    "Belarus",
                    "Belgium",
                    "Belize",
                    "Benin",
                    "Bermuda",
                    "Bhutan",
                    "Bolivia",
                    "Botswana",
                    "Brazil",
                    "Brunei Darussalam",
                    "Bulgaria",
                    "Burkina Faso",
                    "Cambodia",
                    "Canada",
                    "Cape Verde",
                    "Cayman Islands",
                    "Chad",
                    "Chile",
                    "China",
                    "Colombia",
                    "Congo, Republic of",
                    "Costa Rica",
                    "Croatia",
                    "Cyprus",
                    "Czech Republic",
                    "Denmark",
                    "Dominica",
                    "Dominican Republic",
                    "Ecuador",
                    "Egypt",
                    "El Salvador",
                    "Estonia",
                    "Fiji",
                    "Finland",
                    "France",
                    "Gambia",
                    "Germany",
                    "Ghana",
                    "Greece",
                    "Grenada",
                    "Guatemala",
                    "Guinea-Bissau",
                    "Guyana",
                    "Honduras",
                    "Hong Kong",
                    "Hungary",
                    "Iceland",
                    "India",
                    "Indonesia",
                    "Ireland",
                    "Israel",
                    "Italy",
                    "Jamaica",
                    "Japan",
                    "Jordan",
                    "Kazakstan",
                    "Kenya",
                    "Korea, Republic Of",
                    "Kuwait",
                    "Kyrgyzstan",
                    "Lao People's Democratic Republic",
                    "Latvia",
                    "Lebanon",
                    "Liberia",
                    "Lithuania",
                    "Luxembourg",
                    "Macau",
                    "Macedonia, The Former Yugoslav Republic Of",
                    "Madagascar",
                    "Malawi",
                    "Malaysia",
                    "Mali",
                    "Malta",
                    "Mauritania",
                    "Mauritius",
                    "Mexico",
                    "Micronesia, Federated States of",
                    "Moldova, Republic Of",
                    "Mongolia",
                    "Montserrat",
                    "Mozambique",
                    "Namibia",
                    "Nepal",
                    "Netherlands",
                    "New Zealand",
                    "Nicaragua",
                    "Niger",
                    "Nigeria",
                    "Norway",
                    "Oman",
                    "Pakistan",
                    "Palau",
                    "Panama",
                    "Papua New Guinea",
                    "Paraguay",
                    "Peru",
                    "Philippines",
                    "Poland",
                    "Portugal",
                    "Qatar",
                    "Romania",
                    "Russia",
                    "Saint Lucia",
                    "Saudi Arabia",
                    "Senegal",
                    "Seychelles",
                    "Sierra Leone",
                    "Singapore",
                    "Slovakia",
                    "Slovenia",
                    "Solomon Islands",
                    "South Africa",
                    "Spain",
                    "Sri Lanka",
                    "St. Kitts and Nevis",
                    "St. Vincent and The Grenadines",
                    "Suriname",
                    "Swaziland",
                    "Sweden",
                    "Switzerland",
                    "Sao Tome and Principe",
                    "Taiwan",
                    "Tajikistan",
                    "Tanzania, United Republic Of",
                    "Thailand",
                    "Trinidad and Tobago",
                    "Tunisia",
                    "Turkey",
                    "Turkmenistan",
                    "Turks and Caicos",
                    "Uganda",
                    "Ukraine",
                    "United Arab Emirates",
                    "United Kingdom",
                    "United States",
                    "Uruguay",
                    "Uzbekistan",
                    "Venezuela",
                    "Vietnam",
                    "Virgin Islands, British",
                    "Yemen",
                    "Zimbabwe",
                    "New Territories As Added"
                );
                ?>

                <?php
                $selected_countries = get_option('frm_countries_select');

                //default all countries to checked
                if (!is_array($selected_countries))
                {
                    $selected_countries = array();
                    foreach ($countries as $country)
                    {
                        $selected_countries[$country] = "on";
                    }
                }
                ?>

                <li><input type="checkbox" id="select_all_countries"
                    <?php
                    if ( sizeof($selected_countries) == sizeof($countries) ) {
                        echo 'checked';
                    } elseif ( sizeof($selected_countries) == 0) {

                    } else {
                        echo 'checked class="some_selected" ';
                    }
                    ?>

                    >
                <strong>Select all</strong></li>
                <div style="border-bottom: 1px solid #DDD; margin-bottom: 5px;"> </div>


                <?php foreach ($countries as $country): ?>
                <?php echo '<li><label><input type="checkbox" class="country" name="frm_countries_select[' . $country . ']"'; ?>
                <?php if (!empty($selected_countries[$country])) echo 'checked="checked"'; ?>
                <?php echo '/> ' . $country . '</label></li>'; ?>
                <?php endforeach; ?>
            </ul>

        </div>

    </div>

    <div class="clear"></div>

    <h3>Categories</h3>

    <?php

    $categories = array(
        'News (default)',
        'Book',
        'Business',
        'Catalogs',
        'Education',
        'Entertainment',
        'Finance',
        'Food & Drink',
        'Games',
        'Health & Fitness',
        'Lifestyle',
        'Medical',
        'Music',
        'Navigation',
        'News',
        'Photo & Video',
        'Productivity',
        'Reference',
        'Social Networking',
        'Sports',
        'Travel',
        'Utilities',
        'Weather',
    )

    ?>

    <div class="frm_row">

        <div class="frm_left">
            <label>Primary Category</label>
        </div>

        <div class="frm_right">

            <select name="frm_category_primary" id="frm_category_primary">

                <?php foreach ($categories as $category): ?>

                <option value="<?php echo $category ?>"
                    <?php if (get_option('frm_category_primary') == $category): ?>selected<?php endif; ?> >
                    <?php echo $category ?></option>

                <?php endforeach; ?>

            </select>
        </div>
    </div>

    <div class="clear"></div>

    <div class="frm_row">

        <div class="frm_left">
            <label>Secondary Category</label>
        </div>

        <div class="frm_right">

            <select name="frm_category_secondary" id="frm_category_secondary">

                <option value="-"
                    <?php if (get_option('frm_category_secondary') == $category): ?>selected<?php endif; ?>
                    >-
                </option>

                <?php foreach ($categories as $category): ?>

                <option value="<?php echo $category ?>"
                    <?php if (get_option('frm_category_secondary') == $category): ?>selected<?php endif; ?> >
                    <?php echo $category ?></option>

                <?php endforeach; ?>

            </select>

        </div>
    </div>

    <div class="clear"></div>

    <h3>Age Restriction</h3>

    <div class="frm_row">

        <div class="frm_left">
            <label>Please Rate Your App<br/>Content</label>
        </div>

        <div class="frm_right">

            <ul>
                <li>
                    <div class="table_left">Cartoon or Fantasy Violence</div>
                    <select name="frm_age_fantasy_violence" id="frm_age_fantasy_violence">
                        <option <?php if (get_option('frm_age_fantasy_violence') == 'none'): ?>selected<?php endif; ?>
                            value="none">None
                        </option>
                        <option <?php if (get_option('frm_age_fantasy_violence') == 'low'): ?>selected<?php endif; ?>
                            value="low">Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_fantasy_violence') == 'high'): ?>selected<?php endif; ?>
                            value="high">Frequent/Intense
                        </option>
                    </select>
                </li>

                <li>
                    <div class="table_left">Realistic Violence</div>
                    <select name="frm_age_realistic_violence" id="frm_age_realistic_violence">
                        <option <?php if (get_option('frm_age_realistic_violence') == 'none'): ?>selected<?php endif; ?>
                            value="none">None
                        </option>
                        <option <?php if (get_option('frm_age_realistic_violence') == 'low'): ?>selected<?php endif; ?>
                            value="low">Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_realistic_violence') == 'high'): ?>selected<?php endif; ?>
                            value="high">Frequent/Intense
                        </option>
                    </select>
                </li>
                <li>
                    <div class="table_left">Sexual Content or Nudity</div>
                    <select name="frm_age_sexual" id="frm_age_sexual">
                        <option <?php if (get_option('frm_age_sexual') == 'none'): ?>selected<?php endif; ?> value="none">
                            None
                        </option>
                        <option <?php if (get_option('frm_age_sexual') == 'low'): ?>selected<?php endif; ?> value="low">
                            Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_sexual') == 'high'): ?>selected<?php endif; ?> value="high">
                            Frequent/Intense
                        </option>
                    </select>
                </li>
                <li>
                    <div class="table_left">Profanity or Crude Humor</div>
                    <select name="frm_age_profanity" id="frm_age_profanity">
                        <option <?php if (get_option('frm_age_profanity') == 'none'): ?>selected<?php endif; ?>
                            value="none">None
                        </option>
                        <option <?php if (get_option('frm_age_profanity') == 'low'): ?>selected<?php endif; ?> value="low">
                            Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_profanity') == 'high'): ?>selected<?php endif; ?>
                            value="high">Frequent/Intense
                        </option>
                    </select>
                </li>
                <li>
                    <div class="table_left">Alcohol, Tobacco, or Drug Use or References</div>
                    <select name="frm_age_drug" id="frm_age_drug">
                        <option <?php if (get_option('frm_age_drug') == 'none'): ?>selected<?php endif; ?> value="none">
                            None
                        </option>
                        <option <?php if (get_option('frm_age_drug') == 'low'): ?>selected<?php endif; ?> value="low">
                            Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_drug') == 'high'): ?>selected<?php endif; ?> value="high">
                            Frequent/Intense
                        </option>
                    </select>
                </li>
                <li>
                    <div class="table_left">Mature/Suggestive Themes</div>
                    <select name="frm_age_mature" id="frm_age_mature">
                        <option <?php if (get_option('frm_age_mature') == 'none'): ?>selected<?php endif; ?> value="none">
                            None
                        </option>
                        <option <?php if (get_option('frm_age_mature') == 'low'): ?>selected<?php endif; ?> value="low">
                            Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_mature') == 'high'): ?>selected<?php endif; ?> value="high">
                            Frequent/Intense
                        </option>
                    </select>
                </li>
                <li>
                    <div class="table_left">Simulated Gambling</div>
                    <select name="frm_age_gambling" id="frm_age_gambling">
                        <option <?php if (get_option('frm_age_gambling') == 'none'): ?>selected<?php endif; ?> value="none">
                            None
                        </option>
                        <option <?php if (get_option('frm_age_gambling') == 'low'): ?>selected<?php endif; ?> value="low">
                            Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_gambling') == 'high'): ?>selected<?php endif; ?> value="high">
                            Frequent/Intense
                        </option>
                    </select>
                </li>
                <li>
                    <div class="table_left">Horror/Fear Themes</div>
                    <select name="frm_age_horror" id="frm_age_horror">
                        <option <?php if (get_option('frm_age_horror') == 'none'): ?>selected<?php endif; ?> value="none">
                            None
                        </option>
                        <option <?php if (get_option('frm_age_horror') == 'low'): ?>selected<?php endif; ?> value="low">
                            Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_horror') == 'high'): ?>selected<?php endif; ?> value="high">
                            Frequent/Intense
                        </option>
                    </select>
                </li>
                <li>
                    <div class="table_left">Prolonged Graphic or Sadistic Realistic Violence</div>
                    <select name="frm_age_graphic_violence" id="frm_age_graphic_violence">

                        <option <?php if (get_option('frm_age_graphic_violence') == 'none'): ?>selected<?php endif; ?>
                            value="none">None
                        </option>
                        <option <?php if (get_option('frm_age_graphic_violence') == 'low'): ?>selected<?php endif; ?>
                            value="low">Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_graphic_violence') == 'high'): ?>selected<?php endif; ?>
                            value="high">Frequent/Intense
                        </option>


                        <!--option value="low">Infrequent/Mild</option> <!--(if selected, app won't be sold)-->
                        <!--option value="high">Frequent/Intense</option> <!--(if selected, app won't be sold)-->
                    </select>
                </li>
                <li>
                    <div class="table_left">Graphic Sexual Content and Nudity</div>
                    <select name="frm_age_graphic_sexual" id="frm_age_graphic_sexual">
                        <option <?php if (get_option('frm_age_graphic_sexual') == 'none'): ?>selected<?php endif; ?>
                            value="none">None
                        </option>
                        <option <?php if (get_option('frm_age_graphic_sexual') == 'low'): ?>selected<?php endif; ?>
                            value="low">Infrequent/Mild
                        </option>
                        <option <?php if (get_option('frm_age_graphic_sexual') == 'high'): ?>selected<?php endif; ?>
                            value="high">Frequent/Intense
                        </option>

                        <!--option value="low">Infrequent/Mild</option> <!--(if selected, app won't be sold)-->
                        <!--option value="high">Frequent/Intense</option> <!--(if selected, app won't be sold)-->
                    </select>
                </li>
            </ul>

        </div>
    </div>
    <div class="clear"></div>
    
    <h3>Security</h3>

    <div class="frm_row">
        <div class="frm_left">
            <div class="frm_left_left">
                <label>Protect your XML feeds</label>
            </div>
            <div class="frm_left_right">
                <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="tooltip">Enable this option to limit access to your content from the <?php echo $pluginName; ?> XML feed.</div>
            </div>
        </div>
        <div class="frm_right" id="iconNameHolder">
            <select name="frm_protect_xml" id="frm_protect_xml">
                <option <?php if (get_option('frm_protect_xml') == 'no'): ?>selected<?php endif; ?>  value="no">No</option>
                <option <?php if (get_option('frm_protect_xml') == 'yes'): ?>selected<?php endif; ?>  value="yes">Yes</option>
            </select>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    <h3>Content</h3>
    
    <div class="frm_row">
        
        <div class="frm_left">
            <div class="frm_left_left">
                <label>Enable strict filtering</label>
            </div>
            <div class="frm_left_right">
                <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="tooltip">If you notice that some special characters are being stripped from your content try disable this option.</div>
            </div>
        </div>
        <div class="frm_right" id="iconNameHolder">
            <select name="frm_strict_filtering" id="frm_strict_filtering">
                <option <?php if (get_option('frm_strict_filtering') == 'enableFiltering'): ?>selected<?php endif; ?>  value="enableFiltering">Yes</option>
                <option <?php if (get_option('frm_strict_filtering') == 'disableFiltering'): ?>selected<?php endif; ?>  value="disableFiltering">No</option>
            </select>
        </div>
        <div class="clear"></div>
        
    </div>
    
    <h3>Comments</h3>
    
        <div id="comment_options">
        <div class="frm_row">
            <div class="frm_left">
                <div class="frm_left_left">
                    <label>Comment option</label>
                </div>
                <div class="frm_left_right">
                    <div class="show_tooltip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="tooltip">Enable comments support in the app using the default Wordpress functionality or Disqus.</div>
                </div>
            </div>
            <div class="frm_right" id="iconNameHolder">
                <select name="frm_comment_option" id="frm_comment_option">
                    <option <?php if (get_option('frm_comment_option') == 'disable'): ?>selected<?php endif; ?> value="disabled">Disabled</option>
                    <option <?php if (get_option('frm_comment_option') == 'wordpress'): ?>selected<?php endif; ?>  value="wordpress">Default Wordpress comments</option>
                    <option <?php if (get_option('frm_comment_option') == 'disqus'): ?>selected<?php endif; ?>  value="disqus">Disqus</option>
                </select>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div id="comment_disqus_options" style="display:none">
        <div class="frm_row">
            <div class="frm_left">
                <div class="frm_left_left">
                    <label>Disqus short name</label>
                </div>
                <div class="frm_left_right">
                    
                </div>
            </div>
            <div class="frm_right" id="iconNameHolder">
                <input type="text" class="mopub_text mp_input" name="frm_disqus_short_name" id="frm_disqus_short_name"
                       value="<?php 
                                if (!get_option('frm_disqus_short_name') && get_option('disqus_forum_url')) {
                                    
                                    echo get_option('disqus_forum_url');
                                    
                                } else {
                                    
                                    echo get_option('frm_disqus_short_name');
                                    
                                }
                           
                           ?>"/>
            </div>
            <div class="clear"></div>
        </div>
        <div class="frm_row">
            <div class="frm_left">
                <div class="frm_left_left">
                    <label>Disqus API key</label>
                </div>
                <div class="frm_left_right">
                    
                </div>
            </div>
            <div class="frm_right" id="iconNameHolder">
                <input type="text" class="mopub_text mp_input" name="frm_disqus_api_key" id="frm_disqus_api_key"
                       value="<?php 
                                if (!get_option('frm_disqus_api_key') && get_option('disqus_api_key')) {
                                    
                                    echo get_option('disqus_api_key');
                                    
                                } else {
                                    
                                    echo get_option('frm_disqus_api_key');
                                    
                                }
                           
                           ?>"/>
            </div>
            <div class="clear"></div>
        </div>
        <div class="frm_row">
            <div class="frm_left">
                <div class="frm_left_left">
                    <label>Disqus User API key</label>
                </div>
                <div class="frm_left_right">
                    
                </div>
            </div>
            <div class="frm_right" id="iconNameHolder">
                <input type="text" class="mopub_text mp_input" name="frm_disqus_user_api_key" id="frm_disqus_user_api_key"
                       value="<?php 
                                if (!get_option('frm_disqus_user_api_key') && get_option('disqus_user_api_key')) {
                                    
                                    echo get_option('disqus_user_api_key');
                                    
                                } else {
                                    
                                    echo get_option('frm_disqus_user_api_key');
                                    
                                }
                           
                           ?>"/>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="clear"></div>

    <div class="frm_row">

        <a href="#tab-3" class="button tabnav">Previous</a>
        <a href="#tab-5" class="button tabnav">Next</a>

    </div>


</div><!-- /inner -->
