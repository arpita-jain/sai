<?php
//session_start();
include("includes/config.php");
include("includes/database.php");
//$l_code=$_SESSION['l_code'];
$obj=new database();
$sql="select * from Library_code";
$l_query=mysql_query($sql) or die(mysql_error());
$l_code=mysql_fetch_array($l_query) or die(mysql_error());
$librarycode=$l_code['l_code'];

?>
<html>
    <head>
        <link href="css/login.css" rel="stylesheet">
    </head>
    <body>
        <?php
        $msg="";
        if(isset($_POST['submit']))
{
    $c_lcode=$_POST['c_lcode'];
    $n_lcode=$_POST['n_lcode'];
    $r_lcode=$_POST['r_lcode'];
    if($c_lcode==$librarycode)
     {
     if($n_lcode==$r_lcode)
      {
       $sql="update Library_code set l_code='".$n_lcode."'" ;
        $l_query=mysql_query($sql) or die(mysql_error());
        $msg="library code has been changed";
      }
      else
      {
        $msg="password mismatch";
      }
    }
    else
    {
       $msg="incorrect password"; 
    }
}
        ?>
        <center>
            <div class="login">
                <div style="margin-bottom: 20px; margin-top: 20px;">
            <form method="post">
                <div style="color: green;"><?php echo $msg; ?></div>
                <input type="password" name="c_lcode" placeholder="Current Library Code" required/>
                
                    <input type="password" placeholder="New Library Code" name="n_lcode" required/>
              <input type="password" placeholder="Re enter Library Code" name="r_lcode" required/>
              
                    <input type="submit" name="submit" value="change library code"/>
               
            </form>
            </div>
            </div>
            </center>
    </body>
</html>