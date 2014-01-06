<?php define('ABSPATH', dirname(__FILE__) . '/');
?>
<script language="JavaScript" type="text/javascript">
      
	$(document).ready(function(){
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
	});
   $(function() {
   $('#submitlink').click(function(e) {  
       e.preventDefault();
     $("#frm_userdetail").submit();s
    });
   });
</script>
<script>
   function Blur(id)
{
    // do whatever in here
    alert(document.getElementById("lastBox").value = id);
}
</script>
<script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script>
<script>
$(function(){
       $(".show_paydonate_mobile").hide();
  $("a.show_paymobile").click(function(){
    $(".show_paydonate_mobile").slideToggle();
  }); 
});
</script>
<style>
/* popup_box DIV-Styles*/
#popup_box { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:23%;  
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

#show_images
{
	
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	
	width:45%;
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
#popupBoxClose_img {
	font-size:12px;  
	line-height:15px;  
	right:-18px;  
	top:5px;  
	position:absolute;  
	color:#6fa5e2;  
	font-weight:500;  	
}
.image_ul 
li{
	float: left;
	height: 200px;
	width: 200px;
	padding: 5px;
	list-style: none;
}
li img { height: 200px !important;}
/*popup box*/
</style>
<script type="text/javascript">
	
	$(document).ready( function() {
	
		// When site loaded, load the Popupbox First
		//loadPopupBox();
	$('#mydoc_link').click(function(){
		loadPopupBox();
		});
		$('#popupBoxClose').click( function() {			
			unloadPopupBox();
		});
		
		//$('#container').click( function() {
		//	unloadPopupBox();
		//});

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
<div class="mobile_myaccount_page">
<form name="frm_userdetail" id="frm_userdetail" action="" method="post" enctype="multipart/form-data">
<div id="popup_box">	<!-- OUR PopupBox DIV-->
	<div>
	<a id="popupBoxClose"><img  width="25%" src="<?php bloginfo('template_url')?>/images/close.png"  alt="Close"/></a>
	</div>
	<div>
	<?php global $wpdb;
            global $current_user;
	    if($current_user->data->user_login){
	    $user=$current_user->data->user_login;
	    $user_id=$current_user->data->ID;
	    }
	if(isset($_POST['submit_doc']))
	{
        $user_id;
        $path=ABSPATH."wp-content/uploads/mydoc/";
       $table_name ="wp_mydoc";
       $uppdf = basename($_FILES['docfile']['name']);
       $type=$_FILES['docfile']['type'];
       $status=0;
       //$allowedExts = array("pdf", "txt", "doc", "docx", "dot");
       //$extension = end(explode(".", $_FILES["docfile"]["name"]));
       if($type=="application/pdf" || "application/doc")
     {
    
	move_uploaded_file($_FILES['docfile']['tmp_name'],$path.$uppdf);
	 $data = array('doc_name'=>$uppdf,'userid'=>$user_id,'check_status'=>$status);
	 //$where = array('id'=>$job_id);
	 $rowaffected = $wpdb->insert($table_name,$data);
 }
     else{
	echo "Upload  PDF file or doc file only ";
     }
	}
	?>
	<h5>Attach your company document</h5><br>
	<h6>(upload only pdf or doc files)</h6>
	<div id="ajax_responce"></div>
	<input type="file" name="docfile"><br><br><input type="hidden" value="<?php echo $u_id ?>" name="uid">
	<!--<div><span><a href="javascript:void(0);"  class="apply_nw_btn" id="doc_apply" >Submit</a></div>-->
	<input type="submit" name="submit_doc" value="submit" style="  background: none repeat scroll 0 0 #22B4EB;border: medium none;border-radius: 3px 3px 3px 3px;color: #FFFFFF;padding: 5px 20px;">
	</div>
</div>
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
            $ea_id = $wpdb->get_results("SELECT ea_id from wp_xyz_em_additional_field_value where `field1`='$user'"); 
	    $status = $wpdb->get_results("SELECT status from wp_xyz_em_address_list_mapping where `ea_id`='".$ea_id[0]->ea_id."'");print_r();
	     $id=$retrieve_data[0]->ID;
	  //Update table  
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
	    $about_us_str=$_POST['about_us'];
	    $about_us=strtolower($about_us_str);
	    $company_terms=$_POST['company_terms'];
	    $newpassword=$_POST['new_password'];
	    $company_slogan=$_POST['slogan'];
	    $url=$_POST['url'];
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
	    update_user_meta( $id, 'promotion',$email_promotion);
	    update_user_meta( $id, 'about_company',$about_us);
	    update_user_meta( $id, 'company_terms',$company_terms);
	    update_user_meta( $id, 'slogan',$company_slogan);
	    update_user_meta( $id, 'url',$url);
	    $myAv = new simple_local_avatars();
	    $myAv->edit_user_profile_update($id);
	    wp_redirect(site_url().'?page_id=487', 301 ); exit;
            }
	    $retrieve_data1 = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
	    $id1=$retrieve_data1[0]->ID;
	    $email=$retrieve_data1[0]->user_email; 
	    $all_meta_for_user = get_user_meta( $id1 );
       $user_type= $all_meta_for_user['usertype'][0];
       
            if($user_type=='1')
       {
?>	 <div class="job-title-field-area">
        <!--<div class="fleft"><div class="job-type_field_main"><h3>Hello <?php //if($user_type==1){echo "Home Owner";}elseif($user_type==2){echo "Trader";}elseif($user_type==3){echo "Builders";} elseif($user_type==4){echo "Employers";} ?></h3></div></div>-->
 <?php 
		//         $img=get_avatar($id1,150);
		//	 preg_match("/src='(.*?)'/i",get_avatar($id1,150), $matches);
		//	 $a=explode('=',$matches[0]);
		//	 $a1=explode("'",$a[1]);
			?>
			 <!--<div class="profile_img"><img src="<?php //echo $a1[1];?>"></div>-->
	       <div class="builder">
		
	
		  <?php if (get_template()=="constructionmatesss_mob") {?>
	       <div><span><a href="<?php echo site_url();?>?page_id=1465&theme=handheld">Home</a></span></div>
              <div><span><a href="<?php echo site_url();?>?page_id=1044&theme=handheld">Jobs</a></span></div>
              <div><span><a href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364&theme=handheld'; }else {  echo site_url().'?page_id=354&theme=handheld'; }?>">Post A Job</a></span></div>
              <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox&theme=handheld">Messages</a></span></div>
              <div><span><a class="active_arrow" href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&page=rwpm_frontend_inbox&theme=handheld'; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442&theme=handheld'; }?>">My Account</a></span></div>
	      <?php }else{?>
		      <div><span><a href="<?php echo site_url();?>?page_id=1465">Home</a></span></div>
              <div><span><a href="<?php echo site_url();?>?page_id=1044">Jobs</a></span></div>
              <div><span><a href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364'; }else {  echo site_url().'?page_id=354'; }?>">Post A Job</a></span></div>
              <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox">Messages</a></span></div>
              <div><span><a class="active_arrow" href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&page=rwpm_frontend_inbox'; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442'; }?>">My Account</a></span></div>
	     <?php }?>
            </div>
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
                    <input type="text" name="first_name" value="<?php echo $all_meta_for_user['first_name'][0];?>" placeholder="First Name"/>
                    </span> </div>
                </div>
                <div class="join-firstname-field">
                  <div class="job-input-bg"> <span>
                    <input name="last_name" type="text"  value="<?php echo $all_meta_for_user['last_name'][0];?>" placeholder="Last Name"/>
                    </span> </div>
                </div>
          </div>
                <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="company_name" type="text"  value="<?php echo $all_meta_for_user['company_name'][0];?>" placeholder="Company Name"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input  name="user_email" type="text"  value="<?php echo $retrieve_data[0]->user_email;?>" placeholder="Email"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="address1" type="text"  value="<?php echo $all_meta_for_user['address1'][0];?>" placeholder="Address"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="address2" type="text"  value="<?php echo $all_meta_for_user['address2'][0];?>" placeholder="Address2"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="city" type="text"  value="<?php echo $all_meta_for_user['city'][0];?>" placeholder="City"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input type="text" value="<?php echo $all_meta_for_user['post_code'][0];?>" name="postcode" placeholder="Post Code">
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="mobile" type="text"  value="<?php echo $all_meta_for_user['mobile'][0];?>" placeholder="Mobile"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="phone" type="text"  value="<?php echo $all_meta_for_user['phone'][0];?>" placeholder="Phone"/>
                    </span> </div>
                </div>
          </div>
          	<!--	<div class="join-field-area">
                <div class="join-title-field join-field-spc-rgt">
                      <div class="job-input-bg"> <span>
                        <input name="email" type="text"  value="<?php //echo $retrieve_data[0]->user_email;?>"/>
                        </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="new_password"  type="password" placeholder="Change Password" value=""/>
                    </span> </div>
                </div>
          		</div>-->
          		<?php if($user_type!=1){?>
                <div class="job-title-field-area">
			      <div class="job-upload-field">
			       <div class="job-upload-bg"><span>
			      <input type="file" name="simple-local-avatar" style="display:none" id="simple-local-avatar" accept="image/*" class="valid">
				<!-- Fake field to fool the user -->
				
				<input type="text" name="imagename" placeholder="Upload logo" readonly="true" id="imagename" > 
					   </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" class="uploadbtn" id="uploafile" value=" <?php if (get_template()=="constructionmatesss_mob") { echo 'Upload logo';}?>">
		  </div>
	    </div>
	    
	   <div class="job-list-area">
			<h3>About us</h3>
            <div>
                  <!--<div class="job-img-part"><img alt="" src="<?php//bloginfo('template_url')?>/images/logo-img-demo.png"></div>-->
		  <div >
                    <div >
                     <textarea  name="about_us" class="t_area" ><?php echo $all_meta_for_user['about_company'][0]?></textarea>
                    </div>
		    </div>
            </div>
            </div>
	    <?php } ?>
	  
		<?php if($user_type!=1){?>
	 	<div class="job-list-area makeclear">
			<h3>Company Terms and Condition (optional)</h3>
            	<div>
                  <!--<div class="job-img-part"><img alt="" src="<?php//bloginfo('template_url')?>/images/logo-img-demo.png"></div>-->
                <div class="personal_container">
		   <textarea class="t_area" name="company_terms"><?php echo $all_meta_for_user['company_terms'][0]?></textarea>
                </div>
             </div>
       </div>
       <?php } ?>
          <div class="job-list-area">
		      <h3>Here you can change your login details</h3>
                <div class="join-title-field join-field-spc-rgt">
                      <div class="job-input-bg"> <span>
                        <input name="email" type="text"  value="<?php echo $retrieve_data[0]->user_email;?>"/>
                        </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                     <input name="new_password"  type="password" placeholder="Change Password" value=""/>
                    </span> </div>
                </div>
	    </div>
	     <div class="job-submit-radio-area recent-work-area ">
              <div class="job-radio-submit-field">
            <div class="job-radio">
	      <?php  $p_value=$all_meta_for_user['promotion'][0];?>
              <input type="checkbox" id="labour1" name="option1" value="0" <?php if($status[0]->status==1)echo 'checked="checked" '; ?>>
              <label for="labour">Subscribe to Our Email Newsletter</label>
                </div>
            <div class="job-radio">
		<input type="checkbox" id="labour2" name="option2" value="1" <?php if ($p_value) echo 'checked="checked" '; ?> >
                  <label for="labour2">Subscribe to Promotion</label>
                </div>
          </div>
          </div>
	    
	    <div class="builder12 accnt_btns">
              <div><span><a href="#" id="submitlink">Submit</a></span></div>
              <div><span><a href="http://constructionmates.co.uk/?page_id=1165">Addvertse</a></span></div>
              <div><span><a onclick="return confirm('Are You Sure, You want to delete Account ?')" href="<?php echo site_url().'?close='.$id;?>">Close Account</a></span></div>
</form>
	        <?php
		$theme=$_GET['theme'];
		if($theme=='handheld'){ ?><div><span><a  href="javascript:void(0)" id="sampledonation" class="show_paymobile">Pay/Donate</a><?php echo do_shortcode('[frontDonationMobile]') ;?></span></div>
            <?php } else {?>
              <div><span><?php echo do_shortcode('[frontDonation]') ;?></span></div><?php } ?>
	      </div>
	    <div class="job-list-area">
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
            </div>
	    </div>
	      </div>
	      <style>
.job-list-area ul{
  display: none;
}
</style>
	  <?php    }
	  else
	  if($user_type=='4')
	  {
	     
	  ?><form name="frm_userdetail" id="frm_userdetail" action="" method="post" enctype="multipart/form-data">
	  
	  <div class="job-title-field-area">
	 
        <!--<div class="fleft"><div class="job-type_field_main"><h3>Hello <?php //if($user_type==1){echo "Home Owner";}elseif($user_type==2){echo "Trader";}elseif($user_type==3){echo "Builders";} elseif($user_type==4){echo "Employers";} ?></h3></div></div>-->
 <?php 
		//         $img=get_avatar($id1,150);
		//	 preg_match("/src='(.*?)'/i",get_avatar($id1,150), $matches);
		//	 $a=explode('=',$matches[0]);
		//	 $a1=explode("'",$a[1]);
			?>
			 <!--<div class="profile_img"><img src="<?php //echo $a1[1];?>"></div>-->
	       
	       <div class="builder">
	       <div><span><a href="<?php echo site_url();?>?page_id=1465">Home</a></span></div>
              <div><span><a href="<?php echo site_url();?>?page_id=1044">Jobs</a></span></div>
              <div><span><a href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364'; }else {  echo site_url().'?page_id=354'; }?>">Post A Job</a></span></div>
              <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox">Messages</a></span></div>
              <div><span> <a class="active_arrow" href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487'; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442'; }?>">My Account</a></span></div>
            </div>
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
                    <input type="text" name="first_name" value="<?php echo $all_meta_for_user['first_name'][0];?>" placeholder="First Name"/>
                    </span> </div>
                </div>
                <div class="join-firstname-field">
                  <div class="job-input-bg"> <span>
                    <input name="last_name" type="text"  value="<?php echo $all_meta_for_user['last_name'][0];?>" placeholder="last Name"/>
                    </span> </div>
                </div>
          </div>
                <div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="company_name" type="text"  value="<?php echo $all_meta_for_user['company_name'][0];?>" placeholder="Company Name"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="user_email" type="text"  value="<?php echo $retrieve_data[0]->user_email;?>" placeholder="Email"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="address1" type="text"  value="<?php echo $all_meta_for_user['address1'][0];?>" placeholder="Address"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="address2" type="text"  value="<?php echo $all_meta_for_user['address2'][0];?>" placeholder="Address2"/>
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="city" type="text"  value="<?php echo $all_meta_for_user['city'][0];?>" placeholder="City"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input type="text" value="<?php echo $all_meta_for_user['post_code'][0];?>" name="postcode" placeholder="Postcode">
                    </span> </div>
                </div>
          </div>
          		<div class="join-field-area">
            <div class="join-title-field join-field-spc-rgt">
                  <div class="job-input-bg"> <span>
                    <input name="mobile" type="text"  value="<?php echo $all_meta_for_user['mobile'][0];?>" placeholder="Mobile"/>
                    </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="phone" type="text"  value="<?php echo $all_meta_for_user['phone'][0];?>" placeholder="Phone"/>
                    </span> </div>
                </div>
          </div>
			<div class="join-field-area" style="margin-bottom:12px;">
            <div class="">
                  <div class="job-input-bg"> <span>
                    <input name="url" type="text"  value="<?php echo $all_meta_for_user['url'][0]; ?>" placeholder="www.mysite.com"/>
                    </span> </div>
                </div>
                
          </div>
          	<!--	<div class="join-field-area">
                <div class="join-title-field join-field-spc-rgt">
                      <div class="job-input-bg"> <span>
                        <input name="email" type="text"  value="<?php //echo $retrieve_data[0]->user_email;?>"/>
                        </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                    <input name="new_password"  type="password" placeholder="Change Password" value=""/>
                    </span> </div>
                </div>
          		</div>-->
          		<?php if($user_type!=1){?>
                <div class="job-title-field-area">
			      <div class="job-upload-field">
			       <div class="job-upload-bg"><span>
			      <input type="file" name="simple-local-avatar" style="display:none" id="simple-local-avatar" accept="image/*" class="valid">
				<!-- Fake field to fool the user -->
				
				<input type="text" name="imagename" readonly="true" id="imagename" placeholder="Upload logo"> 
					   </span> </div>
				 </div>
				 <div class="post-job-upload">
				<!-- Button to invoke the click of the File Input -->
				<input type="button" class="uploadbtn" id="uploafile" value=" <?php if (get_template()=="constructionmatesss_mob") { echo 'Upload logo';}?>">
		  </div>
	    </div>
		
			
            <div class="join-field-area" style="margin-bottom:15px;">
              <h4>add here your company slogan</h4>
              <input id="slogan" class="slogan_txt_inner" type="text" value="<?php echo $all_meta_for_user['slogan'][0]; ?>" placeholder="slogan" name="slogan">
                 </div>
	   <div class="job-list-area title_area ">
			<h3>About us</h3>
                    <div class="personal_container">
                     <textarea  name="about_us" class="t_area" ><?php echo $all_meta_for_user['about_company'][0]?></textarea>
                    </div>
            </div>
	    <?php } ?>
	  
		<?php if($user_type!=1){?>
	 	<div class="job-list-area title_area makeclear">
			<h3>Company Terms and Condition (optional)</h3>
                <div class="personal_container">
		     <textarea class="t_area" name="company_terms"><?php echo $all_meta_for_user['company_terms'][0]?></textarea>
                </div>
       </div>
       <?php } ?>
	     <div class="job-list-area">
              <div class="job-radio-submit-field" >
            <div class="job-radio">
	      <?php  $p_value=$all_meta_for_user['promotion'][0];?>
              <input type="checkbox" id="labour1" name="option1" value="0" <?php if($status[0]->status==1)echo 'checked="checked" '; ?>>
              <label for="labour">Subscribe to Our Email Newsletter</label>
                </div>
            <div class="job-radio">
		<input type="checkbox" id="labour2" name="option2" value="1" <?php if ($p_value) echo 'checked="checked" '; ?> >
                  <label for="labour2">Subscribe to Promotion</label>
                </div>
          </div>
          </div>
	       <div class="job-submit-radio-area recent-work-area">
		     <h3>Here you can change your login details</h3>
                <div class="join-title-field join-field-spc-rgt">
                      <div class="job-input-bg"> <span>
                        <input name="email" type="text"  value="<?php echo $retrieve_data[0]->user_email;?>"/>
                        </span> </div>
                </div>
                <div class="join-title-field">
                  <div class="job-input-bg"> <span>
                     <input name="new_password"  type="password" placeholder="Change Password" value=""/>
                    </span> </div>
                </div>
	    </div>
	    <div class="builder12 accnt_btns">
              <div><span><a href="#" id="submitlink">Submit</a></span></div>
              <div><span><a href="http://constructionmates.co.uk/?page_id=1165">Addvertse</a></span></div>
	       <div><span><a href="javascript:void(0);" id="mydoc_link">My Doc's</a></span></div>
              <div><span><a onclick="return confirm('Are You Sure, You want to delete Account ?')" href="<?php echo site_url().'?close='.$id;?>">Close Account</a></span></div>
	      <?php
		$theme=$_GET['theme'];
		if($theme=='handheld'){ ?><div><span><a  href="javascript:void(0)" id="sampledonation" class="show_paymobile">Pay/Donate</a><?php echo do_shortcode('[frontDonationMobile]') ;?></span></div>
            <?php } else {?>
              <div><span><?php echo do_shortcode('[frontDonation]') ;?></span></div><?php } ?>
	      </div>
	    <div class="job-list-area">
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
		</div>
		</div>
	      </div>
	      <style>

.makeclear{
clear:both;}
</style>
	  <?php
	  
	  }
?>