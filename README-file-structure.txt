
This file contains a brief overview of the file and directory structure in this template.


advf-author-pane.tpl.php - Author info for the Author_pane module, which 
	is used by the Advanced Forum module

backgrounds/ - An optional background for each site, where 
	the filename is (site).jpg.
	In the future, I may add support for multiple backgrounds per site.

bin/ - Shell scripts, including the script to deploy the template files for a 
	specific site.
	In this context, "deploying" a template means creating symlinks in the 
	theme's main directory to the files specific to the specified site.

block.tpl.php - The block template file.

box.tpl.php - The box template file.

comment.tpl.php - The comment template file.

favicons/ - A favicon for each site, where the filename is (site).ico.

icons/ - Icons for various instant messenger services.  Used by the user 
	profile page.

images/ - Images for various websites.  These files are not symlinked
	anywhere but instead referenced directly from HTML and CSS.
	Each site should have its own directory under here.

infos/ - .info files for each site.  The filename is (site).info.

logos/ - A logo for each site.  The filename is (site).jpg.

node/ - Node templates for each site.  The filename is (site).tpl.php.

page/ - Page templates for each site.  The filename is (site).tpl.php.

screenshot/ - The 100x100 logo file for each site that is displayed 
	on the template selection page. The filename is (site).jpg.

styles/ - The CSS file for each site.  The filename is (site).css.

user-profile.tpl.php - The user profile page.


