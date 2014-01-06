<?php
global $wpdb;

$message     = '';
$ID          = $_GET['id'];
$addNew      = $_POST['addNew'];
$add         = $_POST['add'];
$edit        = $_POST['edit'];
$copy        = $_POST['copy'];
$copyID      = $_GET['copyID'];
$title       = $_POST['title'];
$subTitle    = $_POST['subTitle'];
$description = $_POST['description'];
$archive     = $_POST['archive'];
$pubDate     = date('Y-m-d H:i:s');

$range = 3;
 
// Add New
if ( $add ){

	if ( $archive == '' ){
		$archiveAdd = 0;
	} else {
		$archiveAdd = $archive;
	}
	
	$insertQuery = $wpdb->query( 'INSERT INTO ' . JOBTABLE . ' VALUES(NULL, "' . $title . '",
																	"' . $subTitle . '",
																	"' . $description . '",
																	"' . $archiveAdd . '",
																	"' . $pubDate . '")' );
	if( $insertQuery ){
		$message = '<div class="updated fade" id="message"><p>' . __( 'The job posting' ) . ' &quot;<b>' . $title . '</b>&quot; ' . __( 'was succesfully added.' ) . '</p></div>';
	} else {
		$message = '<div class="error fade" id="message"><p>' . __( 'Sorry, the job posting could not be added. Please try again.' ) . '</p></div>';
	}
	
}

// End Add New


// BOF View/Edit 
if ( $edit ){
	
	if ( $archive == '' ){
		$archiveUpdate = 0;
	} else {
		$archiveUpdate = $archive;
	}
	$updateQuery = $wpdb->query( 'UPDATE ' . JOBTABLE . ' SET title = "' . $title . '",
															  subTitle = "' . $subTitle . '",
															  description = "' . $description . '",
															  archive = "' . $archiveUpdate . '"
															  WHERE id = "' . $ID . '"' );
	if( $updateQuery ){
		$message = '<div class="updated fade" id="message"><p>' . __( 'The job posting was succesfully updated.' ) . '</p></div>';
	} else {
		$message = '<div class="error fade" id="message"><p>' . __( 'Sorry, the job posting could not be updated. Please try again.' ) . '</p></div>';
	}
	
}
// EOF View/Edit 

// Copy Entry
if ( $copyID ){
	
	$copyFrom = $wpdb->get_row( 'SELECT * FROM ' . JOBTABLE . ' WHERE id = "' . $copyID . '"' );
	
	$copyQuery = $wpdb->query( 'INSERT INTO ' . JOBTABLE . ' VALUES(NULL, "' . $copyFrom->title . '",
																	"' . $copyFrom->subTitle . '",
																	"' . $copyFrom->description . '",
																	"' . $copyFrom->archive . '",
																	"' . $pubDate . '")' );
	if( $copyQuery ){
		$copyText = __( 'The job posting was succesfully copied.' );
		$message  = '<div class="updated fade" id="message"><p>' . $copyText . '</p></div>';
	} else {
		$copyText = __( 'Sorry, the job posting could not be copied. Please try again.' );
		$message = '<div class="error fade" id="message"><p>' . $copyText . '</p></div>';
	}
	
}



/* BOF Delete */
$deleteSubmit = $_POST['deleteSubmit'];
$deleteID     = $_POST['deleteID'];

if ( $deleteSubmit ){
	$count = 0;
	$sep = '';
	foreach ( $deleteID as $id ) {
		if ( $count > 0 ) 
			$sep = ',';
    	$deleteIDs .= $sep . $id;
		$count++;
	}
    $deleteQuery = $wpdb->query( 'DELETE FROM ' . JOBTABLE . ' WHERE id IN ( ' . $deleteIDs . ' )' );

    if ( $deleteQuery ){
		$deleteText = __( 'Job posting(s) have been deleted.' );
		$message    = '<div class="updated fade" id="message"><p>' . $deleteText . '</p></div>';
    }
}
/* EOF Delete */
?>


<?php 
if ( $ID ){
	$subName = ' - ' . __( 'View/Edit' );
} elseif ( $addNew ){
	$subName = ' - ' . __( 'Add New' );
} else {
	$subName = '';
}
?>


<div class="wrap alternate">
	
    <div id="icon-rsjp-postings" class="icon32"></div>	
    <h2><?php _e( 'Job Postings' ) . $subName; ?></h2>
    <?php echo $message; ?>
    <br class="a_break" style="clear: both;"/>
    <?php
    if( !isset( $ID ) && !isset( $addNew ) ){
		?>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="left">
                    <form method="post" name="addNew" id="addNew">
                        <input type="submit" name="addNew" value="<?php _e( 'Add New Job Posting' ); ?>" class="button-secondary" />
                    </form>
                </td>
            </tr>
        </table>
		<?php
	} 
	
	// Display job for editing
	if( isset( $ID )){
		$single = $wpdb->get_row( 'SELECT * FROM ' . JOBTABLE . ' WHERE id = "' . $ID . '"' );
		?>
		<form name="back" method="post" enctype="multipart/form-data" action="<?php echo admin_url(); ?>admin.php?page=rsjp-job-postings">
			<input name="back" type="submit" value="<?php _e( 'Back' ); ?>" class="button-secondary" />
		</form>
		<br class="a_break" style="clear: both;"/>
		<form name='form' id='form' class='form' method='POST'>
		<table width="600px" cellpadding="0" cellspacing="0">
			<tr>
				<td width="80px">&nbsp;</td>
				<td></td>
			</tr>
			<tr>
				<td><p><b><?php _e( 'Job Title' ); ?>: </b></p></td>
				<td align="left"><input type='text' name='title' size='30' id='title' value='<?php echo $single->title; ?>' /></td>
			</tr>
			<tr>
				<td><p><b><?php _e( 'Subtitle' ); ?>: </b></p></td>
				<td align="left"><input type='text' name='subTitle' size='25' id='subTitle' value='<?php echo $single->subTitle; ?>' /></td>
			</tr>
			<tr>
				<td valign="top"><p><b><?php _e( 'Copy' ); ?>: </b></p></td>
				<td align="left"><p><?php wp_editor( $single->description, 'description', setTinySetting( 'description', '15', true, true, true ) ); ?></p><br /></td>
			</tr>
		<?php
		if ( $single->archive == 1 ){
			$archiveChecked = 'checked="checked"';
		} else {
			$archiveChecked = '';
		}
		?>
			<tr>
				<td><p><b><?php _e( 'Archive' ); ?>: </b></p></td>
				<td align="left"><input type="checkbox" name="archive" value="1" <?php echo $archiveChecked; ?> /></td>
			</tr>
			<tr>
				<td><input type='hidden' name='edit' value='Edit' /></td>
				<td><p><input type='submit' value='<?php _e( 'Update Job Posting' );?>' name='submit' class="button-primary" /></p></td>
			</tr>
		</table>
		</form>
		<?php
	
	// Add new entry
	} elseif( $addNew ) {
		
		?>
		<form name="back" method="post" enctype="multipart/form-data" action="<?php echo admin_url(); ?>admin.php?page=rsjp-job-postings">
			<input name="back" type="submit" value="<?php _e( 'Back' ); ?>" class="button-secondary" />
		</form>
		<br class="a_break" style="clear: both;"/>
		<form name='form' method='post' enctype="multipart/form-data">
		<table width="600px" cellpadding="0" cellspacing="0">
			<tr>
				<td width="80px">&nbsp;</td>
				<td></td>
			</tr>
			<tr>
				<td><p><b><?php _e( 'Job Title' ); ?>: </b></p></td>
				<td align="left"><input type='text' name='title' size='30' id='title' value='' /></td>
			</tr>
			<tr>
				<td><p><b><?php _e( 'Subtitle' ); ?>: </b></p></td>
				<td align="left"><input type='text' name='subTitle' size='25' id='subTitle' value='' /></td>
			</tr>
			<tr>
				<td valign="top"><p><b><?php _e( 'Description' ); ?>: </b></p></td>
				<td align="left"><p><?php wp_editor( '', 'description', setTinySetting( 'description', '15', true, true, true ) ); ?></p><br /></td>
			</tr>
			<tr>
				<td><p><b><?php _e( 'Archive' ); ?>: </b></p></td>
				<td align="left"><input type="checkbox" name="archive" value="1" /></td>
			</tr>
			<tr>
				<td><input type='hidden' name='add' value='Add' /></td>
				<td><p><input type='submit' value='<?php _e( 'Add Job Posting' ); ?>' name='addJob' class="button-primary" /></p></td>
			</tr>
		</table>
		</form>
		<?php
		
	// Show list of entries
	} else {
	
		$getNum = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . JOBTABLE );
		$numRows = $getNum;
	  
		$rowsPerPage = 10;
		$totalPages = ceil( $numRows / $rowsPerPage );
		
		if ( isset( $_GET['currentPage'] ) && is_numeric( $_GET['currentPage'] ) ) {
		   $currentPage = ( int ) $_GET['currentPage'];
		} else {
		   $currentPage = 1;
		}
		
		if ( $currentPage > $totalPages ) {
		   $currentPage = $totalPages;
		}
		if ( $currentPage < 1 ) {
		   $currentPage = 1;
		} 
		
		$offSet = ( $currentPage - 1 ) * $rowsPerPage;
	  
		$infoQuery = $wpdb->get_results( 'SELECT * FROM ' . JOBTABLE . ' ORDER BY archive ASC, pubDate DESC, title DESC LIMIT ' . $offSet . ', ' .$rowsPerPage );
		?>
        
	  	<form name="deleteEntries" method="post" enctype="multipart/form-data" action="<?php echo admin_url(); ?>admin.php?page=rsjp-job-postings">
		<table class="widefat">
			<thead>
				<tr>
                	<th scope="col" width="20px">&nbsp;</th>
					<th scope="col" width="300px"><?php _e( 'Job Title' ); ?></th>
					<th scope="col" width="300px"><?php _e( 'Post Date' ); ?></th>
					<th scope="col" width="300px"><?php _e( 'Status' ); ?></th>
					<th scope="col">&nbsp;</th>
					<th scope="col">&nbsp;</th>
					<th scope="col">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if ( $getNum > 0 ){
				foreach ( $infoQuery as $info ){
					
					if ( $info->archive == 0 ){
						$isArchived = '<p style="color:#09cc09;">Open</p>';
					} else {
						$isArchived = '<p style="color:#cc0909;">Closed</p>';
					}
				
					?>
					<tr>
                    	<td><input type="checkbox" name="deleteID[]" value="<?php echo $info->id; ?>" /></td>
						<td><p><?php _e( $info->title ); ?></p></td>
						<td><p><?php echo date( 'F j, Y g:ia', strtotime( $info->pubDate ) ); ?></p></td>
						<td><?php echo $isArchived; ?></td>
						<td>&nbsp;</td>
						<td align="right" width="50px">
                        	<input name="view" type="button" value="<?php _e( 'View/Edit' ); ?>" class="button-secondary" onclick="location.href='<?php echo admin_url(); ?>admin.php?page=rsjp-job-postings&id=<?php echo $info->id; ?>'" />
						</td>
						<td align="right" width="50px">
                            <input name="copy" type="button" value="<?php _e( 'Copy' ); ?>" class="button-secondary" onclick="location.href='<?php echo admin_url(); ?>admin.php?page=rsjp-job-postings&copyID=<?php echo $info->id; ?>'" />
						</td>
					</tr>
					<?php
				}
			} else {
				
				?>
				<tr>
                	<td>&nbsp;</td>
					<td><p><?php _e( 'There are no job postings at this time.' ); ?></p></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?php			  
			}
					   
			if ($getNum != '' && $getNum != 0){
				?>
				<div class="tablenav">
					<div class="tablenav-pages">
						<span class="displaying-num">Displaying <?php echo $offset + 1; ?> - <?php echo $offset + count( $infoQuery ); ?> of <?php echo $numRows; ?></span>
					
					
						<?php
						if ( $currentPage > 1 ) {
						   echo ' <a href="' . $_SERVER['PHP_SELF'] . '?page=rsjp-job-postings&currentPage=1">First</a> ';
						   $prevPage = $currentPage - 1;
						   echo ' <a href="' . $_SERVER['PHP_SELF'] . '?page=rsjp-job-postings&currentPage=' . $prevPage . '">«</a> ';
						} 
						
						for ( $x = ( $currentPage - $range ); $x < ( ( $currentPage + $range ) + 1 ); $x++ ) {
						   
						   if ( ( $x > 0 ) && ( $x <= $totalPages ) ) {
							  if ( $x != $currentPage ) {
								 echo ' <a href="' . $_SERVER['PHP_SELF'] . '?page=rsjp-job-postings&currentPage=' . $x . '">' . $x . '</a> ';
							  } 
						   } 
						}
										 
						if ( $currentPage != $totalPages ) {
						   $nextPage = $currentPage + 1;
						   echo ' <a href="' . $_SERVER['PHP_SELF'] . '?page=rsjp-job-postings&currentPage=' . $nextPage . '">»</a> ';
						   echo ' <a href="' . $_SERVER['PHP_SELF'] . '?page=rsjp-job-postings&currentPage=' . $totalPages . '">Last</a> ';
						}
						?>
					</div> 
				</div>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
		if ( $getNum > 0 ){
			?>
				<input type="submit" name="deleteSubmit" value="<?php _e( 'Delete Record(s)' ); ?>" class="button-secondary" onClick="return( confirm( '<?php _e( 'Are you sure you want to delete these entries?' ); ?>' ) )" />
            </form>
			<?php
		}
	}
	?>
</div>