<?php
/*
  Plugin Name: Job-resume
 *
 */
 /**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			__('Studio and Artist', 'text_domain'), // Name
			array( 'description' => __( 'Job resume', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
	        echo $args['before_widget'];
		$title = apply_filters( 'widget_title', $instance['title'] );
                //===========================================================
                $user_type = mbt_get_user_type();
                           global $wpdb;
				//if ( $user_type == 'studio' || $user_type == 'artist'  ) :
                $sql = "select * from wpjb_resume ORDER BY updated_at DESC LIMIT 5" ;
                 $results = $wpdb->get_results( $sql);
               
		echo $args['before_title'] ."Recent Seekers Job". $args['after_title'];
                $home_url = home_url();
                for($i=0;$i<count($results);$i++)
                {
			$id = $results[$i]->id;
			
                    echo "<a href='".$home_url."/resumes/view/".$id."'>".$results[$i]->firstname."</a>";  //resumes/view/id
                    echo " : ".$results[$i]->title."</br>";
		    echo " Location : ".$results[$i]->address."</br>";
		    echo "</br>";  
                }
                                ?>
				<div style="text-align: right;">
				     <a href="<?php echo home_url('/resumes/'); ?>"><b>view all >> </b></a>
				 </div> 
		   
				<?php //endif;
                
                //===========================================================
	      echo $args['after_widget'];	
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */


	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Foo_Widget


// register Foo_Widget widget
function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );


?>