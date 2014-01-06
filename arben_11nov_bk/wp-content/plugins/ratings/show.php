<?php
function showmyData()
{
    global $wpdb;
    $user = wp_get_current_user();
    $userid = $user->ID;
    $tbl_name=$wpdb->prefix.'rating';
    $result = $wpdb->get_results( "SELECT * FROM ".$tbl_name. " where aboutuser = '".$userid."'");
   return $result;
}
function showmyDataId()
{
    global $wpdb;
    $user = wp_get_current_user();
    $userid = $_REQUEST['id'];
    $tbl_name=$wpdb->prefix.'rating';
    $query = "SELECT * FROM ".$tbl_name. " where aboutuser = '".$userid."'";
    $result = $wpdb->get_results( $query);
   return $result;
}
function getShow()
{ ?><link rel="stylesheet" type="text/css" href="<?php echo  plugins_url().'/ratings/css/popupbox.css';?>">
  <?php  $data =showmyData();
    //echo "<pre>";
    //print_r($data);
    ?>
    
   
    <?php
    for($i=0;$i<count($data);$i++)
    {
        ?>
        <div class="show_rating">
            <?php
        $user_info = get_userdata($data[$i]->fromuser);
        $aboutuserinfo = get_userdata($data[$i]->aboutuser);
       ?>
     <p><?php echo $data[$i]->comment; ?></p>
      <?php for($k=1;$k<=$data[$i]->rating;$k++){?>
        <img src="wp-content/plugins/ratings/images/ratingstar.png" class="star_img"/>
        <?php } ?>
      
     <span> By: <?php echo $user_info->user_login; ?></span>
        </div>
       <?php
    }
    
    ?>
  
    <?php
}
function getShow2()
{ ?><link rel="stylesheet" type="text/css" href="<?php echo  plugins_url().'/ratings/css/popupbox.css';?>">
  <?php  $data =showmyDataId();
    //echo "<pre>";
    //print_r($data);
    ?>
    
   
    <?php
    for($i=0;$i<count($data);$i++)
    {
        ?>
        <div class="show_rating">
            <?php
        $user_info = get_userdata($data[$i]->fromuser);
        $aboutuserinfo = get_userdata($data[$i]->aboutuser); 
       ?>
     <p><?php echo stripslashes($data[$i]->comment); ?></p>
      <?php for($k=1;$k<=$data[$i]->rating;$k++){?>
        <img src="wp-content/plugins/ratings/images/ratingstar.png" class="star_img"/>
        <?php } ?>
      
     <span> By: <?php echo $user_info->user_login; ?></span>
        </div>
       <?php
    }
    
    ?>
  
    <?php
}