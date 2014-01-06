<?php 

	function cis_rating_fun( $atts ) {
	include_once 'function.php';
	$aboutuserid = $_SESSION["rating_aboutname"];
	$user = wp_get_current_user();
	$userid = $user->ID;
	
	
		?>
	
		<html>			
			<body onload="getExistdata();">
                            <body>
				   <?php if (get_template()=="constructionmatesss_mob") {?><a  href="#" id="sample">Rate Me</a><?php }else {?>
                            <div id="container"> <!-- Main Page -->
                            <a  href="#" id="sample">Rate Me</a>
                            </div><?php }?>
                            <div id="popup_box_rating">	<!-- OUR PopupBox DIV-->
                            <div>
                            <a id="popupBoxClose_rating"><img width="46%" alt="Close" src="<?php echo site_url();?>/wp-content/themes/constructionmates/images/close.png"></a>
                            </div>
			  <form action="<?php echo  plugins_url().'/ratings/save.php';?>" name="rating_comment_form" method="post" >
			     <div id="star_comments_container">
 				<?php $data = getData();
				$comment="";
				$rating="";
				$id="";
				if($data[0])
				{
					$comment =$data[0]->comment;
					$rating = $data[0]->rating;
					$id =$data[0]->id;
				}
				?>
				   <div id="rating">					
					<ul id="star">						
						<li onclick="rating_fun(this.value)" id="1" value="1">
							<img id="img_1" src="wp-content/plugins/ratings/images/ratingstar.png"  class="star_img"/>							
						</li>						
						<li  onclick="rating_fun(this.value)" id="2" value="2">
							<img id="img_2" src="wp-content/plugins/ratings/images/ratingstar.png"  class="star_img"/>							
						</li>						
						<li  onclick="rating_fun(this.value)" id="3" value="3">
							<img id="img_3" src="wp-content/plugins/ratings/images/ratingstar.png"  class="star_img"/>							
						</li>						
						<li  onclick="rating_fun(this.value)" id="4" value="4">
							<img  id="img_4" src="wp-content/plugins/ratings/images/ratingstar.png"  class="star_img"/>							
						</li>						
						<li  onclick="rating_fun(this.value)" id="5" value="5">
							<img id="img_5" src="wp-content/plugins/ratings/images/ratingstar.png"  class="star_img"/>						
						</li>					
					</ul>				
				   </div>			   
				   <div id="comments">
					<h5>comment here</h5>
					<textarea name="comment" cols="40" rows="4"><?php echo $comment; ?></textarea>
					<input type="hidden" name="finalrating" value="<?php echo $rating;?>" id="finalrating" />
					  <?php if (get_template()=="constructionmatesss_mob") {?>
					<input type="hidden" name="returnurl" value="<?php echo the_permalink().'&id='.$aboutuserid.'&theme=handheld'; ?>" />
					<?php }else{?>
						<input type="hidden" name="returnurl" value="<?php the_permalink()?><?php echo '&id='.$aboutuserid; ?>" />
				<?php }?>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
				   </div>				   
			     </div>
			    <input type="submit" name="Submit" value="Submit" onclick="return comment_fun()" />
			  </form>
                        </div>
			   
			</body>
			      <!--<script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script> -->   
				<script type="text/javascript" src="<?php echo  plugins_url().'/ratings/js/popupbox.js';?>"></script>                                                           
				<script type="text/javascript" src="<?php echo  plugins_url().'/ratings/js/rating.js';?>"></script>
                                
                                <link rel="stylesheet" type="text/css" href="<?php echo  plugins_url().'/ratings/css/popupbox.css';?>">
				<link rel="stylesheet" type="text/css" href="<?php echo  plugins_url().'/ratings/css/rating.css';?>">
		</html>
	<?php
	
	}
	add_shortcode( 'cis_rating', 'cis_rating_fun' );
	
	
	function showData()
	{
		include_once 'show.php';
		getShow();
	}
	add_shortcode('show_rating','showData');
	function showData2()
	{
		include_once 'show.php';
		getShow2();
	}
	add_shortcode('show_ratingId','showData2');
	
	?>