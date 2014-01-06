<?php
function buatp_cookie_page_id(){
   $current_page = get_the_ID();
   ?>
    <script language="javascript" >
        var j = jQuery;
        j(document).ready(function(){
            j.cookie('buatp_current_page_id','<?php echo $current_page ?>', { path: '/'});
        });
    </script>
   <?php
   if(bp_get_current_signup_step() == 'request-details'):
       $settings = get_option('buatp_basic_setting',true);
       $field_name = $settings['buatp_type_field_selection'];
       $field_id = buatp_get_field_id_by_name($field_name);
   ?>
    <style type="text/css">
        img.buatp_ajax_loader {
            margin-left: 10px;
        }
    </style>
    
    <script type="text/javascript" >
        function load_conditionals(type_field){
            var initial_fields = j('#signup_profile_field_ids').val();
            j(type_field).each(function(){
               var val = j(this).val();
               if(!val)
                   return;
               j(this).after('<img class="buatp_ajax_loader" src = "<?php echo plugins_url('/lib/images/ajax-loader.gif',BUATP_LIB)?>" />');
               j.post(buatpJsVars.buatpAjaxUrl,{ 'action' : 'append-conditional-fields', 'type' : val },function(response){
                   j('.buatp_ajax_loader').remove();
                   if(!j('div').hasClass('conditional_fields'))
                       j(type_field).parent().after(response);
                   else
                       j('.conditional_fields').html(response);
                  var new_fields = new Object();
                  new_fields = j('#conditional_field_values').val().split(',');
                  j('#signup_profile_field_ids').val(initial_fields+','+new_fields.join(','));
                  }); 
            });
        }
        
        j(document).ready(function(){
            var type_field = '#field_<?php echo $field_id ?>';
            load_conditionals(type_field);
            j(type_field).live('change',function(){
                load_conditionals(type_field);
            });
        });
    </script>
   <?php
   endif;
}
add_action('wp_head','buatp_cookie_page_id',100);

///////////////////////////////////////////////////////////////////////////////////////
//                          Hooks to filter users
///////////////////////////////////////////////////////////////////////////////////////

function buatp_select_template(){
    if(is_admin() || !get_the_ID())
        return;
    $do_redirect = false;
    if( get_the_ID() == buatp_current_page_type()) {
        include_once( apply_filters('buatp_template',BUATP_TEMPLATE.'index.php') );
       $do_redirect = true;
    }
    if(!$do_redirect)
        return;
    die();
}
add_action('template_redirect','buatp_select_template');

///////////////////////////////////////////////////////////////////////////////////////

function buatp_display_numbers_of_user_filter($query , $object){
    if($object != 'members')
        return  $query;
    $settings = get_option('buatp_basic_setting',true);
    return $query.'&per_page='.$settings['buatp_users_per_page'];
}
add_filter('bp_dtheme_ajax_querystring','buatp_display_numbers_of_user_filter',2,2);
add_filter('bp_ajax_querystring','buatp_display_numbers_of_user_filter',2,2);

///////////////////////////////////////////////////////////////////////////////////////

function buatp_filter_users_by_type($query, $object){
    if($object != 'members')
        return $query;
    $excludes = buatp_get_filtered_members('exclude');
    $query = 'exclude='.implode(',',(array)$excludes).'&'.$query;
    return apply_filters('buatp_ajax_query_string',$query);
}
add_filter('bp_dtheme_ajax_querystring','buatp_filter_users_by_type',1001,2);
add_filter('bp_ajax_querystring','buatp_filter_users_by_type',1001,2);


///////////////////////////////////////////////////////////////////////////////////////
//                          Hooks to trigger roles
///////////////////////////////////////////////////////////////////////////////////////

function buatp_triger_existing_users(){
    $settings = get_option('buatp_basic_setting',true);
    if((int) $settings['buatp_is_triggerd'])
        return;
    $users = get_users();
    $excludes = explode(',',$settings['buatp_exclude_id_for_roles'] ? trim($settings['buatp_exclude_id_for_roles']) : 1);
    if($settings['buatp_default_type_selection']){
        $field_name = $settings['buatp_type_field_selection'];
        $field_id = buatp_get_field_id_by_name($field_name);
        $type_names = buatp_get_all_types($field_id);
        foreach((array)$type_names as $val){
            $excludes_from_type = array_merge((array)$excludes_from_type,buatp_get_filtered_members('include' , $val['name']),$excludes);
        }
        if($settings['buatp_manage_existing_users'] == 'default_type_to_all' || $settings['buatp_manage_existing_users'] == 'role_to_type'):
            foreach((array)$users as $user){
                if(in_array($user->ID, $excludes_from_type))
                    continue;
                if($settings['buatp_manage_existing_users'] == 'default_type_to_all'){
                    if(!buatp_get_field_data($field_name,$user->ID))
                    buatp_set_field_data($field_name,$user->ID,$settings['buatp_default_type_selection']);
                    $default = $settings['buat_default_type_selection'];
                    buat_update_user_role($user->ID,$settings['buat_role_selection_for_'.$default]);
                }
                if($settings['buatp_manage_existing_users'] == 'role_to_type'){
                        $role = buatp_get_user_role($user->ID);
                        $type = $settings['buatp_role_to_type_for_'.strtolower($role)];
                        if($type == 'false')
                            continue;
                        buatp_set_field_data($field_name,$user->ID,$type);
                }
            }
        endif;
        if($settings['buatp_change_all_existing_users_role'] == 'true'):
            foreach((array)$type_names as $val){
                if(!$settings['buatp_role_selection_for_'.$val['name']])
                    break;
                $users = buatp_get_filtered_members('include' , $val['name']);
                foreach((array)$users as $id){
                    if(in_array($id, $excludes) || is_super_admin($id))
                        continue;
                    buatp_update_user_role($id,$settings['buatp_role_selection_for_'.$val['name']]);
                }
            }
        endif;
    }
    
    $settings['buatp_is_triggerd'] = 1;
    update_option('buatp_basic_setting',$settings);  
}
add_action('buatp_trigger','buatp_triger_existing_users',1);

///////////////////////////////////////////////////////////////////////////////////////

function buatp_trigger_role_at_registration($user_id, $user_login, $user_password, $user_email, $usermeta){
    if(!$user_id)
        return;
    $settings = get_option('buatp_basic_setting',true);
    $field_name = $settings['buatp_type_field_selection'];
    $field_id = buatp_get_field_id_by_name($field_name);
    $type_name = $usermeta["field_$field_id"];
    if(!$settings['buatp_role_selection_for_'. $type_name])
        return;
    buatp_update_user_role($user_id,$settings['buatp_role_selection_for_'. $type_name]);
}
add_action('bp_core_signup_user','buatp_trigger_role_at_registration',10,5);

///////////////////////////////////////////////////////////////////////////////////////

function buatp_trigger_role_at_profile_update(){
    global $bp;
    $settings = get_option('buatp_basic_setting',true);
    if($settings['buatp_can_user_change_type'] == 'false' || apply_filters('buatp_trigger_role_at_profile_update_return', false) )
        return;
    $user_id = $bp->displayed_user->id;
    $excludes = explode(',',$settings['buatp_exclude_id_for_roles'] ? trim($settings['buatp_exclude_id_for_roles']) : 1);
    if(in_array($user_id,$excludes) || is_super_admin($user_id))
        return;
    $field_name = $settings['buatp_type_field_selection'];
    $type_name = buatp_get_field_data($settings['buatp_type_field_selection'], $user_id);
    buatp_update_user_role($user_id,$settings['buatp_role_selection_for_'. $type_name]);
}
add_action('xprofile_screen_edit_profile','buatp_trigger_role_at_profile_update');

///////////////////////////////////////////////////////////////////////////////////////

function buatp_protect_chaging_type_by_force($field_id){
    global $bp;
    $settings = get_option('buatp_basic_setting',true);
    if( $bp->current_action != 'edit' && $bp->current_component != 'profile' )
        return $field_id;
    if(current_user_can('create_users'))
        return $field_id;
    $type_field =  $settings['buatp_type_field_selection'];
    $type_field_id = buatp_get_field_id_by_name($type_field);
   
     if( $settings['buatp_can_user_change_type'] == 'false' && $type_field_id == $field_id)
         return false;
     return $field_id;
}
add_filter('xprofile_data_field_id_before_save','buatp_protect_chaging_type_by_force',1,1);

///////////////////////////////////////////////////////////////////////////////////////
//                          Hooks to filter profile fields
///////////////////////////////////////////////////////////////////////////////////////

function buatp_profile_groups_exclude_from_view(){
    global $bp, $profile_template;
    $settings_profile_data = get_option('buatp_profile_data_setting',false);
    if(!$settings_profile_data)
        return false;
    $user_id = $bp->displayed_user->id;
    if(current_user_can('create_users'))
        return;
    $user_type = buatp_get_user_type($user_id);
    $excluded = $settings_profile_data['buatp_exclude_groups_for_'.$user_type];
    if(!$excluded)
        return;
    foreach($profile_template->groups as $key => $profile_group) {
      if( in_array($profile_group->id, (array)$excluded) ) {
        unset($profile_template->groups[$key]);
      }
    }    
}

///////////////////////////////////////////////////////////////////////////////////////

function buatp_profile_groups_exclude_from_edit(){
    global $bp;
    $settings_profile_data = get_option('buatp_profile_data_setting',false);
    if(!$settings_profile_data)
        return false;
    $user_id = $bp->loggedin_user->id;
    if(current_user_can('create_users'))
        return;
    $user_type = buatp_get_user_type($user_id);
    $excluded = $settings_profile_data['buatp_exclude_groups_for_'.$user_type];
    if(!$excluded)
        return;
    if( in_array($bp->action_variables[1], (array)$excluded) ) {
        bp_core_redirect( $bp->displayed_user->domain . BP_XPROFILE_SLUG . '/edit/group/1' );
    }    
}

///////////////////////////////////////////////////////////////////////////////////////

function buatp_profile_groups_exclude_from_tab(){
    global $bp, $profile_template;
    $settings_profile_data = get_option('buatp_profile_data_setting',false);
    if(!$settings_profile_data)
        return false;
    $user_id = $bp->displayed_user->id;
    if(current_user_can('create_users'))
        return;
    $user_type = buatp_get_user_type($user_id);
    $excluded = $settings_profile_data['buatp_exclude_groups_for_'.$user_type];
    if(!$excluded)
        return;
    $groups = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
    foreach($groups as $key => $profile_group) {
      if( in_array($profile_group->id, (array)$excluded) ) {
        unset($groups[$key]);
      }
    }
    $groups = array_values($groups);
    wp_cache_set( 'xprofile_groups_inc_empty', $groups, 'bp' );
}

///////////////////////////////////////////////////////////////////////////////////////


function buatp_profile_groups_exclude(){
    add_action('xprofile_screen_edit_profile', 'buatp_profile_groups_exclude_from_edit');
    add_action('xprofile_template_loop_start', 'buatp_profile_groups_exclude_from_view');
    add_action('bp_before_profile_field_content', 'buatp_profile_groups_exclude_from_tab');
}

add_action('bp_init', 'buatp_profile_groups_exclude');

///////////////////////////////////////////////////////////////////////////////////////


function buatp_fields_exclution($fields,$id){
    global $bp;
    $settings_basic = get_option('buatp_basic_setting',true);
    $settings_profile_data = get_option('buatp_profile_data_setting',true);
    
    if(!$settings_basic['buatp_default_type_selection'] || $_POST['action'] == 'append_conditional_fields')
        return $fields;
    $field_name = $settings_basic['buatp_type_field_selection'];
    $field_id = buatp_get_field_id_by_name($field_name);
    $type_names = buatp_get_all_types($field_id);
    foreach((array)$type_names as $val){
        if( bp_is_current_action( 'edit' ) || bp_is_current_action( 'public' )){
            $user_id = $bp->displayed_user->id;
            if(is_super_admin($bp->loggedin_user->id))
                return $fields;
            $user_type = buatp_get_field_data($settings_basic['buatp_type_field_selection'], $user_id);
            if($user_type == $val['name']){
                $excludes_arr = (array)$settings_profile_data['buatp_exclude_fields_for_'.$val['name']];
                
            }
        }
        if('request-details' == bp_get_current_signup_step()){
            $excludes_arr = array_merge((array)$excludes_arr,(array)$settings_profile_data['buatp_exclude_fields_for_'.$val['name']]);
        }
    }
    if($settings_basic['buatp_can_user_change_type'] == 'false' 
        && !is_super_admin($bp->loggedin_user->id) && bp_get_current_signup_step() != 'request-details'
        && apply_filters('buatp_show_type_field_condition', true)
        && $bp->current_action == 'edit' && $bp->current_component == 'profile'
        )
        $excludes_arr = array_merge ((array)$excludes_arr,array($field_name));
    
    $excludes = array();
    foreach((array)$excludes_arr as $names){
        $excludes[$i++] = buatp_get_field_id_by_name($names);
    }
    $field_info = $fields;
    foreach((array)$field_info as $index => $field){
        if(in_array($field->id, $excludes) ) {
            unset($fields[$index]);
        }
    }
    return apply_filters('buatp_fields_exclution',array_merge((array)$fields));
}

add_filter('xprofile_group_fields','buatp_fields_exclution',10,2);

///////////////////////////////////////////////////////////////////////////////////////

function buatp_type_exclusion( $html, $option , $field_id ){
    if( current_user_can('create_users'))
        return $html;
    $settings_profile_data = get_option('buatp_profile_data_setting',true);
    $settings_basic = get_option('buatp_basic_setting',true);
    $type_field = buatp_get_field_id_by_name($settings_basic['buatp_type_field_selection']);
    $excludes = (array) $settings_profile_data['buatp_exclude_types_to_select_own'];
    if( $type_field != $field_id ){
        return $html;
    } else {
        if( !in_array($option->name, $excludes))
            return $html;
    }
    
}
add_action('bp_get_the_profile_field_options_select','buatp_type_exclusion',1,3);

///////////////////////////////////////////////////////////////////////////////////////

function buatp_member_count($count){
    if(!buatp_get_dir_name())
        return $count;
    return count(buatp_get_all_users_by_type(buatp_get_dir_name()));
}
add_filter('bp_get_total_member_count','buatp_member_count',100);

function buatp_print_before_members_loop(){
    echo '<div id="buatp_members" class="'.apply_filters('buatp_members_dir_class','list_view').'">';
}
add_action('bp_before_members_loop','buatp_print_before_members_loop',1);

///////////////////////////////////////////////////////////////////////////////////////

function buatp_print_after_members_loop(){
    echo '</div>';
}
add_action('bp_after_members_loop','buatp_print_after_members_loop',1);

///////////////////////////////////////////////////////////////////////////////////////
//                          Hooks to Styling
///////////////////////////////////////////////////////////////////////////////////////

function buatp_styling(){
    global $bp;
    $settings_style = get_option('buatp_style_setting',true);
    $setting_active = $settings_style['buatp_tyle_elable'];
    if($setting_active == 'false')
        return;
    add_action('bp_directory_members_actions','buatp_include_fields_at_loop',1);
    add_filter('bp_member_avatar','buatp_set_default_avatar_size');
    add_action('bp_members_directory_member_sub_types','buatp_add_grid_list_button',1);
    add_filter('buatp_members_dir_class','buatp_default_view',1,1);
    add_action('wp_head','buatp_custom_style',201);
}
add_action('bp_loaded','buatp_styling');
///////////////////////////////////////////////////////////////////////////////////////

function buatp_include_the_fields_at_loop(){
    $settings_profile_data = get_option('buatp_profile_data_setting',true);
    $fields_per_col = $settings_profile_data['buatp_fields_for_profile_loop_per_column'];
    $fields = (array) $settings_profile_data['buatp_fields_for_profile_loop'];
    $html = '<div id="buatp_col_0" class="buatp_loop_column">';
    foreach((array)$fields as $name){
        $field_id = buatp_get_field_id_by_name($name);
        $user_id = (int) bp_get_member_user_id();
        $value = buatp_get_field_data($name,$user_id);
        if($value) {
            $count++;
            $html.= "<p id='field_$field_id'><span class='fname'><strong>$name:&nbsp</strong></span><span class='fval'>$value</span></p>";
            if($count == $fields_per_col) {
                $html .= '</div><div id="buatp_col_'.++$col.'" class="buatp_loop_column">';
                $count = 0;
            }
        }
    }
    $html = '<div id="buatp_loop_fields">'.$html;
    $html .= '</div><div style="clear:both"></div></div>';
    return $html;
}

///////////////////////////////////////////////////////////////////////////////////////

function buatp_include_fields_at_loop(){
    echo buatp_include_the_fields_at_loop();    
}

///////////////////////////////////////////////////////////////////////////////////////

function buatp_set_default_avatar_size($avatar = '',$custom = ''){
    return apply_filters( 'buatp_set_default_avatar_size', bp_get_member_avatar( 'type=full&id='.(int)bp_get_member_user_id().$custom ) );
}

///////////////////////////////////////////////////////////////////////////////////////

function buatp_add_grid_list_button(){
    $settings_style = get_option('buatp_style_setting',true);
    if( $settings_style['buatp_allow_to_change_view'] != 'on' )
        return;
    $html = '<div id="buat_view_mode">
            <img src="'.plugins_url('/lib/images/grid_16_2.png', BUATP_LIB).'" id="grid_view" class="'.do_action('buatp_grid_view').'" />
            <img src="'.plugins_url('/lib/images/list_16.png', BUATP_LIB).'" id="list_view" class="'.do_action('buatp_list_view').'" />
            </div>';
    echo $html;
}

///////////////////////////////////////////////////////////////////////////////////////

function buatp_default_view($view){
    $settings_style = get_option('buatp_style_setting',true);
    if( $settings_style['buatp_default_view'] == 'Grid' ){
        //add_action('buatp_grid_view', function(){ echo 'current_view'; },1);
        return 'grid_view';
     } else {
        //add_action('buatp_list_view', function(){ echo 'current_view'; },1);
        return $view;
     }
}

///////////////////////////////////////////////////////////////////////////////////////

function buatp_custom_style(){
    $styles = get_option('buatp_style_setting',true);
    echo '<style type="text/css">';
    if($styles['buatp_grid_view_thumb_size'])
        echo ' #buatp_members.grid_view ul.item-list li 
                { height: '.$styles['buatp_grid_view_thumb_size'].'px; 
                  width: '.$styles['buatp_grid_view_thumb_size'].'px }';
    if($styles['buatp_grid_view_avatar_size'])
        echo ' #buatp_members.grid_view ul.item-list li .avatar 
                { height: '.$styles['buatp_grid_view_avatar_size'].'px; 
                  width: '.$styles['buatp_grid_view_avatar_size'].'px }';
    
    if($styles['buatp_grid_view_mergin'])
        echo ' #buatp_members.grid_view ul.item-list li 
                { margin-right: '.$styles['buatp_grid_view_mergin'].'px; 
                  margin-tor: '.$styles['buatp_grid_view_mergin'].'px }';
    if($styles['buatp_grid_view_thumb_border'])
        echo ' #buatp_members.grid_view ul.item-list li 
                { border-width: '.$styles['buatp_grid_view_thumb_border'].'px; }';
    if($styles['buatp_grid_view_thumb_border_color'])
        echo ' #buatp_members.grid_view ul.item-list li 
                { border-color: '.$styles['buatp_grid_view_thumb_border_color'].'; }';
    if(trim($styles['buatp_grid_view_thumb_border']) == 'none')
        echo ' #buatp_members.grid_view ul.item-list li 
                { border: none; }';
    if($styles['buatp_grid_view_thumb_border_color']) {
        if(!in_array('Last active',(array) $styles['buatp_elements_grid_view']))
            echo ' #buatp_members.grid_view ul.item-list li span.activity
                { display: none; }';
        if(!in_array('name',(array) $styles['buatp_elements_grid_view']))
            echo ' #buatp_members.grid_view ul.item-list li .item-title
                { display: none; }';
        
        if(!in_array('Avatar',(array) $styles['buatp_elements_list_view']))
            echo ' #buatp_members.list_view ul.item-list li .avatar
                { display: none; }';
        if(!in_array('name',(array) $styles['buatp_elements_list_view']))
            echo ' #buatp_members.list_view ul.item-list li .item-title
                { display: none; }';
        if(!in_array('Last active',(array) $styles['buatp_elements_list_view']))
            echo ' #buatp_members.list_view ul.item-list li span.activity
                { display: none; }';
        if(!in_array('BuddyPress User Account Type custom fields',(array) $styles['buatp_elements_list_view']))
            echo ' #buatp_members.list_view ul.item-list li #buatp_loop_fields
                { display: none; }';
        if(!in_array('Add/Remove friend button',(array) $styles['buatp_elements_list_view']))
            echo ' #buatp_members.list_view ul.item-list li .friendship-button
                { display: none; }';
                
    }
    
    echo '</style>';
}

///////////////////////////////////////////////////////////////////////////////////////
//                          Hooks to page restriction
///////////////////////////////////////////////////////////////////////////////////////

function buatp_page_restriction(){
    global $bp;
    $page_id = get_the_ID();
    $current_url = buatp_prepare_url('current');
    if(!$page_id)
        return;
    $access = get_option('buatp_access_setting', true);
    $current_basic_setting = get_option('buatp_basic_setting',true);
    $field_name = $current_basic_setting['buatp_type_field_selection'];
    $field_id = buatp_get_field_id_by_name($field_name);
    $type_names = buatp_get_all_types($field_id);
    if(!$field_name){
        return;
    }
    if(!$access['buatp_restrict_redirect_general']){
        return;
    }
    foreach((array)$type_names as $val) {
        $user_type = $val['name'];
        $pages = explode(',',trim($access['buatp_restrict_page_for_'.$user_type]));
        $url = preg_split('/[\r\n]+/', buatp_prepare_url(trim($access['buatp_restrict_url_for_'.$user_type])), -1, PREG_SPLIT_NO_EMPTY);
        $urls = array_merge((array) $urls, (array) $url ) ;
        
    
        $all_restricted_pages = array_merge( (array) $all_restricted_pages,(array) $pages, (array) $urls );
        if($access['buatp_restrict_page_for_'.$val['name']] || count( $urls ) ) { 
            $resricted = true;
         }
    }
    if(( $current_url && in_array($current_url, $all_restricted_pages ) ) ) {
        $url_redirect = true;       
    }
    if( !in_array($page_id, $all_restricted_pages ) && !$url_redirect ) { 
        return;
    }
    if(!is_user_logged_in() &&  $resricted ) {
        wp_redirect(get_permalink($access['buatp_restrict_redirect_general']),302);
        return;
    }
    $do_redirect = false;
    $user_id = $bp->loggedin_user->id;
    $current_user_type = buatp_get_field_data($field_name,$user_id);
    if( current_user_can('edit_post', $page_id) || current_user_can('create_users') || is_super_admin($user_id))
        return;
    foreach((array)$type_names as $val) {
        $user_type = $val['name'];
        $page_arr = explode(',',trim($access['buatp_restrict_page_for_'.$user_type]));
        $url = (array)preg_split('/[\r\n]+/', buatp_prepare_url(trim($access['buatp_restrict_url_for_'.$user_type])), -1, PREG_SPLIT_NO_EMPTY);
        if(in_array($current_url, $url) && $user_type == $current_user_type ) {
                    $do_redirect = true;
                    $redirect_to = $access['buatp_restrict_redirect_for_'.$user_type];
                    break;
                    
        }
        if(in_array($page_id, $page_arr) && $user_type == $current_user_type ) {
                    $do_redirect = true;
                    $redirect_to = $access['buatp_restrict_redirect_for_'.$user_type];
                    break;
                    
        }
    }
    if($do_redirect)
        wp_redirect(get_permalink($redirect_to),302);
    return;
}
add_action('wp','buatp_page_restriction',1);
add_action('bp_core_pre_load_template','buatp_page_restriction',1);


///////////////////////////////////////////////////////////////////////////////////////

function buatp_shotcodes($attr, $content = '') {
   global $bp;
   $setting = get_option('buatp_basic_setting',true);
   $defaults = array(
       'user_type' => false,
       'include' => false, 
       'exclude' => false
   );
   if(!$content)
     $defaults = array_merge($defaults,array(
         'arrange_by' => 'active',
         'max' => 10,
     ));
    extract( shortcode_atts( $defaults , $attr ) );
    $user_type = trim($user_type);
    $include = trim($include);
    $exclude = trim($exclude);
    if($user_type)
       $types = explode (',',$user_type);
   if($content) {
       if(!$user_type && !$include)
           return $content;
       if(!is_user_logged_in())
           return buatp_get_content_error_messsage($user_type);
       $user_id = $bp->loggedin_user->id;
       if(current_user_can('edit_post', get_the_ID()) || current_user_can('create_users') || is_super_admin($user_id))
           return $content;
       
           $loggedin_user_type = buatp_get_field_data( $setting['buatp_type_field_selection'], $user_id );
           if(( in_array($loggedin_user_type, $types) || in_array($user_id, explode(',', $include))) && !in_array($user_id, explode(',',$exclude)) ) 
               return $content;
           else
               return buatp_get_content_error_messsage($user_type);
   }else {
       $query = '';
       foreach((array) $types as $name) {
           $users = array_merge((array)$users, buatp_get_filtered_members('exclude' , $name));
       }
       $query .= $exclude ? "exclude=$exclude,".implode(',', (array)$users) : "exclude=".implode(',',(array) $users);
       if($arrange_by)
           $query .= '&type='.$arrange_by;
       if($max)
           $query .= '&max='.$max;
      
       ob_start();
       
       //////////////////////////////////////////////////////////////////////////////////////////////////
       
 ?>      
                <?php do_action( 'bp_before_members_loop' ); ?>

                <?php if ( bp_has_members( $query ) ) : ?>



                        <div id="pag-top" class="pagination">

                                <div class="pag-count" id="member-dir-count-top">

                                        <?php bp_members_pagination_count(); ?>

                                </div>

                                <div class="pagination-links" id="member-dir-pag-top">

                                        <?php bp_members_pagination_links(); ?>

                                </div>
                            <?php echo '<div id="buat_view_mode">
                                <img src="'.plugins_url('/lib/images/grid_16_2.png', BUATP_LIB).'" id="grid_view" class="'.do_action('buatp_grid_view').'" />
                                <img src="'.plugins_url('/lib/images/list_16.png', BUATP_LIB).'" id="list_view" class="'.do_action('buatp_list_view').'" />
                                </div>'
                        ?>
                        </div>
                        
                        <?php do_action( 'bp_before_directory_members_list' ); ?>

                <ul id="members-list" class="item-list" role="main" style="margin: 0">

                        <?php while ( bp_members() ) : bp_the_member(); ?>

                                <li>
                                        <div class="item-avatar">
                                                <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
                                        </div>

                                        <div class="item">
                                                <div class="item-title">
                                                        <a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>

                                                        <?php if ( bp_get_member_latest_update() ) : ?>

                                                                <span class="update"> <?php bp_member_latest_update(); ?></span>

                                                        <?php endif; ?>

                                                </div>

                                                <div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>

                                                <?php do_action( 'bp_directory_members_item' ); ?>

                                                <?php
                                                 /***
                                                  * If you want to show specific profile fields here you can,
                                                  * but it'll add an extra query for each member in the loop
                                                  * (only one regardless of the number of fields you show):
                                                  *
                                                  * bp_member_profile_data( 'field=the field name' );
                                                  */
                                                ?>
                                        </div>

                                        <div class="action">

                                                <?php do_action( 'bp_directory_members_actions' ); ?>

                                        </div>

                                        <div class="clear"></div>
                                </li>

                        <?php endwhile; ?>

                        </ul>

                        <?php do_action( 'bp_after_directory_members_list' ); ?>

                        <?php bp_member_hidden_fields(); ?>

                        <div id="pag-bottom" class="pagination">

                                <div class="pag-count" id="member-dir-count-bottom">

                                        <?php bp_members_pagination_count(); ?>

                                </div>

                                <div class="pagination-links" id="member-dir-pag-bottom">

                                        <?php bp_members_pagination_links(); ?>

                                </div>

                        </div>

                <?php else: ?>

                        <div id="message" class="info">
                                <p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
                        </div>

                <?php endif; ?>

                <?php do_action( 'bp_after_members_loop' ); ?>
    
<?php
       
       ///////////////////////////////////////////////////////////////////////////////////////////////////
       $html = ob_get_clean();
       return $html;
       
   }
   
}
add_shortcode('buatp','buatp_shotcodes')
?>