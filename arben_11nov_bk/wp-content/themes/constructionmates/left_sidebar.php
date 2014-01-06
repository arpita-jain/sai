<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Left Sidebar Template
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
	     <?php 	if($current_user->data->user_login){
	      ?>
	     <div class="wlcm-guest-btn-my-account"><a href="<?php echo $redirect_to;?>">My Account</a></div>
	     <?php } ?>
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
	<?php 	//if($current_user->data->user_login){
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
    <div class="cntnt-faq-lft-prt">
      <?php if( get_the_ID()==20){
	 define('ABSPATH', dirname(__FILE__) . '/');
 wp_enqueue_script('validationjsfile',plugins_url('/js/jobpostform-validation.js' , __FILE__ ));?>
	 	<script>/*
		(function($){
			$(window).load(function(){
				$(".personal_box").mCustomScrollbar({
					scrollButtons:{
						enable:true
					}
				});
				//ajax demo fn
				$("a[rel='load-content']").click(function(e){
					e.preventDefault();
					var $this=$(this),
						url=$this.attr("href");
					$this.addClass("loading");
					$.get(url,function(data){
						$this.removeClass("loading");
						$(".personal_box .mCSB_container").html(data); //load new content inside .mCSB_container
						$(".personal_box").mCustomScrollbar("update"); //update scrollbar according to newly loaded content
						$(".personal_box").mCustomScrollbar("scrollTo","top",{scrollInertia:200}); //scroll to top
					});
				});
				$("a[rel='append-content']").click(function(e){
					e.preventDefault();
					var $this=$(this),
						url=$this.attr("href");
					$this.addClass("loading");
					$.get(url,function(data){
						$this.removeClass("loading");
						$(".personal_box .mCSB_container").append(data); //append new content inside .mCSB_container
						$(".personal_box").mCustomScrollbar("update"); //update scrollbar according to newly appended content
						$(".personal_box").mCustomScrollbar("scrollTo","h2:last",{scrollInertia:2500,scrollEasing:"easeInOutQuad"}); //scroll to appended content
					});
				});
			});
		})(jQuery);*/
		//alert('---');
		$(document).ready(function(){
		// $('.question_id').hide();
		    /* $('.category_id').click(function(){
			   alert('===');
			   id=this.id();
			   alert(id);
		});*/
	 });
		
	</script>
<?php  /*	if ( is_active_sidebar( 'Sidebar Widget Area' ) ) : ?><?php  dynamic_sidebar( 'Sidebar Widget Area' ); ?><?php endif; */
		//Show_question();
		$retrieve_data1 = $wpdb->get_results("SELECT * from wp_faq_category");?>
		<div class="job-list-area">
		     <h3>FAQ</h3>
		  </div>
		<div class="traders-plc">
	 <div class="jobdetal_scroll">
                    <div class="personal_container">
                        <div class="personal_box">
                            <span class="text">
				    <?php foreach($retrieve_data1 as $retrieve_data1){?>
					      <div class="questions term-condition-rw"><a id="<?php echo $retrieve_data1->id;?>" class="category_id" href="<?php echo site_url().'?page_id=20'.'&cat='.$retrieve_data1->id;?>"><h3><?php echo $retrieve_data1->category_name;?></h3></a>
					     <div class="question_id" id="<?php echo 'cat_'.$retrieve_data1->id;?>">
				    <?php  $catid=$retrieve_data1->id;
				     $retrieve_value = $wpdb->get_results("select * from wp_faq_content where category= $catid ");
				      foreach($retrieve_value as $retrieve_value){ ?>
				  <div style="margin-left:30px;width:90%;"><ul><li><?php echo $retrieve_value->question;?>
				  </li></ul></div>
				   
				    <?php }?></div></div><?php } ?>
			   </span>
                        </div>
                    </div>
            	</div>
		</div> 
		
<?php }?>
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