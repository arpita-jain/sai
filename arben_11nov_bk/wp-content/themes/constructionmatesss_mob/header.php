<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head>
 <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/defualt.css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/SpryTabbedPanels.css" media="screen">

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/jquery-ui.css" media="screen">
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery_006.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){
	 $('#content1').show(); $('#tab1').addClass("current");
	$('#tab1').click(function(){
			 $('#content1').fadeIn("slow");
 			 $('#tab2').removeClass("current");
			 $('#tab1').addClass("current");
			 $('#content2').fadeOut("fast");
			 });
	$('#tab2').click(function(){
			 $('#tab1').removeClass("current");
			  $('#tab2').addClass("current");
			 $('#content2').fadeIn("slow");
			 $('#content1').fadeOut("fast");
		});
	$('#button2').click(function(){
			joinnow_url ="<?php site_url()?>/?page_id=118&theme=handheld";
				 window.location.href=joinnow_url;
		});
	$('#submitimage').click(function() {			    
			  $("#form1").submit();
			 });
			
	});
  </script>
<?php wp_head(); ?>
</head>

<body <?php body_class();
   global $current_user;
if(($current_user->usertype==1)or($current_user->usertype==4)){
		$redirect_to=site_url().'?page_id=487&theme=handheld';
           
	  }else{
	       $redirect_to=site_url().'?page_id=442&theme=handheld';
	  }

?>
<?php
//For delete account
	    $close=$_REQUEST['close'];
	     $delete_data = $wpdb->get_results("DELETE FROM wp_usermeta WHERE user_id = '$close'");
	     $delete_data2 = $wpdb->get_results("DELETE FROM wp_users WHERE ID= '$close'");?>

   <div class="main_freme">
    <div class="logo"> <a href="<?php echo site_url();?>"><img src="<?php bloginfo('template_url')?>/images/logo.png" alt="Everything you need to know"></a>
 
      <div class="header">
        <div class="wrap top-bar">
          <button class="menu-show"><img src="<?php echo get_template_directory_uri(); ?>/images/plus.png" alt="plus"></button>
          <button class="menu-hide"><img src="<?php echo get_template_directory_uri(); ?>/images/minus.png" alt="minus"></button>
          <div class="clear-both"></div>
        </div>
      </div>
     <nav class="menu">
        <ul>
	   <li><a href="<?php echo site_url();?>?theme=handheld">Home</a></li>
          <li><a href="<?php echo site_url();?>?page_id=11&theme=handheld">Builders</a></li>
          <li><a href="<?php echo site_url();?>?page_id=13&theme=handheld">Traders</a></li>
          <li><a href="<?php echo site_url();?>?page_id=15&theme=handheld">Jobs</a></li>
          <li><a href="<?php echo site_url();?>?page_id=18">Post a Job</a></li>
          <li><a href="<?php echo site_url();?>?page_id=20">FAQ</a></li>
          <li><a href="<?php echo site_url();?>?page_id=22">News</a></li>
          <li><a href="<?php echo site_url();?>?page_id=21">About Us</a></li>
          <li><a href="<?php echo site_url();?>?page_id=30">Terms & Conditions</a></li>
          <li><a href="<?php echo site_url();?>?page_id=32">Privacy&Cookie’s</a></li>
          <li><a href="<?php echo site_url();?>?page_id=36">Sitemap</a></li>
          <li><a href="<?php echo site_url();?>?page_id=62">Contact Us</a></li>
          <li><a href="<?php echo site_url();?>?page_id=1308" class="last_li">Blog</a></li>
        </ul>
      </nav>
     <!--login_status S-->
      <div class="login_status">
   <?php if($current_user->data->user_login){?>
       <div class="my_account_new"><a href="<?php echo $redirect_to; ?>">My Account</a></div> <?php }?>
       <div class="my_Name_new">Welcome  <?php if($current_user->data->user_login){ echo $current_user->data->user_login; } else { echo "Guest";}?>!</div>
          <div class="my_Logout_new"><?php if($current_user->data->user_login){?><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a><?php }else {?><a href="<?php echo site_url(); ?>?page_id=18">Login</a> <?php }?></div>
      </div>
      <!--login_status E-->
      <div class="clear-both"></div>
      
    </div>
    <div class="content">
    <form name="form1" id="form1" method="post" action="<?php echo site_url().'?page_id=1359&theme=handheld'?>">
    <?php if(($_GET['page_id']==1308)||($_GET['page_id']==11) ||($_GET['page_id']==13) ||($_GET['page_id']==15)){?>
	 <!--<div class="banner2"></div>-->
	 <?php
       if(function_exists( 'wp_bannerize' ))
       wp_bannerize( 'group=mobile_header2_banner&random=1&limit=1' );
?>
	 <div class="clear-both"></div>
    <?php } else {?>
    <div style="position:relative;">
       <?php
       if(function_exists( 'wp_bannerize' ))
       wp_bannerize( 'group=mobile_header_banner&random=1&limit=1' );
?>
    </div>
<div style="position: absolute; width: 100%; ">
          <div class="frm_row">
            <p class="frm_text">What</p>
            <div class="frm_input">
              <input type="text" name="searchbox" id="textfield" placeholder="name, category, accreditations, skill " value="<?php echo $searchbox; ?>">
            </div>
          </div>
	  
          <div class="frm_row">
            <p class="frm_text">Where</p>
            <div class="frm_input">
              <input type="text" name="city" value="<?php echo $city; ?>" id="textfield" placeholder="city or postcode" class="second_inp">
              <a href="#" id="submitimage"><img src="<?php echo get_template_directory_uri(); ?>/images/location.png" alt="icon" class="location" id="submitimage"></a></div>
          </div>
          <div class="frm_row2">
            <input type="submit" name="button" id="button" value="Search" class="search_btn">
	   <input type="button" name="button2" id="button2" value="Join Now" class="join_btn">
	</div>
      </div>
      <?php } ?>
</form>