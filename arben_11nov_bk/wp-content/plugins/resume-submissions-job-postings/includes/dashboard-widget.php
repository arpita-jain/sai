<?php
global $wpdb;

$entries = $wpdb->get_results( 'SELECT * FROM ' . SUBTABLE . ' ORDER BY pubdate DESC, lname DESC, fname DESC LIMIT 5' );

?>
<table width="100%" cellspacing="0" class="widefat">
	<?php
    
foreach ( $entries as $entry ) {
	$getJobArg = array( 'numberposts'     => 1,
						'post_type'       => 'rsjp_job_postings',
						'name' => $entry->job ); 
	$getJob = get_posts( $getJobArg );
	?>
    <tr class="alternate">
    	<td><p><a href="admin.php?page=rsjp-submissions&id=<?php echo $entry->id; ?>"><?php echo $entry->fname . ' ' . $entry->lname; ?></a> - <?php echo date( 'F j, Y g:ia', strtotime( $entry->pubdate ) ); ?></p></td>
        <td><p><?php echo $getJob[0]->post_title; ?></p></td>
    <?php
}

if ( !$entries ){
	?>
    <tr>
    	<td><p><i><?php _e( 'There are no submissions at this time' ); ?></i></p></td>
    </tr>
    <?php	
}
?>
</table>