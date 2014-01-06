<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1>Customer <small>manage all customer</small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i>Customer</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="customer_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Transaction Id <i class="icon-sort"></i></th>
                                <th>Name  <i class="icon-sort"></i></th>
                                <th>Mobile <i class="icon-sort"></i></th>
                                <th>Email  <i class="icon-sort"></i></th>
                                <th>Address  <i class="icon-sort"></i></th>                            
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($customers as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['city']; ?></td>               
                                    <td>
                                        <a class="btn btn-success btn-xs" href="javascript:void(0);" onclick="viewCustomer(<?php echo $row['cid']; ?>);" ><i class="icon-search"></i></a>                                        
                                        <a  class="btn btn-warning btn-xs" href="javascript:void(0);" onclick="updateCustomer(<?php echo $row['cid']; ?>);"><i class="icon-pencil"></i></a>                                        
                                        <a class="btn btn-xs btn-success" href="<?php echo site_url(); ?>admin/printticket/<?php echo $row['order_id']; ?>/<?php echo md5($row['order_id'] . "jaswant.s@cisinlabs.com"); ?>"> Print</a>                                       
                                        <a class="btn btn-xs btn-success" href="<?php echo site_url(); ?>admin/refund/<?php echo $row['order_id']; ?>/<?php echo md5($row['order_id'] . "jaswant.s@cisinlabs.com"); ?>"> Refund Order</a> 
                                        <a class="btn btn-xs btn-success" href="<?php echo site_url(); ?>admin/OrderTickets/<?php echo $row['order_id']; ?>/<?php echo md5($row['order_id'] . "jaswant.s@cisinlabs.com"); ?>"> Order details</a>                                       
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

<!-- Modal -->
<div class="modal fade" id="viewAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Customer Details</h4>
            </div>
            <div class="modal-body">
                <table id="viewData" class="table table-bordered table-stripped">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="updateAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Customer info</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="upd_firstname">First name</label>
                        <input type="text" class="form-control upd_required" id="upd_firstname" name="upd_Firstname"  placeholder="First name" >
                        <input type="hidden" class="hidden" id="upd_id" name="upd_id" >
                    </div>
                    <div class="form-group">
                        <label for="upd_lastname">Last name</label> 
                        <input type="text" class="form-control upd_required" name="upd_lastname" id="upd_lastname" placeholder="Last name">
                    </div>
                    <div class="form-group">
                        <label for="upd_email">Mobile</label>
                        <input type="text" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control upd_required" id="upd_mobile" name="upd_mobile">
                    </div>
                    <div class="form-group">
                        <label for="upd_email">Email</label>
                        <input type="text"  class="form-control upd_required" id="upd_email" name="upd_email">
                    </div>            
                    <div class="form-group">
                        <label for="upd_address">House Number</label>
                        <input type="text"  class="form-control upd_required" id="upd_housenumber" name="housenumber">
                    </div>
                    <div class="form-group">
                        <label for="upd_address">Street</label>
                        <input type="text"  class="form-control upd_required" id="upd_street" name="upd_street">
                    </div>
                    <div class="form-group">
                        <label for="upd_address">City</label>
                        <input type="text"  class="form-control upd_required" id="upd_city" name="upd_city">
                    </div>
                    <div class="form-group">
                        <label for="upd_address">County</label>
                        <input type="text"  class="form-control upd_required" id="upd_county" name="upd_county">
                    </div>                    
                    <div class="form-group">
                        <label for="upd_address">Country</label>
                        <input type="text"  class="form-control upd_required" id="upd_country" name="upd_country">
                    </div>
                    <div class="form-group">
                        <label for="upd_address">Postcode</label>
                        <input type="text"  class="form-control upd_required" id="upd_postcode" name="upd_postcode"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editCustomer();">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?php echo base_url(); ?>assets/scripts/customer.js"></script>
<script>
                                            $(document).ready(function() {
                                                $("#customer_menu").addClass("active");
                                            });
</script>
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
