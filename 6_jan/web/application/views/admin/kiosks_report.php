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
                    <li class="active"><i class="icon-group"></i> Kiosk Report</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="kiosk_report" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Order Id  <i class="icon-sort"></i></th>
                                <th>Customer Name<i class="icon-sort"></i></th>
                                <th>Amount<i class="icon-sort"></i></th>
                                <th>Items<i class="icon-sort"></i></th>
				<th>Kiosk Id</th>
				<th>View-detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($kioskReport as $row) { ?>
                                <tr> 
				    <td><?php echo $row['order_id']; ?></td>                                                    
				    <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>                                
                                    <td><?php echo $row['order_amount']; ?></td>
                                    <td><?php echo $row['order_items']; ?></td>                                   
                                    <td><?php echo $row['kiosk_id']; ?></a></td>
				    <td><a href="<?php echo base_url(); ?>index.php/admin/order_detail/<?php echo $row['order_id']; ?>" class="btn btn-success btn-sm"><i class="icon-search"></i></a></td>
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


<script src="<?php echo base_url(); ?>assets/scripts/kiosk_report.js"></script>
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
