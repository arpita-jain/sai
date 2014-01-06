<?php get_header(); ?>
<?php
$url = mbt_get_url_segments();
if ( isset($url[3]) ) {
	$media_categories = explode(',', $url[3]);
	$media_categories = array_filter($media_categories);
}
$media_all = 0;
if ( count($media_categories) == 0 ) {
	$media_all = 1;
}

$m_categories = get_terms( MBT_MEDIA_TAXONOMY ); 
?>
	<div id="content">

		<div class="page-title"><?php the_title(); ?></div>
		
		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" role="main">
			<?php if ( $m_categories ) : ?>
			<div class="mbt_gallery_categories">
				<form action="<?php echo site_url( 'explore' ); ?>/1" method="post" id="explore_categories">
					<fieldset>
						<legend>Choose Categories</legend>
						<label><input type="checkbox" name="all" id="all" value="yes" <?php echo checked( $media_all ); ?> /> All</label>
						<?php
						foreach ($m_categories as $category) {
							$checked 	= null;
							
							if ( count($media_categories) > 0 ) {
								if ( in_array($category->term_id, $media_categories) ) {
									$checked = 'checked="checked"';
								}
							}
							
							echo '<label><input type="checkbox" ' . $checked . ' name="media_category[]" id="media_category_'. $category->term_id . '" value="'. $category->term_id . '" /> ' . $category->name . '</label>' . "\n";
						}
						?>
						<div class="right">
							<input type="hidden" id="categories_array" name="categories" value="" />
							<input type="submit" value="Show" />
						</div>
					</fieldset>
				</form>
				<script>
					jQuery(document).ready( update_explore_categories );
					jQuery(document).ready(function($) {
						$(".pagination a").each(function(e) {
							$(this).addClass("no-popup");
						})
					});

					jQuery('#explore_categories :checkbox').change( update_explore_categories );

					function update_explore_categories() {
						var selected_categories = new Array();
						var all_selected = 0;
						jQuery('#explore_categories input[type="checkbox"]:checked').each(function() { 
							if ( jQuery(this).val() == 'yes' ) {
								all_selected = 1;
							}
							selected_categories.push(jQuery(this).val()); 
						});
						if ( all_selected == 0 ) {
							jQuery('#categories_array').val( selected_categories.join() );
						} else {
							jQuery('#categories_array').val('');
						}
						jQuery('#explore_categories').attr('action', '<?php echo site_url( 'explore' ); ?>/1/' + jQuery('#categories_array').val());
					}
				</script>
			</div>
			<?php endif; ?>
			<div class="mbt_bp_album_featured_images_gallery rtmedia-list-media" >
			<?php
			global $wp_query;
			$per_page 	= 50;
			$paged 		= (get_query_var('page')) ? get_query_var('page') : 1;
			
			$args = array(
				'posts_per_page'	=> $per_page,
				'post_type'			=> 'attachment',
				'post_status'		=> 'any',
				'paged'				=> $paged
			);
			
			if ( isset($media_categories) && count($media_categories) > 0 ) {
				$args['tax_query'] = array(
					array(
						'taxonomy'	=> MBT_MEDIA_TAXONOMY,
						'field'		=> 'id',
						'terms'		=> $media_categories
					)
				);
			}
			
			query_posts( $args );
			
			$total_posts = $wp_query->found_posts;
			?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php
						
				$media_id 			= $post->ID;
				$link 				= get_permalink();
				$title 				= get_the_title();
				$author_id 			= $post->post_author;
				$author_username	= get_userdata( $author_id )->user_login;
				$author_link		= bp_core_get_user_domain( $author_id );
				$author_media_link	= untrailingslashit( $author_link ) . '/media';
				$image_large		= wp_get_attachment_image_src( $media_id, array(MBT_MAX_IMAGE_WIDTH, MBT_MAX_IMAGE_HEIGHT));
				

				if ( $media_id ) {
					$row = $wpdb->get_row("SELECT * FROM {$wpdb->base_prefix}rt_rtm_media WHERE media_id = '{$media_id}'");
					if ( $row ) {
					$item_id = $row->id;
					//$author_id = $row->media_author;
					$link = site_url("/members/{$author_username}/media/{$item_id}");
					} else {
						/* Item not uploaded by RTMedia plugin */
						continue;
					}
				}
			?>
				<div class="explore_divs">
					<a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
						<?php echo wp_get_attachment_image( $media_id, array(150, 150) ); ?>	
					</a>
					<div class="explore_author"><span><a href="<?php echo $author_media_link; ?>" class="no-popup" title="Image Uploaded By <?php echo $author_username; ?>"><?php echo $author_username; ?></a></span></div>
				</div>
				
					
			<?php endwhile; endif; ?>
				<hr />
				<div class="pagination">
					<?php 
					$url 		= mbt_get_url_segments();
					if ( isset($url[3]) ) {
						$media_categories = $url[3];
					}
					echo paginate_links( array(
						'total'		=> ceil( $total_posts / $per_page ), 
						'current'	=> $paged,
						'base'		=>  site_url('explore/%#%/' . $media_categories )
					)); ?>
				</div>
			</div>
		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ); ?>

	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
