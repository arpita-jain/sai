<?php
$kaps= NEW uagent_info();
$kaps->DetectAndroidPhone();
$pageURL= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

//print_r($URL[0]);

?>
<div class="footer">
      <div class="wrap bot-bar">
        <ul class="footer_list">
          <li><a href="<?php if ( is_front_page() ) { $URL=explode("?theme", $pageURL);echo 'http://'.$URL[0].'?theme=handheld'; }else { $URL=explode("&theme", $pageURL); echo 'http://'.$URL[0].'&theme=handheld'; }?>">Mobile</a></li>
          |
          <li><a href="<?php if ( is_front_page() ) {$URL=explode("?theme", $pageURL);echo 'http://'.$URL[0].'?theme=handheld'; }else { $URL=explode("&theme", $pageURL); echo 'http://'.$URL[0].'&theme=handheld'; }?>">Smart Phone</a></li>
          |
          <li><a href="<?php if ( is_front_page() ) { $URL=explode("?theme", $pageURL);echo 'http://'.$URL[0].'?theme=active'; }else { $URL=explode("&theme", $pageURL); echo 'http://'.$URL[0].'&theme=active'; }?>">Desktop Site</a></li>
        </ul>
        &copy; 2013 <a href="#">ConstructionMates.co.uk</a> All rights reserved.
        <div class="clear-both"></div>
      </div>
    </div>
    <script type="text/javascript">
	$('.menu').hide();
	$('.menu-show').show();
	$('.menu-hide').hide();
	$('.menu-show').click(function(){
		$('.menu-show').toggle();
		$('.menu-hide').toggle();
		$('.menu').slideDown();
	});
	$('.menu-hide').click(function(){
		$('.menu-hide').toggle();
		$('.menu-show').toggle();
		$('.menu').slideUp();
	});
</script> 
    <a href="http://www.mobifreaks.com" title="site design by Mobifreaks.com"></a> </div>
<?php wp_footer(); ?>
</body></html>