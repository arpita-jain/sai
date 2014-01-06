<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wegot Tickets</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/css/printstyle.css">
</head>

<body>

<div class="wrapper">
	 <img src="<?php echo base_url(); ?>assets/site/images/logo.png" alt=""  class="img_box"/>
    <div class="text left">
         <?php
                        foreach ($orderData as $row) {
                       $datetest= $row['created_time'];
                       $time=explode(" ",$datetest);
                       $date=date('d-m-Y',strtotime($time[0]));
                       foreach($row['tickets'] as $tickete)
                    {
                     $price[]=$tickete['price'];
                    }
                               
                       ?>
    	<ul>
        	<li>Here is your Ticket Confirmation:</li>
           
                <li>BOOKING REFERENCE: <span>t08956743899884</span></br>
                NAMED TICKET HOLDER: <span><?php echo $row['firstname']."&nbsp;&nbsp;".$row['lastname']; ?></span></br>
                Admits:<span> <?php echo $item=count($row['tickets']);?></span></br></li>
                <li>Event: OXFORD LITERARY FESTIVAL EVENT</br>
                Venue: St Anne's College, Oxford</br>
                Start time: <?php  echo  $time[1]; ?></li>    
        </ul>
        <?php } ?>
    </div>
    <div class="bottom">
    	<div class="left"><span>DATE OF PURCHASE:</span><?php  echo  $date; ?></div>
        <div class="left pading"><span>TIME OF PURCHASE:</span><?php  echo  $time[1]; ?></div>
    </div>
    
    <div class="text_box">
    Thank you for purchasing tickets for this Oxford Literary Festival event. This is your ticket confirmation and it
includes your Booking Reference. The booking reference is your ticket. Please read the following terms and
conditions carefully. Please refer all enquiries regarding this ticket to the point of purchase.
    </div>
    
     <div class="text_box">
    <span><a href="javascript:void();" onClick="window.print();">Print</a></span>
    <span><a href="javascript:void();" onClick="window.close();">Close</a></span>
    </div>
</div>

</body>
</html>
