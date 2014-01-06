<?php 
/* 
Theme Name: PCCTI
Version: 0.9b
Author: Cis Team
Template for default page
*/
?>

<?php get_header(); ?>
</div>
<div class="container content_bg-new">
   <div class="row">
     <div class="twelvecol">
        <div class="wlcm-guest-btn-area"><?php if($current_user->data->user_login){ ?>
	 <div class="wlcm-guest-btn-bg">
              <h3>Welcome <?php echo $current_user->data->user_login;?>!</h3>
          </div>
        <div class="wlcm-guest-btn"><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></div>
       </div><?php } ?>
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
		 if($id==140 || $id==196){ 
		Show_News_content_sidebar($id);
		   }   /* ...........end news content ............*/?>
	       </div>    	
      </div>    	   
    <div class="sidebar">
      <div class="sidebar_top1">
            	<?php /*<h1>Testimonial Info...</h1>*/?>
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
