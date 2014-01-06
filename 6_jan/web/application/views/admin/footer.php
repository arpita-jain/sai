<!-- Bootstrap core JavaScript -->
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootbox.js"></script>
<!-- Page Specific Plugins -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/morris/chart-data-morris.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/TableTools/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/TableTools/media/js/TableTools.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
<?php if ($this->session->userdata("admin_type") == 0 || $this->session->userdata("admin_type") == 1) { ?>
    <script>
        function refreshData()
        {
            $.ajax({
                type: 'post',
                dataType: 'text',
                acync: false,
                url: site_path + 'admin_ajax/updateDataTables',
                data: {
                    'action': 'refresh'
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
    <!-- Modal -->
    <div class="modal fade" id="waitModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Updating Kiosk server records</h4>
                </div>
                <div class="modal-body">
                    Please wait while we are updating records on kiosk server.......
                    <i class="icon-spinner icon-spin icon-1x"></i>
                    <i class="icon-refresh icon-spin icon-3x"></i>
                    <i class="icon-cog icon-spin icon-5x"></i>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php } ?>
</body>
</html>

<?php
/*
  .::File Details::.
  End of file footer.php
  Created By : Jaswant Singh
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  Location: ./application/Controllers/footer.php
  Created At : 15 Nov, 2013  2:41:19 PM
 */
?>
