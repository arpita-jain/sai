<?php
/*Plugin Name: Job Posting
Plugin URI: http://www.cisin.com/
Description: Allow Job Posting on site
Author: CIS
Author URI: hhttp://www.cisin.com/
Version: 1.1
*/
//include_once("job_display.php");
include_once("job_post.php");
//include_once("job_detail.php");
include_once("job_listing.php");
//include_once("job_latest.php");
include_once("jobs_multiple.php");
include_once("jobs_post_employer.php");
include_once("job_adminlisting.php");
//include_once("job_apply.php");
add_shortcode("job_display","job_display");
add_shortcode("job_posting","job_posting");
add_shortcode("job_detail","job_detail");
add_shortcode("job_listing","job_listing");
add_shortcode("job_latest","job_latest");
add_shortcode("jobs_multiple","jobs_multiple");
add_shortcode("jobs_post_employer","jobs_post_employer");
add_shortcode("jobs_admincode","jobs_adminfun");
//add_shortcode("job_apply","job_apply");

function job_display(){
 $theme=$_GET['theme'];
	 if($theme=='handheld'){
	//  echo "===";
	  include_once("job_display_mobile.php");
	}else{
	  include_once("job_display.php");
	}
}
function job_latest(){
 $theme=$_GET['theme'];
	 if($theme=='handheld'){
	//  echo "===";
	  include_once("job_latest_mobile.php");
	}else{
	  include_once("job_latest.php");
	}
}

function job_detail(){
     $theme=$_GET['theme'];
	 if($theme=='handheld'){
	// echo "===";
	  include_once("job_detail_mobile.php");
	}else{
	  include_once("job_detail.php");
	}
}

function apply_job_fromuser()
{
     global $wpdb;
     global $current_user;
     $id=$current_user->data->ID;
     $job_id=$_REQUEST['job_id'];
     $applydate=date("Y-m-d");
     $rec=$current_user->data->user_login;
     $sender=$current_user->data->user_login;
     $rec_email=$current_user->data->user_email;
    //echo $q= $wpdb->insert( $wpdb->jobapply, array("user_id" => $id, "job_id" => $job_id,"apply_date" => $applydate ));
      $table_name="wp_jobapply";
      $sql1  = "INSERT INTO `" . $table_name ."` VALUES ('','$id','$job_id','$applydate')";    
      $result1 = $wpdb->query($sql1);
      $user_recepitent_id = $wpdb->get_var("SELECT user_id FROM wp_jobpost where id=$job_id");
      $job_title = $wpdb->get_var("SELECT job_title FROM wp_jobpost where id=$job_id");
      $recevier = $wpdb->get_var( "SELECT user_login FROM $wpdb->users WHERE id = '$user_recepitent_id' LIMIT 1" );
           $retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where id='$job_id'");
	     foreach ($retrieve_data as $retrieved_data){
	      $Jt =  $retrieved_data->job_category;
	       $Jd = $retrieved_data->job_detail;
	       $cont=substr($Jd, 0, 150);
	       $Jl = $retrieved_data->job_location;
	       $Fn = $retrieved_data->file_name;
	       $Jty = $retrieved_data->job_type;
	       $Cn = $retrieved_data->contact;
	       $Pd = $retrieved_data->post_date;
	       $recp= $rec;
	       $recpt=explode(" ",$recp);
	       $pdf=$recpt[0].".pdf";
	       
	      }
	      $attachment_id = $wpdb->get_var("SELECT userid FROM wp_rsjp_submissions where userid='$id'");
	      if(isset($attachment_id))
	      {
	     $content='<span> Job Category:-'.$Jt.'</span><br/>'.'<span>User Name:-'.$rec.'</span><br/><span>Email:-'.$rec_email.'</span><br/><span>Job Detail:-'. $Jd .'</span><br/><span class="downloadbg"><a href="'.site_url().'/wp-content/uploads/rsjp/pdfs/'.$pdf.'">Download CV</a></span>';
	      }
	      else{
	       $content='<span> Job Category:-'.$Jt.'</span><br/>'.'<span>User Name:-'.$rec.'</span><br/><span>Email:-'.$rec_email.'</span><br/><span>Job Detail:-'. $Jd .'</span><br/>';
	      }
	      
	    				$new_message = array(
					'id'        => NULL,
					'subject'   => $subject,
					'content'   => $content,
					'sender'    => $sender,
					'recipient' => $recevier,
					'date'      => current_time( 'mysql' ),
					'read'      => 0,
					'deleted'   => 0
				);
				// insert into database
				if ( $wpdb->insert( $wpdb->prefix . 'pm', $new_message, array( '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d' ) ) )
				{
					$numOK++;
					//unset( $_REQUEST['recipient'], $_REQUEST['subject'], $_REQUEST['content'] );

					// send email to user
					if ( $option['email_enable'] )
					{
						$sender = $wpdb->get_var( "SELECT display_name FROM $wpdb->users WHERE user_login = '$sender' LIMIT 1" );

						// replace tags with values
						$tags = array( '%BLOG_NAME%', '%BLOG_ADDRESS%', '%SENDER%', '%INBOX_URL%' );
						$replacement = array( get_bloginfo( 'name' ), get_bloginfo( 'admin_email' ), $sender, admin_url( 'admin.php?page=rwpm_inbox' ) );

						$email_name = str_replace( $tags, $replacement, $option['email_name'] );
						$email_address = str_replace( $tags, $replacement, $option['email_address'] );
						$email_subject = str_replace( $tags, $replacement, $option['email_subject'] );
						$email_body = str_replace( $tags, $replacement, $option['email_body'] );

						// set default email from name and address if missed
						if ( empty( $email_name ) )
							$email_name = get_bloginfo( 'name' );

						if ( empty( $email_address ) )
							$email_address = get_bloginfo( 'admin_email' );

						$email_subject = strip_tags( $email_subject );
						if ( get_magic_quotes_gpc() )
						{
							$email_subject = stripslashes( $email_subject );
							$email_body = stripslashes( $email_body );
						}
						$email_body = nl2br( $email_body );

						$recipient_email = $wpdb->get_var( "SELECT user_email from $wpdb->users WHERE display_name = '$rec'" );
						$mailtext = "<html><head><title>$email_subject</title></head><body>$email_body</body></html>";

						// set headers to send html email
						$headers = "To: $recipient_email\r\n";
						$headers .= "From: $email_name <$email_address>\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= 'Content-Type: ' . get_bloginfo( 'html_type' ) . '; charset=' . get_bloginfo( 'charset' ) . "\r\n";

						wp_mail( $recipient_email, $email_subject, $mailtext, $headers );
					}
				}
				else
				{
					$numError++;
				}
    
}
add_action('wp_ajax_jobapply_action', 'apply_job_fromuser');
add_action('wp_ajax_nopriv_jobapply_action', 'apply_job_fromuser');

/*Process to create admin menu*/

/*step2*/
add_action('admin_menu','get_menu');
/*step-1*/
function get_menu()
{
    add_menu_page('My Plugin Options', 'Job-post', 'manage_options', 'job-post', 'create_menu');
     //add_menu_page( 'My Plugin Options', 'Demo', 'manage_options', 'demoplugin', 'my_plugin_options2' );
}

/* function step3 */
function create_menu()
{
     if(!current_user_can('manage_options'))
     {
	  wp_die( __ ('You do not have sufficient permission to view this page'));
     }
     do_shortcode('[jobs_admincode]');
}
?>