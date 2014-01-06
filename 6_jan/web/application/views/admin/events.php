<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1><small>Manage all Events </small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i> Events</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="events_table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Title  <i class="icon-sort"></i></th>
                                <th>Description<i class="icon-sort"></i></th>
                                <th>Date-time<i class="icon-sort"></i></th>
                                <th>Age Limit  <i class="icon-sort"></i></th>
                                <th>Status<i class="icon-sort"></i></th>
                                <th>View-detail<i class="icon-sort"></i></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($events as $row) {
                                $desc = $row['description'];
                                $cont = substr($desc, 0, 80);
                                ?>
                                <tr> <td><?php echo $row['title']; ?></td>                                                                      
                                    <td><?php echo $cont; ?></td>
                                    <td><?php echo $row['date'] . "&nbsp-" . $row['time']; ?></td>                                   
                                    <td><?php echo $row['ageLimit']; ?></td>
                                    <td><?php echo $row['status']; ?></td>                                   
                                    <td align="centre">
                                        <a href="javascript:void(0);" onclick="vieweventdetails(<?php echo $row['id']; ?>);" class="btn btn-success btn-sm"><i class="icon-search"></i></a>                                       
                                        <a class="btn btn-xs btn-success" href="<?php echo site_url(); ?>admin/printticketquantity/<?php echo $row['id']; ?>/<?php echo md5($row['id'] . $row['id']); ?>">Print Ticket</a>  
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
<div class="modal fade" id="viewEvents" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Event Details</h4>
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
<script src="<?php echo base_url(); ?>assets/scripts/events.js"></script>
<script>
    $(document).ready(function() {
        $("#event_menu").addClass("active");
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