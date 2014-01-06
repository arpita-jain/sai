<?php
define('ABSPATH', dirname(__FILE__) . '/');
include_once(ABSPATH.'wp-content/plugins/job-post/pagination.class.php');
?>	 
<script language="JavaScript" type="text/javascript">
         $(document).ready(function(){
                   $("#uploafile").click(function()
                                         {
                                           $('#simple-local-avatar').trigger('click');
                                         });
                   $('#simple-local-avatar').change(function(){
                                   $("#imagename").val($('#simple-local-avatar').val());
                                   });
                   $("#uploadwork_imag").click(function()
                                         { 
                                           $('#workfile').trigger('click');
                                         });
                   $('#workfile').change(function(){
                                   $("#work_imagename").val($('#workfile').val());
                                   });
           });
      $(function() {
      $('#submitlink').click(function(e) {  
          e.preventDefault();
        $("#frm_userdetail").submit();
       });
      });
   </script>
 <script type="text/javascript">
	 $(document).ready(function(){ 
	  pageid=1188;
	  job_cat = $("#job_cat_id").val();
		 $(".page_class").click(function(){
		 // alert(this.title);
		  owntitle = this.title;
		  window.location='http://constructionmates.co.uk/?page_id='+pageid+'&job_cat='+job_cat+'&paging='+owntitle;
		  });
		 
		 //for next button
		 $('.next').click(function(){
		    owntitle = this.title;
		    window.location='http://constructionmates.co.uk/?page_id='+pageid+'&job_cat='+job_cat+'&paging='+owntitle;
		    });
		 
		 $('.prev').click(function(){
		    owntitle = this.title;
		    window.location='http://constructionmates.co.uk/?page_id='+pageid+'&job_cat='+job_cat+'&paging='+owntitle;
		    });
		 
		  });
</script>
   <script>
      function Blur(id)
   {
       // do whatever in here
       alert(document.getElementById("lastBox").value = id);
   }
   </script>
   <style>
   .t_area{
      width:620px;
      height:90px; 
     border: 1px solid #CCCCCC;
     text-transform: uppercase;
      }
   </style>
    <?php
	    if (!is_user_logged_in()) {
	    wp_redirect(site_url().'?page_id=18', 301 ); exit;
	     }
               global $wpdb;
               global $current_user;
               if($current_user->data->user_login){
	       $user=$current_user->data->user_login;
	       $user_id=$current_user->data->ID;
               }
	       //Delete job
	       $j_id= $_REQUEST['djob_id'];
	       $wpdb->query("DELETE FROM wp_jobpost WHERE id ='$j_id' and published='1'");
	       $retrieve_data = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
                 $ea_id = $wpdb->get_results("SELECT ea_id from wp_xyz_em_additional_field_value where `field1`='$user'"); 
		 $status = $wpdb->get_results("SELECT status from wp_xyz_em_address_list_mapping where `ea_id`='".$ea_id[0]->ea_id."'");
                $id=$retrieve_data[0]->ID;
		
             //Update table
               $retrieve_data1 = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
               $id1=$retrieve_data1[0]->ID;
               $email=$retrieve_data1[0]->user_email; 
               $all_meta_for_user = get_user_meta( $id1 );
	       $job_cat=$_REQUEST['job_cat'];
	       
   ?>
  <input type="hidden" id="job_cat_id" value="<?php echo $job_cat; ?>" />
	       <?php
		  $retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where job_category='$job_cat' and published='1'");
	       $items = count($retrieve_data);// number of total rows in the database
	       if($items > 0) {
	       $p = new pagination;
	       $p->items($items);
	       $p->limit(10); // Limit entries per page
	       $p->target(site_url()."?page_id=1044");
	       $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
	       $p->calculate(); // Calculates what to show
	       $p->parameterName('paging');
	       $p->adjacents(1); //No. of page away from the current page
	       if(!isset($_GET['paging'])) {
		   $p->page = 0;
		   $p->page = 1; }
		else { $p->page = $_GET['paging']; }
		//Query for limit paging
	       $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
	    //   $show = $p->show();
	    }
	  else {  $show = "No Record Found";}
	      global $wpdb;
	      //$table_name = $wpdb->prefix . "jobpost";
	      $retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where job_category='$job_cat' and published='1' $limit");
?>
</form>
   <h1 class="traders">latest jobs</h1>
<ul class="tab_2list">
           <?php foreach ($retrieve_data as $retrieved_data){
			 preg_match("/src='(.*?)'/i",get_avatar($retrieved_data->user_id,150), $matches);
			  //echo $matches[0];
			  $a=explode('=',$matches[0]);
			  $a1=explode("'",$a[1]);?>
<li><div class="more_btn"><a href="<?php echo site_url();?>?page_id=509&job=<?php echo $retrieved_data->id; ?>&theme=handheld"><img src="<?php echo site_url();?>/wp-content/themes/constructionmatesss_mob/images/more.png" alt="more"></a></div>
		       <?php   $image_name=(explode("/",$a1[1]));
			$image=$retrieved_data->file_name;
			if(!$retrieved_data->file_name)
			{
			$image = "jobslogo.png";
			}?>
	<img class="img_profile" src="<?php echo $a1[1];?>" alt="icon">
		      <div class="span2">
			       <?php $job_detail=$retrieved_data->job_detail;
		$cont=substr($job_detail, 0, 150);?>
		<h3><?php echo $retrieved_data->job_type;?></h3>
          <span class="top_s"><?php echo $cont;?></span>
            
            </div> <div class="clear-both"></div></li>
		     <?php }/*if($items > 0) {  $show = $p->show();} else
	  {
		    $show = "No Record Found";
	  }*/
            ?>
	 </ul>
</div>