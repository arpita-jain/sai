<?php do_action( 'bbp_template_before_topics_loop' ); ?>

<table class="forum-table">
<thead>
		<tr class="forum-head">
	
			<td class="forum-head-author"><?php _e( 'Author', 'buddypress' ); ?></td>
			<td class="forum-head-topic"><?php _e( 'Topic', 'buddypress' ); ?></td>
			<td class="forum-head-counter"><?php _e( 'Posts', 'buddypress' ); ?></td>
			<td class="forum-head-freshness"><?php _e( 'Freshness', 'buddypress' ); ?></td>

		</tr>
</thead>

 <tbody>

		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

			<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

</table>

<?php do_action( 'bbp_template_after_topics_loop' ); ?>
