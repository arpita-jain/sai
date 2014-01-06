<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1><i class="icon-shopping-cart icon-1x"></i> Cart items </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i>Basket</li>                    
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <form name="checkout" id="checkout" method="post" action="<?php echo site_url(); ?>admin/checkout">
                        <?php
                        if (count($basket) > 0) {
                            ?>
                            <table id="basket_table" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Ticket Type</th>
                                        <th>Event Name </th>
                                        <th>Venue Name </th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                           
                                <tbody>
                                    <?php
                                    $total = 0;
                                    foreach ($basket as $row) {
                                        $total+=($row['price'] * $row['quantity']);
                                        ?>
                                        <tr>
                                            <td><?php echo $row['type']; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td>
                                                <input type="hidden" name="tickets[]" value="<?php echo $row['ticket_id']; ?>" /> 
                                                <input type="text" id="user_ticket_<?php echo $row['ticket_id']; ?>" onblur="get_stock(<?php echo $row['ticket_id']; ?>);" name="qty[]" onkeypress="return isNumberKey(event);"  class="required1" size="4" value="<?php echo $row['quantity']; ?>"/>
                                                <input type="hidden" id="actuall_stock_<?php echo $row['ticket_id']; ?>" name="actuall_stock"  value="<?php echo $row['stockAvailable']; ?>"/>
                                            </td>
                                            <td><?php echo "£" . number_format(($row['price'] * $row['quantity']) / 100, 2); ?></td>                                    
                                            <td><a class="btn btn-danger" href="<?php echo site_url(); ?>admin/removeitem/<?php echo $row['cart_id']; ?>"><i class="icon-trash"></i></a></td>
                                        </tr>
                                    <?php } ?> 
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td ><strong>Total</strong></td>
                                        <td style="width: 75px;height: 46px;"><strong><?php echo "£" . number_format($total / 100, 2); ?></strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="clearfix">&nbsp;</div>
                            <div class="btn-group pull-right">
                                <button type="submit" class="btn btn-primary" name="checkout_btn" >Checkout <i class="icon-chevron-right"></i></button>
                            </div>
                            <div class="btn-group" style="text-align:center;width:80%;">
                                <form action="<?php echo site_url(); ?>admin_ajax/clear_basket" name="clear_basket" method="post">
                                    <a href="<?php echo site_url(); ?>admin/clearcart" class="btn btn-primary" >Clear-Basket</a> 
                                </form>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-warning fade in">
                                <strong>Empty Cart !</strong> Got to tickets and add to cart.
                            </div>
                            <?php
                        }
                        ?>
                        </table>
                    </form>
                </div>
            </div><!-- /.row -->
        </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->



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
