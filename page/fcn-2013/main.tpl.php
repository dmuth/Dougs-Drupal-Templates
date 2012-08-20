
TEST IN MAIN<br/>
        
<?php print $breadcrumb ?>

	<?php
	//
	// Facebook code
	//
	include("social.tpl.php");

	?>
	<h1 class="title"><?php print $title ?>
		<?php
		print $fb_html;
		print $plus_one_html;
		?>
		</h1>

<?php
	include("anon-welcome.tpl.php");
?>

<div class="tabs"><?php print $tabs ?></div>
<?php print $help ?>
<?php print $messages ?>
<?php print $content; ?>
</div>


