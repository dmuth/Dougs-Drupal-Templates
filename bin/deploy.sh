#!/bin/bash
#
# This script is used for deploying a site-specific template
# It MUST be run before loading the themes page in Drupal.
#
# Author: Douglas Muth <http://www.dmuth.org/>
#

#
# Errors are fatal
#
set -e

#
# Check our syntax
#
if test ! "$1"
then
	echo "Syntax: $0 <site to deploy|clean>";
	exit 1
fi

if test ! `which drush`
then
	echo "$0: Please install Drush (available at http://drupal.org/project/drush) before continuing.";
	exit 1
fi

#
# Our symlinks
#
SYMLINKS="style.css screenshot.png *.info page.tpl.php node.tpl.php script.js favicon.ico logo.jpg lib.inc.php"

#
# Clear out the currently deployed site.  Note that this WILL break 
# the current template until another site is deployed.
#
if test "$1" = "clean"
then
	rm -f $SYMLINKS
	drush -q cache clear
	echo "Template cleaned."
	exit
fi


#
# The site we're deploying
#
SITE=$1

#
# Change to the directory of this script, then go to the parent, which
# guarantees we'll be in the theme directory.
#
cd `dirname $0`
cd ..

#
# Now get the name of the current directory, which is also the name of the
# current theme that we're in.
#
THEME=`basename $PWD`


#
# Check to see if the specified filename exists.  If not, print an error 
# and exit with status 1.
#
# @param string $1 The name of the file to check for
#
function check_file() {

	FILE=$1

	if test ! -f ${FILE}
	then
		echo "$0: File '${FILE}' not found.";
		exit 1
	fi

} # End of check_file()


#
# Check for each of our site-specific files, and make sure they exist.
#
STYLE=styles/${SITE}.css
check_file $STYLE

SCREENSHOT=screenshots/${SITE}.png
check_file $SCREENSHOT

INFO=infos/${SITE}.info
check_file $INFO

PAGE=page/${SITE}.tpl.php
check_file $PAGE

NODE=node/${SITE}.tpl.php
check_file $NODE

#
# Some of these files are optional
#
SCRIPT=scripts/${SITE}.js
LOGO="logos/${SITE}.jpg"
FAVICON="favicons/${SITE}.ico"
LIB="lib/${SITE}.inc.php"


#
# Remove our symlinks
#
rm -f $SYMLINKS

#
# Create our symlinks to the site-specific files
#
ln -sf ${STYLE} style.css
ln -sf ${SCREENSHOT} screenshot.png
ln -sf ${INFO} ${THEME}.info
ln -sf ${PAGE} page.tpl.php
ln -sf ${NODE} node.tpl.php
ln -sf ${SCRIPT} script.js
ln -sf ${LOGO} logo.jpg
ln -sf ${FAVICON} favicon.ico
ln -sf ${LIB} lib.inc.php

#
# Finally clear the cache, in case the current template has any remaining 
# references to old template files.
#
drush -q cache clear

echo "Site '${SITE}' deployed in theme '${THEME}'!"


