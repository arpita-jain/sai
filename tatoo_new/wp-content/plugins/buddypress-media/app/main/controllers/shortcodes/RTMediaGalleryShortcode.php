<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RTMediaGalleryShortcode
 *
 * rtMedia Gallery Shortcode to embedd a gallery of media anywhere
 *
 * @author Udit Desai <udit.desai@rtcamp.com>
 */
class RTMediaGalleryShortcode {

    static $add_script;

    /**
     *
     */
    public function __construct () {

        add_shortcode ( 'rtmedia_gallery', array( 'RTMediaGalleryShortcode', 'render' ) );
        //add_action('init', array($this, 'register_scripts'));
        //add_action('wp_footer', array($this, 'print_script'));
    }

    static function register_scripts () {
        wp_enqueue_script ( 'plupload-all' );
        wp_enqueue_script ( 'rtmedia-backbone', RTMEDIA_URL . 'app/assets/js/rtMedia.backbone.js', array( 'plupload', 'backbone' ), false, true );
        $template_url = RTMediaTemplate::locate_template ( "media-gallery-item", "media/", true );
        wp_localize_script ( 'rtmedia-backbone', 'template_url', $template_url );
        $url = trailingslashit ( $_SERVER[ "REQUEST_URI" ] );

        if ( strpos ( $url, "/media" ) !== false ) {
            $url_array = explode ( "/media", $url );
            $url = trailingslashit ( $url_array[ 0 ] ) . "upload/";
        } else {
            $url = trailingslashit ( $url ) . "upload/";
        }

        $params = array(
            'url' => $url,
            'runtimes' => 'html5,silverlight,flash,html4',
            'browse_button' => 'rtMedia-upload-button',
            'container' => 'rtmedia-upload-container',
            'drop_element' => 'drag-drop-area',
            'filters' => apply_filters ( 'rtmedia_plupload_files_filter', array( array( 'title' => "Media Files", 'extensions' => get_rtmedia_allowed_upload_type () ) ) ),
            'max_file_size' => min ( array( ini_get ( 'upload_max_filesize' ), ini_get ( 'post_max_size' ) ) ),
            'multipart' => true,
            'urlstream_upload' => true,
            'flash_swf_url' => includes_url ( 'js/plupload/plupload.flash.swf' ),
            'silverlight_xap_url' => includes_url ( 'js/plupload/plupload.silverlight.xap' ),
            'file_data_name' => 'rtmedia_file', // key passed to $_FILE.
            'multi_selection' => true,
            'multipart_params' => apply_filters ( 'rtmedia-multi-params', array( 'redirect' => 'no', 'action' => 'wp_handle_upload', '_wp_http_referer' => $_SERVER[ 'REQUEST_URI' ], 'mode' => 'file_upload', 'rtmedia_upload_nonce' => RTMediaUploadView::upload_nonce_generator ( false, true ) ) )
        );
        if ( wp_is_mobile () )
            $params[ 'multi_selection' ] = false;

        wp_localize_script ( 'rtmedia-backbone', 'rtMedia_plupload_config', $params );
        wp_localize_script ( 'rtmedia-backbone', 'rMedia_loading_file', admin_url ( "/images/loading.gif" ) );
    }

    /**
     * Helper function to check whether the shortcode should be rendered or not
     *
     * @return type
     */
    static function display_allowed () {
        $flag = true;

        //$flag = !(is_home() || is_post_type_archive() || is_author());
        $flag = apply_filters ( 'before_rtmedia_gallery_display', $flag );
        return $flag;
    }

    /**
     * Render a shortcode according to the attributes passed with it
     *
     * @param boolean $attr
     */
    static function render ( $attr ) {
        if ( self::display_allowed () ) {
            self::$add_script = true;

            ob_start ();

            if ( ( ! isset ( $attr )) || empty ( $attr ) )
                $attr = true;

            $attr = array( 'name' => 'gallery', 'attr' => $attr );
            global $post;
            if ( isset ( $attr ) && isset ( $attr[ "attr" ] ) ) {
                if ( ! is_array ( $attr[ "attr" ] ) ) {
                    $attr[ "attr" ] = Array( );
                }
                if ( ! isset ( $attr[ "attr" ][ "context_id" ] ) && isset ( $post->ID ) ) {
                    $attr[ "attr" ][ "context_id" ] = $post->ID;
                }
                if ( ! isset ( $attr[ "attr" ][ "context" ] ) && isset ( $post->post_type ) ) {
                    $attr[ "attr" ][ "context" ] = $post->post_type;
                }
            }

            $template = new RTMediaTemplate();
            $gallery_template = false;
            $template->set_template ( $gallery_template, $attr );

            return ob_get_clean ();
        }
    }

    static function print_script () {
        if ( ! self::$add_script )
            return;
        if ( ! wp_script_is ( 'rtmedia-backbone' ) ) {
            wp_print_scripts ( 'rtmedia-backbone' );
        }
    }

}

?>
