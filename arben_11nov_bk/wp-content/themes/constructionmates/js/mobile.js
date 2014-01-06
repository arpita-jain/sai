jQuery.noConflict();


/* Mobile */
//$('.navbar').prepend('<div id="menu-trigger" class="menu-trigger"></div>');
$('#navbar_header').prepend('<div id="menu-trigger" class="menu-trigger_header"></div>');
$('#navbar_footer').prepend('<div id="menu-trigger" class="menu-trigger_footer"></div>');
$(".menu-trigger_header").on("click", function(){ //alert('aaaaaaaaaaaaa');
	$(".menu-primary_header").slideToggle();
});
$(".menu-trigger_footer").on("click", function(){ //alert('aaaaaaaaaaaaa');
	$(".menu-primary_footer").slideToggle();
});

// iPad
var isiPad = navigator.userAgent.match(/iPad/i) != null;
if (isiPad) $('#menu-primary ul').addClass('no-transition');