<?php

define('ABSPATH', dirname(__FILE__) . '/');
wp_enqueue_script('validationjsfile',plugins_url('/js/jquery.mCustomScrollbar.concat.min.js' , __FILE__ ));
wp_enqueue_script('validationjsfile1',plugins_url('/js/jquery-1.2.6.min.js' , __FILE__ ));

        if (!is_user_logged_in()) {
	wp_redirect(site_url().'?page_id=18', 301 ); exit;
}
$job_id=$_REQUEST['job'];
global $wpdb;
$retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost where id='$job_id' and published='1'");
foreach ($retrieve_data as $retrieved_data){
$images = $retrieved_data->job_images;
$retrieved_data->job_type;
 global $current_user;
	    if($current_user->data->user_login){
	    $currentuser_id=$current_user->data->ID;
	    $user=$current_user->data->user_login;
	    }
?>
 <script>
function printpage()
  {
  window.print();
  }
</script>
<script type="text/Javascript">
   $('#download_link').click(function(e) {
      $.ajax({
       
                type: 'POST',
                url: "/downloads/dlpolicies",
                data:  $("#frmMyContent").serialize(),
		
                cache: false,
                dataType: "html",
                success: function(html_input){
                    alert(html_input);  // This has the pdf file in a string.
                    //ToDo: Open/Save pdf file dialog using this string..
                }
            });
});
</script>
<!--<script type="text/javascript" src="js/jquery_006.js"></script>-->
<link href="<?php echo site_url().'/wp-content/themes/constructionmatesss_mob/css/SpryTabbedPanels.css';?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="<?php echo site_url().'/wp-content/themes/constructionmatesss_mob/js/SpryTabbedPanels.js';?>"></script>
	<script language="JavaScript" type="text/javascript">
var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab: 0 });
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2");
var TabbedPanels3 = new Spry.Widget.TabbedPanels("TabbedPanels3");
var TabbedPanels4 = new Spry.Widget.TabbedPanels("TabbedPanels4");
var TabbedPanels6 = new Spry.Widget.TabbedPanels("TabbedPanels6");
	</script>

<!--<script type="text/javascript">
/* show popup box script*/
	$(document).ready( function() {
		// When site loaded, load the Popupbox First
		//loadPopupBox();
	         $('#apply_job_link').click(function(){
		loadPopupBox();
		});
		$('#popupBoxClose').click( function() {			
			unloadPopupBox();
		});
		function unloadPopupBox() {	// TO Unload the Popupbox
			$('#popup_box').fadeOut("slow");
			$("#container").css({ // this is just for style		
				"opacity": "1"
			}); 
		}
		function loadPopupBox() {	// To Load the Popupbox
			$('#popup_box').fadeIn("slow");
			
			$("#container").css({ // this is just for style
				"opacity": "0.3"
			});
}
		/**********************************************************/
		$("#img_of_job").click(function(){
			loadImages();
			});
		$('#popupBoxClose_img').click( function() {			
			unloadImages();
		});
		
		function loadImages()
		{
			$('#show_images').fadeIn("slow");
		}
		function unloadImages() {	// TO Unload the Popupbox
			$('#show_images').fadeOut("slow");
			
		}
		$("#job_apply1").click(function(){
			$.post('<?php echo site_url(); ?>/wp-admin/admin-ajax.php',{job_id:"<?php echo $job_id;?>",action:"jobapply_action"  }, function(data) {
		  $('.result').html(data);
		 
		  });
	});
});
</script>-->
<script>
	$(document).ready(function(){
	$("#show_requirement_div").hide();
	$("#show_about_div").hide();
	$("#show_apply_div").hide();
	$("#show_contact_div").hide();
	$("#show_job_div").show();
	//$(".show_thisjob").show();
	$('#show_thisjob').click(function(){
	$("#show_job_div").show();
	$("#show_requirement_div").hide();
	$("#show_about_div").hide();
	$("#show_apply_div").hide();
	$("#show_contact_div").hide();
	});
	$('#show_requirement').click(function(){
	$("#show_requirement_div").show();
	$("#show_job_div").hide();
	$("#show_about_div").hide();
	$("#show_apply_div").hide();
	$("#show_contact_div").hide();
	});
	$('#show_about').click(function(){
	$("#show_about_div").show();
	$("#show_job_div").hide();
	$("#show_requirement_div").hide();
	$("#show_apply_div").hide();
	$("#show_contact_div").hide();
	});
	$('#show_apply').click(function(){
	 $("#show_apply_div").show();
	$("#show_about_div").hide();
	$("#show_job_div").hide();
	$("#show_requirement_div").hide();
	$("#show_contact_div").hide();
	});
	$('#show_contact').click(function(){
	 $("#show_contact_div").show();
	 $("#show_apply_div").hide();
	$("#show_about_div").hide();
	$("#show_job_div").hide();
	$("#show_requirement_div").hide();
	
	});

});
</script>
<!--<script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>-->
<script type="text/javascript">
$(document).ready(function(){
	 $('#send_cv').click(function(){
		 user_id=document.getElementById("send_cv").value;
		 var params = "u_id="+user_id;
		 var url = "<?php echo site_url()."/ajax_rsponce.php";?>";
		 $.ajax({
                               type: 'POST',
                               url: url,
                               dataType: 'html',
                               data: params,
			       success: function(html) {
				     if(html)
				    {
				document.getElementById("ajax_responce").innerHTML= html ;
				    }
				    else
				    {
				document.getElementById("ajax_responce").innerHTML="";
				    }
				
				    }
		});
		 });
	});

</script>
<form action="" method="post" name="frmMyContent" id="frmMyContent">
   <div class="tabs_search">
	<?php
		        $u_id=$retrieved_data->user_id;
			$all_meta_for_user = get_user_meta( $u_id );
			$user_type= $all_meta_for_user['usertype'][0];
	
			preg_match("/src='(.*?)'/i",get_avatar($u_id,150), $matches);
			$a=explode('=',$matches[0]);
			$a1=explode("'",$a[1]);
			$sal=$retrieved_data->salary;
?>
	<ul class="tab_2list">
	<li><img class="img_profile" src="<?php echo $a1[1]; ?>" alt="">
	   <div class="span2 new_paddind">
            <h3><?php echo $retrieved_data->job_type;?></h3>
             <span class="top_s new_width">
		 <div class="new_fild">
			<div class="new_field_detail">
				<label class="new_field_one">Location</label><label><?php echo $retrieved_data->job_location;?></label>
			</div>
			 <div class="new_field_detail">
				 <label class="new_field_one">Salary:</label><label><?php echo $sal;echo "&nbsp;&nbsp;";if($sal!=""){echo $retrieved_data->salary_time;}?></label>
			 </div>
			 <div class="new_field_detail">
				<label class="new_field_one">Date Posted:</label><label><?php echo $retrieved_data->post_date;?></label>
			</div>
			 <div class="new_field_detail">
				<label class="new_field_one">Work Duration:</label><label><?php echo $retrieved_data->work_duration;?></label>
			</div>
			<div class="new_field_detail">
			<?php if($user_type==1){?> <label class="new_field_one">Quote me for:</label> <label><?php echo $retrieved_data->job_estimate;?></label><?php }  else {?> <label class="new_field_one">Candidates req:</label><label><?php echo $retrieved_data->candidate;?></label><?php } ?>
			 </div>
			 <div class="new_field_detail clearfix">
				<label class="new_field_one">Start date:</label><label><?php echo $retrieved_data->start_date;?></label>
			 </div>
		 </div>
	    </span>
	     <div class="clear-both"></div>
	</li>
                
		
	<li>
            <!--tab S-->
            	<div class="TabbedPanels" id="tp1">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0" id="show_thisjob">Job Details</li>
    <li class="TabbedPanelsTab" tabindex="0" id="show_requirement">Requirments</li>
    <li class="TabbedPanelsTab" tabindex="0" id="show_about">About us</li>
     <li class="TabbedPanelsTab" tabindex="0" id="show_contact">Contact</li>
    <li class="TabbedPanelsTab TabbedPanelsTabSelected" tabindex="0"  id="show_apply">Apply</li>
  </ul><div class="TabbedPanelsContentGroup">
    <div style="display: none;" class="TabbedPanelsContent" id="show_job_div">
    <h2>Job Details</h2>
<p><?php echo $retrieved_data->job_detail;?> </p>
</div> 
<!-- Show Requirements -->
<div  class="TabbedPanelsContent" id="show_requirement_div" >
     <h2>Requirements</h2>
<p> <?php echo $retrieved_data->requirements;?></p> </div>
<?php
	       $Jt =  $retrieved_data->job_category;
	       $Jd = $retrieved_data->job_detail;
	       $Jl = $retrieved_data->job_location;
	       $Fn = $retrieved_data->file_name;
	       $Jty = $retrieved_data->job_type;
	       $Cn = $retrieved_data->contact;
	       $Pd = $retrieved_data->post_date;
	       $u_id= $retrieved_data->user_id;
	       $all_meta_for_user = get_user_meta( $u_id );
}?>
          
	 <div  class="TabbedPanelsContent" id="show_about_div"> <h2>About Company</h2><p><?php echo $all_meta_for_user['about_company'][0];?></p> </div>
	  <div  class="TabbedPanelsContent" id="show_contact_div"> <h2>Contact reference</h2><p><?php echo $retrieved_data->contact_reference; ?></p> </div>
    <div class="TabbedPanelsContent TabbedPanelsContentVisible" id="show_apply_div">
    <div id="ajax_responce"></div>
    	<p>
        <span>Dear Sir or Madam</span>
Im responding to Job you posted on constructionmates.co.uk and i believe that i meet the requirements for this job and like to give me an opportunity to work and serve your business
<div class="new_cv"><input type="checkbox" id="send_cv" name="send_cv">Send my CV 
<input type="submit" value="Apply Now" id="apply_job_link">
</div>
    	</p>
    </div>
</li>
  </div>
</div>
</ul>
