<?php

//drupal_rebuild_theme_registry(); // Debugging


/**
* Override our breadcrumb theming function.
*
* I should probably name this (theme)_breadcrumb, but that's difficult
* to do with hypens in a theme name. :-(
*
* @param array $vars Variables for this template function.
*
* @return string HTML code
*/
function phptemplate_breadcrumb($vars) {

	$retval = "";

	foreach ($vars as $key => $value) {

		//
		// These always show up, thanks to the chatroom being
		// in the sidebar.  So don't print them.
		//
		if (strstr($value, "Chat Rooms")
			|| strstr($value, "General Chat")
			) {
			continue;
		}

		if (!empty($retval)) {
			$retval .= "&nbsp;" . "»" . "&nbsp;";
		}

		$retval .= $value;

	}

	$retval = "<div class=\"breadcrumb\">$retval</div>\n";

	return($retval);

} // End of phptemplate_breadcrumb()


