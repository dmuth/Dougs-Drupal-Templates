<?php

include_once("functions.inc.php");

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

<?php

	//
	// If this is a forum post and it was created before/on the last day of the
	// 2007 convention, put a blurb at the top about it being from a past con.
	// In future years, I can make the message be convention year specific.
	//
	$date = date("Ymd", $node->created);
	if (
		//$date <= 20070708
		//$date <= 20080629
		$date <= 20090706
		&& $node->type == "forum" 
		&& empty($node->teaser)
		&& !$sticky
		) {
		$html = "<div style=\"border: 1px solid black; font-size: large; "
			. "text-align: center; padding: 5px; margin: 5px;\">"
			. "This page is from a past convention.  It is kept here for archival "
			. "and informational purposes only.<br>\n"
			. "Please visit <a href=\"/forums\">our forums</a> for the latest "
			. "announcements and discussion."
			. "</div>";
	
		print $html;
	}

?>
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
