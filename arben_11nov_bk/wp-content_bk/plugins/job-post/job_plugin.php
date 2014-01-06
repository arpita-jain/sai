<?php
/*Plugin Name: Job Posting
Plugin URI: http://www.cisin.com/
Description: Allow Job Posting on site
Author: CIS
Author URI: hhttp://www.cisin.com/
Version: 1.1
*/
include_once("job_display.php");
include_once("job_post.php");
add_shortcode("job_display","job_display");
add_shortcode("job_posting","job_posting");
?>