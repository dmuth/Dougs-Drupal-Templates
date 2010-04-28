  <div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
    <?php if ($page == 0) { ?><h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2><?php }; ?>
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
	$submitted = "Subbmited by " . l($node->name, "user/" . $node->uid)
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

?>
</span>
<table border="0">

<tr>
<td valign="top">
<?php if ($picture) {
	//
	// Print the picture ONLY if this is a forum post and not a "teaser",
	// which means an abbreciated post shown on the front page.
	//
	if (empty($node->teaser)) {
		if ($node->type == "forum" || $node->type == "blog" || $node->type == "event") {
			print $picture;
			$account = user_load($node->uid);
			$template = "advf-author-pane";
			//$author_pane = theme('author_pane', $account, advanced_forum_path_to_images(), $template);
			//print $author_pane;
		}
	}
}

?>

</td>

<td>
    <div class="content"><?php print $content?></div>
</td>
</tr>

</table>

    <?php if ($links) { ?><div class="links">&raquo; <?php print $links?></div><?php }; ?>

  </div>
