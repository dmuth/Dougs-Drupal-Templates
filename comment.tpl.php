  <div class="comment<?php if ($comment->status == COMMENT_NOT_PUBLISHED) print ' comment-unpublished'; ?>">
<h3 class="title"><?php print $title; ?></h3><?php if ($new != '') { ?><span class="new"><?php print $new; ?></span><?php } ?>
    <div class="submitted"><?php print $submitted; ?></div>

<table>
<tr>
<td valign="top">
<?php 
if ($picture) {
	print $picture;
} 
?>
</td>
<td valign="top">
<div class="content"><?php print $content; ?></div>
</td>
</tr>
</table>

    <div class="links">&raquo; <?php print $links; ?></div>
  </div>
