<?php
/*
Plugin Name: Alchemist Ajax Upload
Plugin URI: http://www.tandukar.com
Description: Front-end ajax image upload. Add sohrtcode [AAIU] any where in post,page or in your custom form. For theme insert the code ' echo do_shortcode('[AAIU theme="true"]'); ' in your theme.
Version:  1.1
Author: Rajesh Tandukar
Author URI: http://www.tandukar.com
License: GPL2
*/

/*  2013  Rajesh Tandukar  (email : rtandukar@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('AAIU_BASENAME', trailingslashit(basename(dirname(__FILE__))));
define('AAIU_DIR', WP_CONTENT_DIR . '/plugins/' . AAIU_BASENAME);
define('AAIU_URL', WP_CONTENT_URL . '/plugins/' . AAIU_BASENAME);

class Alchimest__Ajax_Image_Upload
{
    public $option = 'aaiu-options';
    public $options = null;

    public function register()
    {
        register_setting('aaiu_plugin_option', $this->option, array($this, 'validate_options'));
    }

    public function initialize_default_options()
    {
        $default_options = array(
            "max_upload_size" => "100 ",
            "max_upload_no" => "2",
            "allow_ext" => "jpg,gif,png"
        );
        update_option($this->option, $default_options);

    }

    public function display($atts = null)
    {
        if (isset($atts)) {
            if ($atts['theme'] == true) {
                $this->enquee(true);
            }
        }
        include_once (AAIU_DIR . '/html.php');

    }

    public function validate_options($input)
    {
        return $input;
    }

    public function enquee($theme = false)
    {
        if ($theme) {
            $this->add_script();
        } elseif ($this->has_shortcode('AAIU')) {
            $this->add_script();

        }
    }

    public function add_script()
    {
        $this->options = get_option('aaiu-options');

        wp_enqueue_script('jquery');
        wp_enqueue_script('plupload-handlers');

        $max_file_size = intval($this->options['max_upload_size']) * 1000 * 1000;
        $max_upload_no = intval($this->options['max_upload_no']);
        $allow_ext = $this->options['allow_ext'];

        wp_enqueue_script('aaiu_upload', AAIU_URL . 'js/aaiu_upload.js', array('jquery'));

        wp_localize_script('aaiu_upload', 'aaiu_upload', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('aaiu_upload'),
            'remove' => wp_create_nonce('aaiu_remove'),
            'number' => $max_upload_no,
            'upload_enabled' => true,
            'confirmMsg' => __('Are you sure you want to delete this?'),
            'plupload' => array(
                'runtimes' => 'html5,flash,html4',
                'browse_button' => 'aaiu-uploader',
                'container' => 'aaiu-upload-container',
                'file_data_name' => 'aaiu_upload_file',
                'max_file_size' => $max_file_size . 'b',
                'url' => admin_url('admin-ajax.php') . '?action=aaiu_upload&nonce=' . wp_create_nonce('aaiu_allow'),
                'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                'filters' => array(array('title' => __('Allowed Files'), 'extensions' => $allow_ext)),
                'multipart' => true,
                'urlstream_upload' => true,
            )
        ));

    }

    public function upload()
    {
        check_ajax_referer('aaiu_allow', 'nonce');

        $file = array(
            'name' => $_FILES['aaiu_upload_file']['name'],
            'type' => $_FILES['aaiu_upload_file']['type'],
            'tmp_name' => $_FILES['aaiu_upload_file']['tmp_name'],
            'error' => $_FILES['aaiu_upload_file']['error'],
            'size' => $_FILES['aaiu_upload_file']['size']
        );
        $file = $this->fileupload_process($file);


    }

    public function fileupload_process($file)
    {
        $attachment = $this->handle_file($file);

        if (is_array($attachment)) {
            $html = $this->getHTML($attachment);

            $response = array(
                'success' => true,
                'html' => $html,
            );

            echo json_encode($response);
            exit;
        }

        $response = array('success' => false);
        echo json_encode($response);
        exit;
    }

    function handle_file($upload_data)
    {

        $return = false;
        $uploaded_file = wp_handle_upload($upload_data, array('test_form' => false));

        if (isset($uploaded_file['file'])) {
            $file_loc = $uploaded_file['file'];
            $file_name = basename($upload_data['name']);
            $file_type = wp_check_filetype($file_name);

            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $file_loc);
            $attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);
            wp_update_attachment_metadata($attach_id, $attach_data);

            $return = array('data' => $attach_data, 'id' => $attach_id);

            return $return;
        }

        return $return;
    }

    function getHTML($attachment)
    {

        $attach_id = $attachment['id'];
        $file = explode('/', $attachment['data']['file']);
        $file = array_slice($file, 0, count($file) - 1);
        $path = implode('/', $file);
        $image = $attachment['data']['sizes']['thumbnail']['file'];
        $post = get_post($attach_id);
        $dir = wp_upload_dir();
        $path = $dir['baseurl'] . '/' . $path;

        $html = '';
        $html .= '<li class="aaiu-uploaded-files">';
        $html .= sprintf('<img src="%s" name="' . $post->post_title . '" />', $path . '/' . $image);
        $html .= sprintf('<br /><a href="#" class="action-delete" data-upload_id="%d">%s</a></span>', $attach_id, __('Delete'));
        $html .= sprintf('<input type="hidden" name="aaiu_image_id[]" value="%d" />', $attach_id);
        $html .= '</li>';

        return $html;
    }


    function has_shortcode($shortcode = '', $post_id = false)
    {
        global $post;

        if (!$post) {
            return false;
        }

        $post_to_check = ($post_id == false) ? get_post(get_the_ID()) : get_post($post_id);

        if (!$post_to_check) {
            return false;
        }
        $return = false;

        if (!$shortcode) {
            return $return;
        }

        if (stripos($post_to_check->post_content, '[' . $shortcode) !== false) {
            $return = true;
        }

        return $return;
    }

    public function delete_file()
    {
        $attach_id = $_POST['attach_id'];
        wp_delete_attachment($attach_id, true);
        exit;
    }

}

function register_alchemist_menu_page()
{
    $menuSlug = 'alchemist_ajax_upload.php';
    add_menu_page('Waau', 'AAIU Upload', 'manage_options', $menuSlug, 'aaiu_settings');

}

function aaiu_settings()
{
    ?>
<div class="wrap">
    <h2>AAIU Settings</h2>

    <form method="post" name="aaiu-form" action="<?php echo 'options.php'; ?>">
        <?php settings_fields('aaiu_plugin_option'); ?>
        <?php $options = get_option('aaiu-options');?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><label for="max_upload_size">Max Upload Size</label></th>
                <td><input type="text" value="<?php echo $options['max_upload_size'];?>"
                           name="aaiu-options[max_upload_size]" size="10">

                    <p class="description">Size in MB.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="max_upload_no">Max Number of Image</label></th>
                <td><input type="text" value="<?php echo $options['max_upload_no'];?>"
                           name="aaiu-options[max_upload_no]" size="10">

                    <p class="description">Maximun number of Images user can upload.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="allow_ext">Allowed Extension</label></th>
                <td><input type="text" value="<?php echo $options['allow_ext'];?>"
                           name="aaiu-options[allow_ext]" size="20">

                    <p class="description">Eg: jpge,gif,png</p>
                </td>
            </tr>

            <tr valign="top">
                <td colspan="2"><?php submit_button(); ?></td>
            </tr>

            </tbody>
        </table>
    </form>
</div>
<?php
}

$aaiufile = WP_CONTENT_DIR . '/plugins/' . basename(dirname(__FILE__)) . '/' . basename(__FILE__);

$aaui = new Alchimest__Ajax_Image_Upload();
add_action('admin_init', array($aaui, 'register'));
add_action('admin_menu', 'register_alchemist_menu_page');
register_activation_hook($aaiufile, array($aaui, 'initialize_default_options'));
add_action('wp_enqueue_scripts', array($aaui, 'enquee'));
add_shortcode('AAIU', array($aaui, 'display'));
add_action('wp_ajax_aaiu_upload', array($aaui, 'upload'));
add_action('wp_ajax_aaiu_delete', array($aaui, 'delete_file'));

/* For non logged-in user */
add_action('wp_ajax_nopriv_aaiu_upload', array($aaui, 'upload'));
add_action('wp_ajax_nopriv_aaiu_delete', array($aaui, 'delete_file'));

