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

?>
<div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
<?php 
if ($page == 0) { 
	?>
	<h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2>
	<?php 
}; 
?>
    
<span class="submitted"><?php 

//
// Load profile data for this user
//
profile_load_profile($node);

//
// Grab their public display name, if present.
//
$name = "";
if (!empty($node->profile_display_name)) {
	$name = " (" . $node->profile_display_name . ")";
}

//
// Glue in their name
//
$submitted = "Submitted by " . l($node->name, "user/" . $node->uid)
	. $name
	. " on "
	. format_date($node->created)
	;

	print $submitted;
	?></span>
<span class="taxonomy">
<?php
if (!empty($terms)) {
	print "Tags: " . $terms;
}

?></span>

<table border=0>
<tr>
<td valign="top">
<?php 

if ($picture) {
	//
	// Print the picture only if this is not sticky and if the node is
	// a forum post or is a teaser.
	//
	if (
		(
			$node->type == "forum" 
			|| (
				//($node->type == "page" || $node->type == "blog")
				!empty($node->teaser)
			)
		)
		//&& empty($node->teaser)
		&& empty($node->sticky)
		) {
			//print $picture;
			$account = user_load($node->uid);
			$template = "advf-author-pane";
			$author_pane = theme('author_pane', $account, advanced_forum_path_to_images(), $template);
			print $author_pane;
	}
}
?>
</td>
<td valign="top">
<div class="content"><?php print $content?></div>
</td>
</tr>

</table>

    <?php if ($links) { ?><div class="links">&raquo; <?php print $links?></div><?php }; ?>
  </div>
