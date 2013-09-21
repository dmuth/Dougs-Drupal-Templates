<?php
/**
* This file holds our Facebook and Google Plus code
*
* @author Douglas Muth <http://www.dmuth.org/>
*/


//
// Check to see if we are in WAMP (onsite registration) in the admin 
// (not public) or on dev (devinitely not public).  If any of those 
// is true, don't display social link.
//
$_template_in_wamp = strstr($_SERVER["DOCUMENT_ROOT"], "/wamp/");
$_template_in_admin = (arg(0) == "admin");
$_template_on_dev = strstr($_SERVER["SERVER_NAME"], "localdomain");
//print "Debug: $_template_in_wamp, $_template_in_admin, $_template_on_dev";

if ( $_template_in_wamp || $_template_in_admin || $_template_on_dev ) {
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


