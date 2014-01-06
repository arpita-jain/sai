<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head>
<?php
require_once('Mobile_Detect.php');
$detect = new Mobile_Detect;
if($detect->isMobile()){
 $pageURL= 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 $url_check=site_url().'/';
  if($pageURL==$url_check){
    $url=site_url().'/?theme=handheld';
     wp_redirect($url); exit; 
  }
  if(($_GET['theme']=='active')&&(($_GET['page_id']==1606)||($_GET['page_id']==1630)||($_GET['page_id']==1631)||($_GET['page_id']==1721) ||($_GET['page_id']==1722))){
    $url=site_url().'/?theme=active';
     wp_redirect($url); exit; 
  }
  
}?>
<?php /*
<meta name="viewport" content="width=device-width">
<!--disable iPhone inital scale -->
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!--<meta name="viewport" content="width=device-width"> -->
<!--<meta charset="<?php //bloginfo( 'charset' ); ?>" />-->
<!--<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />-->*/ ?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie.css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/1140.css" media="screen">
<link rel="stylesheet" href="<?php //bloginfo('template_url'); ?>/css/styles.css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/defualt.css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/finalmsg.css" media="screen">
<?php if(is_page('1465'))
{
?>
<!--<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>-->
<!--<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bjqs.css" media="screen">-->
<!--<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/demo.css" media="screen">-->
<!--<script src="<?php bloginfo('template_url'); ?>/js/bjqs-1.3.min.js"></script>-->

<?php	       
}
?>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
//<![CDATA[
bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
//]]>
</script>-->
<?php
/* We add some JavaScript to pages with the comment form
* to support sites with threaded comments (when in use).
*/
if ( is_singular() && get_option( 'thread_comments' ) )
wp_enqueue_script( 'comment-reply' );
/* Always have wp_head() just before the closing </head>

* tag of your theme, or you will break many plugins, which

* generally use this hook to add elements to <head> such

* as styles, scripts, and meta tags.

*/
wp_head(); ?>
</head>
<body style="overflow-x: hidden;">

<?php
global $current_user;
 if(($current_user->usertype==1)or($current_user->usertype==4)){
		$redirect_to=site_url().'?page_id=487';
           
	  }else{
	       $redirect_to=site_url().'?page_id=442';
	  }
	?>
<div class="container">
<!--	 Header Start -->
	<div class="row">
	
	<div class="twelvecol">
		<!-- logo div start here-->
		<div class="logo_left">
		<div class="fl logo">
		
		<a href="<?php echo site_url();?>"> <?php if(is_page('330')) { ?><img src="<?php bloginfo('template_url')?>/images/logo-new.jpg" alt="" border="0" /><?php }else {?><img src="<?php bloginfo('template_url')?>/images/logo-new.jpg" alt="" border="0" /><?php }?></a>
		</div>
		</div>
		<!-- logo div end here-->
		<!-- navigation div start here--><?php $close=$_REQUEST['close'];
	     $delete_data = $wpdb->get_results("DELETE FROM wp_usermeta WHERE user_id = '$close'");
	     $delete_data2 = $wpdb->get_results("DELETE FROM wp_users WHERE ID= '$close'");?>
		<div class="navbar nav_right" id="navbar_header">
		<?php
	       // navigation array for settings values		
		$defaults = array(
		'theme_location'  => '',
		'menu'            => 'menu',
		'container'       => 'div',
		'container_class' => 'fl nav',		
		'echo'            => true,			       
		'before'          => '<span>',
		'after'           => '</span>',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="menu-primary" class="menu-primary_header">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		);
		//word pres menu function
	       wp_nav_menu($defaults);
	 if(is_front_page()){ //echo do_shortcode('[post_job_menu]');
	  }
	
		?><?php if(is_front_page()){ ?> <form name="login_form" method="post" action="<?php echo site_url( '/wp-login.php' ); ?>">
		<div class="login_section_home">
		<div class="user_name_home">
		<input name="log" placeholder="User Name" type="text"  value="" id="log" /></div>
		<div class="pwd_section_home"><input clas="pwd_home" name="pwd" placeholder="Password" type="password"  value="" required/></div>
		<input type="image" class="login_link_home" name="image" id="image" value="Login" alt="Login">
		<?php /*  <input name="image" id="image" type="image" value="Login" src="<?php bloginfo('template_url')?>/images/join-login-btn.png" alt="Login" />*/?>
		</div></form><?php }?>
		<!-- navigation div end here-->
	</div>
	<?php if (!is_front_page() ){?>
	<div class="breadcrumbs" style="font-size:14px; padding-left: 20px;">
   	 <?php if(function_exists('bcn_display'))
   	 {
     	   //bcn_display();
    	}?></div><?php }?>
	<?php if(is_home() || is_front_page()) echo '</div></div>'; ?>
<!--	 Header end -->
<style>
.html
{ margin-top:0px !important;
}</style>
<script language="JavaScript" type="text/javascript">
       siteurl= '<?php echo site_url(); ?>';
	$(document).ready(function(){
	usertype = '<?php echo $current_user->usertype;?>';
	if(usertype==2){
	 $('#menu-item-26').hide();
	}else{
	  $('#menu-item-26').show();
	}
	});
	 </script>