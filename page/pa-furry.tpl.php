<?php
//
// Load our functions conditionally.
// The reason for this function_exists() silliness is because touching the
// lib/display.inc.php file causes the first reload afterward to somwhoe
// load the file twice.
//
if (!function_exists("check_private_messages")
	|| !function_exists("check_dev_theme")
	) {
	$file = dirname(__FILE__) . "/../lib/display.inc.php";
	include($file);
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
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=555152114579817";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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
      <?php if (isset($primary_links)) { ?><div id="primary"><?php print theme('links', $primary_links) ?></div><?php } ?>
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
	<?php
	//
	// Facebook code.
	//
	$url = $GLOBALS["base_url"] . request_uri();

	$fb_html = "<div class=\"fb-like\" "
		. "style=\"float: right; padding-top: 10px; height: 24px; \" "
		. "data-href=\"${url}\" "
		. "data-layout=\"button_count\" data-action=\"like\" "
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
	?>
	<h1 class="title"><?php print $title ?>
	<?php
		//
		// If we are running under Wamp, that only happens
		// for onsite reg, so suppres the Facebook Like 
		// button there. 	
		//
		if (
			!strstr($url, "/edit")
			&& !strstr($url, "/admin")
			) {
			//print $fb_html;
			//print $plus_one_html;
			?>
			<div style="float: right; padding-top: 10px; height: 24px; ">
			<div class="addthis_native_toolbox"></div>
			</div>
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
	. "<li>The ability to send private messages to other users on this site</li>\n"
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


<a name="footer"></a>
<div id="footer">

    <div id="footer-region" class="clearfloat">
      <div id="footer-left" class="clearfloat">
        <?php print $footer_left; ?>
      </div> 		

      <div id="footer-middle" class="clearfloat">
        <?php print $footer_middle; ?>
      </div>

      <div id="footer-right" class="clearfloat">
        <?php print $footer_right; ?>
      </div>
    </div>

    <div id="footer-message">
	<?php print $footer; ?>
  	<?php print $footer_message ?><p>

All posts and comments on this site are Copyright (C) their authors.
All other content is licensed under the Gnu Free Documentation License.<br/>
<br/>

<a href="/whatisfurry">What Is "Furry"?</a>
| 
<a href="/events">Calendar</a>
| 
<a href="/tags">Tag Cloud</a>
| 
<a href="/search">Search</a>
| 
<a href="/contact">Contact Us</a>
| 
<a href="https://www.facebook.com/pages/Pennsylvania-Furries/242129352474917">PA Furries on Facebook</a>
<br/>
<br/>

    </div>

</div>
<?php print $closure ?>
<?php // Widget code for AddThis ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-572ab4887648a861"></script>
</body>
</html>
