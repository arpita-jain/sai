<?php
//include_once(ABSPATH.'wp-content/plugins/join-network/pagination.class.php');
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
	     $q1 = "SELECT  distinct a.user_id FROM wp_usermeta as a JOIN wp_usermeta as b JOIN wp_usermeta as c  ON a.meta_key='usertype' and a.user_id=b.user_id and b.user_id = c.user_id and ( a.meta_value='2' || a.meta_value='3' )  $condition  $condition2 order by user_id desc $limit";
	     }
	     
	     else
	     {
		  $q1 = "SELECT * FROM wp_usermeta where meta_key='usertype' and ( meta_value='2' || meta_value='3' ) order by user_id desc $limit";
	     }
	      $retrieve_data = $wpdb->get_results($q1);
	  $items = count($retrieve_data); // number of total rows in the database
 
	  if($items > 0) {
        $p = new pagination;
        $p->items($items);
        $p->limit(10); // Limit entries per page
        $p->target(site_url()."?page_id=1359&theme=handheld");
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
	  pageid=1359;
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
	     $q1 = "SELECT  distinct a.user_id FROM wp_usermeta as a JOIN wp_usermeta as b JOIN wp_usermeta as c  ON a.meta_key='usertype' and a.user_id=b.user_id and b.user_id = c.user_id and ( a.meta_value='2' || a.meta_value='3' )  $condition  $condition2 order by user_id desc $limit";
	     }
	     
	     else
	     {
		  $q1 = "SELECT * FROM wp_usermeta where meta_key='usertype' and ( meta_value='2' || meta_value='3' ) order by user_id desc $limit";
	     }
	      $retrieve_data = $wpdb->get_results($q1);
              //    echo '<pre>';
              //print_r($retrieve_data);die;
	  
?>
<div class="tabs_search">
 <div class="build_search_field_main">
	  <form action="<?php echo site_url().'?page_id=1359&theme=handheld'?>" method="post" name="searchform" id="searchform">
	      <!-- <div class="build_search_field_main">
	       
		    <!--<div class="build_what_field"> <span>what</span><br>
		    <div class="build_input_bg"> <span>
		    <!--<input type="text" name="txtEmail" value="job title, keywords or company name">-->
		    <!--<input  type="text" name="searchbox" value="<?php //echo $searchbox;?>" placeholder="name, category, accreditations, skill "/>
		    </span>
		    </div>
		    </div>--->
		    
		    <!--<div class="build_where_field"> <span>where</span><br>
		    <div class="build_input_bg"> <span>
		    <!--<input type="text" name="txtEmail" value="city or postcode">-->
		    <!--<input name="city" value="<?php //echo $city; ?>" placeholder="city or postcode"/>
		    </span>
		    <p><a href="javascript:void(0)" onclick="document.getElementById('searchform').submit();">Advanced search</a></p>
		    </div>
		    </div>-->
		    
		    <!--<div class="build_search_button"> <span>
		    <input type="submit" name="search" value="Search">
		    </span>
		    </div> </div>-->
	       
	<!--	  <div class="job_search_field_main">
			   <div class="job_search-field"> <span>Search Results</span><br>
			      <div class="job_input_bg"> <span>
			  
				 <input readonly="readonly" name="search_result" type="text" value="<?php if($searchbox && $items){ echo $items;}else {echo "No Search result found";}?>"/>
				
				 <div class="view-job-btn"><span><a href="<?php echo site_url().'?page_id=1359&theme=handheld'?>">View All</a></span></div>
				 </span>
			      </div>
			   </div>
		    </div>-->
		     <div class="search_res">

  
       <input name="textfield2" type="text" id="textfield2" value="<?php if($searchbox && $items){ echo $items;}else {echo "No Search result found";}?>" placeholder="No Search result found">
    <input type="submit" name="button3" id="button3" value="View All">
  </div>
	  </form>
 <h1 class="traders">Results</h1>
   
<ul class="tab_2list">
              <?php foreach ($retrieve_data as $retrieved_data){
		  $id= $retrieved_data->user_id;
		  $all_meta_for_user = get_user_meta($id);?>
            <li><div class="more_btn"><a href="<?php echo site_url();?>?page_id=702&id=<?php echo $id;?>&theme=handheld"><img src="<?php echo site_url();?>/wp-content/themes/constructionmatesss_mob/images/more.png" alt="more"></a></div>
              <?php preg_match("/src='(.*?)'/i",get_avatar($id,150), $matches);
		  $a=explode('=',$matches[0]);
		  $a1=explode("'",$a[1]);
		  $about_company=$all_meta_for_user['about_company'][0];
		$cont=substr($about_company, 0, 150);?>
            <img class="img_profile" src="<?php echo $a1[1];?>" >
            <div class="span2">
            <h3><?php echo $all_meta_for_user['first_name'][0];echo "&nbsp";echo $all_meta_for_user['last_name'][0];?></h3>
          <span class="top_s"><?php echo $cont;?></span>
            </div>
	    <?php
		$accred=$all_meta_for_user['accreditations'][0];
		$ac1=explode(",",$accred);
?>
	    <div class="clear-both"></div><div class="csc_btn_box">
        <ul>
          <li><a href="#"><?php if(isset($accred)) {echo $ac1[0];}else{echo "CSCS";} ?></a></li>
          <li><a href="#"><?php if(isset($accred)){ echo $ac1[1];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></a></li>
          <li><a href="#"><?php if(isset($accred)){ echo $ac1[2];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></a></li>
          <li><a href="#"><?php if(isset($accred)){echo $ac1[3];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></a></li>
          <li><a href="#"><?php if(isset($accred)){echo $ac1[4];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></a></li>
          <li><a href="#"<?php if(isset($accred)){echo $ac1[5];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}?></a></li>
          <div class="clear-both"></div>
        </ul>
      </div></li>
            <?php }if($items > 0) {  $show = $p->show();} else
	  {
		    $show = "No Record Found";
	  }
?>
</ul>   
</div>
</div>