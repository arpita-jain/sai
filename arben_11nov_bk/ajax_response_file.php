<?php
include('wp-config.php');
//include('wp-includes/user.php');
global $wpdb;
 $category_id=$_POST['cat'];
$retrieve_data = $wpdb->get_results("select * from wp_faq_content where Faq_id = '$category_id'"); 
       foreach($retrieve_data as $retrieved_data){
	echo $retrieved_data->question;
}

//for checking doc file attachment for builder and trader
       $us_id=$_POST['us_id'];
       $chk_status=$_POST['check_status'];
       //$table_name ="wp_mydoc";
//       $data = array('check_status'=>$chk_status);
//	 $where = array('userid'=>$us_id);
//	//print_r($data);
//	 $row_affected =$wpdb->update($table_name,$data,$where);
        $retrieved_data_id = $wpdb->get_results("select * from wp_mydoc where userid='$us_id'");
	//$user_id_chk=$retrieve_data3[0]->userid;
	if( $retrieved_data_id[0]->userid)
	{
	echo "Your file has been attached";
	}
	else
	{
		echo "Your file is not available please upload a file";
	}
?>