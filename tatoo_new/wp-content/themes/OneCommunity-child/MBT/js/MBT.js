var country_code_ISO = {'004': 'AF', '248': 'AX', '008': 'AL',	'012': 'DZ',	'016': 'AS',	'020': 'AD',	'024': 'AO',	'660': 'AI',	'010': 'AQ', 	'028': 'AG',	'032': 'AR',	'051': 'AM',	'533': 'AW',	'036': 'AU',	'040': 'AT',	'031': 'AZ',	'044': 'BS',	'048': 'BH',	'050': 'BD',	'052': 'BB',	'112': 'BY',	'056': 'BE',	'084': 'BZ',	'204': 'BJ',	'060': 'BM',	'064': 'BT',	'068': 'BO',	'070': 'BA',	'072': 'BW', 	'074': 'BV',	'076': 'BR', 	'086': 'IO',	'096': 'BN',	'100': 'BG',	'854': 'BF',	'108': 'BI',	'116': 'KH',	'120': 'CM',	'124': 'CA',	'132': 'CV',	'136': 'KY',	'140': 'CF',	'148': 'TD',	'152': 'CL',	'156': 'CN',	'162': 'CX',	'166': 'CC',	'170': 'CO',	'174': 'KM',	'178': 'CG',	'180': 'CD',	'184': 'CK',	'188': 'CR',	'384': 'CI',	'191': 'HR',	'192': 'CU',	'196': 'CY',	'203': 'CZ',	'208': 'DK',	'262': 'DJ',	'212': 'DM', 	'214': 'DO',	'218': 'EC',	'818': 'EG', 	'222': 'SV', 	'226': 'GQ',	'232': 'ER',	'233': 'EE',	'231': 'ET', 	'238': 'FK', 	'234': 'FO',	'242': 'FJ',	'246': 'FI',	'250': 'FR', 	'254': 'GF', 	'258': 'PF', 	'260': 'TF',	'266': 'GA',	'270': 'GM',	'268': 'GE',	'276': 'DE',	'288': 'GH',	'292': 'GI',	'300': 'GR',	'304': 'GL',	'308': 'GD',	'312': 'GP',	'316': 'GU',	'320': 'GT',	'831': 'GG',	'324': 'GN',	'624': 'GW',	'328': 'GY',	'332': 'HT', 	'334': 'HM',	'340': 'HN', 	'344': 'HK',	'348': 'HU',	'352': 'IS',	'356': 'IN',	'360': 'ID',	'364': 'IR',	'368': 'IQ',	'372': 'IE',	'833': 'IM',	'376': 'IL',	'380': 'IT',	'388': 'JM',	'392': 'JP',	'832': 'JE',	'400': 'JO',	'398': 'KZ',	'404': 'KE',	'296': 'KI',	'408': 'KP',	'410': 'KR',	'414': 'KW',	'417': 'KG',	'418': 'LA',	'428': 'LV',	'422': 'LB',	'426': 'LS',	'430': 'LR',	'434': 'LY',	'438': 'LI',	'440': 'LT',	'442': 'LU',	'446': 'MO',	'807': 'MK',	'450': 'MG',	'454': 'MW',	'458': 'MY',	'462': 'MV',	'466': 'ML',	'470': 'MT',	'584': 'MH',	'474': 'MQ',	'478': 'MR',	'480': 'MU',	'175': 'YT',	'484': 'MX',	'583': 'FM',	'498': 'MD',	'492': 'MC',	'496': 'MN',	'499': 'ME',	'500': 'MS',	'504': 'MA',	'508': 'MZ',	'104': 'MM',	'516': 'NA',	'520': 'NR',	'524': 'NP',	'528': 'NL', 	'530': 'AN',	'540': 'NC',	'554': 'NZ',	'558': 'NI',	'562': 'NE',	'566': 'NG',	'570': 'NU',	'574': 'NF', 	'580': 'MP',	'578': 'NO',	'512': 'OM',	'586': 'PK',	'585': 'PW',	'275': 'PS',	'591': 'PA', 	'598': 'PG',	'600': 'PY',	'604': 'PE',	'608': 'PH',	'612': 'PN',	'616': 'PL',	'620': 'PT', 	'630': 'PR',	'634': 'QA',	'638': 'RE',	'642': 'RO', 	'643': 'RU',	'646': 'RW', 	'652': 'BL', 	'654': 'SH',	'659': 'KN',	'662': 'LC',	'663': 'MF', 	'666': 'PM',	'670': 'VC',	'882': 'WS',	'674': 'SM',	'678': 'ST',	'682': 'SA',	'686': 'SN',	'688': 'RS',	'690': 'SC',	'694': 'SL',	'702': 'SG',	'703': 'SK',	'705': 'SI', 	'090': 'SB',	'706': 'SO',	'710': 'ZA',	'239': 'GS',	'724': 'ES',	'144': 'LK',	'736': 'SD',	'740': 'SR',	'744': 'SJ',	'748': 'SZ',	'752': 'SE',	'756': 'CH',	'760': 'SY',	'158': 'TW',	'762': 'TJ',	'834': 'TZ',	'764': 'TH',	'626': 'TL',	'768': 'TG',	'772': 'TK',	'776': 'TO',	'780': 'TT',	'788': 'TN',	'792': 'TR',	'795': 'TM',	'796': 'TC',	'798': 'TV',	'800': 'UG',	'804': 'UA', 	'784': 'AE', 	'826': 'GB',	'581': 'UM',	'840': 'US',	'858': 'UY',	'860': 'UZ',	'548': 'VU',	'336': 'VA',	'862': 'VE',	'704': 'VN',	'092': 'VG', 	'850': 'VI', 	'876': 'WF', 	'732': 'EH',	'887': 'YE',	'894': 'ZM',	'716': 'ZW'};

jQuery(document).ready(function($) {

	$(".action_btn.setting_btn").click(function(event){
		event.stopPropagation();
		hide_notification_box();
		if ( $("#mbt_settings_box").is(":visible") ) {
			hide_settings_box();
		} else {
			show_settings_box();
		}
	});

	$(".action_btn.notification_btn").click(function(event){
		event.stopPropagation();
		hide_settings_box();
		if ( $("#mbt_notification_box").is(":visible") ) {
			hide_notification_box();
		} else {
			show_notification_box();
		}
		
	});

	function hide_settings_box() {
		$("#mbt_settings_box").hide("fast", function() {
			$("#mbt_settings_box #arrow").removeClass('animate');
		});
	}

	function show_settings_box() {
		$("#mbt_settings_box").show("fast", function() {
			$("#mbt_settings_box #arrow").addClass('animate');
		});
	}

	function hide_notification_box() {
		$("#mbt_notification_box").hide("fast", function() {
			$("#mbt_notification_box #arrow").removeClass('animate');
		});
	}

	function show_notification_box() {
		$("#mbt_notification_box").show("fast", function() {
			$("#mbt_notification_box #arrow").addClass('animate');
		});
	}

	$(document).click(function() {
		$(".mbt_bar_box").hide();
		$(".mbt_bar_box #arrow").removeClass('animate');
	});             
	
	$('.wpjb-listing-type-item input:first[type="radio"]').prop('checked', true);
	
	if ( $('#mytabs .current').length > 0 ) {
		$('#mytabs #subnav').addClass('in_tab');
	}	


	jQuery("#job_zip_code").removeAttr("autocomplete");

	var zip_source_url = "http://ws.geonames.org/postalCodeSearchJSON?&country=";

	function bind_job_zip_autocomplete() {

		try {
			$('#job_zip_code').autocomplete('destroy');
		} catch (e) { }

		var self = this;

		$('#job_zip_code').autocomplete({
			source: function( request, response ) {
				//console.log(self);
				$.ajax({
					url: zip_source_url + country_code_ISO[$(self).val()],
					dataType: "jsonp",
					data: {
						style: "full",
						maxRows: 12,
						postalcode_startsWith: request.term
					},
					success: function(data) {
						response($.map(data.postalCodes, function(item) {
							var label = item.postalCode + ", " + item.placeName + ", " + item.adminName1;
							if ( item.adminName1== null ) {
								item.adminName1 = '';
								label = item.postalCode + ", " + item.placeName;
							}
							return {
								label: label,
								value: item.postalCode,
								city:item.placeName,
								state:item.adminName1
							}
						}));
						jQuery('.ui-autocomplete').css('width', '250px');
					}
				});
			},

			minLength: 2,
			select: function( event, ui ) {
				jQuery('#job_state').val(ui.item.state);
				jQuery('#job_location').val(ui.item.city);
			},

			open: function() {
				jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},

			close: function() {
				jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}

		});
	}

	$('#job_country').change(bind_job_zip_autocomplete);
	bind_job_zip_autocomplete.call($('#job_country').get(0));

		

	jQuery("#company_zip_code").removeAttr("autocomplete");

	function bind_zip_autocomplete() {

		try {
			$('#company_zip_code').autocomplete('destroy');
		} catch (e) { }

		var self = this;

		$('#company_zip_code').autocomplete({
			source: function( request, response ) {
				//console.log(self);
				$.ajax({
					url: zip_source_url + country_code_ISO[$(self).val()],
					dataType: "jsonp",
					data: {
						style: "full",
						maxRows: 12,
						postalcode_startsWith: request.term
					},
					success: function(data) {
						response($.map(data.postalCodes, function(item) {
							var label = item.postalCode + ", " + item.placeName + ", " + item.adminName1;
							if ( item.adminName1== null ) {
								item.adminName1 = '';
								label = item.postalCode + ", " + item.placeName;
							}
							return {
								label: label,
								value: item.postalCode,
								city:item.placeName,
								state:item.adminName1
							}
						}));
						jQuery('.ui-autocomplete').css('width', '250px');
					}
				});
			},
 
			 minLength: 2,
			select: function( event, ui ) {
				jQuery('#company_state').val(ui.item.state);
				jQuery('#company_location').val(ui.item.city);
			},

			open: function() {
				jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},

			close: function() {
				jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}

		});
	}

	$('#company_country').change(bind_zip_autocomplete);
	bind_zip_autocomplete.call($('#company_country').get(0));

	
	var category_all_checkbox 	= jQuery('.wpjr-page-resumes-search .wpjb-element-name-category #category_, .wpjb-page-search .wpjb-element-name-category #category_');
	var category_checkboxes 	= jQuery('.wpjr-page-resumes-search .wpjb-element-name-category input[type="checkbox"]:not(#category_), .wpjb-page-search .wpjb-element-name-category input[type="checkbox"]:not(#category_)');
	
	category_all_checkbox.change( enable_disable_categories );
	enable_disable_categories.call(category_all_checkbox.get(0));

	function enable_disable_categories() {
		if ( $(this).is(":checked") ){
			category_checkboxes.attr('disabled', true);
		} else {
			category_checkboxes.removeAttr('disabled');
		}
	}


	var media_category_all_checkbox 	= jQuery('#explore_categories #all');
	var media_category_checkboxes 		= jQuery('#explore_categories input[type="checkbox"]:not(#all)');
	
	media_category_all_checkbox.change( enable_disable_media_categories );
	enable_disable_media_categories.call(media_category_all_checkbox.get(0));

	function enable_disable_media_categories() {
		if ( $(this).is(":checked") ){
			media_category_checkboxes.attr('disabled', true);
		} else {
			media_category_checkboxes.removeAttr('disabled');
		}
	}

	$('.job_delete').click( function (e) {
		if ( !confirm('Are you sure you want to delete this Job?') ) {
			e.preventDefault();
		} 
	});

	scroll_page_top_pagination();

});


jQuery('#members-dir-list').bind('DOMNodeInserted DOMNodeRemoved', scroll_page_top_pagination);


function scroll_page_top_pagination() {
	jQuery('.pagination-links a.page-numbers').click(function() {
		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
	});
}




jQuery(document).ready( update_rtmedia_categories );

jQuery('#rtmedia-categories-list :checkbox').change( update_rtmedia_categories );

function update_rtmedia_categories() {
	var selected_categories = new Array();
	var all_selected = 0;
	jQuery('#rtmedia-categories-list input[type="checkbox"]:checked').each(function() { 
		/*if ( jQuery(this).val() == 'yes' ) {
			all_selected = 1;
		}*/
		selected_categories.push(jQuery(this).val()); 
	});
	if ( all_selected == 0 ) {
		jQuery('#assign_category_values').val( selected_categories.join() );
	} else {
		jQuery('#assign_category_values').val('');
	}
}