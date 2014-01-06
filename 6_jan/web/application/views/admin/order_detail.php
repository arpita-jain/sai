<?php 
//echo"<pre/>";

//print_r($orderDetail);die;
?>
<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1><small>Manage Order </small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i> Order Detail</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="order_detail" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Order Id</th>
				<th>Ticket Id </th>
                                <th>Amount</th>
                                <th>Items</th>
				<th>Kiosk Id</th>
				<th>Created Date</th>
				<th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
				$totalAmount = 0;
                            foreach ($orderDetail as $row) { 
				$Amount = $row['price']*$row['quantity'];
				$totalAmount = $totalAmount+$Amount;
			   ?>
                                <tr> 
				    <td><?php echo $row['transaction_id']; ?></td>             
 	 			    <td><?php echo $row['ticket_id']; ?></td>              
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>                                   
                                    <td><?php echo $row['kiosk_id']; ?></a></td>
  				    <td><?php echo $row['created_date'].'  '.$row['created_time']; ?></a></td>
				    <td><?php echo ($row['price']*$row['quantity']); ?></td>
                                </tr>
                                <?php
                            }
                            ?>	
				 <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><b><?php echo $totalAmount; ?></b></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<script src="<?php echo base_url(); ?>assets/scripts/order_detail.js"></script>
<script>
    $(document).ready(function() {
        $("#kiosks_menu").addClass("active");
    });
</script>
<?php
/*
  .::File Details::.
  End of file supervisors.php
  Project Name: wegottickets
  Created By : Jaswant Singh
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  File Location: ./application/views/admin/supervisors.php
  Created At : 15 Nov, 2013  1:44:07 PM
 */
?>
