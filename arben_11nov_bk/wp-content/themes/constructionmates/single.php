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
<div class="clr"></div>*/
global $current_user;
 if(($current_user->usertype==1)or($current_user->usertype==4)){
		$redirect_to=site_url().'?page_id=487';
           
	  }else{
	       $redirect_to=site_url().'?page_id=442';
	  }
?>
<div class="wlcm-guest-btn-area">
      <?php if($current_user->data->user_login){
	      ?>
	     <div class="wlcm-guest-btn-my-account"><a href="<?php echo $redirect_to;?>">My Account</a></div>
	     <?php } else { ?> <div class="wlcm-guest-btn-my-account"></div><?php }?>
	     <div class="wlcm-guest-btn-bg">
		   <h3>Welcome <?php if($current_user->data->user_login){ echo $current_user->data->user_login; } else { echo "Guest";}?>!</h3>
		 </div>
	     <div class="wlcm-guest-btn"><?php if($current_user->data->user_login){ ?><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a><?php } else { ?><a href="<?php echo site_url(); ?>?page_id=18">Login</a><?php }?></div>
	   </div>
      </div>
</div>
<div class="container content_bg-new">
   <div class="row">
  <div class="twelvecol">
 <!--   <div class="wlcm-guest-btn-area">
	     <?php //if($current_user->data->user_login){
	      ?>
	     <div class="wlcm-guest-btn-my-account"><a href="<?php //echo site_url(); ?>?page_id=442">My Account</a></div>
	     <?php //} ?>
	     <div class="wlcm-guest-btn-bg">
		   <h3>Welcome <?php //if($current_user->data->user_login){ echo $current_user->data->user_login; } else { echo "Guest";}?>!</h3>
		 </div>
	     <div class="wlcm-guest-btn"><?php //if($current_user->data->user_login){ ?><a href="<?php //echo wp_logout_url( home_url() ); ?>">Logout</a><?php //} else { ?><a href="<?php //echo site_url(); ?>?page_id=18">Login</a><?php //}?></div>
	   </div>-->
	       <div class="build_smal_ban_bg"> <img src="<?php bloginfo('template_url')?>/images/small-banner.png" /> </div>
      </div>
  </div>
      <div class="row">
    <div class="twelvecol">
          <div class="term-condition-area">
        <div class="term-condition-bg">
	<div class="term-condition-txt">
	<div class="term-condition-rw">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <h3><?php the_title(); ?></h3><br/>
		  <?php if(get_the_post_thumbnail( get_the_ID())!=""){ ?>
		     <div class="job-img-part"><?php echo get_the_post_thumbnail( get_the_ID());?></div> <?php } ?>
		<?php echo '<p>'.$post->post_content.'</p>';//print_r($content);?>
                 <?php comments_template(); ?>
    <?php endwhile;?>
    	 </div>    
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