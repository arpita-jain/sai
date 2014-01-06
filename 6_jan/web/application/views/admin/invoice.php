<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Oxford</title>
        <link href="<?php echo base_url(); ?>assets/admin/css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="wrapper" style="height:100px;">
            <div class="text_box">
                <a href="<?php echo site_url(); ?>admin/tickets" style="float:left;margin-left: 10px;"   >Back to Tickets</a>
                <a href="<?php echo site_url(); ?>admin/printticket/<?php echo $ticketinfo['orderinfo']['order_id']; ?>/<?php echo md5($ticketinfo['orderinfo']['order_id'] . "jaswant.s@cisinlabs.com"); ?>" style="float:left;margin-left: 10px;"   >Print Ticket</a>
                <a href="<?php echo site_url(); ?>admin/downloadticket/<?php echo $ticketinfo['orderinfo']['order_id']; ?>/<?php echo md5($ticketinfo['orderinfo']['order_id'] . "jaswant.s@cisinlabs.com"); ?>" style="float:right;margin-left: 10px;"   >Download Ticket</a>
                <a href="<?php echo site_url(); ?>admin/emailticket/<?php echo $ticketinfo['orderinfo']['order_id']; ?>/<?php echo md5($ticketinfo['orderinfo']['order_id'] . "jaswant.s@cisinlabs.com"); ?>" style="float:right;margin-left: 10px;"  >Email Ticket</a>
            </div>
        </div>
        <?php
        foreach ($ticketinfo['itemsinfo'] as $item) {
            ?>
            <div class="wrapper" style="height:100px;">        <hr/></div>
            <div class="wrapper" style="height:600px;">
                <img src="<?php echo base_url(); ?>assets/admin/images/img.jpg" alt=""  class="img_box"/>
                <div class="text left">
                    <ul>
                        <li>Here is your Ticket Confirmation:</li>
                        <li>BOOKING REFERENCE: <span><?php echo $item['ticket_id']; ?></span></br>
                            NAMED TICKET HOLDER: <span><?php echo $ticketinfo['customerinfo']['firstname'] . " " . $ticketinfo['customerinfo']['lastname']; ?></span></br> 
                        </li>
                        <li>Event: <?php echo $item['event_name']; ?></br>
                            Venue: <?php echo $item['venue_name']; ?></br>
                            Admits:<span> <?php echo $item['quantity']; ?></span><br/>
                            Start date: <?php echo $item['event_date']; ?><br/> 
                            Start time: <?php echo $item['event_time']; ?></li>    
                    </ul>
                </div>
                <div class="bottom"> 
                    <div class="left"><span>DATE OF PURCHASE:</span> <?php echo $ticketinfo['orderinfo']['created_date']; ?></div>
                    <div class="left pading"><span>TIME OF PURCHASE:</span> <?php echo $ticketinfo['orderinfo']['created_time']; ?></div>
                </div>
                <div class="text_box">
                    Thank you for purchasing tickets for this Oxford Literary Festival event. This is your ticket confirmation and it
                    includes your Booking Reference. The booking reference is your ticket. Please read the following terms and
                    conditions carefully. Please refer all enquiries regarding this ticket to the point of purchase.
                </div>
                <div class="text_box">
                    <span>Terms and Conditions
                        The NAMED TICKET HOLDER must give their name and this reference and may be asked to confirm</span>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="wrapper" style="height:100px;">        <hr/></div>

        <div class="wrapper" style="height:100px;">
            <div class="text_box">
                <a href="<?php echo site_url(); ?>admin/tickets" style="float:left;margin-left: 10px;"   >Back to Tickets</a>
                <a href="<?php echo site_url(); ?>admin/printticket/<?php echo $ticketinfo['orderinfo']['order_id']; ?>/<?php echo md5($ticketinfo['orderinfo']['order_id'] . "jaswant.s@cisinlabs.com"); ?>" style="float:left;margin-left: 10px;"   >Print Ticket</a>
                <a href="<?php echo site_url(); ?>admin/downloadticket/<?php echo $ticketinfo['orderinfo']['order_id']; ?>/<?php echo md5($ticketinfo['orderinfo']['order_id'] . "jaswant.s@cisinlabs.com"); ?>" style="float:right;margin-left: 10px;"   >Download Ticket</a>
                <a href="<?php echo site_url(); ?>admin/emailticket/<?php echo $ticketinfo['orderinfo']['order_id']; ?>/<?php echo md5($ticketinfo['orderinfo']['order_id'] . "jaswant.s@cisinlabs.com"); ?>" style="float:right;margin-left: 10px;"  >Email Ticket</a>
            </div>
        </div>
    </body>
</html>
