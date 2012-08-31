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
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
</head>

<?php
//
// Set our image directory
//
$image_dir = "/" . $directory . "/images/fcn-2013";

?>
<body style="background: #0b3926; background-repeat: repeat-x; background-position: top">

<!--
<span id="sidebar-left" 
	style="
		background: url(<?php print $image_dir . "/background-left.gif"; ?>) no-repeat; 
		float: left; height: 1500px; width:130px; 
		"
	></span>
-->
<span id="sidebar-left" 
	style="float: left; height: 1500px; width:130px; 
		background: #0b3926;
		"
	></span>

<span id="fcn-header" style="float: left; background-color: #f9f8f3; ">

<?php // The set of two header graphics and Menus ?>
<div id="fcn-header-graphics" style="padding: 0; " >

<div style="float: left; ">
<img src="<?php print $image_dir . "/header-left.gif"; ?>" style=" " />
</div>

<div style="float: left; ">

	<div id="primary" style="background-color: black; width: 100%; height: 29px; padding-right: 0px; ">
	<?php print theme('links', $primary_links) ?>
	</div><?php // fcn-links-primary ?>

	<div style="height: 174px; ">
	<img src="<?php print $image_dir . "/header-right.gif"; ?>" style=" " />
	</div>

	<div id="secondary" style="color: white; background-color: black; width: 100%; height: 25px; a">
		<span style="font-style: italic; ">
		April 12 - 14, 2013 Detroit Novi Sheraton
		</span>
		<div style="float: right; padding-right: 20px; ">
		<?php print theme('links', $secondary_links) ?>
		</div>
	</div> <?php // fcn-links-secondary ?>

</div>

</div><?php // fcn-header-graphics ?>
<br clear="all" />

<?php // The center part of the site, including the left sidebar ?>
<div id="fcn-center" 
	><div id="sidebar-left" style="float: left; ">
<a href="http://twitter.com/furryconnect"><img src="<?php print $image_dir; ?>/twitter.png" class="social-icon" /></a>
<a href="http://www.facebook.com/pages/Furry-Connection-North/177692785151"><img src="<?php print $image_dir; ?>/facebook.png" class="social-icon" /></a>
<a href="http://fcn-convention.livejournal.com/"><img src="<?php print $image_dir; ?>/livejournal.png"  class="social-icon" /></a>
<a href="/tags"><img src="<?php print $image_dir; ?>/tags.png" class="social-icon" /></a>
<?php print $left; ?>
</div><?php // sidebar-left ?>


<div id="fcn-main" style="background-color: white; float: left; width: 763px; background-color: #f9f8f3; ">
<?php

include_once("fcn-2013/main.tpl.php");

include_once("fcn-2013/footer.tpl.php");

?>
</div><?php // fcn-main ?>

</div><?php // fcn-center ?>

</span><?php // fcn-header ?>

<!--
<span id="sidebar-right" 
	style="background: url(<?php print $image_dir . "/background-right.gif"; ?>) no-repeat; float: left; height: 1500px; width: 130px; "
	></span>
-->

<br clear="all" />

<?php //print $closure ?>
</body>
</html>
