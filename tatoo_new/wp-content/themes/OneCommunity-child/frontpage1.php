<?php
/*
Template Name: Frontpage 1
*/
?>

<?php get_header() ?>

<section>

<div id="content">

<div id="frontpage-info">
<div id="frontpage-info-big"><?php echo of_get_option('hello', 'Hello!' ); ?></div>
<div id="frontpage-info-desc"><?php echo of_get_option('info', 'BuddyPress lets users register on your site and start creating profiles, posting messages, making connections, creating and interacting in groups and much more.' ); ?></div>

</div><!-- #frontpage-info -->

		<?php do_action( 'bp_after_header' ) ?>

		<?php do_action( 'bp_before_container' ) ?>
<div class="clear"> </div>

<div class="frontpage">


<div id="tabs-container">
<div id="object-nav">
        	<ul class="tabs-nav">
                <li class="nav-one"><a href="#popular" class="current"><?php echo of_get_option('t-9', 'Popular' ); ?></a></li>
                <li class="nav-two"><a href="#active"><?php echo of_get_option('t-10', 'Active' ); ?></a></li>
                <li class="nav-three"><a href="#alphabetical"><?php echo of_get_option('t-11', 'Alphabetical' ); ?></a></li>
                <li class="nav-four"><a href="#newest"><?php echo of_get_option('t-12', 'Newest' ); ?></a></li>
            </ul>
</div>

<div class="list-wrap">

<!-- NEWEST GROUPS LOOP POPULAR -->
<?php if ( bp_is_active('groups') ) : ?>
<?php if ( bp_has_groups( 'type=popular&max=8' ) ) : ?>

<ul id="popular">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<?php bp_group_member_count(); ?></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>
 
<?php else: ?>

<ul id="popular"> 
    <div id="message" class="info">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div>
<br />
</ul>

<?php endif; ?>
<?php endif; ?>
<!-- POPULAR GROUPS LOOP END -->

<!-- NEWEST GROUPS LOOP START -->
<?php if ( bp_is_active('groups') ) : ?>
<?php if ( bp_has_groups( 'type=newest&max=8' ) ) : ?>

<ul id="newest" class="hide">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<?php bp_group_member_count(); ?></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>
 
<?php else: ?>
 
<ul id="newest" class="hide">
    <div id="message" class="info">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>
<?php endif; ?>

<!-- NEWEST GROUPS LOOP END -->


<!-- LAST ACTIVE GROUPS LOOP START -->

<?php if ( bp_is_active('groups') ) : ?>
<?php if ( bp_has_groups( 'type=active&max=8' ) ) : ?>

<ul id="active" class="hide">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<?php bp_group_member_count(); ?></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>
 
<?php else: ?>
 
<ul id="active" class="hide">
    <div id="message" class="info">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>
<?php endif; ?>
<!-- LAST ACTIVE GROUPS LOOP END -->



<!-- ALPHABETICAL GROUPS LOOP -->
<?php if ( bp_is_active('groups') ) : ?>
<?php if ( bp_has_groups( 'type=alphabetical&max=8' ) ) : ?>

<ul id="alphabetical" class="hide">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<?php bp_group_member_count(); ?></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>
 
<?php else: ?>
 
<ul id="alphabetical" class="hide">
    <div id="message" class="info">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>
<?php endif; ?>
<!-- ALPHABETICAL GROUPS LOOP END -->


</div> <!-- List Wrap -->
</div> <!-- tabs-container -->

<div class="clear"> </div>


<div class="frontpage-bottom-left">

<div class="front-box widget">
<div class="front-box-title"><?php echo of_get_option('t-17', 'Active Members' ); ?></div>
<div class="front-box-child">

<?php if ( bp_has_members( 'type=active&max=8' ) ) : ?>			
			<?php while ( bp_members() ) : bp_the_member(); ?>						
				<a href="<?php bp_member_permalink() ?>" class="front-member-item" title="<?php bp_member_name(); ?> (<?php bp_member_last_active(); ?>)"><?php bp_member_avatar('type=full&width=60&height=60') ?></a>
			<?php endwhile; ?>
<?php endif; ?>
		
</div><!--front-box-child ends-->
</div><!--front-box ends-->

<div class="clear"></div>

<div class="front-box widget">
<div class="front-box-title"><?php echo of_get_option('t-19', 'Popular Members' ); ?></div>
<div class="front-box-child">

<?php if ( bp_has_members( 'type=popular&max=8' ) ) : ?>			
			<?php while ( bp_members() ) : bp_the_member(); ?>						
				<a href="<?php bp_member_permalink() ?>" class="front-member-item" title="<?php bp_member_name(); ?> (<?php bp_member_last_active(); ?>)"><?php bp_member_avatar('type=full&width=60&height=60') ?></a>
			<?php endwhile; ?>
<?php endif; ?>
		
</div><!--front-box-child ends-->
</div><!--front-box ends-->

</div> <!-- frontpage-bottom-left -->

<div class="frontpage-bottom-right">

<div class="front-box">
<div class="front-box-title"><?php echo of_get_option('t-3', 'On the Forums' ); ?></div>

<div class="front-box-child">
	<?php if ( bp_is_active('groups') ) : ?>
	<?php if ( bbp_has_topics( array( 'author' => 0, 'show_stickies' => false, 'order' => 'DESC', 'post_parent' => 'any', 'posts_per_page' => 5 ) ) ) : ?>
		<?php bbp_get_template_part( 'loop', 'mytopics' ); ?>
	<?php else : ?>
		<?php bbp_get_template_part( 'feedback', 'no-topics' ); ?>
	<?php endif; ?>
	<?php endif; ?>

</div>
<div class="clear"></div>
</div>

</div> <!-- frontpage-bottom-right -->

</div><!-- .frontpage -->
<div class="clear"> </div>
</div><!-- #content -->

</section>

<div id="sidebar">
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-frontpage')) : ?><?php endif; ?>
</div><!-- #sidebar -->

<?php get_footer() ?>
