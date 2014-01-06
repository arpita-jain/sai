<?php
define('ABSPATH', dirname(__FILE__) . '/');
//echo ABSPATH.'wp-content/plugins/job-post/'
include_once(ABSPATH.'wp-content/plugins/job-post/pagination.class.php');
// job list display shortcode
global $current_user;
	    if($current_user->data->user_login){
	    $user=$current_user->data->user_login;
	    $user_id=$current_user->data->ID;
	     $all_meta_for_user = get_user_meta( $user_id );
	    $user_type=$all_meta_for_user['usertype'][0];
	    }
?>
<script type="text/javascript">
	 $(document).ready(function(){
	  pageid=15;
		 $(".page_class").click(function(){
		 // alert(this.title);
		  owntitle = this.title;
		  $("#searchform").attr('action','http://constructionmates.co.uk/?page_id='+pageid+'&paging='+owntitle);
		  $("#searchform").submit();
		  });
		 
		 //for next button
		 $('.next').click(function(){
		    owntitle = this.title;
		    $("#searchform").attr('action','http://constructionmates.co.uk/?page_id='+pageid+'&paging='+owntitle);
		    $("#searchform").submit();
		    
		    });
		 
		 $('.prev').click(function(){
		    owntitle = this.title;
		    $("#searchform").attr('action','http://constructionmates.co.uk/?page_id='+pageid+'&paging='+owntitle);
		    $("#searchform").submit();
		    
		    });
		 
		  });
</script>
<?php
	 $searchbox= $_POST['searchbox'];
	 $city= $_POST['city'];
	 global $wpdb;
		  $where = "";
		  $condition =array();
		  if($searchbox)
		  {
			   $condition[] = "(job_type like '%$searchbox%' OR job_category like '%$searchbox%')";
		  }
		  if($city)
		  {
			   $condition[] = "(job_location like '%$city%' OR post_code like '%$city%')";
		  }
		  $condition=implode(" and ",$condition);
		  if($condition)
		  $where ="where ".$condition." and published='1'";
		  else
		  $where ="where published='1'";
		  $query="SELECT * FROM ".$wpdb->prefix."jobpost ". $where." order by id desc";
		  
	 //echo $query;
	 $retrieve_data = $wpdb->get_results($query);

	 $items = count($retrieve_data); // number of total rows in the database
	  if($items > 0) {
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
	     
	      //$table_name = $wpdb->prefix . "jobpost";
	$query="SELECT * FROM ".$wpdb->prefix."jobpost ". $where." order by id desc ".$limit;
	$retrieve_data = $wpdb->get_results($query);
?>
<div class="row">
<div class="twelvecol">
<div class="build_search_field_main">
<form action="<?php echo site_url().'?page_id=15'?>" method="post" name="searchform" id="searchform">
        <div class="build_what_field"> <span>what</span><br>
              <div class="build_input_bg">
		  <span>
		  <!--<input type="text" name="txtEmail" value="job title, keywords or company name">-->
		  <input type="text" name="searchbox" value="<?php echo $searchbox; ?>" placeholder="job type, job category "/>
		  </span>
	      </div>
         </div>
        <div class="build_where_field"> <span>where</span><br>
              <div class="build_input_bg">
		  <span>
			   <!--<input type="text" name="txtEmail" value="city or postcode">-->
			   <input name="city" value="<?php echo $city; ?>" placeholder="city or postcode"/>
                
		  </span>
		   <p><a onclick="document.getElementById('searchform').submit();" href="javascript:void(0)"></a></p>
            </div>
         </div>
        <div class="build_search_button">
	 <span>
          <input type="submit" name="search" value="Search">
         </span>
	</div>
</form>      
</div> <?php echo do_shortcode( "[featslider]" ); ?>
	<!--	  <div class="job_search_field_main">
        <div class="job_search-field"> <span>Search Results</span><br>
              <div class="job_input_bg"> <span>
	      <input name="search_result" readonly="readonly" type="text" value="<?php //if((!isset($searchbox))&(!isset($city))){echo "No Search result found";}else{ echo $items; }?>"/>
		<div class="view-job-btn"><span><a href="<?php //echo get_page_link(15); ?>">View All</a></span></div>
                </span> </div>
            </div>
      </div> -->     
      		
          <div class="sprtr-mid_line"></div>
        </div>
  </div>
<div class="content-left-part">
        	<div fullclass="job-listing-left-area">
		<div class="job-list-area">
              <h3>Jobs</h3>
	      <div class="search_newBox">
			<div class="job_input_bg"> <span>
	      <input name="search_result" readonly="readonly" type="text" value="<?php if((!isset($searchbox))&(!isset($city))){echo "No Search result found";}else{ echo $items; }?>"/>
		<div class="view-job-btn"><span><a href="<?php echo get_page_link(15); ?>">View All</a></span></div>
                </span> </div>
	      </div>
	      <?php foreach ($retrieve_data as $retrieved_data){
			 preg_match("/src='(.*?)'/i",get_avatar($retrieved_data->user_id,150), $matches);
			  //echo $matches[0];
			  $a=explode('=',$matches[0]);
			  $a1=explode("'",$a[1]);
		         $image_name=(explode("/",$a1[1]));
			$image=$retrieved_data->file_name;
			if(!$retrieved_data->file_name)
			{
			$image = "jobslogo.png";
			}
			?>
              <div class="job-list-part">
            <div class="job-img-part"><img src="<?php echo $a1[1];?>" alt=""></div>
            <div class="job-list-txt-plc">
	    <?php $job_detail=$retrieved_data->job_detail;
		$cont=substr($job_detail, 0, 150);?>
            	<h5><?php echo $retrieved_data->job_type;?></h5>
                <p><?php echo $cont;?></p>
		<?php if($user_type==2 || $user_type==3 )
		{
		if($user=="")
		 {?>
		  <div class="read-more-job-btn"><span><a href="<?php echo site_url();?>?page_id=330">Read More</a></span></div>
		<?php } else {?>
		    <div class="read-more-job-btn"><span><a href="<?php echo site_url();?>?page_id=509&job=<?php echo $retrieved_data->id; ?>">Read More</a></span> </div>
<?php }
		}?>
            </div>
            
          </div>
<?php }         if($items > 0) {  $show = $p->show();} else
	  {
		   echo $show = "No Record Found";
	  }?> 
            </div>
 		
           </div>
      </div>