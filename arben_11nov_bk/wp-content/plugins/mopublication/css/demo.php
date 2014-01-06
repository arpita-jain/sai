<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Stylesheet for the demo
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */
?>

<style>

    .mopub_demo .demo_article { border-color: <?php if(get_option('frm_border_color')){echo get_option('frm_border_color');}else {echo '#dddddd';}; ?>; }
    .mopub_demo .demo_topbar { background-color: <?php if(get_option('frm_topbar_background')){ echo get_option('frm_topbar_background');}else { echo '#5585a0';} ?> ; }
    .mopub_demo .demo_menu { background-color: <?php if(get_option('frm_menu_background_color')){ echo get_option('frm_menu_background_color');} else { echo '#333333';} ?> ; }
    .mopub_demo .demo_menu .current  a  { color: <?php if(get_option('frm_menu_textcolor')){ echo get_option('frm_menu_textcolor');}else{ echo '#ffffff'; } ?>; }
    .mopub_demo .demo_menu .inactive  a  { color: <?php if(get_option('frm_menu_textcolor_inactive')){ echo get_option('frm_menu_textcolor_inactive'); }else{ echo '#666666';} ?>; }
    .mopub_demo .demo_article h3 a { color: <?php if(get_option('frm_type_title_color')){ echo get_option('frm_type_title_color');}else{ echo '#333333';} ?>; }
    .mopub_demo .demo_body .meta { color: <?php if(get_option('frm_type_meta_color')){ echo get_option('frm_type_meta_color');}else{ echo '#333333'; } ?> ; }
    .mopub_demo .demo_body a { color: <?php if(get_option('frm_type_link_color')){ echo get_option('frm_type_link_color'); }else{ echo '#333333';} ?>  ; }
    .mopub_demo .demo_body { color: <?php if(get_option('frm_type_text_color')){ echo get_option('frm_type_text_color');}else{ echo '#333333';} ?>; }
    .mopub_demo .viewer .demo_body {background-color: <?php if(get_option('frm_viewer_background')){ echo get_option('frm_viewer_background'); }else{ echo '#ffffff';} ?> ; }
    .mopub_demo .demo_menu ul li.current a {background-color: <?php if(get_option('frm_menu_active_background_color')){ echo get_option('frm_menu_active_background_color'); }else{ echo '555';} ?> ; }
    .mopub_demo .grid .demo_article h3 a{ color:#fff; font-weight: normal}
    }
    .mopub_demo .viewer {
        <?php if ( get_option('frm_type_font_type')) {
           echo 'font-family: ' . get_option('frm_type_font_type');
        }?>; }

</style>
