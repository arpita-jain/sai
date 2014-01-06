jQuery( document ).ready( function ( $ )
{

	/**
	 * Split string into multiple values, separated by commas
	 *
	 * @param val
	 *
	 * @return array
	 */
	function split( val )
	{
		return val.split( /,\s*/ );
	}

	function getURLParameter(name) {
	    return decodeURI(
		(RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
	    );
	}
	/**
	 * Extract string Last into multiple values
	 * @param term
	 *
	 */
	function extract_last( term )
	{
		return split( term ).pop();
	}

	$( '#recipient' ).autocomplete( {
		source: function ( request, response )
		{
			var data = {
				action: 'rwpm_get_users',
				term  : extract_last( request.term )
			};
			$.post( ajaxurl, data, function ( r )
			{
				response( r );
			}, 'json' );
		},
		select: function ( event, ui )
		{
			var terms = split( this.value );
			terms.pop();
			terms.push( ui.item.value );
			terms.push( "" );
			this.value = terms.join( "," );
			return false;
		}
	} );
	$('.takeoption').click(function()
			       {
				$('.takeoption').removeClass('activeoption');
				$(this).addClass("activeoption"); 
			       });
	
	//alert(getURLParameter('page'));
	if(getURLParameter('page')=="rwpm_frontend_inbox")
	{
		//$('.takeoption').removeClass('activeoption');
		//$('#inbox_msg').addClass('activeoption');
		$('#inbox_msg').trigger('click');
	}
	if(getURLParameter('page')=="rwpm_front_message_outbox")
	{
		//$('.takeoption').removeClass('activeoption');
		//$('#sent_msg').addClass('activeoption');
		$('#sent_msg').trigger('click');
	}
	$('#delete_inbox_mail').click(function(){
	  var didConfirm = confirm("Are you sure?");
	  if (didConfirm == true) {
	  var redirect_url = $("#delete_inbox_hidden").val();
	  window.location.href = redirect_url;
	}
	else{
		return false;
	}
	 });
	
	$('.delete_outbox_mail').click(function(){
	  var didConfirm = confirm("Are you sure?");
	  if (didConfirm == true) {
	  var redirect_url = $("#delete_outbox_hidden").val();
	  //alert(redirect_url);
	  window.location.href = redirect_url;
	}
	else{
		return false;
	}
	 });
	var pagename;
	var checked ;
	$('.checkboxmsg').click(function()
				{
					pagename=$('#pagename').val();
					checked=$("input.checkboxmsg:checkbox:checked").length;					
				}
				);
	$('.checkboxmsg1').click(function()
				{
					pagename=$('#pagename1').val();
					checked=$("input.checkboxmsg1:checkbox:checked").length;					
				}
				);
	$('#delete_msg').click(function(){		
               
		if(checked==0)
		{
			alert("Please select checkbox");
			return false;
		}
		else
		{
		if(pagename=="rwpm_front_message_outbox")
		{		
		//var didConfirm = confirm("Are you sure?");
		//if (didConfirm == true) {
		//
		//$('#outbox_form').submit();
		//}
		//else{return false; }
                $("#dialog").dialog({
			autoOpen: true,
			modal: true,
			buttons : {
			     "Confirm" : function() {
				 $("#outbox_form").submit();            
			     },
			     "Cancel" : function() {
			       $(this).dialog("close");
			     }
			   }
			 });
		
		}
		else if(pagename=="rwpm_frontend_inbox")
		{
			$("#dialog").dialog({
			autoOpen: true,
			modal: true,
			buttons : {
			     "Confirm" : function() {
				 $("#inbox_form").submit();            
			     },
			     "Cancel" : function() {
			       $(this).dialog("close");
			     }
			   }
			 });	
		}		
		}
		});

});