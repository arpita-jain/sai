<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Blog Template
*/
?>
<?php get_header(); 
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
	     <div class="wlcm-guest-btn-my-account"><a href="<?php echo site_url(); ?>?page_id=442">My Account</a></div>
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
	     <!--  <div class="wlcm-guest-btn-area">
	     <?php 	//if($current_user->data->user_login){
	      ?>
	     <div class="wlcm-guest-btn-my-account"><a href="<?php //echo site_url(); ?>?page_id=442">My Account</a></div>
	     <?php //} ?>
	     <div class="wlcm-guest-btn-bg">
		   <h3>Welcome <?php //if($current_user->data->user_login){ echo $current_user->data->user_login; } else { echo "Guest";}?>!</h3>
		 </div>
	     <div class="wlcm-guest-btn"><?php //if($current_user->data->user_login){ ?><a href="<?php //echo wp_logout_url( home_url() ); ?>">Logout</a><?php //} else { ?><a href="<?php //echo site_url(); ?>?page_id=18">Login</a><?php//}?></div>
	   </div>-->
	       <div class="build_smal_ban_bg"> <img src="<?php bloginfo('template_url')?>/images/small-banner.png" /> </div>
	     </div>
  </div>
      <div class="row">
    <div class="twelvecol">
          <div class="term-condition-area"><h3><?php the_title();?></h3>
        <div class="term-condition-bg">
	<div class="term-condition-rw">
		    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		   <?php get_template_part( 'content', 'page' ); ?>
	          <?php the_content(); ?>
		<?php endwhile; // end of the loop. ?>
		<?php
		  /* ...........for news content ............*/
		 if($id==1308){ 
		Show_News_content_sidebar($id);
		   }   /* ...........end news content ............*/?>
	       </div>    	
      </div>    	   
    <div class="sidebar">
      <div class="sidebar_top1">
      </div>
     <?php if ( is_active_sidebar( 'Sidebar Widget Area' ) ) : ?><?php  //dynamic_sidebar( 'Sidebar Widget Area' ); ?><?php endif; ?>
      <?php //get_sidebar(); ?>
  <div class="clr"></div>
   </div>
    </div>
	  </div>
  </div>
 </div> </div>
<?php get_footer(); ?>