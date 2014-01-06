<?php
/* 
Theme Name: constructionmatesss_mob
Version: 0.9b
Author: Cis Team
Template Name: Home Page
*/
?>
<!-- Getting Header-->
<?php get_header(); ?>
<!--<div class="adv">-->
<div class="mainWrapper clearfix">
<div class="topImg clearfix">
<?php if(function_exists( 'wp_bannerize' ))
        wp_bannerize( 'group=mobile_home_image1'); ?>
        </div>
        </div>
        </div>
<!--<a href="#"><img src="<?php //echo get_template_directory_uri(); ?>/images/add.png" alt="add"></a>--><!--</div>-->
      <div class="clear-both"></div>
      <div class="tabs_search">
        <div id="tabsholder">
          <ul class="tabs">
            <li id="tab1">Popular Searches</li>
            <li id="tab2">Recent Searches</li>
          </ul>
          <div class="contents marginbot">
            <div id="content1" class="tabscontent">
              <ul class="buttons_list">
                <li> <a href="<?php echo site_url().'?page_id=1606&theme=handheld';?>" class="li_1">Popular Builders</a></li>
                <li> <a href="<?php echo site_url().'?page_id=1631&theme=handheld';?>" class="li_5">Latest Jobs</a></li>
                <li> <a href="<?php echo site_url().'?page_id=1721&theme=handheld';?>" class="li_6">Trades</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1171&theme=handheld" class="li_7">Buy Tools</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1630&theme=handheld" class="li_1">Recent Traders</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1167&theme=handheld" class="li_2"> Building supplies</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1165&theme=handheld" class="li_6">Advertising</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1167&theme=handheld" class="li_4"> Building supplies</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1169&theme=handheld" class="li_8">Hire Shopes</a></li>
              </ul>
            </div>
            <div id="content2" class="tabscontent">
              <ul class="tab_2list">
              <?php  
			global $wpdb;
			$retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where published='1' GROUP BY job_category ORDER BY id desc limit 0,6");
			foreach ($retrieve_data as $retrieved_data){
                          preg_match("/src='(.*?)'/i",get_avatar($retrieved_data->user_id,150), $matches);
			  //echo $matches[0];
			  $a=explode('=',$matches[0]);
			  $a1=explode("'",$a[1]);
                          $job_detail=$retrieved_data->job_detail;
                          $cont=substr($job_detail, 0, 150);?>
                <li>
                  <div class="more_btn"><a href="<?php echo site_url();?>?page_id=509&job=<?php echo $retrieved_data->id; ?>&theme=handheld"><img src="<?php echo get_template_directory_uri(); ?>/images/more.png" alt="more"></a></div>
                  <img class="img_profile" src="<?php echo $a1[1];?>" alt="icon">
                  <div class="span2">
                    <h3><?php echo $retrieved_data->job_type;?></h3>
                  <span class="top_s"><?php echo $cont;?></span>
                    <p><?php //echo $cont;?></p>
                  </div>
                  <div class="clear-both"></div>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
<div class="slider">
 <?php echo do_shortcode( "[featslider]" ); ?>
</div>
 <div class="clear-both"></div>
        </div>
      </div>
    </div>
<?php get_footer(); ?>