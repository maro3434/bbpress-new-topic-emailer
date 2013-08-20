<?php

//Disallow direct access
if(!defined('HNTE_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function HNTE_Render_Configure() {

    $HNTE_options = get_option('HNTE_options');
    $show_message = false;
    if($_POST['submit']) {

        unset($_POST['submit']);
        $HNTE_options = HNTE_Save_Notification_Options($_POST);
        $show_message = true;
    }

    $forum_categories = HNTE_Retrieve_Forum_Categories();

    ?>
    <?php if($show_message) { ?>
    <div id="message" class="updated">
        <p><?php _e('Notification Settings Saved Successfully', 'HNTE'); ?></p>
    </div>
    <?php } ?>
    <form method="post" action="?page=<?php echo $_REQUEST['page'];?>&render=configure">
        <?php
        if ( function_exists('wp_nonce_field') )  {
            wp_nonce_field('HNTE_options');
        }
        ?>
        <p><?php _e('Configure notification settings for each of your forum sections below:'); ?></p>
    <?php

    foreach($forum_categories as $forum) {

        ?>
        <h3><?php _e('Forum: ', 'HNTE'); ?><?php echo $forum['title']; ?></h3>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="enabled_<?php echo $forum['ID']; ?>"><?php _e('Enable Emails:', 'HNTE'); ?></label>
                    </th>
                    <td>
                        <label for="enabled_<?php echo $forum['ID']; ?>">
                            <input type="checkbox" name="enabled_<?php echo $forum['ID']; ?>" id="enabled_<?php echo $forum['ID']; ?>" <?php if($HNTE_options['enabled_'.$forum['ID']] === true) {echo 'checked="checked"';} ?>/>
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="notify_<?php echo $forum['ID']; ?>"><?php _e('Emails Address to Notify:', 'HNTE'); ?></label>
                    </th>
                    <td>
                        <textarea rows="5" cols="50" name="notify_<?php echo $forum['ID']; ?>" id="notify_<?php echo $forum['ID']; ?>"><?php if(isset($HNTE_options['notify_'.$forum['ID']])) {
                                echo $HNTE_options['notify_'.$forum['ID']];
                            } ?></textarea>
                        <p class="description"><span style="color:red;"><?php _e('Notice', 'HNTE'); ?>:</span> <?php _e('Seperate each email with a comma (test@example.com, test2@example.com).', 'HNTE'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
        <hr />
        <?php
    }

    submit_button();

    ?>
    </form>
    <?php

}

function HNTE_Retrieve_Forum_Categories() {

    $forum_cats_query = new WP_Query( array('post_type' => 'forum') );
    $forum_categories = array();
    $x=0;
    foreach($forum_cats_query->posts as $post) {
        $forum_categories[$x]['title'] = $post->post_title;
        $forum_categories[$x]['name'] = $post->post_name;
        $forum_categories[$x]['ID'] = $post->ID;
        $x++;
    }

    if(!empty($forum_categories)) {
        return $forum_categories;
    }

}

function HNTE_Save_Notification_Options($new_options) {

    $forum_categories = HNTE_Retrieve_Forum_Categories();

    check_admin_referer('HNTE_options');

    unset($new_options['_wpnonce']);
    unset($new_options['_wp_http_referer']);

    $HNTE_options = get_option('HNTE_options');

    foreach($new_options as $key => $option)
    {
        if(stristr($key, 'notify_')) {
            $option = HNTE_Verify_Emails($option);
        }
        $HNTE_options[$key] = $option;
    }

    foreach($forum_categories as $forum) {
        $HNTE_options['enabled_'.$forum['ID']] = (isset($new_options['enabled_'.$forum['ID']])) ? true : false;
    }

    update_option('HNTE_options', $HNTE_options);

    return $HNTE_options;

}

function HNTE_Verify_Emails($emails) {

    // Remove any spaces
    $emails = str_replace(' ', '', $emails);

    // Turn email string into Array
    $emails_array = explode(',', $emails);

    foreach($emails_array as $key => $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            unset($emails_array[$key]);
        }
    }

    $cleaned_emails = implode(',', $emails_array);

    return $cleaned_emails;

}









?>