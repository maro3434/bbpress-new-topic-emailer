<?php

//Disallow direct access
if(!defined('HNTE_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function HNTE_Render_Options() {

    $HNTE_options = get_option('HNTE_options');
    $show_message = false;
    if($_POST['submit']) {

        unset($_POST['submit']);
        $HNTE_options = HNTE_Save_Options($_POST);
        $show_message = true;
    }

	?>
    <?php if($show_message) { ?>
    <div id="message" class="updated">
        <p><?php _e('Options Saved Successfully', 'HNTE'); ?></p>
    </div>
    <?php } ?>
    <form method="post" action="?page=<?php echo $_REQUEST['page'];?>&render=options">
        <?php
        if ( function_exists('wp_nonce_field') )  {
            wp_nonce_field('HNTE_options');
        }
        ?>

        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="enable_all"><?php _e('Enable Outgoing Emails', 'HNTE'); ?>:</label>
                    </th>
                    <td>
                        <input type="checkbox" name="enable_all" id="enable_all" <?php if($HNTE_options['enable_all'] === true) {echo 'checked="checked"';} ?>/>
                        <p class="description"><span style="color:red;"><?php _e('Notice', 'HNTE'); ?></span>: <?php _e('This is the master on/off for all email notications', 'HNTE'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="email_subject"><?php _e('New Notification Subject', 'HNTE'); ?>:</label>
                    </th>
                    <td>
                        <input type="text" name="email_subject" id="email_subject" value="<?=$HNTE_options['email_subject'];?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="append_title"><?php _e('Append Topic Title to Subject', 'HNTE'); ?>:</label>
                    </th>
                    <td>
                        <input type="checkbox" name="append_title" id="append_title" <?php if($HNTE_options['append_title'] === true) {echo 'checked="checked"';} ?>/>
                        <p class="description"><?php _e('If checked, the title of the new topic will be appended to the end of the subject. A space will automatically be added before the title.', 'HNTE'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="send_content"><?php _e('Include Topic Content in Email', 'HNTE'); ?>:</label>
                    </th>
                    <td>
                        <input type="checkbox" name="send_content" id="send_content" <?php if($HNTE_options['send_content'] === true) {echo 'checked="checked"';} ?>/>
                        <p class="description"><?php _e('If checked, the content of the new forum post will be included in the email notification', 'HNTE'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="excerpt_only"><?php _e('Limit Length of Topic Content', 'HNTE'); ?>:</label>
                    </th>
                    <td>
                        <input type="checkbox" name="excerpt_only" id="excerpt_only" <?php if($HNTE_options['excerpt_only'] === true) {echo 'checked="checked"';} ?>/>
                        <p class="description"><?php _e('If "Include Topic Content in Email" is enabled, limit the length of the content', 'HNTE'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="max_length"><?php _e('Max Length of Topic Content', 'HNTE'); ?>:</label>
                    </th>
                    <td>
                        <input type="text" name="max_length" id="max_length" value="<?=$HNTE_options['max_length'];?>" class="regular-text" />
                        <p class="description"><?php _e('Numbers of characters to show in email, "Limit Length of Topic Content" must be enabled', 'HNTE'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <br />

    <?php submit_button(); ?>
    </form>
    <?php
}

function HNTE_Save_Options($new_options) {

    check_admin_referer('HNTE_options');

    unset($new_options['_wpnonce']);
    unset($new_options['_wp_http_referer']);

    $HNTE_options = get_option('HNTE_options');

    foreach($new_options as $key => $option)
    {
        if($key == 'max_length') {
            $option = preg_replace("/[^0-9]/","", $option);
            $option = (int) $option;
        }
        $HNTE_options[$key] = $option;
    }
    $HNTE_options['enable_all'] = (isset($new_options['enable_all'])) ? true : false;
    $HNTE_options['send_content'] = (isset($new_options['send_content'])) ? true : false;
    $HNTE_options['excerpt_only'] = (isset($new_options['excerpt_only'])) ? true : false;
    $HNTE_options['append_title'] = (isset($new_options['append_title'])) ? true : false;

    update_option('HNTE_options', $HNTE_options);

    return $HNTE_options;

}

?>