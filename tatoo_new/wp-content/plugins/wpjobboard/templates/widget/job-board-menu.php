<?php echo $theme->before_widget ?>
<?php if($title) echo $theme->before_title.$title.$theme->after_title ?>
<?php $can_post = (mbt_get_user_type() == 'studio')? true:false; ?>
<ul id="wpjb_widget_jobboardmenu" class="wpjb_widget">
    <?php if($can_post): ?>
    <li>
        <a href="<?php echo wpjb_link_to("step_add") ?>">
            <?php _e("Post a Job", WPJB_DOMAIN) ?>
        </a>
    </li>
    <?php endif; ?>
    <li>
        <a href="<?php echo wpjb_url() ?>">
            <?php _e("View Jobs", WPJB_DOMAIN) ?>
        </a>
    </li>
    <li>
        <a href="<?php echo wpjb_link_to("advsearch") ?>">
            <?php _e("Advanced Search", WPJB_DOMAIN) ?>
        </a>
    </li>

    <?php if(get_user_meta(wp_get_current_user()->ID, "is_employer")): ?>
        <li>
            <a href="<?php echo wpjb_link_to("employer_panel") ?>">
                <?php _e("Applications", WPJB_DOMAIN) ?>
            </a>
        </li>
        <li>
            <a href="<?php echo wpjb_link_to("employer_edit") ?>">
                <?php _e("Studio Profile", WPJB_DOMAIN) ?>
            </a>
        </li>
        <!--<?php if(Wpjb_Project::getInstance()->conf("cv_enabled")): ?>
        <li>
            <a href="<?php echo wpjb_link_to("employer_access") ?>">
                <?php _e("Resumes Access", WPJB_DOMAIN) ?>
            </a>
        </li>
        <?php endif; ?>
        <li>
            <a h.ref="<?php echo wpjb_link_to("employer_logout") ?>">
                <?php _e("Logout", WPJB_DOMAIN) ?>
            </a>
        </li> -->
    <?php elseif(get_option('users_can_register')): ?>
    <!--   <li>
            <a href="<?php echo wpjb_link_to("employer_login") ?>">
                <?php _e("Studio Login", WPJB_DOMAIN) ?>
            </a>
        </li>
        <li>
            <a href="<?php echo wpjb_link_to("employer_new") ?>">
                <?php _e("Studio Registration", WPJB_DOMAIN) ?>
            </a>
        </li> -->
    <?php endif; ?>


</ul>

<?php echo $theme->after_widget ?>