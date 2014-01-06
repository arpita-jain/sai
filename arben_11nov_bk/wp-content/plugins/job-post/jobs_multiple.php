<?php
define('ABSPATH', dirname(__FILE__) . '/');
//include('pagination.class.php');
// job multiple images shortcode
function jobs_multiple() {

	    global $current_user;
	    if($current_user->data->user_login){
	    $user=$current_user->data->user_login;
	    $user_id=$current_user->data->ID;
	    }
?>
<div class="recent-work-area">
              <h3>Jobs Images</h3>
	       <?php
			global $wpdb;
			$retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where user_id='$user_id'");
			foreach ($retrieve_data as $retrieved_data){
			$job_image=$retrieved_data->job_images;
			$job=explode('---',$job_image);
	     ?>
	     <div class="recent-work-plc">
            <div class="recent-img-text"><img src="<?php //echo site_url().'/wp-content/plugins/job-post/job_image/'.$job[0];?>" alt=""></div>
            <div class="recent-work"> <img src="<?php echo site_url().'/wp-content/plugins/job-post/job_image/'.$job[0];?>" alt=""> <img src="<?php echo site_url().'/wp-content/plugins/job-post/job_image/'.$job[1];?>" alt=""> <img src="<?php echo site_url().'/wp-content/plugins/job-post/job_image/'.$job[2];?>" alt=""></div>
          </div>
	  <div class="recent-work-plc">
            <div class="recent-img-text"><!--<img src="images/rcnt-aftr-txt-img.png" alt="">--></div>
            <div class="recent-work rcnt-wrk-last"> <img src="<?php echo site_url().'/wp-content/plugins/job-post/job_image/'.$job[3];?>" alt=""><img src="<?php echo site_url().'/wp-content/plugins/job-post/job_image/'.$job[4];?>" alt=""><img src="<?php echo site_url().'/wp-content/plugins/job-post/job_image/'.$job[5];?>" alt="" class="rcnt-last"> </div>
          </div>
<?php }
?>
</div>
<?php		
}
?>