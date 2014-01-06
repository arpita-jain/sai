<?php
/**
 * Plugin Name: Profilecounter
 **/
/*for frontend*/
define('PROFILECOUNTER_VERSION', '1.0');
define('PROFILECOUNTER_DIR', plugin_dir_path(__FILE__));
define('PROFILECOUNTER_URL', plugin_dir_url(__FILE__));
add_action('admin_menu', 'count_info');
$url= esc_url( home_url( '/' ) ); 
   // add_submenu_page('abckid_affiliated/abckid-affiliated.php', 'Mentor list','Mentor list', 'administrator','Mentor_list','mentor_list');
function  count_info(){
add_menu_page('admin-menu', 'profilecounter', 5, __FILE__, 'profilecounter');
//add_submenu_page('profilecounter/profilecounter.php', 'Builder','Builder', 'administrator','profile_Group1','builder_count');
//add_submenu_page('profilecounter/profilecounter.php', 'Trader','Trader', 'administrator','profile_Group2','trader_count');

}
function profilecounter(){
    //include_once('../pagination.class.php');
    require_once('builder.php');
     }?>



