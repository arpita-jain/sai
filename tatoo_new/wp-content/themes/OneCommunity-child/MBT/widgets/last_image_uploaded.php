<?php

class last_image_uploaded extends WP_Widget {

	function last_image_uploaded() {
		//Widget settings
		$widget_ops = array( 'description' => __('Last Image Upload' ) );

		//Widget control settings
		$control_ops = array( 
			//'width' => 400, 
			//'height' => 550, 
			'id_base' => 'last_image_uploaded' 
		);

		//Create the widget
		$this->WP_Widget( 'last_image_uploaded', 'Last Image Upload', $widget_ops, $control_ops );
	}
	
	function update( $new_instance, $old_instance ){
		$instance = array();
		$instance['title']				= $new_instance['title'];
		$instance['num_images']			= $new_instance['num_images'];
		
		return $instance;
	}
	
	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ]; } else { $title = 'Last Image Upload'; }
		if ( isset( $instance[ 'num_images' ] ) ) { $num_images = $instance[ 'num_images' ]; } else { $num_images = 9; }
		

		?>  
		<p><label>Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<p><label>No of Images: <input class="widefat" id="<?php echo $this->get_field_id( 'num_images' ); ?>" name="<?php echo $this->get_field_name( 'num_images' ); ?>" type="text" value="<?php echo esc_attr( $num_images ); ?>" /></label></p>
		
		<?php
    }
	
    function widget($args , $instance){
    	global $wpdb, $post;
		extract( $args );

		$title				= $instance['title'];
		$num_images			= $instance['num_images'];

		echo $before_widget;
		if ( !empty($title) ) { echo $before_title . $title . $after_title; }
		
		echo do_shortcode( '[mbt_bc_img_wgt images="' . $num_images . '"]' );
		
		echo $after_widget;
    }
}