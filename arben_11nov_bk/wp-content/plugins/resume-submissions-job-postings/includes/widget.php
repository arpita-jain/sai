<?php
add_action( 'widgets_init', array( 'resume_job_postings', 'register' ) );
register_activation_hook( __FILE__, array( 'resume_job_postings', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'resume_job_postings', 'deactivate' ) );

class resume_job_postings {
	function activate(){
		$data = array( 'title' => '' ,'display' => 5 );
		if ( !get_option( 'resume_job_postings_widget' ) ){
			add_option( 'resume_job_postings_widget' , $data );
		} else {
			update_option( 'resume_job_postings_widget' , $data );
		}
	}
	function deactivate(){
		delete_option( 'resume_job_postings_widget' );
	}
	function control(){
		$data          = get_option( 'resume_job_postings_widget' );
		$widgetTitle   = $data['title'];
		$widgetDisplay = $data['display'];
		?>
        <label for="job_display_title"><?php _e( 'Title' ); ?>: <input type="text" name="job_display_title" value="<?php echo $widgetTitle; ?>" size="33" /></label><br />
        <label for="job_display_amount"><?php _e( 'Posts to Display' ); ?>: <input type="text" name="job_display_amount" value="<?php echo $widgetDisplay; ?>" size="5" /></label>	
    	<?php
		if ( isset( $_POST['job_display_title'] ) ){
			$data['title']   = esc_html( $_POST['job_display_title'] );
			$data['display'] = esc_html( $_POST['job_display_amount'] );
			update_option( 'resume_job_postings_widget', $data );
		}
    }
	function widget( $args ){
		global $wpdb, $post;
		
		$data          = get_option( 'resume_job_postings_widget' );
		$widgetTitle   = $data['title'];
		$widgetDisplay = $data['display'];
		
		if ( !$widgetDisplay ){
			$widgetDisplay = 5;
		}
		
		echo $args['before_widget'];
		echo $args['before_title'] . $widgetTitle . $args['after_title'];
		
		$getJobsArg = array( 'numberposts' => $widgetDisplay,
							 'post_type'   => 'rsjp_job_postings',
							 'orderby'     => 'post_date',
							 'order'       => 'DESC',
							 'meta_query'  => array(
												  array( 'key'     => 'rsjp_archive_posting',
													     'value'   => 1,
													     'compare' => 'NOT LIKE'
												  ) ) ); 
		$getJobs = get_posts( $getJobsArg );
		
		if ( $getJobs ){
			?>
        	<ul>
				<?php
				foreach( $getJobs as $job ) :	setup_postdata( $job );
					?>
					<li><a href="<?php echo get_permalink( $job->ID ); ?>" title="<?php echo $job->post_title; ?>"><?php echo $job->post_title; ?></a><br />
			            &nbsp;&nbsp; - <i style="font-size:10px;"><?php _e( 'Posted' ); ?>: <?php echo date_i18n( get_option( 'date_format' ), strtotime( $job->post_date ) ); ?></i></li>
				   <?php 
				endforeach;
				wp_reset_postdata();				
            	?>
            </ul>
            <center><a href="<?php echo get_option( 'resume_jobs_page' ); ?>"><?php _e( 'View All Current Jobs' ); ?></a></center>
            <?php
		} else {
			?>
            <center><i><?php _e( 'There are no jobs available at this time.' ); ?></i></center>
            <?php
		}
		echo $args['after_widget'];
	}
	function register(){
		register_sidebar_widget( 'Current Job Postings', array( 'resume_job_postings', 'widget' ) );
		register_widget_control( 'Current Job Postings', array( 'resume_job_postings', 'control' ) );
	}
}