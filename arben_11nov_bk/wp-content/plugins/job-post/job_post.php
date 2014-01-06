<?php
define('ABSPATH', dirname(__FILE__) . '/');
//wp_enqueue_script('validationjsfile',plugins_url('/js/jquery-1.9.1.min.js' , __FILE__ ));
wp_enqueue_script('validationjsfile1',site_url('/wp-content/plugins/join-network/js/jquery.validate.pack.js' , __FILE__ ));
wp_enqueue_script('validationjsfile2',plugins_url('/js/jobpostform-validation.js' , __FILE__ ));
wp_enqueue_script('validationjsfile3',plugins_url('/js/jquery.MultiFile.js' , __FILE__ ));
//add job post shortcode
function job_posting() {
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
				        $('#myFile').trigger('click');
				      });
		$('#myFile').change(function(){
				$("#imagename").val($('#myFile').val());
				});
	});
	
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$("#job_categoty").change(function()
{
	
var dataString = 'id1='+ $(this).val();
$.ajax
({
type: "POST",
url: "<?php echo site_url()."/ajax_jcategory.php";?>",
data: dataString,
cache: false,
success: function(html)
{ 
$("#job_type").html(html);
} 
	});
	});


	});
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

<!--Date Picker-->
 	<script src="<?php bloginfo('template_url'); ?>/js/jquery.ui.core.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.ui.widget.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.ui.datepicker.js" type="text/javascript"></script>
	<script type="text/javascript">
	 $(function() {
	$( "#datepicker" ).datepicker();
});
  </script>
<form action="" method="post" name="job_postingform" id="job_postingform" enctype="multipart/form-data">
<div class="job-title-field-area">
        <?php /*  <div class="fleft"><div class="job-type_field_main"><h3>Hello <?php if($user_type==1){echo "Home Owner";}elseif($user_type==2){echo "Trader";}elseif($user_type==3){echo "Builders";} elseif($user_type==4){echo "Employers";} ?></h3></div></div>
            <div class="available_select apply available">
                  <div> <span>
                    <select name="available" class="text_field">
                    <option value="Available">Available</option>
                    <option value="Not Available">Not Available</option>
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
	        <div class="profile_img"><img src="<?php echo $a1[1];?>"></div>*/?>
	       <div class="builder">
	       <div><span><a href="<?php echo site_url();?>?page_id=1465">Home</a></span></div>
              <div><span><a href="<?php echo site_url();?>?page_id=1044">Jobs</a></span></div>
          <?php if($user_type!=2){?> <div><span><a class="active_arrow" href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364'; }else {  echo site_url().'?page_id=354'; }?>">Post A Job</a></span></div><?php } ?>
              <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox">Messages</a></span></div>
              <div><span><a  href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487'; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442'; }?>">My Account</a></span></div>
            </div>
          </div>
		<?php global $wpdb;
	      //$table_name = $wpdb->prefix . "jobpost";
	      if(isset($job_id)){
		//Edit Job
	if(isset($_POST['submit']))
     {
     //print_r($_POST);
     $job_category=$_POST['job_category'];
     $job_type=$_POST['job_type'];
     $job_detail=$_POST['job_detail'];
     $job_estimate=$_POST['estimate'];
     $job_location=$_POST['job_location'];
     $post_code=$_POST['post_code'];
     $salary=$_POST['salary'];
     $salary_time=$_POST['salary_time'];
     $job_detail_cont=$_POST['job_detail'];
     $job_detail=strtolower($job_detail_cont);
     $requirement=$_POST['requirement'];
     $contact_reference=$_POST['contact_reference'];
     $work_duration=$_POST['work_duration'];
     $start_date=$_POST['start_date'];
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
     $currentdate=date("Y-m-d");
     global $wpdb;
     $table_name ="wp_jobpost";
    
	$tmparray=array();
	if($_POST['beforeimg'])
	{
		for($i=0;$i<count($_POST['beforeimg']);$i++)
		{
		  $tmparray[]=$_POST['beforeimg'][$i];
		}
	}
	if($_FILES['myFile']['tmp_name'][0])
	{
		for($i=0;$i<count($_FILES['myFile']['tmp_name']);$i++)
		{
			$tmparray[] = $product_image = time().basename($_FILES['myFile']['name'][$i]);
			move_uploaded_file($_FILES['myFile']['tmp_name'][$i],$path.$product_image);     
		}
	}
	$product_image1=implode("---",$tmparray);
	//print_r($_FILES['myFile']['tmp_name']);
//	$sql2 = "update `" . $table_name ."` set job_title='$job_title',job_category='$job_category',job_type='$job_type',job_detail='$job_detail',job_estimate='$job_estimate',job_location='$job_location',post_code='$post_code',job_name='$job_name',job_quotes='$job_quotes',job_size='$sizeOfJob',job_work_start='$work_start',candidate='$contact',criteria='$criteria',file_name='$tmparray[0]',contact_reference='$contact_reference',post='$post_data',post_date='$currentdate',job_images='$product_image1' where id='$job_id'";
//        $result2 = $wpdb->query($sql2);
	//echo $job_category;
	$data = array('job_category'=>$job_category,'job_type'=>$job_type,'job_detail'=>$job_detail,'job_location'=>$job_location,'post_code'=>$post_code,'file_name'=>$tmparray[0],'contact_reference'=>$contact_reference,'post'=>$post_data,'post_date'=>$currentdate,'user_id'=>$user_id,'job_images'=>$product_image1,'contact_reference'=>$contact_reference,'start_date'=>$start_date,'candidate'=>$candidate_required,'contact_no'=>$contact,'salary'=>$salary,'salary_time'=>$salary_time,'work_duration'=>$work_duration,'job_estimate'=>$job_estimate,'job_expiry'=>$job_expiry,'requirements'=>$requirement,'job_pdf'=>$uppdf);
	 $where = array('id'=>$job_id);
	//$table_name =
	//print_r($data);
	 $row_affected =$wpdb->update($table_name,$data,$where);
     }
     $retrieve_data2 = $wpdb->get_results("SELECT * FROM wp_jobpost where id='$job_id'");
     foreach($retrieve_data2 as $retrieved_data2){
?>
<div class="job-type_field_main">
              <div class="job-title-field-area">
              <div class="job-title-field-area">
           <div class="job-type-field apply join-field-spc-rgt"><span>Job category</span>
	    <?php 
		  $list_all= $wpdb->get_results("SELECT * from wp_jobcategory");
		  $cat_id=$retrieved_data2->job_category;
		  $retrieve_data_cat = $wpdb->get_results("SELECT * from wp_jobcategory where id='$cat_id'");
		  $select_category[]= $retrieve_data_cat[0]->category;?>
                  <div> <span>
                    <select class="text_field" name="job_category" id="job_category">
			<option value="">-Select Category-</option>
		<?php foreach($list_all as $list_all_data ){?>
                    <option title="<?php echo $list_all_data->category ?>" value="<?php echo $list_all_data->category;?>"<?php if($list_all_data->category==$cat_id){echo "selected='selected'";}?>><?php echo $list_all_data->category;?></option>
		   <?php } ?>
                  </select>
                    </span>
		  </div>
                </div>
             <div class="job-type-field"><span class="short_work_description">short job description</span>
		 <div class="job-input-bg"> <span>
                    <input type="text" class="valid" name="job_type" id="job_type" value="<?php echo $retrieved_data2->job_type; ?>">
                    </span>
		  </div>
                </div>
          </div>
	     <div class="job-title-field-area">
            <div class="job-location-field"> <span></span><br>
                  <div class="job-location-bg"> <span>
                    <input type="text" value="<?php echo $retrieved_data2->job_location; ?>" placeholder="Work location" name="job_location" id="job_location">
                  
                    </span> </div>
                </div>
            <div class="job-post-field"> <span></span><br>
                  <div class="job-post-bg post_code_bg"> <span>
                    <input type="text" value="<?php echo $retrieved_data2->post_code;?>" name="post_code" id="post_code" placeholder="Post code"> 
                    </span> </div>
                </div>
          </div>
	<div class="join-field-area">
            <div class="join-title-field salary_bg">
		<div class="job-location-field"><span>Salary</span></div>
                  <div class="job-input-bg "> <span class="salary_amt">
                    <input name="salary" id="salary" type="text" value="<?php echo $retrieved_data2->salary;?>"/>
                    </span>
		<div class="job-type-field apply job_time"> 
		 <?php  $list = array("per hour", "per day", "per week", "per month","per year", "contract", "price work");
		  $select_var[]=  $retrieved_data2->salary_time;
		?>
		<div><span> <select class="text_field valid" name="salary_time" id="salary_time">
		<?php foreach($list as $listing){?> <option value="<?php echo $listing;?>"<?php if(in_array($listing,$select_var)){echo "selected='selected'";}?>><?php echo $listing;?></option>
		<?php } ?>
		</select></span>
		</div></div>
		</div>
                </div>
          </div>
         <div class="join-field-area">
            <div class="job-location-field work_duration_bg"><span>Work Duration</span><br>
                  <div class="job-location-bg"><span>
                    <input type="text" value="<?php echo $retrieved_data2->work_duration;?>" placeholder="" name="work_duration" id="work_duration">
                    </span> </div>
                </div>
          </div>
	   <div class="job-radio-field"> <span>Quote me for<?php $estimate=$retrieved_data2->job_estimate;?></span>
            <div class="job-radio">
                  <input type="radio" name="estimate" id="labour" value="Labour and material" <?php if ($estimate=="Labour and material") echo 'checked="checked" ';?>/>
                  <label for="labour">Labour and material</label>
                </div>
            <div class="job-radio">
                  <input type="radio" name="estimate" id="labour2" value="Labour only" <?php if ($estimate=="Labour only") echo 'checked="checked" ';?>/>
                  <label for="labour2">Labour only</label>
                </div>
          </div>
	   <div class="join-field-area">
	    <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Start Date</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="start_date" id="datepicker" type="text" value="<?php echo $retrieved_data2->start_date;?>"/>
                    </span> </div>
                </div><input type="file" name="myFile[]" id="myFile"  class="multi">
		<?php
					if($retrieved_data2->job_images)
					{
						$beforeimg = explode("---",$retrieved_data2->job_images);
						for($j=0;$j<count($beforeimg);$j++)
						{
						?>
						<div class="MultiFile-label" id="MultiFile_label_id_<?php echo $j;?>">
						<input type="hidden" name="beforeimg[]" value="<?php echo $beforeimg[$j];?>" />
							<a href="javascript:void(0)" onclick="getActivecnt('MultiFile_label_id_<?php echo $j;?>')" class="MultiFile-remove">x</a>
							<span title="File selected: art-2.jpg" class="MultiFile-title"><?php echo $beforeimg[$j]; ?></span>
						</div>
						<?php
						}
					}?>
<!--	    <div class="job-title-field-area">
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<!--<input type="button" class="uploadbtn" id="uploafile">-->
		  <!--</div>
          </div>-->
	     </div>
              <div class="job-textarea-field"> <span>Work description</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="job_detail" id="job_detail" cols="" rows=""><?php echo $retrieved_data2->job_detail;?></textarea>
              </div>
              </span> </div>
          </div>
            <div class="job-textarea-field"> <span>Requirements</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="requirement" id="requirement" cols="" rows=""><?php echo $retrieved_data2->requirements;?></textarea>
              </div>
              </span></div>
          </div>
	   <div class="job-textarea-field"><span>Contact reference</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="contact_reference" id="contact_reference" cols="" rows=""><?php echo $retrieved_data2->contact_reference;?></textarea>
              </div>
              </span> </div>
          </div>
	<div class="job-submit-radio-area">
              <div class="job-radio-submit-field">
             <div class="job-radio">
	     <?php $post_job= $retrieved_data2->post;?>
                  <input type="radio" name="postg" id="labour"  value="Post more jobs" <?php if ($post_job=="Post more jobs") echo 'checked="checked" ';?>/>
                  <label for="labour">Post more jobs</label>
                </div>
           <div class="job-radio">
                   <input type="radio" name="postg" id="labour2" value="No more jobs" <?php if ($post_job=="No more jobs") echo 'checked="checked" ';?>/>
                  <label for="labour2">No more jobs</label>
                </div>
          </div>
            <div class="post-job-submit">
	       <input type="hidden" name="submit" value="submit" />
	       <input name="image" type="image" value="Submit" src="<?php bloginfo('template_url'); ?>/images/post-job-submit.png">
	  <!--   <input type= "submit" alt="Search" src="http://constructionmates.co.uk/wp-content/themes/constructionmates/images/post-job-submit.png" value="Submit" name="image">
              <input name="submit" type="submit" value="Submit" />-->
            </div>
	    </div>    
            </div>
	    </div>
	    </form>
	  
     <?php     
}
}
else {
	  if(isset($_POST['submit']))
     {
     //print_r($_POST);
     //$job_title=$_POST['job_title'];
     $job_category=$_POST['job_category'];
     $job_type=$_POST['job_type'];
     $job_detail=$_POST['job_detail'];
     $job_estimate=$_POST['estimate'];
     $job_location=$_POST['job_location'];
     $post_code=$_POST['post_code'];
     $salary=$_POST['salary'];
     $salary_time=$_POST['salary_time'];
     $job_detail_cont=$_POST['job_detail'];
     $job_detail=strtolower($job_detail_cont);
     $requirement=$_POST['requirement'];
     $contact_reference=$_POST['contact_reference'];
     $work_duration=$_POST['work_duration'];
     $start_date=$_POST['start_date'];
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
     $currentdate=date("Y-m-d");
     global $wpdb;
     $table_name ="wp_jobpost";
     $tmparray=array();
	for($i=0;$i<count($_FILES['myFile']['tmp_name']);$i++)
	{
	$tmparray[] = $product_image = time().basename($_FILES['myFile']['name'][$i]);
	move_uploaded_file($_FILES['myFile']['tmp_name'][$i],$path.$product_image);     
	}
	$product_image1=implode("---",$tmparray);
	$data = array('job_category'=>$job_category,'job_type'=>$job_type,'job_detail'=>$job_detail,'job_location'=>$job_location,'post_code'=>$post_code,'file_name'=>$tmparray[0],'contact_reference'=>$contact_reference,'post'=>$post_data,'post_date'=>$currentdate,'user_id'=>$user_id,'job_images'=>$product_image1,'contact_reference'=>$contact_reference,'start_date'=>$start_date,'candidate'=>$candidate_required,'contact_no'=>$contact,'salary'=>$salary,'salary_time'=>$salary_time,'work_duration'=>$work_duration,'job_estimate'=>$job_estimate,'job_expiry'=>$job_expiry,'requirements'=>$requirement,'job_pdf'=>$uppdf);
	$row_affected =$wpdb->insert($table_name,$data);
	
}                                                                                                                                                    
?><div class="job-type_field_main">
              <div class="job-title-field-area">
              <div class="job-title-field-area">
            <div class="job-type-field apply join-field-spc-rgt"><span>Job category</span>
                  <div><span>
                   <select class="text_field" name="job_category" id="job_category">
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
             <div class="job-type-field"><span class="short_work_description">short job description</span>
		 <div class="job-input-bg"> <span>
                    <input type="text" class="valid" name="job_type" id="job_type" value="">
                    </span>
		  </div>
                </div>
          </div>
	     <div class="job-title-field-area">
            <div class="job-location-field"> <span></span><br>
                  <div class="job-location-bg"> <span>
                    <input type="text" value="" placeholder="Work location" name="job_location" id="job_location">
                    </span> </div>
                </div>
            <div class="job-post-field"> <span></span><br>
                  <div class="job-post-bg post_code_bg"> <span>
                    <input type="text" value="" name="post_code" id="post_code" placeholder="Post code"> 
                    </span> </div>
                </div>
          </div>
	  <div class="join-field-area">
            <div class="join-title-field salary_bg">
		<div class="job-location-field"><span>Salary</span></div>
                  <div class="job-input-bg "> <span class="salary_amt">
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
          <div class="join-field-area">
            <div class="job-location-field work_duration_bg"><span>Work Duration</span><br>
                  <div class="job-location-bg"><span>
                    <input type="text" value="" placeholder="" name="work_duration" id="work_duration">
                    </span> </div>
                </div>
          </div>
	   <div class="job-radio-field"> <span>Quote me for<?php $estimate=$retrieved_data2->job_estimate;?></span>
            <div class="job-radio">
                  <input type="radio" name="estimate" id="labour" value="Labour and material" <?php if ($estimate=="Labour and material") echo 'checked="checked" ';?>/>
                  <label for="labour">Labour and material</label>
                </div>
            <div class="job-radio">
                  <input type="radio" name="estimate" id="labour2" value="Labour only" <?php if ($estimate=="Labour only") echo 'checked="checked" ';?>/>
                  <label for="labour2">Labour only</label>
                </div>
          </div>
	   <div class="join-field-area">
	    <div class="join-title-field join-field-spc-rgt">
	    <div class="job-location-field"><span>Start Date</span></div>
                  <div class="job-input-bg"> <span>
                    <input name="start_date" id="datepicker" type="text" value=""/>
                    </span> </div>
                </div><input type="file" name="myFile[]" id="myFile"  class="multi">
	    <div class="job-title-field-area">
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<!--<input type="button" class="uploadbtn" id="uploafile">-->
		  </div>
          </div>
	     </div>
              <div class="job-textarea-field"> <span>Work description</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="job_detail" id="job_detail" cols="" rows=""></textarea>
              </div>
              </span> </div>
          </div>
            <div class="job-textarea-field"> <span>Requirements</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="requirement" id="requirement" cols="" rows=""></textarea>
              </div>
              </span></div>
          </div>
	   <div class="job-textarea-field"><span>Contact reference</span>
            <div class="job-textarea-bg"> <span>
              <div>
                <textarea name="contact_reference" id="contact_reference" cols="" rows=""></textarea>
              </div>
              </span> </div>
          </div>
	<div class="job-submit-radio-area">
              <div class="job-radio-submit-field">
            <div class="job-radio">
                  <input type="radio" name="postg" id="labour"  value="Post more jobs"/>
                  <label for="labour">Post more jobs</label>
                </div>
            <div class="job-radio">
                   <input type="radio" name="postg" id="labour2" value="No more jobs"/>
                  <label for="labour2">No more jobs</label>
                </div>
          </div>
             <div class="post-job-submit">
	       <input type="hidden" name="submit" value="submit" />
	       <input name="image" type="image" value="Submit" src="<?php bloginfo('template_url'); ?>/images/post-job-submit.png">
	  <!--   <input type= "submit" alt="Search" src="http://constructionmates.co.uk/wp-content/themes/constructionmates/images/post-job-submit.png" value="Submit" name="image">
              <input name="submit" type="submit" value="Submit" />-->
            </div>
	    </div>    
            </div>
	    </div>
	    </form>
<?php }
}
?>