<?php 
/* 
Theme Name: PCCTI
Version: 0.9b
Author: Cis Team
Template for main Banner
*/
?>
<div class="inner_slider">
    <?php
	    // check if the post has a Post Thumbnail assigned to it.
	    if (has_post_thumbnail() ) {
		  $large_image_url= wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
    ?>
    <style type="text/css">
    .inner_slider .banner { background:url(<?php echo $large_image_url[0];  ?>) no-repeat left top; height:143px;}
    </style>
	<div class="slider_in">
    	<div class="banner">
	<?php $bannerTextValue= get_post_meta(get_the_ID(), "banner_text", true); ?>
        	  <?php if(!empty($bannerTextValue)):?>
		<div class="banner_in">
            	<h1><?php the_title(); ?></h1>
                <p><?php echo get_post_meta(get_the_ID(), "banner_text", true); ?> <a href="<?php echo get_permalink(get_the_ID());  ?>">Read More...</a></p>
              </div>
	    <?php endif; ?>
        </div>
    </div>
    
</div>
<?php }  else {  ?>
  <div class="slider-room-rental">
  <div class="slider-new">
    <div id="container">
      <div id="banner-slide" style="position: relative; max-width: 1011px; height: 397px;">
        <div class="bjqs-wrapper" style="width: 1011px; height: 397px; overflow: hidden; position: relative;">
     <?php   if (function_exists('get_thethe_image_slider')) {
		print get_thethe_image_slider('slider');
	}
        ?>
    </div>
 <?php } ?>
  </div>
    </div>
  </div>
     <div class="shadow_slider"><img width="1024" height="33" src="<?php bloginfo('template_url')?>/images/shadow-slider.png"></div>
    <div class="clr"></di
  </div>



