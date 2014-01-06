<?php
/*
 Template Name: Job Resume
 *
 */

get_header();

   if(isset($_POST['editor']))
   {
      $message = $_POST['editor']; //echo $message; die;
                           $user_type = mbt_get_user_type();
                           global $wpdb;
				if ( $user_type == 'studio' ) :
                              $user_id = get_current_user_id( );
                              $current_user = wp_get_current_user();
                              $sql_studio = "select user_id from studio where user_id='".$user_id."'"; 
			      $results_studio = $wpdb->get_row( $sql_studio);
                                  if(empty($results_studio))
                                  {
                                    //echo "insert"; die;
                                    $wpdb->insert(studio, array('user_id' => $user_id, 'studio_name' => $current_user->user_login, 'studio_message' => $message, 'date' => date("Y-m-d H:i:s") ));
                                    
                                  }
                                  else
                                  {
                                    //echo "update"; die;
                                    $wpdb->update(studio, array('studio_message' => $message, 'date' => date("Y-m-d H:i:s")), array('user_id' => $user_id) );	    
                                  }
                                
                                //echo "studio";
                                
                                ?>
				     
				<?php elseif ( $user_type == 'artist' ) :
                              $user_id = get_current_user_id( );
                               $current_user = wp_get_current_user();
                               $sql_artist = "select user_id from artist where user_id='".$user_id."'";  
                              $results_artist = $wpdb->get_row( $sql_artist); //echo "<pre>"; print_r($results); die;
                                 
                                    if(empty($results_artist))
                                  {
                                    //echo "insert";
                                     $wpdb->insert(artist, array('user_id' => $user_id, 'artist_name' => $current_user->user_login, 'artist_message' => $message, 'date' => date("Y-m-d H:i:s") ));
                                  }
                                  else
                                  {
                                    //echo "update";
                                    $wpdb->update(artist, array('artist_message' => $message, 'date' => date("Y-m-d H:i:s") ), array('user_id' => $user_id) );	    
                                  }
                                //echo "artist";
                                ?>
				     
				<?php endif;
   }

//$content='comments here';
?>
<br>
<div id="job_form" style="float:left;">
<form action="" method="post" >   

<div id="job_textarea">
<?php   $user_type = mbt_get_user_type();
      if ( $user_type == 'studio' ) : ?> 
   <h6 class="sidebar-title">POST JOBS</h6>
<?php  elseif ( $user_type == 'artist' ) : ?>
 <h6 class="sidebar-title">SEARCH JOBS</h6>
 <?php endif; ?>  
   
<textarea id="editor" name="editor" cols=50 rows=10>
    
<?php

//$editor_id='editor';
//
//wp_editor($content,$editor_id);

?> 
    
</textarea>
</div>
<input type="submit" name="submit" value="submit"/>
</form>
</div>
<div id="job_widget" style="float: right; width: 400px;">
<?php
dynamic_sidebar('Sidebar - Blog ');
?>
</div>
<?php
get_footer() ;
?>


