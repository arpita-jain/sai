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
<style>
/* popup_box DIV-Styles*/
#popup_box { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:23%;  
	width:25%;
	padding: auto;
	background:#FFFFFF;  
	left:33%;
	color: #777777;
	top:20%;
	z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	/*margin-left: 20%;  */
	text-transform: uppercase;
	/* additional features, can be omitted */
	border:1px solid #888888;  	
	padding:15px;  
	font-size:1em;  
	font-family: 'myriad_pro_lightregular';
	-moz-box-shadow: 0 0 5px #A3A3A3;
	-webkit-box-shadow: 0 0 5px #A3A3A3;
	border-radius: 10px 10px 10px 10px;
        box-shadow: 0 0 5px #A3A3A3;
}
a{  
cursor: pointer;  
text-decoration:none;  
} 
/* This is for the positioning of the Close Link */
#popupBoxClose {
	font-size:12px;  
	line-height:15px;  
	right:-18px;  
	top:5px;  
	position:absolute;  
	color:#6fa5e2;  
	font-weight:500;  	
}

#show_images
{
	
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	
	width:45%;
	padding: auto;
	background:#FFFFFF;  
	left:33%;
	color: #777777;
	top:20%;
	z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	/*margin-left: 20%;  */
	text-transform: uppercase;
	/* additional features, can be omitted */
	border:1px solid #888888;  	
	padding:15px;  
	font-size:1em;  
	font-family: 'myriad_pro_lightregular';
	-moz-box-shadow: 0 0 5px #A3A3A3;
	-webkit-box-shadow: 0 0 5px #A3A3A3;
	border-radius: 10px 10px 10px 10px;
    box-shadow: 0 0 5px #A3A3A3;
	
}
#popupBoxClose_img {
	font-size:12px;  
	line-height:15px;  
	right:-18px;  
	top:5px;  
	position:absolute;  
	color:#6fa5e2;  
	font-weight:500;  	
}
.image_ul 
li{
	float: left;
	height: 200px;
	width: 200px;
	padding: 5px;
	list-style: none;
}
li img { height: 200px !important;}
/*popup box*/
</style>
<script type="text/javascript">
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
		
		$("#job_apply1").click(function(){
			$.post('<?php echo site_url(); ?>/wp-admin/admin-ajax.php',{job_id:"<?php echo $job_id;?>",action:"jobapply_action"  }, function(data) {
		  $('.result').html(data);
		 
		  });
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
});
</script>
 <script>
	$(document).ready(function(){
	$(".show_requirement_div").hide();
	$(".show_about_div").hide();
	$(".show_contact_div").hide();
	//$("#show_apply_div").hide();
	$("#show_job_div").show();
	//$(".show_thisjob").show();
	$('.show_thisjob').click(function(){
	$(".show_job_div").show();
	$(".show_requirement_div").hide();
	$(".show_about_div").hide();
	$(".show_contact_div").hide();
	//$("#show_apply_div").hide();
	});
	$('.show_requirement').click(function(){
	$(".show_requirement_div").show();
	$(".show_job_div").hide();
	$(".show_about_div").hide();
	$(".show_contact_div").hide();
	//$("#show_apply_div").hide();
	});
	$('.show_about').click(function(){
	$(".show_about_div").show();
	$(".show_job_div").hide();
	$(".show_requirement_div").hide();
	$(".show_contact_div").hide();
	//$("#show_apply_div").hide();
	});
	$('.show_contact').click(function(){
	$(".show_contact_div").show();
	$(".show_job_div").hide();
	$(".show_requirement_div").hide();
	$(".show_about_div").hide();
	//$("#show_apply_div").hide();
	});
	$('.apply_job').click(function(){
	$(".show_job_div").show();
	$(".show_requirement_div").hide();
	$(".show_about_div").hide();
	$(".show_contact_div").hide();
	});

});
</script>
<script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
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

<div id="popup_box">	<!-- OUR PopupBox DIV-->
	<div>
	<a id="popupBoxClose"><img  width="25%" src="<?php bloginfo('template_url')?>/images/close.png"  alt="Close"/></a>
	</div>
	<div>
	<?php $u_id=$retrieved_data->user_id;
	$all_meta_for_user = get_user_meta( $u_id );
	$user_type= $all_meta_for_user['usertype'][0];
	?>
	<h5>Dear Sir or Madam</h5>
	<h6>Im responding to Job you posted on constructionmates.co.uk and i believe that i meet the requirements for this job and like to give me an opportunity to work and serve your business</h6><br>
	<div id="ajax_responce"></div>
	<input type="checkbox" name="send_cv" id="send_cv" value="<?php echo $currentuser_id;?>">Send my CV &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"  class="apply_nw_btn" id="job_apply1" > Apply Now </a>
	</div>
</div>
<form action="" method="post" name="frmMyContent" id="frmMyContent">
      <div class="job-list-area">
            <h3><?php echo $retrieved_data->job_type;?></h3>
            <div class="job-list-part job_detail">
		<?php
		        preg_match("/src='(.*?)'/i",get_avatar($u_id,150), $matches);
			$a=explode('=',$matches[0]);
			$a1=explode("'",$a[1]);
			$sal=$retrieved_data->salary;
?>
                  <div class="job-img-part"><img src="<?php echo $a1[1]; ?>" alt=""></div>
         
		  <div class="job-list-txt-plc"> <span class="job_label">Location</span> <span class="job_detail_txt"><?php echo $retrieved_data->job_location;?></span> <span class="clear">&nbsp;</span>
		  <span class="job_label">Salary:</span> <span class="job_detail_txt"><?php echo $sal ;echo "&nbsp;&nbsp;";if($sal!=""){echo $retrieved_data->salary_time;}?></span>  <span class="clear">&nbsp;</span>
		 <span class="job_label">Date Posted:</span> <span class="job_detail_txt"><?php echo $retrieved_data->post_date;?></span> <span class="clear">&nbsp;</span>
		 <span class="job_label">Work Duration:</span> <span class="job_detail_txt"><?php echo $retrieved_data->work_duration;?></span> <span class="clear">&nbsp;</span>
		  <?php if($user_type==1){?><span class="job_label">Quote me for:</span> <span class="job_detail_txt"><?php echo $retrieved_data->job_estimate;?></span><?php }  else {?><span class="job_label">Candidates req:</span> <span class="job_detail_txt"><?php echo $retrieved_data->candidate;?></span><?php } ?> <span class="clear">&nbsp;</span>
		 <span class="job_label">Start date:</span> <span class="job_detail_txt"><?php echo $retrieved_data->start_date;?></span><span class="clear">&nbsp;</span>
		  </div>
                </div>
		<!-- Show job details -->
		<div class="show_job_div">
            <h3>Job Details</h3>
            <div class="jobdetal_scroll">
                  <div class="personal_container">
                <div class="personal_box"> <span class="text"> <?php echo $retrieved_data->job_detail;?><br/>
                  </span> </div>
              </div>
	</div>
</div>
<!-- Show Requirements -->
<div class="show_requirement_div">
            <h3>Requirements</h3>
            <div class="jobdetal_scroll">
                  <div class="personal_container">
                <div class="personal_box"> <span class="text"> <?php echo $retrieved_data->requirements;?><br/>
                  </span> </div>
              </div>
	</div>
</div>
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
<div class="show_about_div">
            <h3>About Company</h3>
            <div class="jobdetal_scroll">
                  <div class="personal_container">
                <div class="personal_box"> <span class="text"><?php echo $all_meta_for_user['about_company'][0];?><br/>
                  </span> </div>
              </div>
	</div>
</div>
<div class="show_contact_div">
            <h3>Contact reference</h3>
            <div class="jobdetal_scroll">
                  <div class="personal_container">
                <div class="personal_box"> <span class="text"><?php echo $retrieved_data->contact_reference; ?><br/>
                  </span> </div>
              </div>
	</div>
</div>
            <div class="job_tabs">
                  <div><span><a href="javascript:void(0);" class="show_thisjob upper_active_arrow">Job Details</a></span></div>
                  <div><span><a href="javascript:void(0);" class="show_requirement">Requirements</a></span></div>
                  <div><span><a  href="javascript:void(0);" class="show_about">About Us</a></span></div>
		  <div><span><a  href="javascript:void(0);" class="show_contact">Contact</a></span></div>
                  <div><span><a href="javascript:void(0);" id="apply_job_link" class="apply_job">Apply </a></span></div>
		 <!-- <div><span><a href="javascript:void(0);" onClick="printpage();">Print this job</a></span></div>
		   <div><span><a href="pdf.php?Jt=<?php //echo $Jt;?>&Fn=<?php //echo $Fn ;?>&Jl=<?php //echo $Jl;?>&Jd=<?php //echo $Jd;?>&Cn=<?php //echo $Cn;?>&Jty=<?php //echo $Jty;?>&Pd=<?php //echo $Pd;?>" id="download_link">Download</a></span></div>-->
                </div>
          </div>
	  </form>
              <div class="faq-news-area">
            <div class="job-list-area"> 
                </div>
          </div>
      <!-- Google CDN jQuery with fallback to local --> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery-1.9.1.min.js"%3E%3C/script%3E'))</script> 
<!-- custom scrollbars plugin --> 
<script>
		(function($){
			$(window).load(function(){
				$(".personal_box").mCustomScrollbar({
					scrollButtons:{
						enable:true
					}
				});
				//ajax demo fn
				$("a[rel='load-content']").click(function(e){
					e.preventDefault();
					var $this=$(this),
						url=$this.attr("href");
					$this.addClass("loading");
					$.get(url,function(data){
						$this.removeClass("loading");
						$(".personal_box .mCSB_container").html(data); //load new content inside .mCSB_container
						$(".personal_box").mCustomScrollbar("update"); //update scrollbar according to newly loaded content
						$(".personal_box").mCustomScrollbar("scrollTo","top",{scrollInertia:200}); //scroll to top
					});
				});
				$("a[rel='append-content']").click(function(e){
					e.preventDefault();
					var $this=$(this),
						url=$this.attr("href");
					$this.addClass("loading");
					$.get(url,function(data){
						$this.removeClass("loading");
						$(".personal_box .mCSB_container").append(data); //append new content inside .mCSB_container
						$(".personal_box").mCustomScrollbar("update"); //update scrollbar according to newly appended content
						$(".personal_box").mCustomScrollbar("scrollTo","h2:last",{scrollInertia:2500,scrollEasing:"easeInOutQuad"}); //scroll to appended content
					});
				});
			});
		})(jQuery);
	</script>

	<div id="show_images" style="display: none;">
	<div>
	<a id="popupBoxClose_img"><img  width="25%" src="<?php bloginfo('template_url')?>/images/close.png"  alt="Close"/></a>
	<div>
	<ul class="image_ul">
	<?php
if($images)
{
	$allimg = explode("---",$images);
	for($i=0;$i<count($allimg);$i++)
	{
?>
	<li><img height="200" width="200" src="<?php echo site_url().'/wp-content/plugins/job-post/job_image/'.$allimg[$i]; ?>"</li>
	<?php
	}
}
?>
</ul>
</div>
</div>
</div>