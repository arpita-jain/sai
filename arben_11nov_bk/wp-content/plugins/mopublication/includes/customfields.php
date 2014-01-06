<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Defines the Custom Fields for Mobile video and audio
 *   used by the MoPublication app
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

$mopub_prefix = 'mopub_';

$mopub_meta_box = array(
    'id' => 'mopub-meta-box',
    'title' => $pluginName.' Options',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'low',
    'fields' => array(
        array(
            'title' => 'Mobile Featured Image',
            'type' => 'label' 
        ),
        array(
            'name' => 'Image Title',
            'desc' => 'Enter a short title for your featured image',
            'id' => $mopub_prefix . 'featured_title',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Caption',
            'desc' => 'Enter a short description of your image',
            'id' => $mopub_prefix . 'featured_caption',
            'type' => 'text',
            'std' => ''
        ) ,
        array(
            'name' => 'Image',
            'desc' => 'The path/URL to the video file.',
            'id' => $mopub_prefix . 'featured_image',
            'type' => 'upload',
            'formats' => 'png, jpg, jpeg',
            'std' => ''
        ),
        array(
            'title' => 'Video Embed',
            'type' => 'label' 
        ),
        array(
            'name' => 'YouTube URL',
            'desc' => 'Link to the YouTube video',
            'id' => $mopub_prefix . 'embed_video_youtube',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Vimeo URL',
            'desc' => 'Link to the Vimeo video',
            'id' => $mopub_prefix . 'embed_video_vimeo',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'title' => 'Mobile Video',
            'type' => 'label' 
        ),
        array(
            'name' => 'Title',
            'desc' => 'Enter a short title for your video',
            'id' => $mopub_prefix . 'vid_title',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Caption',
            'desc' => 'Enter a short description of your video',
            'id' => $mopub_prefix . 'vid_caption',
            'type' => 'text',
            'std' => ''
        ) ,
        array(
            'name' => 'Video File',
            'desc' => 'The path/URL to the video file.',
            'id' => $mopub_prefix . 'vid_video',
            'type' => 'upload',
            'formats' => 'AAC, MP3, mov, mp4, mpv, 3gp',
            'std' => ''
        ),
        array(
            'name' => 'Video Thumbnail',
            'desc' => 'The path/URL to the video image file.',
            'id' => $mopub_prefix . 'vid_image',
            'type' => 'upload',
            'formats' => 'png, jpg, jpeg',
            'std' => ''
        ),
        array(
            'title' => 'Mobile Audio',
            'type' => 'label' 
        ),
        array(
            'name' => 'Title',
            'desc' => 'Enter a short title for your audio clip',
            'id' => $mopub_prefix . 'aud_title',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Caption',
            'desc' => 'Enter a short description of your audio clip',
            'id' => $mopub_prefix . 'aud_caption',
            'type' => 'text',
            'std' => ''
        ) ,
        array(
            'name' => 'Audio File',
            'desc' => 'The path/URL to the audio.',
            'id' => $mopub_prefix . 'aud_video',
            'type' => 'upload',
            'formats' => 'mp3',
            'std' => ''
        ),
        array(
            'name' => 'Audio Thumbnail',
            'desc' => 'The path/URL to the audio image file.',
            'id' => $mopub_prefix . 'aud_image',
            'type' => 'upload',
            'formats' => 'png, jpg, jpeg',
            'std' => ''
        ),
    )
);

add_action('admin_menu', 'mopub_add_box');
// Add meta box
function mopub_add_box() {
    
    global $mopub_meta_box, $pluginName;
    add_meta_box($mopub_meta_box['id'], $mopub_meta_box['title'], 'mopub_show_box', $mopub_meta_box['page'], $mopub_meta_box['context'], $mopub_meta_box['priority'], $mopub_meta_box['fields']);
    
}

// Start image uploader

function mopub_embed_uploader_code() { 
    global $pluginDirectory;
?>
    <script type="text/javascript" src="<?php echo plugins_url('/'.$pluginDirectory.'/js/media.js'); ?>"></script>
<?php }

add_action('admin_head', 'mopub_embed_uploader_code');

// End image uploader

// Callback function to show fields in meta box
function mopub_show_box($args, $fields) {
    
    global $post, $pluginName;
    
    // Use nonce for verification
    echo '<input type="hidden" name="mopub_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    echo '<table class="form-table">';
    foreach ($fields['args'] as $field) {

        $meta = array();

        if ( ! empty($field['id']) )
        {
            // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);
        }
        
        if($field['type'] == 'label') 
        {
        	echo "<tr><th colspan='2'><h4>".$field['title']."</h4></th></tr>";	
        }
        else
        {
        	
        echo '<tr>',
                '<th style=""><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:365px" />', '<br /><p class="description">', $field['desc'] . '</p>';
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option ', $meta == $option ? ' selected="selected"' : '', ' value="'.$option.'">', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
			 case 'upload':  

				echo '<input id="input_'.$field['id'].'" class="myInputField" type="text" size="36" name="'.$field['id'].'" value="'. $meta. '" />';
				echo '<input id="input_'.$field['id'].'_btn" class="button upload_image_button" type="button" value="Upload File" />';
				if($meta != "") {
					echo " <a href='".$meta."'>View / Download</a>";	
				}
                if (!empty($field['formats']))
                {
                    echo '<input id="input_'.$field['id'].'_allowed_types" type="hidden" value="' . $field['formats'] . '" />';
                    echo '<p class="description">Allowed formats: ' . $field['formats'] . '</p>';
                }

                break;
        }
        echo     '</td><td>',
            '</td></tr>';
            
        }
    }
    echo '</table>';
}




add_action('save_post', 'mopub_save_post');
// Save data from meta box
function mopub_save_post($post_id)
{
    global $mopub_meta_box, $mopub_meta_box_page, $pluginName;
    
    $currentMetaBox = array();
    
    $post = get_post($post_id);
    
    //TODO: Workout why is_page() does not work here
    if($post->post_parent) {

        $parentPost = get_post($post->post_parent);

        if($parentPost->post_type == 'page') {
            
            $currentMetaBox = $mopub_meta_box_page;
            
            
        } else {
            
            $currentMetaBox = $mopub_meta_box;
            
        }
        
    } else {
        
        if($post->post_type == 'page') {
            
            $currentMetaBox = $mopub_meta_box_page;
            
        } else {
            
            $currentMetaBox = $mopub_meta_box;
            
        }
        
    }
    
    // verify nonce
    if ( empty($_POST['mopub_meta_box_nonce']) )
    {
        return $post_id;
    }
    else
    {
        if ( ! wp_verify_nonce($_POST['mopub_meta_box_nonce'], basename(__FILE__)) ) {
            return $post_id;
        }
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        
        return $post_id;
        
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
        
    } elseif (!current_user_can('edit_post', $post_id)) {
        
        return $post_id;
        
    }
    foreach ($currentMetaBox['fields'] as $field) {
        
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        
        if ($new && $new != $old) {
            
            update_post_meta($post_id, $field['id'], $new);
            
        } elseif ('' == $new && $old) {
            
            delete_post_meta($post_id, $field['id'], $old);
            
        }
        
    }
}

