<?php
/**
* This file contains the greeting shown to anonymous visitors.
*
* @author Douglas Muth <http://www.dmuth.org/>
*/

//
// If this is a forum post and the user is not logged in, print
// a message promting them to do so.
//
if (
	!$GLOBALS["user"]->uid
	&& !strstr($_REQUEST["q"], "who-is-welcome-here")
	&& (
		strstr($_REQUEST["q"], "recent")
		|| $node->type == "forum"
		|| $node->type == "event"
		|| $node->type == "blog"
	)
	) {
	
		$html = "<div style=\"border: 1px solid black; "
			//. "font-size: large; "
			. "padding: 5px; margin: 5px;\" "
			. "class=\"messages\"; "
			. ">"

			. "Welcome <b>furry fans</b>!</p>\n"
			. "We're glad you stopped by.  Go ahead and "
				. "<a href=\"/user\">register for a free account</a> "
				. "to get the benefits of being a member, including:\n"
			. "<ul>\n"
			. "<li>Access to all of our posts and comments</li>\n"
			. "<li>Your own profile including an avatar, buddy lists, and other social networking features</li>\n"
			. "</ul>\n"

			. "<span style=\"font-size: larger; \">"
			. "Creating an account is easy. <a href=\"/user\">Register now!</a>\n"
			. "</span>"

			. "</div>";
	
	print $html;

}


