<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Left Sidebar Template
*/
?>
<!-- Getting Header-->
<?php get_header(); ?>
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
    <div class="cntnt-faq-lft-prt">
       <?php if ( ! dynamic_sidebar( 'Sidebar Widget Area' ) ) :  endif; ?>  
    </div>
    <div class="cntnt-faq-rgt-prt">
	    <!-- Page Content Start form here  -->
		   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		    <!--<h1><?php //the_title();?></h1>-->
		     <?php the_content(); ?>
		   <?php endwhile; // end of the loop. ?>
          </div>
        </div>
  </div>
  
    </div>
	<?php /*$id = get_the_ID();
		if($id==20){
		$id=22; 
		$post = get_page($id); 
		$content = apply_filters('the_content', $post->post_content); 
		echo $content;  
		echo get_the_post_thumbnail(22);
		 }*/ ?>
<!--Getting Footer-->
<?php get_footer(); ?>
