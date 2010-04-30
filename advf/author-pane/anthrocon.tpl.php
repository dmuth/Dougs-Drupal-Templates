<?php
// $Id: advf-author-pane.tpl.php,v 1.6 2010/04/15 04:33:40 doug Exp $

/**
 * @file
 * Theme implementation to display information about the post/profile author.
 *
 * See author-pane.tpl.php in Author Pane module for a full list of variables.
 */
?>

<?php
//
// Reference to our public profile array
//
$public_profile = $profile["Public Profile"];

//
// Our base URI for icons in this template.
//
$path = $GLOBALS["base_path"] . "sites/all/themes/" . $GLOBALS["theme"];

?>

<div class="author-pane">
 <div class="author-pane-inner">
    <div class="author-pane-name-status author-pane-section">
      <div class="author-pane-line author-name"> 
	<?php print $account_name; ?> 
	</div>

      <div class="author-pane-line author-real-name"> 
	<?php
	//
	// Print the public display name
	//
	$name = "";

	if (!empty($public_profile["profile_display_name"]["#value"])) {
		$name = "(" . $public_profile["profile_display_name"]["#value"] . ")";
	}

	?>

	<?php print $name; ?> 
	</div>

      <?php if (!empty($facebook_status_status)): ?>
        <div class="author-pane-line author-facebook-status"><?php print $facebook_status_status;  ?></div>
      <?php endif; ?>

      <?php if (!empty($picture)): ?>
        <?php print $picture; ?>
      <?php endif; ?>

      <?php if (!empty($user_title)): ?>
        <div class="author-pane-line author-title"> <?php print $user_title; ?> </div>
      <?php endif; ?>
      
      <?php if (!empty($user_badges)): ?>
        <div class="author-pane-line author-badges"> <?php print $user_badges;  ?> </div>
      <?php endif; ?>

	<?php 
	//
	// Print up the poster's location.
	//
	if (!empty($public_profile["profile_location"]["#value"])) {
		$location = $public_profile["profile_location"]["#value"];
	}
	?>
      <?php if (!empty($location)): ?>
        <div class="author-pane-line author-location">
	Location: <?php print $location;  ?>
	</div>
      <?php endif; ?>

        <div class="author-pane-line author-comment">
	<?php

	//
	// Print up the user comment
	//
	if (!empty($public_profile["profile_comment"]["#value"])) {
		//$html = check_plain($public_profile["profile_comment"]["#value"]);
		$html = ($public_profile["profile_comment"]["#value"]);
		$html = "<em>\"" . $html . "\"</em><br/>\n";
		print $html;
	}

	?>
	</div>

	<?php

	//
	// Generate HTML code for each of our social networks
	// Note that this code is also in user-profile.tpl.php
	// I'd like to put the below code into a function someday...
	//
	$html = "";

	//$public_profile["profile_blog"]["#value"] = 12345; // Debugging
	//$public_profile["profile_icq"]["#value"] = 12345; // Debugging

	//
	// Array of fields for our different social networks
	//
	$fields = array();
	$fields["profile_website"] = array(
		"img" => "home.png",
		"alt" => t("Personal Website"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_blog"] = array(
		"img" => "blog.png",
		"alt" => t("Blog"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_linkedin"] = array(
		"img" => "linkedin.png",
		"alt" => t("LinkedIn Profile"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_aim"] = array(
		"img" => "aim.png",
		"alt" => t("AOL Instant Messenger"),
		"add_http" => false,
		"pre_link" => "aim:goim?screenname=",
		);
	$fields["profile_google_talk"] = array(
		"img" => "gtalk.png",
		"alt" => t("Google Talk"),
		"pre_link" => "gtalk:chat?jid=",
		);
	$fields["profile_yahoo"] = array(
		"img" => "yahoo.png",
		"alt" => t("Yahoo Messenger"),
		"pre_link" => "ymsgr:sendIM?",
		);
	$fields["profile_icq"] = array(
		"img" => "icq.png",
		"alt" => t("ICQ"),
		"pre_link" => "aim:goim?screenname=",
		);
	$fields["profile_msn"] = array(
		"img" => "msn.png",
		"alt" => t("Microsoft Messenger"),
		"pre_link" => "msnim:chat?contact=",
		);
	$fields["profile_da"] = array(
		"img" => "da.png",
		"alt" => t("DeviantArt"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_lj"] = array(
		"img" => "lj.png",
		"alt" => t("LiveJournal"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_skype"] = array(
		"img" => "skype.png",
		"alt" => t("Skype"),
		"pre_link" => "skype:",
		"post_link" => "?userinfo",
		);
	$fields["profile_flickr"] = array(
		"img" => "flickr.png",
		"alt" => t("Flickr"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_twitter"] = array(
		"img" => "twitter.png",
		"alt" => t("Twitter"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_facebook"] = array(
		"img" => "facebook.png",
		"alt" => t("Facebook"),
		"add_http" => true,
		"target" => "_blank",
		);
	$fields["profile_delicious"] = array(
		"img" => "delicious.png",
		"alt" => t("Delicious"),
		"add_http" => true,
		"target" => "_blank",
		);

	//
	// Loop through our social networks and print up an image and 
	// link for each
	//
	foreach ($fields as $key => $value) {

		if (empty($public_profile[$key]["#value"])) {
			continue;
		}

		$img = $path . "/icons/" . $value["img"];
		$alt = $value["alt"];

		$link = strip_tags($public_profile[$key]["#value"]);

		//
		// Add in the http:// protocol if it's not present.
		//
		if (!empty($value["add_http"])) {
			if (!stristr($link, "http://")) {
				$link = "http://" . $link;
			}
		}

		//
		// Pre and post link text.
		//
		if (!empty($value["pre_link"])) {
			$link = $value["pre_link"] . $link;
		}

		if (!empty($value["post_link"])) {
			$link = $link . $value["post_link"];
		}

		//
		// See if we have a custom target
		//
		$target = "";
		if (!empty($value["target"])) {
			$target = "target=\"" . $value["target"] . "\"";
		}

		$html .= "<a href=\"" . $link . "\" $target ><img src=\"" 
			. $img . "\" title=\"$alt\" height=\"16\" border=\"0\" "
			. "/></a>";

	}


	if (!empty($html)) {
		//
		// Wrap these all in a class.
		//
		$html = "<span class=\"profile_icons\">" . $html . "</span>";
		print $html;
	}

	?>

    </div>

      <?php if (!empty($privatemsg)): ?>
        <div class="author-pane-icon"><?php print $privatemsg; ?></div>
      <?php endif; ?>

    <div class="author-pane-stats author-pane-section">
      <?php if (!empty($joined)): ?>
        <div class="author-pane-line author-joined">
          <span class="author-pane-label"><?php print t('Joined'); ?>:</span> 
	<?php 
	//
	// For some reason, there's a colon with numbers on the end.  Let's
	// just split out spaces to get rid of them.
	//
	$results = explode(" ", $joined);
	$joined = $results[0];
	print $joined; 
	?>
        </div>
      <?php endif; ?>

      <?php if (isset($user_stats_posts)): ?>
        <div class="author-pane-line author-posts">
          <span class="author-pane-label"><?php print t('Posts'); ?>:</span> <?php print $user_stats_posts; ?>
        </div>
      <?php endif; ?>

        <div class="author-pane-icon"><?php //print $user_relationships_api; ?></div>
	<?php
		//
		// Print a link to the user's buddy list
		//
		$uid = $account->uid;
		$url = "user/$uid/buddies";
		$url_text = t("Buddy List");
		$link = l($url_text, $url);
		print $link;
	?>
      <?php if (!empty($user_relationships_api)): ?>
      <?php endif; ?>
      
      <?php if (isset($userpoints_points)): ?>
        <div class="author-pane-line author-points">
          <span class="author-pane-label"><?php print t('!Points', userpoints_translation()); ?></span>: <?php print $userpoints_points; ?>
        </div>
      <?php endif; ?>

      <?php if (isset($og_groups)): ?>
        <div class="author-pane-line author-groups">
          <span class="author-pane-label"><?php print t('Groups'); ?>:</span> <?php print $og_groups; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="author-pane-admin author-pane-section">
      <?php if (!empty($user_stats_ip)): ?>
        <div class="author-pane-line author-ip">
          <span class="author-pane-label"><?php print t('IP'); ?>:</span> <?php print $user_stats_ip; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($fasttoggle_block_author)): ?>
        <div class="author-fasttoggle-block"><?php print $fasttoggle_block_author; ?></div>
      <?php endif; ?>

      <?php if (!empty($troll_ban_author)): ?>
        <div class="author-pane-line author-troll-ban"><?php print $troll_ban_author; ?></div>
      <?php endif; ?>        
    </div>

    <div class="author-pane-contact author-pane-section">
      <?php if (!empty($contact)): ?>
        <div class="author-pane-icon"><?php print $contact; ?></div>
      <?php endif; ?>

      <?php if (!empty($buddylist)): ?>
        <div class="author-pane-icon"><?php print $buddylist; ?></div>
      <?php endif; ?>

      <?php if (!empty($flag_friend)): ?>
        <div class="author-pane-icon"><?php print $flag_friend; ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>
