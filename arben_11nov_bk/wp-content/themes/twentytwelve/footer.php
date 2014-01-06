<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'twentytwelve_credits' ); ?>
			<div>
				<?php
				//echo $url=$_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];
				//echo $url=$_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/device-theme-switcher/inc/mobile-esp.php';
				//echo $url = plugins_url('device-theme-switcher/inc/mobile-esp.php');
				//echo $url='/wp-content/plugins/device-theme-switcher/inc/mobile-esp.php';
				//require_once( $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/device-theme-switcher/inc/mobile-esp.php' );
				//require_once('http://constructionmates.co.uk/wp-content/plugins/device-theme-switcher/inc/mobile-esp.php');
				//if(exist(DetectAndroidPhone()))
				//{
				//	$k=DetectAndroidPhone();
				//	print_r($k);
				//}
$kaps= NEW uagent_info();
$kaps->DetectAndroidPhone();
echo '<pre>';
//print_r($kaps);
echo '</pre>';

$pageURL= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

if ( is_front_page() ) {
    $pageURL='http://constructionmates.co.uk?theme=active';
}
else {
    $pageURL='http://'.$pageURL.'&theme=active';
}
//echo $pageURL;
require_once('Mobile_Detect.php');
$detect = new Mobile_Detect;

// 1. Check for mobile environment.

if ($detect->isMobile()) {
    echo 'cought mobile';
}

				//require_once $url;
				echo 'included';
				//$returndevice=DetectAndroidPhone();
				//echo 'device='.$returndevice;
				?>
			</div>
			
			<div><a href="<?php echo $pageURL?>">Switch to windows mode</a></div>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>