<?php

//
// Since we are running within another function, copy our the directory to our
// globals (with an "ac_" prefix for uniqueness) so that one or more of the
// functions below can get to that data.
//
$GLOBALS["ac_directory"] = $directory;

//
// Only run this code once, since the file can be included multiple times
//
if (!function_exists("_get_submitter")) {

	/**
	*
	* Get submitter information including the display name, if present
	*
	* @param object $data Our node or comment object
	* 
	* @param integer $timestamp The timestamp for when this object
	*	was created.  The field name is different for nodes
	*	and comments.
	*
	* @return string HTML code with submitter identification
	*
	*/
	function _get_submitter(&$data, &$timestamp) {
	
		$retval = "Posted by " . theme("username", $data);
	
		//
		// Display the user's display name, if we have it.
		//
		if (!empty($data->profile_display_name)) {
			$retval .= " (" . $data->profile_display_name . ")";
		}

		$retval .= " on " . format_date($timestamp);

		return($retval);

	} // End of _get_submitter()
	

	/**
	* Main function to get user information for display in posts or 
	* 	comments.
	*
	* @param object $data Our node or comment object.  
	*	profile_load_profile() should have already been callled on
	*	this object to populate it.
	*
	* @return string HTML code for user in the profile info.
	*/
	function _get_user_info(&$data) {
	
		$retval = "<div class=\"picture-comment\">";

		if ($tmp = _get_user_string($data, "profile_comment")) {
			$retval .= "\"" . $tmp . "\"" . "<p>\n";
		}
		
		if ($tmp = _get_user_string($data, "profile_location")) {
			$retval .= "Location: " . $tmp . "<p>\n";
		}
		
		if ($tmp = _get_user_url($data, "profile_website", "Website")) {
			$retval .= $tmp . "<br>\n";
		}
		
		if ($tmp = _get_user_url($data, "profile_blog", "Blog")) {
			$retval .= $tmp . "<br>\n";
		}
		$retval .= "<p>\n";

		$retval .= _get_user_buttons($data->uid);

		if ($tmp = _get_user_im($data, "google_talk")) {
			$retval .= $tmp . "\n";
		}

		if ($tmp = _get_user_im($data, "aim")) {
			$retval .= $tmp . "\n";
		}

		if ($tmp = _get_user_im($data, "yahoo")) {
			$retval .= $tmp . "\n";
		}
		
		if ($tmp = _get_user_im($data, "icq")) {
			$retval .= $tmp . "\n";
		}
		
		if ($tmp = _get_user_im($data, "msn")) {
			$retval .= $tmp . "\n";
		}
		
		$retval .= "</div>";

		return($retval);

	} // End of _get_user_info()


	/**
	* Get an arbitrary string from the user object.
	*
	* @param string $key The name of the object attrib to fetch
	*
	* @return mixed A string is returned of the attrib is found, 
	*	otherwise not.
	*/
	function _get_user_string(&$data, $key) {

		$retval = "";

		if (!empty($data->${key})) {
			$retval = filter_xss($data->${key});
		}

		return($retval);

	}


	/**
	* Get a url from the user object.
	*
	* @param string $key The name of the object attrib to fetch
	*
	* @param string $header The header string to display before the link.
	*
	* @return mixed An HTML link is displayed if the attrib is found.
	*
	*/
	function _get_user_url($data, $key, $header) {

		$retval = "";
		
		if (!empty($data->${key})) {
			//
			// Catch users who have not entered in "http://" 
			// on their URLs.
			//
			if (!stristr($data->${key}, "http://")) {
				$data->${key} = "http://" 
					. $data->${key};
			}
			
			$retval .= "$header: <a href=\"" 
				. check_url($data->${key}) 
				."\">[Link]</a>";
		}

		return($retval);
		
	} // End of _get_user_url()
	

	/**
	* This function gets HTML code to link to an image for the user's 
	* IM protocol.
	*
	* @param string $protocol The name of the IM protocol.  This isthen
	*	translated into an actual key.
	*/
	function _get_user_im($data, $protocol) {

		$key = "profile_" . $protocol;
		
		$retval = "";

		$dir = $GLOBALS["ac_directory"] . "/images/im";

		if (!empty($data->${key})) {

			$image = "/" . $dir . "/" . $protocol . ".gif";
			$image = "<img src=\"$image\" />";

			$link = "";
			if ($tmp = _get_user_im_handler($protocol)) {
				$link = $tmp .= check_url($data->{$key});
			}

			if (!empty($link)) {
				$retval .= "<a href=\"" . $link . "\" "
					. "border=\"0\" "
					. "alt=\"" . $protocol 
						. " Username: " . check_url($data->{$key}) . "\" "
					. "title=\"" . $protocol 
						. " Username: " . check_url($data->{$key}) . "\" "
					. ">" . $image . "</a>";
			} else {
				$retval .= $image;
			}

			$retval .= "\n";
		}

		return($retval);
		
	} // End of _get_user_im()


	/**
	* Get the handler string used in an HREF tag for a particular
	* IM protocol.
	*
	* @param string $protocol The protocol we want.
	*/
	function _get_user_im_handler($protocol) {

		$retval = "";
		
		if ($protocol == "aim") {
			$retval = "aim:goim?screenname=";

		} else if ($protocol == "icq") {
			$retval = "aim:goim?screenname=";

		} else if ($protocol == "yahoo") {
			$retval = "ymsgr:sendIM?";

		} else if ($protocol == "msn") {
			$retval = "msnim:chat?contact=";

		} else if ($protocol == "google_talk") {
			$retval = "gtalk:chat?jid=";

		}

		return($retval);

	} // End of _get_user_im_handler()


	/**
	* Get our user staff/board buttons
	*
	* @param integer $uid The user ID from the node or comment
	*
	* @return string HTML code
	*/
	function _get_user_buttons($uid) {

		$retval = "";
		
		$board_ids = array(2, 4, 5, 178, 198, 15, 582);
		$staff_ids = array(2, 4, 5, 21, 337, 56, 470, 
			178, 198, 582, 1763, 1769, 87, 15, 266, 2282,
			1129, 30, 159, 128, 327, 784, 772, 2937, 778,
			326, 3822, 1314, 2025, 1494, 3339, 115);
		
		$dir = $GLOBALS["ac_directory"] . "/images/buttons";

		if (in_array($uid, $board_ids)) {
			$retval .= "<img src=\"/" . $dir . "/board.png\" "
				. "alt=\"This user is a Board Member.\" "
				. "title=\"This user is a Board Member.\" "
				. "/> ";
		}

		if (in_array($uid, $staff_ids)) {
			$retval .= "<img src=\"/" . $dir . "/staff.png\" "
				. "alt=\"This user is a Staff Member.\" "
				. "title=\"This user is a Staff Member.\" "
				. "/> ";
		}

		if (!empty($retval)) {
			$retval .= "<p>\n";
		}

		return($retval);
		
	} // End of _get_user_buttons()


} // if()

