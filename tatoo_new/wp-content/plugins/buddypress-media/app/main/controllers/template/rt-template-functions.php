<?php

/**
 * Checks at any point of time any media is left to be processed in the db pool
 * @global type $rtmedia_query
 * @return type
 */
function have_rtmedia () {
    global $rtmedia_query;

    return $rtmedia_query->have_media ();
}

/**
 * Rewinds the db pool of media album and resets it to begining
 * @global type $rtmedia_query
 * @return type
 */
function rewind_rtmedia () {

    global $rtmedia_query;

    return $rtmedia_query->rewind_media ();
}

/**
 * moves ahead in the loop of media within the album
 * @global type $rtmedia_query
 * @return type
 */
function rtmedia () {
    global $rtmedia_query;

    return $rtmedia_query->rtmedia ();
}

/**
 * echo the title of the media
 * @global type $rtmedia_media
 */
function rtmedia_title () {

    global $rtmedia_backbone;
    if ( $rtmedia_backbone[ 'backbone' ] ) {
        echo '<%= media_title %>';
    } else {
        global $rtmedia_media;
        return $rtmedia_media->media_title;
    }
}

function rtmedia_author_profile_pic ( $show_link = true ) {
    global $rtmedia_backbone;
    if ( $rtmedia_backbone[ 'backbone' ] ) {
        echo '';
    } else {
        global $rtmedia_media;
        $show_link = apply_filters ( "rtmedia_single_media_show_profile_picture_link", $show_link );
        if ( $show_link ) {
            echo "<a href='" . get_rtmedia_user_link ( $rtmedia_media->media_author ) . "' title='" . rtmedia_get_author_name ( $rtmedia_media->media_author ) . "'>";
        }
        $size = apply_filters ( "rtmedia_single_media_profile_picture_size", 90 );
        if ( function_exists ( "bp_get_user_has_avatar" ) ) {
            if ( bp_core_fetch_avatar ( array( 'item_id' => $rtmedia_media->media_author, 'object' => 'user', 'no_grav' => false, 'html' => false ) ) != bp_core_avatar_default () ) {
                echo bp_core_fetch_avatar ( array( 'item_id' => $rtmedia_media->media_author, 'object' => 'user', 'no_grav' => false, 'html' => true, 'width' => $size, 'height' => $size ) );
            } else {
                echo "<img src='" . bp_core_avatar_default () . "' width='" . $size . "'  height='" . $size . "'/>";
            }
        } else {
            echo get_avatar ( $rtmedia_media->media_author, $size );
        }
        if ( $show_link ) {
            echo "</a>";
        }
    }
}

function rtmedia_author_name ( $show_link = true ) {

    global $rtmedia_backbone;
    if ( $rtmedia_backbone[ 'backbone' ] ) {
        echo '';
    } else {
        global $rtmedia_media;
        $show_link = apply_filters ( "rtmedia_single_media_show_profile_name_link", $show_link );
        if ( $show_link ) {
            echo "<a href='" . get_rtmedia_user_link ( $rtmedia_media->media_author ) . "' title='" . rtmedia_get_author_name ( $rtmedia_media->media_author ) . "'>";
        }
        echo rtmedia_get_author_name ( $rtmedia_media->media_author );
        if ( $show_link ) {
            echo "</a>";
        }
    }
}

function rtmedia_get_author_name ( $user_id ) {
    if ( function_exists ( "bp_core_get_user_displayname" ) ) {
        return bp_core_get_user_displayname ( $user_id );
    } else {
        $user = get_userdata ( $user_id );
        if ( $user ) {
            return $user->display_name;
        }
    }
}

function rtmedia_media_gallery_class () {
    global $rtmedia_query;
    if ( isset ( $rtmedia_query->media_query ) && isset ( $rtmedia_query->media_query[ "context_id" ] ) )
        echo "context-id-" . $rtmedia_query->media_query[ "context_id" ];
}

function rtmedia_id ( $media_id = false ) {
    if ( $media_id ) {
        $model = new RTMediaModel();
        $media = $model->get_media ( array( 'media_id' => $media_id ), 0, 1 );
        return $media[ 0 ]->id;
    } else {
        global $rtmedia_media;
        return $rtmedia_media->id;
    }
}

function rtmedia_media_id ( $id = false ) {
    if ( $id ) {
        $model = new RTMediaModel();
        $media = $model->get_media ( array( 'id' => $id ), 0, 1 );
        return $media[ 0 ]->media_id;
    } else {
        global $rtmedia_media;
        return $rtmedia_media->media_id;
    }
}

function rtmedia_activity_id ( $id = false ) {
    if ( $id ) {
        $model = new RTMediaModel();
        $media = $model->get_media ( array( 'id' => $id ), 0, 1 );
        return $media[ 0 ]->activity_id;
    } else {
        global $rtmedia_media;
        return $rtmedia_media->activity_id;
    }
}

function rtmedia_type ( $id = false ) {
    if ( $id ) {
        $model = new RTMediaModel();
        $media = $model->get_media ( array( 'id' => $id ), 0, 1 );
        return $media[ 0 ]->media_type;
    } else {
        global $rtmedia_media;
        return $rtmedia_media->media_type;
    }
}

function rtmedia_cover_art ( $id = false ) {
    if ( $id ) {
        $model = new RTMediaModel();
        $media = $model->get_media ( array( 'id' => $id ), 0, 1 );
        return $media[ 0 ]->cover_art;
    } else {
        global $rtmedia_media;
        return $rtmedia_media->cover_art;
    }
}

/**
 * echo parmalink of the media
 * @global type $rtmedia_media
 */
function rtmedia_permalink ( $media_id = false ) {

    global $rtmedia_backbone;

    if ( $rtmedia_backbone[ 'backbone' ] ) {
        echo '<%= rt_permalink %>';
    } else {
        echo get_rtmedia_permalink ( rtmedia_id ( $media_id ) );
    }
}

function rtmedia_media ( $size_flag = true, $echo = true, $media_size = "rt_media_single_image" ) {
    $size_flag = true;
    global $rtmedia_media, $rtmedia;
    if ( isset ( $rtmedia_media->media_type ) ) {
        if ( $rtmedia_media->media_type == 'photo' ) {
            $src = wp_get_attachment_image_src ( $rtmedia_media->media_id, $media_size );
            $html = "<img src='" . $src[ 0 ] . "' alt='' />";
        } elseif ( $rtmedia_media->media_type == 'video' ) {
            $size = " width=\"" . $rtmedia->options[ "defaultSizes_video_singlePlayer_width" ] . "\" height=\"" . $rtmedia->options[ "defaultSizes_video_singlePlayer_height" ] . "\" ";

            $html = '<video src="' . wp_get_attachment_url ( $rtmedia_media->media_id ) . '" ' . $size . ' type="video/mp4" class="wp-video-shortcode" id="bp_media_video_' . $rtmedia_media->id . '" controls="controls" preload="true"></video>';
        } elseif ( $rtmedia_media->media_type == 'music' ) {
            $size = ' width="600" height="0" ';
            if ( ! $size_flag )
                $size = '';
            $html = '<audio src="' . wp_get_attachment_url ( $rtmedia_media->media_id ) . '" ' . $size . ' type="audio/mp3" class="wp-audio-shortcode" id="bp_media_audio_' . $rtmedia_media->id . '" controls="controls" preload="none"></audio>';
        } else {
            $html = false;
        }
    } else {
        $html = false;
    }

    do_action ( 'rtmedia_after_' . $rtmedia_media->media_type, $rtmedia_media->id );

    $html = apply_filters ( 'rtmedia_single_content_filter', $html, $rtmedia_media );

    if ( $echo )
        echo $html;
    else
        return $html;
}

/*
 * echo http url of the media
 */

function rtmedia_image ( $size = 'rt_media_thumbnail', $id = false ,$recho = true ) {
    global $rtmedia_backbone;

    if ( $rtmedia_backbone[ 'backbone' ] ) {
        echo '<%= guid %>';
        return;
    }

    if ( $id ) {
        $model = new RTMediaModel();
        $media = $model->get_media ( array( 'id' => $id ), false, false );
        if ( isset ( $media[ 0 ] ) )
            $media_object = $media[ 0 ];
        else
            return false;
    } else {
        global $rtmedia_media;
        $media_object = $rtmedia_media;
    }

    $thumbnail_id = 0;
    if ( isset ( $media_object->media_type ) ) {
        if ( $media_object->media_type == 'album' || $media_object->media_type != 'photo' || $media_object->media_type == 'video' ) {
            $thumbnail_id = (isset ( $media_object->cover_art) && ($media_object->cover_art !=  "0"  )) ? $media_object->cover_art : false;
        } elseif ( $media_object->media_type == 'photo' ) {
            $thumbnail_id = $media_object->media_id;
        } else {
            $thumbnail_id = false;
        }
    } else {
        $src = false;
    }

    if ( ! $thumbnail_id ) {
        global $rtmedia;
        if ( isset ( $rtmedia->allowed_types[ $media_object->media_type ] ) && isset ( $rtmedia->allowed_types[ $media_object->media_type ][ 'thumbnail' ] ) ) {
            $src = $rtmedia->allowed_types[ $media_object->media_type ][ 'thumbnail' ];
        } elseif ( $media_object->media_type == 'album' ) {
            $src = rtmedia_album_image ( $size , $id );
        } else {
            $src = false;
        }
    } else {
        if(is_numeric($thumbnail_id) && $thumbnail_id != "0" ) {

        list($src, $width, $height) = wp_get_attachment_image_src ( $thumbnail_id, $size );
        } else {
            $src = $thumbnail_id;
        }
    }

    $src = apply_filters ( 'rtmedia_media_thumb', $src, $media_object->id, $media_object->media_type );
    if($recho == true){
        echo $src;
    }else{
        return $src;
    }
}

function rtmedia_album_image ( $size = 'thumbnail', $id = false) {
    global $rtmedia_media;
    $model = new RTMediaModel();
    if($id == false){
        $id = $rtmedia_media->id;
    }
    $media = $model->get_media ( array( 'album_id' => $id, 'media_type' => 'photo' ), 0, 1 );

    if ( $media ) {
        $src = rtmedia_image ( $size, $media[ 0 ]->id ,false);
    } else {
        global $rtmedia;
        $src = $rtmedia->allowed_types[ 'photo' ][ 'thumbnail' ];
    }
    return $src;
}

function rtmedia_sanitize_object ( $data, $exceptions = array( ) ) {
    foreach ( $data as $key => $value ) {
        if ( ! in_array ( $key, array_merge ( RTMediaMedia::$default_object, $exceptions ) ) )
            unset ( $data[ $key ] );
    }
    return $data;
}

function rtmedia_delete_allowed () {
    global $rtmedia_media;

    $flag = $rtmedia_media->media_author == get_current_user_id ();

    if(!$flag)
        $flag = is_super_admin ();

    $flag = apply_filters ( 'rtmedia_media_delete_priv', $flag );

    return $flag;
}

function rtmedia_edit_allowed () {

    global $rtmedia_media;

    $flag = $rtmedia_media->media_author == get_current_user_id ();

    if(!$flag)
        $flag = is_super_admin ();

    $flag = apply_filters ( 'rtmedia_media_edit_priv', $flag );

    return $flag;
}

function rtmedia_request_action () {
    global $rtmedia_query;
    return $rtmedia_query->action_query->action;
}

function rtmedia_title_input () {
    global $rtmedia_media;

    $name = 'media_title';
    $value = $rtmedia_media->media_title;

    $html = '';

    if ( rtmedia_request_action () == 'edit' )
        $html .= '<input type="text" name="' . $name . '" id="' . $name . '" value="' . $value . '">';
    else
        $html .= '<h2 name="' . $name . '" id="' . $name . '">' . $value . '</h2>';

    $html .= '';

    echo $html;
}

function rtmedia_description_input () {
    global $rtmedia_media;

    $name = 'description';
    $value = $rtmedia_media->post_content;

    $html = '';

    if ( rtmedia_request_action () == 'edit' )
        $html .= wp_editor ( $value, $name, array( 'media_buttons' => false ) );
    else
        $html .= '<div name="' . $name . '" id="' . $name . '">' . $value . '</div>';

    $html .= '';

    return $html;
}

/**
 * echo media description
 * @global type $rtmedia_media
 */
function rtmedia_description () {
    global $rtmedia_media;
    echo $rtmedia_media->post_content;
}

/**
 * returns total media count in the album
 * @global type $rtmedia_query
 * @return type
 */
function rtmedia_count () {
    global $rtmedia_query;

    return $rtmedia_query->media_count;
}

/**
 * returns the page offset for the media pool
 * @global type $rtmedia_query
 * @return type
 */
function rtmedia_offset () {
    global $rtmedia_query;

    return ($rtmedia_query->action_query->page - 1) * $rtmedia_query->action_query->per_page_media;
}

/**
 * returns number of media per page to be displayed
 * @global type $rtmedia_query
 * @return type
 */
function rtmedia_per_page_media () {
    global $rtmedia_query;

    return $rtmedia_query->action_query->per_page_media;
}

/**
 * returns the page number of media album in the pagination
 * @global type $rtmedia_query
 * @return type
 */
function rtmedia_page () {
    global $rtmedia_query;

    return $rtmedia_query->action_query->page;
}

/**
 * returns the current media number in the album pool
 * @global type $rtmedia_query
 * @return type
 */
function rtmedia_current_media () {
    global $rtmedia_query;

    return $rtmedia_query->current_media;
}

/**
 *
 */
function rtmedia_actions () {

    $actions = array( );

    if ( is_user_logged_in () && rtmedia_edit_allowed () ) {

        $actions[ ] = '<form action="' . get_rtmedia_permalink ( rtmedia_id () ) . 'edit/">
			<button type="submit" >' . __ ( 'Edit', 'rtmedia' ) . '</button></form>';
    }
    $actions = apply_filters ( 'rtmedia_action_buttons_before_delete', $actions );
    foreach ( $actions as $action ) {
        echo $action;
    }
    $actions = array( );
    if ( rtmedia_delete_allowed () ) {
        rtmedia_delete_form ();
    }
    $actions = apply_filters ( 'rtmedia_action_buttons_after_delete', $actions );

    foreach ( $actions as $action ) {
        echo $action;
    }
    do_action ( "after_rtmedia_action_buttons" );
}

/**
 * 	rendering comments section
 */
function rtmedia_comments () {

    $html = '<ul id="rtmedia_comment_ul" class="large-block-grid-1">';

    global $wpdb, $rtmedia_media;

    $comments = $wpdb->get_results ( "SELECT * FROM $wpdb->comments WHERE comment_post_ID = '" . $rtmedia_media->media_id . "'", ARRAY_A );

    foreach ( $comments as $comment ) {
        $html .= rmedia_single_comment ( $comment );
    }

    $html .= '</ul>';

    echo $html;
}

function rmedia_single_comment ( $comment ) {
    $html = "";
    $html .= '<li class="rtmedia-comment">';
    $html .= '<div class ="rtmedia-comment-author">' . (($comment[ 'comment_author' ]) ? $comment[ 'comment_author' ] : 'Annonymous') . '  said : </div>';
    $html .= '<div class="rtmedia-comment-content">' . $comment[ 'comment_content' ] . '</div>';
    $html .= '<div class ="rtmedia-comment-date"> on ' . $comment[ 'comment_date_gmt' ] . '</div>';
//			$html .= '<a href></a>';
    $html .= '</li>';
    return $html;
}

function rtmedia_pagination_prev_link () {

    global $rtmedia_media, $rtmedia_interaction, $rtmedia_query;

    $page_url = ((rtmedia_page () - 1) == 1) ? "" : "pg/" . (rtmedia_page () - 1);
    $site_url = (is_multisite ()) ? trailingslashit ( get_site_url ( get_current_blog_id () ) ) : trailingslashit ( get_site_url () );
    $author_name = get_query_var ( 'author_name' );
    $link = '';

    if ( $rtmedia_interaction->context->type == "profile" ) {
        if ( function_exists ( "bp_core_get_user_domain" ) )
            $link .= trailingslashit ( bp_core_get_user_domain ( $rtmedia_media->media_author ) );
        else
            $link = $site_url . 'author/' . $author_name . '/';
    } else if ( $rtmedia_interaction->context->type == 'group' ) {
        if ( function_exists ( "bp_get_current_group_slug" ) )
            $link .= $site_url . bp_get_groups_root_slug () . '/' . bp_get_current_group_slug () . '/';
    } else {
        $post = get_post ( $rtmedia_media->post_parent );

        $link .= $site_url . $post->post_name . '/';
    }

    $link .= RTMEDIA_MEDIA_SLUG . '/';

    if ( isset ( $rtmedia_query->action_query->media_type ) ) {
        if ( in_array ( $rtmedia_query->action_query->media_type, array( "photo", "music", "video", "album" ) ) )
            $link .= $rtmedia_query->action_query->media_type . '/';
    }
    return $link . $page_url;
}

function rtmedia_pagination_next_link () {

    global $rtmedia_media, $rtmedia_interaction, $rtmedia_query;

    $page_url = 'pg/' . (rtmedia_page () + 1);
    $site_url = (is_multisite ()) ? trailingslashit ( get_site_url ( get_current_blog_id () ) ) : trailingslashit ( get_site_url () );
    $author_name = get_query_var ( 'author_name' );
    $link = '';

    if ( $rtmedia_interaction->context->type == "profile" ) {
        if ( function_exists ( "bp_core_get_user_domain" ) )
            $link .= trailingslashit ( bp_core_get_user_domain ( $rtmedia_media->media_author ) );
        else
            $link .= $site_url . 'author/' . $author_name . '/';
    } else if ( $rtmedia_interaction->context->type == 'group' ) {
        if ( function_exists ( "bp_get_current_group_slug" ) )
            $link .= $site_url . bp_get_groups_root_slug () . '/' . bp_get_current_group_slug () . '/';
    } else {
        $post = get_post ( $rtmedia_media->post_parent );

        $link .= $site_url . $post->post_name . '/';
    }
    $link .= RTMEDIA_MEDIA_SLUG . '/';
    if ( isset ( $rtmedia_query->media_query[ "album_id" ] ) && intval ( $rtmedia_query->media_query[ "album_id" ] ) > 0 ) {
        $link .= $rtmedia_query->media_query[ "album_id" ] . "/";
    }
    if ( isset ( $rtmedia_query->action_query->media_type ) ) {
        if ( in_array ( $rtmedia_query->action_query->media_type, array( "photo", "music", "video", "album" ) ) )
            $link .= $rtmedia_query->action_query->media_type . '/';
    }
    return $link . $page_url;
}

function rtmedia_comments_enabled () {
    global $rtmedia;
    return $rtmedia->options[ 'general_enableComments' ] && is_user_logged_in ();
}

/**
 *
 * @return boolean
 */
function is_rtmedia_gallery () {
    global $rtmedia_query;
    if ( $rtmedia_query )
	return $rtmedia_query->is_gallery ();
    else
	return false;
}

/**
 *
 * @return boolean
 */
function is_rtmedia_album_gallery () {
    global $rtmedia_query;
    if ( $rtmedia_query )
	return $rtmedia_query->is_album_gallery ();
    else
	return false;
}

/**
 *
 * @return boolean
 */
function is_rtmedia_single () {
    global $rtmedia_query;
    if ( $rtmedia_query )
        return $rtmedia_query->is_single ();
    else
        return false;
}

/**
 *
 * @return boolean
 */
function is_rtmedia_album () {
    global $rtmedia_query;
    if ( $rtmedia_query )
        return $rtmedia_query->is_album ();
    else
        return false;
}

/**
 *
 * @return boolean
 */
function is_rtmedia_edit_allowed () {
    global $rtmedia_query;
    if ( $rtmedia_query ) {
        if ( isset ( $rtmedia_query->media_query[ 'media_author' ] ) && get_current_user_id () == $rtmedia_query->media_query[ 'media_author' ] && $rtmedia_query->action_query->action == 'edit' )
            return true;
        else
            return false;
    } else {
        return false;
    }
}

add_action ( 'rtmedia_add_edit_fields', 'rtmedia_image_editor', 999 );
add_action ( 'rtmedia_add_edit_fields', 'rtmedia_vedio_editor', 1000 );
add_action ('rtmedia_after_update_media', 'set_video_thumbnail', 12);
add_filter ('rtmedia_single_content_filter', 'change_poster', 99, 2);

function change_poster($html,$media){
    global $rtmedia_media;
    if ( $rtmedia_media->media_type == 'video' ) {
        $thumbnail_id = $rtmedia_media->cover_art;
        if ( $thumbnail_id ) {
            if(is_numeric($thumbnail_id)) {
                $thumbnail_info = wp_get_attachment_image_src($thumbnail_id, 'full');
                $html = str_replace('<video ', '<video poster="'.$thumbnail_info[0].'" ', $html);
            }
            else {
                $html = str_replace('<video ', '<video poster="'.$thumbnail_id.'" ', $html);
            }
        }
    }
    return $html;
}

function rtmedia_vedio_editor() {
    global $rtmedia_query;
    if ( $rtmedia_query->media[ 0 ]->media_type == 'video' ) {
        $media_id = $rtmedia_query->media[ 0 ]->media_id;
        $thumbnail_array = get_post_meta($media_id, "rtmedia_media_thumbnails", true);
        if(is_array($thumbnail_array)) {
    ?>
            <div class="rtmedia-change-cover-arts">
                <p> Video Thumbnail:</p>
                <ul>
            <?php
                    foreach($thumbnail_array as $key => $thumbnail_src) {
            ?>
                    <li<?php echo checked($thumbnail_src, $rtmedia_query->media[ 0 ]->cover_art, false) ? ' class="selected"' : ''; ?> style="width: 150px;display: inline-block;">
                        <label for="rtmedia-upload-select-thumbnail-<?php echo $key + 1; ?>" class="alignleft">
                        <input type="radio"<?php checked($thumbnail_src, $rtmedia_query->media[ 0 ]->cover_art); ?> id="rtmedia-upload-select-thumbnail-<?php echo $key + 1; ?>" value="<?php echo $thumbnail_src; ?>" name="rtmedia-thumbnail" />
                        <img src="<?php echo $thumbnail_src; ?>" style="max-height: 120px;max-width: 120px" />
                        </label>
                    </li>
            <?php
                    }
            ?>
                </ul>
            </div>
    <?php
        }
        else {  // check for array of thumbs stored as attachement ids
            global $rtmedia_media;
            $curr_cover_art = $rtmedia_media->cover_art;
            if($curr_cover_art != "") {
                $rtmedia_video_thumbs = get_rtmedia_meta($rtmedia_query->media[ 0 ]->media_id, "rtmedia-thumbnail-ids");
                if(is_array($rtmedia_video_thumbs)) {
            ?>
                <div class="rtmedia-change-cover-arts">
                    <p> Video Thumbnail:</p>
                    <ul>
            <?php
                    foreach($rtmedia_video_thumbs as $key=>$attachment_id) {
                        $thumbnail_src = wp_get_attachment_url($attachment_id);
             ?>
                        <li<?php echo checked($attachment_id, $curr_cover_art, false) ? ' class="selected"' : ''; ?> style="width: 150px;display: inline-block;">
                            <label for="rtmedia-upload-select-thumbnail-<?php echo $key + 1; ?>" class="alignleft">
                            <input type="radio"<?php checked($attachment_id, $curr_cover_art); ?> id="rtmedia-upload-select-thumbnail-<?php echo $key + 1; ?>" value="<?php echo $attachment_id; ?>" name="rtmedia-thumbnail" />
                            <img src="<?php echo $thumbnail_src; ?>" style="max-height: 120px;max-width: 120px" />
                            </label>
                        </li>
            <?php
                    }
            ?>
                    </ul>
                </div>
            <?php

                }
            }
        }
    }
}

function update_activity_after_thumb_set($id) {
	$model = new RTMediaModel();
	$mediaObj = new RTMediaMedia();
	$media = $model->get(array('id' => $id));
        $privacy = $media[0]->privacy;
        $activity_id = rtmedia_activity_id($id);
        $same_medias = $mediaObj->model->get ( array( 'activity_id' => $activity_id ) );
        $update_activity_media = Array( );
        foreach ( $same_medias as $a_media ) {
            $update_activity_media[ ] = $a_media->id;
        }
        $objActivity = new RTMediaActivity ( $update_activity_media, $privacy, false );
        global $wpdb, $bp;
        $activity_old_content = bp_activity_get_meta($activity_id, "bp_old_activity_content");
        $activity_text = bp_activity_get_meta($activity_id, "bp_activity_text");
        if( $activity_old_content == "") {
            // get old activity content and save in activity meta
            $activity_get = bp_activity_get_specific( array( 'activity_ids' => $activity_id ) );
            $activity = $activity_get['activities'][0];
            $activity_body = $activity->content;
            bp_activity_update_meta ($activity_id, "bp_old_activity_content", $activity_body);
	    //extract activity text from old content
            $activity_text = strip_tags($activity_body, '<span>');
	    $activity_text = explode("</span>", $activity_text);
	    $activity_text = strip_tags($activity_text[0]);
            bp_activity_update_meta ($activity_id, "bp_activity_text", $activity_text);
        }
	$activity_text = bp_activity_get_meta($activity_id, "bp_activity_text");
	$objActivity->activity_text =$activity_text;
        $wpdb->update ( $bp->activity->table_name, array( "type" => "rtmedia_update", "content" => $objActivity->create_activity_html () ), array( "id" => $activity_id ) );
}

function set_video_thumbnail($id) {
    $media_type = rtmedia_type($id);
    if ('video' == $media_type) {
        $model = new RTMediaModel();
        $model->update(array('cover_art' => $_POST['rtmedia-thumbnail']), array('id' => $id));
	update_activity_after_thumb_set($id);
        // code to update activity

    }
}

function rtmedia_image_editor () {
    global $rtmedia_query;
    if ( $rtmedia_query->media[ 0 ]->media_type == 'photo' ) {
        $media_id = $rtmedia_query->media[ 0 ]->media_id;
        $id = $rtmedia_query->media[ 0 ]->id;
        //$editor = wp_get_image_editor(get_attached_file($id));
        include_once( ABSPATH . 'wp-admin/includes/image-edit.php' );
        echo '<div class="rtmedia-image-editor-cotnainer">';
        echo '<div class="rtmedia-image-editor" id="image-editor-' . $media_id . '"></div>';
        $thumb_url = wp_get_attachment_image_src ( $media_id, 'thumbnail', true );
        $nonce = wp_create_nonce ( "image_editor-$media_id" );
        echo '<div id="imgedit-response-' . $media_id . '"></div>';
        echo '<div class="wp_attachment_image" id="media-head-' . $media_id . '">
				<p id="thumbnail-head-' . $id . '"><img class="thumbnail" src="' . set_url_scheme ( $thumb_url[ 0 ] ) . '" alt="" /></p>
	<p><input type="button" class="rtmedia-image-edit" id="imgedit-open-btn-' . $media_id . '" onclick="imageEdit.open( \'' . $media_id . '\', \'' . $nonce . '\' )" class="button" value="Modifiy Image"> <span class="spinner"></span></p></div>';
        echo '</div>';
    }

}

function update_video_poster($html,$media,$activity=false){
    if ( $media->media_type == 'video' ) {
        $thumbnail_id = $media->cover_art;
        if ( $thumbnail_id ) {
            $thumbnail_info = wp_get_attachment_image_src($thumbnail_id, 'full');
            $html = str_replace('<video ', '<video poster="'.$thumbnail_info[0].'" ', $html);
        }
    }
    return $html;
}

function get_video_without_thumbs() {
    $rtmedia_model = new RTMediaModel();
    $sql = "select media_id from {$rtmedia_model->table_name} where media_type = 'video' and cover_art is null";
    global $wpdb;
    $results = $wpdb-> get_col ( $sql );
    return $results;
}


function rtmedia_comment_form () {
    ?>
    <form method="post" id="rt_media_comment_form" action="<?php echo get_rtmedia_permalink ( rtmedia_id () ); ?>comment/">
        <div class="row">
            <div class="large-12 columns">
                <textarea style="width:100%" placeholder="<?php _e ( "Type Comment...", 'rtmedia' ); ?>" name="comment_content" id="comment_content"></textarea>
            </div>
        </div>
        <input type="submit" id="rt_media_comment_submit" value="<?php _e ( 'Comment', 'rtmedia' ); ?>">
        <?php RTMediaComment::comment_nonce_generator (); ?>
    </form>
    <?php
}

function rtmedia_get_cover_art_src($id) {
    $model = new RTMediaModel();
    $media = $model->get(array("id" => $id));
    $cover_art = $media[0]->cover_art;
    if($cover_art != "") {
        if(is_numeric($cover_art)) {
            $thumbnail_info = wp_get_attachment_image_src($thumbnail_id, 'full');
            return $thumbnail_info[0];
        }
        else
            return $cover_art;
    }
    else
        return false;

}

function rtmedia_delete_form () {

    $html = '<form method="post" action="' . get_rtmedia_permalink ( rtmedia_id () ) . 'delete/">';
    $html .= '<input type="hidden" name="id" id="id" value="' . rtmedia_id () . '">';
    $html .= '<input type="hidden" name="request_action" id="request_action" value="delete">';
    echo $html;
    RTMediaMedia::media_nonce_generator ( rtmedia_id (), true );
    echo '<input type="submit" value="' . __ ( 'Delete', 'rtmedia' ) . '"></form>';
}

/**
 *
 * @param type $attr
 */
function rtmedia_uploader ( $attr = '' ) {
    if ( function_exists ( 'bp_is_blog_page' ) && ! bp_is_blog_page () ) {
        if ( function_exists ( 'bp_is_user' ) && bp_is_user () && function_exists ( 'bp_displayed_user_id' ) && bp_displayed_user_id () == get_current_user_id () )
            echo RTMediaUploadShortcode::pre_render ( $attr );
        else if ( function_exists ( 'bp_is_group' ) && bp_is_group () ) {
            if ( can_user_upload_in_group () )
                echo RTMediaUploadShortcode::pre_render ( $attr );
        }
    }
}

function rtmedia_gallery ( $attr = '' ) {
    echo RTMediaGalleryShortcode::render ( $attr );
}

function get_rtmedia_meta ( $id = false, $key = false ) {
    $rtmediameta = new RTMediaMeta();
    return $rtmediameta->get_meta ( $id, $key );
}

function add_rtmedia_meta ( $id = false, $key = false, $value = false, $duplicate = false ) {
    $rtmediameta = new RTMediaMeta ( $id, $key, $value, $duplicate );
    return $rtmediameta->add_meta ( $id, $key, $value, $duplicate );
}

function update_rtmedia_meta ( $id = false, $key = false, $value = false, $duplicate = false ) {
    $rtmediameta = new RTMediaMeta();
    return $rtmediameta->update_meta ( $id, $key, $value, $duplicate );
}

function delete_rtmedia_meta ( $id = false, $key = false ) {
    $rtmediameta = new RTMediaMeta();
    return $rtmediameta->delete_meta ( $id, $key );
}

function rtmedia_global_albums () {
    return RTMediaAlbum::get_globals (); //get_site_option('rtmedia-global-albums');
}

function rtmedia_global_album_list () {
    global $rtmedia_query;
    $model = new RTMediaModel();
    $global_albums = rtmedia_global_albums ();
    if ( ! empty ( $global_albums ) ) {
        if ( is_array ( $global_albums ) ) {
            $albums = implode ( ',', $global_albums );
        } else {
            //return;
        }
        //return;
    }
    $option = NULL;

    $album_objects = $model->get_media ( array( 'id' => ($global_albums) ), false, false );

    if ( $album_objects ) {
        foreach ( $album_objects as $album ) {
            if ( (isset ( $rtmedia_query->media_query[ 'album_id' ] ) && ($album_objects[ 0 ]->id != $rtmedia_query->media_query[ 'album_id' ])) || ! isset ( $rtmedia_query->media_query[ 'album_id' ] ) )
                $option .= '<option value="' . $album->id . '">' . $album->media_title . '</option>';
        }
    }


    return $option;
}

function rtmedia_user_album_list ( $get_all = false ) {
    global $rtmedia_query;
    $model = new RTMediaModel();
    $global_option = rtmedia_global_album_list ();
    $global_albums = rtmedia_global_albums ();

    $global_album = get_site_option ( 'rtmedia-global-albums' );
    $album_objects = $model->get_media ( array( 'media_author' => get_current_user_id (), 'media_type' => 'album' ), false, 'context' );
    $option_group = "";
    $profile_option = "";
    if ( $album_objects ) {
        foreach ( $album_objects as $album ) {
            if ( ! in_array ( $album->id, $global_albums ) && (( isset ( $rtmedia_query->media_query[ 'album_id' ] ) && (
                    $album->id != $rtmedia_query->media_query[ 'album_id' ] || $get_all)) || ! isset ( $rtmedia_query->media_query[ 'album_id' ] )
                    )
            )
                if($album->context == 'profile')
                    $profile_option .= '<option value="' . $album->id . '">' . $album->media_title . '</option>';
                else
                    $option_group .= '<option value="' . $album->id . '">' . $album->media_title . '</option>';

        }
    }
    $option = "$global_option";
    if($profile_option != "")
	$option.= "<optgroup label='".__("Profile Albums","rtmedia")." ' value = 'profile'>$profile_option</optgroup>";
    if($option_group != "")
	$option.="<optgroup label='".__("Group Albums","rtmedia")."' value = 'group'>$option_group</optgroup>";
    if ( $option )
        return $option;
    else
        return false;
}

function rtmedia_group_album_list () {
    global $rtmedia_query;
    $model = new RTMediaModel();

    $global_option = rtmedia_global_album_list ();
    $global_albums = rtmedia_global_albums ();

    $album_objects = $model->get_media (
            array(
        'context' => $rtmedia_query->media_query[ 'context' ],
        'context_id' => $rtmedia_query->media_query[ 'context_id' ],
        'media_type' => 'album'
            ), false, false
    );
    $option_group = "";
    if ( $album_objects ) {
        foreach ( $album_objects as $album ) {
            if ( ! in_array ( $album->id, $global_albums ) && (( isset ( $rtmedia_query->media_query[ 'album_id' ] ) && ($album->id != $rtmedia_query->media_query[ 'album_id' ])) || ! isset ( $rtmedia_query->media_query[ 'album_id' ] ) ) )
		$option_group .= '<option value="' . $album->id . '">' . $album->media_title . '</option>';

        }
    }
    $option = $global_option;
    if($option_group != "")
	$option.="<optgroup label='".__("Group Albums")."' value = 'group'>$option_group</optgroup>";
    if ( $option )
        return $option;
    else
        return false;
}

add_action ( 'rtmedia_before_media_gallery', 'rtmedia_create_album' );

add_action ( 'rtmedia_before_album_gallery', 'rtmedia_create_album' );

function rtmedia_create_album () {
    if ( ! is_rtmedia_album_enable () )
        return;
    global $rtmedia_query;
    $user_id = get_current_user_id ();
    $display = false;
    if ( isset ( $rtmedia_query->query[ 'context' ] ) && in_array ( $rtmedia_query->query[ 'context' ], array( 'profile', 'group' ) ) ) {
        switch ( $rtmedia_query->query[ 'context' ] ) {
            case 'profile':
                if ( $rtmedia_query->query[ 'context_id' ] == $user_id ) {
                    $display = true;
                }
                break;
            case 'group':
                $group_id = $rtmedia_query->query[ 'context_id' ];
                if ( can_user_create_album_in_group () ) {
                    $display = true;
                }
                break;
        }
    }
    if ( $display === true ) {
        ?>
        <button type="button" class="button rtmedia-create-new-album-button"><?php _e ( "Create New Album", "rtmedia" ); ?> </button>
        <div class="rtmedia-create-new-album-container">
            <input type="text" id="rtmedia_album_name" value="" />
            <input type="hidden" id="rtmedia_album_context" value="<?php echo $rtmedia_query->query[ 'context' ]; ?>">
            <input type="hidden" id="rtmedia_album_context_id" value="<?php echo $rtmedia_query->query[ 'context_id' ]; ?>">
            <button type="button" id="rtmedia_create_new_album"><?php _e ( "Create Album", "rtmedia" ); ?>
            </button>
        </div><?php
    }
}

add_action ( 'rtmedia_before_media_gallery', 'rtmedia_album_edit' );

function rtmedia_album_edit () {

    if ( ! is_rtmedia_album () || ! is_user_logged_in () )
        return;
    if ( ! is_rtmedia_album_enable () )
        return;
    global $rtmedia_query;
    //var_dump($rtmedia_query);
    if ( isset ( $rtmedia_query->media_query ) && ! in_array ( $rtmedia_query->media_query[ 'album_id' ], get_site_option ( 'rtmedia-global-albums' ) ) ) {
        if ( isset ( $rtmedia_query->media_query[ 'media_author' ] ) && get_current_user_id () == $rtmedia_query->media_query[ 'media_author' ] ) {
            ?>
            <a class="alignleft" href="edit/"><input type="button" class="button rtmedia-edit" value="<?php _e ( 'Edit', 'rtmedia' ); ?>" /></a>
            <form method="post" class="album-delete-form alignleft" action="delete/">
                <?php wp_nonce_field ( 'rtmedia_delete_album_' . $rtmedia_query->media_query[ 'album_id' ], 'rtmedia_delete_album_nonce' ); ?>
                <input type="submit" name="album-delete" value="<?php _e ( 'Delete', 'rtmedia' ); ?>" />
            </form>
            <?php if ( $album_list = rtmedia_user_album_list () ) { ?>
                <input type="button" class="button rtmedia-merge" value="<?php _e ( 'Merge', 'rtmedia' ); ?>" />
                <div class="rtmedia-merge-container">
                    <?php _e ( 'Merge to', 'rtmedia' ); ?>
                    <form method="post" class="album-merge-form" action="merge/">
                        <?php echo '<select name="album" class="rtmedia-merge-user-album-list">' . $album_list . '</select>'; ?>
                        <?php wp_nonce_field ( 'rtmedia_merge_album_' . $rtmedia_query->media_query[ 'album_id' ], 'rtmedia_merge_album_nonce' ); ?>
                        <input type="submit" class="rtmedia-move-selected" name="merge-album" value="<?php _e ( 'Merge Album', 'rtmedia' ); ?>" />
                    </form>
                </div>
                <?php
            }
        }
    }
}

add_action ( 'rtmedia_before_item', 'rtmedia_item_select' );

function rtmedia_item_select () {
    global $rtmedia_query, $rtmedia_backbone;
    if ( $rtmedia_backbone[ 'backbone' ] ) {
        if ( $rtmedia_backbone[ 'is_album' ] && $rtmedia_backbone[ 'is_edit_allowed' ] )
            echo '<input type="checkbox" name="move[]" value="<%= id %>" />';
    } else if ( is_rtmedia_album () && isset ( $rtmedia_query->media_query ) && $rtmedia_query->action_query->action == 'edit' ) {
        if ( isset ( $rtmedia_query->media_query[ 'media_author' ] ) && get_current_user_id () == $rtmedia_query->media_query[ 'media_author' ] )
            echo '<input type="checkbox" name="selected[]" value="' . rtmedia_id () . '" />';
    }
}

add_action ( 'rtmedia_query_actions', 'rtmedia_album_merge_action' );

function rtmedia_album_merge_action ( $actions ) {
    $actions[ 'merge' ] = __ ( 'Merge', 'rtmedia' );
    return $actions;
}

function rtmedia_sub_nav () {
    global $rtMediaNav;
    $rtMediaNav = new RTMediaNav();
    $rtMediaNav->sub_nav ();
}

function is_rtmedia_album_enable () {
    global $rtmedia;
    if ( isset ( $rtmedia->options[ "general_enableAlbums" ] ) && $rtmedia->options[ "general_enableAlbums" ] != "0" ) {
        return true;
    }
    return false;
}

function rtmedia_load_template () {
    do_action ( "rtmedia_before_template_load" );
    include(RTMediaTemplate::locate_template ());
    do_action ( "rtmedia_after_template_load" );
}

function is_rtmedia_privacy_enable () {
    global $rtmedia;
    if ( isset ( $rtmedia->options[ "privacy_enabled" ] ) && $rtmedia->options[ "privacy_enabled" ] != "0" ) {
        return true;
    }
    return false;
}

function is_rtmedia_privacy_user_overide () {
    global $rtmedia;
    if ( isset ( $rtmedia->options[ "privacy_userOverride" ] ) && $rtmedia->options[ "privacy_userOverride" ] != "0" ) {
        return true;
    }
    return false;
}

function get_rtmedia_default_privacy () {

    global $rtmedia;
    if ( isset ( $rtmedia->options[ "privacy_default" ] ) ) {
        return $rtmedia->options[ "privacy_default" ];
    }
    return 0;
}

function is_rtmedia_group_media_enable () {
    global $rtmedia;
    if ( isset ( $rtmedia->options[ "buddypress_enableOnGroup" ] ) && $rtmedia->options[ "buddypress_enableOnGroup" ] != "0" ) {
        return true;
    }
    return false;
}

function can_user_upload_in_group () {
    $group = groups_get_current_group ();
    $upload_level = groups_get_groupmeta ( $group->id, "rt_upload_media_control_level" );
    $user_id = get_current_user_id ();
    $display_flag = false;
    if ( groups_is_user_member ( $user_id, $group->id ) ) {
//        if ($upload_level == "admin") {
//            if (groups_is_user_admin($user_id, $group->id)) {
//                $display_flag = true;
//            }
//        } else if ($upload_level == "moderator") {
//            if (groups_is_user_mod($user_id, $group->id)) {
//                $display_flag = true;
//            }
//        } else {
//            $display_flag = true;
//        }
        $display_flag = true;
    }
    return $display_flag;
}

/**
 *
 * @param type $group_id
 * @param type $user_id
 * @return boolean
 */
function can_user_create_album_in_group ( $group_id = false, $user_id = false ) {
    if ( $group_id == false ) {
        $group = groups_get_current_group ();
        $group_id = $group->id;
    }
    $upload_level = groups_get_groupmeta ( $group_id, "rt_media_group_control_level" );
    if ( empty ( $upload_level ) ) {
        $upload_level = groups_get_groupmeta ( $group_id, "bp_media_group_control_level" );
        if ( empty ( $upload_level ) ) {
            $upload_level = "all";
        }
    }
    $user_id = get_current_user_id ();
    $display_flag = false;
    if ( groups_is_user_member ( $user_id, $group_id ) ) {
        if ( $upload_level == "admin" ) {
            if ( groups_is_user_admin ( $user_id, $group_id ) > 0 ) {
                $display_flag = true;
            }
        } else if ( $upload_level == "moderators" ) {
            if ( groups_is_user_mod ( $user_id, $group_id ) ) {
                $display_flag = true;
            }
        } else {
            $display_flag = true;
        }
    }
    return $display_flag;
}

function is_rtmedia_upload_video_enabled () {
    global $rtmedia;
    if ( isset ( $rtmedia->options[ "allowedTypes_video_enabled" ] ) && $rtmedia->options[ "allowedTypes_video_enabled" ] != "0" ) {
        return true;
    }
    return false;
}

function is_rtmedia_upload_photo_enabled () {
    global $rtmedia;
    if ( isset ( $rtmedia->options[ "allowedTypes_photo_enabled" ] ) && $rtmedia->options[ "allowedTypes_photo_enabled" ] != "0" ) {
        return true;
    }
    return false;
}

function is_rtmedia_upload_music_enabled () {
    global $rtmedia;
    if ( isset ( $rtmedia->options[ "allowedTypes_music_enabled" ] ) && $rtmedia->options[ "allowedTypes_music_enabled" ] != "0" ) {
        return true;
    }
    return false;
}

function get_rtmedia_allowed_upload_type () {
    global $rtmedia;
    $allow_type_str = "";
    $sep = "";
    foreach ( $rtmedia->allowed_types as $type ) {
        if ( call_user_func ( "is_rtmedia_upload_" . $type[ "name" ] . "_enabled" ) ) {
            foreach ( $type[ "extn" ] as $extn ) {
                $allow_type_str .= $sep . $extn;
                $sep = ",";
            }
        }
    }
    return $allow_type_str;
}

