<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html"><i class="icon-tags"></i> WeGotTickets</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">           
            <?php if ($this->session->userdata("admin_type") == 0) { ?>
                <li id="dashboard_menu"><a href="<?php echo site_url(); ?>admin/"><i class="icon-dashboard"></i> Dashboard</a></li>
                <li id="admins_menu"><a  href="<?php echo site_url(); ?>admin/administrators"><i class="icon-group"></i> Administrators</a></li>
                <li id="masters_menu"><a href="<?php echo site_url(); ?>admin/masters"><i class="icon-group"></i> Master users</a></li>
                <li id="supervisors_menu"><a href="<?php echo site_url(); ?>admin/supervisors"><i class="icon-group"></i> Supervisor users</a></li>
                <li id="group_menu"><a href="<?php echo site_url(); ?>admin/kioskgroups"><i class="icon-group"></i> Kiosk Groups</a></li>
                <li id="users_menu"><a href="<?php echo site_url(); ?>admin/users"><i class="icon-group"></i> Users</a></li>
                <li id="event_menu"><a href="<?php echo site_url(); ?>admin/events"><i class="icon-group"></i> Events</a></li>
                <li id="venue_menu"><a href="<?php echo site_url(); ?>admin/venues"><i class="icon-group"></i> Venues</a></li>                              
                <li ><a href="javascript:void(0);" onclick="refreshData();"><i class="icon-refresh"></i> Synchronize data</a></li> 
                <li id="kiosks_menu"><a href="<?php echo site_url(); ?>admin/kiosks"><i class="icon-group"></i> Kiosks</a></li>
            <?php } ?>

            <?php if ($this->session->userdata("admin_type") == 1) { ?>
                <li id="dashboard_menu"><a href="<?php echo site_url(); ?>admin/"><i class="icon-dashboard"></i> Dashboard</a></li>
                <li id="masters_menu"><a href="<?php echo site_url(); ?>admin/masters"><i class="icon-group"></i> Master users</a></li>
                <li id="supervisors_menu"><a href="<?php echo site_url(); ?>admin/supervisors"><i class="icon-group"></i> Supervisor users</a></li>
                <li id="group_menu"><a href="<?php echo site_url(); ?>admin/kioskgroups"><i class="icon-group"></i> Kiosk Groups</a></li>
                <li id="users_menu"><a href="<?php echo site_url(); ?>admin/users"><i class="icon-group"></i> Users</a></li>
                <li id="event_menu"><a href="<?php echo site_url(); ?>admin/events"><i class="icon-group"></i> Events</a></li>
                <li id="venue_menu"><a href="<?php echo site_url(); ?>admin/venues"><i class="icon-group"></i> Venues</a></li>                              
                <li ><a href="javascript:void(0);" onclick="refreshData();"><i class="icon-refresh"></i> Synchronize data</a></li> 
                <li id="kiosks_menu"><a href="<?php echo site_url(); ?>admin/kiosks"><i class="icon-group"></i> Kiosks</a></li>
            <?php } ?>

            <?php if ($this->session->userdata("admin_type") == 2) { ?>
                <li id="dashboard_menu"><a href="<?php echo site_url(); ?>admin/"><i class="icon-dashboard"></i> Dashboard</a></li>
                <li id="group_menu"><a href="<?php echo site_url(); ?>admin/kioskgroups"><i class="icon-group"></i> Kiosk Groups</a></li>
                <li id="users_menu"><a href="<?php echo site_url(); ?>admin/users"><i class="icon-group"></i> Users</a></li>
                <li id="event_menu"><a href="<?php echo site_url(); ?>admin/events"><i class="icon-group"></i> Events</a></li>
                <li id="venue_menu"><a href="<?php echo site_url(); ?>admin/venues"><i class="icon-group"></i> Venues</a></li>                              
                <li ><a href="javascript:void(0);" onclick="refreshData();"><i class="icon-refresh"></i> Synchronize data</a></li> 
                <li id="kiosks_menu"><a href="<?php echo site_url(); ?>admin/kiosks"><i class="icon-group"></i> Kiosks</a></li>
            <?php } ?>

            <?php if ($this->session->userdata("admin_type") == 3) { ?>
                <li id="dashboard_menu"><a href="<?php echo site_url(); ?>admin/"><i class="icon-dashboard"></i> Dashboard</a></li>
                <li id="users_menu"><a href="<?php echo site_url(); ?>admin/users"><i class="icon-group"></i> Users</a></li>              
                <li id="event_menu"><a href="<?php echo site_url(); ?>admin/events"><i class="icon-group"></i> Events</a></li>
                <li id="venue_menu"><a href="<?php echo site_url(); ?>admin/venues"><i class="icon-group"></i> Venues</a></li>
                <li id="kiosks_menu"><a href="<?php echo site_url(); ?>admin/kiosks"><i class="icon-group"></i> Kiosks</a></li>           
            <?php } ?>
               
            <li id="ticket_menu"><a href="<?php echo site_url(); ?>admin/tickets"><i class="icon-ticket"></i> Tickets</a></li>
            <li id="customer_menu"><a href="<?php echo site_url(); ?>admin/customers"><i class="icon-user"></i> Customers</a></li>           
        </ul>

        <ul class="nav navbar-nav navbar-right navbar-user">

            <a class="navbar-brand" href="<?php echo site_url(); ?>admin/basket"><i class="icon-shopping-cart"></i>&nbsp;<?php
                echo $this->session->userdata('totalitems');
                ?></a>         
            <li class="dropdown user-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $this->session->userdata('admin_firstname') . "&nbsp" . $this->session->userdata('admin_lastname'); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo site_url(); ?>admin/adminprofile"><i class="icon-user"></i> Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo site_url(); ?>admin/logout"><i class="icon-power-off"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->  
</nav>

<?php
/*
  .::File Details::.
  End of file sidebar.php
  Project Name: wegottickets
  Created By : Jaswant Singh
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  File Location: ./application/views/sidebar.php
  Created At : 15 Nov, 2013  2:46:59 PM
 */
?>