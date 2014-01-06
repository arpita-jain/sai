<?php
include_once(ABSPATH.'wp-content/plugins/job-post/pagination.class.php');
//error_reporting('E_ALL');
//ini_set('display_errors',1);
global $current_user;
if($current_user->data->user_login){
$user=$current_user->data->user_login;
}
$searchbox= $_POST['searchbox'];
$city= $_POST['city'];
global $wpdb;
if($searchbox || $city)
	     {
		  $condition = "";
		  $condition2 = "";
		  if($searchbox)
		  {
			   
		  $condition="and ( b.meta_key='first_name' and b.meta_value like '%$searchbox%' OR b.meta_key='accreditations' and b.meta_value like '%$searchbox%' OR b.meta_key='trades_name' and b.meta_value like '%$searchbox%' OR b.meta_key='skill' and b.meta_value like '%$searchbox%' )";
		  }
		  if($city)
		  {
			   
		  $condition2 = " and ( c.meta_key='city' and c.meta_value like '%$city%' OR c.meta_key='post_code' and c.meta_value like '%$city%' )";
		  }
	     $q1 = "SELECT  distinct a.user_id FROM wp_usermeta as a JOIN wp_usermeta as b JOIN wp_usermeta as c  ON a.meta_key='usertype' and a.user_id=b.user_id and b.user_id = c.user_id and a.meta_value='2'  $condition  $condition2 order by user_id desc $limit";
	     }
	     
	     else
	     {
		  $q1 = "SELECT * FROM wp_usermeta where meta_key='usertype' and meta_value='2' order by user_id desc $limit";
	     }
	      $retrieve_data = $wpdb->get_results($q1);
	  $items = count($retrieve_data); // number of total rows in the database
 
	  if($items > 0) {
        $p = new pagination;
        $p->items($items);
        $p->limit(10); // Limit entries per page
        $p->target(site_url()."?page_id=13");
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
	      
	      
?>
<script type="text/javascript">
	 $(document).ready(function(){
	  pageid=13;
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
	
	     //$retrieve_data = $wpdb->get_results("SELECT * FROM wp_usermeta where meta_key='usertype' and meta_value='2' order by user_id desc $limit");
	     if($searchbox || $city)
	     {
		  $condition = "";
		  $condition2 = "";
		  if($searchbox)
		  {
			   
		  $condition="and ( b.meta_key='first_name' and b.meta_value like '%$searchbox%' OR b.meta_key='accreditations' and b.meta_value like '%$searchbox%' OR b.meta_key='trades_name' and b.meta_value like '%$searchbox%' OR b.meta_key='skill' and b.meta_value like '%$searchbox%' )";
		  }
		  if($city)
		  {
			   
		  $condition2 = " and ( c.meta_key='city' and c.meta_value like '%$city%' OR c.meta_key='post_code' and c.meta_value like '%$city%' )";
		  }
	     $q1 = "SELECT  distinct a.user_id FROM wp_usermeta as a JOIN wp_usermeta as b JOIN wp_usermeta as c  ON a.meta_key='usertype' and a.user_id=b.user_id and b.user_id = c.user_id and a.meta_value='2'  $condition  $condition2 order by user_id desc $limit";
	     }
	     
	     else
	     {
		  $q1 = "SELECT * FROM wp_usermeta where meta_key='usertype' and meta_value='2' order by user_id desc $limit";
	     }
	      $retrieve_data = $wpdb->get_results($q1);
	  
?>
<div class="row">
    <div class="twelvecol">
   <form action="<?php echo site_url().'?page_id=13'?>" method="post" name="searchform" id="searchform">
    <div class="build_search_field_main">
	 
	 <div class="build_what_field"> <span>what</span><br>
              <div class="build_input_bg"> <span>
                <!--<input type="text" name="txtEmail" value="job title, keywords or company name">-->
                <input type="text" name="searchbox" value="<?php echo $searchbox;?>" placeholder="name, category, accreditations, skill "/>
                </span>
	      </div>
            </div>
        <div class="build_where_field"> <span>where</span><br>
              <div class="build_input_bg"> <span>
                <!--<input type="text" name="txtEmail" value="city or postcode">-->
                <input name="city" value="<?php echo $city; ?>" placeholder="city or postcode"/>
                </span>
            <p><a href="javascript:void(0)" onclick="document.getElementById('searchform').submit();"><!--Advanced search--></a></p>
          </div>
            </div>
        <div class="build_search_button"> <span>
          <input type="submit" name="search" value="Search">
          </span>
	</div>
    
 </div>      <?php echo do_shortcode( "[featslider]" ); ?>
		 <!-- <div class="job_search_field_main">
			   <div class="job_search-field"> <span>Search Results</span><br>
			<div class="job_input_bg"> <span>
		    
			   <input readonly="readonly" name="search_result" type="text" value="<?php //if($searchbox && $items){ echo $items;}else {echo "No Search result found";}?>"/>
			   
			   <div class="view-job-btn"><span><a href="<?php //echo get_page_link(13); ?>">View All</a></span></div>
			   </span> </div>
		       </div>
		 </div> -->   
      		
          <div class="sprtr-mid_line"></div>
	  </form>
        </div>
  </div>
<div class="content-left-part">
	 
        	<div fullclass="job-listing-left-area">
		

        	<div class="job-list-area">
              <h3>Traders</h3>
	       <div class="search_newBox">
			<div class="job_input_bg"> <span>
		    
			   <input name="search_result" readonly="readonly" type="text" value="<?php if($searchbox && $items){ echo $items;}else {echo "No Search result found";}?>"/>
			   
			   <div class="view-job-btn"><span><a href="<?php echo get_page_link(11); ?>">View All</a></span></div>
			   </span> </div>
	      </div>
	     <?php foreach ($retrieve_data as $retrieved_data){
		  $id= $retrieved_data->user_id;
		  $all_meta_for_user = get_user_meta($id);?>
              <div class="job-list-part">
              <?php preg_match("/src='(.*?)'/i",get_avatar($id,150), $matches);
		  $a=explode('=',$matches[0]);
		  $a1=explode("'",$a[1]);?>
	      <div class="job-img-part"><img src="<?php echo $a1[1];?>" alt=""></div>
            <div class="job-list-txt-plc">
            	<h5><?php echo $all_meta_for_user['first_name'][0];echo "&nbsp";echo $all_meta_for_user['last_name'][0];?></h5>
                <p><?php echo $all_meta_for_user['about_company'][0];?></p>
				<?php
		$accred=$all_meta_for_user['accreditations'][0];
		$ac1=explode(",",$accred);
		 ?>
		<div class="acrdtn-smal-btn-area">
		   <div class="acrdtn-smal-btn"><span><p><?php if(isset($accred)) {echo $ac1[0];}else{echo "CSCS";} ?></p></span> </div>
		  <div class="acrdtn-smal-btn"><span><p><?php if(isset($accred)){ echo $ac1[1];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></p></span> </div>
		  <div class="acrdtn-smal-btn"><span><p><?php if(isset($accred)){ echo $ac1[2];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></p></span> </div>
		  <div class="acrdtn-smal-btn"><span><p><?php if(isset($accred)){echo $ac1[3];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></p></span> </div>
		  <div class="acrdtn-smal-btn"><span><p><?php if(isset($accred)){echo $ac1[4];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></p></span> </div>
		  <div class="acrdtn-smal-btn"><span><p><?php if(isset($accred)){echo $ac1[5];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></p></span> </div>
		  </div>
		 <div class="read-more-job-btn"><span><a href="<?php echo site_url();?>?page_id=710&id=<?php echo $id;?>">Read More</a></span> </div>
	    </div>
          </div>
<?php }
if($items > 0) {  $show = $p->show();} else
	  {
		    $show = "No Record Found";
	  }
	  
	  ?> 
            </div>
 		
           </div>
</div>