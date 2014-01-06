<?php
/*
Theme Name: constructionmates_mobile
Version: 0.9b
Author: Michael Louviere
The template for displaying Search Results pages.
*/

?>
<?php get_header(); ?>
<div class="clear"></div>
<div class="clear"></div>
<?php get_sidebar('banner'); ?>
       <div class="content">
	<div class="inner_content">
            <div class="content_text">
                <?php if ( have_posts() ) : ?>
                <h1><?php printf( __( 'Search Results for: %s', 'pccti' ), '' . get_search_query() . '' ); ?></h1>
                <?php
                /* Run the loop for the search to output the results.
                * If you want to overload this in a child theme then include a file
                * called loop-search.php and that will be used instead.
                */
                get_template_part( 'loop', 'search' );
                ?>
                <?php else : ?>
                <h1><?php _e( 'Nothing Found', 'pccti' ); ?></h1>
                <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'sandbox' ); ?></p>
                <div style="margin-top:10px;"><?php get_search_form(); ?></div>
                <?php endif; ?>

	 </div>
	 <div class="clear"></div>
	<!-- Right Section End--> 
</div>
    <div class="clear"></div>
  </div>
<!--contener end-->
<?php get_footer(); ?>