<div class="wrapper" style="height:600px;">
    <div class="text_box">
        <table>
            <tr>
                <td>
                    <img style="width:300px;" src="<?php echo base_url(); ?>assets/admin/images/img.jpg" alt=""  />
                </td>
                <td valign="top" align="right">
                    <table style="width:100%;">
                        <tr>
                            <td>
                                <h3>Here is your Ticket Confirmation:</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                BOOKING REFERENCE: 
                                <?php echo $ticketinfo['itemsinfo']['ticket_id']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                NAMED TICKET HOLDER:
                                <?php echo $ticketinfo['customerinfo']['firstname'] . " " . $ticketinfo['customerinfo']['lastname']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr><td>Event:</td><td> <?php echo $ticketinfo['itemsinfo']['event_name']; ?></td></tr>
                                    <tr><td>Venue: </td><td> <?php echo $ticketinfo['itemsinfo']['venue_name']; ?></td></tr>
                                    <tr><td>Admits:</td><td>  <?php echo $ticketinfo['itemsinfo']['quantity']; ?></td></tr>
                                    <tr><td>Event Date:</td><td>  <?php echo $ticketinfo['itemsinfo']['event_date']; ?></td></tr>
                                    <tr><td>Start time:</td><td>  <?php echo $ticketinfo['itemsinfo']['event_time']; ?></td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>    
    </div>
    <div class="bottom">
        <table style="width:100%;">
            <tr>
                <td align="left">
                    <h3>DATE OF PURCHASE: <?php echo $ticketinfo['orderinfo']['created_date']; ?></h3>
                </td>
                <td align="right">
                    <h3>TIME OF PURCHASE: <?php echo $ticketinfo['orderinfo']['created_time']; ?></h3>
                </td>
            </tr>
        </table>
    </div>
    <div class="text_box" style="text-align: justify;">
        Thank you for purchasing tickets for this Oxford Literary Festival event. This is your ticket confirmation and it
        includes your Booking Reference. The booking reference is your ticket. Please read the following terms and
        conditions carefully. Please refer all enquiries regarding this ticket to the point of purchase.
    </div>
    <div class="text_box">
        <span>Terms and Conditions
            The NAMED TICKET HOLDER must give their name and this reference and may be asked to confirm</span>
    </div>
</div>
