<?php
require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
$task = $_REQUEST['task'];

global $wpdb;
$pathredirect = site_url().'/wp-admin/admin.php?page=job-post';
if($_REQUEST['paging'])
{
   $pathredirect = site_url().'/wp-admin/admin.php?page=job-post&paging='.$_REQUEST["paging"]; 
}
$id=$_REQUEST['id'];
if($id)
{
$query="update ".$wpdb->prefix. "jobpost set published=published XOR 1 where id=".$id;
$affedtedrow= $wpdb->query($query);
wp_redirect($pathredirect,301);
}
