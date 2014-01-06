<?php
function jobs_adminfun()
{
include_once(ABSPATH.'wp-content/plugins/job-post/pagination.class.php');
?>
<div>
    <h3>Job-Post Listing</h3>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo site_url().'/wp-content/themes/constructionmates/css/default.css'; ?>" />   
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
  
	 $(document).ready(function(){
            url = $("#url").val();
                $(".page_class").click(function(){
		 // alert(this.title);
		  owntitle = this.title;
		  window.location = url+'&paging='+owntitle;
                 });
		 //for next button
		 $('.next').click(function(){
		    owntitle = this.title;
		    window.location = url+'&paging='+owntitle;
		    
		    });
		 
		 $('.prev').click(function(){
		    owntitle = this.title;
		   window.location = url+'&paging='+owntitle;
		    
		    });
		 
		  });
</script>
<style>
    .list_table tr td
    {
        padding: 10px;
    }
</style>
<?php
global $wpdb;
$query = "select * from ".$wpdb->prefix."jobpost order by id desc";
$postdata = $wpdb->get_results($query);
//print_r($postdata);
 $items = count($postdata); // number of total rows in the database
if($items > 0) {
    echo "===========";
$p = new pagination;

$p->items($items);
        $p->limit(10); // Limit entries per page
        $p->target(site_url()."?page_id=15");
        $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
        $p->calculate(); // Calculates what to show
        $p->parameterName('paging');
        $p->adjacents(1); //No. of page away from the current page
 
        if(!isset($_GET['paging'])) {
	    $p->page = 0;
            $p->page = 1;
	  }
	 else
	  {
            $p->page = $_GET['paging'];
	  }
 
        //Query for limit paging
        $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
     //   $show = $p->show();
        
	  }
	  else
	  {
		    $show = "No Record Found";
	  }
$query = "select * from ".$wpdb->prefix."jobpost order by id desc ".$limit;
$postdata = $wpdb->get_results($query);
?>
<table width="100%" class="list_table">
    <tr>
       
        <th>Job-id</th>
        <th>Job-category</th>
        <th>Job-type</th>
        <th>Job-location</th>
        <th>Posted by</th>
        <th>Post-date</th>
        <th>Status</th>
    </tr>
<?php
$i=1;
foreach($postdata as $data)
{
    if($data->published)
    {
        $imgname = "tick.png";
    }
    else
    {
        $imgname = "publish_x.png";
    }
    $path = 'update.php?task=updateadmin&id='.$data->id;
    if($_GET['paging'])
    {
        $path = 'update.php?task=updateadmin&paging='.$_GET["paging"].'&id='.$data->id;
    }
 ?>
 <tr>
    
    <td align="center"><?php echo $data->id;; ?></td>
    <td align="center"><?php echo $data->job_category; ?></td>
    <td align="center"><?php echo $data->job_type; ?></td>
    <td align="center"><?php echo $data->job_location; ?></td>
    <td align="center"><?php echo get_userdata($data->user_id)->user_login; ?></td>
    <td align="center"><?php echo $data->post_date; ?></td>
    <td align="center"><a href="<?php echo plugins_url($path,__FILE__);?>"><img src="<?php echo site_url().'/wp-content/plugins/job-post/images/statusimg/'.$imgname;?>" /></a></td>

 </tr>
 <?php
 $i++;
}
?>
</table>
<input type="hidden" id="url" value="<?php echo site_url().'/wp-admin/admin.php?page=job-post'?>" />
<?php 
if($items > 0) {  $show = $p->show();} else
	  {
		   echo $show = "No Record Found";
	  }?> 
</div>
<?php
 }
 
?>