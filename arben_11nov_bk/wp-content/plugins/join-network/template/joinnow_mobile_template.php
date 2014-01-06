<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Mobile theme Template
*/
?>
<?php include_once('header_mob.php');?>
<!--member login S-->
      <div class="tabs_search">
            <h2 class="new_content_heading">Member Login</h2>
            <form name="form1" method="post" action="">
              <div class="frm_row">
              
                <div class="frm_input"><input type="text" name="textfield" id="textfield" placeholder="User Name "></div>
               </div>
             <div class="frm_row" >
             
              <div class="frm_input"><input type="text" name="textfield" id="textfield" placeholder="Password" >
            </div>
            </div>
              <div class="frm_row2 new_left">
                <input type="submit" name="button" id="button" value="Login" class="search_btn">
                
              </div>
              </form>

            </div>
<!--member login E-->

<!--Join now S-->
      <div class="tabs_search new_margin">
            <h2 class="new_content_heading new_heading_top">Join Now or Network</h2>
            <p class="new_text">Please select your category below to be registered and grow your business with us</p>
            
            <form name="form1" method="post" action="">
            
         
              <div class="frm_row">
              
                <div class="frm_input">
                	<select name="usertype" class="new_select">
                        <option value="0">User Type</option>
                        <option selected="selected" value="1">Home Owner</option>
                        <option value="2">Traders</option>
						<option value="3">Builders</option>
						<option value="4">Employers</option>
	                </select>
                </div>
                
            </div>
            
            <div class="frm_row">
              
                <div class="frm_input">
                	<select name="usertype" class="new_select new_small">
                        <option value="2">Mr</option>
						<option value="3">Mrs</option>
						<option value="4">miss</option>
	                </select>
                    <input type="text" name="textfield" id="textfield" placeholder="First Name"  class="new_smallBox">
                    <input type="text" name="textfield" id="textfield" placeholder="Last Name"  class="new_smallBox">
                    
                </div>
                
            </div>
               
             <div class="frm_row" >
              <div class="frm_input"><input type="text" name="textfield" id="textfield" placeholder="your Company Name" class="new_half"> 
              <select name="usertype" class="new_select new_half"  style="margin-left:8px;">
                        <option value="2">Business Type</option>
						<option value="3">Sole Proprietor</option>
						<option value="4">Self Employed</option>
                        <option value="5">Singal Member limited Company</option>
                        <option value="6">Recruiter Agency</option>
                        <option value="7">Estate Agency</option>
	                </select></div>
            </div>
            
            
             <div class="frm_row" >
              <div class="frm_input"><input type="text" name="textfield" id="textfield" placeholder="Address 1" class="new_half"> 
              <input type="text" name="textfield" id="textfield" placeholder="Address 2" class="new_half" style="margin-left:8px;"> </div>
            </div>
            
            
             <div class="frm_row" >
              <div class="frm_input"><input type="text" name="textfield" id="textfield" placeholder="City" class="new_half"> 
              <input type="text" name="textfield" id="textfield" placeholder="Post Code" class="new_half" style="margin-left:8px;"> </div>
            </div>
            
               <div class="frm_row" >
              <div class="frm_input"><input type="text" name="textfield" id="textfield" placeholder="Mobile" class="new_half"> 
              <input type="text" name="textfield" id="textfield" placeholder="Phone" class="new_half" style="margin-left:8px;"> </div>
            </div>
            <div style="clear:both !important;"></div>
              </form>

            </div>
<!--Join now E-->

<!--About com S-->
      <div class="tabs_search new_margin new_heading_top">
            <h2 class="new_content_heading">About your company</h2>
            <form name="form1" method="post" action="">
              <div class="frm_row">
              
                <div class="frm_input"><textarea class="new_textarea"></textarea></div>
               </div>
               
             <div class="frm_row" >
              <div class="frm_input"><!--<input type="text" name="textfield" id="textfield" placeholder="Password" > --> 
         <!-- <input type="file">-->
              
              	<div class="job-title-field-area">
				<div class="job-upload-field">
				 <div class="job-upload-bg"> <span>
				 <input type="file" class="valid new_valid" id="simple-local-avatar"  name="simple-local-avatar">
				<!-- Fake field to fool the user -->
				<input type="text" id="imagename" readonly name="imagename" class="valid">
					   </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" id="uploafile" value="upload Image" class="uploadbtn">
					</div>
				</div>
              
              
              
              </div>
            </div>
            
            <div class="frm_row" >
              <div class="frm_input"><select name="usertype" class="new_select">
                        <option value="2">How did you hear about us ? </option>
						<option value="3">News Paper</option>
						<option value="4">E-mail Promotion</option>
                        <option value="5">Other</option>
	                </select>  </div>
            </div>
            
             </form>

            </div>
<!--About com E-->

<!--login now S-->
      <div class="tabs_search new_margin">
            <h2 class="new_content_heading new_heading_top">log in details</h2>
          
            
            <form name="form1" method="post" action="">
            
             <div class="frm_row" >
              <div class="frm_input"><input type="text" name="textfield" id="textfield" placeholder="Your Email" class="new_half"> 
              <input type="text" name="textfield" id="textfield" placeholder="Confirm Email" class="new_half" style="margin-left:8px;"> </div>
            </div>
            
            <div class="frm_row" >
              <div class="frm_input"><input type="text" name="textfield" id="textfield" placeholder="Select password" class="new_half"> 
              <input type="text" name="textfield" id="textfield" placeholder="Confirm Password" class="new_half" style="margin-left:8px;"> 
              </div>
            </div>
            
             <div class="frm_row" >
             
              <div class="frm_input">
              <input type="checkbox" > <span class="new_agree">I agree to the website terms of agreement</span>
              </div>
              
              <div class="frm_input new_top">
              <input type="checkbox" > <span class="new_agree">Subscribe to our email news</span>
              </div>
              
            </div>
            <div class="frm_row2 new_left">
                <input type="submit" name="button" id="button" value="Submit" class="search_btn">
                
              </div>
            
            <div style="clear:both !important;"></div>
              </form>

            </div>
<!--login now E-->


     
            <div class="clear-both"></div>
            </div> <div class="clear-both"></div></li>
            </ul>
            
            
            <div class="adv_box">
             <?php if(function_exists( 'wp_bannerize' ))
        wp_bannerize( 'group=mobile_blog&random=1&limit=2'); ?>
           <div class="clear-both"></div></div>
</div>
</div>
<?php include_once('footer_mob.php');?>