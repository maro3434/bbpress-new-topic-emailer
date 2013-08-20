<?php

//Disallow direct access
if(!defined('HNTE_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

add_action( 'bbp_new_topic', 'HNTE_New_Post_Triggered', 10, 4 );
function HNTE_New_Post_Triggered( $topic_id, $forum_id, $anonymous_data, $topic_author) {
	
	$options = get_option('HNTE_options');

	if($options['enable_all'] === true && $options['enabled_'.$forum_id] === true && !empty($options['notify_'.$forum_id])) {

		$emails_to_notify = HNTE_Get_Emails($forum_id);

		$send_result = HNTE_Send_Post_Notifications($forum_id, $topic_id, $emails_to_notify, $topic_author, $options['send_content'], $options['excerpt_only'], $options['max_length'], $options['append_title'], $options['email_subject']);
	}

}

function HNTE_Get_Emails($forum_id) {

	$options = get_option('HNTE_options');

	$forum_emails = $options['notify_'.$forum_id];

	$emails_array = explode(',', $forum_emails);

	return $emails_array;

}

function HNTE_Send_Post_Notifications($forum_id, $topic_id, $emails_to_notify, $topic_author, $send_content = false, $excerpt_only = false, $max_length = false, $append_title = false, $subject = "Forum Post Notification") {

	// Get our new topic info
	$new_topic = get_post($topic_id);

	// Setup our vars from the new topic
	$topic_title 	= $new_topic->post_title;
	$topic_content 	= $new_topic->post_content;
	$topic_url 		= $new_topic->guid;

	// Get our author info
	$author_ojb		= get_user_by('id', $topic_author);
	$author_name 	= $author_ojb->data->display_name;

	// Get the contents of our HTML template into a string
	$html_template = file_get_contents( HNTE_DIRECTORY . '/includes/html_template.html' );

	// If send content is set
	if($send_content) {
		if($excerpt_only && $max_length != 0) {

			// Get our content length
			$content_length = strlen($topic_content);

			// If longer than Max Chars, cut it
			if($content_length > $max_length) {
				
				// Cut it
				$topic_content = substr($topic_content,0,$max_length);

				// Add elipsis
				$topic_content .= '...';
			}
		}

		// Apply Content Filter
		$topic_content = apply_filters ("the_content", $topic_content);
		
		// Inject the content into the email
		$html_template = str_replace('<!-- NEW_TOPIC_CONTENT_PLACEHOLDER -->', $topic_content, $html_template);
	}

	// Add topic title to email subject
	if($append_title) {
		$subject .= ' ' . $topic_title;
	}

	// Inject our information into our HTML template
	$html_template = str_replace('<!-- NEW_TOPIC_TITLE_PLACEHOLDER -->', $topic_title, $html_template);
	$html_template = str_replace('<!-- AUTHOR_NAME_PLACEHOLDER -->', $author_name, $html_template);
	$html_template = str_replace('<!-- NEW_TOPIC_URL_PLACEHOLDER -->', $topic_url, $html_template);

	// Send HTML email
	$headers = 'Content-type: text/html';
	$sent_message = wp_mail( $emails_to_notify, $subject, $html_template, $headers );

	function set_html_content_type() {
		return 'text/html';
	}

	return $sent_message;

}

?>