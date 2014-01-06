<?php

/**
 * Description of RTMediaUploadEndpoint
 *
 * @author Joshua Abenazer <joshua.abenazer@rtcamp.com>
 */
class RTMediaUploadEndpoint {

    public $upload;

    /**
     *
     */
    public function __construct () {
        add_action ( 'rtmedia_upload_redirect', array( $this, 'template_redirect' ) );
    }

    /**
     *
     */
    function template_redirect () {
        ob_start ();
        if ( ! count ( $_POST ) ) {
            include get_404_template ();
        } else {
            $nonce = $_REQUEST[ 'rtmedia_upload_nonce' ];
            $mode = $_REQUEST[ 'mode' ];
            $rtupload = false;
            $activity_id = -1;
            if ( wp_verify_nonce ( $nonce, 'rtmedia_upload_nonce' ) ) {
                $model = new RTMediaUploadModel();
                $this->upload = $model->set_post_object ();
                if ( isset ( $_POST[ 'activity_id' ] ) && $_POST[ 'activity_id' ] != -1 ) {
                    $this->upload[ 'activity_id' ] = $_POST[ 'activity_id' ];
                    $activity_id = $_POST[ 'activity_id' ];
                }
                $rtupload = new RTMediaUpload ( $this->upload );
                $mediaObj = new RTMediaMedia();
                $media = $mediaObj->model->get ( array( 'id' => $rtupload->media_ids[ 0 ] ) );
                $rtMediaNav = new RTMediaNav();
                if ( $media[ 0 ]->context == "group" ) {
                    $rtMediaNav->refresh_counts ( $media[ 0 ]->context_id, array( "context" => $media[ 0 ]->context, 'context_id' => $media[ 0 ]->context_id ) );
                } else {
                    $rtMediaNav->refresh_counts ( $media[ 0 ]->media_author, array( "context" => "profile", 'media_author' => $media[ 0 ]->media_author ) );
                }
                if ( $activity_id == -1 && ( ! (isset ( $_POST[ "rtmedia_update" ] ) && $_POST[ "rtmedia_update" ] == "true")) ) {
                    $activity_id = $mediaObj->insert_activity ( $media[ 0 ]->media_id, $media[ 0 ] );
                } else {
                    $mediaObj->model->update ( array( 'activity_id' => $activity_id ), array( 'id' => $rtupload->media_ids[ 0 ] ) );
                    //
                    $same_medias = $mediaObj->model->get ( array( 'activity_id' => $activity_id ) );

                    $update_activity_media = Array( );
                    foreach ( $same_medias as $a_media ) {
                        $update_activity_media[ ] = $a_media->id;
                    }
                    $privacy = 0;
                    if ( isset ( $_POST[ "privacy" ] ) ) {
                        $privacy = $_POST[ "privacy" ];
                    }
                    $objActivity = new RTMediaActivity ( $update_activity_media, $privacy, false );
                    global $wpdb, $bp;
                    $wpdb->update ( $bp->activity->table_name, array( "type" => "rtmedia_update", "content" => $objActivity->create_activity_html () ), array( "id" => $activity_id ) );
                }
            }
            
                if ( isset ( $_POST[ "redirect" ] ) && is_numeric ( $_POST[ "redirect" ] ) ) {
                        if ( intval ( $_POST[ "redirect" ] ) > 1 ) {
                            //bulkurl
                            if ( $media[ 0 ]->context == "group" ) {
                                $redirect_url =  trailingslashit ( get_rtmedia_group_link ( $media[ 0 ]->context_id ) ) . RTMEDIA_MEDIA_SLUG;
                            } else {
                                $redirect_url =  trailingslashit ( get_rtmedia_user_link ( $media[ 0 ]->media_author ) ) . RTMEDIA_MEDIA_SLUG;
                            }
                        } else {
                            $redirect_url = get_rtmedia_permalink ( $media[ 0 ]->id );
                        }
                }
                    
                          // Ha ha ha
                    ob_end_clean ();
                    if ( isset ( $_POST[ "rtmedia_update" ] ) && $_POST[ "rtmedia_update" ] == "true" ) {
                        if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT'])) { // if IE(<=9) set content type = text/plain
                           header ( 'Content-type: text/plain' );
                        } else {
                           header ( 'Content-type: application/json' );
                        }
                        echo json_encode ( $rtupload->media_ids );
                    } else {
                        // Media Upload Case - on album/post/profile/group
                        $data = array( 'activity_id' => $activity_id, 'redirect_url' => $redirect_url  );
                        if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT'])) { // if IE(<=9) set content type = text/plain
                           header ( 'Content-type: text/plain' );
                        } else {
                           header ( 'Content-type: application/json' );
                        }
                        echo json_encode ( $data );
                    }
               
           
            die ();
        }
    }

}

?>
