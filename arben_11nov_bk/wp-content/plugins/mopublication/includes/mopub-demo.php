<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Live demo (preview) of the app
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

?>
<div class="demo_topbar_background">

<div class="demo_topbar">
    <img src="<?php if (get_option('frm_topbar_logo') == '') {
        echo plugins_url('/'.$pluginDirectory.'/images/example_logo.png');
    } else {
        echo get_option('frm_topbar_logo');
    } ?>" height="32px"/>
</div>

</div>

<div class="demo_menu">
    <ul id="demo_menu_items">
        <?php
        $x = 0;

        foreach ($cat_arr as $field)
        {
            $field = str_replace("-", " ", $field);
            $class = '';

            if ($x === 0) {
                $class = 'current';
            } else {
                $class = 'inactive';
            }

            if (get_option('frm_cat_checkbox_' . str_replace(" ", "-", $field))) {
                echo '<li class=' . $class . '><a><span>' . ucwords($field) . '</span></a></li>';
                $x++;
            }

            
        }
        ?>
    </ul>
    <div class="clear"></div>
</div>

<div class="demo_body">
    <div class="ad_container">
    <div class="ad_display ad_display_iphone_top" style="display: <?php echo (in_array(get_option('frm_ad_status'), array('', 'none'))) ? 'none' : 'block'; ?>">
        <?php if (get_option('frm_ad_status') == 'custom_ad'): ?>
            <?php if (get_option('frm_ad_image_iphone_top') == '') :?>
            <img src="<?php echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');?>" width="229px" height="59px" id="demoAdvert"/>
            <?php else: ?>
            <img src="<?php echo get_option('frm_ad_image_iphone_top');?>" width="229px" height="59px" id="demoAdvert"/>
            <?php endif; ?>
        <?php elseif(get_option('frm_ad_status') == 'ad_embed_code') :?>
            <div id="demo_ad_embed_code"> <?php echo get_option('frm_ad_code_iphone_top'); ?></div>
        <?php else: ?>
            <img src="<?php echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');?>" width="229px" height="59px" id="demoAdvert"/>
        <?php endif; ?>
        <img src="<?php echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');?>" width="229px" height="59px" id="demoAdvertDefault"/>
        <?php if (get_option('frm_ad_image_iphone_top') == '') :?>
        <img src="<?php echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');?>" width="229px" height="59px" id="demoAdvertCustomDefault"/>
        <?php else: ?>
        <img src="<?php echo get_option('frm_ad_image_iphone_top');?>" width="229px" height="59px" id="demoAdvertCustomDefault"/>
        <?php endif; ?>
        <div id="demo_ad_embed_code_temp"></div>
        <img src="<?php echo plugins_url('/'.$pluginDirectory.'/images/example_banner.png');?>" width="229px" height="59px" id="demoAdvertTemp" />
    </div>
    </div>
    <?php 
    
    $args = array( 'numberposts' => 5, 'orderby' => 'post_date' );
    $posts = get_posts( $args ); 
    $demo_article_count = 0;
    ?>
    <?php if ($posts) : ?>
        <div class="demo_body_content">
    <?php foreach($posts as $post) : ?>
    <?php 
    $demo_article_count ++;
        $publishedDate = strtotime($post->post_date);
        
        $thumbnail = '';
        //Mopub featured image
        $thumbnail = get_post_meta($post->ID, 'mopub_featured_image', true);
        
        //If no thumbnail rather use featured image
        if(empty($thumbnail)) { 
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full');
            $thumbnail = $featured_image[0];
            
        }
        
        //Lastly if nothing set, scan the document.
        if(empty($thumbnail)) {
            $matchDemoImages = str_img_src($post->post_content);
            $thumbnail = $matchDemoImages[1][0];
        }
        
    ?>
    <div class="clear"></div>

    <div class="demo_article demo_article_<?php echo $demo_article_count; ?>">
        <?php if(!empty($thumbnail)) :?>
            <img src="<?php echo $thumbnail; ?>" />
        <?php else : ?>
            <img src="<?php echo plugins_url('/'.$pluginDirectory.'/images/default_thumbnail_75x75.png'); ?>" width="57px" height="57px" />
        <?php endif; ?>
        <div class="imageview"></div>
        <div class="demo_post_content">
            <h3><a><?php echo substr($post->post_title, 0, 55); ?></a></h3>
            <div class="paragraph"><?php echo substr(cleanContentDemo($post->post_content), 0, 55); ?></div>
            <div class="meta">Published: <?php echo date('d F Y',$publishedDate) ?></div>
            <div class="clear"></div>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<div class="demo_bottommenu">
    <ul id="tab_menu_items">
        <?php
        $i = 1;
        $more = false;
        $numChecked = 0;

        //workout how many tabs have been checked
        /*foreach ($tab_pages as $field) {
            if (get_option('frm_checkbox_' . $field)) {
                $numChecked++;
            }
        }
        
        foreach ($tab_pages as $field)
        {
            
            if ($numChecked > 5)
            {
                if (get_option('frm_checkbox_' . $field) && $i < 5 && $more == false)
                {
                    echo '<li class="icon_' . $field . '"><a>' . $field . '</a></li>';
                    $i++;
                }

                if ($i == 5 && $more == false)
                {
                    echo '<li class="icon_more"><a>More</a></li>';
                    $more = true;
                }
            }
            else
            {
                if (get_option('frm_checkbox_' . $field))
                {
                    echo '<li class="icon_' . $field . '"><a>' . $field . '</a></li>';
                    $i++;
                }
            }
        }*/
        
        $tab_pages = json_decode(get_option('mopub_tabs_order'), true);
        
        if(empty($tab_pages)) {
            
           $tab_pages = getSystemTabs();
            
        }
        
        foreach ($tab_pages as $tab) {
            if (get_option('frm_checkbox_' . $tab['ID'])) {
                $numChecked++;
            }
        }
        
        foreach ($tab_pages as $tab)
        {
            
            if ($numChecked > 5)
            {
                if (get_option('frm_checkbox_' . $tab['ID']) && $i < 5 && $more == false)
                {
                    echo '<li class="icon_' . $tab['icon'] . '"><a>' . $tab['name'] . '</a></li>';
                    $i++;
                }

                if ($i == 5 && $more == false)
                {
                    echo '<li class="icon_more"><a>More</a></li>';
                    $more = true;
                }
            }
            else
            {
                if (get_option('frm_checkbox_' . $tab['ID']))
                {
                    echo '<li class="icon_' . $tab['icon'] . '"><a>' . $tab['name'] . '</a></li>';
                    $i++;
                }
            }
        }
        
        
        
        
        if($numChecked == 0) {
           echo '<li class="icon_about"><a>About</a></li>'; 
           echo '<li class="icon_latest"><a>Latest</a></li>';
        }
        ?>
    </ul>
</div>

