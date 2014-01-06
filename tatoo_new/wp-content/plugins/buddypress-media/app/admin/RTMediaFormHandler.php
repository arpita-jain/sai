<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RTMediaFormHandler
 *
 * @author udit
 */
class RTMediaFormHandler {

	public static function checkbox($args) {

		global $rtmedia;
		$options = $rtmedia->options;
		$defaults = array(
			'key' => '',
			'desc' => '',
			'show_desc' => false
		);
		$args = wp_parse_args($args, $defaults);
		extract($args);

		if (!isset($value)) {
			trigger_error(__('Please provide "value" in the argument.', 'rtmedia'));
			return;
		}

		if (!empty($key)) {
			$args['name'] = 'rtmedia-options[' . $key . ']';
		}

		$args['rtForm_options'] = array(array('' => 1, 'checked' => $value));

		$chkObj = new rtForm();
//		echo $chkObj->get_checkbox($args);
		echo $chkObj->get_switch($args);
//		echo $chkObj->get_switch_square($args);
	}

	public static function radio($args) {

		global $rtmedia;
            $options = $rtmedia->options;
		$defaults = array(
			'key' => '',
			'radios' => array(),
			'default' => '',
			'show_desc' => false
		);
		$args = wp_parse_args($args, $defaults);
		extract($args);

		if (2 > count($radios)) {
			trigger_error(__('Need to specify atleast to radios else use a checkbox instead', 'rtmedia'));
			return;
		}

		if (!empty($key))
			$args['name'] = 'rtmedia-options[' . $key . ']';

		$args['rtForm_options'] = array();
		foreach ($radios as $value => $key) {
			$args['rtForm_options'][] = array(
				$key => $value,
				'checked' => ($default == $value) ? true : false
			);
		}

		$objRad = new rtForm();
		echo $objRad->get_radio($args);
	}

	public static function dimensions($args) {

		$dmnObj = new rtDimensions();
		echo $dmnObj->get_dimensions($args);
	}

	public static function number($args) {
		global $rtmedia;
		$options = $rtmedia->options;
		$defaults = array(
			'key' => '',
			'desc' => ''
		);
		$args = wp_parse_args($args, $defaults);
		extract($args);

		if (!isset($value)) {
			trigger_error(__('Please provide "value" in the argument.', 'rtmedia'));
			return;
		}

		if (!empty($key)) {
			$args['name'] = 'rtmedia-options[' . $key . ']';
		}

		$args['value'] = $value;

		$numObj = new rtForm();
		echo $numObj->get_number($args);
	}

	static function extract_settings($section_name,$options) {
		$section = array();
		foreach ($options as $key => $value) {
			if(strncmp($key, $section_name, strlen($section_name))==0)
				$section[$key] = $value;
		}
		return $section;
	}

	static function general_render_options($options) {

		$render = array(
			'general_enableAlbums' => array(
				'title' => __('Albums','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'checkbox'),
				'args' => array(
					'key' => 'general_enableAlbums',
					'value' => $options['general_enableAlbums'],
					'desc' => __('Enable Albums in rtMedia','rtmedia')
				)
			),
			'general_enableComments' => array(
				'title' => __('Comments','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'checkbox'),
				'args' => array(
					'key' => 'general_enableComments',
					'value' => $options['general_enableComments'],
					'desc' => __('Enable Comments in rtMedia','rtmedia')
				)
			),
			'general_downloadButton' => array(
				'title' => __('Download Button','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'checkbox'),
				'args' => array(
					'key' => 'general_downloadButton',
					'value' => $options['general_downloadButton'],
					'desc' => __('Display download button under media','rtmedia')
				)
			),
			'general_enableLightbox' => array(
				'title' => __('Lightbox','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'checkbox'),
				'args' => array(
					'key' => 'general_enableLightbox',
					'value' => $options['general_enableLightbox'],
					'desc' => __('Enable Lighbox on Media','rtmedia')
				)
			),
			'general_perPageMedia' => array(
				'title' => __('Number of Media Per Page','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'number'),
				'args' => array(
					'key' => 'general_perPageMedia',
					'value' => $options['general_perPageMedia']
				)
			),
//			'general_enableMediaEndPoint' => array(
//				'title' => __('Enable Media End Point for users','rtmedia'),
//				'callback' => array('RTMediaFormHandler', 'checkbox'),
//				'args' => array(
//					'key' => 'general_enableMediaEndPoint',
//					'value' => $options['general_enableMediaEndPoint'],
//					'desc' => __('Users can access their media on media end point','rtmedia')
//				)
//			),
                        'general_videothumbs' => array(
                                'title' => __('Number of Video Thumbnails','rtmedia'),
                                'callback' => array('RTMediaFormHandler', 'number'),
                                'args' => array(
                                        'key' => 'general_videothumbs',
                                        'value' => $options['general_videothumbs']
                                )
                        ),
			'general_showAdminMenu' => array(
				'title' => __('Admin Bar Menu','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'checkbox'),
				'args' => array(
					'key' => 'general_showAdminMenu',
					'value' => $options['general_showAdminMenu'],
					'desc' => __('Enable menu in WordPress admin bar','rtmedia')
				)
			)
//			,'general_viewcount' => array(
//				'title' => __('View count','rtmedia'),
//				'callback' => array('RTMediaFormHandler', 'checkbox'),
//				'args' => array(
//					'key' => 'general_viewcount',
//					'value' => $options['general_viewcount'],
//					'desc' => __('Enable media view count','rtmedia')
//				)
//			),
//			'general_uniqueviewcount' => array(
//				'title' => __('Unique view count','rtmedia'),
//				'callback' => array('RTMediaFormHandler', 'checkbox'),
//				'args' => array(
//					'key' => 'general_uniqueviewcount',
//					'value' => $options['general_uniqueviewcount'],
//					'desc' => __('Enable Unique media view count','rtmedia')
//				)
//			)
		);

		return $render;
	}

	public static function general_content() {
		global $rtmedia;
		$options = self::extract_settings('general', $rtmedia->options);
		$render_options = self::general_render_options($options);
                $render_options = apply_filters("rtmedia_general_content_add_itmes",$render_options, $options);
		foreach ($render_options as $key => $option) { ?>
			<div class="row section">
				<div class="columns large-4"> <?php echo $option['title']; ?> </div>
				<div class="columns large-8">
					<?php call_user_func($option['callback'], $option['args']); ?>
				</div>
			</div>
			<div class="clearfix"></div>
		<?php }
	}

	static function get_type_details($allowed_types, $key) {
		foreach ($allowed_types as $type) {
			if($type['name']==$key) {
				$data = array(
					'name' => $type['label'],
					'extn' => $type['extn']
				);
				return $data;
			}
		}
	}

	static function types_render_options($options) {
		global $rtmedia;

		$render = array();

		foreach ($options as $key => $value) {
			$data = explode('_', $key);
			if(!isset($render[$data[1]]))
				$render[$data[1]] = self::get_type_details($rtmedia->allowed_types, $data[1]);
		}
		foreach ($options as $key => $value) {
			$data = explode('_', $key);
			$render[$data[1]][$data[2]] = $value;
		}

		return $render;
	}

	public static function types_content() {

		global $rtmedia;
		$options = self::extract_settings('allowedTypes', $rtmedia->options);

		$render_data = self::types_render_options($options);
?>
		<div class="rt-table large-12">
			<div class="row rt-header">
				<h4 class="columns large-3"><?php echo __("Media Type","rtmedia") ?></h4>
				<h4 class="columns large-3 rtm-show-tooltip" title="<?php echo __("Allows you to upload a particular media type on your post.","rtmedia"); ?>"><abbr><?php echo __("Allow Upload","rtmedia"); ?></abbr></h4>
				<h4 class="columns large-3 rtm-show-tooltip" title="<?php echo __("Put a specific media as a featured content on the post.","rtmedia"); ?>"><abbr><?php echo __("Set Featured","rtmedia"); ?></abbr></h4>
				<h4 class="columns large-3 rtm-show-tooltip" title="<?php echo __("File extensions that can be uploaded on the website.","rtmedia"); ?>"><abbr><?php echo __("File Extensions","rtmedia"); ?></abbr></h4>
			</div>
<?php
		$even = 0;
		foreach ($render_data as $key=>$section) {
			if( ++$even%2 )
				echo '<div class="row rt-odd">';
			else
				echo '<div class="row rt-even">';

				echo '<div class="columns large-3">' . $section['name'] . '</div>';
				$args = array('key' => 'allowedTypes_'.$key.'_enabled', 'value' => $section['enabled']);
				echo '<div class="columns large-3">';
					self::checkbox($args);
				echo '</div>';
				$args = array('key' => 'allowedTypes_'.$key.'_featured', 'value' => $section['featured']);
				echo '<div class="columns large-3">';
					self::checkbox($args);
				echo '</div>';
				echo '<div class="columns large-3">' . implode(', ', $section['extn']) . '</div>';
			echo '</div>';
		}
		echo '</div>';
	}

	static function sizes_render_options($options) {

		$render = array();
		foreach ($options as $key => $value) {
			$data = explode('_', $key);
			if(!isset($render[$data[1]])) {
				$render[$data[1]] = array();
				$render[$data[1]]['title'] = __($data[1],"rtmedia");
			}
			if(!isset($render[$data[1]][$data[2]])) {
				$render[$data[1]][$data[2]] = array();
				$render[$data[1]][$data[2]]['title'] = __($data[2],"rtmedia");
			}
			$render[$data[1]][$data[2]][$data[3]] = $value;
		}
		return $render;
	}

	public static function sizes_content() {

		global $rtmedia;
		$options = self::extract_settings('defaultSizes',$rtmedia->options);
		$render_data = self::sizes_render_options($options);

		//container
		echo '<div class="rt-table large-12 rtmedia-size-content-setting">';

		//header
		echo '<div class="rt-header row">';
			echo '<h4 class="columns large-3">' . __("Category","rtmedia") . '</h4>';
			echo '<h4 class="columns large-3">' . __("Entity","rtmedia") . '</h4>';
			echo '<h4 class="columns large-6"><span class="large-offset-2">' . __("Width","rtmedia") . '</span><span class="large-offset-2">' . __("Height","rtmedia") . '</span><span class="large-offset-2">' . __("Crop","rtmedia") . '</span></h4>';
		echo'</div>';

		//body
		$even = 0;
		foreach ($render_data as $parent_key => $section) {
			if( ++$even%2 )
				echo '<div class="row rt-odd">';
			else
				echo '<div class="row rt-even">';
			echo '<div class="columns large-3">' . ucfirst($section['title']) . '</div>';
			$entities = $section;
			unset($entities['title']);
			echo '<div class="columns large-3">';
			foreach ($entities as $entity) {
				echo '<div class="row">' . ucfirst($entity['title']) . '</div>';
			}
			echo '</div>';
			echo '<div class="columns large-6">';
			foreach ($entities as $entity) {
				$args = array(
					'key' => 'defaultSizes_'.$parent_key.'_'.$entity['title'],
				);
				foreach ($entity as $child_key=>$value) {
					if($child_key!='title') {
						$args[$child_key] = $value;
					}
				}
				self::dimensions($args);
			}
			echo '</div>';
			echo '</div>';
		}

		echo '</div>';
	}

	static function privacy_render_options($options) {

		global $rtmedia;

		$render = array(
			'enable' => array(
				'title' => __("Enable Privacy","rtmedia"),
				'callback' => array("RTMediaFormHandler", "checkbox"),
				'args' => array(
					'id' => 'rtmedia-privacy-enable',
					'key' => 'privacy_enabled',
					'value' => $options['privacy_enabled']
				)
			),
			'default' => array(
				'title' => __("Default Privacy","rtmedia"),
				'callback' => array("RTMediaFormHandler","radio"),
				'args' => array(
					'key' => 'privacy_default',
					'radios' => $rtmedia->privacy_settings['levels'],
					'default' => $options['privacy_default']
				),
			),
			'user_override' => array(
				'title' => __("User Override","rtmedia"),
				'callback' => array("RTMediaFormHandler", "checkbox"),
				'args' => array(
					'key' => 'privacy_userOverride',
					'value' => $options['privacy_userOverride']
				)
			)
		);

		return $render;
	}

	public static function privacy_content() {

		global $rtmedia;
		$options = self::extract_settings('privacy', $rtmedia->options);

		$render_data = self::privacy_render_options($options);

		echo '<div class="large-12">';
			foreach ($render_data as $key=>$privacy) {
				echo '<div class="row section">';
					echo '<div class="columns large-4">' . $privacy['title'] . '</div>';
					echo '<div class="columns large-8">';
						if($key != "enable")
							call_user_func($privacy['callback'], array_merge_recursive($privacy['args'], array('class' => array("privacy-driven-disable"))));
						else
							call_user_func($privacy['callback'], $privacy['args']);
					echo '</div>';
				echo '</div>';
			}
		echo '</div>';
	}

	static function buddypress_render_options($options) {


		$render = array(
			'rtmedia-enable-on-profile' => array(
				'title' => __('Enable Media in Profile','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'checkbox'),
				'args' => array(
					'key' => 'buddypress_enableOnProfile',
					'value' => $options['buddypress_enableOnProfile'],
					'desc' => __('Enable Media on BuddyPress Profile','rtmedia')
				)
			),
			'rtmedia-enable-on-group' => array(
				'title' => __('Enable Media in Group','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'checkbox'),
				'args' => array(
					'key' => 'buddypress_enableOnGroup',
					'value' => $options['buddypress_enableOnGroup'],
					'desc' => __('Enable Media on BuddyPress Groups','rtmedia')
				)
			),
			'rtmedia-enable-on-activity' => array(
				'title' => __('Enable Media in Activity','rtmedia'),
				'callback' => array('RTMediaFormHandler', 'checkbox'),
				'args' => array(
					'key' => 'buddypress_enableOnActivity',
					'value' => $options['buddypress_enableOnActivity'],
					'desc' => __('Enable Media on BuddyPress Activities','rtmedia')
				)
			)
		);

		return $render;
	}

	public static function buddypress_content() {

		global $rtmedia;
		$options = self::extract_settings('buddypress', $rtmedia->options);

		$render_data = self::buddypress_render_options($options);

		echo '<div class="large-12">';
		foreach ($render_data as $option) { ?>
			<div class="row section">
				<div class="columns large-4"><?php echo $option['title']; ?></div>
				<div class="columns large-8">
					<?php call_user_func($option['callback'], $option['args']); ?>
				</div>
			</div>
		<?php }
		echo '</div>';
	}

	public static function rtForm_settings_tabs_content($page, $sub_tabs) {
                $rtmedia_admin_ui_handler = "<div class='section-container auto' data-options='deep_linking: true' data-section=''>";
                $rtmedia_admin_ui_handler = apply_filters("rtmedia_admin_ui_handler_filter",$rtmedia_admin_ui_handler);
                echo $rtmedia_admin_ui_handler;
                $sub_tabs = apply_filters("rtmedia_pro_settings_tabs_content",$sub_tabs);
		foreach ($sub_tabs as $tab) {
                    if ( isset ( $tab[ 'icon' ] ) && ! empty ( $tab[ 'icon' ] ) )
                        $icon = '<i class="' . $tab[ 'icon' ] . '"></i>';
                    $tab_without_hash = explode("#", $tab[ 'href' ]);
                    $tab_without_hash  = $tab_without_hash[1];
                    echo '<section> <p class="title" data-section-title><a id="tab-' . substr ( $tab[ 'href' ], 1 ) . '" title="' . $tab[ 'title' ] . '" href="' . $tab[ 'href' ] . '" class="rtmedia-tab-title ' . sanitize_title ( $tab[ 'name' ] ) . '">' . $icon . ' ' . $tab[ 'name' ] . '</a> </p> <div class="content" data-section-content data-slug="' . $tab_without_hash . '">';
				call_user_func($tab['callback'], $page);
                    echo '</div> </section>';
		}
            ?>
                </div>
                     <div class="clearfix"></div>
            <?php
	}

	public static function rtForm_do_settings_fields($page, $section) {
		global $wp_settings_fields;

		if (!isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section]))
			return;

		foreach ((array) $wp_settings_fields[$page][$section] as $field) {
			echo '<div class="row">';
			echo '<div class="large-11 columns">';

			if (isset($field['args']['label_for']) && !empty($field['args']['label_for']))
				call_user_func($field['callback'], array_merge($field['args'], array('label' => $field['args']['label_for'])));
			else if (isset($field['title']) && !empty($field['title']))
				call_user_func($field['callback'], array_merge($field['args'], array('label' => $field['title'])));
			else
				call_user_func($field['callback'], $field['args']);
			echo '</div>';
			echo '</div>';
		}
	}
}
?>
