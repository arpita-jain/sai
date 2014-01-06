<?php
include('wp-config.php');
//include('wp-includes/user.php');
 $username=$_POST["username"];
 $usertype=$_POST["usertype"];
 
if($usertype==""){
	if($username!=""){ echo "if";
		if(username_exists( $username )){
			echo $user_id=username_exists( $username );
			
		}else{
			echo 0;
		}
		}
}else{
if($username!=""){
		if(username_exists( $username )){
			   $user_id=username_exists( $username );
			 $all_meta_for_user = get_user_meta($user_id);
			 $all_meta_for_user['usertype'][0];
			if($all_meta_for_user['usertype'][0]==2 || $all_meta_for_user['usertype'][0]==3)
                       {	                
                        echo 'url='.site_url('/?page_id=442&usertype='.$all_meta_for_user['usertype'][0]);
			}    
			else if($all_meta_for_user['usertype'][0]==1 || $all_meta_for_user['usertype'][0]==4){
                        echo 'url='.site_url('/?page_id=487&usertype='.$all_meta_for_user['usertype'][0]);}
			else if($user_id==1){
                        echo 'url='.site_url('/wp-login.php');}
}else{
echo 0;
}
}
}

//Username exist validation
$uname=$_POST['user_id'];
$uemail=$_POST['user_email'];
$sql = "SELECT * FROM wp_users where user_login = '$uname'";
$rows=mysql_query($sql);
//$res will hold count of result
$res=mysql_num_rows($rows);
if($res>0){
 
  echo "This user is already exist";
}
$sql1 = "SELECT * FROM wp_users where user_email = '$uemail'";
$rows1=mysql_query($sql1);
//$res will hold count of result
$res1=mysql_num_rows($rows1);
if($res1>0){
  echo "This email address is already exist";
}
//Select Category in admin
$category_id=$_POST['cat'];
$retrieve_data = $wpdb->get_results("select * from wp_faq_content where category='$category' "); 
       foreach($retrieve_data as $retrieved_data){
	$ques=$retrieved_data->question;
       }
       
       //For Checking of CV attachment
       $uid=$_POST['u_id'];
       if(isset($uid))
       {
       $retrieve_data3 = $wpdb->get_results("select * from wp_rsjp_submissions where userid='$uid' ");
     
	//$user_id_chk=$retrieve_data3[0]->userid;
	if($retrieve_data3[0]->userid)
	{
	echo "Your CV has been attached";
	}
	else
	{
		echo "Your CV is not available please create a CV";
	}
       }
?>