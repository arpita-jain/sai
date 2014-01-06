<?php
require_once(dirname( __FILE__ ) . '../../../../wp-blog-header.php');
global $wpdb;
$tbl_name = $wpdb->prefix.'paypalsetting';
$results = $wpdb->get_results("select * from $tbl_name");
$testmode = $results[0]->testmode;
$this_script = site_url().'/wp-content/plugins/donation/paypalreturn.php';
$amount=$_POST['amount'];

//insert
 $tbl_name1 = $wpdb->prefix.'paypal';
$data1 = array('amount'=>$amount);
if($amount)
{
 $wpdb ->insert($tbl_name1,$data1);
 $lastid= $wpdb->insert_id;
}
require_once( ABSPATH . 'wp-content/plugins/donation/paypal.class.php' );
$p =new paypal_class;
if($testmode=='0')
{
        $p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}
else
{
        $p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
}
    $p->add_field('business', $results[0]->email);
    $p->add_field('return', $this_script.'?action=success');
    $p->add_field('cancel_return', $this_script.'?action=cancel');
    $p->add_field('notify_url', $this_script.'?action=ipn');
    //USD
    $p->add_field('currency_code',$results[0]->currencycode);
    
    $p->add_field('amount',$amount);
    
    $p->add_field('item_number',$lastid);
    
    $p->add_field('item_name','Donation');
    
    $p->submit_paypal_post();
    
?>