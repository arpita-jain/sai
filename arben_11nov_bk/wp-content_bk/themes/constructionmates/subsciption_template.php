<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: subsciption Template
*/
?>
<!-- Getting Header-->
<?php get_header();
 global $current_user;?>

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
      <div class="term-condition-area">
                <!-- Page Content Start form here  -->
		   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		    <h3>Listing Packages / Prices
		    </h3>
		  
		     <?php the_content(); ?>
		 
		   <?php endwhile; // end of the loop. ?>
      </div>
      </div>
  </div>
  
 </div>
<!--Getting Footer-->
<?php get_footer(); ?>
<script>
function choose_subscription(id){
//alert(id);
//url="<?php echo $_SERVER['SERVER_NAME'];?>"
window.location.href = '?page_id=330&type='+id;
}
</script>
