<?php
/**
 * @package Private Messages For WordPress
 *
 * @author: Rilwis
 * @url: http://www.deluxeblogtips.com
 * @email: rilwis@gmail.com
 
 Template Name: Private Messages
 
 */
 ?>

<?php
if (!is_user_logged_in()) {
	//redirect_to_login_url();
}

get_header();
?>
<div class="container content_bg-new">
      <div class="row">
    <div class="twelvecol">
          <div class="wlcm-guest-btn-area">
        <div class="wlcm-guest-btn-bg">
              <h3>Welcome Guest!</h3>
            </div>
        <div class="wlcm-guest-btn"><a href="#">Logout</a></div>
      </div>
          <div class="build_smal_ban_bg"> <img src="<?php bloginfo('template_url')?>/images/small-banner.png" /> </div>
        </div>
  </div>
          <div class="row">
    <div class="twelvecol">
	<div class="content-left-part">
		     <div class="job-listing-left-area">
              <div class="job-list-area">
            <h3>Hello Employer</h3>
             <div class="builder">
              <div><span><a href="#">Jobs</a></span></div>
              <div><span><a href="#">Post A Job</a></span></div>
              <div><span><a href="#" class="active_arrow">Messages</a></span></div>
              <div><span><a href="#">My Account</a></span></div>
            </div>
            <div class="options">
            	<a class="takeoption activeoption" href="javascript:void(0);"><span class="compose" onclick="pmSwitch('pm-send');">Compose</span></a>
                <a href="javascript:void(0);" class="takeoption" onclick="pmSwitch('pm-inbox');"><span class="inbox">Inbox</span></a>
                <a href="javascript:void(0);" class="takeoption"><span class="refresh">Refresh</span></a>
                <a href="javascript:void(0);" class="takeoption" onclick="pmSwitch('pm-outbox');"><span class="sent">Sent</span></a>
                <a href="javascript:void(0);" class="takeoption"><span class="delete" class="takeoption">Delete</span></a>
            </div>
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
		<div id="pm-send" <?php if (!$show[0]) echo 'style="display:none"'; ?>><?php rwpm_front_message_send();?></div>
		<div id="pm-inbox" <?php if (!$show[1]) echo 'style="display:none"'; ?>><?php rwpm_inbox();?></div>
		<div id="pm-outbox" <?php if (!$show[2]) echo 'style="display:none"'; ?>><?php rwpm_outbox();?></div>
	</div>
	<?php endwhile; endif; ?>
</div>
	      </div>
		     </div>
	</div>
	  <div class="content-right-part">
       <div class="faq-cntnt-lft-area">
	    <div class="traders-right-area">
              <div class="traders-right-part">
            <div class="traders-plc">
                  <div class="traders-head" style="color:#000;">Click Links</div>
                <?php Show_sidebar_right();
		?>
            </div>
             </div>
               </div>
        <div class="content-advertise-area"><img src="<?php bloginfo('template_url')?>/images/advertise-img.png" alt=""></div>
       </div>
	  </div>
    </div>
    </div>
</div>
<?php get_footer(); ?>
