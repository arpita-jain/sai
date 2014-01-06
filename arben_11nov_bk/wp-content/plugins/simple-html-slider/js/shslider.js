//-- SHS Front Script --------------
//----------------------------------

jQuery('document').ready(function()
{
	jQuery('.shslider_section').find('iframe').each(function(){
		jQuery(this).parent('.shs_items').addClass('shs-iframe');
		var url = jQuery(this).attr("src"), 
		vchar = url.indexOf("?") != -1 ? '&' : '?';
		/* In my case it is only necessary to youtube player */
		if(url.indexOf("youtube") != -1){
			jQuery(this).attr("src",url+vchar+"wmode=transparent");
			jQuery(this).attr("wmode","Opaque");
		}		
	});

	jQuery('.shs-iframe').each(function(){
		jQuery(this).append('<div class="shs-iframe-overlay"></div><div class="shs-fixed-overlay"></div>');
		jQuery(this).find('.shs-fixed-overlay').prepend(jQuery(this).find('iframe').clone());
	});
	
	jQuery('.shslider_section .shs-fixed-overlay').find('iframe').each(function(){
		var ifrmHt = jQuery(this).outerHeight(),
		    ifrmWt = jQuery(this).outerWidth();
		jQuery(this).wrap('<div class="shs-iframe-wrap"></div>');
		jQuery(this).parent('.shs-iframe-wrap').css({'width':ifrmWt,'height':ifrmHt,'margin-top':-(ifrmHt/2)}).prepend('<a class="shs-close-iframe" href="javascript:void(0)"></a>');
	});
	
	jQuery('.shslider_section').on('click','.shs-iframe-overlay',function(){
		var Iframe = jQuery(this).next('.shs-fixed-overlay').find('iframe');	
		var src = Iframe.attr('src');
		Iframe.attr('src', '');
		Iframe.attr('src', src);
		jQuery(this).next('.shs-fixed-overlay').fadeIn('fast',function(){Iframe.css({'opacity':1});});
	});
	
	jQuery('.shs-fixed-overlay').on('click','.shs-close-iframe',function(){
		jQuery('#shs_slider_cont .shs-fixed-overlay').hide();
		jQuery('#shs_slider_cont .shs-fixed-overlay iframe').css({'opacity':0});
	});
});

jQuery(document).keyup(function(e) { 
	if (e.keyCode == 27) { // esc keycode
		jQuery('#shs_slider_ul .shs-fixed-overlay').hide();
		jQuery('#shs_slider_cont .shs-fixed-overlay iframe').css({'opacity':0});
	}
});