<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1>Kiosk Groups <small>Manager </small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i> Groups</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="group_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="1" class="group-checkable" data-set="#group_table .checkboxes" ></th>
                                <th>Group Name  <i class="icon-sort"></i></th>
                                <th>Description  <i class="icon-sort"></i></th>
                                <th>Date <i class="icon-sort"></i></th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($groups as $row) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" id="<?php echo $row['id']; ?>" class="checkboxes" onclick="select_row(this);"  ></td>
                                    <td><?php echo $row['group_name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td  align="center">
                                        <?php
                                        if ($row['is_actived'] == 1) {
                                            $class = "icon-ok-sign";
                                            ?>
                                            <a href="javascript:void(0);" onclick="set_kioskgroupsstatus('<?php echo $row['id']; ?>');"><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-success icon-large'></i></a>
                                            <?php
                                        } else {
                                            $class = "icon-minus-sign";
                                            ?>
                                            <a href="javascript:void(0);" onclick="set_kioskgroupsstatus('<?php echo $row['id']; ?>');"><i id="status_<?php echo $row['id']; ?>" class='<?php echo $class; ?> text-error icon-large'></i></a>
                                        <?php } ?>
                                    </td>
                                    <td  align="center">
                                        <a href="javascript:void(0);" onclick="viewGroup(<?php echo $row['id']; ?>);" class="btn btn-success btn-sm"><i class="icon-search"></i></a>
                                        <a href="javascript:void(0);" onclick="updateGroup(<?php echo $row['id']; ?>);" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></a>
                                        <a href="javascript:void(0);" onclick="delete_groups(<?php echo $row['id']; ?>);" class="delete btn btn-danger btn-sm"><i class="icon-trash"></i></a>
                                        <a class="btn btn-small btn-success" href="<?php echo site_url(); ?>admin/assignedkiosks/<?php echo $row['id']; ?>/<?php echo md5($row['id']."jaswant.s@cisinlabs.com"); ?>"><i class="icon-cog"></i> Manage Group</a>
					<!--a href="kioskgroupsReport/<?php echo $row['id']; ?>" class="btn btn-success btn-sm"><i class="icon-search"></i></a-->
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
<div class="modal fade" id="viewGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Group Details</h4>
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
                <h4 class="modal-title" id="myModalLabel">Add New Group</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="group_name">Group Name</label>
                        <input type="text" class="form-control required " id="group_name"  name="group_name"  placeholder="Group Name" />
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control required" id="description" name="description" placeholder="Description"></textarea>
                    </div>   
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control required " id="location"  name="location"  placeholder="Location" />
                    </div>  
                    <div class="form-group">
                        <label for="supervisor">Assign Supervisor</label>
                        <select class="form-control required " name="supervisor" id="supervisor">
                            <option value="">Select Supervisor</option>
                            <?php foreach ($admins as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="add_group" class="btn btn-primary">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="updateGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Group Info</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="group_name">Group Name</label>
                        <input type="text" class="form-control required length" id="upd_group_name"  name="upd_group_name"  placeholder="Group Name" />
                        <input type="hidden" class="hidden" id="upd_id" name="upd_id" >
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control required" id="upd_description" name="upd_description" placeholder="Description"></textarea>
                    </div> 
                    <div class="form-group">
                        <label for="location">Location</label>
                         <input type="text" class="form-control required length" id="upd_location"  name="upd_location"  placeholder="Location" />
                    </div> 
                    <div class="form-group">
                        <label for="supervisor">Supervisor list</label>
                        <select class="form-control required " name="upd_supervisor" id="upd_supervisor">
                            <option value="">-Please Select-</option>
                            <?php foreach ($admins as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editGroup();" id="editGroup">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?php echo base_url(); ?>assets/scripts/groups.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/common.js"></script>
<script>
    $(document).ready(function() {
        $("#group_menu").addClass("active");
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
