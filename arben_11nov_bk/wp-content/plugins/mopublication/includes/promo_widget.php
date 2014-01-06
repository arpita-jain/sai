<?php
/**
* MoPublication App Store Badge
*/
class mopub_app_promote_widget extends WP_Widget {


    function mopub_app_promote_widget() {
        parent::WP_Widget(false, $name = 'MoPublication App Store Badge');	
    }

    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $app_link 	= $instance['app_link'];
        $app_language 	= $instance['app_language'];
        $app_text 	= $instance['app_text'];
        ?>
        <?php echo $before_widget; ?>

            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?> 

            <?php if ( $app_text ) { echo "<p>".$app_text."</p>"; } ?>

            <?php if( trim($app_language) != "") { ?>

                <a href="<?php echo $app_link; ?>"><img src="<?php echo plugins_url( 'images/badges/app_store_badge_'.strtolower($app_language).'.png' , dirname(__FILE__) ); ?>" alt="App Store" border="0" /></a>
                
            <?php } ?> 
                
        <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {		
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['app_link'] = strip_tags($new_instance['app_link']);
        $instance['app_language'] = strip_tags($new_instance['app_language']);
        $instance['app_text'] = strip_tags($new_instance['app_text']);
        return $instance;
    }

    function form($instance) {

        $title = empty($instance['title']) ? '' : esc_attr($instance['title']);
        $app_link = empty($instance['app_link']) ? '' : esc_attr($instance['app_link']);
        $app_language = empty($instance['app_language']) ? '' : esc_attr($instance['app_language']);
        $app_text = empty($instance['app_text']) ? '' : esc_attr($instance['app_text']);
        ?>
                
        <p>Promote your iOS App by adding an App Store Badge to your website sidebar.</p>
                
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (Optional)'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('app_text'); ?>"><?php _e('Short Description (Optional)'); ?></label> 
            <textarea name="<?php echo $this->get_field_name('app_text'); ?>" class="widefat" id="<?php echo $this->get_field_id('app_text'); ?>"><?php echo $app_text; ?></textarea>
        </p> 

        <p>
            <label for="<?php echo $this->get_field_id('$app_link'); ?>"><?php _e('App Store Link'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('$app_link'); ?>" name="<?php echo $this->get_field_name('app_link'); ?>" type="text" value="<?php echo $app_link; ?>" />
        </p> 
        
        <p>
            <label for="<?php echo $this->get_field_id('app_language'); ?>"><?php _e('Badge Language'); ?></label> 
            <select name="<?php echo $this->get_field_name('app_language'); ?>" class="app_language" id="app_language">
            
            <?php 
            if($app_language != "") 
            { 
            echo "<option value='".$app_language."'>".$app_language."</option>"; 
            } 
            ?> 
            <option value="English">English</option>
            <option value="Dutch">Dutch</option>
            <option value="French">French</option>
            <option value="German">German</option>
            <option value="Italian">Italian</option>
            <option value="Japanese">Japanese</option>
            <option value="Portuguese">Portuguese</option>
            <option value="Russian">Russian</option>
            <option value="Spanish">Spanish</option>
            </select> 
        </p>
        
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("mopub_app_promote_widget");'));
?>