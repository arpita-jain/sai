<?php $type=$_GET['type'];?> 
<div class="join-field-part">
            	<h3>Join Now or Network<br/>
		Subscrition Type - <?php echo $type;?>
		</h3> 
               <?php /* <h4>Please select your category below to be registered and grow your business with us</h4>*/?>
                
                <div class="join-now-tab-area">
            <?php /*   <div class="join-tab-btn"><span class="active"><a href="#" class="active">Builders</a></span> </div>
             <div class="join-tab-btn"><span><a href="#">Traders</a></span> </div>
              <div class="join-tab-btn"><span><a href="#">Home Owners</a></span> </div>
              <div class="join-tab-btn last-tab-nav"> <span><a href="#">Employers</a></span> </div>*/ ?>
            </div>
                
                <form name="join-form" action="" method="post" autocomplete="on" id="join-form">
                <div class="join-field-area">
 		 <div class="join-name-field join-name">
                  <div> <span>
                    <select class="name-text_field" name="gender">
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                  </select>
                    </span> </div>
                </div>
            <div class="join-name-field join-name">
                  <div> <span>
                    <select class="name-text_field" name="gender">
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                  </select>
                    </span> </div>
                </div>
                <div class="join-firstname-field join-name-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input  name="first_name" id="first_name"  type="text"  placeholder="First Name" value="" />
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
                    <input  name="company_name" onFocus="if (this.value == 'Your Company Name') this.value = '';" onBlur="if (this.value == '') this.value = 'Your Company Name';" type="text"  value="Your Company Name"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="email_address" id="email_address" placeholder="Your Email Address" type="text"  value=""/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="address1" onFocus="if (this.value == 'Address 1') this.value = '';" onBlur="if (this.value == '') this.value = 'Address 1';" type="text"  value="Address 1"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="address2" onFocus="if (this.value == 'Address 2') this.value = '';" onBlur="if (this.value == '') this.value = 'Address 2';" type="text"  value="Address 2"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="city" onFocus="if (this.value == 'City') this.value = '';" onBlur="if (this.value == '') this.value = 'City';" type="text"  value="City"/>
                    </span> </div>
                </div>
                <div class="join-type-field apply">
                  <div> <span>
                    <select class="text_field" name="post_code">
                   <?php  foreach($this->postcode as  $key =>$postcode){ ?>
			    <option value="<?php echo $key; ?>"><?php echo $postcode; ?></option>  
		   <?php  } ?>		   
                  </select>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="mobile" id="mobile" onFocus="if (this.value == 'Mobile') this.value = '';" onBlur="if (this.value == '') this.value = 'Mobile';" type="text"  value="Mobile" />
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="phone" id="phone" onFocus="if (this.value == 'Phone') this.value = '';" onBlur="if (this.value == '') this.value = 'Phone';" type="text"  value="Phone"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="pick_password" s.value = 'Pick a Password';" type="password"  value="" id="pick_password" placeholder="Pick a Password"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input type="password" name="confirm_password" value="" id="confirm_password" placeholder="Confirm Password"/>
                    </span> </div>
                </div>
          </div>
          		
                
                <div class="join-field-area">
            <div class="join-about-field join-apply">
                  <div> <span>
                    <select class="join-text_field" name="about_us">
                     <?php  foreach($this->about_us as  $key =>$about_us){ ?>
			    <option value="<?php echo $key; ?>"><?php echo $about_us; ?></option>  
		     <?php  } ?>	
                  </select>
                    </span> </div>
                </div>
                <div class="join-trade-field join-select">
                  <div> <span>
                    <select class="join-slct-text_field" name="intrest">
                     <?php  foreach($this->interest as  $key =>$interest){ ?>
			    <option value="<?php echo $key; ?>"><?php echo $interest; ?></option>  
		     <?php  } ?>
                    </select>
                    </span> </div>
                </div>
          </div>
                
                
                <div class="job-submit-radio-area">
              <div class="job-radio-submit-field">
            <div class="job-radio">
                  <input type="radio" name="agree_option" id="labour"/>
                  <label for="labour">I agree to the website terms of agreement</label>
                </div>
          </div>
        </div>  <div class="post-job-submit">
              <input type="hidden" name="submit_option" id="submit_option" value="1"/>
              <input name="image" type="image" value="Submit" src="<?php bloginfo('template_url')?>/images/post-job-submit.png" alt="Search" />
          </div> 
          </div></form>
 </div>
 </div>
 <script type="text/javscript">
    if(form.agree_option.value == '') { alert("Error: Input is empty!"); form.agree_option.focus(); return false;
</script>
