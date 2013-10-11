
What is this?
=============

I built this theme to solve the problem I had, wherein I managed several 
different websites that used templates that were similar, but not 100%
identical.  Specifically, I needed to solve:

1. Whenever I added a tweak to one template, deploying the changes to 
	the other teplates in a safe and sane manner, and

2. Dealing with the fact that the styles on different websites were 
	similar, but not 100% identical.

So I wrote this tool.  I can make changes on one site, and then simply
check out the changes on the other websites.  Additionally, I can deploy
an arbitrary template on any installation, so I can make changes to the
style for any website from any checked out copy.  That simplfies things
for me somewhat.


Installation and usage
----------------------

1. Make sure you have this file (and the others) in a directory under DOCROOT/site/all/templates/

2. Run the script **bin/deploy.sh (site name)**.  As of this writing, 
	valid sitenames are "pa-furry" and "saveardmore".  That will create
	symlinks to the appropriate files.

3. Go to **/admin/build/themes** in Drupal.  The template you just deployed should be there.

I admit that this is a bit convuluted, but it does help me share code 
between the different sites that I manage, which is a huge timesaver 
when developing new features.


Features
--------

- Support for numerous social networks in user profiles (Facebook, Twitter, Flickr, etc.)

- Support for several instant messenger protocols in user profiles (AIM, YIM, Google Chat, etc.)

- Support for the Author Pane template in the Advanced Forums module


Sites this is used on
---------------------

- http://www.SaveArdmoreCoalition.org/
- http://www.SabaNews.org/
- http://www.anthrocon.org/
- http://www.pa-furry.org/
- http://www.FurryConnectionNorth.com/

If you have any questions about this project, don't hesitate to call on me.
My contact info can be found on the web at:

http://www.dmuth.org/contact


