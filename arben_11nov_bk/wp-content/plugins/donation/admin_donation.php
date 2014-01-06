
<h3>Paypal Setting</h3>
<?php

require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
global $wpdb;
$tbl_name = $wpdb->prefix.'paypalsetting';
$results = $wpdb->get_results("select * from $tbl_name");
?>
<div style="padding-top: 100px;">
<form name="demoForm" action="<?php echo plugins_url('save.php', __FILE__);?>" method="post">
    <table>
      
        <tr>
            <td>Email</td>
            <td><input type="text" name="email" value="<?php if($results[0]) {echo $results[0]->email;}?>" /></td>
        </tr>
        <tr>
        <td>Amount</td>
            <td><input type="text" name="amount" value="<?php if($results[0]) {echo $results[0]->amount;}?>" /></td>
            </tr>
        <td>Testmode</td>
            <td><select name="testmode">
                <option value="0">Yes</option>
                <option <?php if($results[0]->testmode== 1){ ?> selected="selected" <?php }?> value="1">No</option>
            </select></td>
        </tr>
         <td>ReturnUrl</td>
            <td><input type="text" name="returnurl" value="<?php if($results[0]) {echo $results[0]->returnurl;}?>" /></td>
            </tr>
        <td>Currency Code</td>
            <td><input type="text" name="currencycode" value="<?php if($results[0]) {echo $results[0]->currencycode;}?>" /></td>
            </tr>
        <tr>
            <input type="hidden" name="id" value="<?php if($results[0]) {echo $results[0]->id;}?>" />
            <td colspan="2"><input type="submit" name="save" value="Save" /></td>
        </tr>
    </table>
</form>
</div>