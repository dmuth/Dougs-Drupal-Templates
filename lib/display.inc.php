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
* Set a notification if we have any pending friend requests.
*/
function check_pending_friend_requests() {

	if (!module_exists("user_relationships_ui")) {
		return(null);
	}

	global $user;
	_user_relationships_ui_set_notifications($user);

} // End of check_pending_friend_requests()


/**
* Print a note when we are in the dev site
*/
function check_dev_theme($directory) {

	if (strstr($directory, "dev")) {
		$message = "DEVELOPMENT TEMPLATE - If you think you shouldn't be seeing "
			. "this, please <a href=\"/contact\">contact us</a>.";
		$head_title .= " - " . $message;
		print $message;
	}

} // End of check_dev_theme()


/**
* Are we displaying user details?
* 
* @param object $node The object for the current node
* 
* @return boolean True if we are displaying user details.  False otherwise.
*/
function display_user_details($node) {

	$retval = false;

	if (empty($node->teaser)) {
		//
		// Not on the front page.
		//
		$retval = true;

	} else {
		//
		// Only certain sites get user details displayed on the
		// front page.
		//
		// @TODO: Come up with a better way of determining the 
		// site we're on.
		//
		$site_name = $GLOBALS["conf"]["site_name"];
		if (stristr($site_name, "ardmore")) {
			$retval = true;
		}

	}
	
	return($retval);

} // End of user_details_on_front_page()


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

