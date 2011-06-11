<?php

//
// Load our functions conditionally.
// The reason for this function_exists() silliness is because touching the
// lib/display.inc.php file causes the first reload afterward to somwhoe
// load the file twice.
//
if (!function_exists("check_private_messages")) {

	$slash = DIRECTORY_SEPARATOR;
       	$file = $slash . ".." . $slash . "lib" . $slash . "display.inc.php";
	$path = dirname(__FILE__) . $file;

	//
	// If the file was not found, then maybe we didn't create symlinks,
	// so try removing ".." instead.
	//
	if (!is_file($path)) {
       		$file = $slash . "lib" . $slash . "display.inc.php";
		$path = dirname(__FILE__) . $file;
	}

	include($path);

}

//print "<pre>"; print_r($GLOBALS); print "</pre>"; // Debugging

//
// Are we in the dev theme?
//
check_dev_theme($directory);

//
// If we have unread private messages, let the user know.
//
check_private_messages();

//
// Do we have any outstandng buddy requests?
//
check_pending_friend_requests();
//print "Timer: " . get_time_offset() . "<br/>\n"; // Debugging

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language ?>" xml:lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
<?php
//
// Base directory for stuff under this template
//
?>
<script type="text/javascript" >
var directory = "/<?php print $directory; ?>"; 
</script>
<?php
//
// jQuery cookie plugin.  The jquery_cookie module breaks.
// See: http://drupal.org/node/203435 for details
//
?>
<script type="text/javascript" src="/<?php print $directory; ?>/lib/cookie.js"></script>
<script type="text/javascript" src="/<?php print $directory; ?>/lib/drupalBlockToggle.js"></script>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
<?php
//
// Code for our SSL "corner of trust" graphic.
//
?>
<script language="javascript" type="text/javascript">
//<![CDATA[
//
// Only display when connecting via HTTPS.
//
// Commented out due to secure.comodo.net being DOWN
// 30 Apr 2009, DTM
//
//if (window.location.protocol == "https:") {
//	var cot_loc0=(window.location.protocol == "https:")? "https://secure.comodo.net/trustlogo/javascript/cot.js" :
//	"http://www.trustlogo.com/trustlogo/javascript/cot.js";
//	document.writeln('<scr' + 'ipt language="JavaScript" src="'+cot_loc0+'" type="text\/javascript">' + '<\/scr' + 'ipt>');
//}
//]]>
</script>
</head>

<body >

<?php
//
// Main graphic and a link back to the main page.
// Full list of variables is at: http://drupal.org/node/11812
//
// Note that we can't just have the banner outside of table, because strict HTML causes a few
// pixels to be added underneath of the banner.
//
?>

<table border="0" cellpadding="0" cellspacing="0" id="content">
<tr>
<td colspan="2" 
	id="banner"
	background="/<?php print $directory; ?>/images/anthrocon-2011/logo.png"
	>
<div id="menu">
      <?php if (isset($primary_links)) { 
	?><div id="primary"><?php print theme('links', $primary_links) ?></div><?php 
	} ?>
</div>
</td>
</tr>

<!-- No idea WHY this works, but it does, and removes that stupid black line. -->
<tr><td></td></tr>

  <tr>
    <?php if ($left) { ?><td id="sidebar-left">
      <?php print $left ?>
    </td><?php } ?>
    <td valign="top">
      <?php if ($mission) { ?><div id="mission"><?php print $mission ?></div><?php } ?>
      <div id="main">
<div class="ac_outer">
        <?php print $breadcrumb ?>
	<?php
	//
	// Facebook code.
	//
	$url = $GLOBALS["base_url"] . request_uri();
	$url_string = rawurlencode($url);
	$fb_url = "http://www.facebook.com/plugins/like.php?"
		. "href=${url_string}&amp;"
		. "layout=button_count&amp;show_faces=true&amp;action=like&amp;font&amp;colorscheme=light"
		;
	?>
	<h1 class="title"><?php print $title ?>
		<?php
		//
		// If we are running under Wamp, that only happens
		// for onsite reg, so suppres the Facebook Like 
		// button there. 	
		//
		if (!strstr($_SERVER["DOCUMENT_ROOT"], "/wamp/")) {
		?>
		<iframe src="<?php print $fb_url; ?>" 
		scrolling="no" frameborder="0" 
		style="border:none; overflow:hidden; width:90px; height: 40px; float: right; padding-top: 5px; " 
		allowTransparency="true"></iframe>
		<?php
		}
		?>
	</h1>
<?php
	//
	// If this is a forum post and the user is not logged in, print
	// a message promting them to do so.
	//
	if (
		!$GLOBALS["user"]->uid
		&& (
			$node->type == "forum"
			|| $_REQUEST["q"] == "recent"
			|| strstr($_REQUEST["q"], "forum")
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
			. "<li>The ability to participate in a community of over 6,000 furry fans!</li>\n"
			. "</ul>\n"

			. "<span style=\"font-size: larger; \">"
			. "Creating an account is easy. <a href=\"/user\">Register now!</a>\n"
			. "</span>"

			. "</div>";
	
		print $html;

/*
// Store is live, let's comment this out for now.
	} else if (
		$node->type == "product"
		|| $node->type == "dvd"
		|| $node->type == "misc"
		|| $node->type == "tshirt"
		|| (!empty($_GET["q"]) && strstr($_GET["q"], "cart"))
		|| (!empty($_GET["q"]) && strstr($_GET["q"], "catalog"))
		|| (!empty($_GET["q"]) && strstr($_GET["q"], "node/5974"))
		) {
			$html = "<div style=\"border: 1px solid black; font-size: large; "
				. "text-align: center; padding: 5px; margin: 5px; \" "
				. "class=\"messages\" "
				. ">"
				. "Welcome to the Anthrocon Store!<br/>"
				. "We're not quite finished setting up the store yet, so "
				. "feel free to browse around and add things to your cart, "
				. "but you won't be able to get very far into the checkout "
				. "process. </br>"
				. "Watch this space for more updates.<br/>"
				. "</div>";
	
			print $html;
*/

	} else {
		//
		// If this is a forum post and it was created before/on the last day of the
		// 2007 convention, put a blurb at the top about it being from a past con.
		// In future years, I can make the message be convention year specific.
		//
		$date = date("Ymd", $node->created);
		if (
			//$date <= 20070708
			//$date <= 20080629
			//$date <= 20090706
			$date <= 20100616
			&& $node->type == "forum" 
			&& empty($node->teaser)
			&& !$sticky
			) {
			$html = "<div style=\"border: 1px solid black; font-size: large; "
				. "text-align: center; padding: 5px; margin: 5px;\" "
				. "class=\"messages\"; "
				. ">"
				. "This page is from a past convention.  It is kept here for archival "
				. "and informational purposes only.<br>\n"
				. "Please visit <a href=\"/forums\">our forums</a> for the latest "
				. "announcements and discussion."
				. "</div>";
	
			print $html;

		}

	}

?>
        <div class="tabs"><?php print $tabs ?></div>
        <?php print $help ?>
        <?php print $messages ?>
        <?php print $content; ?>
      </div>
</div> <?php // End of .ac_outer ?>
    </td>
    <?php if ($right) { ?><td id="sidebar-right">
      <?php print $right ?>
    </td><?php } ?>
  </tr>
 
</table>

<div id="footer">
<table border="0">
<tr>
<td>
<img src="/<?php print $directory; ?>/images/anthrocon-2011/bunny-hat.png" />
</td>
<td width="100%">
<?php //print $footer_message ?>
&copy; 1996-<?php print date("Y"); ?>, Anthrocon, Inc. / PO Box 476 / Malvern, PA 19355 
	- "Fur, Fun, And So Much More!"
	- Use of this website <a href="/legal">covered by our AUP</a>.
<p>

Anthrocon and the Anthrocon logo are registered servicemarks of Anthrocon, Inc., a Pennsylvania-incorporated 501(c)7 nonprofit organization
<p>

Site design by <a href="http://www.cuprohastes.com/">Cuprohastes</a>.<br/>
<br/>

<a href="/about">About</a>
| 
<a href="/sitemap">Site Map</a>
| 
<a href="http://twitter.com/anthrocon">Twitter</a>
| 
<a href="http://www.facebook.com/group.php?gid=49844448265">Facebook</a>
| 
<a href="http://www.flickr.com/groups/anthrocon/pool/">Flickr</a>
| 
<a href="http://www.youtube.com/user/anthrocon">YouTube</a>
|
<a href="/contact">Contact Us</a>

</td>
</tr>
</table>

<?php
//
// This is stupid, but it should fix some overflow problems we've been having
// on the footer.
// See http://archivist.incutio.com/viewlist/css-discuss/51230
// for details.
//
?>
<br style="clear: both; " />

<?php print $closure ?>
<?php
//
// Code for our "corner of trust" graphic.
//
?>
<!--
<a href="http://www.instantssl.com" id="comodoTL">SSL</a>
-->
<script language="JavaScript" type="text/javascript">
//
// Only display when connecting via HTTPS.
//
if (window.location.protocol == "https:") {
	//COT("https://www.anthrocon.org/sites/all/themes/anthrocon/trust_logo.gif", "SC2", "none");
}
</script>
</body>
</html>
