<?php 

add_shortcode('xyz_em_subscription_html_code','display_content');


function display_content(){
	$tmp=ob_get_contents();
	ob_clean();
	ob_start();
	include(dirname( __FILE__ ).'/shortcodes/htmlcode.php');
	$xyz_em_content = ob_get_contents();
	ob_clean();
	echo $tmp;
	return $xyz_em_content;
}

add_shortcode('xyz_em_thanks','display_thanks');


function display_thanks(){
	$tmp=ob_get_contents();
	ob_clean();
	ob_start();
	include(dirname( __FILE__ ).'/shortcodes/thanks.php');
	$xyz_em_thanks = ob_get_contents();
	ob_clean();
	echo $tmp;
	return $xyz_em_thanks;
}

add_shortcode('xyz_em_confirm','display_confirm');


function display_confirm(){
	$tmp=ob_get_contents();
	ob_clean();
	ob_start();
	include(dirname( __FILE__ ).'/shortcodes/confirm.php');
	$xyz_em_confirm = ob_get_contents();
	ob_clean();
	echo $tmp;
	return $xyz_em_confirm;
}

add_shortcode('xyz_em_unsubscribe','display_unsubscribe');


function display_unsubscribe(){
	$tmp=ob_get_contents();
	ob_clean();
	ob_start();
	include(dirname( __FILE__ ).'/shortcodes/unsubscribe.php');
	$xyz_em_unsubscribe = ob_get_contents();
	ob_clean();
	echo $tmp;
	return $xyz_em_unsubscribe;
}

?>