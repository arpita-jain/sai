<?php
if (!is_user_logged_in()) {
	wp_redirect(site_url().'?page_id=18', 301 ); exit;
}
get_header();
global $current_user;
 if(($current_user->usertype==1)or($current_user->usertype==4)){
		$redirect_to=site_url().'?page_id=487';
           
	  }else{
	       $redirect_to=site_url().'?page_id=442';
	  }


?>

<div class="container content_bg-new">
       <div class="row">
     <div class="twelvecol">
          <!--<div class="wlcm-guest-btn-area">
	<?php 	//if($current_user->data->user_login){
	 ?>
	<div class="wlcm-guest-btn-my-account"><a href="<?php //echo site_url(); ?>?page_id=442">My Account</a></div>
	<?php //} ?>
        <div class="wlcm-guest-btn-bg">
              <h3>Welcome <?php //if($current_user->data->user_login){ echo $current_user->data->user_login; } else { echo "Guest";}?>!</h3>
            </div>
        <div class="wlcm-guest-btn"><?php //if($current_user->data->user_login){ ?><a href="<?php //echo wp_logout_url( home_url() ); ?>">Logout</a><?php// } else { ?><a href="<?php //echo site_url(); ?>?page_id=18">Login</a><?php //}?></div>
      </div>-->
        </div>
  </div>
	<div class="mobile_myaccount_page">
          <div class="row">
    <div class="twelvecol">
	<div class="content-left-part yyy">
		     <div class="job-listing-left-area">
              <div class="job-list-area">
	<?php   $user_id= $current_user->ID; 
 		$all_meta_for_user = get_user_meta( $user_id );
	   	$user_type= $all_meta_for_user['usertype'][0];?>
            <?php//if($user_type!=1){ ?><!--<h3>Hello--> <?php //if($user_type==2){echo "Trader";}elseif($user_type==3){echo "Builders";} elseif($user_type==4){echo "Employers";} ?></h3><?php //} ?>
             <div class="builder">
	     <div><span><a href="<?php echo site_url();?>?page_id=1465&theme=handheld">Home</a></span></div>
              <div><span><a href="<?php if($user_type ==2){ echo site_url().'?page_id=15&theme=handheld'; }else {  echo site_url().'?page_id=1044&theme=handheld'; }?>">Jobs</a></span></div>
              <?php if($user_type!=2){?> <div><span><a href="<?php if(($user_type ==4) || ($user_type ==3)){ echo site_url().'?page_id=1364&theme=handheld'; }else {  echo site_url().'?page_id=354&theme=handheld'; }?>">Post A Job</a></span></div><?php } ?>
	      <div><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox&theme=handheld" class="active_arrow">Messages</a></span></div>
              <div><span><a href="<?php if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&theme=handheld'; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442&theme=handheld'; }?>">My Account</a></span></div>
            </div>
            <div class="options">
            	 <?php //if($user_type!=1){?><!--<a id="compose_msg" class="takeoption activeoption" href="javascript:void(0);"><span class="compose" onclick="pmSwitch('pm-send');">Compose</span></a>--><?php //} ?>
                <a id="inbox_msg" href="javascript:void(0);" class="takeoption" onclick="pmSwitch('pm-inbox');"><span class="inbox">Inbox</span></a>
                <a id="refresh_msg" href="<?php echo site_url(); ?>?page_id=437&page=rwpm_frontend_inbox" class="takeoption"><span class="refresh">Refresh</span></a>
                <a id="sent_msg" href="javascript:void(0);" class="takeoption" onclick="pmSwitch('pm-outbox');"><span class="sent">Sent</span></a>
                <a id="delete_msg" href="javascript:void(0);" class="takeoption"><span class="delete" class="takeoption">Delete</span></a>
		 <!--<a id="print_msg" href="javascript:void(0);" class="takeoption"><span class="print" class="takeoption">Print</span></a>-->
            </div>
	    <div id="dialog" title="Confirmation Required" style="display:none;"> Are you sure about this?</div>
<div class="hfeed content">
	<h2><?php //the_title(); ?></h2>	
	<script type="text/javascript">
		// Switch between send page, inbox and outbox
		function pmSwitch(page) {
			document.getElementById('pm-send').style.display = 'none';
			document.getElementById('pm-inbox').style.display = 'none';
			document.getElementById('pm-outbox').style.display = 'none';
			document.getElementById(page).style.display = '';
			return false;
		}
	</script>
	<!-- Include scripts and style for autosuggest feature -->
	<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/private-messages-for-wordpress/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/private-messages-for-wordpress/js/jquery.autoSuggest.packed.js"></script>
	<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/private-messages-for-wordpress/js/script.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/private-messages-for-wordpress/css/style.css" />
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<?php
		$show = array(true, false, false);
		if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'rwpm_inbox') {
			$show = array(false, true, false);
		} elseif (isset($_REQUEST['page']) && $_REQUEST['page'] == 'rwpm_outbox') {
			$show = array(false, false, true);
		}
		?>
		<div id="pm-send" <?php if (!$show[0]) echo 'style="display:none"'; ?>><?php rwpm_front_message_send_mobile();?></div>
		<div id="pm-inbox" <?php if (!$show[1]) echo 'style="display:none"'; ?>><?php rwpm_frontend_inbox_mobile();?></div>
		<div id="pm-outbox" <?php if (!$show[2]) echo 'style="display:none"'; ?>><?php rwpm_front_message_outbox_mobile();?></div>
	</div>
	<?php endwhile; endif; ?>
</div>
	      </div>
		     </div>
	</div>
	  <!--<div class="content-right-part">
       <div class="faq-cntnt-lft-area">
	    <div class="traders-right-area">
              <div class="traders-right-part">
            <div class="traders-plc">
                  <div class="traders-head" style="color:#000;">Click Linksssss</div>
                <?php //Show_sidebar_right();
		?>
            </div>
             </div>
               </div>
        <div class="content-advertise-area"><img src="<?php //bloginfo('template_url')?>/images/advertise-img.png" alt=""></div>
       </div>
	  </div>-->
    </div>
    </div>
</div>
</div>
<?php get_footer(); ?>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
