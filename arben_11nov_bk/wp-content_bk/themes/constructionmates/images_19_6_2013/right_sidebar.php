<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Right Sidebar Template
*/
?>
<!-- Getting Header-->
<?php get_header(); ?>
<div class="breadcrumbs" style="font-size:14px;padding-left:175px;">
   	 <?php if(function_exists('bcn_display'))
   	 {
     	   bcn_display();
    	}?></div>
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
          <div class="content-left-part">
        <div class="job-listing-left-area">
             <!-- Page Content Start form here  -->
		   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		    
		     <?php the_content(); ?>
		   <?php endwhile; // end of the loop. ?>
		<?php 
			$id = get_the_ID();
			if($id==22){?>
				      <h3>News</h3>
				<?php query_posts( array ( 'category_name' => 'News', 'posts_per_page' => -1 ) ); ?>
      				<?php while (have_posts()) : the_post(); ?>
				
			      <div class="job-list-part">
			  <?php if(get_the_post_thumbnail( get_the_ID())==""){ ?>
			       <div class="job-img-part"><img src="images/logo-img-demo.png" alt=""></div>
			  }else{ ?>
                  <div class="job-img-part"><?php echo get_the_post_thumbnail( get_the_ID());?></div> <?php } ?>
				
				<div class="job-list-txt-plc">
				<h5><?php the_title(); ?></h5>
				<?php the_excerpt();
				?>
				 </div>
         		       </div>	
				<?php endwhile; ?>
				<?php } ?>
            </div>
    </div>
      
    <div class="content-right-part">
       <div class="faq-cntnt-lft-area"> 
        <div class="traders-right-area">
              <div class="traders-right-part">
            <div class="traders-plc">
                  <div class="traders-head">Click Links</div>
                  <div class="trader-box">
                <div class="traders-img_txt">
                      <div class="traders-img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                      <div class="traders-head-txt"><span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                    </div>
              </div>
                  <div class="trader-box">
                <div class="traders-img_txt">
                      <div class="traders-img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                      <div class="traders-head-txt"><span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                    </div>
              </div>
                  <div class="trader-box">
                <div class="traders-img_txt">
                      <div class="traders-img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                      <div class="traders-head-txt"><span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                    </div>
              </div>
                  <div class="trader-box">
                <div class="traders-img_txt">
                      <div class="traders-img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                      <div class="traders-head-txt"><span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                    </div>
              </div>
                  <div class="trader-box last-trade-brdr">
                <div class="traders-img_txt">
                      <div class="traders-img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                      <div class="traders-head-txt"><span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                    </div>
              </div>
                </div>
          </div>
            </div>
        <div class="content-advertise-area"><img src="images/advertise-img.png" alt=""></div>
       </div> 
      </div>
      
   </div>
  </div>
 </div>

<!--Getting Footer-->
<?php get_footer(); ?>
