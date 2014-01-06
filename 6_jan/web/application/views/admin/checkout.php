<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1><i class="icon-suitcase icon-1x"></i> Checkout </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i>Checkout</li>                    
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <h2><i class="icon-shopping-cart icon-1x"></i> Items in Cart</h2>
                <hr/>
            </div>                
            <div class="col-lg-12">
                <div class="table-responsive">                      
                    <table id="basket_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Ticket Type</th>
                                <th>Event Name </th>
                                <th>Venue Name </th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>                           
                        <tbody>
                            <?php
                            $total = 0;
                            $i = 0;
                            foreach ($tickets as $row) {
                                $total+=$row['price'] * $qty[$i];
                                ?>
                                <tr>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['event_name']; ?></td>
                                    <td><?php echo $row['venue_name']; ?></td>
                                    <td>                                            
                                        <?php echo $qty[$i]; ?>
                                        <input type="hidden" id="quantity_<?php echo $row['ticket_id']; ?>" name="quantity"  value="<?php echo $qty[$i]; ?>"/>
                                    </td>
                                    <td><i class="icon-gbp"></i> <?php echo number_format($row['price'] * $qty[$i] / 100, 2); ?></td>                                    
                                </tr>
                                <?php $i++;
                            } ?>                          
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><strong>Total</strong></td>
                        <td style="width: 95px;height: 46px;"><strong><i class="icon-gbp icon-2x"></i> <?php echo number_format($total / 100, 2); ?></strong></td>
                        </tbody>
                    </table>
                    <div class="clearfix">&nbsp;</div>                      
                </div>
            </div><!-- /.row -->
        </div><!-- /#wrapper -->
        <div class="row">
            <form role="form" method="post" action="<?php echo site_url(); ?>admin/placeOrder" > 
                <div class="col-lg-12">
                    <h2><i class="icon-truck icon-1x"></i> Delivery </h2>
                    <hr/>
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="firstname">First name</label>
                                <input type="text" class="form-control required" id="firstname" name="firstname"  placeholder="First name" >
                            </div>
                        </div>
                        <div class="clearfix col-xs-1"></div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="lastname">Last name</label> 
                                <input type="text" class="form-control required" name="lastname" id="lastname" placeholder="Last name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="mobile">Phone</label>
                                <input type="text" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control required" id="mobile" name="mobile" placeholder="1234567890" >
                            </div>
                        </div>
                        <div class="clearfix col-xs-1"></div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text"  class="form-control required" id="email" name="email" placeholder="xxx@yahoo.com">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="housenumber">House number/name</label>
                                <input type="text"  class="form-control required" id="houseNumber" name="housenumber" placeholder="House number" > 
                            </div>
                        </div>
                        <div class="clearfix col-xs-1"></div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="street">Street</label>
                                <input type="text"  class="form-control required" id="street" name="street" placeholder="Street" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="city">Town/City</label>
                                <input type="text"  class="form-control required" id="city" name="city" placeholder="City" > 
                            </div>
                        </div>
                        <div class="clearfix col-xs-1"></div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="county">County</label>
                                <input type="text"  class="form-control required" id="county" name="county" placeholder="County">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text"  class="form-control required" id="country" name="country" placeholder="Country">
                            </div>
                        </div>
                        <div class="clearfix col-xs-1"></div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="postcode">Postcode</label>
                                <input type="text"  class="form-control required" id="postcode" name="postcode" placeholder="Olx20" maxlength="12">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">                                             
                                <input type="submit" class="btn btn-primary" onclick="return validateInputs();" value="Sell Now">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
    <!-- /.modal -->
    <script src="<?php echo base_url(); ?>assets/scripts/basket.js"></script>
    <script>
                                    $(document).ready(function() {
                                        $("#basket_menu").addClass("active");
                                    });
    </script>
    <?php
    /*
      .::File Details::.
      End of file tickets.php
      Project Name: wegottickets
      Created By : Mayank awasthi
      Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
      File Location: ./application/views/admin/basket.php
      Created At : 25 Nov, 2013  1:44:07 PM
     */
    ?>
