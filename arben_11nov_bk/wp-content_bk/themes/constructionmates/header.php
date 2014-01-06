<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width">    
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie.css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/1140.css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/styles.css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/defualt.css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/finalmsg.css" media="screen">
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
<body>
<div class="container">
<!--	 Header Start -->
	<div class="row">
	
	<div class="twelvecol">
		<!-- logo div start here-->
		<div class="logo_left">
		<div class="fl logo">
		
		<a href="http://constructionmates.co.uk"> <?php if(is_page('330')) { ?><img src="<?php echo bloginfo('template_url')?>/images/toplogo.png" alt="" border="0" /><?php }else {?><img src="<?php bloginfo('template_url')?>/images/logo-new.jpg" alt="" border="0" /><?php }?></a>
		</div>
		</div>
		<!-- logo div end here-->
		<!-- navigation div start here-->
		<div class="navbar nav_right">
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
		'items_wrap'      => '<ul id="menu-primary">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		);
		//word pres menu function
		wp_nav_menu($defaults);
		?>		
		</div>
		<!-- navigation div end here-->
	</div>
	<?php if (!is_front_page() ){?>
	<div class="breadcrumbs" style="font-size:14px; padding-left: 20px;">
   	 <?php if(function_exists('bcn_display'))
   	 {
     	   bcn_display();
    	}?></div><?php }?>
	</div>
</div>
<!--	 Header end -->
