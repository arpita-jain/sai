<div class="clear"></div>
</div> <!-- #container -->		

		<?php do_action( 'bp_after_container' ); ?>

</div><!-- main -->

		<?php do_action( 'bp_before_footer'   ); ?>

	
<footer>
<div class="footer-left">

<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_compact"><span class="icon-share"> </span></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50d5ccc825461c61"></script>
<!-- AddThis Button END -->
			
</div>

	
<div class="footer-right"><?php echo of_get_option('t-4', 'All rights reserved by' ); ?> <?php bloginfo( 'name' ); ?></div>

</footer>

<?php do_action( 'bp_after_footer' ); ?>

<?php wp_footer(); ?>

</body>

</html>