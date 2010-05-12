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


/**
*
*/
function check_pending_friend_requests() {

	if (!module_exists("user_relationships_ui")) {
		return(null);
	}

	global $user;
	_user_relationships_ui_set_notifications($user);

} // End of check_pending_friend_requests()


/**
* Return the number of seconds elapsed since the last call.
* 
*/
function get_time_offset() {

	$retval = 0;

	static $timestamp = "";

	$new_timestamp = microtime(true);

	if (!empty($timestamp)) {
		$retval = $new_timestamp - $timestamp;
	}

	$timestamp = $new_timestamp;

	//
	// Format for 6 digits.
	//
	$retval = sprintf("%.6f", $retval);

	return($retval);

} // End of get_time_offset()

//
// Initialize the timer on include
//
get_time_offset();

