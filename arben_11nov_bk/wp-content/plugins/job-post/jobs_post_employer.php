<?php
define('ABSPATH', dirname(__FILE__) . '/');
//wp_enqueue_script('validationjsfile',plugins_url('/js/jquery-1.9.1.min.js' , __FILE__ ));
wp_enqueue_script('validationjsfile1',site_url('/wp-content/plugins/join-network/js/jquery.validate.pack.js' , __FILE__ ));
wp_enqueue_script('validationjsfile5',plugins_url('/js/jobpostemployer-validation.js' , __FILE__ ));
wp_enqueue_script('validationjsfile3',plugins_url('/js/jquery.MultiFile.js' , __FILE__ ));
function jobs_post_employer() {
        if (!is_user_logged_in()) {
	wp_redirect(site_url().'?page_id=18', 301 ); exit;
}
           global $current_user;
           if($current_user->data->user_login){
	   $user=$current_user->data->user_login;
	   $user_id= $current_user->ID;
	   $job_id=$_REQUEST['job_id'];
	   $all_meta_for_user = get_user_meta( $user_id );
	   $user_type= $all_meta_for_user['usertype'][0];
      }
?>
  <script language="JavaScript" type="text/javascript">
	$(document).ready(function(){
		$("#uploafile").click(function()
				      {
				        $('#simple-pdf').trigger('click');
				      });
		$('#simple-pdf').change(function(){
				$("#imagename").val($('#simple-pdf').val());
				});
	});
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
/*$(document).ready(function()
{
 $("#job_categoty").change(function()
{
	
var dataString = 'id1='+ $(this).val();
$.ajax
({
type: "POST",
url: "<?php //echo site_url()."/ajax_jcategory.php";?>",
data: dataString,
cache: false,
success: function(html)
{ 
$("#job_type").html(html);
} 
	});
	});


	});*/
function getActivecnt(id)
{
	//alert(id);
 $('#'+id).remove();
lt1 = $('.MultiFile-label').length;
if(lt1 >= 6)
{
	slave.attr('disabled','disabled');
}
else{
	$('#myFile').removeAttr('disabled');
}

}
</script>
<form action="" method="post" name="job_posting" id="job_posting" enctype="multipart/form-data">
<div class="job-title-field-area">
<?php /*<div class="fleft"><div class="job-type_field_main"><h3>Hello <?php if($user_type==1){echo "Home Owner";}elseif($user_type==2){echo "Trader";}elseif($user_type==3){echo "Builders";} elseif($user_type==4){echo "Employers";} ?></h3></div></div>*/?>
	       <!--<img class="available" alt="innovation" src="<?php //bloginfo('template_url')?>/images/innovation.png">-->
	       <div class="builder">
	       <div><span><a href="<?php echo site_url();?>?page_id=1465">Home</a></span></div>
              <div><span><a href="<?php echo site_url();?>?page_id=1044">Jobs</a></span></div>
             <?php if($user_type!=2){?> <div><span><a  class="active_arrow" href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364'; }else {  echo site_url().'?page_id=354'; }?>">Post A Job</a></span></div><?php } ?>
              <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox">Messages</a></span></div>
              <div><span><a  href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&usertype='.$user_type; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442&usertype='.$user_type; }?>">My Account</a></span></div>
            </div>
          </div>
	<?php
	if(isset($job_id)){
	if(isset($_POST['submit']))
     {
     //$job_title=$_POST['job_title'];
     $job_category=$_POST['job_category'];
     $job_type=$_POST['job_type'];
     $job_location=$_POST['job_location'];
     $salary=$_POST['salary'];
     $start_date=$_POST['start_date'];
     $contact=$_POST['contact'];
     $file_name=$_POST['myFile'];
     $salary=$_POST['salary'];
     $salary_time=$_POST['salary_time'];
     $job_detail_cont=$_POST['job_detail'];
     $job_detail=strtolower($job_detail_cont);
     $requirement=$_POST['requirement'];
     $candidate_required=$_POST['candidate_required'];
     $contact_reference=$_POST['contact_reference'];
     $path=ABSPATH."wp-content/plugins/job-post/job_image/";//die('asfdasfsdg');
     $path_pdf=ABSPATH."wp-content/plugins/job-post/job_pdf/";
     $product_image = time().basename($_FILES['myFile']['name']);
     $job_pdf=$_POST['myFile'];
     $work_duration=$_POST['work_duration'];
     $job_expiry=$_POST['job_expiry'];
     $type=$_FILES['myFile']['type'];
     $currentdate=date("Y-m-d");
     global $wpdb;
     $table_name ="wp_jobpost";
     if($_FILES['simple-pdf']['name'])
     {
     $uppdf = time().basename($_FILES['simple-pdf']['name']);
     move_uploaded_file($_FILES['simple-pdf']['tmp_name'],$path_pdf.$uppdf);
     }
     else
     {
	$uppdf = $_POST['exist_pdf'];
     }
     $tmparray=array();
	if($_FILES['myFile']['tmp_name'][0])
	{
		
		for($i=0;$i<count($_FILES['myFile']['tmp_name']);$i++)
		{
		$tmparray[] = $product_image = time().basename($_FILES['myFile']['name'][$i]);
		move_uploaded_file($_FILES['myFile']['tmp_name'][$i],$path.$product_image);     
		}
	}
	if($_POST['beforeimg'][0])
	{
		
		for($i=0;$i<count($_POST['beforeimg']);$i++)
		{
		$tmparray[] = $_POST['beforeimg'][$i];
		}
	}
	//echo "<pre>";
	//print_r($_POST);
	//print_r($_POST['beforeimg']);die;
	$product_image1=implode("---",$tmparray);
        $data = array('job_category'=>$job_category,'job_type'=>$job_type,'job_detail'=>$job_detail,'job_location'=>$job_location,'file_name'=>$tmparray[0],'contact_reference'=>$contact_reference,'post_date'=>$currentdate,'user_id'=>$user_id,'job_images'=>$product_image1,'contact_reference'=>$contact_reference,'start_date'=>$start_date,'candidate'=>$candidate_required,'contact_no'=>$contact,'salary'=>$salary,'salary_time'=>$salary_time,'work_duration'=>$work_duration,'job_expiry'=>$job_expiry,'requirements'=>$requirement,'job_pdf'=>$uppdf);
	 $where = array('id'=>$job_id);
	//$table_name = 
	$row_affected =$wpdb->update($table_name,$data,$where);
}

?>	<div class="job-type_field_main">
              <div class="job-title-field-area">
	      	 <?php
		 global $wpdb;
		 $q="SELECT * FROM wp_jobpost where id='$job_id'";
		 $retrieve_data2 = $wpdb->get_results($q);
		 foreach($retrieve_data2 as $retrieved_data2){
	  ?>
            <div class="job-type-field apply join-field-spc-rgt"><span>Job category</span>
                  <?php 
		  $list_all= $wpdb->get_results("SELECT * from wp_jobcategory");
		  $cat_id=$retrieved_data2->job_category;
		  $retrieve_data_cat = $wpdb->get_results("SELECT * from wp_jobcategory where id='$cat_id'");
		  $select_category[]= $retrieve_data_cat[0]->category;?>
                  <div> <span>
                    <select class="text_field" name="job_category" id="job_categoty">
			<option value="">-Select Category-</option>
		<?php foreach($list_all as $list_all_data ){?>
                    <option title="<?php echo $list_all_data->category ?>" value="<?php echo $list_all_data->category;?>"<?php if($list_all_data->category==$cat_id){echo "selected='selected'";}?>><?php echo $list_all_data->category;?></option>
		   <?php } ?>
                  </select>
                    </span>
		  </div>
                </div>
             <div class="job-type-field"><div class="job-location-field"><span> short description of work</span></div>
		 <div class="job-input-bg"> <span>
                    <input type="text" value="<?php echo $retrieved_data2->job_type;?>" id="job_type" name="job_type" class="error">
                    </span>
		  </div>
                </div>
          </div>
	 
	    <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Job location</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="job_location" id="job_location" type="text"  value="<?php echo $retrieved_data2->job_location; ?>"/>
                    </span>
		  </div>
                </div>
                <div class="join-title-field">
		<div class="job-location-field"><span>Salary</span></div>
                  <div class="job-input-bg"> <span class="salary_amt">
                    <input name="salary" id="salary" type="text" value="<?php echo $retrieved_data2->salary; ?>"/>
                    </span>
		<div class="job-type-field apply job_time"> <div><span> <select class="text_field valid" name="salary_time" id="salary_time">
		<option value="per hour" <?php if($retrieved_data2->salary_time=="per hour") {?>  selected="selected" <?php }?>>per hour</option>
		<option value="per day" <?php if($retrieved_data2->salary_time=="per day") {?>  selected="selected" <?php }?>>per day</option>
		<option value="per week" <?php if($retrieved_data2->salary_time=="per week") {?>  selected="selected" <?php }?>>per week</option>
		<option value="per month" <?php if($retrieved_data2->salary_time=="per month") {?>  selected="selected" <?php }?>>per month</option>
		<option value="per year" <?php if($retrieved_data2->salary_time=="per year") {?>  selected="selected" <?php }?>>per year</option>
		<option value="contract" <?php if($retrieved_data2->salary_time=="contract") {?>  selected="selected" <?php }?>>contract</option>
		<option value="price work" <?php if($retrieved_data2->salary_time=="price work") {?>  selected="selected" <?php }?>>price work</option>
		</select></span>
		</div></div>
		</div>
                </div>
          </div>
	  
	   <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Start Date</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="start_date" id="start_date" type="text" value="<?php echo $retrieved_data2->start_date; ?>"/>
                    </span> </div>
                </div>
            <?php /*    <div class="join-title-field">
		<div class="job-location-field"><span>candiadte required</span></div>
                  <div class="job-input-bg"> 
                   <?php /* <input name="contact" id="contact" type="text"  value="<?php echo $retrieved_data2->contact_no; ?>"/>*/?>
		 <?php /*  <div class="job-type-field apply"> <div><span> <select class="text_field valid" name="time" id="time"><option>per hour</option></select></span></div></div>

		</div>
                </div>*/?>
		  <!-- <div class="job-type-field apply"><span>candiadte required</span>
                   <div class="job-input-bg"><span>
                    <input type="text" name="candidate_required" id="candidate_required">
                    </span>
		  </div>
                </div>-->
                <div class="job-type-field"><div class="job-location-field"><span>Candidate Required</span></div>
		 <div class="job-input-bg"> <span>
                    <input type="text" class="valid" name="candidate_required" id="candidate_required" value="<?php echo $retrieved_data2->candidate;?>">
                    </span>
		  </div>
                </div>
          </div>
	   
	     <div class="join-field-area">
	    <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Work Duration</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="work_duration" id="work_duration" type="text" value="<?php echo $retrieved_data2->work_duration; ?>"/>
                    </span> </div>
                </div><input type="file" name="myFile[]" id="myFile"  class="multi">
	    <div class="job-title-field-area">
				<div class="job-upload-field jobImges">
				   <div class="job-upload-bg">
					<span class="job_img_uploading">
				
					<div class="job_imges_listing">
					<?php
					if($retrieved_data2->job_images)
					{
						$beforeimg = explode("---",$retrieved_data2->job_images);
						for($j=0;$j<count($beforeimg);$j++)
						{
						?>
						 
						<div class="MultiFile-label" id="MultiFile_label_id_<?php echo $j;?>">
						<input type="hidden" name="beforeimg[]" value="<?php echo $beforeimg[$j];?>" />
							<a art="123" href="javascript:void(0)" onclick="getActivecnt('MultiFile_label_id_<?php echo $j;?>')" class="remove_img MultiFile-remove">x</a>
							<span title="File selected: art-2.jpg" class="MultiFile-title"><img src="<?php echo site_url().'/wp-content/plugins/job-post/job_image/'.$beforeimg[$j]; ?>" /></span>
						</div>
						<?php
						}
						
					}?></div>
					   </span>
				   </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<!--<input type="button" class="uploadbtn" id="uploafile">-->
		  </div>
          </div>
	     </div>
	   
              <div class="job-textarea-field"> <span>Job description</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="job_detail" id="job_detail" cols="" rows=""><?php echo $retrieved_data2->job_detail; ?></textarea>
              </div>
              </span> </div>
          </div>
            <div class="job-textarea-field"> <span>Requirements</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="requirement" id="requirement" cols="" rows=""><?php echo $retrieved_data2->requirements; ?></textarea>
              </div>
              </span></div>
          </div>
	   <div class="job-textarea-field"><span>Contact Preferences</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="contact_reference" id="contact_reference" cols="" rows=""><?php echo $retrieved_data2->contact_reference; ?></textarea>
              </div>
              </span> </div>
          </div>
	  <div class="job-type-field apply full upload_job"><span>This Job Expire</span>
                  <div><span>
                    <select class="text_field" name="job_expiry" id="job_expiry">
		    <option value="">-Please Select-</option>
		    <option value="In 1 day" <?php if($retrieved_data2->job_expiry=="In 1 day") {?>  selected="selected" <?php }?>>In 1 day</option>
		    <option value="In 7 days" <?php if($retrieved_data2->job_expiry=="In 7 days") {?>  selected="selected" <?php }?>>In 7 days</option>
		    <option value="In 30 days" <?php if($retrieved_data2->job_expiry=="In 30 days") {?>  selected="selected" <?php }?>>In 30 days</option>
                  </select>
                    </span>
		  </div>
                </div>
		
	<div class="job-title-field-area upload_job"><span class="pdf_upload">Upload this job in pdf file</span>
				<div class="job-upload-field ">
				   <div class="job-upload-bg"> <span>
				 <input type="file" name="simple-pdf" style="display: none" id="simple-pdf" class="valid" accept="pdf">
				<!-- Fake field to fool the user -->
				<input type="hidden" name="exist_pdf" value="<?php echo $retrieved_data2->job_pdf; ?>" />
				<input type="text" name="imagename" readonly="true" id="imagename" value="<?php echo $retrieved_data2->job_pdf; ?>"> 
					   </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" class="uploadpdf uploadbtn" id="uploafile" value="<?php  if (get_template()=="constructionmatesss_mob") { echo 'Upload PDF';}?>">
			</div>
		</div>
		<?php } ?>
          <div class="job-submit-radio-area">
              <div class="post-job-submit">
	       <input type="hidden" name="submit" value="submit" />
	       <input name="image" type="image" value="Submit" src="<?php bloginfo('template_url'); ?>/images/post-job-submit.png">
            </div>
      </div>    
</div>

<?php }
//For Post a job Employer
else { 
if(isset($_POST['submit']))
     {
     //$job_title=$_POST['job_title'];
     $job_category=$_POST['job_category'];
     $job_type=$_POST['job_type'];
     $job_location=$_POST['job_location'];
     $salary=$_POST['salary'];
     $start_date=$_POST['start_date'];
     $candidate_required=$_POST['candidate_required'];
     $contact=$_POST['contact'];
     $file_name=$_POST['myFile'];
     $salary=$_POST['salary'];
     $salary_time=$_POST['salary_time'];
     $job_detail_cont=$_POST['job_detail'];
     $job_detail=strtolower($job_detail_cont);
     $requirement=$_POST['requirement'];
     $contact_reference=$_POST['contact_reference'];
     $path=ABSPATH."wp-content/plugins/job-post/job_image/";//die('asfdasfsdg');
     $path_pdf=ABSPATH."wp-content/plugins/job-post/job_pdf/";
     $product_image = time().basename($_FILES['myFile']['name']);
     $job_pdf=$_POST['myFile'];
     $work_duration=$_POST['work_duration'];
     $job_expiry=$_POST['job_expiry'];
     //$expiry_time= mktime(0, 0, 0, date("m")  , date("d")+$job_expiry , date("Y"));
     //echo $expiry_time;
     //echo  date(mktime(0, 0, 0, 7, 1, 2000));
     //echo date("Y-m-d H:m:s", $expiry_time);
     //die('========');
     $type=$_FILES['simple-pdf']['type'];
     $currentdate=date("Y-m-d"); 
     global $wpdb;
     $table_name ="wp_jobpost";
     $uppdf = time().basename($_FILES['simple-pdf']['name']);

     if($type=="application/pdf")
     {
	move_uploaded_file($_FILES['simple-pdf']['tmp_name'],$path_pdf.$uppdf);
     }
     else{
	$var_type="Upload only PDF file";
     }
     $tmparray=array();
     //echo "<pre>";
     //print_r($_FILES['myFile']);
     
     for($i=0;$i<count($_FILES['myFile']['tmp_name']);$i++)
	{
	$tmparray[] = $product_image = time().basename($_FILES['myFile']['name'][$i]);
	
		move_uploaded_file($_FILES['myFile']['tmp_name'][$i],$path.$product_image);
	//echo $path.$product_image;
	}

	$product_image1=implode("---",$tmparray);
//        $sql1  = "INSERT INTO `" . $table_name ."` VALUES ('','','$job_category','$job_type','$job_detail','','$job_location','','','','','','','','$tmparray[0]',' $contact_reference','','$currentdate','$user_id','$product_image1','$company','$contact','$salary','$job_expiry','$requirement','$uppdf')"; 
//	$result1 = $wpdb->query($sql1);
	 $data = array('job_category'=>$job_category,'job_type'=>$job_type,'job_detail'=>$job_detail,'job_location'=>$job_location,'file_name'=>$tmparray[0],'contact_reference'=>$contact_reference,'post_date'=>$currentdate,'user_id'=>$user_id,'job_images'=>$product_image1,'contact_reference'=>$contact_reference,'start_date'=>$start_date,'candidate'=>$candidate_required,'contact_no'=>$contact,'salary'=>$salary,'salary_time'=>$salary_time,'work_duration'=>$work_duration,'job_expiry'=>$job_expiry,'requirements'=>$requirement,'job_pdf'=>$uppdf);
	 //$where = array('id'=>$job_id);
	 $rowaffected = $wpdb->insert($table_name,$data);
	 
}  ?> 
	<div class="job-type_field_main">
              <div class="job-title-field-area">
            <div class="job-type-field apply"><span>Job category</span>
                  <div><span>
                   <select class="text_field" name="job_category" id="job_categoty">
		    <option value="">-Select Category-</option>
                    <?php global $wpdb;
			 $retrieve_data = $wpdb->get_results("SELECT * from wp_jobcategory");
			foreach ($retrieve_data as $retrieved_data){?>
		    <option title="<?php echo $retrieved_data->id; ?>" value="<?php echo $retrieved_data->category; ?>"><?php echo $retrieved_data->category; ?></option>
		    <?php } ?>
                  </select>
                    </span>
		  </div>
                </div>
             <div class="job-type-field"><div class="job-location-field"><span> short description of work</span></div>
		 <div class="job-input-bg" style="margin-bottom:10px;"> <span>
                    <input type="text" class="valid" name="job_type" id="job_type" value="">
                    </span>
		  </div>
                </div>
          </div>
	    <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Job location</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="job_location" id="job_location" type="text"  value=""/>
                    </span>
		  </div>
                </div>
                <div class="join-title-field">
		<div class="job-location-field"><span>Salary</span></div>
                  <div class="job-input-bg"> <span class="salary_amt">
                    <input name="salary" id="salary" type="text" value=""/>
                    </span>
		<div class="job-type-field apply job_time"> <div><span> <select class="text_field valid" name="salary_time" id="salary_time">
		<option>-Please Select-</option>
		<option value="per hour">per hour</option>
		<option value="per day">per day</option>
		<option value="per week">per week</option>
		<option value="per month">per month</option>
		<option value="per year">per year</option>
		<option value="contract">contract</option>
		<option value="price work">price work</option>
		</select></span>
		</div></div>
		</div>
                </div>
          </div>
	  <!-- <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Start Date</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="company" id="company" type="text"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
		<div class="job-location-field"><span>Contact</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="contact" id="contact" type="text"  value=""/>
                    </span> 
		</div>
                </div>
          </div>-->
          <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Start Date</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="start_date" id="start_date" type="text" value=""/>
                    </span> </div>
                </div>
            <?php /*    <div class="join-title-field">
		<div class="job-location-field"><span>candiadte required</span></div>
                  <div class="job-input-bg"> 
                   <?php /* <input name="contact" id="contact" type="text"  value="<?php echo $retrieved_data2->contact_no; ?>"/>*/?>
		 <?php /*  <div class="job-type-field apply"> <div><span> <select class="text_field valid" name="time" id="time"><option>per hour</option></select></span></div></div>

		</div>
                </div>*/?>
		   <!--<div class="job-type-field apply"><span>candiadte required</span>
                   <div class="job-input-bg"> <span>
                  <input name="candidate_required" id="candidate_required" type="text" value=""/>
                    </span>
		  </div>
                </div>-->
                <div class="job-type-field"><div class="job-location-field"><span>Candidate Required</span></div>
		 <div class="job-input-bg"> <span>
                    <input type="text" class="valid" name="candidate_required" id="candidate_required" value="">
                    </span>
		  </div>
                </div>
          </div>
	   <div class="join-field-area">
	    <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Work Duration</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="work_duration" id="work_duration" type="text" value=""/>
                    </span> </div>
                </div><input type="file" name="myFile[]" id="myFile"  class="multi">
	    <div class="job-title-field-area">
				
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<!--<input type="button" class="uploadbtn" id="uploafile">-->
		  </div>
          </div>
	     </div>
	   
              <div class="job-textarea-field"> <span>Job description</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="job_detail" id="job_detail" cols="" rows=""></textarea>
              </div>
              </span> </div>
          </div>

             <!-- <div class="job-textarea-field"> <span>Job Details</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="job_detail" id="job_detail" cols="" rows=""></textarea>
              </div>
              </span> </div>
          </div>-->
            <div class="job-textarea-field"> <span>Requirements</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="requirement" id="requirement" cols="" rows=""></textarea>
              </div>
              </span></div>
          </div>
	   <div class="job-textarea-field"><span>Contact Preferences</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="contact_reference" id="contact_reference" cols="" rows=""></textarea>
              </div>
              </span> </div>
          </div>
	<!--<div class="job-title-field-area">
				<div class="job-upload-field">
				   <div class="job-upload-bg"> <span class="job_img_uploading">
				 <input type="file" name="myFile[]" id="myFile"  class="multi">
				<!-- Fake field to fool the user -->
				<!--<input type="file" name="test"  class="multi"  maxlength="3"/>-->
				<!--<input type="text" name="imagename" readonly="true" id="imagename">-->
				<!--</span> </div>
				 </div>
				 <div class="post-job-upload">-->
				<!-- Button to invoke the click of the File Input -->
				<!--<input type="button" class="uploadbtn" id="uploafile">-->
		  <!--</div>
          </div>-->
	  
	  <div class="job-type-field apply full"><span>This Job Expire</span>
                  <div><span>
                    <select class="text_field" name="job_expiry" id="job_expiry">
		    <option value="">-Please Select-</option>
		    <option value="In 1 day">In 1 day</option>
		    <option value="In 7 days">In 7 days</option>
		    <option value="In 30 days">In 30 days</option>
                  </select>
                    </span>
		  </div>
                </div>
		
	<div class="job-title-field-area"><span class="pdf_upload">Upload this job in pdf file </span>
				<div class="job-upload-field">
				   <div class="job-upload-bg"> <span>
				 <input type="file" name="simple-pdf" style="display: none" id="simple-pdf" class="valid" accept="pdf">
				<!-- Fake field to fool the user -->
				<input type="text" name="imagename" readonly="true" id="imagename">
					   </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" class="uploadpdf uploadbtn" id="uploafile" value="<?php  if (get_template()=="constructionmatesss_mob") { echo 'Upload PDF';}?>" >
			</div>
		</div>
           <div class="post-job-submit">
	       <input type="hidden" name="submit" value="submit" />
	       <input name="image" type="image" value="Submit" src="<?php bloginfo('template_url'); ?>/images/post-job-submit.png">
	  <!--   <input type= "submit" alt="Search" src="http://constructionmates.co.uk/wp-content/themes/constructionmates/images/post-job-submit.png" value="Submit" name="image">
              <input name="submit" type="submit" value="Submit" />-->
            </div>
</div>
</form>
<?php
}
}
?>