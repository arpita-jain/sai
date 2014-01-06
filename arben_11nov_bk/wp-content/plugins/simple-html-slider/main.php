<?php
/*
Plugin Name: Simple HTML Slider
Plugin URI: http://www.wpfruits.com
Description: This is simple Html content carousel. Put Your HTML CONTENT directly in the slides. Use more than two slides for better performance. This is continuous carousel.
Author: WPFruits
Version: 1.1.0
Author URI: http://www.wpfruits.com
*/
function shs_slider_init_method() {
    wp_enqueue_script('jquery');
	if(is_admin())
	{
		if(isset($_REQUEST['page']))
		{
			if($_REQUEST['page']=="shs_slider_options")
			{
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('shs-admin-script',plugins_url('js/shs-admin.js',__FILE__), array('jquery'),'',1);
				wp_enqueue_style('shs-admin-style',plugins_url('css/shs-admin.css',__FILE__), false, '1.0.0' );
			}
		}
	}
	
}  

add_action('wp_enqueue_scripts', 'shs_frontend_scripts');
function shs_frontend_scripts() {	
	if(!is_admin()){
		wp_enqueue_style('shs-front',plugins_url('css/shs-front.css',__FILE__));
		wp_enqueue_script('shs-front-script',plugins_url('js/shslider.js',__FILE__), array('jquery'),'',1);
	}
}
  
add_action('init', 'shs_slider_init_method');
function shs_slider_install(){
   	$shs_settings['pause_time']=7000;
	$shs_settings['trans_time']=1000;
	$shs_settings['width']="250px";
	$shs_settings['height']="200px";
	$shs_settings['direction']="Up";
	$shs_settings['pause_on_hover']="Yes";
	$shs_settings['show_navigation']="Yes";
	add_option("shs_slider_settings", $shs_settings);
	shs_plugin_activate();
}
register_activation_hook(__FILE__,'shs_slider_install');

add_action('admin_init', 'shs_plugin_redirect');
function shs_plugin_activate() {
    add_option('shs_plugin_do_activation_redirect', true);
}
function shs_plugin_redirect() {
    if (get_option('shs_plugin_do_activation_redirect', false)) {
        delete_option('shs_plugin_do_activation_redirect');
        wp_redirect('admin.php?page=shs_slider_options');
    }
}

// get shslider version
function shs_get_version(){
	if ( ! function_exists( 'get_plugins' ) )
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}

function shs_slider_show()
{
$shs_settings=get_option('shs_slider_settings');
	$pause_time=$shs_settings['pause_time'];
	$trans_time=$shs_settings['trans_time'];
	$width=$shs_settings['width'];
	$height=$shs_settings['height'];
	$direction=$shs_settings['direction'];
	$show_navigation=$shs_settings['show_navigation'];
	
	$pause_hover=$shs_settings['pause_on_hover'];
	
	if($direction=="Left"||$direction=="Right")
	{
	$li_style="style='width:$width;height:$height;float:left;margin:0;padding:0;overflow:hidden;'";
	}
	else
	{
	$li_style="style='width:$width;height:$height;margin:0;padding:0;overflow:hidden;'";
	}
	
	$toret='<div id="shs_slider_cont" class="shslider_section" style="width:'.$width.';height:'.$height.';overflow:hidden;">';

			if($show_navigation ==='Yes'){
				$toret .='<a href="javascript:void(0)" id="shs_prev" class="shs_nav"></a><a href="javascript:void(0)" id="shs_next"  class="shs_nav"></a>';
			}
			$toret .='<div class="shs_slider_wrp" id="shs_slider_ul" style="width:'.$ul_width.';list-style-type:none;position:relative;margin:0;padding:0;" >';				
				$contents=get_option('shs_slider_contents');
				
				if($contents)
				{
					foreach($contents as $content)
					{
						if($content)
						{
						$content=stripslashes($content);
					
						$toret.="<div class='shs_items' $li_style >".$content."</div>";
						} // if($content)
					}// 	foreach($contents as $content)
				} // if($contents)
	$toret.='</div>
		</div>';
		$toret .='<div id="thumb">'; foreach($contents as $content)
					{
						if($content)
						{
						$content=stripslashes($content);
						$toret .="<div class='small_div'>".$content."</div>";
						}
				}
		$toret .='</div>';
    $toret.="
<script type='text/javascript'>
jQuery(document).ready(function() {
	jQuery('#shs_prev').click(function(){
		shs_animate();
	});
	jQuery('#shs_next').click(function(){
		shs_animate_next();
	});
";
switch($direction)
{

	case "Down":
		$toret.="
		var dcount = jQuery('.shs_slider_wrp .shs_items').length; 
		jQuery('#shs_slider_ul .shs_items:first').before(jQuery('#shs_slider_ul .shs_items:last'));
		jQuery('#shs_slider_ul').css({'top':'-$height'});
		
		function shs_animate_next(){
			if(dcount < 3){
				jQuery('#shs_slider_ul').css({'top':'0'});
				jQuery('#shs_slider_ul .shs_items:last').after(jQuery('#shs_slider_ul .shs_items:first'));
				jQuery('#shs_slider_ul:not(:animated)').animate({'top':'-$height'},$trans_time,function(){});
			}else{
				var item_height = jQuery('#shs_slider_ul .shs_items').outerHeight();
				var top_indent = parseInt(jQuery('#shs_slider_ul').css('top')) - item_height;
				jQuery('#shs_slider_ul:not(:animated)').animate({'top' : top_indent},$trans_time,
				function(){
					jQuery('#shs_slider_ul .shs_items:last').after(jQuery('#shs_slider_ul .shs_items:first'));
					jQuery('#shs_slider_ul').css({'top':'-$height'});
				});
			}
		}
		
		function shs_animate()
		{
			var item_height = jQuery('#shs_slider_ul .shs_items').outerHeight();
			var top_indent = parseInt(jQuery('#shs_slider_ul').css('top')) + item_height;
			jQuery('#shs_slider_ul:not(:animated)').animate({'top' : top_indent},$trans_time,
			function(){
				jQuery('#shs_slider_ul .shs_items:first').before(jQuery('#shs_slider_ul .shs_items:last'));
				jQuery('#shs_slider_ul').css({'top':'-$height'});
			});
		}";
		break;
	case "Right":
		$toret.="
		
		var rcount = jQuery('.shs_slider_wrp .shs_items').length; 
		
		jQuery('#shs_slider_ul .shs_items:first').before(jQuery('#shs_slider_ul .shs_items:last'));
		var item_width = jQuery('#shs_slider_ul .shs_items').outerWidth();
		var total_width=jQuery('#shs_slider_ul .shs_items').length;
		jQuery('#shs_slider_ul').css({'left':'-$width','width':item_width*total_width+10});
		jQuery('#shs_slider_ul .shs_items').css({'float':'left'});
		
		function shs_animate_next(){
			if(rcount < 3){
				jQuery('#shs_slider_ul').css({'left':'0'});
				jQuery('#shs_slider_ul .shs_items:last').after(jQuery('#shs_slider_ul .shs_items:first'));
				jQuery('#shs_slider_ul:not(:animated)').animate({'left' : '-$width'},$trans_time,function(){});
			}else{
				var item_width = jQuery('#shs_slider_ul .shs_items').outerWidth();
				var left_indent = parseInt(jQuery('#shs_slider_ul').css('left')) -item_width;
				jQuery('#shs_slider_ul:not(:animated)').animate({'left' : left_indent},$trans_time,
				function(){
					jQuery('#shs_slider_ul .shs_items:last').after(jQuery('#shs_slider_ul .shs_items:first'));
					jQuery('#shs_slider_ul').css({'left':'-$width'});
				});
			}
		}

		function shs_animate(){
			var item_width = jQuery('#shs_slider_ul .shs_items').outerWidth();
			var left_indent = parseInt(jQuery('#shs_slider_ul').css('left')) + item_width;
			jQuery('#shs_slider_ul:not(:animated)').animate({'left' : left_indent},$trans_time,
			function(){
				jQuery('#shs_slider_ul .shs_items:first').before(jQuery('#shs_slider_ul .shs_items:last'));
				jQuery('#shs_slider_ul').css({'left':'-$width'});
			});
		}";
		break;
	}//switch($direction)
if($pause_hover=="No")
{
$toret.="
var shs=setInterval(function(){ shs_animate(); },$pause_time);";
}
else
{
$toret.="
var shs=setInterval(function(){ shs_animate(); },$pause_time);
jQuery('#shs_slider_cont').hover(function(){ clearInterval(shs); },function(){ shs=setInterval(function(){ shs_animate(); },$pause_time); });";
}
$toret.="
})
</script>";
return $toret;
}

add_shortcode('shs_slider_show', 'shs_slider_show');

function shs_slider_view($ech=true)
{
	if($ech)
	{
	echo shs_slider_show();
	}
	else
	{
	shs_slider_show();
	return shs_slider_show();
	}
}

add_action('admin_menu', 'shs_slider_add_menu');

function shs_slider_add_menu() {
add_menu_page('Simple HTML Slider', 'SHTML Slider','administrator', 'shs_slider_options', 'shs_slider_menu_op',plugins_url('images/shs-icon.png',__FILE__));
}

function shs_slider_menu_op() {
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general"><br></div><h2>Simple HTML Slider '.shs_get_version().'</h2>';
	if(isset($_POST['jsetsub']))
	{
		$pause_time=$_POST['pause_time'];
		$trans_time=$_POST['trans_time'];
		$width=$_POST['width'];
		$height=$_POST['height'];
		$direction=$_POST['direction'];
		$pause_hover=$_POST['pause_on_hover'];
		$show_navigation=$_POST['show_navigation'];
		
		$shs_settings['pause_time']=$pause_time;
		$shs_settings['trans_time']=$trans_time;
		$shs_settings['width']=$width;
		$shs_settings['height']=$height;
		$shs_settings['direction']=$direction;
		$shs_settings['pause_on_hover']=$pause_hover;
		$shs_settings['show_navigation']=$show_navigation;
		update_option('shs_slider_settings',$shs_settings);
		?>
		<div class="updated" style="width:686px;"><p><strong><font color="green"><?php _e('Setting Saved' ); ?></font></strong></p></div>
		<?php
	}
	?>
	<div class="shs_banner_wrapper">
		<!-- WP-Banner Starts Here -->
		<div id="wp_banner">
			<!-- Top Section Starts Here -->
			<div class="top_section">
				<!-- Begin MailChimp Signup Form -->
				<link type="text/css" rel="stylesheet" href="http://cdn-images.mailchimp.com/embedcode/classic-081711.css">
				<style type="text/css">
					#mc_embed_signup{ clear:left; font:14px Helvetica,Arial,sans-serif; }
					/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
					   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
				</style>
				<div id="mc_embed_signup">
					<form novalidate="" target="_blank" class="validate" name="mc-embedded-subscribe-form" id="mc-embedded-subscribe-form" method="post" action="http://wpfruits.us6.list-manage.com/subscribe/post?u=166c9fed36fb93e9202b68dc3&amp;id=bea82345ae">
						<div class="mc-field-group">
							<input type="email" id="mce-EMAIL" class="required email" name="EMAIL" value="" placeholder="Our Newsletter Just Enter Your Email Here" />
							<input type="submit" class="button" id="mc-embedded-subscribe" name="subscribe" value="" onclick="return wp_jsvalid();">
							<div style="clear:both;"></div>
						</div>
						<div class="clear" id="mce-responses">
							<div style="display:none" id="mce-error-response" class="response"></div>
							<div style="display:none" id="mce-success-response" class="response"></div>
						</div>	
						
					</form>
				</div>
				<script type="text/javascript">
					var fnames = new Array();var ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';
					try {
						var jqueryLoaded=jQuery;
						jqueryLoaded=true;
					} catch(err) {
						var jqueryLoaded=false;
					}
					var head= document.getElementsByTagName('head')[0];
					if (!jqueryLoaded) {
						var script = document.createElement('script');
						script.type = 'text/javascript';
						script.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js';
						head.appendChild(script);
						if (script.readyState &amp;&amp; script.onload!==null){
							script.onreadystatechange= function () {
								  if (this.readyState == 'complete') mce_preload_check();
							}    
						}
					}
					var script = document.createElement('script');
					script.type = 'text/javascript';
					script.src = 'http://downloads.mailchimp.com/js/jquery.form-n-validate.js';
					head.appendChild(script);
					var err_style = '';
					try{
						err_style = mc_custom_error_style;
					} catch(e){
						err_style = '#mc_embed_signup input.mce_inline_error{border-color:#6B0505;} #mc_embed_signup div.mce_inline_error{margin: 0 0 1em 0; padding: 5px 10px; background-color:#6B0505; font-weight: bold; z-index: 1; color:#fff;}';
					}
					var head= document.getElementsByTagName('head')[0];
					var style= document.createElement('style');
					style.type= 'text/css';
					if (style.styleSheet) {
						style.styleSheet.cssText = err_style;
					} else {
						style.appendChild(document.createTextNode(err_style));
					}
					head.appendChild(style);
					setTimeout('mce_preload_check();', 250);

					var mce_preload_checks = 0;
					function mce_preload_check(){
						if (mce_preload_checks&gt;40) return;
						mce_preload_checks++;
						try {
							var jqueryLoaded=jQuery;
						} catch(err) {
							setTimeout('mce_preload_check();', 250);
							return;
						}
						try {
							var validatorLoaded=jQuery("#fake-form").validate({});
						} catch(err) {
							setTimeout('mce_preload_check();', 250);
							return;
						}
						mce_init_form();
					}
					function mce_init_form()
					{
						jQuery(document).ready( function($) 
						{
						  var options = { errorClass: 'mce_inline_error', errorElement: 'div', onkeyup: function(){}, onfocusout:function(){}, onblur:function(){}  };
						  var mce_validator = $("#mc-embedded-subscribe-form").validate(options);
						  $("#mc-embedded-subscribe-form").unbind('submit');//remove the validator so we can get into beforeSubmit on the ajaxform, which then calls the validator
						  options = { url: 'http://wpfruits.us6.list-manage.com/subscribe/post-json?u=166c9fed36fb93e9202b68dc3&amp;id=bea82345ae&amp;c=?', type: 'GET', dataType: 'json', contentType: "application/json; charset=utf-8",
										beforeSubmit: function(){
											$('#mce_tmp_error_msg').remove();
											$('.datefield','#mc_embed_signup').each(
												function(){
													var txt = 'filled';
													var fields = new Array();
													var i = 0;
													$(':text', this).each(
														function(){
															fields[i] = this;
															i++;
														});
													$(':hidden', this).each(
														function(){
															var bday = false;
															if (fields.length == 2){
																bday = true;
																fields[2] = {'value':1970};//trick birthdays into having years
															}
															if ( fields[0].value=='MM' &amp;&amp; fields[1].value=='DD' &amp;&amp; (fields[2].value=='YYYY' || (bday &amp;&amp; fields[2].value==1970) ) ){
																this.value = '';
															} else if ( fields[0].value=='' &amp;&amp; fields[1].value=='' &amp;&amp; (fields[2].value=='' || (bday &amp;&amp; fields[2].value==1970) ) ){
																this.value = '';
															} else {
																if (/\[day\]/.test(fields[0].name)){
																	this.value = fields[1].value+'/'+fields[0].value+'/'+fields[2].value;									        
																} else {
																	this.value = fields[0].value+'/'+fields[1].value+'/'+fields[2].value;
																}
															}
														});
												});
											return mce_validator.form();
										}, 
										success: mce_success_cb
									};
						  $('#mc-embedded-subscribe-form').ajaxForm(options);

						});
					}
					function mce_success_cb(resp){
						$('#mce-success-response').hide();
						$('#mce-error-response').hide();
						if (resp.result=="success"){
							$('#mce-'+resp.result+'-response').show();
							$('#mce-'+resp.result+'-response').html(resp.msg);
							$('#mc-embedded-subscribe-form').each(function(){
								this.reset();
							});
						} else {
							var index = -1;
							var msg;
							try {
								var parts = resp.msg.split(' - ',2);
								if (parts[1]==undefined){
									msg = resp.msg;
								} else {
									i = parseInt(parts[0]);
									if (i.toString() == parts[0]){
										index = parts[0];
										msg = parts[1];
									} else {
										index = -1;
										msg = resp.msg;
									}
								}
							} catch(e){
								index = -1;
								msg = resp.msg;
							}
							try{
								if (index== -1){
									$('#mce-'+resp.result+'-response').show();
									$('#mce-'+resp.result+'-response').html(msg);            
								} else {
									err_id = 'mce_tmp_error_msg';
									html = '&lt;div id="'+err_id+'" style="'+err_style+'"&gt; '+msg+'&lt;/div&gt;';
									
									var input_id = '#mc_embed_signup';
									var f = $(input_id);
									if (ftypes[index]=='address'){
										input_id = '#mce-'+fnames[index]+'-addr1';
										f = $(input_id).parent().parent().get(0);
									} else if (ftypes[index]=='date'){
										input_id = '#mce-'+fnames[index]+'-month';
										f = $(input_id).parent().parent().get(0);
									} else {
										input_id = '#mce-'+fnames[index];
										f = $().parent(input_id).get(0);
									}
									if (f){
										$(f).append(html);
										$(input_id).focus();
									} else {
										$('#mce-'+resp.result+'-response').show();
										$('#mce-'+resp.result+'-response').html(msg);
									}
								}
							} catch(e){
								$('#mce-'+resp.result+'-response').show();
								$('#mce-'+resp.result+'-response').html(msg);
							}
						}
					}

				</script>
				<!--End mc_embed_signup-->
			</div>
			<!-- Top Section Ends Here -->
			
			<!-- Bottom Section Starts Here -->
			<div class="bot_section">
				<a href="http://www.wpfruits.com/" class="wplogo" target="_blank" title="WFruits.com"></a>
				<a href="https://www.facebook.com/pages/WPFruitscom/443589065662507" class="fbicon" target="_blank" title="Facebook"></a>
				<a href="http://www.twitter.com/wpfruits" class="twicon" target="_blank" title="Twitter"></a>
				<div style="clear:both;"></div>
			</div>
			<!-- Bottom Section Ends Here -->
		</div>
		<!-- WP-Banner Ends Here -->
	</div>
	<?php
	$shs_settings=get_option('shs_slider_settings');
	$pause_time=$shs_settings['pause_time'];
	$trans_time=$shs_settings['trans_time'];
	$width=$shs_settings['width'];
	$height=$shs_settings['height'];
	$direction=$shs_settings['direction'];
	$pause_hover=$shs_settings['pause_on_hover'];
	$show_navigation=$shs_settings['show_navigation'];
	echo "<div class='shs_admin_wrapper'><h5 style='text-align:center' class='shs_shortinfo'>Use Shortcode <br> <span style='font-size:14px;font-weight: bold;'>[shs_slider_show]</span><br> ' or '<br>
	Use Template Code<br> <span style='font-size:14px;font-weight: bold;'>&lt;?php if(function_exists('shs_slider_view')){ shs_slider_view(); } ?&gt;</span></h5></div>";
	echo '<div id="poststuff" style="position:relative;">
		  <div class="postbox shs_admin_wrapper">
		  <div class="handlediv" title="Click to toggle"><br/></div>
		  <h3 class="hndle"><span>General Settings</span></h3>
		  <div class="inside" style="padding: 15px;margin: 0;">';
			echo "<form name='settings' method='post'>";
			echo "<table>";
			?>
			<tr><td><?php _e('Width','shs'); ?></td><td><input type='text' name='width' value='<?php echo $width; ?>' /> <?php _e('eg:200px','shs'); ?></td></tr>
			<tr><td><?php _e('Height','shs'); ?></td><td><input type='text' name='height' value='<?php echo $height; ?>' /> <?php _e('eg:200px','shs'); ?></td></tr>
			
			<tr>
				<td><?php _e('Show Navigation','shs'); ?></td>
				<td>
					<select name="show_navigation">
						<option <?php shs_check_for_selected($show_navigation,"Yes"); ?> ><?php _e('Yes','shs'); ?></option>
						<option <?php shs_check_for_selected($show_navigation,"No"); ?> ><?php _e('No','shs'); ?></option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><?php _e('Pause on Hover','shs'); ?></td>
				<td>
					<select name="pause_on_hover">
						<option <?php shs_check_for_selected($pause_hover,"Yes"); ?> ><?php _e('Yes','shs'); ?></option>
						<option <?php shs_check_for_selected($pause_hover,"No"); ?> ><?php _e('No','shs'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php _e('Direction','shs'); ?></td>
				<td>
					<select name="direction">
						<option value="Right" <?php shs_check_for_selected($direction,"Right"); ?> ><?php _e('Left - Right','shs'); ?></option>
						<option value="Down" <?php shs_check_for_selected($direction,"Down"); ?> ><?php _e('Up - Down','shs'); ?></option>
					</select>
				</td>
			</tr>
			<tr><td><?php _e('Pause time','shs'); ?></td><td><input type='text' name='pause_time' value='<?php echo $pause_time; ?>' /> <?php _e('eg:7000','shs'); ?></td></tr>
			<tr><td><?php _e('Transition time','shs'); ?></td><td><input type='text' name='trans_time' value='<?php echo $trans_time; ?>' /> <?php _e('eg:1000','shs'); ?></td></tr>
			<tr><td colspan="2" style="font-weight:normal;"><input type='submit' name='jsetsub'  class='button-primary' value='SAVE SETTINGS' /></td></tr>
			<?php
			echo "</table>";
			echo "</form>";
			echo '</div></div></div>';
			
	?>
    <?php
	if(isset($_POST['joptsv']))
	{
	$contents=$_POST['cnt'];
	update_option('shs_slider_contents',$contents);
	?>
    <div class="updated" style="width:686px;"><p><strong><font color="green"><?php _e('Slides Saved','shs'); ?></font></strong></p></div>
    <?php
	}
	?>
    <style>#joptions{ list-style-type: none; margin: 0; padding: 0; }</style>
	
	<div id="poststuff" style="position:relative;">
		<div class="postbox shs_admin_wrapper">
			<div class="handlediv" title="Click to toggle"><br/></div>
			<h3 class="hndle"><span><?php _e('Add Slider Contents Below (Drap up-down to re-order)','shs'); ?></span></h3>
			<div class="inside" style="padding: 15px;margin: 0;">
				<div>
					<h5>
					<?php _e('Note:You can add HTML here.','shs'); ?>
					<br/>
					<?php _e('More Than two slides Recommended.','shs'); ?>
					</h5>
					<form name="qord" method="post">
						<ul id="joptions">
							<?php
							$contents=get_option('shs_slider_contents');
							if($contents)
							{
								foreach($contents as $content)
								{
									if($content)
									{
									$content=stripslashes($content);
								?>
								<li><textarea name="cnt[]" rows="3" style="width:70%;" ><?php echo $content; ?></textarea><input type="button" class="shs_del" title="Delete" value="" onClick="shs_delete_field(this);"  /><input type="button" class="shs_add" title="Add New" value="" onClick="shs_add_to_field(this);"  /></li>
								<?php
									} // if($content)
								}// 	foreach($contents as $content)
							} // if($contents)
							?>
							<li><textarea name="cnt[]" rows="3" style="width:70%;" ></textarea><input type="button" class="shs_del" title="Delete" value="" onClick="shs_delete_field(this);"  /><input type="button" class="shs_add" title="Add New" value=""  onClick="shs_add_to_field(this);"  /></li>
						</ul>
						<input type="submit" name="joptsv" class="button-primary" style="margin-left: 13px;" value="SAVE SLIDES" />
					</form>
				</div>
			</div>
		</div>
	</div>
	<iframe class="shs_iframe" src="http://www.sketchthemes.com/sketch-updates/plugin-updates/shs-lite/shs-lite.php" width="694px" height="220px" scrolling="no" ></iframe> 
	
	<?php
	echo '</div>'; // .wrap
}

function shs_check_for_selected($option,$check){
	if($option==$check){
		echo "selected='selected'";
	}
}

function shs_slider_cont_count()
{
global $wpdb;
$number=0;
$contents=get_option('shs_slider_contents');
	if($contents)
	{
		foreach($contents as $content)
		{
			if($content)
			{
			$number++;
			} 
		}
	}
return $number;
}
