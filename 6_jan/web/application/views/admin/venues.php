<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1><small>Manage all Venues </small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i> Venues</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="venue_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
<!--                                <th><input type="checkbox" id="1" class="group-checkable" data-set="#venue_table .checkboxes" ></th>-->
                                <th>Name  <i class="icon-sort"></i></th>
                                <th>Town <i class="icon-sort"></i></th>
                                <th>Country <i class="icon-sort"></i></th>
                                <th>PostCode <i class="icon-sort"></i></th>
                                <th> Website <i class="icon-sort"></i></th>
                                <th>Contact<i class="icon-sort"></i></th>                                
                               <!-- <th>Actions</th>-->

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($venues as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['town']; ?></td>
                                    <td><?php echo $row['county']; ?></td>
                                    <td><?php echo $row['postcode']; ?></td>
                                    <td><?php echo $row['website']; ?></td>
                                    <td><?php echo $row['telephone']; ?></td>                                  
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
<script src="<?php echo base_url(); ?>assets/scripts/venue.js"></script>
<script>
$(document).ready(function() {
    $("#venue_menu").addClass("active");
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