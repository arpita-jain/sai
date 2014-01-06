<?php
include_once("header.php");
if($this->session->userdata('ticket_id')==""){
    redirect("kiosk/ticket"); 
}
?>
</div>      
<div class="Dates-div">
      <div class="col-md-12">
        <h1 class="date-text"><i class="fa fa-shopping-cart"></i><span>Checkout Confirmation</span></h1>
      </div>
      <div class="col-md-12">
        <div class="all-Dates">
          <h2>Checkout Confirmation</h2>
          <div class="date-div">
            <div class="dateText Basket">
                <?php
                if ($this->session->userdata('ticket_id') != "") {
                ?>
                <form name="checkout" action="<?php echo site_url(); ?>kiosk/Delivery" method="post" id="pay_form">
                <ul>
                    <li>
                  <p class="itemsHead"><a class="clear-basketBtn" href="#">Back</a> 
                      <span>items:<?php if ($this->session->userdata('ticket_id') != "") {echo count($this->session->userdata('ticket_id'));}else{echo "0";} ?> 
                          <br/>Total:<?php //echo array_sum($totalprice);?> </span> 
                      <a class="checkoutBtn" href="javascript:void();" onclick="$('#pay_form').submit();">Pay</a></p>
                </li>
                <li class="EverestMain"><i class="fa fa-chevron-circle-right"></i>
                    <?php    
                                    $total = 0;
                                    foreach ($basket as $row) {
                                    $total+=$row['price'];?>
                  <div class="Everest-divMain">
                    <div class="Everest-div">
                      <div class="EverestText">
                        <h4><?php echo $row['event_name']; ?></h4>
                        <div class="Photos">Photos From The First Ascent</div>
                        <div class="moreBtn"><a href="javascript:void(0);" onclick="viewDetailTicket(<?php echo $row['eventId']; ?>);" >more...</a> </div>
                        <div class="clear"></div>
                      </div>
                      <div class="plusText"><span></span></div>
                      <div class="clear"></div>
                    </div>
                    <div class="Everest-div Everest-div-border">
                      <div class="LocationDiv">
                        <h4>Location:</h4>
                        <div class="Woodstock"><?php echo $row['vanu_name']; ?></div>
                        <div class="clear"></div>
                      </div>
                      <div class="LocationDiv">
                          <?php $date= $row['date'];
                                $timestamp= strtotime($date);
                                $day = date('l', $timestamp); ?>
                        <h4>On:</h4>
                        <div class="Woodstock"><?php echo date('d-m-Y',strtotime($date)).",".$day; ?></div>
                        <div class="clear"></div>
                      </div>     
                        <input type="hidden" name="tickets[]" value="<?php echo $row['qty']; ?>" > 
                        <input type="hidden" id="user_ticket_<?php echo $row['id']; ?>"  name="qty[]" value="<?php echo $row['qty']; ?>"/>
                        <input type="hidden" id="quantity_<?php echo $row['id']; ?>" name="quantity"  value="<?php echo $row['qty']; ?>"/>
                      <div class="LocationDiv">
                        <h4>Price: </h4>
                        <div class="Woodstock"><img src="<?php echo base_url(); ?>assets/site/images/Pound.png"></img><?php $price= $row['price'] * $row['qty'];echo number_format($price/100,2); ?></div>
                        <div class="clear"></div>
                      </div>               
                    </div>
                    <div class="clear"></div>
                  </div>
                    <?php } ?>
                </li>
              </ul>
                  <?php } ?>
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
                <h4 class="modal-title" id="myModalLabel" style="color:#000;">Event Details</h4>
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
  <!--content-->
  <script src="<?php echo base_url(); ?>assets/site/js/tickets.js"></script>
<?php
include_once("footer.php");
?>