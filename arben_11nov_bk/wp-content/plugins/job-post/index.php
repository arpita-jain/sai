<?php
/* 
Theme Name: Constructionmates
Version: 0.9b
Author: Cis Team
Template Name: Home Page
*/
?>
<!-- Getting Header-->
<?php get_header(); ?>
<script>
  var i;
var divs = document.getElementsByTagName('span');
for(i=0;i<divs.length;i++) {
  if(divs[i].className == 'myclass') {
    divs[i].innerHTML = divs[i].innerHTML.substring(0,15);
  }
}
</script>
<div class="back_bg1">
  <div class="Top_banner">
<?php
	 
       if(function_exists( 'wp_bannerize' ))
       wp_bannerize( 'group=header_group&random=1&limit=1' );
	
?>
      <div class="side_image"></div>
      </div>
<div class="row  banner_content">
    <div class="twelvecol">
          <div class="slogan_txt">
        <div class="slogan_text"> Premium Services by professional<br/>
              <span>Builders and Traders</span> </div>
      </div>
          <div class="search_field_main">
        <div class="what_field"> <span>what</span><br>
              <div class="input_bg"> <span>
                <input type="text" name="txtEmail" value="job title, keywords or company name">
                </span> </div>
            </div>
        <div class="where_field"> <span>where</span><br>
              <div class="input_bg"> <span>
                <input type="text" name="txtEmail" value="city or postcode">
                </span>
            <p><a href="#">Advanced search</a></p>
          </div>
            </div>
	<div class="bteNew">
        <div class="search_button"> <span>
          <input type="button" name="txtEmail" value="Search">
          </span> </div>
        <div class="join_now" id="index"> <span>
          <a href="<?php echo site_url();?>?page_id=118"><input type="button" name="txtEmail" value="Join Now"></a>
          </span>
              <p><a href="<?php echo site_url();?>?page_id=18">Sign-in to your account</a></p>
            </div>
          </div>
        <!--<div class="join_now_main">
                	<div class="join_now">
                		Join Now
                	</div>
                    	<p>Sign-in to your account</p>
                </div>--> 
      </div>
      <div class="category_box_main">
       <div class="cate_box last">
              <div class="cate_box_bg"><p></p>
               <?php if ( is_active_sidebar( 'Home Widget Area' ) ) : ?><?php  dynamic_sidebar( 'Home Widget Area' ); ?><?php endif; ?>
            <div class="read_more_div">
                  <div class="read_more_button"> <a href="<?php echo site_url(); ?>?page_id=52">Read more</a> </div>
                </div>
          </div>
            </div>
       
       <div class="cate_box">
              <div class="cate_box_bg"><p></p>
                      <?php if ( is_active_sidebar( 'Home1 Widget Area' ) ) : ?><?php  dynamic_sidebar( 'Home1 Widget Area' ); ?><?php endif; ?>
               <p><?php // echo $values[0]; ?></p>
             
               <?php // wp_reset_query(); ?>
            <div class="read_more_div">
                  <div class="read_more_button"> <a href="<?php echo site_url(); ?>?page_id=54">Read more</a> </div>
                </div>
          </div>
            </div>
       <div class="cate_box">
              <div class="cate_box_bg"><p></p>
              <?php if ( is_active_sidebar( 'Home2 Widget Area' ) ) : ?><?php  dynamic_sidebar( 'Home2 Widget Area' ); ?><?php endif; ?>
            <div class="read_more_div">
                  <div class="read_more_button"> <a href="<?php echo site_url(); ?>?page_id=56">Read more</a> </div>
                </div>
          </div>
            </div>
      </div>
      </div>
  </div>
    </div>
<div class="container content_bg">
      <div class="row">
    <div class="twelvecol">
          <div class="small_banner_bg"> <img src="<?php bloginfo('template_url')?>/images/small-banner.png" /> </div>
        </div>
  </div>
      <div class="middle_line">
    <div class="row">
          <div class="twelvecol">
        <div class="slogan_txt_middle">
              <p>Let?s find Best Traders & </p>
              <br/>
              <div>Professional <span class="color">Builders</span></div>
            </div>
      </div>
        </div>
  </div>
      <div class="row">
    <div class="twelvecol">
          <div class="category_part">
        <div class="traders_part">
              <div class="border_div">
            <div class="title_cate">Recent Traders</div>
	    <?php $retrieve_data = $wpdb->get_results("SELECT * FROM wp_usermeta where meta_key='usertype' and meta_value='2' ORDER BY user_id desc limit 0,2");
	    $counter=0;
	    foreach ($retrieve_data as $retrieved_data){
	    $counter++;
	    $id= $retrieved_data->user_id;
	    $all_meta_for_user = get_user_meta($id);
	    $myStr= $all_meta_for_user['about_company'][0];
	    $company=substr($myStr, 0, 50);
	    preg_match("/src='(.*?)'/i",get_avatar($id,150), $matches);
	    $a=explode('=',$matches[0]);
	    $a1=explode("'",$a[1]);
	    
	    if($counter==1)
	    {
	    ?>
            <div class="img_txt">
                  <div class="img_small"><img border="0" align="left" src="<?php echo $a1[1];?>" style="height:57px;width:57px;" /></div>
                  <div class="txt_cate"><?php echo $all_meta_for_user['first_name'][0];?><span class="myclass"><?php echo $company;?></span></div>
                </div>
	<?php }elseif($counter==2){?>	
	    </div>
            <div class="second_div">
	      <div class="img_txt_2">
                  <div class="img_small"><img border="0" align="left" src="<?php echo $a1[1];?>" style="height:57px;width:57px;" /></div>
                  <div class="txt_cate"><?php echo $all_meta_for_user['first_name'][0];?><span><?php echo $company;?></span></div>
                  <div class="more_button"> <span><a href="<?php echo site_url();?>?page_id=13">More Trader</a></span> </div>
                </div>
          </div>
	  <?php }}?>
          </div>
        <div class="latest_part">
              <div class="title_cate">Latest Jobs</div>
	      <br/>
	      <?php $retrieve_data = $wpdb->get_results("SELECT * FROM wp_jobpost limit 0,12");
	      $j=0;
	      foreach ($retrieve_data as $retrieved_data){
		$j=$j+1;
		if($j%2==1)
		{
		?>
	      <div class="left_job"><a href="#"><?php echo $retrieved_data->job_title;?><span>(11)</span></a> </div><?php }
	      else
	      {?>
	       <div class="left_job last"><a href="#"><?php echo $retrieved_data->job_title;?><span>(11)</span></a> </div>
	      <?php
		}
		}?>
	      <!--<div class="left_job last"><a href="#">try <span>(7,738)</span></a> <a href="#">rj <span>(1,014)</span></a> <a href="#">work <span>(112)</span></a> <a href="#">try <span>(8,494)</span></a> <a href="#">try <span>(2,933)</span></a> <a href="#">try <span>(5,357)</span></a> </div>
-->              <div class="more_job"> <span><a href="<?php echo site_url();?>?page_id=15">More Jobs</a></span> </div>
            </div>
	
   <!--<popular section start>-->	
	<div class="popular_part">
	  
            <div class="popular_div">
	      <div class="border_div">
            <div class="title_popular">Popular Builders</div>
	<?php
	      global $wpdb;
	      $table_name2 = $wpdb->prefix . "KOFT_hitcount";
	      $querylimit="LIMIT 2";
	      $KOFTdrafts = $wpdb->get_results("SELECT * FROM $table_name2  ORDER BY hit DESC $querylimit");
	      $c=0;
	      foreach($KOFTdrafts as $value)
	       {
		$c=$c+1; 
		   $userid = str_replace ("constructionmates.co.uk/?page_id=702&id=",'',$value->name);
		 $retrieve_data = $wpdb->get_results("SELECT * FROM wp_usermeta where meta_key='usertype' and meta_value='3' and user_id = $userid");
	       //print_r($retrieve_data);  die;
	       
	      foreach ($retrieve_data as $retrieved_data){
		
		  $id= $retrieved_data->user_id;
		  $all_meta_for_user = get_user_meta($id);
             preg_match("/src='(.*?)'/i",get_avatar($id,150), $matches);
		  $a=explode('=',$matches[0]);
		  $a1=explode("'",$a[1]);
	 if($c==1)
	     {
	      ?>
	      <div class="img_txt">
                  <div class="img_small"><img border="0" align="left" src="<?php echo $a1[1];?>" alt="" style="height:57px;width:57px;"></div>
                  <div class="txt_popular"><?php echo $all_meta_for_user['first_name'][0];echo "&nbsp";echo $all_meta_for_user['last_name'][0];?><span><?php echo substr($all_meta_for_user['about_company'][0] ,0, 50);?></span></div>
            </div>
          <?php }
	 elseif($c==2)
	   { ?> </div>
	    <div class="second_div">
	   <div class="img_txt_2">
                  <div class="img_small"><img border="0" align="left" src="<?php echo $a1[1];?>" alt="" style="height:57px;width:57px;"></div>
                  <div class="txt_popular"><?php echo $all_meta_for_user['first_name'][0];echo "&nbsp";echo $all_meta_for_user['last_name'][0];?><span><?php echo substr($all_meta_for_user['about_company'][0] ,0, 50);?></span></div>
            <div class="more_bilders"><span><a href="<?php echo site_url(); ?>?page_id=11">More Builders</a></span></div>
	   </div>
	   
	    </div>
	  <?php }
   }  } //end of foreach loop?>
       </div>
          
      </div>
  <!--<popular section closed>-->
      </div>
        </div>
  </div>
      <div class="row">
    <div class="twelvecol">
          <div class="buttton_addvertize">
        <div class="adver_button"> <span><a href="#">Advertising</a></span> </div>
        <div class="trade_button"> <span><a href="#">Building supplies</a></span> </div>
        <div class="post_button"> <span><a href="#">Hire Shopes</a></span> </div>
	 <div class="trade_button"> <span><a href="#">Buy Tools</a></span> </div>
      </div>
        </div>
  </div>
    </div>
<!--Getting Footer-->
<?php get_footer(); ?>
