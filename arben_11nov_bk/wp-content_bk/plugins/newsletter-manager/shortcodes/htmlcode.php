<script>
function xyz_em_verify_fields()
{
var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
var address = document.subscription.xyz_em_email.value;
if(reg.test(address) == false) {
alert("Please check whether the email is correct.");
return false;
}else{
//document.subscription.submit();
return true;
}
}

</script>
<style>
#tdTop{
	border-top:none;
}
</style>
<form method="POST" name="subscription" action="<?php echo plugins_url('newsletter-manager/subscription.php');?>">
<table border="0" style="display:none;">
<tr>
<td id="tdTop"  colspan="2">
<span style="font-size:14px;display:none;"><b><?php echo esc_html(get_option('xyz_em_widgetName'))?></b></span>
</td>
</tr>
<tr >
<td id="tdname" width="200px" style="display:none;">Name</td>
<td id="tdTop" >
<input id="xyz_em_name" name="xyz_em_name" type="text" />
</td>
</tr>
<tr >
<td id="tdemail" style="display:none;" >Email Address</td>
<td id="tdTop">
<input  id="xyz_em_email" name="xyz_em_email" type="text" /><span style="color:#FF0000">*</span>
</td>
</tr>
<tr>
<td id="tdTop"  style="display:none;">&nbsp;</td>
<td id="tdTop">
<div style="height:20px;"><input name="htmlSubmit"  id="submit_em" class="button-primary" type="submit" value="Subscribe" onclick="javascript: if(!xyz_em_verify_fields()) return false; "  /></div>
</td>
</tr>
<tr>
<td id="tdTop" colspan="3" >&nbsp;</td>
</tr>
</table>
</form>