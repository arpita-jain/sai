<?php
// Create the custom post type for the Job Postings
function rsjp_job_postings_init() {
  $labels = array(
      'name' => _x( 'RSJP Job Postings', 'post type general name' ),
      'singular_name' => _x( 'RSJP Job Posting', 'post type singular name' ),
      'add_new' => _x( 'Add New Job Posting', 'job-posting' ),
      'add_new_item' => __( 'Add New Job' ),
      'edit_item' => __( 'Edit Job Posting' ),
      'new_item' => __( 'New Job Posting' ),
      'all_items' => __( 'All Job Postings' ),
      'view_item' => __( 'View Job Posting' ),
      'search_items' => __( 'Search Job Postings' ),
      'not_found' =>  __( 'No job postings found' ),
      'not_found_in_trash' => __( 'No job postings found in Trash' ), 
      'parent_item_colon' => '',
      'menu_name' => __( 'RSJP Jobs' )
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => __( 'job-postings' ) ),
	'menu_icon' => resume_get_plugin_dir( 'go' ) . '/images/icons/jobs-menu-icon.png', 
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => true,
    'menu_position' => 24,
    'supports' => array( 
		'title', 
		'editor', 
		'author', 
		'thumbnail', 
		'excerpt', 
		'comments', 
		'custom-fields', 
		'revisions', 
		'post-formats' ),
	'taxonomies' => array( 
		'category', 
		'post_tag' )
  );
  register_post_type( 'rsjp_job_postings', $args );
}

//add_action( 'init', 'rsjp_job_postings_init' );

// Add archive column to the table
function add_new_rsjp_job_postings_column( $rsjp_columns ) {
	$new_columns['cb'] = '<input type="checkbox" />';
	$new_columns['title'] = _x( 'Title', 'column name' );
	$new_columns['rsjp_archive_posting'] = __( 'Archive' );
	$new_columns['categories'] = __( 'Categories' );
	$new_columns['tags'] = __( 'Tags' );
	$new_columns['date'] = _x( 'Date', 'column name' );

	return $new_columns;
}

add_filter( 'manage_edit-rsjp_job_postings_columns', 'add_new_rsjp_job_postings_column' );

function manage_rsjp_job_postings_columns( $column_name, $id ) {
	global $wpdb;
	switch ( $column_name ) {
		case 'rsjp_archive_posting':
			$archived = $wpdb->get_var( $wpdb->prepare( 'SELECT meta_value FROM ' . $wpdb->postmeta . ' WHERE post_id = "%d" AND meta_key = "%s"', $id, 'rsjp_archive_posting' ) );
			if ( $archived == 1 ){
				echo '<p style="color:#cc0909;">Closed</p>';
			} else {
				echo '<p style="color:#09cc09;">Open</p>';
			}
			break;
		default:
			break;
	}
}

add_action( 'manage_rsjp_job_postings_posts_custom_column', 'manage_rsjp_job_postings_columns', 10, 2 );




// Sort Archive Column
function rsjp_job_postings_column_register_sortable( $columns ) {
    $columns['rsjp_archive_posting'] = 'rsjp_archive_posting'; 
    return $columns;
}
add_filter( 'manage_edit-rsjp_job_postings_sortable_columns', 'rsjp_job_postings_column_register_sortable' );


function rsjp_job_postings_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'rsjp_archive_posting' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'rsjp_archive_posting',
            'orderby' => 'meta_value'
        ) );
    }
 
    return $vars;
}
add_filter( 'request', 'rsjp_job_postings_column_orderby' );


// Remove the Categories and Tags link from the RSJP menu
add_action( 'admin_menu', 'remove_taxonomy_from_rsjp_menu', 999 );
function remove_taxonomy_from_rsjp_menu() {
	$page = remove_submenu_page( 'edit.php?post_type=rsjp_job_postings', 'edit-tags.php?taxonomy=category&amp;post_type=rsjp_job_postings' );
	$page = remove_submenu_page( 'edit.php?post_type=rsjp_job_postings', 'edit-tags.php?taxonomy=post_tag&amp;post_type=rsjp_job_postings' );
}



// Load new meta box
add_action( 'load-post.php', 'rsjp_meta_box_create' );
add_action( 'load-post-new.php', 'rsjp_meta_box_create' );

// Meta box setup function
function rsjp_meta_box_create() {
	add_action( 'add_meta_boxes', 'rsjp_meta_boxes' );
	add_action( 'save_post', 'rsjp_posting_save_meta', 10, 2 );
}

function rsjp_meta_boxes() {
	add_meta_box(
		'rsjp-archive-posting',
		esc_html__( 'Archive Job Posting' ),
		'rsjp_archive_posting_meta_box',		
		'rsjp_job_postings',
		'side',
		'default'
	);
}

// Display the meta box. 
function rsjp_archive_posting_meta_box( $object, $box ) { 
	wp_nonce_field( basename( __FILE__ ), 'rsjp_archive_posting_nonce' ); ?>

	<p>
    	<label for="rsjp-archive-posting"><?php _e( 'Check the following box to archive this job posting.' ); ?></label><br />
        <input type="checkbox" name="rsjp-archive-posting" value="1" <?php if ( get_post_meta( $object->ID, 'rsjp_archive_posting', true ) == 1 ) echo 'checked="checked"';?> /> Archive
	</p>
	<?php 
}

// Save the meta box post metadata
function rsjp_posting_save_meta( $post_id, $post ) {

	if ( !isset( $_POST['rsjp_archive_posting_nonce'] ) || !wp_verify_nonce( $_POST['rsjp_archive_posting_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );

	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	$new_meta_value = ( isset( $_POST['rsjp-archive-posting'] ) ? $_POST['rsjp-archive-posting'] : '0' );
	$meta_key       = 'rsjp_archive_posting';
	$meta_value     = get_post_meta( $post_id, $meta_key, true );
		
	if ( !$meta_value && $meta_value != 0 )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	else
		update_post_meta( $post_id, $meta_key, $new_meta_value );

}


?>