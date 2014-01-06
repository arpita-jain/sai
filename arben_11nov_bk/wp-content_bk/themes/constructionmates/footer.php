<!--Footer start here-->
<div class="bottom_line_arrow">
      <div class="container addver_image">
    <div class="row">
          <div class="twelvecol">
        <div class="addvertize_img">
	<div>
	
	 <?php
	 
	 if(function_exists( 'wp_bannerize' ))
        wp_bannerize( 'group=group & random=4 & limit=4' );
   ?>
	
	</div>
	<?php
		// function define in function.php
		/*$gallery=footer_banner_images();
		$i=1;
		foreach($gallery as $image)
			{
				$path=site_url().'/'.$image->path.'/'.$image->filename;//full path of image
				// dynamic class
				if($i==1)
				$class="img_1 first";
				elseif($i==4)
				$class="img_2";
				else
				$class="img_1";*/
	?>
            <!--  <div class="<?php //echo $class; ?>"> <img border="0" src="<?php //echo $path; ?>" alt="<?php //echo $image->alttext ?>" /> </div> -->
	<?php //$i++; } ?>
            </div>
      </div>
        </div>
  </div>
    </div>
<div class="container footer_part">
      <div class="footer_middle">
    <div class="row">
          <div class="twelvecol">
        <div class="logo_left_1">
              <div class="fl logo_footer"><a href="http://constructionmates.co.uk"> <?php if(is_page('330')) { ?><img src="<?php bloginfo('template_url')?>/images/footer_logo-new.png" alt="" border="0" /><?php }else {?><img src="<?php bloginfo('template_url')?>/images/footerlogo.png" alt="" border="0" /><?php } ?></a></div>
            </div>
        <div class="navbar nav_right_footer">
		<?php
	       // navigation array  for footer menu
		$defaults = array(
		'theme_location'  => '',
		'menu'            => 'footer-nav',
		'container'       => 'div',
		'container_class' => 'fl footer-nav',		
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
      </div>
        </div>
    <div class="row">
          <div class="twelvecol">
        <div class="coptright_txt">&copy; 2013 BuildersandTraders.co.uk <span>All rights reserved.</span></div>
      </div>
        </div>
  </div>
    </div>
<!--Footer end here-->
<!--All js load here-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" media="screen"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/mobile.js"></script>
</body>
</html>




