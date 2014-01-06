<?php
if ($this->session->userdata('admin_id') == "") {
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Dashboard - WeGotTickets</title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>/assets/admin/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/admin/css/DT_bootstrap.css" rel="stylesheet">
        <!-- Add custom CSS here -->
        <link href="<?php echo base_url(); ?>/assets/admin/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/scripts/common.js"></script>
        <script>
            var base_path = '<?php echo base_url(); ?>';
            var site_path = '<?php echo site_url(); ?>';
        </script>
    </head>
    <body>
        <?php
        /*
          .::File Details::.
          End of file header.php
          Created By : Jaswant Singh
          Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
          Location: ./application/Controllers/header.php
          Created At : 15 Nov, 2013  2:41:10 PM
         */
        ?>
