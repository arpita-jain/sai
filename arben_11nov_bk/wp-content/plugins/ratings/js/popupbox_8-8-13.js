$(document).ready( function() {
	
		// When site loaded, load the Popupbox First
		//loadPopupBox();
	$('#sample').click(function(){
		loadPopupBox();
		});
		$('#popupBoxClose_rating').click( function() {			
			unloadPopupBox();
		});
		
		//$('#container').click( function() {
		//	unloadPopupBox();
		//});

		function unloadPopupBox() {	// TO Unload the Popupbox
			$('#popup_box_rating').fadeOut("slow");
			$("#container").css({ // this is just for style		
				"opacity": "1"
			}); 
		}	
		
		function loadPopupBox() {	// To Load the Popupbox
			$('#popup_box_rating').fadeIn("slow");
			
			$("#container").css({ // this is just for style
				"opacity": "0.3"
			});
		
		}
		
		/**********************************************************/
});