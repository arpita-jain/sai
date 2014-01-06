<?php
session_start();

if($_POST)
{
require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
$user = wp_get_current_user();
$userid = $user->ID;
$aboutuser = $_SESSION["rating_aboutname"];
$tbl_name = $wpdb->prefix.'rating';
$id=$_POST['id'];
if($id)
{
    $query ="UPDATE `".$tbl_name."` SET comment = '".$_POST['comment']."', rating = '".$_POST['finalrating']."'  WHERE id =".$id;
    $wpdb->query($query);
}
else
{
    $data = array('rating'=>$_POST['finalrating'],'comment'=>$_POST['comment'],'fromuser'=>$userid,'aboutuser'=>$aboutuser);
    $row_affected =$wpdb->insert($tbl_name,$data);
}

wp_redirect($_POST['returnurl']);
}