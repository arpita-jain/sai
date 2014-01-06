<?php  function job_listing()
 { include_once(ABSPATH.'wp-content/plugins/job-post/pagination.class.php');
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
	  pageid=1044;
		 $(".page_class").click(function(){
		 // alert(this.title);
		  owntitle = this.title;
		  window.location='http://constructionmates.co.uk/?page_id='+pageid+'&paging='+owntitle;
		  });
		 
		 //for next button
		 $('.next').click(function(){
		    owntitle = this.title;
		    window.location='http://constructionmates.co.uk/?page_id='+pageid+'&paging='+owntitle;
		    });
		 
		 $('.prev').click(function(){
		    owntitle = this.title;
		    window.location='http://constructionmates.co.uk/?page_id='+pageid+'&paging='+owntitle;
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
   <script>
	function showhide(small,big){
	$('#'+small).hide();
	$('#'+big).show();
	//$(".show_thisjob").show();
	}
	function hideshow(small,big){
	$('#'+small).show();
	$('#'+big).hide();
	
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
	       $status = $wpdb->get_results("SELECT status from wp_xyz_em_address_list_mapping where `ea_id`='".$ea_id[0]->ea_id."'");print_r();
               $id=$retrieve_data[0]->ID;
             //Update table
               $retrieve_data1 = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
               $id1=$retrieve_data1[0]->ID;
               $email=$retrieve_data1[0]->user_email; 
               $all_meta_for_user = get_user_meta( $id1 );
	       $user_type= $all_meta_for_user['usertype'][0];
?>			<div class="mobile_myaccount_page">
		       <form name="frm_userdetail" id="frm_userdetail" action="" method="post" enctype="multipart/form-data">
		      <?php if($user_type!=1){?>
   <!--new code-->
			  <div class="job-title-field-area">
			 <input id="user_type_val" type="hidden" value="3" name="user_type">
			    <?php $img=get_avatar($id1,150);
                            preg_match("/src='(.*?)'/i",get_avatar($id1,150), $matches);
                            $a=explode('=',$matches[0]);
                            $a1=explode("'",$a[1]);
?>
 </div><?php } ?>
  
                  <div class="builder">
		      <div><span><a href="<?php echo site_url();?>?page_id=1465">Home</a></span></div>
                      <div><span><a class="active_arrow" href="<?php if($user_type ==2){ echo site_url().'?page_id=15'; }else {  echo site_url().'?page_id=1044'; }?>">Jobs</a></span></div>
                        <?php if($user_type!=2){?> <div><span><a href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364'; }else {  echo site_url().'?page_id=354'; }?>">Post A Job</a></span></div><?php } ?>
                      <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox">Messages</a></span></div>
                      <div><span> <a  href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487'; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442'; }?>">My Account</a></span></div>
                </div>
        	<div fullclass="job-listing-left-area">
	       <?php
	       global $wpdb;
	       $rdata = $wpdb->get_results("SELECT * FROM wp_jobpost where job_type != '' and user_id='$user_id' and published='1'");
	       $items = count($rdata); // number of total rows in the database
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
	      $retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where job_type != '' and user_id='$user_id' and published='1' order by id desc $limit");
?>
	       <div class="job-list-area">
		<form action="<?php echo the_permalink();?>" method="post" id="searchform" name="searchform">
	     
	      <?php
	      $small_class_name=0;
	      $big_class_name=0;
	      foreach ($retrieve_data as $retrieved_data){
	       $small_class_name++;
	       $big_class_name++;
	       $final_s_class="show_small_div".$small_class_name;
	       $final_b_class="show_big_div".$big_class_name;
		 preg_match("/src='(.*?)'/i",get_avatar($retrieved_data->user_id,150), $matches);
			  //echo $matches[0];
			  $a=explode('=',$matches[0]);
			  $a1=explode("'",$a[1]);
		         $image_name=(explode("/",$a1[1]));
			?>
              <div class="job-list-part clearfix">
            <div class="job-img-part"><img src="<?php echo $a1[1];?>" alt=""></div>
            <div class="job-list-txt-plc" id="<?php echo $final_s_class; ?>">
	    <?php $job_detail=$retrieved_data->job_detail;
		$cont=substr($job_detail, 0, 150);?>
            	<h5><?php echo $retrieved_data->job_type;?></h5>
                <p><?php echo $cont ;?></p>
		<?php //if($user=="")
		 //{?>
		  <div class="read-more-job-btn"><span style="margin-right:10px;"><a href="javascript:void(0);" id="view_link" onclick="showhide('<?php echo $final_s_class; ?>','<?php echo $final_b_class;?>'); return false;">View</a></span><span><a href="<?php if(($user_type ==3)||($user_type ==4)){ echo site_url().'?page_id=1364&job_id='.$retrieved_data->id; }else { echo site_url().'?page_id=354&job_id='.$retrieved_data->id; }?>">Edit Job</a></span><span style="margin-left:10px;"><a onclick="return confirm('Are You Sure, You want to delete Account ?')" href="<?php echo site_url();?>?page_id=1044&djob_id=<?php echo $retrieved_data->id; ?>">Delete Job</a></span></div>
		  <!--<div class="read-more-job-btn"><span><a href="<?php echo site_url();?>?page_id=330">Delete Job</a></span></div>-->
		<?php //} else {?>
		    <!--<div class="read-more-job-btn"><span><a href="<?php //echo site_url();?>?page_id=509&job=<?php //echo $retrieved_data->id; ?>">Read More</a></span> </div>-->
<?php //}?></div>
	           <div class="job-list-txt-plc" id="<?php echo $final_b_class; ?>" style="display: none;">
	    <?php $job_detail=$retrieved_data->job_detail;
		$cont=substr($job_detail, 0, 150);?>
            	<h5><?php echo $retrieved_data->job_type;?></h5>
                <p><?php echo $retrieved_data->job_detail;?></p>
		<?php //if($user=="")
		 //{?>
		  <div class="read-more-job-btn"><span style="margin-right:10px;"><a href="javascript:void(0);" id="hide_link" onclick="hideshow('<?php echo $final_s_class; ?>','<?php echo $final_b_class;?>'); return false;">Hide</a></span><span><a href="<?php if(($user_type ==3)||($user_type ==4)){ echo site_url().'?page_id=1364&job_id='.$retrieved_data->id; }else { echo site_url().'?page_id=354&job_id='.$retrieved_data->id; }?>">Edit Job</a></span><span style="margin-left:10px;"><a onclick="return confirm('Are You Sure, You want to delete Account ?')" href="<?php echo site_url();?>?page_id=1044&djob_id=<?php echo $retrieved_data->id; ?>">Delete Job</a></span></div>
		  <!--<div class="read-more-job-btn"><span><a href="<?php //echo site_url();?>?page_id=330">Delete Job</a></span></div>-->
		<?php //} else {?>
		    <!--<div class="read-more-job-btn"><span><a href="<?php //echo site_url();?>?page_id=509&job=<?php //echo $retrieved_data->id; ?>">Read More</a></span> </div>-->
<?php //}?></div>
	      
	      </div>
<?php }
      if($retrieve_data) {  $show = $p->show();
      } else
	  {
		    echo "No Record Found";
	  }
	  ?>
	 </form>
            </div>
	 </div>
     </form>
   </div>
   <?php
}
?>