<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Smart App Banner Seting 
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */
  
add_action('admin_menu', 'mopub_create_options_menu');

function mopub_create_options_menu() {
    add_options_page('MoPublicatio Smart App Banner', 'Smart App Banner', 'administrator', __FILE__, 'mopub_options_page','');
    add_action( 'admin_init', 'register_mopub_settings' ); 
}

function register_mopub_settings() {
    register_setting( 'mopub-options-group', 'mopub_app_id' ); 
}

function mopub_options_page() { 
    global $pluginName, $pluginMode;
?>

<div class="wrap">
    <h2><?php echo $pluginName; ?> Smart App Banner</h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'mopub-options-group' ); ?>
        <table class="form-table">

            <tbody>
                <tr valign="top">
                    <?php if($pluginMode == 1) :?>
                    <th scope="row" colspan="2">
                        Set up a Smart App Banner by entering your details below or <a href="http://support.mopublication.com/customer/portal/articles/785600-what-are-smart-banners-and-how-do-they-work-" target="new">find out more about Smart App Banners</a>.
                    </th>
                    <?php endif;  ?>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        App ID
                    </th>
                    <td>
                        <input name="mopub_app_id" type="text" id="mopub_app_id" value="<?php echo get_option('mopub_app_id'); ?>" class="regular-text"/>
                        <p class="description">
                            Please enter your app's App Store ID. (e.g. 123456789)
                        </p>
                    </td>  
                </tr> 
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>

    </form>
</div>

<?php } 

add_action('wp_head', 'mopub_app_meta');

function mopub_app_meta() { 
    if(get_option('mopub_app_id')) {
        echo '<meta name="apple-itunes-app" content="app-id='.get_option('mopub_app_id').'"/>' . "\n";
    }
}
?>