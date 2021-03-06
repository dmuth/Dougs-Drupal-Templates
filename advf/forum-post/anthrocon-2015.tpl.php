<?php
// $Id: advf-forum-post.tpl.php,v 1.1.2.21 2009/02/07 04:40:48 michellec Exp $

/**
 * @file
 *
 * Theme implementation: Template for each forum post whether node or comment.
 *
 * All variables available in node.tpl.php and comment.tpl.php for your theme
 * are available here. In addition, Advanced Forum makes available the following
 * variables:
 *
 * - $top_post: TRUE if we are formatting the main post (ie, not a comment)
 * - $reply_link: Text link / button to reply to topic.
 * - %total_posts: Number of posts in topic (not counting first post).
 * - $new_posts: Number of new posts in topic, and link to first new.
 * - $links_array: Unformatted array of links.
 * - $account: User object of the post author.
 * - $name: User name of post author.
 * - $author_pane: Entire contents of advf-author-pane.tpl.php.

 */

//
// Load our functions conditionally.
// The reason for this function_exists() silliness is because touching the
// lib/display.inc.php file causes the first reload afterward to somwhoe
// load the file twice.
//
if (!function_exists("check_private_messages")) {
	$file = dirname(__FILE__) . "/../../lib/display.inc.php";
	include($file);
}

//
// Reference to our public profile array
//
$public_profile = $account->content["Public Profile"];
//print_r($public_profile); // Debugging

//
// Each of our social networks.
//
$social_html = get_social_network_links($public_profile);

?>

<?php if ($top_post): ?>

  <?php print $topic_header ?>
  
  <?php $classes .= $node_classes; ?>
  <div id="node-<?php print $node->nid; ?>" class="top-post forum-post <?php print $classes; ?> clear-block">

<?php else: ?>
  <?php $classes .= $comment_classes; ?>
  <div id="comment-<?php print $comment->cid; ?>" class="forum-post <?php print $classes; ?> clear-block">
<?php endif; ?>

  <div class="post-info clear-block">
    <div class="posted-on">
      <?php print $date ?>
	<?php
		$uid = $account->uid;
	?>
	 - <?php print l($account->name, "user/$uid"); ?> 

	<?php
	//
	// Print the public display name
	//
	$name = "";

	if (!empty($public_profile["profile_display_name"]["#value"])) {
		$name = "(" . $public_profile["profile_display_name"]["#value"] . ")";
	}

	?>

	<span class="author-real-name">
	<?php print $name; ?> 

	<?php 
	$joined = format_date($account->created, "custom", "M j, Y");
	?>
	</span>

	<span class="author-joined">
	<?php print t('Member since'); ?>: 
	<?php print $joined; ?>
	</span> 
	<br/>

	<div class="profile-icons" style="margin-top: 5px; ">
	<?php print $social_html; ?>
	</div>

	<?php //$comment->new = true; $new = "new"; // Debugging ?>
      <?php if (!$top_post && !empty($comment->new)): ?>
        <a id="new"><span class="new">(<?php print $new ?>)</span></a>
      <?php endif; ?>

    </div>

    <?php if (!$top_post): ?>
      <span class="post-num"><?php print $comment_link . ' ' . $page_link; ?></span>
    <?php endif; ?>

  </div>

  <div class="forum-post-wrapper" >

    <div class="forum-post-panel-sub">
      <?php print $author_pane; ?>
    </div>

    <div class="forum-post-panel-main clear-block">
      <?php if ($title && !$top_post): ?>
        <div class="post-title">
          <?php print $title ?>
        </div>
      <?php endif; ?>

      <div class="content">
        <?php print $content ?>
      </div>

      <?php if ($signature): ?>
        <div class="author-signature">
          <?php print $signature ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="forum-post-footer clear-block">
    <div class="forum-jump-links">
      <a href="#top" title="Jump to top of page"><?php print t("Top"); ?></a>
    </div>

    <?php if (!empty($links)): ?>
      <div class="forum-post-links">
        <?php print $links ?>
      </div>
    <?php endif; ?>
  </div>
</div>
