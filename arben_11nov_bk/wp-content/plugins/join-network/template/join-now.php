  <script language="JavaScript" type="text/javascript">
      $(document).ready(function(){
	    siteurl= '<?php echo site_url(); ?>';
		$("#uploafile").click(function()
				      {
				        $('#simple-local-avatar').trigger('click');
				      });
		$('#simple-local-avatar').change(function(){
				$("#imagename").val($('#simple-local-avatar').val());
				});
		  /************* for newsletter*************/
		  $('#email_address').focusout(function(){
		$("#xyz_em_email").val($('#email_address').val());
		  });
		  
		  $('#first_name').focusout(function(){
			$("#xyz_em_name").val($('#first_name').val());
		 
		
		 /*if(username!=""){
			 $.post(siteurl+"/ajax_rsponce.php", {username: ""+username+""}, function(data){
				
                                   if(data!=0){
				    $("#ajax_responce").text("Username is already exist");
				    return false;
				    }
	 
			    });
		 }else{
				  $("#ajax_responce").text("Username is required");
				  return false;
				     }*/
	   });
		 
		   /************ radio button onclick for newsletter***************/
		  $("#subscribe_news").click(function(){
			 var email_address=$('#email_address').val(); 
			 var xyz_em_name=$('#xyz_em_name').val();
			if(email_address!=""){ if(xyz_em_name!=""){ 
			//alert(siteurl+"wp-content/plugins/newsletter-manager/subscription.php");
			     
	    $.post(siteurl+"/wp-content/plugins/newsletter-manager/subscription.php", {xyz_em_email: ""+email_address+"",xyz_em_name: ""+xyz_em_name+""}, function(data){
                                                     //alert(data);
                                                    });
			}}
		   });
		   /********* validation on username and email for already exist *********/
		 /* $('#submit_join_form').click(function(){
		   // alert($("#ajax_responce").text());
		    if($("#ajax_responce").text()==""){
			  return false;
		    }
		        });*/
		  
});
</script>
<!--For username exist validation-->
<script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
$( "#user_name" ).blur(function() {
//alert( "Handler for .blur() called." );
   uname=document.getElementById("user_name").value;
   //alert(uname);
   var params = "user_id="+uname;
   var url = "<?php echo site_url()."/ajax_rsponce.php";?>";
		$.ajax({
                               type: 'POST',
                               url: url,
                               dataType: 'html',
                               data: params,
                                success: function(html) {
				    if(html)
				    {
				document.getElementById("ajax_username").innerHTML= html ;
				    }
				    else
				    {
				document.getElementById("ajax_username").innerHTML="";
				    }
                               }
				 
                       });
		});
});
 </script>
 <!--For Email already exist-->
 <script type="text/javascript">
$(document).ready(function(){
$( "#email_address" ).blur(function() {
//alert( "Handler for .blur() called." );
   uemail=document.getElementById("email_address").value;
   //alert(uname);
   var params = "user_email="+uemail;
   var url = "<?php echo site_url()."/ajax_rsponce.php";?>";
		$.ajax({
                               type: 'POST',
                               url: url,
                               dataType: 'html',
                               data: params,
                                success: function(html) {
				    if(html)
				    {
				document.getElementById("ajax_email").innerHTML= html ;
				    }
				    else
				    {
				document.getElementById("ajax_email").innerHTML="";
				    }
                               }
				 
                       });
		});
});
 </script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript">
    var i=0;
     function getData()
    {
	 
	var geocoder = new google.maps.Geocoder();
	var address = document.getElementById('city').value;
	//alert(address);
	geocoder.geocode( { 'address': address}, function(results, status) {  
	
	var latitude1 = results[0].geometry.location.lat(); 
	var longitude1 = results[0].geometry.location.lng();
	document.getElementById('latitude').value = latitude1;
	document.getElementById('longitude').value = longitude1;
	});
    }
  </script>
<?php $type=$_GET['type'];
?> 
<div class="join-field-part">
            	<h3>Join Now or Network</h3> 
                <h4>Please select your category below to be registered and grow your business with us</h4>
                
                <div class="join-now-tab-area">
            <?php /*   <div class="join-tab-btn"><span class="active"><a href="#" class="active">Builders</a></span> </div>
             <div class="join-tab-btn"><span><a href="#">Traders</a></span> </div>
              <div class="join-tab-btn"><span><a href="#">Home Owners</a></span> </div>
              <div class="join-tab-btn last-tab-nav"> <span><a href="#">Employers</a></span> </div>*/ ?>
            </div>
                
                <form name="join-form" action="" method="post" autocomplete="on" id="join-form" enctype="multipart/form-data" onsubmit="return getData();">
				 <div class="join-field-area">
 					 <div class="uploadselection">
                  	 <div> <span>
                    <select class="name-text_field" name="usertype">
                        <option value="0" >User Type</option>
                        <option value="1" <?php if($type=="Homeowners"){?>selected="selected"<?php }?>>Home Owner</option>
                        <option value="2" <?php if($type=="Traders"){?>selected="selected"<?php }?>>Traders</option>
			<option value="3" <?php if($type=="Builders"){?>selected="selected"<?php }?>>Builders</option>
			<option value="4" <?php if($type=="Employers"){?>selected="selected"<?php }?>>Employers</option>
	                </select>
                    </span> </div>
                </div>
                </div>
               
               
                <div class="join-field-area">
 		
            <div class="join-name-field join-name">
                  <div> <span>
                    <select class="name-text_field new_small" name="gender">
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                  </select>
                    </span> </div>
                </div>
                <div class="join-firstname-field join-name-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input  name="first_name" id="first_name"  type="text"  placeholder="First Name" value="" /><label style="color:red;"id="ajax_responce" name="ajax_responce"></label>
                    </span> </div>
                </div>
                <div class="join-firstname-field">
                  <div class="job-input-bg"> <span>
                    <input name="last_name" id="last_name" type="text"  value="" placeholder="Last Name"/>
                    </span> </div>
                </div>
          </div>
                
                
                <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input  name="company_name" id="company_name" onFocus="if (this.value == 'Your Company Name') this.value = '';" onBlur="if (this.value == '') this.value = 'Your Company Name';" type="text"  value="Your Company Name"/>
                    </span> </div>
                </div>
                <div class="join-type-field apply">
                  <div> <span>
                    <select class="text_field" name="buisness_type">
                   <?php /* foreach($this->postcode as  $key =>$postcode){ */?>
			    <option value="">Business Type</option>
			    <option value="Sole Proprietor">Sole Proprietor</option>  
 			    <option value="Self  Employed">Self  Employed</option>
			    <option value="Single Member Limited Company">Single Member Limited Company</option>  
 			    <option value="Recruiter Agency">Recruiter Agency</option>
			    <option value="Estate Agency">Estate Agency</option>
		   <?php  //} ?>		   
                  </select>
                    </span>
		  </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt new_half">
                  <div class="job-input-bg"> <span>
                    <input name="address1" onFocus="if (this.value == 'Address 1') this.value = '';" onBlur="if (this.value == '') this.value = 'Address 1';" type="text"  value="Address 1"/>
                    </span> </div>
                </div>
                <div class="join-title-field new_half">
                  <div class="job-input-bg"> <span>
                    <input name="address2" onFocus="if (this.value == 'Address 2') this.value = '';" onBlur="if (this.value == '') this.value = 'Address 2';" type="text"  value="Address 2"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area ">
            <div class="join-title-field join-field-spc-rgt new_half">
                  <div class="job-input-bg"> <span>
		  <!--if (this.value == '') this.value = 'City';-->
                    <input name="city" id="city" onFocus="if (this.value == 'City') this.value = '';" onBlur="getData();" placaholder="City" type="text"  value="City"/>
                    </span> </div>
                </div>
		<div class="join-title-field new_half">
                  <div class="job-input-bg"> <span>
                    <input name="post_code" onFocus="if (this.value == 'Post Code') this.value = '';" onBlur="if (this.value == '') this.value = 'Post Code';" type="text"  value="Post Code"/>
                    </span></div>
                </div>
               <!-- <div class="join-type-field apply">
                  <div><span>-->
                  <!--  <select class="text_field" name="post_code">
                   <?php  //foreach($this->postcode as  $key =>$postcode){ ?>
			    <option value="<?php //echo $key; ?>"><?php //echo $postcode; ?></option>  
		   <?php  //} ?>		   
                  </select>-->
               <!--     </span> </div>
                </div>-->
          </div>
          		<div class="join-field-area ">
            <div class="join-title-field join-field-spc-rgt new_half">
                  <div class="job-input-bg"> <span>
                    <input name="mobile" id="mobile" onFocus="if (this.value == 'Mobile') this.value = '';" onBlur="if (this.value == '') this.value = 'Mobile';" type="text"  value="Mobile" />
                    </span> </div>
                </div>
                <div class="join-title-field new_half">
                  <div class="job-input-bg "> <span>
                    <input name="phone" id="phone" onFocus="if (this.value == 'Phone') this.value = '';" onBlur="if (this.value == '') this.value = 'Phone';" type="text"  value="Phone"/>
                    </span> </div>
                </div>
          </div>      
             <div class="job-textarea-field"> <span>About your company</span><br>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea rows="" cols="" name="about_company"></textarea>
              </div>
              </span> </div>
          </div>
          
         <?php/* <div class="job-title-field-area">
            <div class="job-upload-field">
                  <div class="job-upload-bg"> <span>
                    <input type="text" name="" onfocus="if (this.value == '') this.value = '';" onblur="if (this.value == '') this.value = '';" value="">
                    </span> </div>
                </div>
                
          <div class="post-job-upload">
              <input type="image" alt="Upload" src="http://constructionmates.co.uk/wp-content/themes/constructionmates/images/upload-img-btn.png" value="Upload" class="inlineimage" name="image">
            </div>
          </div>*/?>
		<div class="job-title-field-area">
				<div class="job-upload-field">
				   <div class="job-upload-bg"> <span>
				 <input type="file" name="simple-local-avatar" style="display: none" id="simple-local-avatar" class="valid">
				<!-- Fake field to fool the user -->
				<input type="text" name="imagename" readonly="true" id="imagename">
					   </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" class="uploadbtn" id="uploafile" value=" <?php if (get_template()=="constructionmatesss_mob") {  echo "Upload Images";}?>">
			</div>
		</div>
          
          <div class="join-field-area">
 	    <div class="uploadselection">
                <div> <span>
                    <select class="name-text_field" name="about_us">
                        <option value="">How Did you Hear About Us?</option>
                        <option value="Friends">Friends</option>
                        <option value="News paper">News paper</option>
		        <option value="e-Mail promotion">e-Mail promotion</option>
			<option value="Others">Others</option>
	                </select>
                    </span>
		</div>
                </div>
          </div>
          <div class="inputheading">log in details</div>
	       <div class="join-field-area ">
            <div class="join-title-field join-field-spc-rgt new_half">
                  <div class="job-input-bg"> <span>
                    <input type="text" placeholder="User Name" id="user_name"  name="user_name"><label style="color:red;" id="ajax_username" name="ajax_username"></label>
                    </span> </div>
                </div>
                <!--<div class="join-title-field new_half">
                  <div class="job-input-bg"> <span>
                    <input type="text" placeholder="Confirm Email" id="confirm_email" value="" name="Confirm_Email">
                    </span> </div>
                </div>-->
          </div>
         <div class="join-field-area ">
            <div class="join-title-field join-field-spc-rgt new_half">
                  <div class="job-input-bg"> <span>
                    <input type="text" placeholder="Your Email" id="email_address"  name="email_address"><label style="color:red;" id="ajax_email" name="ajax_email"></label>
                    </span> </div>
                </div>
                <div class="join-title-field new_half">
                  <div class="job-input-bg"> <span>
                    <input type="text" placeholder="Confirm Email" id="confirm_email" value="" name="Confirm_Email">
                    </span> </div>
                </div>
          </div>
          
          <div class="join-field-area ">
            <div class="join-title-field join-field-spc-rgt new_half">
                  <div class="job-input-bg"> <span>
                    <input type="password" placeholder="select password" id="select_password" value="" name="select_password">
                    </span> </div>
                </div>
                <div class="join-title-field new_half">
                  <div class="job-input-bg"> <span>
                    <input type="password" placeholder="Confirm Password" id="confirm_password" value="" name="Confirm_Password">
                    </span> </div>
                </div>
          </div>
                
                
                <div class="job-submit-radio-area">
              <div class="">
            <div class="job-radio">
                  <input type="radio" name="agree_option" id="labour"/>
                  <label for="labour">I agree to the website terms of agreement</label>
            </div>
            <div class="job-radio">
                  <input type="radio" name="subscribe_news" id="subscribe_news"/><?php echo do_shortcode('[xyz_em_subscription_html_code]'); ?>
                  <label for="labour">Subscribe to our email news</label>
            </div>
		<div class="post-job-submit">
              <input type="hidden" name="submit_option" id="submit_option" value="1"/>
              <input id="submit_join_form" name="image" type="image" value="Submit" src="<?php bloginfo('template_url')?>/images/post-job-submit.png" alt="submit" />
	      <!--input field for latitude and longitude-->
	      <input type="hidden" name="latitude" id="latitude" value="" />
	      <input type="hidden" name="longitude" id="longitude" value="" />
          </div> 
          </div>
        </div>  
          </div></form>
 </div>
 </div>
 
 <script type="text/javscript">
   
   //script for latitude and longitude
  
  
   
   //script for latitude and longitude
   
    if(form.agree_option.value == '') {alert("Error: Input is empty!"); form.agree_option.focus(); return false;}
    </script>