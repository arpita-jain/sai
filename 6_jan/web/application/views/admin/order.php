<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1>Order <small>manage all Order</small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i>Order</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="order_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Order Number  <i class="icon-sort"></i></th>
                                <th>Order Item <i class="icon-sort"></i></th>
                                <th>Order Quantity <i class="icon-sort"></i></th>                                
                                <th>Order Date  <i class="icon-sort"></i></th>   
                                <th>Status  <i class="icon-sort"></i></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($order as $row) {
                                ?>
                                <tr>   
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo $row['order_items']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['created_date']; ?></td>               
                                    <td> 
                                        <?php
                                        if ($row['order_status'] == 1) {
                                            $class = "icon-ok-sign";
                                            ?>
                                            <a href="javascript:void(0);" onclick="set_usersstatus('<?php echo $row['id']; ?>');"><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-success icon-large'></i></a>
                                            <?php
                                        } else {
                                            $class = "icon-minus-sign";
                                            ?>
                                            <a href="javascript:void(0);" onclick="set_usersstatus('<?php echo $row['id']; ?>');"><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-error icon-large'></i></a>
                                        <?php } ?>
                                    </td>            
                                    <td>
                                        <a class="btn btn-small btn-success" href="<?php echo site_url(); ?>admin/printticket/<?php echo $row['order_id']; ?>/<?php echo md5($row['order_id'] . "jaswant.s@cisinlabs.com"); ?>">Print</a>                                       
                                        <a class="btn btn-small btn-success" href="<?php echo site_url(); ?>admin/order/<?php echo $row['cid']; ?>">Refund Order</a>                                       
                                        <a class="btn btn-small btn-success" href="<?php echo site_url(); ?>admin/OrderTickets/<?php echo $row['oid']; ?>"><li class="icon-ticket"></li> Show Tickets</a>                                       
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<script src="<?php echo base_url(); ?>assets/scripts/order.js"></script>

<?php
/*
  .::File Details::.
  End of file users.php
  Project Name: wegottickets
  Created By : Jaswant Singh
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  File Location: ./application/views/admin/users.php
  Created At : 15 Nov, 2013  1:44:18 PM
 */
?>
