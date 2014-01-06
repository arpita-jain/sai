<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Home Page
*/
?>
<!-- Getting Header-->
<?php get_header(); ?>
<div class="container back_bg">
      <div class="side_image"></div>
<div class="row">
    <div class="twelvecol">
          <div class="slogan_txt">
        <div class="slogan_text"> Premium Services by professional<br/>
              <span>Builders and Traders</span> </div>
      </div>
          <div class="search_field_main">
        <div class="what_field"> <span>what</span><br>
              <div class="input_bg"> <span>
                <input type="text" name="txtEmail" value="job title, keywords or company name">
                </span> </div>
            </div>
        <div class="where_field"> <span>where</span><br>
              <div class="input_bg"> <span>
                <input type="text" name="txtEmail" value="city or postcode">
                </span>
            <p><a href="#">Advanced search</a></p>
          </div>
            </div>
	<div class="bteNew">
        <div class="search_button"> <span>
          <input type="button" name="txtEmail" value="Search">
          </span> </div>
        <div class="join_now" id="index"> <span>
          <a href="http://constructionmates.co.uk/?page_id=118"><input type="button" name="txtEmail" value="Join Now"></a>
          </span>
              <p><a href="#">Sign-in to your account</a></p>
            </div>
          </div>
        <!--<div class="join_now_main">
                	<div class="join_now">
                		Join Now
                	</div>
                    	<p>Sign-in to your account</p>
                </div>--> 
      </div>
      <div class="category_box_main">
       <div class="cate_box last">
              <div class="cate_box_bg">
                <?php query_posts('page_id=52');
                 if (have_posts()) : the_post(); 
                  $values = get_post_custom_values("contact_us");
                  ?>
               <p><?php echo $values[0]; ?></p>
               <?php endif; ?>
               <?php wp_reset_query(); ?>
	    
            <div class="read_more_div">
                  <div class="read_more_button"> <a href="http://constructionmates.co.uk/?page_id=52">Read more</a> </div>
                </div>
          </div>
            </div>
       
       <div class="cate_box">
              <div class="cate_box_bg">
                 <?php query_posts('page_id=54');
                 if (have_posts()) : the_post(); 
                  $values = get_post_custom_values("build_your_profile");
                  ?>
               <p><?php echo $values[0]; ?></p>
               <?php endif; ?>
               <?php wp_reset_query(); ?>
            <div class="read_more_div">
                  <div class="read_more_button"> <a href="http://constructionmates.co.uk/?page_id=54">Read more</a> </div>
                </div>
          </div>
            </div>
       
       <div class="cate_box">
              <div class="cate_box_bg">
               <?php query_posts('page_id=56');
                 if (have_posts()) : the_post(); 
                  $values = get_post_custom_values("Get_connected");
                  ?>
               <p><?php echo $values[0]; ?></p>
               <?php endif; ?>
               <?php wp_reset_query(); ?>
            <div class="read_more_div">
                  <div class="read_more_button"> <a href="http://constructionmates.co.uk/?page_id=56">Read more</a> </div>
                </div>
          </div>
            </div>
       
      </div>

      </div>
  </div>
    </div>
<div class="container content_bg">
      <div class="row">
    <div class="twelvecol">
          <div class="small_banner_bg"> <img src="<?php bloginfo('template_url')?>/images/small-banner.png" /> </div>
        </div>
  </div>
      <div class="middle_line">
    <div class="row">
          <div class="twelvecol">
        <div class="slogan_txt_middle">
              <p>Let?s find Best Traders & </p>
              <br/>
              <div>Professional <span class="color">Builders</span></div>
            </div>
      </div>
        </div>
  </div>
      <div class="row">
    <div class="twelvecol">
          <div class="category_part">
        <div class="traders_part">
              <div class="border_div">
            <div class="title_cate">Recent Traders</div>
            <div class="img_txt">
                  <div class="img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                  <div class="txt_cate">Traders Name<span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                </div>
          </div>
              <div class="second_div">
            <div class="img_txt_2">
                  <div class="img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                  <div class="txt_cate">Traders Name<span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                  <div class="more_button"> <span><a href="#">More Trader</a></span> </div>
                </div>
          </div>
            </div>
        <div class="latest_part">
              <div class="title_cate">Latest Jobs</div>
              <div class="left_job"> <a href="#">Accountancy <span>(7,738)</span></a> <a href="#">Aerospace <span>(1,014)</span></a> <a href="#">Agriculture <span>(112)</span></a> <a href="#">Finance <span>(8,494)</span></a> <a href="#">Hospitality <span>(2,933)</span></a> <a href="#">Construction <span>(5,357)</span></a> </div>
              <div class="left_job last"> <a href="#">Accountancy <span>(7,738)</span></a> <a href="#">Aerospace <span>(1,014)</span></a> <a href="#">Agriculture <span>(112)</span></a> <a href="#">Finance <span>(8,494)</span></a> <a href="#">Hospitality <span>(2,933)</span></a> <a href="#">Construction <span>(5,357)</span></a> </div>
              <div class="more_job"> <span><a href="#">More Jobs</a></span> </div>
            </div>
        <div class="popular_part">
              <div class="popular_div">
            <div class="title_popular">Popular Builders</div>
            <div class="img_txt">
                  <div class="img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                  <div class="txt_popular">Builder Name<span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                </div>
          </div>
              <div class="second_div">
            <div class="img_txt_2">
                  <div class="img_small"><img border="0" align="left" src="<?php bloginfo('template_url')?>/images/img_cate.png" /></div>
                  <div class="txt_popular">Builder Name<span>Lorem ipsum dolor sit amet ad ipisicing consectetur</span></div>
                  <div class="more_bilders"> <span><a href="#">More Builders</a></span> </div>
                </div>
          </div>
            </div>
      </div>
        </div>
  </div>
      <div class="row">
    <div class="twelvecol">
          <div class="buttton_addvertize">
        <div class="adver_button"> <span><a href="#">Advertising</a></span> </div>
        <div class="trade_button"> <span><a href="#">Search by trade</a></span> </div>
        <div class="post_button"> <span><a href="#">Post a job</a></span> </div>
      </div>
        </div>
  </div>
    </div>

<!--Getting Footer-->
<?php get_footer(); ?>
