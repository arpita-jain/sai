<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Full Page Template
*/
?>
<!-- Getting Header-->
 </div>
<?php get_header(); 
global $current_user;
 if(($current_user->usertype==1)or($current_user->usertype==4)){
		$redirect_to=site_url().'?page_id=487';
           
	  }else{
	       $redirect_to=site_url().'?page_id=442';
	  }
	 // echo "redirect=".$redirect_to;
?>
<div class="wlcm-guest-btn-area">
      <div class="wlcm-guest-btn-my-account"></div>
	     <?php if($current_user->data->user_login){
	      ?>
	     <div class="wlcm-guest-btn-my-account"><a href="<?php echo $redirect_to; ?>">My Account</a></div>
	     <?php } ?>
	     <div class="wlcm-guest-btn-bg">
		   <h3>Welcome <?php if($current_user->data->user_login){ echo $current_user->data->user_login; } else { echo "Guest";}?>!</h3>
		 </div>
	     <div class="wlcm-guest-btn"><?php if($current_user->data->user_login){ ?><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a><?php } else { ?><a href="<?php echo site_url(); ?>?page_id=18">Login</a><?php }?></div>
	   </div>
     
</div></div>
<div class="container content_bg-new">
      <div class="row">
	    <div class="twelvecol">
	       <!--<div class="wlcm-guest-btn-area">
	     <?php //if($current_user->data->user_login){
	      ?>
	     <div class="wlcm-guest-btn-my-account"><a href="<?php //echo site_url(); ?>?page_id=442">My Account</a></div>
	     <?php// } ?>
	     <div class="wlcm-guest-btn-bg">
		   <h3>Welcome <?php //if($current_user->data->user_login){ echo $current_user->data->user_login; } else { echo "Guest";}?>!</h3>
		 </div>
	     <div class="wlcm-guest-btn"><?php //if($current_user->data->user_login){ ?><a href="<?php //echo wp_logout_url( home_url() ); ?>">Logout</a><?php //} else { ?><a href="<?php //echo site_url(); ?>?page_id=18">Login</a><?php //}?></div>
	   </div>-->
	       <div class="build_smal_ban_bg"> <img src="<?php bloginfo('template_url')?>/images/small-banner.png" /> </div>
	     </div>
  </div>
     <div class="row" style="padding-bottom:15px;">
    <div class="twelvecol">
      <div class="term-condition-area">
                <!-- Page Content Start form here  -->
		   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		    
		    <div class="" style="position: relative;">
				<?php
			if(!is_page('1465'))
			{ ?><h3><?php the_title();?>
		    </h3>
			    <?php  the_content(); 
		      if( get_the_ID()==1308){ 
		Show_News_content(); }
			}
			else{
			   ?>
		    </div><!--class="row"--><?php
		     $user=$current_user->data->user_login;
			    $retrieve_data1 = $wpdb->get_results("SELECT * from wp_users where `user_login`='$user'");
	    $id1=$retrieve_data1[0]->ID;
	    $email=$retrieve_data1[0]->user_email; 
	    $all_meta_for_user = get_user_meta( $id1 );
	    // print_r($all_meta_for_user['trades_name'][0]);
	  $user_type=$all_meta_for_user['usertype'][0];?>
			
		  <div class="builder">
		 <div style="margin:0px 10px;"><span><a href="<?php echo site_url();?>?page_id=1465" class="active_arrow">Home</a></span></div>
		   <div style="margin:0px 10px;">
			 <span>
			   <a href="<?php if($user_type ==2){ echo site_url().'?page_id=15'; }else {  echo site_url().'?page_id=1044'; }?>">Jobs</a>
			 </span>
		  </div>
               <?php if($user_type!=2){?> <div style="margin:0px 10px;"> <span><a href="<?php if(($user_type ==4)|| ($user_type ==3)){ echo site_url().'?page_id=1364'; }else {  echo site_url().'?page_id=354'; }?>">Post A Job</a></span></div><?php } ?>
              <div style="margin:0px 10px;"><span><a href="<?php echo site_url();?>?page_id=437&page=rwpm_frontend_inbox">Messages</a></span></div>
              <div style="margin:0px 10px;"><span> <a href="<?php echo $redirect_to; ?>">My Account</a></span>
	      </div>
	      <!--<span> <a href="<?php/* if($user_type==1 || $user_type==4){echo site_url().'?page_id=487&usertype='.$user_type; }elseif($user_type==2 || $user_type==3){echo site_url().'?page_id=442&usertype='.$user_type; }*/?>">My Account</a></span>-->
	     
               </div>
			  <?php
		   $kcount=0;
		  $popular = new WP_Query('orderby=date&cat=12'); ?>
		  <?php while ($popular->have_posts()) : $popular->the_post(); ?>
		  <?php
		  $kcount=$kcount+1;
		  ?>
<script>
	       $(document).ready(function(){
			      document.getElementById('kpost_count').value=<?php echo $kcount?>;
			      });
</script>

        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                //alert('dsf');
		var kpost_count= document.getElementById('kpost_count').value
                 $("#id1").show();
		
		 pre=1;
		
		  
		 // alert(pre);
		// setInterval("slide_next("+kpost_count+")",15000);
                 $("#pre").attr("onclick","pre(1)");
                 $("#next").attr("onclick","next(1)");
		 var pre=1;
		 $("#next").attr("onclick","next("+pre+","+kpost_count+")");
                });
        </script>
        <script>
            function display(i)
            {
                //alert (i);
                $(".class").hide('slow');
                $("#id"+i).show('slow');
                $('.testcls').removeClass('k_current');
                $("#id_click"+i).addClass('k_current');
                $("#pre").attr("onclick","pre("+i+")");
                $("#next").attr("onclick","next("+i+")");
                 //$("#next").attr("pre_val",i);
            }
            function pre(c)
            {var kpost_count= document.getElementById('kpost_count').value
                //alert(c);
                if(c==1)
                {
                   var pre= kpost_count;
                }
                else
                {
                   var pre=c-1; 
                }
                var kpost_count= document.getElementById('kpost_count').value
                $(".class").hide('slow');
                $("#id"+pre).show('slow');
                $("#pre").attr("onclick","pre("+pre+")");
                $("#next").attr("onclick","next("+pre+","+kpost_count+")");
            }
            function next(c, count)
            {
                //alert(c);
                if(c==count)
                {
                   var pre= 1;
                }
                else
                {
                   var pre=c+1; 
                }
                var kpost_count= document.getElementById('kpost_count').value
		//alert(kpost_count);
                $(".class").hide('slow');
                $("#id"+pre).show('slow');
                $("#pre").attr("onclick","pre("+pre+")");
                $("#next").attr("onclick","next("+pre+","+kpost_count+")");
            }
	   /*  function slide_next(count)
            {  var className = $('.class').attr('num');
	     alert(className);
                counter=parseInt(className)+1;
		 // alert(counter);
		//alert(counter);
               /*if(pre==count)
                {
                   var pre= 1;
                }
                else
                { 
                   var pre=pre+1; 
                }
                var kpost_count= document.getElementById('kpost_count').value;
		//alert(kpost_count);
                $(".class").hide('slow');
	    //alert(pre);
                $("#id"+counter).show('slow');
		
                $("#pre").attr("onclick","pre("+pre+")");
                $("#next").attr("onclick","next("+pre+","+kpost_count+")");
            }*/
        </script>


<?php endwhile;
//echo 'title='.$iframearr;
?>
    <input type="hidden" value="" id="kpost_count"/> <div>
        <div id="pre" style="float: left; width: 30px; height:30px; position:absolute; top:120%; left: 125px; cursor: pointer; color: #fff; background-image: url('http://constructionmates.co.uk/wp-content/themes/constructionmates//images/prv.png')"; next_val="" onclick=""></div>
        <div style=" width: 1000px; ">
            <?php
	    $i=1;
            while ($popular->have_posts()) : $popular->the_post();
            {
                ?>
                <div class="class<?php //echo $i;?>" num="<?php echo $i;?>" id="id<?php echo $i;?>" style="display: none;"><?php the_content();?></div>
                <?php
		$i=$i+1;
            }
	    endwhile;
	    $i=1;
	    ?>
	    <div class="hh" style="padding: 12px 2px; display: block; width:100%; height: 50px;">
	    <?php
            while ($popular->have_posts()) : $popular->the_post();
            {
                ?>
                <div class="testcls<?php //echo $i;?>" id="id_click<?php echo $i;?>" style="display: block;   border: 5px solid #2C96DA; width: 144px;background: #2c96d4; color: #fff; word-wrap:break-word; word-break:break-all; margin:6px; text-align: center; float: left; cursor: pointer; box-shadow:0px 0px 5px #999;" onclick="display(<?php echo $i;?>)">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
                <?php
		$i=$i+1;
            }
	    endwhile;
            ?>
	    </div><!--hh ends here-->
        </div>
        <div id="next" style="float: left; width: 30px; height:30px; position: absolute; right: 125px; top:120%; cursor: pointer; color: #fff; background-image: url('http://constructionmates.co.uk/wp-content/themes/constructionmates/images/next.png')" pre_val="" onclick=""></div>
    </div>	
			      <?php
			      //echo 'slider';
			      ?>
			      <div><!--class="row"-->
			      <?php
			}
			?>
		    </div>
		   <?php endwhile; // end of the loop. ?>
      </div>
      </div>
  </div>
  
 </div><style>
 .k_current{
	/*background: #2F292B !important;*/
 }
 </style>
<!--Getting Footer-->
<?php get_footer(); ?>
