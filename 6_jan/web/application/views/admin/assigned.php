<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1>Assigned Kiosks <small>manager</small></h1>
                <div class="btn-group pull-right">
                    <button type="button" class="btn  btn-primary dropdown-toggle " data-toggle="dropdown">
                        <i class="icon-group"></i> Assigned Kiosks <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo site_url(); ?>admin/assignedkiosks/<?php echo $group_id; ?>/<?php echo md5($group_id."jaswant.s@cisinlabs.com"); ?>">Assigned Kiosks</a></li>
                        <li><a href="<?php echo site_url(); ?>admin/unassignedkiosks/<?php echo $group_id; ?>/<?php echo md5($group_id."jaswant.s@cisinlabs.com"); ?>">Unassigned Kiosks</a></li>
                    </ul>
                </div>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i> Assigned Kiosk</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <form id="kioskform" action="" method="post">
                        <table id="users_table" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="1" class="group-checkable" data-set="#users_table .checkboxes" ></th>
                                    <th>Name  <i class="icon-sort"></i></th>
                                    <th>Description <i class="icon-sort"></i></th>
                                    <th>Token  <i class="icon-sort"></i></th>
                                    <th>Date Time  <i class="icon-sort"></i></th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($kiosks as $row) {
                                    ?>
                                    <tr> 
                                        <td><input type="checkbox" name="kiosks[]" value="<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>" class="checkboxes" onclick="select_row(this);"  ></td>
                                        <td><?php echo $row['kiosk_name']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><?php echo $row['token']; ?></td>
                                        <td><?php echo $row['ts']; ?></td>
                                        <td align="center"> 
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
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<script src="<?php echo base_url(); ?>assets/scripts/assignedkiosks.js"></script>
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
