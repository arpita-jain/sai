
<?php
include("includes/config.php");
?>


<html>
    <head>
         <link href="css/login.css" rel="stylesheet">
    </head>
    <body>
         <?php
        $msg="";
        if(isset($_POST['login']))
{
    $pass=$_POST['pass'];
    $username=$_POST['user_name'];
    if($username==USERNAME)
    {
    if($pass==PASSWORD)
    {
        
        header("location:admin.php");
    }
    else
    {
        $msg="incorrect password";
    }
    }
    else
    {
        $msg="incorrect username";
    }
    $_SESSION['user']=$username;
}
        ?>
        <form method="post">
<div class="login">
    <div style="margin-bottom: 20px;">
    <div style="color:green; margin-left: 40px; margin-top: 10px;height:20px;"><?php echo $msg ?></div>
    <input type="text"  name="user_name" placeholder="Username" id="username" required>  
  <input type="password" name="pass" placeholder="password" id="password" required>  
 
  <input type="submit" value="Sign In" name="login">
    </div>
</div>
<div class="shadow"></div>
</form>
</body>
</html>