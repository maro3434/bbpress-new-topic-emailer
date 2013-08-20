<?php

//Disallow direct access
if(!defined('HNTE_DIRECTORY')) {
	die('Direct Access Not Allowed');
}


/*************************** REGISTER THE ADMIN PAGE ****************************
 ********************************************************************************/

function HNTE_Admin_Options_Menu() {
    global $HNTE_management_page;
    $HNTE_management_page = add_options_page( 'bbPress New Topic Emailer', 'bbPress Topic Emailer', 'manage_options', 'bbpress-new-topic-emailer', 'HNTE_render_admin_page' );
}
add_action( 'admin_menu', 'HNTE_Admin_Options_Menu', 10 );

function HNTE_render_admin_page() {

    $admin_page = (isset($_GET['render'])) ? $_GET['render'] : 'configure';
    ?>
    <div id="icon-users" class="icon32"><br/></div>
    <h2>bbPress New Topic Emailer</h2>
    <h3 class="nav-tab-wrapper">
        <a href="?page=<?php echo $_REQUEST['page'];?>&render=configure" class="nav-tab <?php if($admin_page == 'configure'){echo 'nav-tab-active';} ?>"><?php _e('Configure Notifications', 'HNTE'); ?></a>
        <a href="?page=<?php echo $_REQUEST['page'];?>&render=options" class="nav-tab <?php if($admin_page == 'options'){echo 'nav-tab-active';} ?>"><?php _e('Options', 'HNTE'); ?></a>
    </h3>

    <?php
    switch($admin_page)
    {
        case 'configure':
            require_once(HNTE_DIRECTORY . '/includes/admin/configure.php');
            HNTE_Render_Configure();
            break;
        case 'options':
            require_once(HNTE_DIRECTORY . '/includes/admin/options.php');
			HNTE_Render_Options();
            break;
    }

}
?>
