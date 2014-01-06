<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1><small>Manage all Tickets</small></h1>
                <div class="pull-right">
                    <a href="javascript:void(0);" onClick="refreshStockData();" class="btn  btn-primary">
                        <i class="icon-refresh"></i> Update Records
                    </a>
                </div>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i>Tickets</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <form name="ticket-from" id="ticket-form" action="" method="post">
                        <table id="tickets_table" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><input type="hidden" id="1" class="group-checkable" data-set="#tickets_table .checkboxes" ></th>
                                    <th>Ticket Type  <i class="icon-sort"></i></th>
                                    <th>Event Name <i class="icon-sort"></i></th>
                                    <th>Venue Name <i class="icon-sort"></i></th>
                                    <th>Date-Time<i class="icon-sort"></i></th>
                                    <th>Price<i class="icon-sort"></i></th>
                                    <th>Stock Available<i class="icon-sort"></i></th>
                                    <th>Actions<i class="icon-sort"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($tickets as $row) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input name="ticket[]" type="checkbox" id="<?php echo $row['ticket_id']; ?>" class="checkboxes checkbox" onclick="select_row(this);" value="<?php echo $row['ticket_id']; ?>"  >
                                            <input type="hidden" id="event_<?php echo $row['ticket_id']; ?>" class="checkboxes checkbox" onclick="select_row(this);" value="<?php echo $row['event_id']; ?>"  >
                                            <input type="hidden" id="venue_<?php echo $row['ticket_id']; ?>" class="checkboxes checkbox" onclick="select_row(this);" value="<?php echo $row['venue_id']; ?>"  >
                                            <input type="hidden" id="price_<?php echo $row['ticket_id']; ?>" class="checkboxes checkbox" onclick="select_row(this);" value="<?php echo $row['price']; ?>"  >
                                        </td>
                                        <td><?php echo $row['type']; ?></td>
                                        <td><?php echo $row['event_name']; ?></td>
                                        <td><?php echo $row['venue_name']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])) . "-" . $row['time']; ?></td>
                                        <td><?php echo "£" . number_format($row['price'] / 100, 2); ?></td>
                                        <td><?php echo $row['stockAvailable']; ?></td>
                                        <td><a href="javascript:void(0);" onclick="viewDetail(<?php echo $row['eventId']; ?>);" class="btn btn-success btn-sm"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
			<thead>
	       		  <tr>
				<th></th>
				<th><input type="text" name="search_type" size="12" placeholder="Search by Type" class="search_init" /></th>
				<th><input type="text" name="search_event" placeholder="Search By Event" class="search_init" /></th>
				<th><input type="text" name="search_venue" placeholder="Search By Venue" class="search_init" /></th>
				<th><input type="text" name="search_date" placeholder="Search Date" class="search_init" /></th>
				<th></th>
				<th></th>
				<th></th>
			  </tr>
			</thead>
                        </table>
                    </form>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->

<!-- Modal -->
<div class="modal fade" id="viewDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-default" data-dismiss="modal" id="test">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo base_url(); ?>assets/scripts/tickets.js"></script>
<script>
                        $(document).ready(function() {
                            $("#ticket_menu").addClass("active");
                        });
</script>
<script>
    function refreshStockData()
    {
        $.ajax({
            type: 'post',
            dataType: 'text',
            acync: false,
            url: site_path + 'admin_ajax/updateStockPrice',
            data: {
                'action': 'refreshStock'
            },
            success: function(data) {
                window.location.href = '';
            },
            beforeSend: function() {
                $('#waitModel').modal({
                    keyboard: false,
                    backdrop: false
                })
            },
            complete: function() {
                //$("#waitModel").modal("hide");
            }
        });
    }
</script>
<?php
/*
  .::File Details::.
  End of file tickets.php
  Project Name: wegottickets
  Created By : Mayank awasthi
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  File Location: ./application/views/admin/tickets.php
  Created At : 25 Nov, 2013  1:44:07 PM
 */
?>
