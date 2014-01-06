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
    </head>

    <body class="login-main">
        <!-- Script for getting pins -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script language="javascript" type="text/javascript">
            var site_path = '<?php echo site_url(); ?>';
        </script>
        <!-- End of pin script -->        
        <style>
            #clr{
                padding: 10px !important;
            }
        </style>
        <div id="main" class="login-bg">
            <div class="container">
                <div class="row">
                    <div class="login-logo"><a href="#"><img src="<?php echo base_url(); ?>/assets/site/images/logo.png" alt="Logo"></a></div>
                    <div class="login-contant">
                        <div class="UserDiv">
                            <div class="UserWrapp">     
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
                                ?><div id="alertMessage"></div>
                                <form action="" name="loginform" id="loginform" method="post" onSubmit="return valLogin();">
                                    <div class="UserText"> <span>User</span>
                                        <input type="text" name="username" id="username" >
                                        <input type="hidden" name="password" id="password" value="">
                                    </div>
                                    <div class="UserText"><span>Pass</span>
                                          <input type="password" name="pass" id="pass"value="" readonly>
                                    </div>
                                    <div class="User-number" >
                                        <div class="number_align" style="margin-left: -26px;">
                                            <ul>
                                                <li><a href="javascript:void(0);" id="one" onclick="enterPassKey(1);" class="pin_required" name="one">1</a> </li>
                                                <li><a href="javascript:void(0);" id="two" onclick="enterPassKey(2);" class="pin_required">2</a> </li>
                                                <li><a href="javascript:void(0);" id="three" onclick="enterPassKey(3);" class="pin_required">3</a> </li>
                                                <li><a href="javascript:void(0);" id="four" onclick="enterPassKey(4);" class="pin_required">4</a> </li>
                                                <li><a href="javascript:void(0);" id="five" onclick="enterPassKey(5);" class="pin_required">5</a> </li>
                                                <li><a href="javascript:void(0);" id="six" onclick="enterPassKey(6);" class="pin_required">6</a> </li>
                                                <li><a href="javascript:void(0);" id="seven" onclick="enterPassKey(7);" class="pin_required">7</a> </li>
                                                <li><a href="javascript:void(0);" id="eight" onclick="enterPassKey(8);" class="pin_required">8</a> </li>
                                                <li><a href="javascript:void(0);" id="nine" onclick="enterPassKey(9);" class="pin_required">9</a> </li>
                                                <li><a href="javascript:void(0);" id="hash" onclick="enterPassKey('#');" class="pin_required">#</a> </li>                                            
                                                <li><a href="javascript:void(0);" id="zero" onclick="enterPassKey(0);" class="pin_required">0</a> </li>
                                                <li><a href="javascript:void(0);" id="clr" onclick="clearPassKey();">CLR</a> </li>
                                            </ul>
                                        </div>
                                        <div class="logoutBtn logoutBtnL"><a href="javascript:void(0);" id="login_btn" ><i class="fa fa-lock"></i> Login</a><span style="cursor: pointer;"  onClick="$('#forgotPassword').modal('show');" class="Forgot-Pin">Forgot Pin?</span>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->            
            <div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
                        </div>
                        <div class="modal-body">
                            <h3 class="form-signin-heading">Enter your email address</h3>
                            <input type="text" name="email" id="email"  class="form-control" placeholder="Email address" ><br>
                        </div>
                        <div id="forgot-msg"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="return valForgot();">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <!-- Bootstrap core JavaScript -->
            <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootbox.js"></script>
            <script src="<?php echo base_url(); ?>/assets/site/js/login.js"></script>
            <script src="<?php echo base_url(); ?>/assets/scripts/common.js"></script>
            <script src="<?php echo base_url(); ?>/assets/scripts/admin-profile.js"></script>
            <?php
            include_once("footer.php");
            ?>