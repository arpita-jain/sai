<?php
// global $wpdb;
if($_POST['id'])
{
$id=$_POST['id'];
global $wpdb;
$retrieve_data = $wpdb->get_results("SELECT * from wp_jobtype where `category_id`='$id'");
foreach ($retrieve_data as $retrieved_data){
echo '<option value="'.$retrieved_data->type.'">'.$retrieved_data->type.'</option>';
}
}

?>