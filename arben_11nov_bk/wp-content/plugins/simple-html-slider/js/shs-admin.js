//-- SHS Admin Script --------------
//----------------------------------
function shs_add_to_field(field){
	var field_html = '<textarea name="cnt[]" rows="3" style="width:70%;" ></textarea>';
		field_html += "<input type=\"button\" class=\"shs_del\" title=\"Delete\" value=\"\" onClick=\"shs_delete_field(this);\"  /><input type=\"button\" class=\"shs_add\" title=\"Add new\" vlaue=\"\" onClick=\"shs_add_to_field(this);\"  />";
		jQuery(field).parent().after("<li style='display:none;'>" + field_html + "</li>");
		jQuery(field).parent().next().slideDown();
}
function shs_delete_field( field ) {
	jQuery(field).parent().slideUp('fast', function(e){ jQuery(this).html(''); });
}
jQuery(document).ready(function() {
	jQuery( "#joptions" ).sortable();
	jQuery( "#joptions li" ).css({'cursor':'move'});
});

jQuery(document).ready(function(){
	jQuery('.shs_admin_wrapper .handlediv,.shs_admin_wrapper .hndle').click(function(){
		jQuery(this).parent().find('.inside').slideToggle("fast");
	});
});