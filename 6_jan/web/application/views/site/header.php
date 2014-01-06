<!DOCTYPE html>
<html>
<head>
<title>WeGot Tickets</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="<?php echo base_url(); ?>assets/site/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/css/font-awesome.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/css/fonts.css">
<!-- EOT-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<script>
            var base_path = '<?php echo base_url(); ?>';
            var site_path = '<?php echo site_url(); ?>';
        </script>
</head>
<body>
<div id="main">
  <div id="sidebar" class="sidebar-fixed">
    <div class="navbar navbar-default">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand" href="<?php echo site_url();?>kiosk"><img src="<?php echo base_url(); ?>/assets/site/images/logo.png" alt="Logo"></a> </div>
      <div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
          <li class="active"><a class="Filters nav-head-bg" href="<?php echo site_url(); ?>kiosk/removeFiltersByEvent"><i class="fa fa-filter"></i> Filters
            <div class="clearfix"></div>
            </a></li>
          <li><a href="<?php echo site_url();?>kiosk/event_dates" class="datefilter"><i class="fa fa-calendar"></i>Dates<span><?php if($this->session->userdata('eventdate')!=""){echo count($this->session->userdata('eventdate'))."&nbsp;&nbsp;Dates";}else{echo "All Dates";} ?></span>
            <div class="clearfix"></div>
            </a></li>         
          <li><a href="<?php echo site_url();?>kiosk/venues"><i class="fa fa-map-marker"></i> Venues <span><?php if($this->session->userdata('venueId')!=""){echo "Venues&nbsp;". count($this->session->userdata('venueId'))."&nbsp;of&nbsp;".$this->session->userdata('venue_count');}else{echo "All Venues &nbsp;".$this->session->userdata('venue_count') ;} ?></span>
            <div class="clearfix"></div>
            </a></li>
          <li><a href="<?php echo site_url();?>kiosk/events"><i class="fa fa-bullhorn"></i> Events <span><?php if($this->session->userdata('eventId')!=""){echo "Events&nbsp;". count($this->session->userdata('eventId'))."&nbsp;of&nbsp;".$this->session->userdata('event_count');}else{echo "All Events &nbsp;".$this->session->userdata('event_count') ;} ?>  </span>
            <div class="clearfix"></div>
            </a></li>
          <li><a class="Filters nav-head-bg" href="#"><i class="fa fa-gear"></i> Operations
            <div class="clearfix"></div>
            </a></li>
          <li><a href="<?php echo site_url();?>kiosk/ticket"><i class="fa fa-ticket"></i>Tickets <span>All Tickets</span>
            <div class="clearfix"></div>
            </a></li>
          <li><a href="<?php echo site_url();?>kiosk/basket"><i class="fa fa-archive"></i> Basket <span><?php
            if ($this->session->userdata('ticket_id') != "") {
                echo count($this->session->userdata('ticket_id'));
            } else {
                echo "0";
            }
            ?> items</span>
            <div class="clearfix"></div>
            </a></li>
          <li><a href="<?php echo site_url();?>kiosk/customerOrder"><i class="fa fa-users"></i> Customer <span>Our Customers</span>
            <div class="clearfix"></div>
            </a></li>
          <li><a href="<?php echo site_url();?>kiosk/Admin"><i class="fa fa-user"></i> Admin <span>Our Admin</span>
            <div class="clearfix"></div>
            </a></li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
  </div>
  <!--sidebar-->
  <div id="content">
    <div class="search">
         <div class="logoutBtn col-md-3 pull-right"><a href="<?php echo site_url(); ?>kiosk/logout"><i class="fa fa-power-off"></i> Logout</a></div>
