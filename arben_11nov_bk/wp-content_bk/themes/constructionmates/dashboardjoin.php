<!--<script>
	 // DOM ready
	 jQuery(function() {
	   
      // Create the dropdown base
      jQuery("<select />").appendTo(".nav");
      
      // Create default option "Go to..."
      jQuery("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Home"
      }).appendTo("nav select");
      
      // Populate dropdown with menu items
      jQuery(".nav a").each(function() {
       var el = jQuery(this);
       jQuery("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo(".nav select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      jQuery("nav select").change(function() {
        window.location = jQuery(this).find("option:selected").val();
      });
	 
	 });
	</script>-->
	<!--<script>
	 // DOM ready
	 jQuery(function() {
	   
      // Create the dropdown base
      jQuery("<select />").appendTo(".footer-nav");
      
      // Create default option "Go to..."
      jQuery("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Home"
      }).appendTo(".footer-nav select");
      
      // Populate dropdown with menu items
      jQuery(".footer-nav a").each(function() {
       var el = jQuery(this);
       jQuery("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo(".footer-nav select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      jQuery("footer-nav select").change(function() {
        window.location = jQuery(this).find("option:selected").val();
      });
	 
	 });
	</script>-->
   <!-- <script language="JavaScript" type="text/javascript">
	function HandleFileButtonClick()
	{
		document.frmUpload.myFile.click();
		//alert(document.frmUpload.myFile.value);
		//document.frmUpload.txtFakeText.value = document.frmUpload.myFile.value;
	}
	function dovalue()
	{
		document.frmUpload.txtFakeText.value = document.frmUpload.myFile.value;
	}
	</script>-->
	    
      <script language="JavaScript" type="text/javascript">
	$(document).ready(function(){
		$("#uploafile").click(function()
				      {
				        $('#myFile').trigger('click');
				      });
		$('#myFile').change(function(){
				$("#imagename").val($('#myFile').val());
				});
	});
	
</script>
	<div class="job-title-field-area">
          <div class="fleft"><div class="job-type_field_main"><h3>Hello Builders</h3></div></div>
            <div class="available_select apply available">
                  <div> <span>
                    <select name="" class="text_field">
                    <option>Available</option>
                    <option>Please Select01</option>
                    <option>Please Select02</option>
                  </select>
                    </span> </div>
                </div>
            <img class="available" alt="innovation" src="<?php bloginfo('template_url')?>/images/innovation.png">
            <div class="builder">
              <div><span><a href="#">Jobs</a></span></div>
              <div><span><a href="http://constructionmates.co.uk/?page_id=354">Post A Job</a></span></div>
              <div><span><a href="#">Messages</a></span></div>
              <div><span><a class="active_arrow" href="#">My Account</a></span></div>
            </div>
            
          </div>
	   
<div class="join-field-part">
                <div class="join-field-area">
            <div class="join-name-field join-name">
                  <div> <span>
                    <select class="name-text_field" name="">
                    <option>Mr</option>
                    <option>Mrs</option>
                    <option>Miss</option>
                  </select>
                    </span> </div>
                </div>
	    <?php
	    if($current_user->data->user_login){
	    echo $current_user->data->user_login;
	    }
	    global $wpdb;
	    $retrieve_data = $wpdb->get_results("SELECT * from wp_users where user_login='prachi' ");
	    $id=$retrieve_data[0]->ID; 
	    $all_meta_for_user = get_user_meta( $id );
	    //$fname = $all_meta_for_user['first_name'][0];
?>
                <div class="join-firstname-field join-name-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="First Name" value="<?php echo $all_meta_for_user['first_name'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-firstname-field">
                  <div class="job-input-bg"> <span>
                    <input name="Last Name" type="text"  value="<?php echo $all_meta_for_user['last_name'][0];?>"/>
                    </span> </div>
                </div>
          </div>
                
                
                <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="Your Company Name" type="text"  value="<?php echo $all_meta_for_user['company_name'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="Your Email Address" type="text"  value="<?php echo $all_meta_for_user['email'][0];?>"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="Address 1" type="text"  value="<?php echo $all_meta_for_user['address1'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="Address 2" type="text"  value="<?php echo $all_meta_for_user['address2'][0];?>"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="City" type="text"  value="<?php echo $all_meta_for_user['city'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input type="text" value="<?php echo $all_meta_for_user['post_code'][0];?>" name="Your Postcode">
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="Mobile" type="text"  value="<?php echo $all_meta_for_user['mobile'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="Phone" type="text"  value="<?php echo $all_meta_for_user['phone'][0];?>"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
                <div class="join-title-field join-field-spc-rgt">
                      <div class="job-input-bg"> <span>
                        <input name="Email" type="text"  value="<?php echo $all_meta_for_user['email'][0];?>"/>
                        </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="Password"  type="text"  value="<?php echo $all_meta_for_user['select_password'][0];?>"/>
                    </span> </div>
                </div>
          		</div>
                <!--
                <div class="job-title-field-area">
                  <form name="frmUpload">-->
                    <!-- Real Input field, but hidden-->
                    <!--<input type="file" onchange="dovalue();" style="display: none" name="myFile">-->
                    <!-- Fake field to fool the user -->
                    	<!--<div class="logo-upload-field">
                          <div class="logo-upload-bg"> <span>-->
                           <!-- <input type="text" value="" onblur="if (this.value == '') this.value = '';" onfocus="if (this.value == '') this.value = '';" name="">-->
                           <!--<input type="text" value="upload a logo" readonly="" name="txtFakeText">
                            </span>
			    <div class="post-logo-upload">-->
                     <!-- <input name="image" type="image" class="inlineimage" value="Upload" src="images/upload-img-btn.png" alt="Upload" />-->
                    <!-- <input type="button" value="" class="browsebutton" onclick="HandleFileButtonClick();">
                    </div>
			  </div>
                        </div>
                        
                  </form>
          		 </div>-->
			 <div class="job-title-field-area">
				<div class="job-upload-field">
				   <div class="job-upload-bg"> <span>
				 <input type="file" name="myFile" style="display: none" id="myFile">
				<!-- Fake field to fool the user -->
				<input type="text" name="imagename" readonly="true" id="imagename">
					   </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" class="uploadbtn" id="uploafile">
		  </div>
          </div>
                <div class="trades apply">
                  <div> <span>
                    <select name="" class="text_field">
                    <option>Your Postcode</option>
                    <option>Your Postcode01</option>
                    <option>Your Postcode02</option>
                  </select>
                    </span>
                  </div>
                  <h4>Maximum 8 for trades and 10 for builders</h4>  
                </div>
	       <div class="btn-acrdtn-part">
                  <h3>Accreditations</h3>
                  <div class="acrdtn-btn"> <span><a href="#">CSCS</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">First AID</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">Gas Safe</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">City Guids</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">IPAF</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">PASHA</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">CSCS</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">First AID</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">Gas Safe</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">City Guids</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">IPAF</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">PASHA</a></span> </div>
                </div>
                <div class="accnt_info">
                 <div class="personal_container">
                 <span class="personal_title">About us</span>
                	<div class="personal_box">
                    	<span class="text">Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. </span>
                    </div>
                    </div>
                     <div class="personal_container">
                     <span class="personal_title">My Skills</span>
                    <div class="personal_box">
                    	<span class="text">Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. </span>
                    </div>
                    </div>
                     <div class="personal_container">
                     <span class="personal_title">Work Area</span>
                    <div class="personal_box">
                    	<span class="text">Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. </span>
                    </div>
                    </div>
                    <div class="personal_container">
                    <span class="personal_title">Customer Feedback</span>
                    <div class="personal_box">
                    	<span class="text">Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. </span>
                    </div>
                    </div>
                     <div class="personal_container">
                     <span class="personal_title">Contact Me</span>
                    <div class="personal_box">
                    	<span class="text">Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. </span>
                    </div>
                    </div>
                </div><!--accnt info-->
                <div class="accnt_recent-work">
                	<div class="recent-work-area">
                      <h3>Recent Work</h3>
                      <div class="recent-work-plc">
                    	<span class="before">Before</span>
                    	<div class="recent-work"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"><img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"> <img class="rcnt-last" alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"> </div>
                  	  </div>
                      <div class="recent-work-plc">
                    	<span class="after">After</span>
                    	<div class="recent-work rcnt-wrk-last"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"><img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"> <img class="rcnt-last" alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"> </div>
                  	  </div>
                    </div>
                </div>
          	
                <div class="job-submit-radio-area">
              <div class="job-radio-submit-field">
            <div class="job-radio">
                  <input type="radio" id="labour" name="option">
                  <label for="labour">Subcribe to Our Email Newsletter</label>
                </div>
            <div class="job-radio">
                   <input type="radio" id="labour2" name="option">
                  <label for="labour2">Subcribe to Promotion</label>
                </div>
          </div>
              
              <!--<div class="post-job-submit">
              <input type="image" alt="Search" src="<?php //bloginfo('template_url')?>/images/post-job-submit.png" value="Submit" name="image">
            </div>--> 
          </div>
          
          <div class="accnt_btns">
              <div><span><a href="#">Submit</a></span></div>
              <div><span><a href="#">Renew Membership</a></span></div>
              <div><span><a href="#">Pay/Donate</a></span></div>
              <div><span><a href="#">Close Account</a></span></div>
          </div>
          
          <div class="job-list-area">
			<h3>News</h3>
            <div class="job-list-part">
                  <div class="job-img-part"><img alt="" src="<?php bloginfo('template_url')?>/images/logo-img-demo.png"></div>
                  <div class="job-list-txt-plc">
                <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>
                <p>Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                      quis nostrud exercitation ullame laboris nisi ut aliquip duis aute irure dolor 
                      in reprehenderit in voluptate velit esse cillum dolore eu fugiat 
                      nulla pariatur quis nostrud exercitation ullame. </p>
                <div class="read-more-job-btn"><span><a href="#">Read More</a></span> </div>
              </div>
            </div>
            </div>
</div>
                
            
           
       <!-- Google CDN jQuery with fallback to local -->
	
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