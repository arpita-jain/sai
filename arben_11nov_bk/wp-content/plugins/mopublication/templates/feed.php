<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  XML feeds template
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */


if(!empty($_GET['debug'])) {
    
    if($_GET['debug'] == 'enabled') {
        
        echo "<!-- Debug is enabled -->";
        
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    
    }
    
} else {

    error_reporting(0);
    

}

ini_set('memory_limit', '-1');
$strictFiltering = get_option('frm_strict_filtering');
//Check if the necessary security is in place to call page

$useXMlProtection = get_option('frm_protect_xml');

if($useXMlProtection == 'yes') {
    
    $key = md5(get_option('mopub_salt').$_GET['t']);

    if($key != $_GET['key']) {

        echo json_encode(array('status' => 'error', 'message' => 'You do not have permission to view this page.'));
        exit;

    }
    
}

function cat_group_by() {
    global $wpdb;
    $groupby = "{$wpdb->posts}.ID";

    return $groupby;
}

if(isset($_GET['type']))
{
	
    
        if ( get_option('permalink_structure') ) { $permalink_seperator = '?'; } else { $permalink_seperator = '&'; }
        
	$pagelink = get_permalink();
	remove_filter('the_excerpt', 'wpautop');
	 
	 
    if ( ! empty($_GET['mopage']) )
    {
        $page = ($_GET['mopage'] + 1);
    }

	$type = $_GET['type'];
	
	$wp_query= null; 
	switch ($type) 
	{
	    case 'search':
	        // Article for specified search query
			$searchquery = $_GET['querystring']; 
                        $wp_query = new WP_Query("s=".$searchquery."&showposts=8&paged=".$page."&post_status=publish"); 
                        
	    break; 
	    case 'cat':
	        // Article for specified category  
			$cat = urldecode($_GET['cat']);
            $cat = str_replace('_mo_', ',', $cat);
            
            $cats = explode(',', $cat);

            $searchTerm = '';
            foreach($cats as $term) {
               
                $catTerm = get_term_by('name', $term, 'category');
                
                if(!empty($catTerm->slug)) {
                    
                    $searchTerm .= $catTerm->slug.',';
                
                } else {
                    
                    $searchTerm .= $term;
                    
                }
                

            }
            
            //fall back to GET
            if(empty($searchTerm) || $searchTerm == ',') {
                
                $searchTerm = $_GET['cat'];
                
            }

            add_filter('posts_groupby', 'cat_group_by');

			$wp_query = new WP_Query(array("category_name" => $searchTerm, "showposts" => '8', 'paged' => $page, 'orderby' => 'date', 'order' => 'DESC', 'post_status' => 'publish'));
            
	    break;
	    case 'tag':
	        // Article for specified tag
			$tag = $_GET['tag'];
			$wp_query = new WP_Query("tag=".$tag."&showposts=8&paged=".$page."&post_status=publish");  
	    break;
	    case 'tag_list':
	        // List of Tags
	    break;
	    case 'cat_list':
	        // List of categories
	    break;  
	}
	
	if($type == 'search' or $type == 'cat' or $type == 'tag') 
	{  
		echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
				<rss version="2.0"> 
					<channel>
						<title><![CDATA[<?php 
                        
                        $blogName = cleanGeneral( bloginfo('name')); 
                        
                        if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                            
                            $blogName = cleanContentStrict($blogName);
                            
                        }
                        
                        echo $blogName;
                        
                        ?>]]></title>
						<description></description>
						<link><![CDATA[<?php echo get_bloginfo('url'); ?>]]></link> 
						<generator><![CDATA[<?php echo $pluginName; ?>]]></generator>
				
							<?php  
							while ($wp_query->have_posts()) : $wp_query->the_post(); 
								$id = get_the_ID();
								$customs = get_post_custom(); 
								?>
								<item>
                                    <title><![CDATA[<?php 

                                    $itemTitle = cleanGeneral(get_the_title());
                                    
                                    if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                                        
                                        $itemTitle = cleanContentStrict($itemTitle);
                                        
                                    }
                                    
                                    echo $itemTitle;
                                    
                                    ?>]]></title>
									<link><![CDATA[<?php echo $pagelink.$permalink_seperator; ?>type=article&article_id=<?php echo urlencode($id); ?>]]></link>
									<description><![CDATA[<?php 
                                    
                                    $description = cleanGeneral(get_the_excerpt()); 
                                    
                                    if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                                        
                                        $description = cleanContentStrict($description);
                                        
                                    }
                                    
                                    echo $description;
                                    
                                    ?>]]></description>
									<author><![CDATA[<?php echo get_the_author(); ?>]]></author>
									<category><![CDATA[iPhone App]]></category>
									<pubDate><![CDATA[<?php echo get_the_date('', $id); ?>]]></pubDate>
										
									<a_id><![CDATA[<?php the_ID(); ?>]]></a_id>
									<a_headline><![CDATA[<?php 
                                    
                                    $headline = cleanGeneral(get_the_title()); 
                                    
                                    if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                                        
                                        $headline = cleanContentStrict($headline);
                                        
                                    }
                                    
                                    echo $headline;
                                    
                                    ?>]]></a_headline>
                                    <a_abstract><![CDATA[<?php 
                                    
                                    $abstract = cleanGeneral(get_the_excerpt()); 
                                    
                                    if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                                        
                                        $abstract = cleanContentStrict($abstract);
                                        
                                    }
                                    
                                    echo $abstract;
                                    
                                    ?>]]></a_abstract>
									<a_publish_date><![CDATA[<?php echo strtotime(get_the_date('', $id)); ?>]]></a_publish_date>
									<a_author><![CDATA[<?php echo get_the_author(); ?>]]></a_author>
                                    <?php
                                        
                                        $thumbnail = '';
                                    
                                        //get mopub fetured imaged
                                        if($thumbnail=='') {
                                            $thumbnail = get_post_meta($id, 'mopub_featured_image', true);  
                                        }
                                        
                                        //get featured image
                                        $featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full');
                                        
                                        if(!empty($featuredImage)) {
                                        
                                            $thumbnail = $featuredImage[0];
                                            
                                        }
                                        
                                    ?>
                                    <a_thumbnail><![CDATA[<?php
                                          
                                          //scan images in article
                                          if($thumbnail == '') {
                                               $matches = str_img_src(get_the_content());
                                                echo $matches[1][0];
                                          } else {
                                               echo $thumbnail;
                                          }
                                          
                                    ?>]]></a_thumbnail>
                                    <?php  $comments = wp_count_comments( $id  ); ?>
									<a_comment_count><![CDATA[<?php echo $comments->approved; ?>]]></a_comment_count>	
                                    <?php
                                        $media = 0;
                                        $video = get_post_meta($id, 'mopub_vid_video', true);
                                        $audio = get_post_meta($id, 'mopub_aud_video', true);
                                        if (!empty($video)) {
                                            $media++;
                                        }
                                        if (!empty($audio)) {
                                            $media++;
                                        }
                                        
                                    ?>
									<a_media_count><![CDATA[<?php echo $media; ?>]]></a_media_count>
									<a_document_count><![CDATA[0]]></a_document_count>
									<updated><![CDATA[<?php echo strtotime(get_the_date()), ""; ?>]]></updated>
									<guid><![CDATA[<?php echo $pagelink; ?><?php echo $pagelink.$permalink_seperator; ?>type=article&article_id=<?php echo urlencode($id); ?>]]></guid>
								</item>
							<?php endwhile; ?>	 
					</channel>
				</rss>
		<?php  
	}
	
	if($type == 'tag_list') 
	{     
			$tags = get_tags( array('orderby' => "count", 'order' => 'desc', 'number' => '100') );
			echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
			<?php echo '<rss version="2.0">'; ?>
			<?php echo '<channel>'; ?>
			<title><![CDATA[<?php 
            
            $blogName = cleanGeneral(bloginfo('name')); 
            
            if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                
                $blogName = cleanContentStrict($blogName);
                
            }
            
            echo $blogName;
            
            ?> - Tags]]></title>
			<description></description>
			<link><![CDATA[<?php echo get_bloginfo('url'); ?>]]></link> 
			<lastBuildDate></lastBuildDate>
			<generator><![CDATA[<?php echo $pluginName; ?>]]></generator>
			<?php
			foreach ( $tags as $key => $tag ) 
			{
				?>
				<item>
					<title><![CDATA[<?php 
                    
                    $itemName = cleanGeneral($tag->name); 
                    
                    if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                        
                        $itemName = cleanContentStrict($itemName);
                        
                    }
                    
                    echo $itemName;
                    
                    ?>]]></title>
					<link><![CDATA[<?php echo $pagelink.$permalink_seperator; ?>type=tag&tag=<?php echo urlencode($tag->slug); ?>]]></link>
					<description></description>
					<author></author>
					<category><![CDATA[iPhone App]]></category>
					<pubDate></pubDate> 
					<content_id><![CDATA[<?php echo $tag->slug; ?>]]></content_id>
					<content_title><![CDATA[<?php echo $itemName; ?>]]></content_title>
                                        
					<content_feed><![CDATA[<?php echo $pagelink.$permalink_seperator; ?>type=tag&tag=<?php echo urlencode($tag->slug); ?>]]></content_feed>
                                        
					<content_count><![CDATA[<?php echo $tag->count; ?>]]></content_count>
					<content_view_feed><![CDATA[<?php echo $pagelink.$permalink_seperator; ?>type=article&article_id=]]></content_view_feed> 
					<updated></updated>
					<guid></guid>
				</item>
				<?php
			} 
			echo '</channel>';
			echo '</rss>';
	}
	
	if($type == 'cat_list') 
	{    
		$tags = get_terms('post_tag');
			
			$cats = get_categories(array('child_of' => 0,'orderby' => 'title','order' => 'ASC'));

            echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
                <rss version="2.0">
                <channel>
                <title><![CDATA[<?php 
                
                $blogName = cleanGeneral(bloginfo('name')); 
                
                if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                    
                    $blogName = cleanContentStrict($blogName);
                    
                }
                
                echo $blogName;
                
                ?> - Categories]]></title>
                <description></description>
                <link><![CDATA[<?php echo get_bloginfo('url'); ?>]]></link>
                <lastBuildDate></lastBuildDate>
                <generator><![CDATA[MoPublisher]]></generator>

            <?php
			foreach($cats as $cat) {
				?>
				<item>
					<title><![CDATA[<?php 
                    
                    $itemTitle = cleanGeneral($cat->name); 
                    
                    if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                        
                        $itemTitle = cleanContentStrict($itemTitle);
                        
                    }
                    
                    echo $itemTitle;
                    
                    ?>]]></title>
					<link><![CDATA[<?php echo $pagelink.$permalink_seperator; ?>type=cat&cat=<?php echo urlencode($cat->slug); ?>]]></link>
					<description></description>
					<author></author>
					<category><![CDATA[iPhone App]]></category>
					<pubDate></pubDate> 
					<content_id><![CDATA[<?php echo $cat->slug; ?>]]></content_id>
					<content_title><![CDATA[<?php 
                    
                    $contentTitle = cleanGeneral($cat->name); 
                    
                    if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                        
                        $itemTitle = cleanContentStrict($itemTitle);
                    
                    }
                    
                    echo $contentTitle;
                    
                    ?>]]></content_title>
					<content_feed><![CDATA[<?php echo $pagelink.$permalink_seperator; ?>type=cat&cat=<?php echo urlencode($cat->slug); ?>]]></content_feed>
					<content_count><![CDATA[<?php echo $cat->category_count; ?>]]></content_count>
					<content_view_feed><![CDATA[<?php echo $pagelink.$permalink_seperator; ?>type=article&article_id=]]></content_view_feed> 
					<updated></updated>
					<guid></guid>
				</item>
				<?php
			}

        echo '</channel>';
        echo '</rss>';

    }
	
	
	if($type == 'article') 
	{  
	echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
	<rss version="2.0">
		<channel>
			<title><![CDATA[<?php bloginfo('name'); ?>]]></title>
			<description></description>
			<link><![CDATA[<?php echo get_bloginfo('url'); ?>]]></link> 
			<generator>MoPublisher</generator> 
					<?php   
					$post_id = $_GET['article_id'];
					$my_post = get_post($post_id);
                    $author = get_userdata($my_post->post_author);
					?>
                    <?php 
                          $videoEmbedYouTube = get_post_meta($post_id, 'mopub_embed_video_youtube', true); 
                          $videoEmbedYouTubeInfo = explode('v=',$videoEmbedYouTube);
                          
                          $videoEmbedVimeo = get_post_meta($post_id, 'mopub_embed_video_vimeo', true); 
                          $videoEmbedVimeoInfo = explode('com/',$videoEmbedVimeo);
                    ?>
						<item>
							<title><![CDATA[<?php 
                            
                            $postTitle = $my_post->post_title; 
                            
                            if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                                
                                $postTitle = cleanContentStrict($postTitle);
                                
                            }
                            
                            echo $postTitle;
                            
                            ?>]]></title>
                            <link><![CDATA[<?php echo $pagelink; ?><?php echo $pagelink.$permalink_seperator; ?>type=article&article_id=<?php echo urlencode($post_id); ?>]]></link>
							<?php 
                                
                                $processedContent = apply_filters( 'the_content', $my_post->post_content );
                                $content = cleanContent($my_post->post_content);



                                if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                                    
                                    $content = cleanContentStrict($content);
                                    
                                }
                                
                            ?>
							<description><![CDATA[<?php echo substr(cleanGeneral($content), 0, 200); ?>]]></description>
							<author><![CDATA[<?php echo get_the_author($my_post->post_author); ?>]]></author>
							<category><![CDATA[iPhone App]]></category>
							<pubDate><![CDATA[<?php echo $my_post->post_date; ?>]]></pubDate>
							
                            <a_url><?php echo get_permalink( $post_id ); ?></a_url>
							<a_id><![CDATA[<?php echo $post_id; ?>]]></a_id>
							<a_headline><![CDATA[<?php echo $my_post->post_title; ?>]]></a_headline>
							<a_abstract><![CDATA[<?php 
                            
                            $abstract =  substr(cleanGeneral($my_post->post_content), 200); 
                            
                            if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {
                                
                                $abstract = cleanContentStrict($abstract);
                                
                            }
                            
                            echo $abstract;
                            
                            ?>]]></a_abstract>
							<a_publish_date><![CDATA[<?php echo strtotime($my_post->post_date), ""; ?>]]></a_publish_date>
							<a_author><![CDATA[<?php echo $author->display_name; ?>]]></a_author>
                            <?php 
                                $matches = str_img_src($processedContent); 
                            ?>
							<a_images>
                                  <?php $mopubFeatured = get_post_meta($post_id, 'mopub_featured_image', true) ?>
                                  <?php if(!empty($mopubFeatured)) :?>  
                                  <a_image>
                                       <ai_thumbnail><![CDATA[<?php echo $mopubFeatured;  ?>]]></ai_thumbnail>
                                       <ai_resized><![CDATA[<?php echo $mopubFeatured;  ?>]]></ai_resized>
                                       <ai_caption><![CDATA[<?php echo get_post_meta($post_id, 'mopub_featured_caption', true);  ?>]]></ai_caption>
                                       <ai_source><![CDATA[]]></ai_source>
                                  </a_image>
                                <?php endif; ?>  
                                  <?php $featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full'); ?>
                                  <?php if(!empty($featuredImage)) :?>
                                  <a_image>
                                       <ai_thumbnail><![CDATA[<?php echo $featuredImage[0];  ?>]]></ai_thumbnail>
                                       <ai_resized><![CDATA[<?php echo $featuredImage[0];  ?>]]></ai_resized>
                                       <ai_caption><![CDATA[]]></ai_caption>
                                       <ai_source><![CDATA[]]></ai_source>
                                  </a_image>
                                  <?php endif;?>
                                  <?php if(!empty($matches) ) :?>
                                  <?php foreach ($matches[1] as $image) :?>
                                  <a_image>
                                    <ai_thumbnail><![CDATA[<?php echo $image;  ?>]]></ai_thumbnail>
                                    <ai_resized><![CDATA[<?php echo $image;  ?>]]></ai_resized>
                                    <ai_caption><![CDATA[]]></ai_caption>
                                    <ai_source><![CDATA[]]></ai_source>
                                  </a_image>  
                                  <?php endforeach;?>
                                  <?php endif;?>
                            </a_images>
                            <?php  $comments = wp_count_comments( $post_id   ); ?>
							<a_comment_count><![CDATA[<?php echo $comments->approved; ?>]]></a_comment_count>
                             <?php
                                        $media = 0;
                                        $video = get_post_meta($post_id, 'mopub_vid_video', true);
                                        $audio = get_post_meta($post_id, 'mopub_aud_video', true);
                                        if (!empty($video)) {
                                            $media++;
                                        }
                                        if (!empty($audio)) {
                                            $media++;
                                        }
                                        
                            ?>
							<a_media_count><![CDATA[<?php echo $media; ?>]]></a_media_count>
							<a_document_count><![CDATA[0]]></a_document_count>
							<a_content><![CDATA[<?php if(!empty($videoEmbedYouTube)) { echo  '<p style="margin-left: auto; margin-right: auto;"><center><iframe width="300" height="200" src="http://www.youtube.com/embed/'.$videoEmbedYouTubeInfo[1].'" frameborder="0" allowfullscreen></iframe></center></p>';} ?><?php if(!empty($videoEmbedVimeo)) { echo  '<p style="margin-left: auto; margin-right: auto;"><center><iframe src="http://player.vimeo.com/video/'.$videoEmbedVimeoInfo[1].'" width="300" height="200" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></center></p>';} ?><?php echo $content; ?>]]></a_content> 
							<?php if(get_post_meta($post_id, 'mopub_vid_video', true) != "" or get_post_meta($post_id, 'mopub_aud_video', true) != "") { ?>
							<a_media>
								
								<?php if(get_post_meta($post_id, 'mopub_vid_video', true) != "") { ?>
								<a_media_item>
									<aa_filename><![CDATA[<?php echo get_post_meta($post_id, 'mopub_vid_video', true); ?>]]></aa_filename>
									<aa_media_description><![CDATA[<?php echo get_post_meta($post_id, 'mopub_vid_caption', true); ?>]]></aa_media_description>
									<ai_media_resized><![CDATA[<?php echo get_post_meta($post_id, 'mopub_vid_image', true); ?>]]></ai_media_resized>
									<ai_media_thumbnail><![CDATA[<?php echo get_post_meta($post_id, 'mopub_vid_image', true); ?>]]></ai_media_thumbnail>
								</a_media_item>
								<?php } ?>
								
								<?php if(get_post_meta($post_id, 'mopub_aud_video', true) != "") { ?>
								<a_media_item>
									<aa_filename><![CDATA[<?php echo get_post_meta($post_id, 'mopub_aud_video', true); ?>]]></aa_filename>
									<aa_media_description><![CDATA[<?php echo get_post_meta($post_id, 'mopub_aud_caption', true); ?>]]></aa_media_description>
									<ai_media_resized><![CDATA[<?php echo get_post_meta($post_id, 'mopub_aud_image', true); ?>]]></ai_media_resized>
									<ai_media_thumbnail><![CDATA[<?php echo get_post_meta($post_id, 'mopub_aud_image', true); ?>]]></ai_media_thumbnail>
								</a_media_item>
								<?php } ?>
								
							</a_media>
							<?php } ?> 
                            <a_comments>
                                <?php $comment_array = get_approved_comments($post_id); ?>
                                <?php foreach($comment_array as $comment) :?>
                                <?php if($comment->comment_approved == 1) :?>
                                <a_comment>
                                    <a_comment_anonymous><![CDATA[No]]></a_comment_anonymous>
                                    <a_comment_by><![CDATA[<?php echo $comment->comment_author; ?>]]></a_comment_by>
                                    <a_comment_date><![CDATA[<?php echo $comment->comment_date; ?>]]></a_comment_date>
                                    <a_comment_content><![CDATA[<?php

                                        
                                        $comment = cleanContent($comment->comment_content, true);


                                        if($strictFiltering == 'enableFiltering' || empty($strictFiltering)) {

                                            $comment = cleanContentStrict($comment);

                                        }
                                        
                                        echo $comment;
                                        
                                    ?>]]></a_comment_content>
                                </a_comment>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </a_comments> 
                            <a_comments_status><![CDATA[<?php echo $my_post->comment_status; ?>]]></a_comments_status>
							<updated><![CDATA[<?php echo strtotime($my_post->post_date), ""; ?>]]></updated>
							<guid><![CDATA[<?php echo $pagelink; ?><?php echo $pagelink.$permalink_seperator; ?>type=article&article_id=<?php echo urlencode($post_id); ?>]]></guid>
						</item>
						<?php   
					?>	
		</channel>
	</rss>
	<?
	}
    
    if($type == 'share') 
	{
        $post_id = $_GET['article_id'];
        header('location: '.get_permalink( $post_id ));
    }

    //capture comment
    if($type == 'comment') 
	{ 
        
        $time = current_time('mysql');

        if(!empty($_POST['comment_post_ID']) && !empty($_POST['comment_author']) && !empty($_POST['comment_author_email']) && !empty($_POST['comment_content']))
        {
            
            if(get_post( $_POST['comment_post_ID'] )) {
                $data = array(
                    'comment_post_ID' => $_POST['comment_post_ID'],
                    'comment_author' => $_POST['comment_author'],
                    'comment_author_email' => $_POST['comment_author_email'],
                    'comment_author_url' => $_POST['comment_author_url'],
                    'comment_content' => $_POST['comment_content'],
                    'comment_type' => '',
                    'comment_parent' => 0,
                    'user_id' => 0,
                    'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                    'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
                    'comment_date' => $time,
                    'comment_approved' => 0,
                );

                if ($commentID = wp_insert_comment($data)) {

                    $comment = (array)get_comment( $commentID );

                    $comment['status'] = 'success';
                    $comment['message'] = 'The comment has been added';

                    echo json_encode($comment);
                    exit;


                } else {

                    echo json_encode(array('status' => 'error', 'message' => 'There was an error adding the comment, please try again later.'));
                    exit;

                }
           } else {
               
               echo json_encode(array('status' => 'error', 'message' => 'The post does not exist.'));
               
           }
           
        } else {
            
            echo json_encode(array('status' => 'error', 'message' => 'All fields are required.'));
            exit;
            
        }
            
    }
    
} 
else
{
	header('Location: '.get_bloginfo('url'));
}
?>