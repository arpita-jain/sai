<?php
include_once("header.php");
if($this->session->userdata('ticket_id')==""){
redirect("kiosk/ticket");
}
?>
</div>
<div class="Dates-div">
    <div class="col-md-12">
        <h1 class="date-text"><i class="fa fa-truck"></i><span>Delivery</span></h1>
    </div>
    <div class="col-md-12">
        <div class="all-Dates">
            <h2>All DELIVERY</h2>
            <div class="date-div">
                <div class="dateText Basket">
                    <?php
                    if ($this->session->userdata('ticket_id') != "") {
                    $totQty = 0;
                    $totPrice = 0;
                    for ($i = 0;$i < count($basket);$i++) {
                    $totQty+=$basket[$i]['qty'];
                    $totPrice+=$basket[$i]['price'];
                    }
                    $ticket_id = array_values($this->session->userdata('ticket_id'));
                    $event_id = array_values($this->session->userdata('event_id'));
                    $venue_id = array_values($this->session->userdata('venue_id'));
                    $price = array_values($this->session->userdata('price'));

                    $ticket = implode(",", $ticket_id);
                    $event = implode(",", $event_id);
                    $venue = implode(",", $venue_id);
                    $price = implode(",", $price);
                    ?>
                    <ul>
                        <li class="EverestMain">
                            <div class="co-div">
                                <div class="col-sm-6 col-xs-6"><h4 class="blue-text">Items:<?php echo $totQty; ?></h4></div>
                                <div class="col-sm-6 col-xs-6"><h4 class="blue-text r-algin">Total: <img src="<?php echo base_url(); ?>assets/site/images/Pound.png"></img><?php echo $totPrice; ?></h4></div>
                                <div class="clear"></div>
                            </div>
                        </li>
                        <li class="EverestMain">
                            <div class="Everest-divMain">
                                <div id="delivery">
                                    <form class="form-horizontal" role="form" method="post">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">First Name</label>
                                            <div class="col-sm-9">
                                                <input type="text"class="form-control required" id="firstname" name="fistname"  placeholder="First Name" autofocus >
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control required" name="lastname" id="lastname" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Mobile</label>
                                            <div class="col-sm-9">
                                                <input type="text" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control" id="mobile" name="Mobile" placeholder="1234567890">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text"  class="form-control" id="email" name="email" placeholder="xyz@yahoo.com">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control required" id="address" name="Address" placeholder="Address">
                                            </div>
                                        </div>
                                        <div class="form-group btm30">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Post code</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control required" id="postcode" name="Postcode" placeholder="12345">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-9 pull-right">                            
                                                <button type="button" class="clear-orderBtn pull-left" onclick="window.location = '<?php echo site_url(); ?>kiosk/basket';">Continue</button> 
                                                <button type="button"class="clear-orderBtn pull-right" onclick="addnewcustomer('<?php echo $ticket; ?>','<?php echo $event; ?>','<?php echo $venue; ?>','<?php echo $price; ?>');">Sell Now</button>
                                            </div>
                                        </div>
                                    </form>
                                </div><!--orderdetails-->
                            </div>
                            <div class="clear"></div>
                        </li>
                        <li class="EverestMain"><i class="fa fa-chevron-circle-right"></i>
                              <?php foreach ($basket as $row) {  ?>
                            <div class="Everest-divMain">
                                <div class="Everest-div">
                                    <div class="EverestText">
                                        <h4><?php echo $row['event_name']; ?></h4>
                                        <div class="Photos">Photos From The First Ascent</div>
                                        <div class="moreBtn"><a href="javascript:void(0);" onclick="viewDetailTicket(<?php echo $row['eventId']; ?>);" >more...</a> </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="plusText"><span><?php echo $row['qty']; ?></span></div>
                                   <input type="hidden" id="quantity_<?php echo $row['id']; ?>" name="quantity"  value="<?php echo $row['qty']; ?>"/>
                                    <div class="clear"></div>
                                </div>
                                <div class="Everest-div Everest-div-border">
                                    <div class="LocationDiv">
                                        <h4>Location:</h4>
                                        <div class="Woodstock"><?php echo $row['vanu_name']; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="LocationDiv">
                                        <?php
                                        $date= $row['date'];
                                        $timestamp= strtotime($date);
                                        $day = date('l', $timestamp);
                                        ?>
                                        <h4>On:</h4>
                                        <div class="Woodstock"><?php echo date('d-m-Y',strtotime($date)).",".$day; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="LocationDiv">
                                        <h4>Price: </h4>
                                        <div class="Woodstock"><img src="<?php echo base_url(); ?>assets/site/images/Pound.png"></img><?php $price=$row['price'];echo  number_format($price/100,2); ?></div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </li>
                    </ul>
                <?php       }
                        } 
                   ?>
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
                        <h4 class="modal-title" id="myModalLabel"style="color:#000;">Event Details</h4>
                    </div>
                    <div class="modal-body" style="color:#000;">
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
<script src="<?php echo base_url(); ?>assets/site/js/basket.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/common.js"></script>
<script src="<?php echo base_url(); ?>assets/site/js/tickets.js"></script>
<!--content-->
<?php include_once("footer.php"); ?>