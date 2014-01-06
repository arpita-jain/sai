<div id="wrapper">

    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1>Dashboard <small>Statistics Overview</small></h1>
                <ol class="breadcrumb">
                    <li class="active"><i class="icon-dashboard"></i> Dashboard</li>
                </ol>
            </div>
        </div><!-- /.row -->
        <?php
        if ($this->session->userdata("success_ack") != "") {
            ?>           
            <div class="alert alert-success fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Acknowledgment ! </strong> <?php echo $this->session->userdata("success_ack"); ?>
            </div>
            <?php
            $this->session->unset_userdata("success_ack");
        }
        ?>
        <?php
        if ($this->session->userdata("error_ack") != "") {
            ?>           
            <div class="alert alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Warning !</strong> <?php echo $this->session->userdata("error_ack"); ?>
            </div>
            <?php
            $this->session->unset_userdata("error_ack");
        }
        ?>
        <div class="row">
            <?php if ($this->session->userdata("admin_type") < 1) { ?>   
                <div class="col-lg-3">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <i class="icon-group icon-5x"></i>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <p class="announcement-heading"><?php echo $users['admins']; ?></p>
                                    <p class="announcement-text">Administrators</p>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url(); ?>admin/administrators">
                            <div class="panel-footer announcement-bottom">
                                <div class="row">
                                    <div class="col-xs-8">
                                        View Admins
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <i class="icon-circle-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <?php if ($this->session->userdata("admin_type") < 2) { ?>   
                <div class="col-lg-3">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <i class="icon-group icon-5x"></i>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <p class="announcement-heading"><?php echo $users['masters']; ?></p>
                                    <p class="announcement-text">Master Users</p>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url(); ?>admin/masters">
                            <div class="panel-footer announcement-bottom">
                                <div class="row">
                                    <div class="col-xs-8">
                                        View Masters
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <i class="icon-circle-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <?php if ($this->session->userdata("admin_type") < 3) { ?>   
                <div class="col-lg-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <i class="icon-group icon-5x"></i>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <p class="announcement-heading"><?php echo $users['supervisors']; ?></p>
                                    <p class="announcement-text">Supervisors</p>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url(); ?>admin/supervisors">
                            <div class="panel-footer announcement-bottom">
                                <div class="row">
                                    <div class="col-xs-8">
                                        View Supervisors
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <i class="icon-circle-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <?php if ($this->session->userdata("admin_type") < 4) { ?>   
                <div class="col-lg-3">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <i class="icon-group icon-5x"></i>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <p class="announcement-heading"><?php echo $users['users']; ?></p>
                                    <p class="announcement-text">Users</p>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url(); ?>admin/users">
                            <div class="panel-footer announcement-bottom">
                                <div class="row">
                                    <div class="col-xs-8">
                                        View Users
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <i class="icon-circle-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon-bar-chart"></i> Sale of Tickets : October 1, 2013 - October 31, 2013</h3>
                    </div>
                    <div class="panel-body">
                        <div id="morris-chart-area"></div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<script>
    $(document).ready(function() {
        $("#dashboard_menu").addClass("active");
    });
</script>
<?php
/*
  .::File Details::.
  End of file dashboard.php
  Project Name: wegottickets
  Created By : Jaswant Singh
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  File Location: ./application/views/admin/dashboard.php
  Created At : 15 Nov, 2013  1:43:37 PM
 */
?>
