<?php
class buatp_admin_options {

    private $settings_api;
    
    var $buatp_basic_setting;
    var $buatp_profile_data_setting;
    var $buatp_style_setting;
    var $buatp_access_setting;
    var $buatp_type_field;
    var $buatp_type_field_id;
    var $all_type_info;
    var $type_array;
    var $page_array;
    var $exclude_fields_array;
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function __construct() {
        $this->settings_api = WpBpShop_Settings_API::getInstance();
        $this->buatp_basic_setting = get_option('buatp_basic_setting',true);
        $this->buatp_profile_data_setting = get_option('buatp_profile_data_setting',true);
        $this->buatp_style_setting = get_option('buatp_style_setting',true);
        $this->buatp_access_setting = get_option('buatp_access_setting',true);
        
        $this->buatp_type_field = $this->buatp_basic_setting['buatp_type_field_selection'];
        if(isset($_POST['buatp_selected_field'])) {
                $this->buatp_type_field = $_POST['buatp_selected_field'];
        }
        add_action( 'admin_init', array($this, 'admin_init') );
        if(!is_multisite())
        add_action('admin_menu', array($this, 'admin_menu'));
        if(is_multisite())
        add_action('network_admin_menu', array($this, 'admin_menu'));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function admin_menu() {
        add_menu_page('Buddypress user account type', 'BUAT PRO settings', apply_filters( 'buatp_settings_visibility', 10 ), 'buddypress_user_account_type_pro_settings', array($this, 'plugin_page') );
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'buatp_basic_setting',
                'title' => __( 'Basic Settings', 'buatp' )
            ),
            array(
                'id' => 'buatp_profile_data_setting',
                'title' => __( 'Profile Data Settings', 'buatp' )
            ),
            array(
                'id' => 'buatp_style_setting',
                'title' => __( 'Style Settings', 'buatp' )
            ),
            array(
                'id' => 'buatp_access_setting',
                'title' => __( 'Access Management and Shortcodes', 'buatp' )
            )
        );
        return $sections;
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function get_settings_fields() {
        $this->buatp_set_all_type_info();
        $this->buatp_set_option_arrays();
        do_action('buatp_before_save_basic_data');        
        $settings_fields = array(
            'buatp_basic_setting' => $this->buatp_basic_setting_page(),
            'buatp_profile_data_setting' => $this->buatp_profile_data_setting_page(),
            'buatp_style_setting' => $this->buatp_style_setting_page(),
            'buatp_access_setting' => $this->buatp_access_setting_page()
        );

        return $settings_fields;
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function buatp_set_all_type_info(){
        $this->all_type_info = buatp_get_all_types( buatp_get_field_id_by_name( $this->buatp_type_field ) );
        $this->buatp_type_field_id = buatp_get_field_id_by_name( $this->buatp_type_field );
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function buatp_set_option_arrays(){
        foreach((array)$this->all_type_info as $val){
            $all_excludeds = array_merge((array)$all_excludeds,(array)$this->buatp_profile_data_setting['buatp_exclude_fields_for_'.$val['name']]);
            $arr[$val['name']] = $val['name'];
        }
        
        $pages = get_pages(array ('sort_order' => 'ASC','post_type' => 'page','post_status' => 'publish','sort_column' => 'post_title'));
        $page_list_arr['0'] = '-------------'; 
        foreach($pages as $page) {
            $page_list_arr[$page->ID] = $page->post_title;
        }
        $this->type_array = $arr;
        $this->page_array = $page_list_arr;
        $this->exclude_fields_array = $all_excludeds;
        
    }
   
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function buatp_basic_setting_page(){
        $setting_fields = array();
        $setting_fields = array( 
            array(
                    'name' => 'buatp_type_field_selection',
                    'class' => 'buatp_type_field_selection',
                    'label' => __( 'Select type defining field', 'buatp' ),
                    'desc' => __( 'User will select his/her own type during registration, which field will define user types', 'buatp' ),
                    'type' => 'select',
                    'options' => array_merge(array('null' => '------'),buatp_get_all_select_box_fields()) 
                )
        );
        
        if(isset($_POST['buatp_default_type_selection'])){
            $this->buatp_basic_setting['buatp_default_type_selection'] = $_POST['buatp_default_type_selection'];
            $this->buatp_basic_setting['buatp_is_triggerd'] = 0;
        }
        if(isset($_POST['buatp_selected_field']) || $this->buatp_basic_setting['buatp_default_type_selection'])
            $not_configured = true;
        else
            $not_configured = false;
        if($not_configured) {
            $field_name = $this->buatp_basic_setting['buatp_type_field_selection'];
            if(isset($_POST['buatp_selected_field'])) {
                $field_name = $_POST['buatp_selected_field'];
                $this->buatp_type_field_id = buatp_get_field_id_by_name($field_name);
            }
            $this->buatp_basic_setting['buatp_type_field_selection'] = $field_name;
            $this->buatp_update_option('buatp_basic_setting', $this->buatp_basic_setting);
            $this->buatp_set_all_type_info();
            
            foreach((array)$this->all_type_info as $val) {
                $i++;
                $page_list[$i] = array(
                    'name' => 'buatp_page_selection_for_'.$val['name'],
                    'class' => 'buatp_page_selection_for_'.$val['name'],
                    'label' => __( sprintf('Select page to show <strong>%1$s</strong> type users', $val['name']), 'buatp' ),
                    'desc' => __( sprintf('<strong>%1$s</strong> type users list will be shown in this page', $val['name']), 'buatp' ),
                    'type' => 'select',
                    'options' =>  $this->page_array,
                );
                $roles_list[$i] = array(
                    'name' => 'buatp_role_selection_for_'.$val['name'],
                    'class' => 'buatp_role_selection_for_'.$val['name'],
                    'label' => __( sprintf('Select role for <strong>%1$s</strong> type users', $val['name']), 'buatp' ),
                    'desc' => __( sprintf('<strong>%1$s</strong> type users role, by default,subscriber ', $val['name']), 'buatp' ),
                    'type' => 'select',
                    'options' =>  buatp_get_all_roles()  
                );
            }
            
            if( !$this->buatp_basic_setting['buatp_manage_existing_users'] ):
            $exisiting_roles = array(
                    array(
                    'name' => 'buatp_manage_existing_users',
                    'class' => 'buatp_manage_existing_users',
                    'label' => __( 'Whats about existing users?', 'buatp' ),
                    'desc' => __( 'What you want to do with exisitng users, you may assign then all to default type,<br>
                                   or can change type according to their role','buatp' ),
                    'type' => 'radio',
                    'options' => array(
                            'false' => 'Do Nothing',
                            'role_to_type' => 'Assign type according to role',
                            'default_type_to_all' => 'Assign default type to all',
                            )
                     ),
                );
            
            foreach( buatp_get_all_roles() as $role ) {
                $j++;
                $options = array_merge(array('false' => '----------'),buatp_get_all_types($this->buatp_type_field_id,'name','single'));
                $exisiting_roles_to_type[$j] = array(
                    'name' => 'buatp_role_to_type_for_'.strtolower($role),
                    'class' => 'buatp_role_to_type_for_'.$role.' buatp_role_to_type',
                    'label' => __( sprintf('Select type for <strong>%1$s</strong> users', $role), 'buatp' ),
                    'desc' => __( sprintf('<strong>%1$s</strong> users will be converted to seleted type', $role), 'buatp' ),
                    'type' => 'select',
                    'options' => $options,
                    'default' => 'false'
                );
            }
            $exisiting_roles = array_merge($exisiting_roles,$exisiting_roles_to_type);
            else:
                $exisiting_roles = array(
                    array(
                        'name' => 'buatp_change_all_existing_users_role',
                        'class' => 'buatp_change_all_existing_users_role',
                        'label' => __( sprintf('Change current users role according to type', $role), 'buatp' ),
                        'desc' => __( sprintf('You can update current user roles depanding on user type, that you selected before', $role), 'buatp' ),
                        'type' => 'select',
                        'options' => array('true'=>'Yes','false' => 'No'),
                        'default' => 'false'
                ),
                    array(
                        'name' => 'buatp_manage_existing_users',
                        'class' => 'buatp_manage_existing_users',
                        'type' => 'hidden',
                        'value' => 'false'
                        ),
                );
            endif;
            
            $conditionals = array(
                'name' => 'buatp_default_type_selection',
                'class' => 'buatp_default_type_selection',
                'label' => __( 'Select default type', 'buatp' ),
                'desc' => __( 'User will obtain this type by default', 'buatp' ),
                'type' => 'select',
                'options' => $this->type_array,
            );
            
            
            $more_basic_fields = array(
                
                array(
                'name' => 'buatp_exclude_id_for_roles',
                'class' => 'buatp_exclude_id_for_roles',
                'label' => __( 'Exclude IDs from change role<br>( comma sapareted )', 'buatp' ),
                'desc' => __( '<br>You may exclude some ids to prevent them from changing roles,admin\'s id (1) will be excluded bu default','buatp' ),
                'type' => 'text',
                'default' => '1'
                ),
                array(
                'name' => 'buatp_users_per_page',
                'class' => 'buatp_users_per_page',
                'label' => __( 'Users to display per page', 'buatp' ),
                'desc' => __( '<br>By default, BuddyPress shows 10 users per page, how many users you want to show per page?','buatp' ),
                'type' => 'text',
                'default' => '10'
                ),
                array(
                'name' => 'buatp_can_user_change_type',
                'class' => 'buatp_can_user_change_type',
                'label' => __( 'Can user change type after registration?', 'buatp' ),
                'desc' => __( 'User may change own type after registration from his/her buddypress profile, Do you want to allow this? By default, No
                            <br> If you select \'No\', Then, only <strong>site admin</strong> can view or change user type','buatp' ),
                'type' => 'radio',
                'options' => array(
                        'true' => 'Yes',
                        'false' => 'No',
                        ),
                 'default' => array('false' => 'No')
                 ),
                array(
                'name' => 'buatp_is_triggerd',
                'class' => 'buatp_is_triggerd',
                'type' => 'hidden',
                'value' => 0
                ),
                
            );
            
            $setting_fields = array_merge($setting_fields,array($conditionals));
            $setting_fields = array_merge($setting_fields,$page_list,$roles_list,(array)$exisiting_roles, $more_basic_fields);
            
        }
        return (array)$setting_fields;
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function buatp_profile_data_setting_page(){
        $setting_fields = array();
        $setting_fields = array(
            array(
                'name' => 'buatp_exclude_types_to_select_own',
                'class' => 'buatp_exclude_types_to_select_own',
                'label' => __( sprintf('Exclude type selection from user'), 'buatp' ),
                'desc' =>  __( sprintf('You may limit type selection for users,excluded types will not visible to users, 
                                <br>so they cant change to this type themself,but admin can change'), 'buatp' ),
                'type' => 'multicheck',
                'options' => $this->type_array,
                'before' => '<div class="checkbox_container">',
                'after' => '</div>',
            )
        );
        
        foreach((array)$this->all_type_info as $val) {
              $j++;
              if(count(buatp_get_all_profile_groups())){
              $groupss_list[$j] = array(
                    'name' => 'buatp_exclude_groups_for_'.$val['name'],
                    'class' => 'buatp_exclude_groups_for_'.$val['name'],
                    'label' => __( sprintf('Exclude Profile groups for <strong>%1$s</strong> type users', $val['name']), 'buatp' ),
                    'desc' =>  __( sprintf('<strong>%1$s</strong> type users can not access these excluded groups, 
                                    All fields in these groups are not visible and not editable to users.
                                    <br>Admin can view and edit only
                                    <br> Default: none', $val['name']), 'buatp' ),
                    'type' => 'multicheck',
                    'options' => buatp_get_all_profile_groups(),
                    'before' => '<div class="checkbox_container">',
                    'after' => '</div>',  
                );
              }
              $fields_list[$j] = array(
                    'name' => 'buatp_exclude_fields_for_'.$val['name'],
                    'class' => 'buatp_exclude_fields_for_'.$val['name'],
                    'label' => __( sprintf('Exclude fields for <strong>%1$s</strong> type users', $val['name']), 'buatp' ),
                    'desc' =>  __( sprintf('<strong>%1$s</strong> type users can not access these excluded fields from his/her buddypress profile', $val['name']), 'buatp' ),
                    'type' => 'multicheck',
                    'options' => buatp_get_all_fields("WHERE parent_id = 0 AND ID!=$this->buatp_type_field_id"),
                    'before' => '<div class="checkbox_container">',
                    'after' => '</div>',  
                );
              $fields_list_reg[$j] = array(
                    'name' => 'buatp_include_fields_at_registration_for_'.$val['name'],
                    'class' => 'buatp_include_fields_at_registration_for_'.$val['name'],
                    'label' => __( sprintf('Include fields for <strong>%1$s</strong> type users at registration form', $val['name']), 'buatp' ),
                    'desc' =>  __( sprintf('<strong>%1$s</strong> type users can fill up these included fields during registration. These fields will be shown after selecting type.', $val['name']), 'buatp' ),
                    'type' => 'multicheck',
                    'options' => array_merge((array) $this->exclude_fields_array,
                                             (array) buatp_get_all_fields("WHERE parent_id = 0 AND ID!=$this->buatp_type_field_id AND group_id > 1") ),
                    'before' => '<div class="checkbox_container">',
                    'after' => '</div>',  
                );
        
        }
        $more_profile_data_fields = array(
                array(
                'name' => 'buatp_fields_for_profile_loop',
                'class' => 'buatp_fields_for_profile_loop',
                'label' => __('Select fields to show in profile loop', 'buatp' ),
                'desc' =>  __(sprintf('You may add some fields to show in members directory beside the member\'s avatar. Demo:<br>
                              <div id="buatp_members"><img class="demo_member" src="%1s" /></div>',  plugins_url('lib/images/loop-field-demo.png',BUATP_LIB)), 'buatp' ),
                'type' => 'multicheck',
                'options' => buatp_get_all_fields(),
                'before' => '<div class="checkbox_container">',
                'after' => '</div>', 
                ),
                array(
                'name' => 'buatp_fields_for_profile_loop_per_column',
                'class' => 'buatp_fields_for_profile_loop_per_column',
                'label' => __( 'Number of fileds per column', 'buatp' ),
                'desc' => __( '<br>How many fields you want to show in a column in members directory, default is 3,
                            <br>column will increase automatically when fields available','buatp' ),
                'type' => 'text',
                'default' => '3'
                ),
            );
        $setting_fields = array_merge($setting_fields,(array)$groupss_list,(array)$fields_list,(array)$fields_list_reg,$more_profile_data_fields);
        return $setting_fields;
        
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function buatp_style_setting_page(){
        $setting_fields = array();
        $setting_fields = array(
            array(
                'name' => 'buatp_tyle_elable',
                'class' => 'buatp_tyle_elable',
                'label' => __( 'Activate BUAT style for', 'buatp' ),
                'desc' => __( 'By default, Activated','buatp' ),
                'type' => 'radio',
                'options' => array(
                        'true' => 'Activate',
                        'false' => 'Deactivate',
                        ),
                 'default' => 'true'
                 ),
            array(
                'name' => 'buatp_default_view',
                'class' => 'buatp_default_view',
                'label' => __( 'Default view of members directory', 'buatp' ),
                'desc' => __( 'By default, list','buatp' ),
                'type' => 'radio',
                'options' => array(
                        'List' => 'List',
                        'Grid' => 'Grid',
                        ),
                 'default' => 'List'
                 ),
            array(
                'name' => 'buatp_allow_to_change_view',
                'class' => 'buatp_allow_to_change_view',
                'label' => __( 'Allow users to change view', 'buatp' ),
                'desc' => __( '<br>User may change members directory view by clicking list or grid button, allowed by default','buatp' ),
                'type' => 'checkbox'
                 ),
            array(
                'name' => 'buatp_elements_list_view',
                'class' => 'buatp_elements_list_view',
                'label' => __('Select elements to show in list view', 'buatp' ),
                'desc' =>  __( 'Elements you want to show in members directory in list view', 'buatp' ),
                'type' => 'multicheck',
                'options' => array(
                                'Avatar' => 'Avatar',
                                'Last active' => 'Last active',
                                'name' => 'name',
                                'Add/Remove friend button' => 'Add/Remove friend button',
                                'BuddyPress User Account Type custom fields' => 'BuddyPress User Account Type custom fields'
                            ),
                'default' => array(
                                'Avatar' => 'Avatar',
                                'Last active' => 'Last active',
                                'name' => 'name',
                                'Add/Remove friend button' => 'Add/Remove friend button',
                                'BuddyPress User Account Type custom fields' => 'BuddyPress User Account Type custom fields'
                            ) 
                ),
            array(
                'name' => 'buatp_elements_grid_view',
                'class' => 'buatp_elements_grid_view',
                'label' => __('Select elements to show in grid view', 'buatp' ),
                'desc' =>  __( 'Elements you want to show in members directory in grid view', 'buatp' ),
                'type' => 'multicheck',
                'options' => array(
                                'Last active' => 'Last active',
                                'name' => 'name'
                            ),
                'default' => array(
                                'Last active' => 'Last active',
                                'name' => 'name'
                            ) 
                ),
            
            array(
                'name' => 'buatp_grid_view_thumb_size',
                'class' => 'buatp_grid_view_thumb_size',
                'label' => __( 'Grid view thumb size', 'buatp' ),
                'desc' => __( 'px','buatp' ),
                'type' => 'text',
                'default' => '150'
                ),
            array(
                'name' => 'buatp_grid_view_avatar_size',
                'class' => 'buatp_grid_view_avatar_size',
                'label' => __( 'Grid view avatar size', 'buatp' ),
                'desc' => __( 'px','buatp' ),
                'type' => 'text',
                'default' => '120'
                ),
            array(
                'name' => 'buatp_grid_view_mergin',
                'class' => 'buatp_grid_view_mergin',
                'label' => __( 'Mergin between grid view thumbs', 'buatp' ),
                'desc' => __( 'px','buatp' ),
                'type' => 'text',
                'default' => '15'
                ),
            array(
                'name' => 'buatp_grid_view_thumb_border',
                'class' => 'buatp_grid_view_thumb_border',
                'label' => __( 'Grid view thumb border', 'buatp' ),
                'desc' => __( 'px<br>type \'none\' to remove border','buatp' ),
                'type' => 'text',
                'default' => '1'
                ),
            array(
                'name' => 'buatp_grid_view_thumb_border_color',
                'class' => 'buatp_grid_view_thumb_border_color',
                'label' => __( 'Grid view thumb border color', 'buatp' ),
                'desc' => __( '','buatp' ),
                'type' => 'text',
                'default' => '#dddddd'
                )
        );
        return $setting_fields;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function buatp_access_setting_page(){
        $setting_fields = array();
        foreach((array)$this->all_type_info as $val) {
            $page_restriction[$i++] = array(
                'name' => 'buatp_restrict_page_for_'.$val['name'],
                'class' => 'buatp_restrict_page_for_'.$val['name'],
                'label' => __( sprintf('Restrict pages/posts for <strong>%1$s</strong> type users', $val['name']), 'buatp' ),
                'desc' => __( '<br>You may restrict some pages/posts for a certain type user group, place page/post ID by comma saparator','buatp' ),
                'type' => 'text',
                );
            
            $url_restriction[$i] = array(
                'name' => 'buatp_restrict_url_for_'.$val['name'],
                'class' => 'buatp_restrict_url_for_'.$val['name'],
                'label' => __( sprintf('Restrict URL for <strong>%1$s</strong> type users <br>( one url per line, slug only )', $val['name']), 'buatp' ),
                'desc' => __( 'You may restrict some URL for a certain type user group, place one URL per line
                            <br> Place BuddyPress URL here to restriction, you may use <b>[user_name]</b> and <b>[group_name]</b>
                            <br> Example: /memebrs/[user_name]/testuser/profile','buatp' ),
                'type' => 'textarea',
                'default' => '/example-page'
                );
            
            $redirect[$i] = array(
                    'name' => 'buatp_restrict_redirect_for_'.$val['name'],
                    'class' => 'buatp_restrict_redirect_for_'.$val['name'],
                    'label' => __( sprintf('Select page to show Restriction notice for <strong>%1$s</strong> type users', $val['name']), 'buatp' ),
                    'desc' => __( sprintf('<br>While trying to access restricted pages, <strong>%1$s</strong> type users will be 
                                <br>redirected to which page to notice the restriction', $val['name']), 'buatp' ),
                    'type' => 'select',
                    'options' =>  $this->page_array 
                );
        }
        
        $more_restriction_fields = array (
            array(
                    'name' => 'buatp_restrict_redirect_general',
                    'class' => 'buatp_restrict_redirect_general',
                    'label' => __( sprintf('Select page to show Restriction notice for not logged in users '), 'buatp' ),
                    'type' => 'select',
                    'options' =>  $this->page_array 
                ),
            array(
                    'name' => 'buatp_shortcode_restriction',
                    'label' => 'Text/html restriction',
                    'type' => 'html',
                    'value' => "You can restrict some specific section for specifi type of users using shortcode</br>
                                Shortcode:<br> 
                                <h3>
                                [buatp user_type=\"user_type_1, user_type_2\"] <br><br>
                                <strong>YOUR CONTECT</strong> <br><br>[/buatp]
                                </h3>"
                ),
            array(
                    'name' => 'buatp_text_for_shortcode_restriction',
                    'label' => 'Restriction message for shortcode restriction',
                    'type' => 'textarea',
                    'default' => 'You are not permitted to see this content,  only [type_name] users can access it'
                ),
        );
        
        $setting_fields = array_merge((array)$setting_fields,(array)$page_restriction,(array)$url_restriction , (array)$redirect, $more_restriction_fields);
        
        return $setting_fields;
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function buatp_update_option($settings_name,$value){
        $this->$settings_name = $value;
        update_option($settings_name, $value);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    function plugin_page() {
        echo '<div id="buatp_setting_page_wraper">';
        echo '<div class="wrap">';
        do_action('buatp_notices');
        settings_errors();
        if(!buatp_check_type_field_exist()) {
            echo '<div class="postbox"><div style="margin-top: 20px; margin-left: 20px;">';
            $url = admin_url('admin.php?page=bp-profile-setup');
            if(is_multisite())
            $url = network_admin_url('admin.php?page=bp-profile-setup');
            echo __('<p>Theres no "Drop Down Select Box" field found at Buddypress profile fields</p>','buatp');
            echo __('<p>Create a "Drop Down Select Box" type profile filed from <a href="'.$url.'">Buddypress->profile fields</a>, 
                    create a new field, Name it as you want, e.g. User Type, select "Field Type" as "Drop Down Select Box"
                    and create some types, e.g type 1, type 2</p>','buatp');
            echo __('<p>It is essential to create "Drop Down Select Box" field to detemine user type. Read the manual to know more</p>','buatp');
            echo '</div></div></div>';
            return;
        }
        echo '<div id="buatp_hidden_fields"></div>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        do_action('buatp_trigger');
        echo '</div> </div>';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
   
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }
        return $pages_options;
    }

}

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
   
$settings = new buatp_admin_options();
?>
