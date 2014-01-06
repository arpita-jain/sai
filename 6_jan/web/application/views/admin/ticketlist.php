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
                                <h3>Here is Avaliable Ticket Quantity:</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Event Name:  </strong>
                                <?php
                             
                                echo $tickequantity['title'];  ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Event Description: </strong>
                                <?php echo $tickequantity['description'];; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr><td> <strong>Ticket Type: </strong></td><td> <?php  $tickequantity['type']; ?></td></tr>                                    
                                    <tr><td> <strong>Ticket Avaliable: </strong></td><td> <?php echo count($tickequantity['id']); ?></td></tr>                                    
                                    <tr><td> <strong>Event Date: </strong></td><td>  <?php echo $tickequantity['date']; ?></td></tr>
                                    <tr><td> <strong>Start time: </strong></td><td>  <?php echo $tickequantity['time']; ?></td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>    
    </div>
    
</div>
