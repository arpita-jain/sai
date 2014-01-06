<?php

require_once ( 'last_image_uploaded.php' );

add_action( 'widgets_init', 'mbt_widgets' );


function mbt_widgets() {
	register_widget( 'last_image_uploaded' );
}
