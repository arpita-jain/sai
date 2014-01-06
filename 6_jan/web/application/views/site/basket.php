<?php
include_once("header.php");
?>  
</div>
<div class="Dates-div">
    <div class="col-md-12">
        <h1 class="date-text"><i class="fa fa-archive"></i><span>Basket</span></h1>
    </div>
    <div class="col-md-12">
        <div class="all-Dates">
            <h2>All Basket</h2>
            <div class="date-div">
                <div class="dateText Basket">
                    <form name="checkout" action="<?php echo site_url(); ?>kiosk/checkout" method="post" id="checkout">
                    <ul>
                        <li>
                            <p class="itemsHead"><a class="clear-basketBtn" href="<?php echo site_url(); ?>kiosk/clear_basket">Clear Basket</a> <span><?php
                                if ($this->session->userdata('ticket_id') != "") {
                                    echo count($this->session->userdata('ticket_id'));
                                } else {
                                    echo "0";
                                }
                                ?> items</span> <a class="checkoutBtn" href="javascript:void();" onclick="$('#checkout').submit();">Checkout</a></p>
                            <div class="clearfix"></div>
                        </li>
                        <?php if ($this->session->userdata('ticket_id') != "") { ?>
                            <li class="EverestMain">
                                <i class="fa fa-chevron-circle-right"></i>
                                <div class="Everest-divMain">
                                    <?php
                                    $total = 0;
                                    foreach ($basket as $row) {
                                    $total+=$row['price'];    
                                        ?>
                                        <div class="Everest-div">
                                            <div class="EverestText">
                                                <h4><?php echo $row['event_name'];?>:</h4>
                                                <div class="Photos">Photos From The First Ascent</div>
                                                <div class="moreBtn"><a href="javascript:void(0);" onclick="viewDetailTicket(<?php echo $row['eventId']; ?>);" >more...</a> </div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="plusText"><a class="plusText1" href="javascript:void(0);" onclick="return decQty(<?php echo $row['id']; ?>);">-</a>
                                                <span>
                                                     <input type="hidden" name="tickets[]" value="<?php echo $row['id']; ?>" > 
                                                    <input type="text" id="user_ticket_<?php echo $row['id']; ?>" onblur="get_stock(<?php echo $row['id']; ?>);" name="qty[]" onkeypress="return isNumberKey(event);"  class="required1"  value="1" style="background-color:transparent;border: 0px solid;width:70px;" />
                                                     <input type="hidden" id="actuall_stock_<?php echo $row['id']; ?>" name="actuall_stock"  value="<?php echo $row['stockAvailable']; ?>"/>
                                                </span><a class="plusText2" href="javascript:void(0);" onclick="addQty(<?php echo $row['id']; ?>);">+</a></div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="Everest-div Everest-div-border">
                                            <div class="LocationDiv">
                                                <h4>Location:</h4>
                                                <div class="Woodstock"><?php echo $row['vanu_name']; ?></div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="LocationDiv">
                                                <h4>On:</h4>
                                                <div class="Woodstock"><?php $date= $row['date'];
                                                    $timestamp= strtotime($date);
                                                    $day = date('l', $timestamp); 
                                                    echo date('d-m-Y',strtotime($date)).",".$day; ?></div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="LocationDiv">
                                                <h4>Price: </h4>
                                                <div class="Woodstock"><img src="<?php echo base_url(); ?>assets/site/images/Pound.png"></img><?php $price=$row['price'];echo number_format($price/100,2); ?></div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </li>
                        <?php } else { ?>
                            <div class="alert alert-info">
                                <span> !!Sorry Tickets are not available in basket..</span>   
                            </div> 
                        <?php } ?>
                    </ul>
                     </form>
                </div>
            </div>
        </div>
        <!--all-Dates--> 
        <!-- Modal -->
<div class="modal fade" id="viewDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:#000;" id="myModalLabel">Event Details</h4>
            </div>
            <div class="modal-body"style="color:#000; ">
                <table id="viewData" class="table table-bordered table-stripped">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="test">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    </div>
</div>
</div>
<!--content-->
<script src="<?php echo base_url(); ?>assets/site/js/tickets.js"></script>
<?php
include_once("footer.php");
?>