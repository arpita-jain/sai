<?php

function get_KOFThitcounter(){
global $wpdb;
//$loged_id = get_current_user_id( );
$user_id = $_SESSION["rating_aboutname"];
$table_name2 = "wp_traiders_hits";

	
    if ($user_id != "")
		{
		        
			$query = "Select hit from  $table_name2 where user_id = '$user_id'"; 
			$result = mysql_query($query);
			if (!$result) 
			{  
    			die('Invalid query: ' . mysql_error());
			}
			if (mysql_affected_rows()==0)
			{      
				$query = "Insert into $table_name2 (user_id) values ($user_id)";
				$result = mysql_query($query);
				echo " Total Views: 1 ";
				if (!$result) 
				{
    				die('Invalid query: ' . mysql_error());
				}
			}
			else
			{
			         
				$hitcount = mysql_result($result, 0);
				$hitcount++;
				echo  $hitcount;
				$query = "Update $table_name2 set hit = $hitcount where  user_id = '$user_id'";
				$result = mysql_query($query);
				if (!$result) 
				{
    				die('Invalid query: ' . mysql_error());
				}
			}
		}?>
<?php }  ?>
<div style="display: none;">
<?php get_KOFThitcounter();?>
</div>

