$(document).ready( function() {
	
		// When site loaded, load the Popupbox First
		//loadPopupBox();
	$('#sampledonation').click(function(){
		loadPopupBox();
		});
		$('#popupBoxClose_donation').click( function() {			
			unloadPopupBox();
		});
		
		//$('#container').click( function() {
		//	unloadPopupBox();
		//});

		function unloadPopupBox() {	// TO Unload the Popupbox
			$('#popup_box_donation').fadeOut("slow");
			$("#container").css({ // this is just for style		
				"opacity": "1"
			}); 
		}	
		
		function loadPopupBox() {	// To Load the Popupbox
			$('#popup_box_donation').fadeIn("slow");
			
			$("#container").css({ // this is just for style
				"opacity": "0.3"
			});
		
		}
		
		/**********************************************************/
});