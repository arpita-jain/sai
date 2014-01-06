<?php
define('ABSPATH', dirname(__FILE__) . '/');

//wp_enqueue_script('validationjsfile',plugins_url('/js/jquery-1.7.2.js' , __FILE__ ));
//wp_enqueue_script('validationjsfile1',plugins_url('/js/jquery-1.2.6.min.js' , __FILE__ ));
	    global $current_user;
	    $user_id = "";
	    if($current_user->data->user_login){
	    $user=$current_user->data->user_login;
	    $user_id=$current_user->data->ID;
	    $all_meta_for_user = get_user_meta( $user_id );
            $user_type= $all_meta_for_user['usertype'][0];
	    }
if(isset($_POST['search']))
{
	 $searchbox= $_POST['searchbox'];
	 $city= $_POST['city'];
}
	 $id=$_REQUEST['id'];
	 $trader_id=$id;
	 global $wpdb;
	 $all_meta_for_user = get_user_meta( $id);
	 
	  // for rating
	 session_start();
	 $_SESSION["rating_aboutname"] = $id;
?>
<script>
    $(document).ready(function() {
    var url = window.location.href;
    var option = url.match(/option=(.*)/);
       $('#abt').addClass('active');       
    $('#about').show();
    $('#skill').hide();
    $('#work_area').hide();
    $('#contact_me').hide();
    $('#customer_feed').hide();
    if (option !== null) {
        $(".link ." . option[1]).trigger('click');
    }
    $(".link").bind('click', function () { 
        $('#show_content').hide();
	$('.boxes').hide();
        $('.link').removeClass('active');
        $(this).removeClass('link');
	$('#' + $(this).prop('class')).show();
         $(this).addClass('link active');        
    });   
});
</script>
<!--For attach file-->
<script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	 $('#send_cv').click(function(){
		 var us_id = '<?php echo $user_id;?>';
		 var check_status=$('#send_cv').val();
		 var url = "<?php echo site_url()."/ajax_response_file.php";?>";
		 $.ajax({
                               type: 'POST',
                               url: url,
                               dataType: 'html',
                               data: {
				    us_id:us_id,
				    check_status:check_status
				    },
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
<style>
/* popup_box DIV-Styles*/
#popup_box { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:auto;
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
	font-size:13px;  
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
/*popup box*/
</style>
<script type="text/javascript">
/* show popup box script*/
	$(document).ready( function() {
	  loged_url=$("#loged_url").val();
	  loged_id = $("#loged_id").val();
	  $('#request_link').click(function(){
	  if(loged_id == "")
	  {
		  window.location=loged_url;
		  return false;
	  }loadPopupBox();
		});
		$('#popupBoxClose').click( function() {			
			unloadPopupBox();
		});
	
		$("#job_apply1").click(function(){
			  
			   if ($('#send_cv').is(":checked"))
			   {
				    var check_status2=1;
			     // it is checked
			     
			   }else {
				     var check_status2=0;
			   }
			$.post('<?php echo site_url(); ?>/wp-admin/admin-ajax.php',{trader_id:"<?php echo $trader_id;?>",check_status:check_status2,action:"traderapply_action"  }, function(data) {
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

<div id="popup_box">	<!-- OUR PopupBox DIV-->
	<div>
	<a id="popupBoxClose"><img src="<?php bloginfo('template_url')?>/images/close.png"  alt="Close"/></a>
	</div>
	<div>
	<h5>Your request will be sent to <?php  echo $all_meta_for_user['first_name'][0];?></h5>
	   A copy of  confirmation will be sent to your  inbox .<br>
	   Thanks from<br>  
	 ConstructionMates Team
	 <?php  $status_retrieved = $wpdb->get_var("SELECT * FROM wp_mydoc where userid='' order by id desc limit 0,1");
	 $doc_name=$st_retrieve->doc_name;?>
	</div>
	<div id="ajax_responce"></div>
	<?php if($user_type==4){?><input type="checkbox" name="send_cv" id="send_cv" >Do you want to Attach company file?<?php } ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"  class="apply_nw_btn" id="job_apply1" > Apply Now </a>
</div>
<div class="row">
    <div class="twelvecol">
    <div class="build_search_field_main">
	  <form action="<?php echo site_url().'?page_id=11'?>" method="post" name="searchform" id="searchform">
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
           <?php /* <p><a href="javascript:void(0)" onclick="document.getElementById('searchform').submit();">Advanced search</a></p>*/?>
          </div>
            </div>
        <div class="build_search_button"> <span>
          <input type="submit" name="search" value="Search">
          </span>
	</div>
    
 </div>
   </form>   
 </div>
      <div class="sprtr-mid_line"></div>
        </div>
  </div>
<?php
	 $all_meta_for_user1= get_user_meta( $user_id);
	 //echo "<pre>";
	 //print_r($all_meta_for_user);
?>
<input type="hidden" name="end" id="end" value="<?php echo $all_meta_for_user['city'][0]; ?>" />
<input type="hidden" name="start" id="start" value="<?php echo $all_meta_for_user1['city'][0];?>" />
<input type="hidden" name="loged_id" id="loged_id" value="<?php echo $user_id;?>" />
<input type="hidden" name="loged_url" id="loged_url" value="<?php echo site_url().'/?page_id=18'; ?>" />
<!--<input type="hidden" name="end" id="end" value="london, United kingdom" />
<input type="hidden" name="start" id="start" value="cambridge, United kingdom" />-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
 <script type="text/javascript">
	  var i=0;
	  var map = null;
          var directionDisplay;
          var directionsService = new google.maps.DirectionsService();

          function calcRoute() {
		 // alert('in');
            directionsDisplay = new google.maps.DirectionsRenderer();
            var start = document.getElementById('start').value;
            var end = document.getElementById('end').value;
            var request = {
              origin: start,
              destination: end,
              travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            directionsService.route(request, function(response, status) {
		  if(status == 'ZERO_RESULTS' && i==0)
		  {
		    document.getElementById('end').value = end+ "United kingdom";
		    document.getElementById('start').value = start+ "United kingdom";
		    calcRoute();
		    i=1;
		  }
              if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                computeTotalDistance(response);
              }
            });
          }
          function computeTotalDistance(result) {
          var total = 0;
          var myroute = result.routes[0];
          for (i = 0; i < myroute.legs.length; i++) {
            total += myroute.legs[i].distance.value;
          }
          total = total / 1000;
          mile = total*0.6214;
          mile = Math.round(mile);
          /*Start Calculating Distance Fair*/
            
          /*Distance Fair Calculation Ends*/
          document.getElementById("distance").innerHTML = mile+" miles" ;
          }

       calcRoute();
 </script>
  <div class="row">
    <div class="twelvecol">
          <div class="content-left-part left_area">
		 <?php
		 
		$builder_cid=$all_meta_for_user['trades_name'][0];
		$builder_cid1=explode(",",$builder_cid);
		//print_r($builder_cid1);
		//foreach($builder_cid1 as $builder_cids1)
		//{
		//$retrieve_category[] = $wpdb->get_results("SELECT `category_name` FROM wp_trades_categoriesy WHERE `id`='$builder_cids1'");
		//}
		//echo '<pre>';
		//print_r($retrieve_category[0]);
		  ?>
		  
        <div class="cntnt-tp-nav-area">
	  <select>
	       
	        <?php
		if($builder_cid1)
		{
		foreach($builder_cid1 as $builder_cids1)
		{
		?>
		<option value="<?php echo $builder_cids1; ?>"><?php echo $builder_cids1; ?></option>
		<?php
		}
		}
		else{
		  ?>
		   <option value=""><?php echo "Builder Not Selected"; ?></option>
		  <?php
		}
		?>
	 </select>
	 
	<span></span> <a href="#"><?php echo $all_meta_for_user['city'][0]; ?></a> <span></span> <a id="distance" href="#"></a></div>
        <div class="buttton_available">
              <div class="avail_button"> <span><a href="#"><?php echo $all_meta_for_user['available'][0]; ?></a></span> </div>
              <div class="rqust-cv_button"> <span><a href="#" id="request_link">Request My CV</a></span> </div>
             <?php if($user_id!=$trader_id){?>
	     <div class="rate_button"> <span><a href="#" id="rate_me">
	      <?php
	      
	      echo do_shortcode('[cis_rating]'); ?></a></span> </div>
	      
           <?php }
	   if($user=="")
		 {?>
		  <div class="rqust-cv_button"> <span><a href="<?php echo site_url().'?page_id=330'?>" >Quote me</a></span> </div>
		<?php } else {?>
		   <div class="rqust-cv_button"> <span><a href="<?php echo site_url().'?page_id=1423&id= '.$id?>" >Quote me</a></span> </div>
<?php }?>
            </div>
        <div class="info-area-part">
              <div class="build-box-img-txt-area">
            <div class="build-img-part">
		  <?php
		        preg_match("/src='(.*?)'/i",get_avatar($id,150), $matches);
			$a=explode('=',$matches[0]);
			$a1=explode("'",$a[1]);
		  ?>
		  <img src="<?php echo $a1[1];?>" alt=""></div>
            <div class="build-text-area">
                  <div class="build-img-txt full">
                <h4>Company</h4>
               <h5><?php echo $all_meta_for_user['company_name'][0];?></h5>
              </div>
	      <div class="build-img-txt full">
                <h4>Name</h4>
               <h5><?php echo $all_meta_for_user['first_name'][0];echo "&nbsp";echo $all_meta_for_user['last_name'][0];?></h5>
              </div>
                  <div class="build-img-txt full">
                <h4>Address</h4>
                <h5><?php echo $all_meta_for_user['address1'][0].",".$all_meta_for_user['city'][0].' '.$all_meta_for_user['post_code'][0]; ?></h5>
              </div>
                  <div class="build-img-txt full">
                <h4>Phone</h4>
                <h5><?php echo $all_meta_for_user['mobile'][0];?></h5>
              </div>
                  <div class="build-img-txt full">
                <h4 >Email Address</h4>
		<?php $userdata = get_userdata($id); ?>
                <h5  ><?php echo $userdata->user_email;?></h5>
              </div>
	       <div class="build-img-txt full">
                <h4 class="last-txt-brdr">Website</h4>
                <h5 class="last-txt-brdr_2"><?php echo $all_meta_for_user['site_url'][0];?></h5>
              </div>
                </div>
          </div>
            </div>
	<?php
		$accred=$all_meta_for_user['accreditations'][0];
		$ac1=explode(",",$accred);
		 ?>
	  <div class="btn-acrdtn-part">
              <h3 class="accredentials_tilte">Accreditations</h3>
              <div class="acrdtn-btn"> <span><p><?php if(isset($accred)) {echo $ac1[0];}else{echo "CSCS";} ?></p></span> </div>
              <div class="acrdtn-btn"> <span><p><?php if(isset($accred)){ echo $ac1[1];}?></p></span> </div>
              <div class="acrdtn-btn"> <span><p><?php if(isset($accred)){ echo $ac1[2];}?></p></span> </div>
              <div class="acrdtn-btn"> <span><p><?php if(isset($accred)){echo $ac1[3];}?></p></span> </div>
              <div class="acrdtn-btn"> <span><p><?php if(isset($accred)){echo $ac1[4];}?></p></span> </div>
              <div class="acrdtn-btn"> <span><p><?php if(isset($accred)){echo $ac1[5];}?></p></span> </div>
            </div>
	     <div class="person-detail-area">
              <div class="prsn-dtl-btn-area">
            <div class="prsn-dtl-btn"><span class="active"><a id="abt" href="javascript:void(0);" class="link about">About Us</a></span></div>
            <div class="prsn-dtl-btn"><span><a href="javascript:void(0);" class="link skill">My Skills</a></span></div>
            <div class="prsn-dtl-btn"><span><a href="javascript:void(0);" class="link work_area">Work Area</a></span></div>
            <div class="prsn-dtl-btn"><span><a href="javascript:void(0);" class="link contact_me">Contact Me</a></span></div>
            <div class="prsn-dtl-last-btn"><span class="last-tab-btn"><a href="javascript:void(0);" class="link customer_feed">Customer Feedback</a></span></div>
          </div>
              <div class="prsn-dtl-txt-plc" id="show_content">
		 
            <h5></h5>
            <p></p>
            <p></p>
          </div>
	      
	    <div class="boxes" id="about">
            <p><?php echo $all_meta_for_user['about_company'][0]; ?></p>
          </div>
	  
	    <div class="boxes" id="skill">
            <span class="personal_title">Skill</span>
            <p><?php echo $all_meta_for_user['skill'][0];?></p>
          </div>
	  
	  <div class="boxes" id="work_area">
		     <span class="personal_title">Work Area</span>
        
            <p><?php echo $all_meta_for_user['work_area'][0];?></p>
          </div>
	  
	   <div class="boxes" id="contact_me">
		   <span class="personal_title">Contact Me</span>
           
            <p><?php echo $all_meta_for_user['contact_me'][0];?></p>
          </div>
	  
	  <div class="boxes" id="customer_feed">
         
	    <span class="personal_title">Customer Feedback</span>

            <?php echo do_shortcode('[show_ratingId]');?>
          </div>
            </div>
	    <?php // echo $path = plugin_dir_path( ); ?> 	   
<script src="<?php echo site_url();?>/wp-content/plugins/join-network/js/visuallightbox.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo site_url();?>/wp-content/plugins/join-network/css/vlightbox2.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo site_url();?>/wp-content/plugins/join-network/css/visuallightbox.css" type="text/css" media="screen" />
        <div class="recent-work-area" id="vlightbox2">
              <h3>Recent Work</h3>
              <div class="recent-work-plc">
            <div class="recent-img-text"><img src="<?php bloginfo('template_url')?>/images/rcnt-bfr-txt-img.png" alt=""></div>
            <div class="recent-work">
		  <?php
			   $uid  = $_GET['id'];
			   $tbl_name = $wpdb->prefix.'postmeta';
			   $que = "select a.*, b.*, c.meta_value as image from $tbl_name as a, $tbl_name as b, $tbl_name as c where a.meta_key = 'user' and a.meta_value =$uid and b.meta_value='before' and c.meta_key = '_wp_attached_file' and a.post_id=b.post_id and b.post_id=c.post_id limit 0,5";
			   $data = $wpdb->get_results($que);
			   if($data)
			   {
			     for($i=0;$i<count($data);$i++)
			     {
			       ?>	
			      <a class="vlightbox2">
				    <img style=" name="art-2" src="<?php echo site_url();?>/wp-content/uploads/<?php echo $data[$i]->image; ?>">
			      </a>
			      
			       <?php
			     }
			   }
		   ?>
	    </div>
          </div>

              <div class="recent-work-plc" >
            <div class="recent-img-text"><img src="<?php bloginfo('template_url')?>/images/rcnt-aftr-txt-img.png" alt=""></div>
            <div class="recent-work rcnt-wrk-last">
		  <?php 
		  $uid  = $_GET['id'];
		  $tbl_name = $wpdb->prefix.'postmeta';
		  $que = "select a.*, b.*, c.meta_value as image from $tbl_name as a, $tbl_name as b, $tbl_name as c where a.meta_key = 'user' and a.meta_value =$uid and b.meta_value='after' and c.meta_key = '_wp_attached_file' and a.post_id=b.post_id and b.post_id=c.post_id limit 0,5";
		  $data = $wpdb->get_results($que);
		  //echo "<pre>";
		  //print_r($data);
		  if($data)
		  {
			   for($i=0;$i<count($data);$i++)
			   {
			   ?>
			   <a class="vlightbox2">
				    <img style="max-height: 100px; max-width: 130px;" name="art-2" src="<?php echo site_url();?>/wp-content/uploads/<?php echo $data[$i]->image; ?>">
			   </a>
			   
			   <?php
			   }
		  }

		  ?>
	 </div>
          </div>
            </div>
      </div>
<script type="text/javascript">
	 $('#recent_work_img').mouseenter(function() {
    $(this).css("cursor","pointer");
    $(this).animate({width: "50%", height: "50%"}, 'slow');
});

$('#recent_work_img').mouseleave(function() {   
    $(this).animate({width: "28%"}, 'slow');
});
</script>
<?php require_once('hits_count_builder.php');?>