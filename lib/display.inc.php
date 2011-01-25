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
			. "this, please <a href=\"/contact\">contact us</a>.<br/>\n";

		if (!empty($GLOBALS["base_url"])) {
			$base_url = $GLOBALS["base_url"];
		} else {
			$base_url = "(none defined)";
		}

		$message .= "base_url: $base_url<br/>\n";

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
* Create HTML that consists of our links to social networks.
*
* @param array $public_profile Array of profile fields.
*
* @return string HTML code
*/
function get_social_network_links($public_profile) {
	
	$retval = "";

	//$public_profile["profile_blog"]["#value"] = 12345; // Debugging
	//$public_profile["profile_icq"]["#value"] = 12345; // Debugging

	//
	// Array of fields for our different social networks
	//
	$fields = array();
	$fields["profile_website"] = array(
		"img" => "home.png",
		"alt" => t("Personal Website"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_blog"] = array(
		"img" => "blog.png",
		"alt" => t("Blog"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_facebook"] = array(
		"img" => "facebook.png",
		"alt" => t("Facebook"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_twitter"] = array(
		"img" => "twitter.png",
		"alt" => t("Twitter"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_linkedin"] = array(
		"img" => "linkedin.png",
		"alt" => t("LinkedIn Profile"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_aim"] = array(
		"img" => "aim.png",
		"alt" => t("AIM: "),
		"alt_append_value" => true,
		"add_http" => false,
		"pre_link" => "aim:goim?screenname=",
		);
	$fields["profile_google_talk"] = array(
		"img" => "gtalk.png",
		"alt" => t("Google Talk: "),
		"alt_append_value" => true,
		"pre_link" => "gtalk:chat?jid=",
		);
	$fields["profile_yahoo"] = array(
		"img" => "yahoo.png",
		"alt" => t("Yahoo Messenger: "),
		"alt_append_value" => true,
		"pre_link" => "ymsgr:sendIM?",
		);
	$fields["profile_icq"] = array(
		"img" => "icq.png",
		"alt" => t("ICQ: "),
		"alt_append_value" => true,
		"pre_link" => "aim:goim?screenname=",
		);
	$fields["profile_msn"] = array(
		"img" => "msn.png",
		"alt" => t("MSN: "),
		"alt_append_value" => true,
		"pre_link" => "msnim:chat?contact=",
		);
	$fields["profile_da"] = array(
		"img" => "da.png",
		"alt" => t("DeviantArt"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_lj"] = array(
		"img" => "lj.png",
		"alt" => t("LiveJournal"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_skype"] = array(
		"img" => "skype.png",
		"alt" => t("Skype"),
		"pre_link" => "skype:",
		"post_link" => "?userinfo",
		);
	$fields["profile_flickr"] = array(
		"img" => "flickr.png",
		"alt" => t("Flickr"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_delicious"] = array(
		"img" => "delicious.png",
		"alt" => t("Delicious"),
		"add_http" => true,
		"target" => "_blank",
		);

	//
	// Our base path for icons in this template
	//
	$path = $GLOBALS["base_path"] . "sites/all/themes/" . $GLOBALS["theme"];

	//
	// Loop through our social networks and print up an image and 
	// link for each
	//
	foreach ($fields as $key => $value) {

		if (empty($public_profile[$key]["#value"])) {
			continue;
		}

		$img = $path . "/icons/" . $value["img"];
		$alt = $value["alt"];

		$link = strip_tags($public_profile[$key]["#value"]);

		//
		// Do we want to append the value (such as a screen name) to
		// the ALT text? 
		//
		if ($value["alt_append_value"]) {
			$alt .= $link;
		}

		//
		// Add in the http:// protocol if it's not present.
		//
		if (!empty($value["add_http"])) {
			if (!stristr($link, "http://")) {
				$link = "http://" . $link;
			}
		}

		//
		// Pre and post link text.
		//
		if (!empty($value["pre_link"])) {
			$link = $value["pre_link"] . $link;
		}

		if (!empty($value["post_link"])) {
			$link = $link . $value["post_link"];
		}

		//
		// See if we have a custom target
		//
		$target = "";
		if (!empty($value["target"])) {
			$target = "target=\"" . $value["target"] . "\"";
		}

		$retval .= "<a href=\"" . $link . "\" $target >"
			. "<img src=\"" 
			. $img . "\" title=\"$alt\" height=\"16\" border=\"0\" "
			. "/>"
			//. "link" // Debugging
			."</a> \n";

	}

	return($retval);

} // End of get_social_network_links()


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

