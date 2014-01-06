<SCRIPT type='text/javascript'>
function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}

function subAction(FormName, FieldName, Count,action)
{
	//alert(FormName);
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	//alert(countCheckBoxes);
	var total = 0;
	var Ids = ""; 
	if(countCheckBoxes){
		for(var i = 0; i < countCheckBoxes; i++)
			if(objCheckBoxes[i].checked == true){
				Ids = Ids + objCheckBoxes[i].value + ",";
				
				total = total+1;
			}
	
	}else{
		if(objCheckBoxes.checked == true){
			Ids = Ids + objCheckBoxes.value + ",";
			
			total = total+1;
		}
	}
	
	//alert(Ids);
	//alert(document.getElementById('abc').value);
	document.getElementById('ids').value = Ids;
	document.getElementById('action').value = action;
	if(total >0){
		document.xyz_em_group.submit(total);
	}else{
		alert("Select atleast one email");
		//return false;
	}
	//alert(total);
}

</script>
<?php 
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$xyz_em_emailMessage = '';
if(isset($_GET['emailmsg'])){
	$xyz_em_emailMessage = $_GET['emailmsg'];
}

if($xyz_em_emailMessage == 1){

?>
<div class="system_notice_area_style1" id="system_notice_area">
	Email successfully updated.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php 

}


if($xyz_em_emailMessage == 2){

?>
<div class="system_notice_area_style1" id="system_notice_area">
	Email successfully unsubscribed.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php 

}
if($xyz_em_emailMessage == 3){

	?>
<div class="system_notice_area_style1" id="system_notice_area">
Email successfully deleted.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}

if($xyz_em_emailMessage == 4){

	?>
<div class="system_notice_area_style1" id="system_notice_area">
Emails successfully added.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}


if($xyz_em_emailMessage == 6){

	?>
<div class="system_notice_area_style0" id="system_notice_area">
Email already exist.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}

if($xyz_em_emailMessage == 5){

	?>
<div class="system_notice_area_style1" id="system_notice_area">
Email successfully activated.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
?>
<div>
<form method="post" name="xyz_em_group" action="<?php echo admin_url('admin.php?page=newsletter-manager-manage-emails&action=group');?>">
	<h2>List Emails</h2>
	
		<?php 
		global $wpdb;
		$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
		$limit = get_option('xyz_em_limit');
		//$limit = 20;
		$offset = ( $pagenum - 1 ) * $limit;
		

		$entries = $wpdb->get_results( "SELECT ea.id,ea.email,em.status FROM ".$wpdb->prefix."xyz_em_email_address ea INNER JOIN ".$wpdb->prefix."xyz_em_address_list_mapping em
ON ea.id=em.ea_id  ORDER BY ea.id DESC LIMIT $offset, $limit" );
		
		
		echo '<div class="wrap">';
		?>
<input class="button-primary cfm_bottonWidth" id="submit_em"
				style="cursor: pointer; margin-bottom:10px;" type="button"
				name="textFieldButton2" value="Add Email Address"
				 onClick='document.location.href="<?php echo admin_url('admin.php?page=newsletter-manager-manage-emails&action=add_emails');?>"'>		
<table class="widefat" style="width:99%;">
<thead>
<tr>
<th scope="col" class="manage-column column-name" style="">Email</th>
<th scope="col" class="manage-column column-name" style="">Name</th>
<th scope="col"  colspan="3" class="manage-column column-name" style="text-align:center;">Action</th>

</tr>
</thead>
<!-- 
<tfoot>
<tr>
<th scope="col" class="manage-column column-name" style="">Email</th>
<th scope="col" class="manage-column column-name" style="">Name</th>
<th scope="col"  colspan="3" class="manage-column column-name" style="text-align:center;">Action</th>

</tr>
</tfoot>
 -->
<tbody>
        <?php if( count($entries)>0 ) { 
        	$pageno = '';
        	if(isset($_GET['pagenum'])){
        		$pageno = $_GET['pagenum'];
        	}
        	if($pageno=="" || $pageno==0){
        		$pageno = 1;
        	}
        	
        	
            $count = 1;
            $class = '';
            foreach( $entries as $entry ) {
            	            	
                $class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
                
               
            ?>
 
            <tr<?php echo $class; ?>>
                <td>
                <input type="checkbox" value="<?php echo $entry->id;?>" name="chk" id="chk<?php echo $entry->id;?>"> &nbsp;
                <?php 

					if($entry->status == 0){?>
					<font color=#DD2929><?php echo $entry->email;?> </font>
					<?php }
					if($entry->status == 1){
						echo $entry->email;
					}
					if($entry->status == -1){
					?>
						<font color=#D7DE10><?php echo $entry->email;?> </font>
					<?php 
					}
					?>
                
                
                
                </td>
                 <td >
                 <?php 
                 
                 echo esc_html($wpdb->get_var( 'SELECT field1 FROM '.$wpdb->prefix.'xyz_em_additional_field_value WHERE ea_id="'.$entry->id.'" ' )) ;
                 
                 ?>
                 </td>
                 <td id="tdCenter">
                 <?php 
			if($entry->status != -1){			
			?>
                 	<a href='<?php echo admin_url('admin.php?page=newsletter-manager-manage-emails&action=edit_email&id='.$entry->id.'&pageno='.$pageno); ?>'><img id="img" title="Edit Email" src="<?php echo plugins_url('newsletter-manager/images/edit.png')?>"></a>
                 <?php 
			}			
                 ?>
                 </td>
                 <td id="tdCenter">
			
			<?php 
			if(($entry->status != 0) && ($entry->status != -1)){			
			?>
			<a
				href="<?php echo admin_url('admin.php?page=newsletter-manager-manage-emails&action=email_unsubscribe&id='.$entry->id.'&pageno='.$pageno); ?>"
				onclick="javascript: return confirm('Please click \'OK\' to confirm ');"><img id="img" title="Unsubscribe Email" src="<?php echo plugins_url('newsletter-manager/images/unsubscribe.png')?>">
			</a>
			<?php 
			}elseif($entry->status == 0){
			?>
			<a
				href="<?php echo admin_url('admin.php?page=newsletter-manager-manage-emails&action=email_activate&id='.$entry->id.'&pageno='.$pageno); ?>"
				onclick="javascript: return confirm('Please click \'OK\' to confirm ');"><img id="img" title="Activate Email" src="<?php echo plugins_url('newsletter-manager/images/active.png')?>">
			</a>
			<?php 
			}
			?>
			</td>
			<td id="tdCenter" ><a
				href='<?php echo admin_url('admin.php?page=newsletter-manager-manage-emails&action=email_delete&id='.$entry->id.'&pageno='.$pageno); ?>'
				onclick="javascript: return confirm('Please click \'OK\' to confirm ');"><img id="img" title="Delete Email" src="<?php echo plugins_url('newsletter-manager/images/delete.png')?>">
			</a></td>
            </tr>
            
 
            <?php
            
                $count++;
            }
            ?>
            
            <tr>
			<td colspan="5" >
			<a  href="javascript:SetAllCheckBoxes('xyz_em_group', 'chk', true);">Check All</a>&nbsp;&nbsp;||
							<a href="javascript:SetAllCheckBoxes('xyz_em_group', 'chk', false);">Uncheck All</a>
							<label style="padding-left:40px;">With Selected&nbsp;:&nbsp;</label> 
							<a  href="javascript: subAction('xyz_em_group', 'chk',<?php echo $limit;?>,2);" >Unsubscribe All</a>&nbsp;&nbsp;||
							<a  href="javascript: subAction('xyz_em_group', 'chk',<?php echo $limit;?>,1);">Delete All</a>
			<br/><br/>
			
			
			<b>Email status </b>&nbsp;:&nbsp;
				<font	color=#D7DE10>Pending</font>
				 &nbsp;&nbsp;&nbsp;
				 <font	color=#DD2929>Unsubscribed</font>
				  &nbsp;&nbsp;&nbsp;
				 <font	>Active</font>
			</td>
		</tr>
            
            
            <?php 
           } else { ?>
        <tr>
            <td colspan="5">Email not found</td>
        </tr>
        <?php } ?>
	
		
		
    </tbody>
    
    <input type="hidden" name="ids" id="ids" value="">
	<input type="hidden" name="action" id="action" value="">
		
	</table>
	<input class="button-primary cfm_bottonWidth" id="submit_em"
				style="cursor: pointer; margin-top:10px; margin-bottom:10px;" type="button"
				name="textFieldButton2" value="Add Email Address"
				 onClick='document.location.href="<?php echo admin_url('admin.php?page=newsletter-manager-manage-emails&action=add_emails');?>"'>
	<?php

	
//  $wpdb->query('ANALYZE TABLE '.$wpdb->prefix.'xyz_em_email_address');
// 	$total1 = $wpdb->get_results( 'SHOW TABLE STATUS WHERE name="'.$wpdb->prefix.'xyz_em_email_address"') ;
// 	$total1 = $total1[0];
	
// 	$num_of_pages = ceil( $total1->Rows / $limit );

	$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM ".$wpdb->prefix."xyz_em_email_address" );
	$num_of_pages = ceil( $total / $limit );
	
function remove_querystring($url) {
	$xyz_em_messageReplacedUrl = preg_replace('/&emailmsg(=[^&]*)?|^emailmsg(=[^&]*)?&?/','',$url);
	return $xyz_em_messageReplacedUrl;
}

	
	$page_links = paginate_links( array(
	  'base' => remove_querystring(add_query_arg( 'pagenum','%#%')),
	    'format' => '',
	    'prev_text' => __( '&laquo;', 'aag' ),
	    'next_text' => __( '&raquo;', 'aag' ),
	    'total' => $num_of_pages,
	    'current' => $pagenum
	) );


//echo "pppp:".remove_querystring_var(add_query_arg( 'pagenum','%#%'),"emailmsg");

if ( $page_links ) {
    echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
}
 
echo '</div>';
	?>
</form>
</div>

