<?php
//
// Print a note when we are in the dev site
//
if (strstr($directory, "-dev")) {
	$message = "DEVELOPMENT TEMPLATE - If you think you shouldn't be seeing "
		. "this, please contact Giza.";
	$head_title .= " - " . $message;
	print $message;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
</head>

<body>

<table border="0" cellpadding="0" cellspacing="0" id="header"
	>
  <tr>
    <td id="logo">
      <?php if ($logo) { ?><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" /></a><?php } ?>
      <?php if ($site_name) { ?><h1 class='site-name'><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><?php print $site_name ?></a></h1><?php } ?>
      <?php if ($site_slogan) { ?><div class='site-slogan'><?php print $site_slogan ?></div><?php } ?>
    </td>
    <td id="menu">
      <?php if (isset($secondary_links)) { ?><div id="secondary"><?php print theme('links', $secondary_links) ?></div><?php } ?>
<!--
      <?php if (isset($primary_links)) { ?><div id="primary"><?php print theme('links', $primary_links) ?></div><?php } ?>
-->
      <?php print $search_box ?>
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
      <?php if ($mission) { ?><div id="mission"><?php print $mission ?></div><?php } ?>
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
	. "padding: 5px; margin: 5px;\">"
	
	. "Welcome <b>furry fans</b>!</p>\n"
	. "We're glad you stopped by.  Go ahead and "
	. "<a href=\"/user\">register for a free account</a> "
	. "to get the benefits of being a member, including:\n"

	. "<ul>\n"
	. "<li>Access to all of our posts and comments</li>\n"
	. "<li>Your own profile including an avatar, buddy lists, and other social networking features</li>\n"
	. "<li>The ability to chat and interact with other furries in and around Pennsylvania.</li>\n"
	. "</ul>\n"

	. "<span style=\"font-size: larger; \">"
	. "Creating an account is easy. <a href=\"/user\">Register now!</a>"
	. "</span>\n"
	. "<br/>\n"
	. "<br/>\n"

	. "(Not a furry fan?  That's cool.  <a href=\"/who-is-welcome-here\">You're still welcome here.</a>)"
	
	. "</div>";
		
	print $html;

}

?>
        <div class="tabs"><?php print $tabs ?></div>
        <?php print $help ?>
        <?php print $messages ?>
        <?php print $content; ?>
      </div>
    </td>
    <?php if ($right) { ?><td id="sidebar-right">
      <?php print $right ?>
    </td><?php } ?>
  </tr>
</table>


<div id="footer">
  <?php print $footer_message ?><p>

All posts and comments on this site are Copyright (C) their authors.  All other content is licensed under the Gnu Free Documentation License.<br/><br/>

Website design by <a href="/user/8">Omnibahumut</a>.  We think he rocks.<br/><br/>


</div>
<?php print $closure ?>
</body>
</html>
