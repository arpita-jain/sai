<?php
include('wp-config.php');
// global $wpdb;
if($_POST['id1'])
{
$id=$_POST['id1'];
global $wpdb;
$tbl_1=$wpdb->prefix.'jobcategory';
$tbl_2=$wpdb->prefix.'jobtype';
$query= "SELECT a.* from $tbl_1 as b join $tbl_2 as a  on  b.`category`= '".$id. "' and b.id=a.category_id";
$retrieve_data = $wpdb->get_results($query);
foreach ($retrieve_data as $retrieved_data){
echo '<option value="'.$retrieved_data->type.'">'.$retrieved_data->type.'</option>';
}
}

?>
