<?php
/*
Theme Name: PCCTI
Version: 0.9b
Author: Cis Team 
The Template for displaying all single posts.
*/
?>
<?php get_header(); ?>
  <?php /*<div class="clear"></div>
<div class="slider-room-rental">
  <div class="slider-new">
    <div id="container">
      <!--<div class="clear"></div>-->
      <div id="banner-slide" style="position: relative; max-width: 1011px; height: 397px;">
        <div class="bjqs-wrapper" style="width: 1011px; height: 397px; overflow: hidden; position: relative;">
<!--Benner Start-->
<?php   if (function_exists('get_thethe_image_slider')) {
                print get_thethe_image_slider('slider');
             }
        ?>
        </div>
      </div>
        
    </div>
    </div>
    <div class="shadow_slider"><img width="1024" height="33" src="<?php bloginfo('template_url')?>/images/shadow-slider.png"></div>
    <div class="clr"></div>
    
</div>
<div class="clr"></div>*/?>
<div class="container content_bg-new">
   <div class="row">
     <div class="twelvecol">
        <div class="wlcm-guest-btn-area">
	 <div class="wlcm-guest-btn-bg">
              <h3>Welcome Guest!</h3>
          </div>
        <div class="wlcm-guest-btn"><a href="#">Logout</a></div>
       </div>
          <div class="build_smal_ban_bg"> <img src="<?php bloginfo('template_url')?>/images/small-banner.png" /> </div>
     </div>
  </div>
      <div class="row">
    <div class="twelvecol">
          <div class="term-condition-area">
        <div class="term-condition-bg">
	<div class="term-condition-rw">
	<?php if( get_the_ID()=='423')
	 {
	      $job_id=$_REQUEST['job'];
   	      global $wpdb;
	      $table_name = $wpdb->prefix . "jobpost";
	      $retrieve_data = $wpdb->get_results("SELECT * FROM $table_name where id='$job_id'");
	      foreach ($retrieve_data as $retrieved_data)
	      {?>
	     
	       <h2><?php echo $retrieved_data->job_title;?></h2><br/>
	       <div class="job-img-part"><img src="<?php echo 'http://constructionmates.co.uk/wp-content/plugins/job-post/job_image/'.$retrieved_data->file_name;?>" alt=""></div>
	       <p><?php //echo $retrieved_data->job_type;?>
	       <?php //echo $retrieved_data->job_estimate;?>
	       <?php echo $retrieved_data->job_detail;?>
	       <?php //echo $retrieved_data->job_location;?>
	       <?php //echo $retrieved_data->post_code;?>
	       <?php //echo $retrieved_data->job_name;?>
	       <?php //echo $retrieved_data->job_quotes;?>
	       <?php //echo $retrieved_data->job_size;?>
	       <?php //echo $retrieved_data->job_work_start;?>
	       <?php //echo $retrieved_data->contact;?>
	       <?php //echo $retrieved_data->criteria;?>
	       <?php //echo $retrieved_data->contact_reference;?>
	       <?php //echo $retrieved_data->post;?></p>
	    
<?php 		}
   }
else
{
   ?>
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <h2><?php the_title(); ?></h2><br/>
		  <?php if(get_the_post_thumbnail( get_the_ID())!=""){ ?>
		     <div class="job-img-part"><?php echo get_the_post_thumbnail( get_the_ID());?></div> <?php } ?>
		<?php echo '<p>'.$post->post_content.'</p>';//print_r($content);?>
    <?php endwhile;}?>
    
       </div>    	
      </div>    	   
<div class="sidebar">
      <div class="sidebar_top1">
            	<?php /* <h1>Testimonial Info...</h1> */ ?>
		
            </div>
     <?php if ( is_active_sidebar( 'testimonial_innerpage-widget-area' ) ) : ?><?php  dynamic_sidebar( 'Testimonial_innerpage Widget Area' ); ?><?php endif; ?>
      <?php //get_sidebar(); ?>
     
    	
    <div class="clr"></div>
   </div>
    </div>
	  </div>
  </div>
 </div>
 <?php get_footer(); ?>
    	

