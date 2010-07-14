<?php
/**
* Custom profile page to override the default one.
*
* @param $account Object of the account that is being displayed.
*
* Last modified: 23 Apr 2010, DTM
*/

//
// Load our functions conditionally.
// The reason for this function_exists() silliness is because touching the
// lib/display.inc.php file causes the first reload afterward to somwhoe
// load the file twice.
//
if (!function_exists("check_private_messages")) {
	$file = dirname(__FILE__) . "/lib/display.inc.php";
	include($file);
}


$public_profile = $account->content["Public Profile"];
$summary = $account->content["summary"];

//print $user_profile; // Default profile
//print "<pre>"; print_r($account); print "</pre>"; // Debugging
//print "<pre>"; print_r($public_profile); print "</pre>"; // Debugging
//print "<pre>"; print_r($user); print "</pre>"; // Debugging
//$public_profile["profile_blog"]["#value"] = 12345; // Debugging
//$public_profile["profile_icq"]["#value"] = 12345; // Debugging

?>
<div class="profile">

	<?php

	//
	// The user picture.
	//
	$key = "user_picture";
	if (!empty($profile[$key])) {
		//
		// For some reason, not all Drupal-powered sites have this div, 
		// so add it in.
		//
		print "<div class=\"picture\">";
		print check_markup($profile[$key]);
		print "</div>";
	}

	//
	// Our table rows
	//
	$rows = array();

	//
	// Our display name.
	//
	$html = "(none given)";
	$key = "profile_display_name";
	if (!empty($public_profile[$key])) {
		$html = check_plain($public_profile[$key]["#value"]);
	}

	//
	// If the user can write a blog, display a link to that
	//
	if (user_access("create blog entries", $account)) {
		$url = "blog/" . $account->uid;
		$html .= " (" . l("View This User's Blog", $url) . ")";
	}

	//
	// If the user is logged in, give them a link to edit the field
	//
	if ($account->uid == $user->uid) {
		$html .= " "  . l("[Edit]", "user/me/edit/Public Profile");
	}

	$row = array(
		array("valign" => "top", "align" => "right", 
			"class" => "name",
			"data" => t("Name:")),
		array("valign" => "top", "data" => $html)
		);
	$rows[] = $row;

	//
	// User Comment
	//
	$html = "(none given)";
	$key = "profile_comment";
	if (!empty($public_profile[$key])) {
		$html = strip_tags($public_profile[$key]["#value"]);
		//$html = check_plain($public_profile[$key]["#value"]);
		//print htmlentities($html);

		//
		// Remove leading and trailing tags added by check_markup()
		//
		//$regexp = "|^ <p></p><p>|";
		//$html = preg_replace($regexp, "", $html);
		//$regexp = "|</p>\n $|";
		//$html = preg_replace($regexp, "", $html);
		$html = ltrim($html);
		$html = rtrim($html);

		$html = "<em>\"" . $html . "\"</em>";

	}

	//
	// If the user is logged in, give them a link to edit the field
	//
	if ($account->uid == $user->uid) {
		$html .= " "  . l("[Edit]", "user/me/edit/Public Profile");
	}

	$row = array(
		array("valign" => "top", "align" => "right", 
			"class" => "name",
			"data" => t("Comment:")),
		array("valign" => "top", "data" => $html)
		);
	$rows[] = $row;


	//
	// Only print up hobbies if it exists, since it may not be in 
	// all installations.
	//
	if (isset($account->profile_hobbies)) {

		$html = t("(none given)");
		$key = "profile_hobbies";
		
		if (!empty($public_profile[$key])) {
			$html = check_plain($public_profile[$key]["#value"]);
		}
		
		//
		// If the user is logged in, give them a link to edit the field
		//
		if ($account->uid == $user->uid) {
			$html .= " "  . l("[Edit]", "user/me/edit/Public Profile");
		}

		$row = array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("Hobbies:")),
			array("valign" => "top", "data" => $html)
			);
		$rows[] = $row;

	}

	//
	// Only print up species if it exists, since it may not be in
	// all installations.
	//
	if (isset($account->profile_species)) {

		$html = t("(none given)");
		$key = "profile_species";
		
		if (!empty($public_profile[$key])) {
			$html = check_plain($public_profile[$key]["#value"]);
		}
		
		//
		// If the user is logged in, give them a link to edit the field
		//
		if ($account->uid == $user->uid) {
			$html .= " "  . l("[Edit]", "user/me/edit/Public Profile");
		}

		$row = array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("Species:")),
			array("valign" => "top", "data" => $html)
			);
		$rows[] = $row;

	}
	
	//
	// Only print up occupation if it exists, since it may not be in
	// all installations.
	//
	if (isset($account->profile_occupation)) {

		$html = t("(none given)");
		$key = "profile_occupation";
		
		if (!empty($public_profile[$key])) {
			$html = check_plain($public_profile[$key]["#value"]);
		}
		
		//
		// If the user is logged in, give them a link to edit the field
		//
		if ($account->uid == $user->uid) {
			$html .= " "  . l("[Edit]", "user/me/edit/Public Profile");
		}

		$row = array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("Occupation:")),
			array("valign" => "top", "data" => $html)
			);
		$rows[] = $row;

	}
	
	//
	// Only print up foxes if it exists, since it may not be in
	// all installations.
	//
	if (isset($account->profile_foxes)) {

		$html = t("(none given)");
		$key = "profile_foxes";
		
		if (!empty($public_profile[$key])) {
			$html = check_plain($public_profile[$key]["#value"]);
		}
		
		//
		// If the user is logged in, give them a link to edit the field
		//
		if ($account->uid == $user->uid) {
			$html .= " "  . l("[Edit]", "user/me/edit/Public Profile");
		}

		$row = array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("\"All Foxes Are\":")),
			array("valign" => "top", "data" => $html)
			);
		$rows[] = $row;

	}
	
	//
	// Location
	//
	$key = "profile_location";
	$location = "(none given)";
	if (!empty($public_profile[$key])) {
		$location = $public_profile[$key]["#value"];
	}

	//
	// If the user is logged in, give them a link to edit the field
	//
	if ($account->uid == $user->uid) {
		$location .= " "  . l("[Edit]", "user/me/edit/Public Profile");
	}

	$row = array(
		array("valign" => "top", "align" => "right", 
			"class" => "name",
			"data" => t("Location:")),
		array("valign" => "top", "data" => $location)
		);
	$rows[] = $row;

	//
	// Each of our social networks.
	//
	$html = get_social_network_links($public_profile);

	if (empty($html)) {
		$html = "(none given)";
	}

	//
	// If the user is logged in, give them a link to edit the field
	//
	if ($account->uid == $user->uid) {
		$html .= " "  . l("[Edit]", "user/me/edit/Public Profile");
	}

	$row = array(
		array("valign" => "top", "align" => "right", 
			"class" => "name",
			"data" => t("Social&nbsp;Networks:")),
		array("valign" => "top", "data" => $html)
		);
	$rows[] = $row;

	//
	// Bio for this user
	//
	$html = "(none given)";
	if (!empty($account->content["Public Profile - Bio"])) {
		$profile_bio = $account->content["Public Profile - Bio"];
		$html = check_markup($profile_bio["profile_biography"]["#value"]);

		//
		// Remove leading and trailing tags added by check_markup()
		//
		$regexp = "|<p></p><p></p>|";
		$html = preg_replace($regexp, "", $html);
		$regexp = "|</p>\n $|";
		$html = preg_replace($regexp, "", $html);

	}


	//
	// If the user is logged in, give them a link to edit the field
	//
	if ($account->uid == $user->uid) {
		$html .= " "  . l("[Edit]", "user/me/edit/Public Profile - Bio");
	}

	$row = array(
		"class" => "biography",
		"data" => array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("Biography:")),
			array("valign" => "top", "data" => $html)
			)
		);
	$rows[] = $row;


	//
	// Signature
	//
	$html = "(none given)";
	if (!empty($account->signature)) {
		$html = check_markup($account->signature);

		//
		// Remove leading and trailing tags added by check_markup()
		//
		$regexp = "|^ <p></p><p>|";
		$html = preg_replace($regexp, "", $html);
		$regexp = "|</p>\n $|";
		$html = preg_replace($regexp, "", $html);

	}
	
	//
	// If the user is logged in, give them a link to edit the field
	//
	if ($account->uid == $user->uid) {
		$html .= " "  . l("[Edit]", "user/me/edit");
	}

	$row = array(
		"class" => "signature",
		"data" => array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("Forum&nbsp;Signature:")),
			array("valign" => "top", "data" => $html)
			)
		);
	$rows[] = $row;

	//
	// Buddy lists
	//
	$url = "user/" . $account->uid . "/buddies";
	$name = t("!name's Buddy List", array("!name" => $account->name));
	$html = l($name, $url) . "<br/>";


	//
	// Only get user relationships if the UI module is loaded.
	//
	if (module_exists("user_relationships_ui")) {

		$relationships = _user_relationships_ui_between($user, $account);
		if (!empty($relationships)) {

			$html .= "<br/>";
			$name = t("You are !name's:", array("!name" => $account->name));
			$html .= $name . "<br/>";

			$html .= "<ul>";
			foreach ($relationships as $key => $value) {
				$html .= "<li>" . $value . "</li>";
			}
			$html .= "</ul>";

		}

		$relationships = _user_relationships_ui_actions_between($user, $account);

		if (!empty($relationships)) {

			$html .= t("You can:") . "<br/>";

			$html .= "<ul>";
			foreach ($relationships as $key => $value) {
				$html .= "<li>" . $value . "</li>";
			}
			$html .= "</ul>";

		}

		if (!empty($html)) {
			$row = array(
				array("valign" => "top", "align" => "right", 
					"class" => "name",
				"data" => t("Buddies:")),
				array("valign" => "top", "data" => $html)
				);
			$rows[] = $row;

		}

	}

	//
	// Gamer tags
	//
	$html = "";

	if (!empty($summary["wii_gamertag_view"])) {
		$html .= $summary["wii_gamertag_view"]["#value"];
	}

	if (!empty($summary["steam_gamertag_view"])) {
		$html .= $summary["steam_gamertag_view"]["#value"];
	}

	if (!empty($summary["psn_gamertag_view"])) {
		if (!empty($html)) {
			$html .= "<br/>\n";
		}
		$html .= $summary["psn_gamertag_view"]["#value"];
	}

	if (!empty($summary["xbox_gamertag_view"])) {
		if (!empty($html)) {
			$html .= "<br/>\n";
		}
		$html .= $summary["xbox_gamertag_view"]["#value"];
	}

	if (!empty($html)) {
		$row = array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("Gamer Tags:")),
			array("valign" => "top", "data" => $html)
			);
		$rows[] = $row;

	}


	//
	// User Badges
	//
	if (!empty($account->content["user_badges"])) {
		$user_badges = $account->content["user_badges"];
		$html = $user_badges["badges"]["#value"];
		$row = array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("Badges:")),
			array("valign" => "top", "data" => $html)
			);
		$rows[] = $row;
	}


	//
	// User rating
	//
	if (!empty($account->content["fivestarextra"])) {
		$html = ($account->content["fivestarextra"]["widget"]["#value"]);
		$row = array(
			array("valign" => "top", "align" => "right", 
				"class" => "name",
				"data" => t("Rate this user:")),
			array("valign" => "top", "data" => $html)
			);
		$rows[] = $row;
		//print $profile["fivestarextra"]; // Old method
	}


	//
	// How long have they been a member?
	//
	$member_len = (time() - $account->created);
	$interval = format_interval($member_len);

	$access = (time() - $account->access);
	$access = format_interval($access);
	$access = t("(Last login: !interval ago)", array("!interval" => $access));
	$interval .= " " . $access;

	$row = array(
		array("valign" => "top", "align" => "right", 
			"class" => "name",
			"data" => t("Member for:")),
		array("valign" => "top", "data" => $interval)
		);
	$rows[] = $row;

	//
	// How many posts made?
	//
	if (module_exists("user_stats")) {

		$num_posts = user_stats_get_stats("post_count", $account->uid);
		if (!$num_posts) {
			$num_posts = 0;
		}

		$url = "user/" . $account->uid . "/track";
		$row = array(
			array("valign" => "top", "align" => "right",
				"class" => "name",
				"data" => t("Number&nbsp;of&nbsp;Posts:")),
			array("valign" => "top", "data" => l($num_posts, $url)
			));
		$rows[] = $row;

	}


	//
	// Private messages
	//
	if (user_access("write privatemsg")) {

		$link = t("Send a private message to !name", 
			array("!name" => $account->name));
		$url = "messages/new/" . $account->uid;
		$html = "<div class=\"fields\">"
			. l($link, $url)
			. "</div>"
			;

		$row = array(
			array("valign" => "top", "align" => "right",
				"class" => "name",
				"data" => t("Messaging:")),
			array("valign" => "top", "data" => $html
			));
		$rows[] = $row;

	}


	//
	// Generate our table and print it up.
	//
	$html = theme("table", array(), $rows);
	print $html;

	//
	// Fasttoggle stuff for this user
	//
	$key = "fasttoggle";
	if (!empty($profile[$key])) {
		print ($profile[$key]);
	}

	?>

</div>

<?php

// Debugging stuff
//foreach ($profile as $key => $value) {
//	print "Item: '$key': $value<br/>\n";
//}


