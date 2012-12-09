<?php
/**
* This file holds our Facebook and Google Plus code
*
* @author Douglas Muth <http://www.dmuth.org/>
*/

//
// If we are running under Wamp, that only happens
// for onsite reg, so suppres the Facebook Like 
// button there. 	
//
if (
	(	strstr($_SERVER["DOCUMENT_ROOT"], "/wamp/")
		&& (arg(0) != "admin")
	) ||
	(
		//
		// Suppress my development servers, too.
		//
		strstr($_SERVER["SERVER_NAME"], "localdomain")
	)
	) {
	return(null);
}

$url = $GLOBALS["base_url"] . request_uri();
$url_string = rawurlencode($url);
$fb_url = "http://www.facebook.com/plugins/like.php?"
	. "href=${url_string}&amp;"
	. "layout=button_count&amp;show_faces=true&amp;action=like&amp;font&amp;colorscheme=light"
	;
$fb_html = "<iframe src=\"" . $fb_url . "\""
		. "scrolling=\"no\" frameborder=\"0\" "
		. "style=\"border:none; overflow:hidden; width:90px; "
			. "height: 40px; float: right; "
			. "padding-top: 10px; \" "
		. "allowTransparency=\"true\">"
		. "</iframe>"
		;

$plus_one = ""
	. "<g:plusone size=\"medium\"></g:plusone>\n"
	. "<script type=\"text/javascript\">\n"
	. "(function() {\n"
		. "var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;\n"
		. "po.src = 'https://apis.google.com/js/plusone.js';\n"
		. "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);\n"
	. "})();\n"
	. "</script>\n"
	;

$plus_one_html = ""
	. "<span style=\"float: right; padding-top: 10px; \">"
	. $plus_one
	. "</span>"
	;


