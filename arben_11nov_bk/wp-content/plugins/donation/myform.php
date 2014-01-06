<script type="text/javascript" src="<?php echo  plugins_url().'/donation/js/popupbox.js';?>"></script>                                                           
<link rel="stylesheet" type="text/css" href="<?php echo  plugins_url().'/donation/css/popupbox.css';?>">
     <!-- Main Page -->
         <a  href="javascript:void(0)" id="sampledonation">Pay/Donate</a>
   
    
<?php
require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
global $wpdb;
$tbl_name1 = $wpdb->prefix.'paypal';

$tbl_name = $wpdb->prefix.'paypalsetting';
$results = $wpdb->get_results("select * from $tbl_name");
?>
<div id="popup_box_donation">
     <div class="container">
        <a id="popupBoxClose_donation"><img alt="Close" src="<?php echo site_url();?>/wp-content/themes/constructionmates/images/close.png"></a>
    </div>

    <form action="<?php  echo  plugins_url().'/donation/front.php';?>" name="donationform" method="post" > 
          <p>You can Change the Amount</p><input type="text" name="amount" value="<?php echo $results[0]->amount; ?>" />
       <input class="button" type="submit" name="Save" value="" />
    </form>
</div>