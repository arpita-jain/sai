<?php
define('ABSPATH', dirname(__FILE__) . '/');
include('pagination.class.php');
//add job post shortcode
function job_display() {
     //print_r($_POST);
?>
<?php if(isset($_POST['search']))
{
	 $searchbox= $_POST['searchbox'];
	 $city= $_POST['city'];
	 }
?>
      <div class="row">
    <div class="twelvecol">
    <div class="build_search_field_main">
<form action="" method="post">
        <div class="build_what_field"> <span>what</span><br>
              <div class="build_input_bg"> <span>
                <!--<input type="text" name="txtEmail" value="job title, keywords or company name">-->
                <input type="text" name="searchbox" value="" placeholder="job title, keywords or company name"/>
                
                </span> </div>
            </div>
        <div class="build_where_field"> <span>where</span><br>
              <div class="build_input_bg"> <span>
                <!--<input type="text" name="txtEmail" value="city or postcode">-->
                <input name="city" value="" placeholder="city or postcode"/>
                
                </span>
            <p><a href="#">Advanced search</a></p>
          </div>
            </div>
        <div class="build_search_button"> <span>
          <input type="submit" name="search" value="Search">
          </span> </div>
</form>      
</div>

	
		  <div class="job_search_field_main">
        <div class="job_search-field"> <span>Search Results</span><br>
              <div class="job_input_bg"> <span>
	     <?php
	     global $wpdb;
	    $retrieve_data = $wpdb->get_results("SELECT count(*) as no_job FROM wp_jobpost where job_title like '%$searchbox%' and job_location like '%$city%'");
	    foreach ($retrieve_data as $retrieved_data){
	      ?>
                <input name="search_result" type="text" value="<?php if((!isset($searchbox))&(!isset($city))){echo "No Search result found";}else{ echo $retrieved_data->no_job; }}?>"/>
		<div class="view-job-btn"><span><a href="<?php echo get_page_link(413); ?>">View All</a></span></div>
                </span> </div>
            </div>
      </div>      
      		
          <div class="sprtr-mid_line"></div>
        </div>
  </div>
<div class="content-left-part">
        	<div class="job-listing-left-area">
		<?php
		
	  $items = mysql_num_rows(mysql_query("SELECT * FROM wp_jobpost;")); // number of total rows in the database
 
	  if($items > 0) {
        $p = new pagination;
        $p->items($items);
        $p->limit(5); // Limit entries per page
        $p->target("http://constructionmates.co.uk/?page_id=413");
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
	      global $wpdb;
	      //$table_name = $wpdb->prefix . "jobpost";
	      $retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where job_title like '%$searchbox%' and job_location like '%$city%' $limit");
?>

        	<div class="job-list-area">
              <h3>Jobs</h3>
	      <?php
	     foreach ($retrieve_data as $retrieved_data){?>
              <div class="job-list-part">
            <div class="job-img-part"><img src="<?php echo 'http://constructionmates.co.uk/wp-content/plugins/job-post/job_image/'.$retrieved_data->file_name;?>" alt=""></div>
            <div class="job-list-txt-plc">
            	<h4><?php echo $retrieved_data->job_title;?></h4>
                <p><?php echo $retrieved_data->job_detail;?></p>
		    <div class="read-more-job-btn"><span><a href="http://constructionmates.co.uk/?p=423 & job=<?php echo $retrieved_data->id; ?>">Read More</a></span> </div>

            </div>
            
          </div>
<?php }         if($items > 0) {  $show = $p->show();} else
	  {
		    $show = "No Record Found";
	  }?> 
            </div>
 		
           </div>
      </div>
<?php     
}
?>