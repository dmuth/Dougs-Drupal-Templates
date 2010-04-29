<?php

//
// Print a note when we are in the dev site
//
if (strstr($directory, "dev")) {
	$message = "DEVELOPMENT TEMPLATE - If you think you shouldn't be seeing "
		. "this, please <a href=\"/contact\">contact us</a>.";
	$head_title .= " - " . $message;
	print $message;
}

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
// jQuery cookie plugin.
//
?>
<script type="text/javascript" src="/<?php print $directory; ?>/cookie.js"></script>
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
	background="/<?php print $directory; ?>/logo.jpg"
	>
<div id="menu">
      <?php if (isset($primary_links)) { 
	?><div id="primary"><?php print theme('links', $primary_links) ?></div><?php 
	} ?>
</div>
</td>
</tr>
  <tr>
    <?php if ($left) { ?><td id="sidebar-left">
      <?php print $left ?>
    </td><?php } ?>
    <td valign="top">
      <?php if ($mission) { ?><div id="mission"><?php print $mission ?></div><?php } ?>
      <div id="main">
<div class="ac_outer">
        <?php print $breadcrumb ?>
        <h1 class="title"><?php print $title ?></h1>
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
			. "padding: 5px; margin: 5px;\">"

			. "Welcome <b>furry fans</b>!</p>\n"
			. "We're glad you stopped by.  Go ahead and "
				. "<a href=\"/user\">register for a free account</a> "
				. "to get the benefits of being a member, including:\n"
			. "<ul>\n"
			. "<li>Access to all of our posts and comments</li>\n"
			. "<li>Your own profile including an avatar, buddy lists, and other social networking features</li>\n"
			. "<li>The ability to participate in a community of over 5,000 furry fans!</li>\n"
			. "</ul>\n"

			. "<span style=\"font-size: larger; \">"
			. "Creating an account is easy. <a href=\"/user\">Register now!</a>\n"
			. "</span>"

			. "</div>";
	
		print $html;
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
<img src="/<?php print $directory; ?>/images/Buffalo-chase.png" />
</td>
<td width="100%">
  <?php print $footer_message ?>
Site design by <a href="http://www.cuprohastes.com/">Cuprohastes</a>.
<?php
/*
Page last generated: <?php print date("r"); ?> 
</div>
*/
?>
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