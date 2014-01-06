<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Join Template
*/
?>
<!-- Getting Header-->
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
         <!-- <div class="wlcm-guest-btn-area">
        <div class="wlcm-guest-btn-bg">
              <h3>Welcome <?php //echo $current_user->data->user_login;?>!</h3>
            </div>
        <div class="wlcm-guest-btn"><a href="#">Logout</a></div>
      </div>-->
          <div class="build_smal_ban_bg"> <img src="<?php bloginfo('template_url')?>/images/small-banner.png" /> </div>
        </div>
  </div>

      <div class="row">
    <div class="twelvecol">
             <!-- Page Content Start form here  -->
		   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		     
		     <?php the_content(); ?>
		   
		   <?php endwhile; // end of the loop.
		 
		   ?>
	<div class="content-right-part">
       <div class="faq-cntnt-lft-area">
       <?php if(get_the_ID()==11 || get_the_ID()==13 || get_the_ID()==15 ) {?>
        <div class="traders-right-area" style="margin-top:-100px;">
              <div class="traders-right-part">
            <div class="traders-plc">
                <?php  Show_sidebar_right_joinnow();   ?>
            </div>
             </div>
               </div>
	       <?php } else {?>
	       <div class="traders-right-area">
              <div class="traders-right-part">
            <div class="traders-plc">
                <?php  Show_sidebar_right_joinnow();   ?>
            </div>
             </div>
               </div>
	       <?php } ?>
	       <div class="content-advertise-area" ><?php if(function_exists( 'wp_bannerize' ))
	       wp_bannerize( 'group=sidebar_group&random=1&limit=1' ); ?></div>
	       <?php if(( get_the_ID()==710)||(get_the_ID()==702)){?>
	       <div class="content-advertise-area" ><?php if(function_exists( 'wp_bannerize' ))
	       wp_bannerize( 'group=flash_banner_profile_upper&random=1&limit=1' ); ?></div>
	       <div class="content-advertise-area flag2" ><?php if(function_exists( 'wp_bannerize' ))
	       wp_bannerize( 'group=flash_banner_profile_middle&random=2&limit=1' ); ?></div>
	       <div class="content-advertise-area" ><?php if(function_exists( 'wp_bannerize' ))
	       wp_bannerize( 'group=flash_banner_profile_lower&random=3&limit=1' ); ?></div>
       <?php } ?>
	 <?php if(get_the_ID()==11 || get_the_ID()==13 || get_the_ID()==15 ) {?>
	  <?php // echo do_shortcode('[xyz_em_subscription_html_code]');
		  
		  $current_user = wp_get_current_user();
		  $uid = $current_user->ID;
		  $userdata = get_user_meta($uid);
		 // print_r($userdata['first_name'][0]);
		  if($uid)
		  {
		  ?>
	 <div class="newsletter-area-part">
        <h3>Newsletter</h3>
	
            <div class="newsletter-area">
		 
		  <form action="<?php echo site_url()."/wp-content/plugins/newsletter-manager/subscription.php";?>" method="post" name="news-letter">
            	<div class="nwltr-prt-bg">
                	
                	<div class="nwltr_input_bg"> <span>
               		 <input type="text" name="xyz_em_email" placeholder="Enter email address">
			 <input type="hidden" name="xyz_em_name" id="xyz_em_name_id" value="<?php echo $userdata['first_name'][0]; ?>" />
                </span> </div>
                
                        <div class="send_button"> <span>
                  <input type="submit" name="txtEmail" value="Send">
                  </span> </div>
                
                </div>
		</form>
            </div>
        </div>
	<?php  } } ?>
       </div> 
      </div>
     
   </div>
  </div>
 </div>
</div>
</div>
<!--Getting Footer-->
<?php get_footer(); ?>
