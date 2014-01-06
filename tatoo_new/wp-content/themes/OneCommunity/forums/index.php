<?php

/**
 * BuddyPress - Forums Directory
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<?php get_header( 'buddypress' ); ?>

	<?php do_action( 'bp_before_directory_forums_page' ); ?>

	<div id="content">


			<?php do_action( 'bp_before_directory_forums' ); ?>

			<?php do_action( 'bp_before_topics' ); ?>

			<form action="" method="post" id="forums-directory-form" class="dir-form">

						<div id="forums-dir-list" class="forums dir-list" role="main">

					<?php locate_template( array( 'forums/forums-loop.php' ), true ); ?>

				</div>

				<?php do_action( 'bp_directory_forums_content' ); ?>

				<?php wp_nonce_field( 'directory_forums', '_wpnonce-forums-filter' ); ?>

			</form>

			<?php do_action( 'bp_after_directory_forums' ); ?>


			<?php if ( is_user_logged_in() ) : ?><a class="show-hide-new" href="#new-topic" id="new-topic-button"><?php _e( 'New Topic', 'buddypress' ); ?></a><?php endif; ?>
			

			<?php do_action( 'bp_before_new_topic_form' ); ?>

			<div id="new-topic-post">

				<?php if ( is_user_logged_in() ) : ?>

					<?php if ( bp_is_active( 'groups' ) && bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100' ) ) : ?>

						<form action="" method="post" id="forum-topic-form" class="standard-form">

							<?php do_action( 'groups_forum_new_topic_before' ); ?>

							<a name="post-new"></a>
							<h5><?php _e( 'Create New Topic:', 'buddypress' ); ?></h5>

							<?php do_action( 'template_notices' ); ?>

							<label><?php _e( 'Title:', 'buddypress' ); ?></label>
							<input type="text" name="topic_title" id="topic_title" value="" maxlength="100" />

							<label><?php _e( 'Content:', 'buddypress' ); ?></label>
							<textarea name="topic_text" id="topic_text"></textarea>

							<label><?php _e( 'Tags (comma separated):', 'buddypress' ); ?></label>
							<input type="text" name="topic_tags" id="topic_tags" value="" />

							<label><?php _e( 'Post In Group Forum:', 'buddypress' ); ?></label>
							<select id="topic_group_id" name="topic_group_id">

								<option value=""><?php /* translators: no option picked in select box */ _e( '----', 'buddypress' ); ?></option>

								<?php while ( bp_groups() ) : bp_the_group(); ?>

									<?php if ( bp_group_is_forum_enabled() && ( bp_current_user_can( 'bp_moderate' ) || 'public' == bp_get_group_status() || bp_group_is_member() ) ) : ?>

										<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>

									<?php endif; ?>

								<?php endwhile; ?>

							</select><!-- #topic_group_id -->

							<?php do_action( 'groups_forum_new_topic_after' ); ?>

							<div class="submit">
								<input type="submit" name="submit_topic" id="submit" value="<?php _e( 'Post Topic', 'buddypress' ); ?>" />
								<input type="button" name="submit_topic_cancel" id="submit_topic_cancel" value="<?php _e( 'Cancel', 'buddypress' ); ?>" />
							</div>

							<?php wp_nonce_field( 'bp_forums_new_topic' ); ?>

						</form><!-- #forum-topic-form -->

					<?php elseif ( bp_is_active( 'groups' ) ) : ?>

						<div id="message" class="info">

							<p><?php printf( __( "You are not a member of any groups so you don't have any group forums you can post in. To start posting, first find a group that matches the topic subject you'd like to start. If this group does not exist, why not <a href='%s'>create a new group</a>? Once you have joined or created the group you can post your topic in that group's forum.", 'buddypress' ), site_url( bp_get_groups_root_slug() . '/create/' ) ); ?></p>

						</div>

					<?php endif; ?>

				<?php endif; ?>
			</div><!-- #new-topic-post -->

			<?php do_action( 'bp_after_new_topic_form' ); ?>

			<?php do_action( 'bp_after_directory_forums_content' ); ?>


	</div><!-- #content -->

	<?php do_action( 'bp_after_directory_forums_page' ); ?>

<?php get_sidebar( 'buddypress' ); ?>

<?php get_footer( 'buddypress' ); ?>
