<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="myform">     
<select name="hitcount" onchange="myform.submit();" style="margin-top: 30px;">
   <option <?php if ($_POST['hitcount'] == 'builder') { ?>selected="true" <?php }; ?>value="builders">Builder</option>
   <option <?php if ($_POST['hitcount'] == 'trader') { ?>selected="true" <?php }; ?>value="trader">Trader</option>
</select>
	 <?php
	 global $wpdb;
	 if(isset($_POST['hitcount'])){
	      if($_POST['hitcount']=="trader"){
	 $table_name2 = "wp_traiders_hits";
	 }
	 else{$table_name2 = "wp_builders_hits";
	      }?>
	 <h1 style="color:#21759B;"><?php echo $_POST['hitcount'].' List'; ?></h1>
          <?php $name=$_POST['hitcount'];
	  }
	  
	 else{$table_name2 = "wp_builders_hits";
	  ?>
	 <h1 style="color:#21759B;">Builder List</h1>
	 <?php $name="Builder";
	       }
	       /*pagination*/?>
	        <style>
       .pagination{
        float:left;
        
       }
        </style>
	     <?php
        $items = $wpdb->get_results("SELECT * FROM $table_name2");
	$items = count($items);
	if($items > 0) {
        $p = new pagination;
        $p->items($items);
        $p->limit(10); // Limit entries per page
        $p->target("admin.php?page=profilecounter/profilecounter.php");
        $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
        $p->calculate(); // Calculates what to show
        $p->parameterName('paging');
        $p->adjacents(1); //No. of page away from the current page

        if(!isset($_GET['paging'])) {
            $p->page = 1;
        } else {
            $p->page = $_GET['paging'];
        }
 
        //Query for limit paging
        $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
        $show = $p->show();
        
} else {
    $show = "No Record Found";
}
// end pagination

	      $KOFTdrafts = $wpdb->get_results("SELECT * FROM $table_name2  ORDER BY hit DESC"); ?>
	      <table align="center" border="1" width="40%" style="float: left;"><tr>
	      <td width="25%"><b><?php echo $name; ?></b></td><td width="75%"><b>Hits count</b></td></tr>
	      <?php
	      foreach($KOFTdrafts as $value)
	       {
		  $userid = $value->user_id;
		  $result = $wpdb->get_results("SELECT user_login FROM wp_users where ID = $userid");?>
		   <tr>
	          
		  <td width="75%"><?php echo $result[0]->user_login;?></td>
		  <td width="25%"><?php echo $value->hit;?></td>
		  </tr>
		  <?php
		  }?>
		  </table>
	   </form>        
