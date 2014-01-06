<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Left Sidebar Template
*/
?>
<!-- Getting Header-->
<?php get_header(); global $current_user;?>
<div class="container content_bg-new">
      <div class="row">
    <div class="twelvecol">
          <div class="wlcm-guest-btn-area">
	<?php if($current_user->data->user_login){ ?>
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
    <div class="cntnt-faq-lft-prt">
       <?php if ( ! dynamic_sidebar( 'Sidebar Widget Area' ) ) :  endif; ?>  
    </div>
    <div class="cntnt-faq-rgt-prt">
		    <div class="job-list-area">
             <!-- Page Content Start form here  -->
		   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		    
		     <?php the_content(); ?>
		   <?php endwhile; // end of the loop. ?>
		<?php
		
		  /* ...........for news content ............*/
		  if( get_the_ID()==20){ 
		Show_FaqNews_content(); ?>
		<h3>Advice</h3>
		 <?php  advice_section_dispaly();
		   }   /* ...........end news content ............*/
	  ?>
            </div>
		   
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
