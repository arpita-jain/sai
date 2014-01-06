<?php

add_action( 'widgets_init', 'vfb_register_widgets' );

function vfb_register_widgets() {
	register_widget( 'VisualFormBuilder_Widget' );
}

/**
 * Class that builds our Import page
 *
 * @since 2.7
 */
class VisualFormBuilder_Widget extends WP_Widget {
	public function __construct(){
		global $wpdb;

		/* Setup global database table names */
		$this->field_table_name 	= $wpdb->prefix . 'visual_form_builder_fields';
		$this->form_table_name 		= $wpdb->prefix . 'visual_form_builder_forms';
		$this->entries_table_name 	= $wpdb->prefix . 'visual_form_builder_entries';

		$args = array(
			'classname' 	=> 'vfb_widget_class',
			'description' 	=> 'Visual Form Builder widget'
		);

		$this->WP_Widget( 'vfb_widget', 'Visual Form Builder', $args );
	}

	public function form( $instance ) {
		global $wpdb;

		// Query to get all forms
		$order = sanitize_sql_orderby( 'form_id ASC' );
		$where = apply_filters( 'vfb_pre_get_forms_widget', '' );
		$forms = $wpdb->get_results( "SELECT * FROM $this->form_table_name WHERE 1=1 $where ORDER BY $order" );

		$instance = wp_parse_args( (array) $instance );
		?>
		<select name="<?php echo $this->get_field_name( 'id' ); ?>">
		<?php
			foreach ( $forms as $form ) {
				echo sprintf(
					'<option value="%1$d" id="%2$s"%3$s>%4$s</option>',
					absint( $form->form_id ),
					esc_html( $form->form_key ),
					selected( $form->form_id, $instance['id'], 1 ),
					wp_specialchars_decode( esc_html( stripslashes( $form->form_title ) ), ENT_QUOTES )
				);
			}
		?>
		</select>
		<?php
	}

	public function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		// Parse the arguments into an array
		$atts = wp_parse_args( $instance );

		// Sanitize and save form id
		$form_id = absint( $atts['id'] );

		// Print the output
		echo do_shortcode( "[vfb id=$form_id]" );

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['id'] = $new_instance['id'];

		return $instance;
	}
}
