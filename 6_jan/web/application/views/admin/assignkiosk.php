<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1>Supervisors <small>manage all assign kiosk</small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i> Assing Kiosk</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="users_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="1" class="group-checkable" data-set="#users_table .checkboxes" ></th>
                                <th>Name  <i class="icon-sort"></i></th>
                                <th>Mobile <i class="icon-sort"></i></th>
                                <th>Email  <i class="icon-sort"></i></th>
                                <th>Address  <i class="icon-sort"></i></th>
				<th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($admins as $row) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" id="<?php echo $row['id']; ?>" class="checkboxes" onclick="select_row(this);"  ></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
				    <td> 
                                      
                                        <?php if ($row['is_actived'] == 1) { 
						$class="icon-ok-sign";
					
					?>
                                            <a href="javascript:void(0);" onclick="set_supervisorsstatus('<?php echo $row['id']; ?>');"><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-success icon-large'></i></a>
                                        <?php } else { $class="icon-minus-sign"; ?>
                                            <a href="javascript:void(0);" onclick="set_supervisorsstatus('<?php echo $row['id']; ?>');"><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-error icon-large'></i></a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                         <a class="btn btn-small btn-success" href="#"><i class="icon-user"></i>Unassign User</a> 
                                        <a class="btn btn-small btn-success" href="<?php echo site_url(); ?>admin/users?id=<?php echo $row['id']; ?>">Assign-Kiosk</a>
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
                <h4 class="modal-title" id="myModalLabel">Admin Details</h4>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add new Admin</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="firstname">Fist name</label>
                        <input type="text" class="form-control required" id="firstname" name="fistname"  placeholder="First name" >
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name</label> 
                        <input type="text" class="form-control required" name="lastname" id="lastname" placeholder="Last name">
                    </div>
                    <div class="form-group">
                        <label for="email">Mobile</label>
                        <input type="text" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control required" id="mobile" name="mobile">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text"  class="form-control required" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control required" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm-password</label>
                        <input type="password" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control required" id="confirm_password" name="confirm_password">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text"  class="form-control required" id="address" name="address">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addnewuser()">Save changes</button>
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
                <h4 class="modal-title" id="myModalLabel">Admin info</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="upd_firstname">Fist name</label>
                        <input type="text" class="form-control upd_required" id="upd_firstname" name="upd_fistname"  placeholder="First name" >
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
                        <label for="password">Password</label>
                        <input type="password" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control upd_required" id="upd_password" name="upd_password">
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm-password</label>
                        <input type="password" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control upd_required" id="upd_confirm_password" name="upd_confirm_password">
                    </div>
                    <div class="form-group">
                        <label for="upd_address">Address</label>
                        <input type="text"  class="form-control upd_required" id="upd_address" name="upd_address">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editAdmin();">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?php echo base_url(); ?>assets/scripts/supervisors.js"></script>
<script>
$(document).ready(function() {
    $("#supervisors_menu").addClass("active");
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
