<?php
define('ABSPATH', dirname(__FILE__) . '/');
wp_enqueue_script('validationjsfile',plugins_url('/js/jquery-1.7.2.js' , __FILE__ ));
wp_enqueue_script('validationjsfile1',plugins_url('/js/jquery-1.2.6.min.js' , __FILE__ ));
	    global $current_user;
	    if($current_user->data->user_login){
	    $user=$current_user->data->user_login;
	    }
if(isset($_POST['search']))
{
	 $searchbox= $_POST['searchbox'];
	 $city= $_POST['city'];
}	 $id=$_REQUEST['id'];
	 global $wpdb;
	 $all_meta_for_user = get_user_meta( $id);
?>

<script>
    $(document).ready(function() {
    var url = window.location.href;
    var option = url.match(/option=(.*)/);
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
        $('.link').removeClass('selected');
        $(this).removeClass('link');
        $('#' + $(this).prop('class')).show();
        $(this).addClass('link selected');       
    });   
});
</script>
<style>
/* popup_box DIV-Styles*/
#popup_box { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:20%;  
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
/*popup box*/
</style>
<script type="text/javascript">
/* show popup box script*/
	$(document).ready( function() {
		// When site loaded, load the Popupbox First
		//loadPopupBox();
	$('#request_link').click(function(){
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
});
</script>
<div id="popup_box">	<!-- OUR PopupBox DIV-->
	<div>
	<a id="popupBoxClose"><img  width="25%" src="http://constructionmates.co.uk/wp-content/themes/constructionmates/images/close.png"  alt="Close"/></a>
	</div>
	<div>
	<h5>Your request  has been sent to <?php  echo $all_meta_for_user['first_name'][0];  ?></h5>
	</div>
</div>
<div class="row">
    <div class="twelvecol">
    <div class="build_search_field_main">
	 <form action="" method="post">
	 <div class="build_what_field"> <span>what</span><br>
              <div class="build_input_bg"> <span>
                <!--<input type="text" name="txtEmail" value="job title, keywords or company name">-->
                <input type="text" name="searchbox" value="" placeholder="job title, keywords or company name"/>
                </span>
	      </div>
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
          </span>
	</div>
   </form>      
 </div>
      <div class="sprtr-mid_line"></div>
        </div>
  </div>
  
  <div class="row">
    <div class="twelvecol">
          <div class="content-left-part">
        <div class="cntnt-tp-nav-area"><a href="#">Plumber</a> <span></span> <a href="#">London</a> <span></span> <a href="#">3 miles</a></div>
        <div class="buttton_available">
              <div class="avail_button"> <span><a href="#">Available</a></span> </div>
              <div class="rqust-cv_button"> <span><a href="#" id="request_link">Request My CV</a></span> </div>
              <div class="rate_button"> <span><a href="#">Rate Me</a></span> </div>
            </div>
        <div class="info-area-part">
              <div class="build-box-img-txt-area">
            <div class="build-img-part"><img src="<?php bloginfo('template_url')?>/images/build-img-info.png" alt=""></div>
            <div class="build-text-area">
                  <div class="build-img-txt full">
                <h4>Name</h4>
               <h5><?php echo $all_meta_for_user['first_name'][0];echo "&nbsp";echo $all_meta_for_user['last_name'][0];?></h5>
              </div>
                  <div class="build-img-txt full">
                <h4>Address</h4>
                <h5><?php echo $all_meta_for_user['address1'][0];echo ",";echo $all_meta_for_user['city'][0];?></h5>
              </div>
                  <div class="build-img-txt full">
                <h4>Phone</h4>
                <h5><?php echo $all_meta_for_user['mobile'][0];?></h5>
              </div>
                  <div class="build-img-txt full">
                <h4 class="last-txt-brdr">Email Address</h4>
                <h5  class="last-txt-brdr_2"><?php echo $all_meta_for_user['address1'][0];?></h5>
              </div>
                </div>
          </div>
            </div>
        <div class="btn-acrdtn-part">
              <h3>Accreditations</h3>
              <div class="acrdtn-btn"> <span><a href="#">CSCS</a></span> </div>
              <div class="acrdtn-btn"> <span><a href="#">First AID</a></span> </div>
              <div class="acrdtn-btn"> <span><a href="#">Gas Safe</a></span> </div>
              <div class="acrdtn-btn"> <span><a href="#">City Guids</a></span> </div>
              <div class="acrdtn-btn"> <span><a href="#">IPAF</a></span> </div>
              <div class="acrdtn-btn"> <span><a href="#">PASHA</a></span> </div>
            </div>
	     <div class="person-detail-area">
              <div class="prsn-dtl-btn-area">
            <div class="prsn-dtl-btn"><span class="active"><a href="javascript:void(0);" class="link about">About Us</a></span></div>
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
            <p><?php echo $all_meta_for_user['about_us'][0];?></p>
          </div>
	  
	    <div class="boxes" id="skill">
            <h5></h5>
            <p><?php echo $all_meta_for_user['skill'][0];?></p>
          </div>
	  
	  <div class="boxes" id="work_area">
            <h5></h5>
            <p><?php echo $all_meta_for_user['work_area'][0];?></p>
          </div>
	  
	   <div class="boxes" id="contact_me">
            <h5></h5>
            <p><?php echo $all_meta_for_user['contact_me'][0];?></p>
          </div>
	  
	  <div class="boxes" id="customer_feed">
            <h5></h5>
            <p><?php echo $all_meta_for_user['feedback'][0];?></p>
          </div>
            </div>
        
        <div class="recent-work-area">
              <h3>Recent Work</h3>
              <div class="recent-work-plc">
            <div class="recent-img-text"><img src="<?php bloginfo('template_url')?>/images/rcnt-bfr-txt-img.png" alt=""></div>
            <div class="recent-work"> <img src="<?php bloginfo('template_url')?>/images/recent-img-before.png" alt=""> <img src="<?php bloginfo('template_url')?>/images/recent-img-before.png" alt=""> <img src="<?php bloginfo('template_url')?>/images/recent-img-before.png" alt=""> <img src="<?php bloginfo('template_url')?>/images/recent-img-before.png" alt="" class="rcnt-last"> </div>
          </div>
              <div class="recent-work-plc">
            <div class="recent-img-text"><img src="<?php bloginfo('template_url')?>/images/rcnt-aftr-txt-img.png" alt=""></div>
            <div class="recent-work rcnt-wrk-last"> <img src="<?php bloginfo('template_url')?>/images/recent-img-after.png" alt=""> <img src="<?php bloginfo('template_url')?>/images/recent-img-after.png" alt=""> <img src="<?php bloginfo('template_url')?>/images/recent-img-after.png" alt=""> <img src="<?php bloginfo('template_url')?>/images/recent-img-after.png" alt="" class="rcnt-last"> </div>
          </div>
            </div>
      </div>