<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Right Sidebar Template
*/
?>
<!-- Getting Header-->
<?php get_header();
global $current_user;
?>
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
          <div class="content-left-part">
        <div class="job-list-area">
             <!-- Page Content Start form here  -->
		   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		    
		     <?php the_content(); ?>
		   <?php endwhile; // end of the loop. ?>
		<?php
		
		  /* ...........for news content ............*/
		  if( get_the_ID()==22){ 
		Show_News_content(); ?>
		<h3>Tips and Advice</h3>
		 <?php  advice_section_dispaly();
		    /* ...........end news content ............*/
	  ?>
            </div>
	 </div>
      
    <div class="content-right-part">
       <div class="faq-cntnt-lft-area"> 
        <div class="traders-right-area">
              <div class="traders-right-part">
            <div class="traders-plc">
                  <div class="traders-head" style="color:#000;">Click Links</div>
                <?php Show_sidebar_right();
		?>
            </div>
             </div>
               </div>
        <div class="content-advertise-area"><img src="<?php bloginfo('template_url')?>/images/advertise-img.png" alt=""></div>
       </div> 
      </div>
      <?php }
      
       else{
	/* Show_FaqNews_content(); ?>
		<h3> Advice</h3>
		 <?php  advice_section_dispaly();
		    /* ...........end news content ............*/
	  ?>
            </div>
	 </div>
       <div class="content-right-part">
       <div class="faq-cntnt-lft-area"> 
        <div class="traders-right-area">
              <div class="traders-right-part">
            <div class="traders-plc">	  
			<div class="traders-head" style="color:#000;">Benefits</div>
                <?php  Show_sidebar_right_joinnow();   ?>
            </div>
             </div>
               </div>
        <div class="content-advertise-area"><img src="<?php bloginfo('template_url')?>/images/advertise-img.png" alt=""></div>
       </div> 
      </div>
      <?php } ?>
   </div>
  </div>
 </div>

<!--Getting Footer-->
<?php get_footer(); ?>
