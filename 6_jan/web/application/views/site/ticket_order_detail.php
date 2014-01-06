<?php
include_once("header.php");
?>
</div>
<div class="Dates-div">
      <div class="col-md-12">
        <h1 class="date-text"><i class="fa fa-tasks"></i><span>Order Details</span></h1>
      </div>
      <div class="col-md-12">
        <div class="all-Dates">
          <h2>Order Details</h2>
          <div class="date-div">
            <div class="dateText Basket">
              <ul>
                  <?php
                    foreach ($order as $row) {
                       
                    foreach($row['tickets'] as $tickete)
                    {
                     $price[]=$tickete['price'];
                    }
                    ?> 
                 <li class="EverestMain">
                 	<div class="co-div">
                            <div id="email_msg"></div>
                        <div class="col-sm-6 col-xs-6"><h4 class="blue-text">Items:<?php echo $item=count($row['tickets']); ?>
                           </h4></div>
                        <div class="col-sm-6 col-xs-6"><h4 class="blue-text r-algin">Total:<i class="fa fa-pounds"></i><?php  $totalprice=array_sum($price);echo $formatted_number = number_format($totalprice/100,2); ?></h4></div>
                        <div class="clear"></div>
                    </div>
                 </li>
                 <li class="EverestMain">
                  <div class="Everest-divMain">
                  	 <div id="order-details">
                        <form class="form-horizontal" role="form" name=""myform>
                           <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="firstname"  value="<?php echo $row['firstname']."&nbsp;&nbsp;".$row['lastname']; ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                              <input type="email" class="form-control" id="email"  placeholder=" " value="<?php echo $row['email']; ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Mobile</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="mobile" readonly placeholder="" value="<?php echo $row['mobile']; ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="address" placeholder="" value="<?php echo $row['address']; ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group btm30">
                            <label for="inputEmail3" class="col-sm-3 control-label">Post code</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="postcode" placeholder="" value="<?php echo $row['postcode']; ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-4">
                              <button type="button" class="clear-orderBtn" onclick="CustomerEmail(<?php echo $row['id']; ?>);">Email Ticket</button>
                            </div>
                            <div class="col-sm-4">
                              <button type="button" class="clear-orderBtn" id="refund" onclick="refundTickets(<?php echo $item.','.$totalprice?>);">Refund Ticket</button>
                            </div>
                            <div class="col-sm-4">
                              <button type="button" class="clear-orderBtn" id="print" onclick=window.open('<?php echo site_url()."kiosk/printTicket/". $row['id']; ?>'); >Print Ticket</button>
                            </div>
                          </div>
                        </form>
                       </div><!--orderdetails-->
                      </div>
                  <div class="clear"></div>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <!--all-Dates--> 
      </div>
    </div>
  </div>
  <!--content-->
  <script src="<?php echo base_url(); ?>assets/site/js/tickets.js"></script>
  <script src="<?php echo base_url(); ?>assets/scripts/common.js"></script>
<?php
include_once("footer.php");
?>