<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage constructionmates_mobile
 * @since constructionmates_mobile 1.0
 */
get_header(); ?>
		<div id="primary">
			<div id="content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<nav id="nav-single">
						<h3 class="assistive-text"><?php //_e( 'Post navigation', 'constructionmates_mobile' ); ?></h3>
						<span class="nav-previous"><?php //previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'constructionmates_mobile' ) ); ?></span>
						<span class="nav-next"><?php //next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'constructionmates_mobile' ) ); ?></span>
					</nav><!-- #nav-single -->

					<?php get_template_part( 'content', 'single' ); ?>
					 <div class="tabs_search">
					<ul class="tab_2list">
					<li class="new_imgs">
				 <?php if(get_the_post_thumbnail( get_the_ID())!=""){ ?>
		                <?php echo get_the_post_thumbnail( get_the_ID());?><?php } ?>
				<div class="span2 new_paddind">
				<h3><?php the_title(); ?></h3>
				<span class="top_s new_width">
			<?php echo '<p class="new_textarea">'.$post->post_content.'</p>';//print_r($content);?>
				<?php comments_template( '', true ); ?>
</span></div> <div class="clear-both"></div></li></ul>
				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer(); ?>