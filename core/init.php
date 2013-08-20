<?php

register_activation_hook(HNTE_PLUGIN_FILE, 'HNTE_Activation_Hook');
function HNTE_Activation_Hook(){
	$default_values = array(
	    'enable_all'	=> true, 						// Enabled Sending of emails
	    'email_subject'	=> 'New Forum Topic Alert:', 	// Default Email Subject
	    'append_title'	=> true, 						// Append Topic Title to email
	    'send_content'	=> true, 						// Sent Topic Content in email
	    'excerpt_only'	=> false, 						// Trim Content Length
	    'max_length'	=> 255 							// Length to trim content to
	);
	add_option('HNTE_options', $default_values);
}

?>