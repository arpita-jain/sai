<?php
/* 
Theme Name: constructionmates_mobile
Version: 0.9b
Author: Cis Team
Template Name: Home Page 
*/
?>
<!-- Getting Header-->
<?php get_header(); ?>
<div class="adv"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/add.png" alt="add"></a></div>
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
                <li> <a href="#" class="li_1">Popular Builders</a></li>
                <li> <a href="#" class="li_5">Latest Jobs</a></li>
                <li> <a href="#" class="li_6">Trades</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1171" class="li_7">Buy Tools</a></li>
                <li> <a href="#" class="li_1">Recent Traders</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1167" class="li_2"> Building supplies</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1165" class="li_6">Advertising</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1167" class="li_4"> Building supplies</a></li>
                <li> <a href="<?php echo site_url();?>?page_id=1169" class="li_8">Hire Shopes</a></li>
              </ul>
            </div>
            <div id="content2" class="tabscontent">
              <ul class="tab_2list">
                <li>
                  <div class="more_btn"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/more.png" alt="more"></a></div>
                  <img src="<?php echo get_template_directory_uri(); ?>/images/img_1.jpg" alt="icon">
                  <div class="span2">
                    <h3>Carpet - Fit only</h3>
                    Lorem ipsum dolor sit a um dolor sit <br>
                    aum dolor sit tipsum amet.
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullame laboris nisi ut aliquip duis aute irure dolor in reprehenderit in </p>
                  </div>
                  <div class="clear-both"></div>
                </li>
                <li>
                  <div class="more_btn"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/more.png" alt="more"></a></div>
                  <img src="<?php echo get_template_directory_uri(); ?>/images/img_1.jpg" alt="icon">
                  <div class="span2">
                    <h3>Carpet - Fit only</h3>
                    <span class="top_s">Lorem ipsum dolor sit a um dolor sit 
                    aum dolor sit tipsum amet.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullame laboris nisi ut aliquip duis aute irure dolor in reprehenderit in </p>
                  </div>
                  <div class="clear-both"></div>
                </li>
                <li>
                  <div class="more_btn"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/more.png" alt="more"></a></div>
                  <img src="<?php echo get_template_directory_uri(); ?>/images/img_4.jpg" alt="icon">
                  <div class="span2">
                    <h3>Carpet - Fit only</h3>
                    <span class="top_s">Lorem ipsum dolor sit a um dolor sit 
                    aum dolor sit tipsum amet.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullame laboris nisi ut aliquip duis aute irure dolor in reprehenderit in </p>
                  </div>
                  <div class="clear-both"></div>
                </li>
                <li>
                  <div class="more_btn"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/more.png" alt="more"></a></div>
                  <img src="<?php echo get_template_directory_uri(); ?>/images/img_3.jpg" alt="icon">
                  <div class="span2">
                    <h3>Carpet - Fit only</h3>
                    <span class="top_s">Lorem ipsum dolor sit a um dolor sit 
                    aum dolor sit tipsum amet.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullame laboris nisi ut aliquip duis aute irure dolor in reprehenderit in </p>
                  </div>
                  <div class="clear-both"></div>
                </li>
                <li>
                  <div class="more_btn"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/more.png" alt="more"></a></div>
                  <img src="<?php echo get_template_directory_uri(); ?>/images/img_2.jpg" alt="icon">
                  <div class="span2">
                    <h3>Carpet - Fit only</h3>
                    <span class="top_s">Lorem ipsum dolor sit a um dolor sit 
                    aum dolor sit tipsum amet.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullame laboris nisi ut aliquip duis aute irure dolor in reprehenderit in </p>
                  </div>
                  <div class="clear-both"></div>
                </li>
                <li>
                  <div class="more_btn"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/more.png" alt="more"></a></div>
                  <img src="<?php echo get_template_directory_uri(); ?>/images/img_4.jpg" alt="icon">
                  <div class="span2">
                    <h3>Carpet - Fit only</h3>
                    <span class="top_s">Lorem ipsum dolor sit a um dolor sit 
                    aum dolor sit tipsum amet.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullame laboris nisi ut aliquip duis aute irure dolor in reprehenderit in </p>
                  </div>
                  <div class="clear-both"></div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <?php echo do_shortcode( "[featslider]" ); ?>
      <!--<div class="slider">
        <div id="featured_slider">
          <ul id="slider">
            <li style="position: absolute; top: 0px; left: 0px; display: none; z-index: 4; opacity: 0; width: 918px; height: 100px;">
              <div class="content_left"> Lorem
                ipsum dolor sit amet, consectetur adipisicing elit. Tempor incididunt 
                ut labore et dolore magna aliqua.</div>
              <div class="img_right"><a href="#"><img src="<?php //echo get_template_directory_uri(); ?>/images/benifit_44.jpg" /></a></div>
            </li>
            <li style="position: absolute; top: 0px; left: 0px; display: block; z-index: 4; opacity: 1; width: 918px; height: 100px;">
              <div class="content_left"> Whether you are Employer, Builder, Trader or Home owner you simply search select and connect</div>
              <div class="img_right"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/images_5.jpg" /></a></div>
            </li>
            <li style="position: absolute; top: 0px; left: 0px; display: block; z-index: 5; opacity: 0; width: 918px; height: 100px;">
              <div class="content_left"> By building your profile you are actually build your own business web page where </div>
              <div class="img_right"><a href="#"><img src="<?php //echo get_template_directory_uri(); ?>/images/benifts.jpg" /></a></div>
            </li>
            <li style="position: absolute; top: 0px; left: 0px; display: none; z-index: 4; opacity: 0; width: 918px; height: 100px;">
              <div class="content_left"> Create an account for as little as 1.99 per month and we will give you access to hundreds</div>
              <div class="img_right"><a href="#"><img src="<?php //echo get_template_directory_uri(); ?>/images/ankita-shrivastav_avatar_1375703289-150x150.jpg" /></a></div>
            </li>
          </ul>
          <div class="feat_next"></div>
          <div class="feat_prev"></div>
        </div>
        <div class="clear-both"></div>
      </div>-->
    </div>
<?php get_footer(); ?>