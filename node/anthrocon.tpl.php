<?php

//
// Load our library file
//
$file = getcwd() . "/" . $directory . "/lib.inc.php";
include_once($file);

//
// Load the profile for the user behind this node
//
profile_load_profile($node);

$submitted = _get_submitter($node, $node->created);

?>
  <div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
    <?php if ($page == 0) { ?><h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2><?php }; ?>
    <span class="submitted"><?php print $submitted?></span>
    <span class="taxonomy"><?php print $terms?></span>

<table border=0>
<tr>
<td valign="top">
    <?php 

	//
	// Print profile info ONLY if this is a forum post and is not part of 
	// a teaser, so that it doesn't show up on the front page.
	//
	if (
		($node->type == "forum" 
		|| $node->type == "poll")
		&& empty($node->teaser)
		) {

		print $picture;

		print _get_user_info($node);

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
