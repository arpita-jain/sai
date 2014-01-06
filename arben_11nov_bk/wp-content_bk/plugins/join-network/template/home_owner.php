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
     $("#frm_userdetail").submit();//alert("========");
    });
   });
</script>
<!--<style>
.button{
   background: none repeat scroll 0 0 transparent;
    border: medium none;
    font-size: 0;
    }
</style>-->
 <?php
	     global $wpdb;
	     
	     global $current_user;
	    if($current_user->data->user_login){
	   $user=$current_user->data->user_login;
	    }
	    $retrieve_data = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
	     $id=$retrieve_data[0]->ID;
	  
	  //Update table  
	     if(isset($_POST['first_name']))
	   {
	    $gender=$_POST['first_name'];		
            $fname=$_POST['first_name'];
	    $lname=$_POST['last_name'];
	    $company_name=$_POST['company_name'];
	    $user_email=$_POST['user_email'];
	    $address1=$_POST['address1'];
	    $address2=$_POST['address2'];
	    $city=$_POST['city'];
	    $postcode=$_POST['postcode'];
	    $mobile=$_POST['mobile'];
	    $phone=$_POST['phone'];
	    $email_promotion=$_POST['option'];
	    $email=$_POST['email'];
	    $password=$_POST['password'];
	    update_user_meta( $id, 'first_name',$fname);
	    update_user_meta( $id, 'last_name',$lname);
	    update_user_meta( $id, 'company_name',$company_name);
	    update_user_meta( $id, 'address1',$address1);
	    update_user_meta( $id, 'address2',$address2);
	    update_user_meta( $id, 'city',$city);
	    update_user_meta( $id, 'post_code',$postcode);
	    update_user_meta( $id, 'mobile',$mobile);
	    update_user_meta( $id, 'phone',$phone);
	    update_user_meta( $id, 'promotion',$email_promotion);
	    $myAv = new simple_local_avatars();
	    $myAv->edit_user_profile_update($id);
            }
	    $retrieve_data1 = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
	    $id1=$retrieve_data1[0]->ID;
	    $email=$retrieve_data1[0]->user_email; 
	    $all_meta_for_user = get_user_meta( $id1 );
	    //echo $user;
	    //$fname = $all_meta_for_user['first_name'][0];
	    //$retrieve_email = $wpdb->get_results("SELECT id from wp_xyz_em_email_address where `email`='$email'");
	   // $value=$retrieve_email[0]->id;
?>
	<div class="job-title-field-area">
        <div class="fleft"><div class="job-type_field_main"><h3>Hello Homeowners</h3></div></div>
        <div class="available_select apply available">
                  <div> <span>
                    <select name="avail_select" class="text_field">
                    <option value="available">Available</option>
                    <option value="not available">Not Available</option>
                    </select>
                    </span> </div>
                </div>
		<?php 
			 $img=get_avatar($id1,150);
			 preg_match("/src='(.*?)'/i",get_avatar($id1,150), $matches);
			 // //echo $matches[0];
			  $a=explode('=',$matches[0]);
			 $a1=explode("'",$a[1]);
			?>
			 <img src="<?php echo $a1[1];?>" style="height:45px; width:108px;">
			
	       <!--<img class="available" alt="innovation" src="<?php //bloginfo('template_url')?>/images/innovation.png">-->
	       <div class="builder">
              <div><span><a href="#">Jobs</a></span></div>
              <div><span><a href="http://constructionmates.co.uk/?page_id=354">Post A Job</a></span></div>
              <div><span><a href="#">Messages</a></span></div>
              <div><span><a class="active_arrow" href="http://constructionmates.co.uk/?page_id=442">My Account</a></span></div>
            </div>
            
          </div>
	
	    <form name="frm_userdetail" id="frm_userdetail" action="" method="post" enctype="">
<div class="join-field-part">

                <div class="join-field-area">
            <div class="join-name-field join-name">
                  <div> <span>
                    <select class="name-text_field" name="gender">
                    <option value="<?php  echo $all_meta_for_user['gender'][0];?>"><?php echo $all_meta_for_user['gender'][0];?></option>
                  </select>
                    </span> </div>
                </div>
	   
                <div class="join-firstname-field join-name-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="first_name" value="<?php echo $all_meta_for_user['first_name'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-firstname-field">
                  <div class="job-input-bg"> <span>
                    <input name="last_name" type="text"  value="<?php echo $all_meta_for_user['last_name'][0];?>"/>
                    </span> </div>
                </div>
          </div>
                
                
                <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="company_name" type="text"  value="<?php echo $all_meta_for_user['company_name'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="user_email" type="text"  value="<?php echo $retrieve_data[0]->user_email;?>"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="address1" type="text"  value="<?php echo $all_meta_for_user['address1'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="address2" type="text"  value="<?php echo $all_meta_for_user['address2'][0];?>"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="city" type="text"  value="<?php echo $all_meta_for_user['city'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input type="text" value="<?php echo $all_meta_for_user['post_code'][0];?>" name="postcode">
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="mobile" type="text"  value="<?php echo $all_meta_for_user['mobile'][0];?>"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="phone" type="text"  value="<?php echo $all_meta_for_user['phone'][0];?>"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
                <div class="join-title-field join-field-spc-rgt">
                      <div class="job-input-bg"> <span>
                        <input name="email" type="text"  value="<?php echo $retrieve_data[0]->user_email;?>"/>
                        </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="password"  type="text"  value="<?php //echo $retrieve_data[0]->user_pass;?>"/>
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
			       <div class="job-upload-bg"><span>
			      <input type="file" name="myFile" style="display:none" id="myFile" accept="image/*">
				<!-- Fake field to fool the user -->
				
				<input type="text" name="imagename" readonly="true" id="imagename" placeholder="Profile images"> 
					   </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" class="uploadbtn" id="uploafile">
		  </div>
          </div>
	  
	   <div class="job-list-area">
			<h3>About</h3>
            <div class="home-owner-part">
                  <!--<div class="job-img-part"><img alt="" src="<?php//bloginfo('template_url')?>/images/logo-img-demo.png"></div>-->
                    <div class="personal_box">
                    	<span class="text">Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. </span>
                    </div>
            </div>
            </div>
	    <div class="join-field-area">
                <div class="join-title-field join-field-spc-rgt">
                      <div class="job-input-bg"> <span>
                        <input name="email" type="text" placeholder="Email" value="<?php echo $retrieve_data[0]->user_email;?>"/>
                        </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="password"  type="text" placeholder="Password"  value="<?php //echo $retrieve_data[0]->user_pass;?>"/>
                    </span> </div>
                </div>
          		</div>
		<!--	<div class="personal_container">
                 <span class="personal_title">About us</span>
                	<div class="personal_box">
                    	<span class="text">Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. </span>
                    </div>
                    </div>-->
	 	<div class="job-list-area">
			<h3>Company Terms & Condition(Optional)</h3>
            	<div class="home-owner-part">
                  <!--<div class="job-img-part"><img alt="" src="<?php//bloginfo('template_url')?>/images/logo-img-demo.png"></div>-->
                <div class="personal_box">
                    	<span class="text">Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat.Tempor incididunt ut labore et dolore magna aliqua,Ut enim ad minim veniam, quis nostrud exercitation, ullame aboris nisi ut aliquip ex ea commodo consequat. </span>
                    </div>
            </div>
            </div>
	    
	    <div class="builder">
              <div><span><a href="#" id="submitlink">Submit</a></span></div>
              <div><span><a href="#">Addvertse</a></span></div>
              <div><span><a href="#">Pay/Donate</a></span></div>
              <div><span><a class="#">Close Account</a></span></div>
            </div>
            
	    <div class="job-submit-radio-area">
              <div class="job-radio-submit-field">
            <div class="job-radio">
	 <input type="checkbox" id="labour" name="option" value="0" <?php if ($value) echo 'checked="checked"';?>>
                  <label for="labour">Subscribe to Our Email Newsletter</label>
                </div>
            <div class="job-radio">
		<input type="checkbox" id="labour2" name="option" value="1" >
                  <label for="labour2">Subscribe to Promotion</label>
                </div>
          </div>
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
      
	  
	  
                <!--<div class="trades apply">
                  <div> <span>
                    <select name="" class="text_field">
		    <option>Your Postcode</option>
                    <option>Your Postcode01</option>
                    <option>Your Postcode02</option>
                  </select>
                    </span>
                  </div>
                  <h4>Maximum 8 for trades and 10 for builders</h4> <!--<input type="submit" name="submit" value="submit"></div>--> 
                
		
	       <!--<div class="btn-acrdtn-part">
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
                </div>-->
		 <!--<div class="">
			      <div class="job-upload-field">
			       <div class="job-upload-bg"><span>
			      <input type="file" name="workfile" style="display:none" id="workfile">
				<!-- Fake field to fool the user -->
				
				<!--<input type="text" name="work_imagename" readonly="true" id="work_imagename" placeholder="Upload work image">
					   </span> </div>
				 </div>
				 <div class="post-job-upload">-->
				<!-- Button to invoke the click of the File Input -->
				<!--<input type="button" class="uploadbtn" id="uploadwork_imag">-->
		  <!--</div>-->
          <!--</div>-->
               <!-- <div class="accnt_info" style="margin-top:5%;">
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
               <!-- <div class="accnt_recent-work" style="margin-top:5%;">
                	<div class="recent-work-area">
                      <h3>Recent Work</h3>
                      <div class="recent-work-plc">
                    	<span class="before">Before</span>
                    	<div class="recent-work"> <img alt="" src="<?php //bloginfo('template_url')?>/images/recent-img-before.png"><img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"> <img class="rcnt-last" alt="" src="<?php bloginfo('template_url')?>/images/recent-img-before.png"> </div>
                  	  </div>
                      <div class="recent-work-plc">
                    	<span class="after">After</span>
                    	<div class="recent-work rcnt-wrk-last"> <img alt="" src="<?php //bloginfo('template_url')?>/images/recent-img-after.png"><img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"> <img alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"> <img class="rcnt-last" alt="" src="<?php bloginfo('template_url')?>/images/recent-img-after.png"> </div>
                  	  </div>
                    </div>
                </div>
          	
                <div class="job-submit-radio-area">
              <div class="job-radio-submit-field">
            <div class="job-radio">
	<?php  //$p_value=$all_meta_for_user['promotion'][0];?>

                  <input type="radio" id="labour" name="option" value="0">
                  <label for="labour">Subscribe to Our Email Newsletter</label>
                </div>
            <div class="job-radio">
		<input type="radio" id="labour2" name="option" value="1"<?php //checked( 1 == $p_value); ?> >
                  <label for="labour2">Subscribe to Promotion</label>
                </div>
          </div>
          </div>--->
          
        <!--  <div class="accnt_btns">
              <div><span><a href="#" id="submitlink" ">Submit</a></span></div>
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
            </div>-->

  </div>              
            
           
       <!-- Google CDN jQuery with fallback to local -->
	</form>
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
