<?php 
if( $archive == 'Show' ) 
	$compare = '<=';
else 
	$compare = 'NOT LIKE';
	
$getJobsArg = array( 'post_type'   => 'rsjp_job_postings',
					 'orderby'     => $order_by,
					 'order'       => $order,
					 'numberposts' => $limit,
					 'meta_query'  => array(
										  array( 'key' => 'rsjp_archive_posting',
											     'value' => 1,
											     'compare' => $compare
										   ) ) ); 
$jobs = get_posts( $getJobsArg );
?>

<div id="jobPostings">
	<?php 

	
	foreach( $jobs as $job ) :	setup_postdata( $job );
		?>
        <article id="post-<?php echo $job->ID; ?>" class="post-<?php echo $job->ID; ?> format-standard  rsjp_job_postings type-rsjp_job_postings status-publish">
            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php echo get_permalink( $job->ID ); ?>" title="<?php echo $job->post_title; ?>"><?php echo $job->post_title; ?></a></h2>
            </header>
            <div class="entry-content">
                <i><?php echo date_i18n( get_option( 'date_format' ), strtotime( $job->post_date ) ); ?></i>
                <?php echo $job->post_excerpt; ?>
            </div>
        </article>
		<?php
	endforeach;
	
	// Reset Post Data
	wp_reset_postdata();
	
	
	?>
</div>