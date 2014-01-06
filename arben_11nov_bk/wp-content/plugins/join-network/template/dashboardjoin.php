<script language="JavaScript" type="text/javascript">
       siteurl= '<?php echo site_url(); ?>';
	$(document).ready(function(){
		    getData(); //function for latlong
		$("#uploafile").click(function()
				      {
				        $('#simple-local-avatar').trigger('click');
				      });
		$('#simple-local-avatar').change(function(){
				$("#imagename").val($('#simple-local-avatar').val());
				});
	      $("#uploadwork_imag").click(function()
				      { 
				        $('#workfile').trigger('click');
				      });
		$('#workfile').change(function(){
				$("#work_imagename").val($('#workfile').val());
				});
	
		$("#newsletter_id").click(function(){ 
			        chk = $("#newsletter_id").is(":checked");
				email_address = $("#user_email").val();
				xyz_em_name = $("#name").val();
				
				if(chk == true && email_address !="" && xyz_em_name !="")
				{
				  //alert('in');
				   $.post(siteurl+"/wp-content/plugins/newsletter-manager/subscription.php", {xyz_em_email: ""+email_address+"",xyz_em_name: ""+xyz_em_name+""}, function(data){
                                                    // alert(data);
                                                    });
				}
				
		  });
	
	});
	
	       $(function() {
		  
			$('#submitlink').click(function(e) {
			  getData();
			    e.preventDefault();
			    
			  $("#frm_userdetail").submit();
			 });
			$('.checkedradio').change(function() {
			    $('#aaiu-uploader').removeAttr("disabled");
			 });
			   /**********for befor/after img************/
		
	    });
</script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript">
  
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
<style>
  .t_area{
    text-transform: uppercase;
   }

</style>
<script>
$(function(){
       $(".show_paydonate_mobile").hide();
  $("a.show_paymobile").click(function(){
    $(".show_paydonate_mobile").slideToggle();
  }); 
});
</script>
<?php 
            if (!is_user_logged_in()) {
	wp_redirect(site_url().'?page_id=18', 301 ); exit;
}
	     $user_type=$_REQUEST['usertype'];
	     global $wpdb;
	     global $current_user;
	    if($current_user->data->user_login){
	    $user=$current_user->data->user_login;
	    }
	    $retrieve_data = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
	    $id=$retrieve_data[0]->ID;
	  //Update table
	//die('===');
	     if(isset($_POST['first_name']))
	    { 
	       
	    $avail_select=$_POST['avail_select'];
	    $gender=$_POST['gender'];
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
	    $email_promotion=$_POST['option2'];
	    $email=$_POST['email'];
	    $password=$_POST['password'];
	    $p_image=$_POST['myFile'];
	    $about_company_str=$_POST['about_us'];
	    $about_company=strtolower($about_company_str);
	    $skill=$_POST['skill'];
	    $work_area=$_POST['work_area'];
	    $feedback=$_POST['feedback'];
	    $contact_me=$_POST['contact_me'];
	    $newpassword=$_POST['new_password'];
	    $accre=array($_POST['cscs'],$_POST['first_add'],$_POST['gas_safe'],$_POST['city_guids'],$_POST['ipaf'],$_POST['pasha']);
	    $accrediations = implode(',',$accre);
	    $latitude = $_POST['latitude'];
	    $longitude = $_POST['longitude'];
	    $site_url = $_POST['site_url'];
	    $slogan = $_POST['slogan'];
	    $trades_name =$_POST['trades1'];
	    $trades_name=implode(",",$trades_name);
             if($newpassword!="")
	     {
		     wp_update_user( array ('ID' => $id, 'user_pass' => $newpassword) ) ;
	     }
	    update_user_meta( $id, 'available',$avail_select);
 	    update_user_meta( $id, 'gender',$gender);
	    update_user_meta( $id, 'first_name',$fname);
	    update_user_meta( $id, 'last_name',$lname);
	    update_user_meta( $id, 'company_name',$company_name);
	    update_user_meta( $id, 'address1',$address1);
	    update_user_meta( $id, 'address2',$address2);
	    update_user_meta( $id, 'city',$city);
	    update_user_meta( $id, 'post_code',$postcode);
	    update_user_meta( $id, 'mobile',$mobile);
	    update_user_meta( $id, 'phone',$phone);
	    update_user_meta( $id, 'about_company',$about_company);
	    update_user_meta( $id, 'skill',$skill);
	    update_user_meta( $id, 'work_area',$work_area);
	    update_user_meta( $id, 'feedback',$feedback);
	    update_user_meta( $id, 'contact_me',$contact_me);
	    update_user_meta( $id, 'promotion',$email_promotion);
            update_user_meta( $id, 'trades_name',$trades_name);
            update_user_meta( $id, 'site_url',$site_url);
            update_user_meta( $id, 'slogan',$slogan);
	    $usertype = $_POST['user_type'];
	    
	       $tbl_name = $wpdb->prefix.'userlatlong';
	       $latdata=array('userid'=>$id, 'lat'=>$latitude, 'lng'=>$longitude, 'usertype'=>$usertype);
	       $userdata = $wpdb->get_results("select * FROM ".$wpdb->prefix."userlatlong where userid=".$id);
	       if($userdata[0]->id)
	       {
		$where = array('id'=>$userdata[0]->id);
		 $row_affected =$wpdb->update($tbl_name,$latdata,$where);
	       }
	       else
	       {
		 $row_affected =$wpdb->insert($tbl_name,$latdata);
	       }
	    update_user_meta( $id, 'accreditations',$accrediations);
	    $myAv = new simple_local_avatars();
	    $myAv->edit_user_profile_update($id);
	    //add_post_meta($post_id, 'category', $meta_value);
	wp_redirect(site_url().'?page_id=442', 301 ); exit;
	    }
	    $retrieve_data1 = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
	    $id1=$retrieve_data1[0]->ID;
	    $email=$retrieve_data1[0]->user_email; 
	    $all_meta_for_user = get_user_meta( $id1 );
	    // print_r($all_meta_for_user['trades_name'][0]);
	  $user_type=$all_meta_for_user['usertype'][0];?>
	<div class="mobile_myaccount_page">
	  <form name="frm_userdetail" id="frm_userdetail" action="" method="post" enctype="multipart/form-data">
	 
	   <div class="job-title-field-area">
           <input type="hidden" id="user_type_val" name="user_type" value="<?php echo $user_type;?>"/>
	   <div class="new_top_section">
       <div class="welcome_txt">
	<h3>Welcome <?php /*Hello <?php if($user_type==2){echo "Traders";} elseif($user_type==3){echo "Builders";} */ ?> </h3></div>
          <div class="availble_txt">
		 <div><span>
                    <select name="avail_select" id="avail_select" class="text_field">
                    <option value="Available " <?php if($all_meta_for_user['available'][0] == "Available "){?> selected="selected" <?php }?>>Available</option>
                    <option value="Not available" <?php if($all_meta_for_user['available'][0] == "Not available"){?> selected="selected" <?php }?>>Not available</option>
                    </select>
                    </span></div>
                </div>
	  </div>
		<?php
	
		//include( dirname( __FILE__ ).'/Mobile_Detect.php');
		//$detect = new Mobile_Detect;
		preg_match("/src='(.*?)'/i",get_avatar($id1,202,105), $matches);
			  //echo $matches[0];
			  $a=explode('=',$matches[0]);
			  $a1=explode("'",$a[1]);
		         $image_name=(explode("/",$a1[1]));
			?>
	       <div class="profile_img"><img src="<?php echo $a1[1];?>"></div>
	       <!--<img class="available" alt="innovation" src="<?php //bloginfo('template_url')?>/images/innovation.png">-->
        <?php if($user_type == 2){
	      ?>
	       <div class="builder builder2">
		 <div><span><a href="<?php echo site_url();?>?page_id=1465">Home</a></span></div>
              <div>
	       <span>
		    <?php if (get_template()=="constructionmatesss_mob") {
		    ?>
		     	<a href="<?php if($user_type ==2){ echo site_url().'?page_id=15&theme=handheld'; }else {  echo site_url().'?page_id=1044&theme=handheld'; }?>">Jobs</a>
		    <?php }else{?>
		     <a href="<?php if($user_type ==2){ echo site_url().'?page_id=15'; }else {  echo site_url().'?page_id=1044'; }?>">Jobs</a>
		     <?php }?>
	       </span>
	      </div>
	    
        <?php if($user_type!=2){?> <div><span>
		     <?php if (get_template()=="constructionmatesss_mob") {?>
		      <a href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364&theme=handheld'; }else {  echo site_url().'?page_id=354&theme=handheld'; }?>">Post A Job</a></span></div>
		     <?php }else{?>
		            <a href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364'; }else {  echo site_url().'?page_id=354'; }?>">Post A Job</a></span></div>
		     <?php }
	       } ?>
	         <?php if (get_template()=="constructionmatesss_mob") {?>
		       <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox&theme=handheld">Messages</a></span></div>
		      <div><span> <a class="active_arrow" href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&usertype='.$user_type.'&theme=handheld'; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442&usertype='.$user_type.'&theme=handheld'; }?>">My Account</a></span></div>
	      <?php }else{?>
		      <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox">Messages</a></span></div>
		      <div><span> <a class="active_arrow" href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&usertype='.$user_type; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442&usertype='.$user_type; }?>">My Account</a></span></div>
	     <?php }?>
	      </div>
       <?php } else{?>
		      <?php if (get_template()=="constructionmatesss_mob") {?>
	    <div class="builder">
		 <div><span><a href="<?php echo site_url();?>?page_id=1465&theme=handheld">Home</a></span></div>
              <div>
	       <span>
		<a href="<?php if($user_type ==2){ echo site_url().'?page_id=15&theme=handheld'; }else {  echo site_url().'?page_id=1044&theme=handheld'; }?>">Jobs</a>
	       </span>
	      </div>
             <?php if($user_type!=2){?> <div><span><a href="<?php if(($user_type ==4)|| ($user_type ==3)){ echo site_url().'?page_id=1364&theme=handheld'; }else {  echo site_url().'?page_id=354&theme=handheld'; }?>">Post A Job</a></span></div><?php } ?>
              <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox&theme=handheld">Messages</a></span></div>
              <div><span> <a class="active_arrow" href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&usertype='.$user_type.'&theme=handheld'; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442&usertype='.$user_type.'&theme=handheld'; }?>">My Account</a></span></div>
            </div>
	    <?php }else{?>
	       <div class="builder">
		 <div><span><a href="<?php echo site_url();?>?page_id=1465">Home</a></span></div>
              <div>
	       <span>
		<a href="<?php if($user_type ==2){ echo site_url().'?page_id=15'; }else {  echo site_url().'?page_id=1044'; }?>">Jobs</a>
	       </span>
	      </div>
             <?php if($user_type!=2){?> <div><span><a href="<?php if(($user_type ==4)|| ($user_type ==3)){ echo site_url().'?page_id=1364'; }else {  echo site_url().'?page_id=354'; }?>">Post A Job</a></span></div><?php } ?>
              <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox">Messages</a></span></div>
              <div><span> <a class="active_arrow" href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&usertype='.$user_type; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442&usertype='.$user_type; }?>">My Account</a></span></div>
            </div>
	  <?php    } } ?>
          </div>
<div class="join-field-part">
      <div class="join-field-area">
	    <div class="join-name-field join-name">
	     <div><span>
		 <select class="name-text_field" name="gender">
		    <option value="Mr" <?php if($all_meta_for_user['gender'][0] == "Mr"){?> selected="selected" <?php }?>>Mr</option>
		    <option value="Mrs" <?php if($all_meta_for_user['gender'][0] == "Mrs"){?> selected="selected" <?php }?>>Mrs</option>
		    <option value="Miss" <?php if($all_meta_for_user['gender'][0] == "Miss"){?> selected="selected" <?php }?>>Miss</option>
		 </select>
		 </span>
	     </div>
	   </div>
	   
                <div class="join-firstname-field join-name-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input  type="text" id="name" name="first_name" value="<?php echo $all_meta_for_user['first_name'][0]; ?>" placeholder="first name"/>
                    </span> </div>
                </div>
                <div class="join-firstname-field">
                  <div class="job-input-bg"> <span>
                    <input name="last_name" type="text"  value="<?php echo $all_meta_for_user['last_name'][0];?>" placeholder="last name"/>
                    </span> </div>
                </div>
          </div>
                <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="company_name" type="text"  value="<?php echo $all_meta_for_user['company_name'][0];?>" placeholder="company name"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input id="user_email" name="user_email" type="text"  value="<?php echo $retrieve_data[0]->user_email;?>" placeholder="user email"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="address1" type="text"  value="<?php echo $all_meta_for_user['address1'][0];?>" placeholder="address1"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="address2" type="text"  value="<?php echo $all_meta_for_user['address2'][0];?>" placeholder="address2"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input id="city" name="city" type="text" onblur="getData();" onkeypress="getData();"  value="<?php echo $all_meta_for_user['city'][0];?>" placeholder="city" />
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input type="text" value="<?php echo $all_meta_for_user['post_code'][0];?>" name="postcode" placeholder="postcode">
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="mobile" type="text"  value="<?php echo $all_meta_for_user['mobile'][0];?>" placeholder="mobile"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="phone" type="text"  value="<?php echo $all_meta_for_user['phone'][0];?>" placeholder="Phone" />
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
                <div class="join-title-field join-field-spc-rgt">
                      <div class="job-input-bg"> <span>
                        <input name="email" type="text"  value="<?php echo $retrieve_data[0]->user_email;?>" placeholder="email"/>
                        </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
		    <input name="new_password"  type="password"  placeholder="Change Password" value=""/>
                    </span> </div>
                </div>
          		</div>
			<div class="join-field-area">
             
                      <div class="job-input-bg url_site url_moblie"> <span>
                        <input type="text" name="site_url" type="url" value="<?php echo $all_meta_for_user['site_url'][0];?>" placeholder="site Url ex: (http://example.com)" />
                        </span> </div>
               
          		</div>
			
			 <div class="job-title-field-area">
			      <div class="job-upload-field">
			       <div class="job-upload-bg"><span>
			      <input type="file" name="simple-local-avatar" style="display:none" id="simple-local-avatar" accept="image/*" class="valid">
				<!-- Fake field to fool the user -->
				<input type="text" name="imagename" readonly="true" id="imagename" value="<?php //echo($image_name[7]);?>"> 
			    </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" class="uploadbtn" id="uploafile" value=" <?php if (get_template()=="constructionmatesss_mob") { echo 'Upload Images';}?>">
				 </div>
			 </div>
			 
		  <span id="error_msg" style="color:red;"></span>
                <div class="tradesmultiple">
		<?php   $tradesdata = $wpdb->get_results("SELECT * from wp_trades_categories order by category_name asc");
			$trades_names= $all_meta_for_user['trades_name'][0];
			  $selected_trades=explode(",", $trades_names);
		     ?>
		    
<script type="text/javascript">
  $(document).ready(function(){
    icnt=$("#icnt").val();
    $("#add_more").click(function(){
	  user_type_val = $("#user_type_val").val();
	  if(user_type_val == "2" && icnt>=3)
	  {
	    return false;
	  }
	  if(user_type_val == "3" && icnt>=8)
	  {
	    return false;
	  }
	  add_data = '<select name="trades1[]" class="text_field" id="trades_'+icnt+'"><?php  foreach($tradesdata as $trades){?><option  value="<?php echo $trades->category_name;?>"><?php echo $trades->category_name;?></option><?php }?></select>';
	  $(".trade_innerspan").append(add_data);
	  icnt++;
	  });
    });
  

</script>		      <?php if($user_type ==2){ echo "<h4>Maximum 3 trades </h4>"; } else {echo "<h4>Maximum 8 trades</h4>";}?>     <a id="add_more" href="javascript:void(0);">+category</a>
                  <div class="trade_innerdiv" id="trade_innerdiv_id">
		   
		  <span class="trade_innerspan">
		   <?php
		   if($trades_names)
		   {
		    for($j=0;$j<count($selected_trades);$j++)
		    {
		   ?>
                    <select name="trades1[]" class="text_field" id="trades_<?php echo $j;?>">
		    <?php  foreach($tradesdata as $trades){?>
		    <option <?php if($trades->category_name == $selected_trades[$j]) {?> selected="selected" <?php } ?> value="<?php echo $trades->category_name;?>"><?php echo $trades->category_name;?></option>
	    <?php }?>
                  </select>
		    <?php } ?>
		    <input type="hidden" id="icnt" name="icnt" value="<?php echo $j;?>" />
		   <?php }
		    else
		    {
		      ?>
		      <select name="trades1[]" class="text_field" id="trades_0">
		    <?php  foreach($tradesdata as $trades){?>
		    <option value="<?php echo $trades->category_name;?>"><?php echo $trades->category_name;?></option>
	    <?php }?>
                  </select>
		      <input type="hidden" id="icnt" name="icnt" value="1" />
		      <?php
		    }
		    ?>
                    </span>
                  </div>
		
		  <!--<input type="hidden" name="trades" id="trades1" value=""/> -->
               <!--<input type="submit" name="submit" value="submit"> -->
                </div>
		<?php if($user_type ==3) {?><div class="join-field-area"><h4>add here your company slogan</h4>
		<input type="text" class="slogan_txt_inner" name="slogan" placeholder="slogan" id="slogan" value="<?php echo $all_meta_for_user['slogan'][0];?>">
		      </div><?php }?>
		<?php
		$accred=$all_meta_for_user['accreditations'][0];
		$ac1=explode(",",$accred);
		 ?>
	       <div class="btn-acrdtn-part">
                  <h3>accreditations <span class="accredential_txt">(Type your accreditations below)</span></h3>
                  <div class="acrdtn-btn"> <span><input type="text"  name="cscs" value="<?php if(isset($accred)) {echo $ac1[0];}else{echo "CSCS";} ?>" /></span> </div>
                  <div class="acrdtn-btn"> <span><input type="text"  name="first_add" value="<?php if(isset($accred)){ echo $ac1[1];}?>" /></span> </div>
                  <div class="acrdtn-btn"> <span><input type="text"  name="gas_safe" value="<?php if(isset($accred)){ echo $ac1[2];}?>" /></span> </div>
                  <div class="acrdtn-btn"> <span><input type="text"  name="city_guids" value="<?php if(isset($accred)){echo $ac1[3];}?>" /></span> </div>
                  <div class="acrdtn-btn"> <span><input type="text"  name="ipaf" value="<?php if(isset($accred)){echo $ac1[4];}?>"/></span> </div>
                  <div class="acrdtn-btn"> <span><input type="text"  name="pasha" value="<?php if(isset($accred)){echo $ac1[5];}?>"/></span> </div>
		  
		   <!--  <div class="acrdtn-btn"> <span><a href="#">CSCS</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">First AID</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">Gas Safe</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">City Guids</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">IPAF</a></span> </div>
                  <div class="acrdtn-btn"> <span><a href="#">PASHA</a></span> </div>-->
                </div>
		<div>
		     <?php if (get_template()!="constructionmatesss_mob") { ?>
		<div><?php echo do_shortcode('[AAIU theme="true"]'); ?></div><?php }?>
		 <div class="">
			     
          </div>
                <div class="accnt_info" style="margin-top:10%;">
		<div class="personal_container">

		<span class="personal_title" >About us</span>
                <div>
                    <textarea class="t_area" name="about_us" ><?php echo $all_meta_for_user['about_company'][0]?></textarea>
                   </div>
                   </div>
                   <div class="personal_container">
                     <span class="personal_title">My Skills</span>
                   <div>
                        <textarea class="t_area" name="skill"><?php echo $all_meta_for_user['skill'][0]?></textarea>
                    </div>
        	      </div>
                       <div class="personal_container">
                     <span class="personal_title">Work Area</span>
                     <div>
                        <textarea class="t_area" name="work_area"><?php echo $all_meta_for_user['work_area'][0]?></textarea>
                    </div>
                 </div>
            	 <div class="personal_container">
                    <span class="personal_title">Customer Feedback</span>
                    <div>
                       <?php echo do_shortcode('[show_rating]');?>
                    </div></div>
                  
                 <div class="personal_container">
                     <span class="personal_title">Contact Me</span>
                    <div>
                        <textarea class="t_area" name="contact_me"><?php echo $all_meta_for_user['contact_me'][0]?></textarea>
                    </div>
                     </div>
                </div><!--accnt info-->
		<?php
		     if (get_template()=="constructionmatesss_mob") {?>
		<div><?php echo do_shortcode('[AAIU theme="true"]'); ?></div><?php }?>
		
                <div class="accnt_recent-work" style="margin-top:5%;">
                	<div class="recent-work-area">
                      <h3>Recent Work</h3>
                      <div class="recent-work-plc">
                    	<span class="before">Before</span>
                    	<div class="recent-work" id="Before">
			  <?php
			  $current_user = wp_get_current_user();
			  $uid  = $current_user->ID;
			  $tbl_name = $wpdb->prefix.'postmeta';
			  $que = "select a.*, b.*, c.meta_value as image from $tbl_name as a, $tbl_name as b, $tbl_name as c where a.meta_key = 'user' and a.meta_value =$uid and b.meta_value='before' and c.meta_key = '_wp_attached_file' and a.post_id=b.post_id and b.post_id=c.post_id";
			  $data = $wpdb->get_results($que);
			  //echo "<pre>";
			  //print_r($data);
			  if($data)
			  {
			    for($i=0;$i<count($data);$i++)
			    {
			      ?>
			      <span class="aaiu-uploaded-files clearfix"><img name="art-2" src="http://constructionmates.co.uk/wp-content/uploads/<?php echo $data[$i]->image; ?>">
			      <br><a data-upload_id="<?php echo $data[$i]->post_id; ?>" class="action-delete" href="#">Delete</a></span><input type="hidden" value="<?php echo $data[$i]->post_id; ?>" name="aaiu_image_id[]">
			      <?php
			    }
			  }
			  ?>
			   </div>
                  	  </div>
                      <div class="recent-work-plc">
                    	<span class="after">After</span>
                    	<div class="recent-work rcnt-wrk-last" id="after">
			  <?php
			  $current_user = wp_get_current_user();
			  $uid  = $current_user->ID;
			  $tbl_name = $wpdb->prefix.'postmeta';
			  $que = "select a.*, b.*, c.meta_value as image from $tbl_name as a, $tbl_name as b, $tbl_name as c where a.meta_key = 'user' and a.meta_value =$uid and b.meta_value='after' and c.meta_key = '_wp_attached_file' and a.post_id=b.post_id and b.post_id=c.post_id";
			  $data = $wpdb->get_results($que);
			  //echo "<pre>";
			  //print_r($data);
			  if($data)
			  {
			    for($i=0;$i<count($data);$i++)
			    {
			      ?>
			      <span class="aaiu-uploaded-files clearfix"><img name="art-2" src="http://constructionmates.co.uk/wp-content/uploads/<?php echo $data[$i]->image; ?>">
			      <br><a data-upload_id="<?php echo $data[$i]->post_id; ?>" class="action-delete" href="#">Delete</a></span><input type="hidden" value="<?php echo $data[$i]->post_id; ?>" name="aaiu_image_id[]">
			      <?php
			    }
			  }
			  
			  ?>
			</div>
                  	  </div>
                    </div>
                </div>
          	
                <div class="job-submit-radio-area">
              <div class="job-radio-submit-field">
            <div class="job-radio">
		  <?php  $p_value=$all_meta_for_user['promotion'][0];
		 //echo $email;
		  $query="select a.status from ".$wpdb->prefix."xyz_em_address_list_mapping as a, ".$wpdb->prefix."xyz_em_email_address as b where b.email= '".$email."' and b.id=a.ea_id";
		 $status = $wpdb->get_var($query);
		  
		  ?>
		  
                  <input type="checkbox" id="newsletter_id" name="option1" value="0" <?php if($status==1){?>checked="checked"<?php }?> />
                  <label for="labour">Subscribe to Our Email Newsletter</label>
                </div>
            <div class="job-radio">
		<input type="checkbox" id="labour2" name="option2" value="1" <?php if ($p_value) echo 'checked="checked" '; ?> >
                  <label for="labour2">Subscribe to Promotion</label>
                </div>
          </div>
          </div>
          <input type="hidden" name="latitude" id="latitude" value="" />
	  <input type="hidden" name="longitude" id="longitude" value="" />
          <div class="accnt_btns clearfix">
              <div><span><a href="#" id="submitlink" >Submit</a></span></div>
              <div><span><a href="#">Renew Membership</a></span></div>
	      <div><span><a href="<?php echo site_url()?>/?page_id=1273">Create Resume</a></span></div>
	      <div><span><a onclick="return confirm('Are You Sure, You want to delete Account ?')" href="<?php echo site_url().'?close='.$id;?>">Close Account</a></span></div>
	  </form>
	
	  <!--For mobiile view-->
	         <?php if (get_template()=="constructionmatesss_mob") {?>
	       <div><span><a  href="javascript:void(0)" id="sampledonation" class="show_paymobile">Pay/Donate</a><?php echo do_shortcode('[frontDonationMobile]') ;?></span></div>
	       <?php
		     
		     global $wpdb;
		     $tbl_name1 = $wpdb->prefix.'paypal';
		     $tbl_name = $wpdb->prefix.'paypalsetting';
		     $results = $wpdb->get_results("select * from $tbl_name");
?>
		     <div class="show_paydonate_mobile">
		     <form action="<?php  echo  plugins_url().'/donation/front.php';?>" name="donationform" method="post" >
			       <p>You can Change the Amount</p><input type="text" name="amount" value="<?php echo $results[0]->amount; ?>" />
			    <input class="button" type="submit" name="Save" value="Donate" />
		     </form>
		     </div>
		     <!--End mobiile view-->
	       <?php } else {?>
              <div><span><?php echo do_shortcode('[frontDonation]') ;?></span></div><?php } ?>
             
          </div>
	  
          <div class="job-list-area full">
			<?php /*<h3>News</h3>
            <div class="job-list-part">
		<?php  query_posts( array ( 'category_name' => 'News', 'posts_per_page' => 1 ) ); ?>
			<?php while (have_posts()) : the_post(); ?>
                <?php if(get_the_post_thumbnail( get_the_ID())==""){ ?>
			       <div class="job-img-part"><img src="<?php bloginfo('template_url')?>/images/logo-img-demo.png" alt=""></div>
			    <?php }else{ ?>
                  <div class="job-img-part"><?php echo get_the_post_thumbnail( get_the_ID());?></div> <?php } ?>
                  <div class="job-list-txt-plc">
              <h5><?php the_title(); ?></h5>
				<?php the_excerpt();?>
				
                <div class="read-more-job-btn"><span><a href="<?php echo '?p='.get_the_ID();?>">Read More</a></span> </div>
              </div> <?php endwhile;?>
            </div>
	    */ ?>
            </div>
       </div>
       </div>

</div>
<style>
.job-list-area ul{
  display: none;
}
</style>