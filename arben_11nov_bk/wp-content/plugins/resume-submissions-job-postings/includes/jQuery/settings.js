// jQuery used on the Settings page

jQuery( document ).ready( function (){
	jsHideSettings();
	var useState = jQuery( '#useStateList' ).val();
	if ( useState == 'Custom' ) {
		jsShowCustomList();
	} else {
		jsHideCustomList();
	}
});
// Hide and hover functions
function tabEnable( id ){ 
	jQuery( id ).css( { 'opacity': '1' } );
}
function tabDisable( id ){ 
	jQuery( id ).css( { 'opacity': '0.7' } );
}

function jsStyleMenu( active, hide1, hide2, hide3 ){
	tabEnable( active );
	jQuery( active ).hover( function(){ tabEnable( this ); } );
	tabDisable( hide1 );
	jQuery( hide1 ).hover( function(){ tabEnable( this ); }, function(){ tabDisable( this ); } );
	tabDisable( hide2 );
	jQuery( hide2 ).hover( function(){ tabEnable( this ); }, function(){ tabDisable( this ); } );
	tabDisable( hide3 );
	jQuery( hide3 ).hover( function(){ tabEnable( this ); }, function(){ tabDisable( this ); } );	
}

// jQuery to slide the settings
function jsHideSettings( param ) {
	jsStyleMenu( '#coreTab', '#recaptchaTab', '#attachmentsTab', '#emailingTab' );
	jQuery( "#coreSettings" ).show( param );
	jQuery( '#recaptchaSettings' ).hide( param );	
	jQuery( '#attachmentSettings' ).hide( param );	
	jQuery( '#emailingSettings' ).hide( param );	
}
function jsOpenSettings( e ) {
	if ( e.value == 'Core' ) {
		jsHideSettings( 'slow' );
		jsStyleMenu( '#coreTab', '#recaptchaTab', '#attachmentsTab', '#emailingTab' );
	} else if ( e.value == 'reCaptcha' ) {
		jsStyleMenu( '#recaptchaTab', '#coreTab', '#attachmentsTab', '#emailingTab' );
		tabEnable( '#recaptchaTab' );
		jQuery( "#coreSettings" ).hide( 'slow' );
		jQuery( '#recaptchaSettings' ).show( 'slow' );	
		jQuery( '#attachmentSettings' ).hide( 'slow' );	
		jQuery( '#emailingSettings' ).hide( 'slow' );
	} else if ( e.value == 'Attachments' ) {
		jsStyleMenu( '#attachmentsTab', '#recaptchaTab', '#coreTab', '#emailingTab' );
		jQuery( "#coreSettings" ).hide( 'slow' );
		jQuery( '#recaptchaSettings' ).hide( 'slow' );	
		jQuery( '#attachmentSettings' ).show( 'slow' );	
		jQuery( '#emailingSettings' ).hide( 'slow' );
	} else if ( e.value == 'Emailing' ) {
		jsStyleMenu( '#emailingTab', '#recaptchaTab', '#attachmentsTab', '#coreTab' );
		jQuery( "#coreSettings" ).hide( 'slow' );
		jQuery( '#recaptchaSettings' ).hide( 'slow' );	
		jQuery( '#attachmentSettings' ).hide( 'slow' );	
		jQuery( '#emailingSettings' ).show( 'slow' );
	}
}

// jQuery to slide the custom state list option
function jsHideCustomList( param ) {
	jQuery( '#customStateList' ).hide( param );	
}
function jsShowCustomList( param ) {
	jQuery( '#customStateList' ).show( param );	
}
function jsOpenCustomList( e ) {
	if ( e.value == 'US' ) {
		jsHideCustomList( 'slow' );
	} else {
		jQuery( "#customStateList" ).show( 'slow' );
	}
}
