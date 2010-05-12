<?php

/**
* Check to see if the user has any unread private messages.
*
* If they do, print a message informing them of that.
*/
function check_private_messages() {

	if (!module_exists("privatemsg")) {
		return(null);
	}

	$num_messages = privatemsg_unread_count();
	if ($num_messages > 0 && (request_uri() != "/messages")) {
		$message = t("You have 1 or more !messages", 
			array("!messages" => l("unread Private Messages", "messages")));
		drupal_set_message($message);
	}

} // End of check_private_messages()

