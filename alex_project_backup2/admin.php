<?php
//session_start();
$msg="";
include("includes/config.php");
include_once("includes/database.php");
$user=$_SESSION['user'];
$msg='';
if(isset($_SESSION ["error_msg"])){
$msg=$_SESSION["error_msg"];
unset($_SESSION["error_msg"]);
}
if(!isset($_SESSION['user']))
{
    header("Location: adminlogin.php");
}
?>
<html>
    <head>
	<link href="css/login.css" rel="stylesheet">
	
    </head>
    <body>
        <center>
          <div class="login">
	    
	   <div ><tr><td ><font style="color:#3399FF;">WELCOME <?php echo $user; ?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="logout.php">logout</a></td></tr></div>
    <div style="margin-bottom: 20px;">
       <form action="exelimporttomysql.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><font style="color: red;"><?php echo $msg;?></font></td>
            </tr>
	    <tr><td><a href="#" onClick="javascript:window.open('passchange.php','','location=0,status=0,scrollbars=0,width=400,height=390');">change library code</a></td></tr>
            <tr>
                <td> <input  type="file" name="file" id="file" /></td>
		
            </tr>
            <tr>
                <td> <input type="submit" value="Load data file into database" name="button1"/></td>
            </tr>
            
        </table>
       </form>
       </div>

       </div>
        </center>
    </body>
</html>
