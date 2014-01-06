<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage constructionmates_mobile
 * @since constructionmates_mobile 1.0
 */
get_header(); ?>
<script>
function choose_subscription(id){
//alert(id);
//url="<?php echo $_SERVER['SERVER_NAME'];?>"
window.location.href = '?page_id=330&type='+id;
}
</script>
		<div id="primary">
			<div id="content" role="main">
			<div class="tabs_search"> 
			<ul class="tab_2list">
				<?php while ( have_posts() ) : the_post();
				if($id==1308){ ?> <?php //blog page ?>
					<h1 class="traders"> Blog</h1>
					<?php show_blog_content_mobile();?></div></li>
				<?php }
				
				elseif($id==1606){?><?php //Popular Builder 
				    show_popular_builder();
		  		?>
				<?php }
				elseif($id==1630){?><?php //Recent Traders 
				    show_recent_trader_mobile();
		  		?>
				<?php }
				elseif($id==1631){?><?php //Latest Jobs 
				    show_latest_job_mobile();
		  		?>
				
				<?php }
				elseif($id==1721){?><?php //Latest Jobs 
				    show_trades_mobile();
		  		?>
				<?php }
				elseif($id==1722){?><?php //Latest Jobs 
				    show_trades_detail_mobile();
		  		?>
				
				<?php }
				
				else{ ?>
				    <?php get_template_part( 'content', 'page' );
				    }
					if($_GET['info']!=""){
					 comments_template( '', true );}
			      ?>
				<?php endwhile; // end of the loop. ?>
			</ul>
			<?php if($id==22){
			Show_News_content_mobile();
			 } ?>
			 <?php if($id==30){?><h2 class="new_content_heading">Terms & Conditions</h2>
			 <p class="new_text"><?php  strip_tags(the_content());?></p>
			<?php }
	                if($id==21){?><h2 class="new_content_heading">About Us</h2><div class="new_text new_row"><?php strip_tags(the_content());?></div>
			<?php }
			if($id==36){?><h2 class="new_content_heading">Sitemap</h2><div class="new_text new_row"><?php strip_tags(the_content());?></div>
			<?php }
			if($id==32){?><h2 class="new_content_heading">Privacy & Cookie's</h2><div class="new_text new_row"><?php strip_tags(the_content());?></div>
			<?php }
			if($id==62){?><h2 class="new_content_heading">Contact Us</h3><div class="new_text new_row"><?php the_content();?></div>
			<?php }
			if($id==1169){?><h2 class="new_content_heading">Hire Shopes</h2><div class="new_text new_row"><?php strip_tags(the_content());?></div>
			<?php }
			if($id==1167){?><h2 class="new_content_heading">Building Supplies</h2><div class="new_text new_row"><?php strip_tags(the_content());?></div>
			<?php }
			if($id==1165){?><h2 class="new_content_heading">Advertising</h2><div class="new_row clearfix"><?php strip_tags(the_content());?></div>
			<?php }
			if($id==1171){?><h2 class="new_content_heading">Buy Tools</h2><div class="new_textFile"><?php strip_tags(the_content());?></div>
			<?php }
			if($id==330){
			  //echo ' 2134312425';
			    echo do_shortcode(" [joinnow_login_form] ");
			}
			if($id==18){
				the_content(); // post a job menu page without login
			}
			if($id==354){
				 echo do_shortcode(" [job_posting] "); // post a job menu page  login
			}
			if($id==1359){
				 echo do_shortcode(" [bt_search] "); // post a job menu page  login
			}
			if($id==1188){
				 echo do_shortcode(" [job_latest] "); //  latest job display page  login
			}
			if($id==20){
			      Show_faq_answer_mobile();
			 }
			 if($id==442){
			       echo do_shortcode(" [show_profile_user] "); // user dashboard
			 }
			 if($id==487){
				echo do_shortcode("[show_home_owner] ");
			 }
			 if($id==1273){
			echo do_shortcode(" [resumeForm] "); 
			 }
			 if($id==1423){
			echo do_shortcode("[vfb id=1]");
			}
			if($id==11){
				//the_content();
				 echo do_shortcode("[show_builders]");
			}
			      if($id==13){
                                the_content(); 
                        }
			 if($id==509){
                                   echo do_shortcode("  [job_detail] ");
			}
			if($id==1044){
				//the_content();
				 echo do_shortcode("[job_listing]");// user job listing at my account page
			}		
			 if($id==1364){
				//the_content();
				 echo do_shortcode("[jobs_post_employer]");// employer job psting 
			}
			 if($id==118){
				//the_content();
				  the_content(); 
			}
			 if($id==1465){
				//the_content();
				home_page_slider();// employer job psting 
			}
			if($id==15){
                                the_content(); 
                        }
			if($id==1375){
                                the_content(); 
                        }
			if($id==702){
                                echo do_shortcode(" [show_builder_detail] ");
                        }
			if($id==710){
                                echo do_shortcode(" [show_trader_detail] ");
                        }
			else { ?>
			<div class="adv_box new_addimgbox">
			<?php if(function_exists( 'wp_bannerize' ))
        wp_bannerize( 'group=mobile_blog&random=1&limit=2'); ?>
             <!-- <img src="<?php //echo get_template_directory_uri(); ?>/images/adv_1.jpg" alt="img"><img src="<?php //echo get_template_directory_uri(); ?>/images/adv_2.jpg" alt="img">-->
           <div class="clear-both"></div></div><?php }?>
		</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer();?>