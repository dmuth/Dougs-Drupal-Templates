<?php
//
// Load our functions conditionally.
// The reason for this function_exists() silliness is because touching the
// lib/display.inc.php file causes the first reload afterward to somwhoe
// load the file twice.
//
if (!function_exists("check_private_messages")) {
	$file = dirname(__FILE__) . "/../lib/display.inc.php";
	include($file);
}

//
// Are we in the dev theme?
//
check_dev_theme($directory);

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
<?php
//
// Load our custom JS
//
?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
</head>

<body>

<table border="0" cellpadding="0" cellspacing="0" id="header">
  <tr>
    <td id="logo" rowspan="2">
	<a href="/"><img src="/<?php print $directory; ?>/logo.jpg" 
		border="0" 
		height="150"
		/></a>
      <?php if ($logo) { ?><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" /></a><?php } ?>
	</td>
	<td id="site-name-cell" >
      <?php if ($site_name) { ?><span class='site-name'><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><?php print $site_name ?></a></span><?php } ?>
    </td>
    <td id="menu">
      <?php if (isset($secondary_links)) { ?><?php print theme('links', $secondary_links, array('class' =>'links', 'id' => 'subnavlist')) ?><?php } ?>
      <?php if (isset($primary_links)) { ?><?php print theme('links', $primary_links, array('class' =>'links', 'id' => 'navlist')) ?><?php } ?>
      <?php print $search_box ?>
    </td>
  </tr>
	<tr>
	<td colspan="1" valign="bottom">
      <?php if ($site_slogan) { ?><div class='site-slogan'><?php print $site_slogan ?></div><?php } ?>
	</td>
	</tr>
  <tr>
    <td colspan="2"><div><?php print $header ?></div></td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" id="content">
  <tr>
    <?php if ($left) { ?><td id="sidebar-left">
      <?php print $left ?>
    </td><?php } ?>
    <td valign="top">
      <div id="main">
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
		strstr($_REQUEST["q"], "recent")
		|| $node->type == "event"
		|| $node->type == "blog"
	)
	) {
	
	$html = "<div style=\"border: 1px solid black; "
	//. "font-size: large; "
	. "padding: 5px; margin: 5px;\">"
	
	. "Welcome <b>Ardmore residents</b>!</p>\n"
	. "We're glad you stopped by.  Go ahead and "
	. "<a href=\"/user\">register for a free account</a> "
	. "to get the benefits of being a member, including:\n"

	. "<ul>\n"
	. "<li>Access to all of our posts and comments</li>\n"
	. "<li>Your own profile including an avatar, buddy lists, and other social networking features</li>\n"
	. "<li>The ability to send private messages to other users on this site</li>\n"
	. "<li>The ability to chat and interact with other citizens in and around Ardmore, Pennsylvania.</li>\n"
	. "</ul>\n"

	. "<span style=\"font-size: larger; \">"
	. "Creating an account is easy. <a href=\"/user\">Register now!</a>"
	. "</span>\n"
	. "<br/>\n"
	. "<br/>\n"

	. "(Don't live in Ardmore?  That's okay.  We won't hold it aginst you.)"
	
	. "</div>";
		
	print $html;

}

?>
        <div class="tabs"><?php print $tabs ?></div>
        <?php print $help ?>
        <?php print $messages ?>
        <?php print $content; ?>
        <?php print $feed_icons; ?>
      </div>
    </td>
    <?php if ($right) { ?><td id="sidebar-right">
      <?php print $right ?>
    </td><?php } ?>
  </tr>
</table>

<div id="footer">
  <?php print $footer_message ?>
  Copyright 2006-<?php print date("Y"); ?>, <a href="/contact">SABA</a> / P.O. Box 772, Ardmore, PA 19003
</div>
<?php print $closure ?>
</body>
</html>
