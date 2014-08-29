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
$_template_on_onsite = strstr($_SERVER["DOCUMENT_ROOT"], "onsite");

$_editing = false;
if (strstr($_GET["q"], "/edit")) { $_editing = true; }
if ($_GET["q"] == "messages") { $_editing = true; }
if (strstr($_GET["q"], "messages/")) { $_editing = true; }
//
// If not logged in, don't show this on the /user page, because it obscures
// the "create new account" button.
//
if (
	$_GET["q"] == "user"
	&& !$user->uid
	) { 
	$_editing = true;
}

//print $_GET["q"];
//print "Debug: $_template_in_wamp, $_template_in_admin, $_template_on_dev, $_editing";

if ( $_template_in_wamp || $_template_in_admin || $_template_on_dev 
	|| $_template_on_onsite || $_editing) {
	return(null);
}


$url = $GLOBALS["base_url"] . request_uri();

//
// Facebook treats these URLs differently, so let's point them all over to HTTP.
//
$url = preg_replace("/^https:/", "http:", $url);

$fb_html = "<div "
	. "class=\"fb-like\" "
	. "style=\"float: right; padding-top: 10px; height: 24px; \" "
	. "data-href=\"${url}\" "
	. "data-width=\"250\" data-layout=\"button_count\" data-action=\"like\" "
	. "data-show-faces=\"false\" data-share=\"true\"></div>"
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


