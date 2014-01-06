<?php
/*Plugin Name: Email Promotion
Plugin URI: http://www.cisin.com/
Description: Allow Email Promotion on site
Author: CIS
Author URI: hhttp://www.cisin.com/
Version: 1.1
*/
add_action('admin_menu','email_promotion');       
     function email_promotion(){
        add_menu_page('Promotion-email', 'Promotion', 5, __FILE__, 'display_email_form');
     }
     function display_email_form(){
    add_submenu_page('example','Promotion','Promotion','manage_optioms','Promotion_Email');
    add_action('admin_init', 'editor_admin_init');
    add_action('admin_head', 'editor_admin_head');

    function editor_admin_init() {
      wp_enqueue_script('word-count');
     wp_enqueue_script('post');
     wp_enqueue_script('editor');
    wp_enqueue_script('media-upload');
        }

    function editor_admin_head() {
        wp_tiny_mce();
        }
?>
    <div>&nbsp;&nbsp;&nbsp;&nbsp;</div>
    <?php if(isset($_POST['send']))
    {
    global $wpdb;
    foreach( $wpdb->get_results("SELECT * FROM wp_users") as $key => $row) {
// each column in your row will be accessible like this
    $user_email = $row->user_email;
    $id= $row->ID;
    $all_meta_for_user = get_user_meta( $id);
    $promotion_value=$all_meta_for_user['promotion'][0];
    if($promotion_value==1){
    $subject=$_POST['email_subject'];
    $message= $_POST['content'];
    $attachments = array(WP_CONTENT_DIR . '/uploads/file_to_attach.zip');
    $headers = 'From: My Name <myname@mydomain.com>' . "\r\n";
    wp_mail($user_email, $subject,$message, $headers, $attachments);
    }
    }
}?>
     <form action="" method="post">
     <h1>Send Promotion Email</h1>
     <div>
         <span>Subject: </span>
         <span><input type="text" name="email_subject" style="width:950px;margin-bottom:5px"></span>
         </div>
         <div></div>
         <div>
            
         <div style="margin-right:30px;margin-bottom:5px">
<?php
the_editor("", "content", "", true);
?>
</div>

        <div>
            <span></span>
            <span><input type="submit" value="SEND" name="send" class="button button-primary button-large"></span>
         </div>
         </form>
   <?php }
?>