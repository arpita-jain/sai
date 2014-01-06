<?php

function buatp_get_all_field_groups($condition = ''){
    global $wpdb;
    $query = "SELECT * FROM ".$wpdb->base_prefix."bp_xprofile_groups $condition";
    $groups = $wpdb->get_results($query, ARRAY_A);
    foreach((array) $groups as $group){
        $ids[$i++] = $group['id'];
    }
    return (array) $ids;
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_all_fields($condition = "WHERE parent_id = 0" , $return = 'name'){
   global $wpdb;
   $query="SELECT * FROM ".$wpdb->base_prefix."bp_xprofile_fields $condition";
   $fields=$wpdb->get_results($query,ARRAY_A);
   if(!count($fields))
       return array();
   foreach($fields as $field) {
       $name = $field[$return];
       $arr[$name] = $name;
   }
   return $arr;
}


//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_all_profile_groups(){
    if(class_exists('BP_XProfile_Group')) {
      $group_obj = BP_XProfile_Group::get();
      foreach($group_obj as $groups ){
          if(!$i){
              $i++;
              continue;
          }
          $arr[$groups->id] = $groups->name;
          
      }
      return (array)$arr;
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_all_select_box_fields() {
   global $wpdb;
   $query="SELECT * FROM ".$wpdb->base_prefix."bp_xprofile_fields WHERE type='selectbox'";
   return buatp_get_all_fields("WHERE type='selectbox'");
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_check_type_field_exist(){
   $fields = buatp_get_all_select_box_fields();
   if(is_array($fields) && count($fields))
       return true;
   else
       return false;
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_all_types($field_id , $selection = '*', $output = 'multidimantion'){
    global $wpdb;
    $query="SELECT $selection FROM ".$wpdb->base_prefix."bp_xprofile_fields WHERE type='option' AND parent_id='".$field_id."'";
    $types=$wpdb->get_results($query,ARRAY_A);
    if(count($types)){
        if($output == 'multidimantion')
        return $types;
        else {
            foreach ((array)$types as $val) {
                $arr[$val[$selection]] = $val[$selection];
            }
            return (array) $arr;
        }
    }
    else
        return false;
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_field_id_by_name($name) {
    return xprofile_get_field_id_from_name($name);
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_convert_fields_name_to_id($fields) {
    if(!$fields)
        return;
    foreach((array)$fields as $index => $name){
        $arr[$index] = buatp_get_field_id_by_name($name);
    }
    return $arr;
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_all_roles() {
	$editable_roles = get_editable_roles();
        foreach ( $editable_roles as $role => $details ) {
		$name = translate_user_role($details['name'] );
                $arr[esc_attr($role)] = $name;
	}
	return array_reverse((array)$arr);
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_dir_name(){
    $settings = get_option('buatp_basic_setting',true);
    $page_id = get_the_ID();
    $field_name = $settings['buatp_type_field_selection'];
    $field_id = buatp_get_field_id_by_name($field_name);
    $type_names = buatp_get_all_types($field_id);
    foreach ($type_names as $val){
        if($settings['buatp_page_selection_for_'.$val['name']] == $page_id ){
            return $val['name'];
        }     
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_the_dir_name(){
    echo buatp_get_dir_name();
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_all_users_by_type($type_name){
    global $wpdb;
    $buatp_general_settings = get_option('buatp_basic_setting',true);
    $field_id = buatp_get_field_id_by_name($buatp_general_settings['buatp_type_field_selection']);
    $query = "SELECT user_id FROM ".$wpdb->base_prefix."bp_xprofile_data WHERE field_id = $field_id AND value = '$type_name'";
    $users = $wpdb->get_results($query,ARRAY_A);
    if(!count($users))
        return 0;
    foreach($users as $user) {
        $ids[$i++] = $user['user_id'];
    }
    return apply_filters('buatp_get_all_users_by_type',$ids);
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_current_page_type($return = 'page_id') {
    $buatp_general_settings = get_option('buatp_basic_setting',true);
    $current_page = (int)get_the_ID();
    if($_POST['action'] == 'members_filter')
    $current_page = $_COOKIE['buatp_current_page_id'];
    foreach((array)$buatp_general_settings as $index => $val){
       if(strpos($index, 'page_selection_for_'))	
           if($current_page == $val){
               if($return == 'page_id')
                   return $val;
               if($return == 'type_name')
                   return str_replace('buatp_page_selection_for_', '', $index);
           }          
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_filtered_members($return = 'exclude' , $type_name = '' , $query = '') {
    if(!$type_name)
        $type_name = buatp_current_page_type('type_name');
    if(!$type_name && $return != 'all')
        return;
    if(!$query)
        $query = 'type=alphabetical&per_page=false';
    $users = (array) buatp_get_all_users_by_type($type_name);
    if ( bp_has_members( $query ) ): 
        while ( bp_members() ) : bp_the_member(); $i++;
           if(!in_array(bp_get_member_user_id(), $users)) {
                   $excludes[$i] = (int)bp_get_member_user_id(); 
           }
           else { 
                    $includes[$i] = (int)bp_get_member_user_id();
           }
        endwhile;
    endif;
    if($return == 'exclude')
        return (array) $excludes;
    else if($return == 'include')
        return (array) $includes;
    else 
        return array_merge((array) $excludes , (array) $includes); 
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_field_data($field_name,$user_id){
    if(!$field_name || !$user_id)
        return;
   $data = xprofile_get_field_data( $field_name, $user_id , 'comma' );
   return $data;
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_user_type($user_id){
    $settings_basic = get_option('buatp_basic_setting',false);
    if(!$user_id || !$settings_basic)
        return;
    return buatp_get_field_data($settings_basic['buatp_type_field_selection'], $user_id);
}
//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_set_field_data($field_name,$user_id,$value){
    if(!$field_name || !$user_id)
        return;
    return xprofile_set_field_data($field_name,$user_id,$value,false);
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_update_user_role($user_id,$role) {
    if(!$user_id || !$role)
        return;
    $user = new WP_User( $user_id );
    $user->set_role($role);
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_user_role($user_id){
    if(!$user_id)
        return;
    $user = new WP_User( $user_id );
    return $user->roles[1];
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_prepare_url( $url = '' ){
    global $bp;
    if( !$url )
        return;
    if( $url == 'current' ){
    $url = $_SERVER['REQUEST_URI'];
    if(strpos( $url, '?'))
       $url = substr ($url, 0, strpos( $url, '?'));
    }
    $current_user = get_userdata($bp->displayed_user->id);
    if(function_exists('bp_get_current_group_slug'))
        $current_group_slug = bp_get_current_group_slug();
    $bp_components = array(
        '[user_name]' => $current_user->user_login,
        '[group_name]' => $current_group_slug
    );
    foreach( $bp_components as $code => $val ){
        if( strpos($url, $code )  && $val  )  {
            $url = str_replace ($code, $val, $url);
        }
    }
    return $url;
}

//////////////////////////////////////////////////////////////////////////////////////////////

function buatp_generate_fields($query = ''){
 $html = '';
 ob_start();
 if ( bp_has_profile( $query ) ) : while ( bp_profile_groups() ) : bp_the_profile_group();
        while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
            <div class="editfield">

                <?php if ( 'textbox' == bp_get_the_profile_field_type() ) : ?>

                        <label for="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
                        <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ) ?>
                        <input type="text" name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>" value="<?php bp_the_profile_field_edit_value() ?>" />

                <?php endif; ?>

                <?php if ( 'textarea' == bp_get_the_profile_field_type() ) : ?>

                        <label for="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
                        <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ) ?>
                        <textarea rows="5" cols="40" name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_edit_value() ?></textarea>

                <?php endif; ?>

                <?php if ( 'selectbox' == bp_get_the_profile_field_type() ) : ?>

                        <label for="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
                        <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ) ?>
                        <select name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>">
                                <?php bp_the_profile_field_options() ?>
                        </select>

                <?php endif; ?>

                <?php if ( 'multiselectbox' == bp_get_the_profile_field_type() ) : ?>

                        <label for="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
                        <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ) ?>
                        <select name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>" multiple="multiple">
                                <?php bp_the_profile_field_options() ?>
                        </select>

                <?php endif; ?>

                <?php if ( 'radio' == bp_get_the_profile_field_type() ) : ?>

                        <div class="radio">
                                <span class="label"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></span>

                                <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ) ?>
                                <?php bp_the_profile_field_options() ?>

                                <?php if ( !bp_get_the_profile_field_is_required() ) : ?>
                                        <a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name() ?>' );"><?php _e( 'Clear', 'buddypress' ) ?></a>
                                <?php endif; ?>
                        </div>

                <?php endif; ?>

                <?php if ( 'checkbox' == bp_get_the_profile_field_type() ) : ?>

                        <div class="checkbox">
                                <span class="label"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></span>

                                <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ) ?>
                                <?php bp_the_profile_field_options() ?>
                        </div>

                <?php endif; ?>

                <?php if ( 'datebox' == bp_get_the_profile_field_type() ) : ?>

                        <div class="datebox">
                                <label for="<?php bp_the_profile_field_input_name() ?>_day"><?php bp_the_profile_field_name() ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ) ?><?php endif; ?></label>
                                <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ) ?>

                                <select name="<?php bp_the_profile_field_input_name() ?>_day" id="<?php bp_the_profile_field_input_name() ?>_day">
                                        <?php bp_the_profile_field_options( 'type=day' ) ?>
                                </select>

                                <select name="<?php bp_the_profile_field_input_name() ?>_month" id="<?php bp_the_profile_field_input_name() ?>_month">
                                        <?php bp_the_profile_field_options( 'type=month' ) ?>
                                </select>

                                <select name="<?php bp_the_profile_field_input_name() ?>_year" id="<?php bp_the_profile_field_input_name() ?>_year">
                                        <?php bp_the_profile_field_options( 'type=year' ) ?>
                                </select>
                        </div>

                <?php endif; ?>

                <?php do_action( 'bp_custom_profile_edit_fields' ) ?>

                <p class="description"><?php bp_the_profile_field_description() ?></p>

        </div>
        
        <?php
        endwhile;
    endwhile;
 endif;
$html = ob_get_clean();  
return $html;
}

//////////////////////////////////////////////////////////////////////////////////////////////////

function buatp_get_content_error_messsage($type = ''){
    $access = get_option('buatp_access_setting', true);
    if(!$access['buatp_text_for_shortcode_restriction'])
        $text = "You are not permitted to see this content,only $type users can access it";
    else
        $text = str_replace ('[type_name]', $type, $access['buatp_text_for_shortcode_restriction']);
    return '<div class="buatp_content_error"><p>'.$text.'</p></div>';
}

//////////////////////////////////////////////////////////////////////////////////////////////////

function buatp_the_content_error_messsage($type = ''){
    echo buatp_get_content_error_messsage($type);
}

//////////////////////////////////////////////////////////////////////////////////////////////////

function buatp_reset_settings(){
    update_option('buatp_basic_setting','');
    update_option('buatp_profile_data_setting','');
    update_option( 'buatp_style_setting',''); 
    update_option( 'buatp_access_setting','');
}

//////////////////////////////////////////////////////////////////////////////////////////////

?>