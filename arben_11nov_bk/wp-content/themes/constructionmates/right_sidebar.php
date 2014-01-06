<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Right Sidebar Template
*/
?>
<!-- Getting Header-->
<?php //die('right page'); ?>
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
	     <div class="wlcm-guest-btn-my-account"><a href="<?php echo $redirect_to; ?>">My Account</a></div>
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
	       <!--<div class="wlcm-guest-btn-area">
	     <?php 	//f($current_user->data->user_login){
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
          <div class="content-left-part">
	  <div id="verified_mesg" style="color:#0B3B0B"></div>
        <div class="job-list-area">
             <!-- Page Content Start form here  -->
		   <?php    if ( have_posts() ) :
			while ( have_posts() ) : the_post(); ?>
			<?php
			if(!is_page('1465'))
			{  
			     the_content(); 
			} 
			?> 
		   <?php endwhile; // end of the loop. ?>
		
		   <?php endif;
		  if(( get_the_ID()==442)||(get_the_ID()== 487)){
			      Show_FaqNews_content();
			      }
		 
		  /* ...........for news content ............*/
		  if( get_the_ID()==22){
		Show_News_content(); ?>
		<!--<h3>Tips and Advice</h3>-->
		 <?php advice_section_dispaly(); 
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
        <div class="content-advertise-area" id="abcd1"><?php if(function_exists( 'wp_bannerize' ))
        wp_bannerize( 'group=sidebar_group&random=1&limit=1' ); ?></div>
       </div>
      </div>
      <?php }  
       else{
	    
	/* Show_FaqNews_content(); ?>
		<h3> Advice</h3>
		 <?php  advice_section_dispaly();
		    /* ...........end news content ............*/
	  ?><?php   if( get_the_ID()==509){?>
	   <!-- <h3>Tips and Advice</h3> -->
		 <?php advice_section_dispaly();
		 }
		  ?>
            </div>
	 </div>
       <div class="content-right-part">
       <div class="faq-cntnt-lft-area"> 
        <div class="traders-right-area">
              <div class="traders-right-part">
            <div class="traders-plc">
		  <?php  if($_GET['page_id'] ==509){ show_job_conent_in_right();
			}else{
			     
               Show_sidebar_right_joinnow(); } ?>
            </div>
             </div>
	</div>
	      <div class="traders-right-area">
	      <?php if(get_the_ID()==354) {?>
	      <div class="traders-right-part">
	    <div class="traders-plc">
                <div class="traders-head" style="color:#000;">Traders</div>
				<?php
			global $wpdb;
			$retrieve_data = $wpdb->get_results("SELECT * FROM wp_usermeta where meta_key='usertype' and meta_value='2' ORDER BY user_id desc limit 0,3");
			foreach ($retrieve_data as $retrieved_data){
			$id= $retrieved_data->user_id;
			$all_meta_for_user = get_user_meta($id);
			$myStr= $all_meta_for_user['about_company'][0];
			$company=substr($myStr, 0, 50);
			preg_match("/src='(.*?)'/i",get_avatar($id,150), $matches);
			$a=explode('=',$matches[0]);
			$a1=explode("'",$a[1]);
			?>
		   <div class="trader-box">
                  <div class="traders-img_txt">
                <div class="traders-img_small"><a href="<?php echo site_url();?>?page_id=710&id=<?php echo $id;?>" style="color:#000;"><img border="0" align="left" src="<?php echo $a1[1];?>" /></a></div>
                <div class="traders-head-txt" style="color:#000;"><a href="<?php echo site_url();?>?page_id=710&id=<?php echo $id;?>" style="color:#000;"><?php echo $all_meta_for_user['first_name'][0];?></a><span><?php echo $company;?></span></div>
              </div>
                </div>
		<?php } ?>
		<div class="more-traders"><span><a href="<?php echo site_url();?>?page_id=13">More Traders</a></span> </div>
            </div>
	    <?php }?>
	      </div>
              </div> 
      <?php /* <div class="content-advertise-area" id="abcd12"><img src="<?php bloginfo('template_url')?>/images/advertise-img.png" alt=""></div> */?>
 <div class="content-advertise-area" id="abcd12"><?php if(function_exists( 'wp_bannerize' ))
        wp_bannerize( 'group=sidebar_group&random=1&limit=1' ); ?></div>
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
	     <?php if($_GET['page_id'] ==442){?>
		 <div class="content-advertise-area" id="abcd"><?php if(function_exists( 'wp_bannerize' ))
        wp_bannerize( 'group=flash_banner&random=1&limit=1' ); ?></div>
		 <?php } ?>
        </div>
	<?php  } ?>
	 <div class="traders-right-area">
	      <?php if(get_the_ID()==1044) {?>
	      <div class="traders-right-part">
	    <div class="traders-plc">
                <div class="traders-head" style="color:#000;">Employers</div>
				<?php
			global $wpdb;
			$retrieve_data = $wpdb->get_results("SELECT * FROM wp_usermeta where meta_key='usertype' and meta_value='4' ORDER BY user_id desc limit 0,3");
			foreach ($retrieve_data as $retrieved_data){
			$id= $retrieved_data->user_id;
			$all_meta_for_user = get_user_meta($id);
			$myStr= $all_meta_for_user['about_company'][0];
			$company=substr($myStr, 0, 50);
			preg_match("/src='(.*?)'/i",get_avatar($id,150), $matches);
			$a=explode('=',$matches[0]);
			$a1=explode("'",$a[1]);
			?>
		   <div class="trader-box">
                  <div class="traders-img_txt">
                <div class="traders-img_small"><img border="0" align="left" src="<?php echo $a1[1];?>" /></div>
                <div class="traders-head-txt" style="color:#000;"><?php echo $all_meta_for_user['first_name'][0];?><span><?php echo $company;?></span></div>
              </div>
                </div>
		<?php } ?>
		<div class="more-traders" ><span><a style="padding: 0 4px 0 2px" href="<?php echo site_url();?>?page_id=13">More employers</a></span> </div>
            </div>
	      </div>
              </div> 
        <div class="content-advertise-area" id="abcd13"><a href="<?php echo site_url();?>?page_id=1165"><?php if(function_exists( 'wp_bannerize' ))
        wp_bannerize( 'group=sidebar_group&random=1&limit=1' ); ?></a></div>
	
	 <?php }?>
       </div> 
      </div>
      <?php }?>
   </div>
  </div>
 </div>
</div>
<!--Getting Footer-->
<?php get_footer(); ?>