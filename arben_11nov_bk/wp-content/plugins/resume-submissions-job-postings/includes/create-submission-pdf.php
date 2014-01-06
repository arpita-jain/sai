<?php 
require_once( 'fpdf/fpdf.php');
require_once( 'fpdi/fpdi.php');
require_once( 'pdf-functions.php');

 $current_user = wp_get_current_user();
 $saveFile = $current_user->user_login. '.pdf';
$info     = $wpdb->get_row( 'SELECT * FROM ' . SUBTABLE . ' WHERE userid = "' .$current_user->ID . '"' );
$getJobArg = array( 'numberposts'     => 1,
    				'post_type'       => 'rsjp_job_postings',
					'name' => $info->job ); 
$getJob = get_posts( $getJobArg );

// Setup the new pdf
$pdf = new PDF(); 
$pdf->AliasNbPages();
$pdf->AddPage(); 
$pdf->setSourceFile( get_option( 'resume_pdf_base_file' ) ); 
$tplIdx = $pdf->importPage( 1 ); 
$pdf->useTemplate( $tplIdx, 0, 0 ); 
$pdf->SetDisplayMode( 'real' );
$pdf->SetAutoPageBreak( 'on', 20 );
$pdf->SetTitle( 'Resume Submission - ' . $info->fname . ' ' . $info->lname );
$pdf->SetAuthor( get_option( 'blogname' ) );
$pdf->SetSubject( 'Resume Submission' );

$startY  = 35;
$startY2 = 35;

// Start the insert of the information
// Name
$pdf->SetFont( 'Arial' ); 
$pdf->SetFontSize( 24 ); 
$pdf->SetTextColor( 0, 0, 0 ); 
$pdf->SetXY( 0, 10 ); 
$pdf->Cell( 210, 5, $info->fname . ' ' . $info->lname, 0, 1, 'C' );

// For Job
$pdf->SetFont( 'Arial' ); 
$pdf->SetFontSize( 16 ); 
$pdf->SetTextColor( 0, 0, 0 ); 
$pdf->SetXY( 0, 20 );
$pdf->Cell( 210, 5, $getJob[0]->post_title, 0, 1, 'C' );
wp_reset_postdata();

// Submission Date
$pdf->SetFont( 'Arial' ); 
$pdf->SetFontSize( 12 ); 
$pdf->SetTextColor( 0, 0, 0 ); 
$pdf->SetXY( 0, 27 ); 
$pdf->Cell( 210, 5, date( 'F d, Y', strtotime( $info->pubdate ) ), 0, 1, 'C' );

// Address
if ( grabContents( get_option( 'resume_input_fields' ), 'address', 0 ) && $info->address ) {	
	$startY = $startY + 5; 
	$pdf->SetFont( 'Arial' ); 
	$pdf->SetFontSize( 10 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 20, $startY ); 
	$pdf->Cell( 100, 5, $info->address, 0, 1, 'L' );
}

// Suite/Apt #
if ( grabContents( get_option( 'resume_input_fields' ), 'address2', 0 ) && $info->address2 ) {	
	$startY = $startY + 5; 
	$pdf->SetFont( 'Arial' ); 
	$pdf->SetFontSize( 10 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 20, $startY ); 
	$pdf->Cell( 100, 5, $info->address2, 0, 1, 'L' );
}

// City, State, Zip
if ( grabContents( get_option( 'resume_input_fields' ), 'city', 0 ) && $info->city ) {	
	$cityStateZip .= $info->city . ' ';
}
if ( grabContents( get_option( 'resume_input_fields' ), 'state', 0 ) && $info->state ) {	
	$cityStateZip .= $info->state . ', ';
}
if ( grabContents( get_option( 'resume_input_fields' ), 'zip', 0 ) && $info->zip ) {	
	$cityStateZip .= $info->zip;
}
if ( $cityStateZip ){
	$startY = $startY + 5;
	$pdf->SetFont( 'Arial' ); 
	$pdf->SetFontSize( 10 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 20, $startY ); 
	$pdf->Cell( 100, 5, $cityStateZip, 0, 1, 'L' );
}

// Email
if ( grabContents( get_option( 'resume_input_fields' ), 'email', 0 ) && $info->email ) {	
	$startY2 = $startY2 + 5; 
	$pdf->SetFont( 'Arial' ); 
	$pdf->SetFontSize( 10 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 120, $startY2 ); 
	$pdf->Cell( 88, 5, $info->email, 0, 1, 'L' );
}

// Primary Number
if ( grabContents( get_option( 'resume_input_fields' ), 'pnumber', 0 ) && $info->pnumber ) {	
	$startY2 = $startY2 + 5; 
	$pdf->SetFont( 'Arial' ); 
	$pdf->SetFontSize( 10 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 120, $startY2 ); 
	$pdf->Cell( 88, 5, $info->pnumber . ' (' . $info->pnumbertype . ')', 0, 1, 'L' );
}

// Secondary Number
if ( grabContents( get_option( 'resume_input_fields' ), 'snumber', 0 ) && $info->snumber ) {	
	$startY2 = $startY2 + 5; 
	$pdf->SetFont( 'Arial' ); 
	$pdf->SetFontSize( 10 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 120, $startY2 ); 
	$pdf->Cell( 88, 5, $info->snumber . ' (' . $info->snumbertype . ')', 0, 1, 'L' );
}

// Attachments
if ( grabContents( get_option( 'resume_input_fields' ), 'attachment', 0 ) && $info->attachment ) {	
    // Title
	$startY2 = $startY2 + 10; 
	$pdf->SetFont( 'Arial' ); 
	$pdf->SetFontSize( 14 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 120, $startY2 ); 
	$pdf->Cell( 88, 5, 'Attachments', 0, 1, 'L' );
	
	// Display attachments
	$attachments = explode( ',', $info->attachment );
    $attachCount = 1;
    foreach ( $attachments as $attach){
		$startY2 = $startY2 + 5; 
		$pdf->SetFont( 'Arial' ); 
		$pdf->SetFontSize( 10 ); 
		$pdf->SetTextColor( 0, 0, 0 ); 
		$pdf->SetXY( 120, $startY2 ); 
		$pdf->Write( 5, $attachCount . '. ' );
		$pdf->SetTextColor( 0, 0, 255 ); 
		$pdf->Write( 5, $attach, WP_CONTENT_URL . '/uploads/rsjp/attachments/' . $attach );
		$attachCount++;
	}
}

// Cover Letter
if ( grabContents( get_option( 'resume_input_fields' ), 'cover', 0 ) && $info->cover ) {
	$pdf->SetFont( 'Times' ); 
	$pdf->SetFontSize( 10 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 30, 80 );
	$pdf->WriteHTML(  $info->cover );	
}

// Resume
if ( grabContents( get_option( 'resume_input_fields' ), 'resume', 0 ) && $info->resume ) {
	$pdf->SetFont( 'Times' ); 
	$pdf->SetFontSize( 10 ); 
	$pdf->SetTextColor( 0, 0, 0 ); 
	$pdf->SetXY( 30, 80 );
	$pdf->WriteHTML(  $info->resume );
	
}

//$pdf->Output();
$pdf->Output( WP_CONTENT_DIR . '/uploads/rsjp/pdfs/' . $saveFile, 'F' );  
$generatedPDF = WP_CONTENT_DIR . '/uploads/rsjp/pdfs/' . $saveFile;

?>
