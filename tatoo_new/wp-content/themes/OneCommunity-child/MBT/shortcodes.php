<?php

//[mbt_bc_img_wgt]
function mbt_bc_img_wgt_handler( $atts ){
	return mbt_bc_img_wgt_gallery( $atts );
}
add_shortcode( 'mbt_bc_img_wgt', 'mbt_bc_img_wgt_handler' );


// function to load images
function mbt_bc_img_wgt_gallery( $atts ) {

	$defaults = array(
		'images' => 12
	);
	extract( shortcode_atts( $defaults, $atts ) );
	
	global $wpdb;
	$uploads = wp_upload_dir();
	$result = $wpdb->get_results("SELECT rt.*, wp.guid, wp.post_author FROM {$wpdb->base_prefix}rt_rtm_media rt, {$wpdb->base_prefix}posts wp WHERE rt.media_type = 'photo' AND rt.media_id = wp.ID ORDER BY rt.id DESC LIMIT {$images}");
	?>
	<div class="mbt_bc_img_wgt_gallery" >
	<?php
		if($result) {
			foreach( $result as $item ) {
				//print_rr( $item);
				$link				= $item->guid;
				$title				= $item->media_title;
				$author_id			= $item->post_author;
				$author_link		= bp_core_get_user_domain( $author_id );
				$author_media_link	= untrailingslashit( $author_link ) . '/media';
				
				//$image_large		= wp_get_attachment_image_src( $item->media_id, array(MBT_MAX_IMAGE_WIDTH, MBT_MAX_IMAGE_HEIGHT));
				//print_rr(wp_get_attachment_image_src( $item->media_id, array(60, 60) ));
				?>
				<a href="<?php echo $author_media_link; ?>" title="<?php echo $title; ?>">
					<?php echo wp_get_attachment_image( $item->media_id, array(60, 60) ); ?>	
				</a>
		<?php }
		}?>
	</div>
<?php }
?>