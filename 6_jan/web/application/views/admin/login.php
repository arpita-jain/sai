<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Administrator Signin - WeGotTickets </title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>/assets/admin/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url(); ?>/assets/admin/css/signin.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script>
            var site_path='<?php echo site_url(); ?>';   
        </script>
    </head>
    <body>

        <div class="container">
            <form class="form-signin well" id="login-form" action="" method="post">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input type="text" name="username" id="username"  value="<?php
if (isset($_COOKIE['username'])) {
    echo $_COOKIE['username'];
}
?>" class="form-control" placeholder="Email address" ><br>
                <input type="password" name="password" id="password" value="<?php
                       if (isset($_COOKIE['password'])) {
                           echo $_COOKIE['password'];
                       }
?>" class="form-control" placeholder="Password">
                       <?php
                       if ($this->session->userdata('loginerror')) {
                           ?>                        
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Input Warnings :</strong><br>
                        <?php echo $this->session->userdata('loginerror'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('loginerror');
                }
                if (validation_errors() != "") {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Input Warnings :</strong><br>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php
                }
                ?>
                <label class="checkbox">
                    <input type="checkbox" id="rememberme" name="rememberme" value="remember-me"> Remember me
                </label>
                <label >
                    <a href="javascript:void(0);" onclick="forgotpassword();" >Forgot password ?</a>
                </label>
                <button class="btn btn-lg btn-primary btn-block" onclick="return valLogin();" type="submit">Sign in</button>
            </form>
            <form class="form-signin well" id="forgot-form" style="display:none;" action="" method="post">
                <h3 class="form-signin-heading">Enter your email address</h3>
                <input type="text" name="email" id="email"  class="form-control" placeholder="Email address" ><br>
                <div id="forgot-msg"></div>
                <label >
                    <a href="javascript:void(0);" onclick="login();" >Login existing user ?</a>
                </label><br>
                <button class="btn btn-lg btn-primary btn-block" onclick="return valForgot();" name="forgotpassword" type="button">Send password</button>
            </form>
        </div> <!-- /container -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url(); ?>/assets/admin/js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>/assets/admin/js/bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>/assets/scripts/common.js"></script>
        <script src="<?php echo base_url(); ?>/assets/scripts/login.js"></script>

    </body>
</html>


<?php
/*
  .::File Details::.
  End of file login.php
  Project Name: wegottickets
  Created By : Jaswant Singh
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  File Location: ./application/views/admin/login.php
  Created At : 15 Nov, 2013  1:43:46 PM
 */
?>
