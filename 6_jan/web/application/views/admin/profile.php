<div id="wrapper">
    <!-- Sidebar -->
    <?php
    $this->load->view('admin/sidebar');
    ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1>Profile<small>admin profile</small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li class="active"><i class="icon-group"></i> Admin-profile</li>
                </ol>
            </div>
        </div>


        <!--row----admin-profiel -->
        <div class="modal-body">
            
            <form role="form" method="post" action="<?php echo site_url(); ?>admin_ajax/editprofile" name="admin_profile" id="admin_profile">
                <div class="form-group">                    
                    <label for="firstname">Fist name</label>
                    <input type="text" class="form-control required" id="firstname" name="firstname"  placeholder="First name" value="<?php echo $profile[0]['first_name']; ?>" >
                   
                </div>
                <div class="form-group">
                    <label for="lastname">Last name</label> 
                    <input type="text" class="form-control required" name="lastname" id="upd_lastname" value="<?php echo $profile[0]['last_name']; ?>" placeholder="Last name">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" onkeypress="return isNumberKey(event);" maxlength="10"  class="form-control required" id="mobile" name="mobile" value="<?php echo $profile[0]['mobile']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text"  class="form-control required" id="email" name="email" value="<?php echo $profile[0]['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text"  class="form-control required" id="address" name="address" value="<?php echo $profile[0]['address']; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password"  class="form-control password"  onkeypress="return isNumberKey(event);" id="password" name="password" value="" placeholder="*******">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm-Password</label>
                    <input type="password"  class="form-control password" onkeypress="return isNumberKey(event);" id="confirm_password" name="password" value="" placeholder="*******">
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-primary" onclick="editprofile('<?php echo $this->session->userdata("admin_id"); ?>');">Save changes</button>
                    </div>
            </form>
        </div>
        <!-- end admin-profile page  row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->



<!-- Modal -->
<!---  modal -->

<!-- Modal -->
<script src="<?php echo base_url(); ?>assets/scripts/common.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/admin-profile.js"></script>

<script>
    $(document).ready(function() {
        $("#dashboard_menu").addClass("active");
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
