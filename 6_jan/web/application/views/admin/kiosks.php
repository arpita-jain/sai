<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1>Kiosks <small>Manage </small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i> Kiosks</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="kiosks_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="1" class="group-checkable" data-set="#kiosks_table .checkboxes" ></th>
                                <th>Kiosk Name  <i class="icon-sort"></i></th>
                                <th>Token  <i class="icon-sort"></i></th>
                                <th>Description  <i class="icon-sort"></i></th>
                                <th>Date Time <i class="icon-sort"></i></th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($kiosks as $row) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" id="<?php echo $row['id']; ?>" class="checkboxes" onclick="select_row(this);"  ></td>
                                    <td><?php echo $row['kiosk_name']; ?></td>
                                    <td><?php echo $row['token']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['ts']; ?></td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 1) {
                                            $class = "icon-ok-sign";
                                            ?>
                                            <a href="javascript:void(0);" onclick="set_kioskstatus('<?php echo $row['id']; ?>');"><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-success icon-large'></i></a>
                                        <?php
                                        } else {
                                            $class = "icon-minus-sign";
                                            ?>
                                            <a href="javascript:void(0);" onclick="set_kioskstatus('<?php echo $row['id']; ?>');"><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-error icon-large'></i></a>
    <?php } ?>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" onclick="viewKiosk(<?php echo $row['id']; ?>);" class="btn btn-success btn-sm"><i class="icon-search"></i></a>
                                        <a href="javascript:void(0);" onclick="editKiosk(<?php echo $row['id']; ?>);" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></a>
                                        <a href="javascript:void(0);" onclick="delete_kiosks(<?php echo $row['id']; ?>);" class="delete btn btn-danger btn-sm"><i class="icon-trash"></i></a>
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
<div class="modal fade" id="viewKiosk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kiosk Details</h4>
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
        <form role="form" action="<?php echo site_url(); ?>admin/addkiosk" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add New Kiosk</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kiosk_name">Kiosk Name</label>
                        <input type="text" class="form-control required " id="kiosk_name"  name="kiosk_name"  placeholder="Kiosk Name" />
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control required" id="description" name="description" placeholder="Description"></textarea>
                    </div>                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="add_kiosk" class="btn btn-primary">Save</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="updateKiosk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kiosk Info</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="group_name">Kiosk Name</label>
                        <input type="text" class="form-control required length" id="upd_kiosk_name"  name="upd_kiosk_name"  placeholder="Group Name" />
                        <input type="hidden" class="hidden" id="upd_id" name="upd_id" >
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control required" id="upd_description" name="upd_description" placeholder="Description"></textarea>
                    </div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateKiosk();" id="editGroup">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?php echo base_url(); ?>assets/scripts/kiosks.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/common.js"></script>
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
