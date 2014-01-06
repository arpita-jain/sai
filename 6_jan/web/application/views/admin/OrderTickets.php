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
                    <table id="ordertickets_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Transaction ID</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>                           
                        <tbody>
                            <?php
                            foreach ($ordertickets as $row) {
                                ?>
                                <tr>   
                                    <td><?php echo $row['ticket_id']; ?></td>
                                    <td><?php echo $row['transaction_id']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['created_date']; ?></td>              
                                    <td> 
                                        <?php
                                        if ($row['status'] == 1) {
                                            $class = "icon-ok-sign";
                                            ?>
                                            <a href="javascript:void(0);" ><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-success icon-large'></i></a>
                                            <?php
                                        } else {
                                            $class = "icon-minus-sign";
                                            ?>
                                            <a href="javascript:void(0);" ><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-error icon-large'></i></a>
                                        <?php } ?>
                                    </td>            
                                    <td align="center">
                                        <a class="btn btn-sm btn-success" href="<?php echo site_url(); ?>admin/printoneticket/<?php echo $row['ticket_id']; ?>/<?php echo $row['transaction_id']; ?>/<?php echo md5($row['ticket_id'] . $row['transaction_id']); ?>">Print Ticket</a>  
                                        <a class="btn btn-sm btn-success" href="<?php echo site_url(); ?>admin/refundoneticket/<?php echo $row['ticket_id']; ?>/<?php echo $row['transaction_id']; ?>/<?php echo md5($row['ticket_id'] . $row['transaction_id']); ?>"> Refund Ticket</a> 
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="clearfix">&nbsp;</div>                      
                </div>
            </div><!-- /.row -->
        </div><!-- /#wrapper -->

    </div>
 </div>
    <!-- /.modal-content -->
    <!-- /.modal -->
    <script src="<?php echo base_url(); ?>assets/scripts/ordertickets.js"></script>

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
