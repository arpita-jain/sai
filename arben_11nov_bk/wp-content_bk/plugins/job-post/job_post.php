<?php
define('ABSPATH', dirname(__FILE__) . '/');
 wp_enqueue_script('validationjsfile',plugins_url('/js/jobpostform-validation.js' , __FILE__ ));
//add job post shortcode
function job_posting() {
	       global $current_user;
	    if($current_user->data->user_login){
	   $user=$current_user->data->user_login;
	    }
	    
	    
     //print_r($_POST);die('===');
      if(isset($_POST['submit']))
     {
     $job_title=$_POST['job_title'];
     $job_type=$_POST['job_type'];
     $job_detail=$_POST['job_detail'];
     $job_estimate=$_POST['estimate'];
     $job_location=$_POST['job_location'];
     $post_code=$_POST['post_code'];
     $job_name=$_POST['job_name'];
     $job_quote=$_POST['quote'];
     $sizeOfJob=$_POST['sizeOfJob'];
     $work_start=$_POST['work_start'];
     $contact=$_POST['contact'];
     $criteria=$_POST['criteria'];
     $file_name=$_POST['myFile'];
     $contact_reference=$_POST['contact_reference'];
     $post_data=$_POST['postg'];
     $path=ABSPATH."wp-content/plugins/job-post/job_image/";//die('asfdasfsdg');
     $product_image = time().basename($_FILES['myFile']['name']);
     $type=$_FILES['myFile']['type'];
   
     global $wpdb;
     $table_name ="wp_jobpost";
     if($type=="image/jpeg" || $type=="image/png" || $type=="image/jpg" || $type=="image/gif" || $type=="image/bmp")
     {	  
     move_uploaded_file($_FILES['myFile']['tmp_name'],$path.$product_image);
     
     $sql1  = "INSERT INTO `" . $table_name ."` VALUES ('','$job_title','$job_type','$job_detail','$job_estimate','$job_location','$post_code','$job_name','$job_quote','$sizeOfJob','$work_start','$contact','$criteria','$product_image',' $contact_reference','$post_data')";
     $result1 = $wpdb->query($sql1);
     }
     }
     ?>

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
<form action="" method="post" name="job_postingform" id="job_postingform" enctype="multipart/form-data">
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
		 
		<!--For shoing profile image-->
		<?php 	 global $wpdb;
			 $retrieve_data = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
			 $id1=$retrieve_data[0]->ID;
			  preg_match("/src='(.*?)'/i",get_avatar($id1,150), $matches);
			  //echo $matches[0];
			  $a=explode('=',$matches[0]);
			  $a1=explode("'",$a[1]);
		?>	
	        <img src="<?php echo $a1[1];?>" style="height:45px; width:128px; margin-left: 5%;">
	       <div class="builder">
              <div><span><a href="#" >Jobs</a></span></div>
              <div><span><a href="http://constructionmates.co.uk/?page_id=354" class="active_arrow">Post A Job</a></span></div>
              <div><span><a href="#">Messages</a></span></div>
              <div><span><a  href="#">My Account</a></span></div>
            </div>
            
          </div>


	  <div class="job-type_field_main">
              <div class="job-title-field-area">
            <div class="job-title-field job-field-spc-rgt"> <span>Job Title</span><br>
                  <div class="job-input-bg"> <span>
                    <input name="job_title" id="job_title" type="text" />
                    </span> </div>
                </div>
            <div class="job-type-field apply"><span>Job type</span>
                  <div> <span>
                    <select class="text_field" name="job_type">
                    <option>City or postcode</option>
                    <option>City or postcode01</option>
                    <option>City or postcode02</option>
                  </select>
                    </span> </div>
                </div>
            
            <!--another select box <div class="job-title-field"> <span>Job Type</span><br>
                  <div class="job-select-bg"> <span>
                    <select name="city or postcode">
                    <option>city or postcode</option>
                    <option>city or postcode02</option>
                  </select>
                    </span> </div>
                 <div class="job-select-bg"> <span>
                    <div class="styled-select">
                    <select>
                        <option>Here is the first option</option>
                        <option>The second option</option>
                      </select>
                  </div>
                    </span> </div> 
                </div>--> 
            
          </div>
              <div class="job-textarea-field"> <span>Describe job details</span><br>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="job_detail" id="job_detail" cols="" rows=""></textarea>
              </div>
              </span> </div>
          </div>
              <div class="job-radio-field"> <span>I require estimate for</span>
            <div class="job-radio">
                  <input type="radio" name="estimate" id="labour" value="Labour and material"/>
                  <label for="labour">Labour and material</label>
                </div>
            <div class="job-radio">
                  <input type="radio" name="estimate" id="labour2" value="Labour only"/>
                  <label for="labour2">Labour only</label>
                </div>
          </div>
              <div class="job-title-field-area">
            <div class="job-location-field"> <span>Job location</span><br>
                  <div class="job-location-bg"> <span>
                    <input type="text" value="" placeholder="Town/Village" name="job_location">
                    </span> </div>
                </div>
            <div class="job-post-field"> <span></span><br>
                  <div class="job-post-bg"> <span>
                    <input type="text" value="" name="post_code" id="post_code" placeholder="Post code"> 
                    </span> </div>
                </div>
          </div>
              <div class="job-quote-field-area">
            <div class="job-select-field apply job-field-spc-rgt"><span>I am</span>
                  <div> <span>
                    <select class="text_field" name="job_name">
                    <option>Please Select</option>
                    <option>Please Select01</option>
                    <option>Please Select02</option>
                  </select>
                    </span> </div>
                </div>
            <div class="job-select-field apply"><span>I would like to receive quotes because</span>
                  <div> <span>
                    <select class="text_field" name="quote">
                    <option>Please Select</option>
                    <option>Please Select01</option>
                    <option>Please Select02</option>
                  </select>
                    </span> </div>
                </div>
          </div>
              <div class="job-quote-field-area">
            <div class="job-select-field apply job-field-spc-rgt"><span>I broadly estimate the size of the job to be</span>
                  <div> <span>
                    <select class="text_field" name="sizeOfJob">
                    <option>Please Select</option>
                    <option>Please Select01</option>
                    <option>Please Select02</option>
                  </select>
                    </span> </div>
                </div>
            <div class="job-select-field apply"><span>I would like the work to begin</span>
                  <div> <span>
                    <select class="text_field" name="work_start">
                    <option>Please Select</option>
                    <option>Please Select01</option>
                    <option>Please Select02</option>
                  </select>
                    </span> </div>
                </div>
          </div>
              <div class="job-quote-field-area">
            <div class="job-select-field apply job-field-spc-rgt"><span>I want to be contacted by no more than</span>
                  <div> <span>
                    <select class="text_field" name="contact">
                    <option>Please Select</option>
                    <option>Please Select01</option>
                    <option>Please Select02</option>
                  </select>
                    </span> </div>
                </div>
            <div class="job-select-field apply"><span>My criteria for selecting and rating tradespeople are</span>
                  <div> <span>
                    <select class="text_field" name="criteria">
                    <option>Please Select</option>
                    <option>Please Select01</option>
                    <option>Please Select02</option>
                  </select>
                    </span> </div>
                </div>
          </div>
          
<!--          <div class="job-title-field-area">
            <div class="job-upload-field">
	     <input name="image_name" type="file"/>
                 <!-- <div class="job-upload-bg"> <span>
		 
                   <input type="text" >
                    </span> </div></div>-->
               
                
         <!-- <div class="post-job-upload">
              <input name="file" type="text" class="inlineimage" value="Upload" src="images/upload-img-btn.png" alt="Upload" />
	      <input name="image_name" type="file"/>
            </div></div>-->
                
                
          

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
	  
	  
              <div class="job-textarea-field"> <span>Contact reference</span><br>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="contact_reference" cols="" rows=""></textarea>
              </div>
              </span> </div>
          </div>
          
          <div class="job-submit-radio-area">
              <div class="job-radio-submit-field">
            <div class="job-radio">
                  <input type="radio" name="postg" id="labour"  value="Post more jobs<"/>
                  <label for="labour">Post more jobs</label>
                </div>
            <div class="job-radio">
                   <input type="radio" name="postg" id="labour2" value="No more jobs<"/>
                  <label for="labour2">No more jobs</label>
                </div>
          </div>
              
              <div class="post-job-submit">
	     <!--<input type= "submit" alt="Search" src="http://constructionmates.co.uk/wp-content/themes/constructionmates/images/post-job-submit.png" value="Submit" name="image">-->
              <input name="submit" type="submit" value="Submit" />
            </div>
	    </form>
	        </div>    
            </div>
     <?php     
     }
     
?>
