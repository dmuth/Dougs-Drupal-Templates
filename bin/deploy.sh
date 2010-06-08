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
	echo "Syntax: $0 <site to deploy|clean> [copy]";
	exit 1
fi

#
# If Drush isn't installed, let the user know.
#
NO_DRUSH=""
if test ! `which drush`
then
	echo "$0: Drush was not found!  I'll still run, but in limited mode."
	NO_DRUSH=1
fi

#
# Our symlinks
#
SYMLINKS="style.css screenshot.png *.info page.tpl.php node.tpl.php script.js favicon.ico logo.jpg lib.inc.php advf-author-pane.tpl.php"

#
# Clear out the currently deployed site.  Note that this WILL break 
# the current template until another site is deployed.
#
if test "$1" = "clean"
then
	rm -f $SYMLINKS
	if test ! "$NO_DRUSH"
	then
		drush -q cache clear
		echo "Template cleaned."
	else
		echo "$0: Unable to clear the cache.  You may need to do this by hand."
	fi

	exit

fi

COPY_FILES=""
if test "$2" = "copy"
then
	COPY_FILES=1
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
SCRIPT="scripts/${SITE}.js"
LOGO="logos/${SITE}.jpg"
FAVICON="favicons/${SITE}.ico"
LIB="lib/${SITE}.inc.php"
AUTHOR_PANE="advf/author-pane/${SITE}.tpl.php"


#
# Remove our symlinks
#
rm -f $SYMLINKS

if test "$COPY_FILES" = ""
then
	#
	# Create our symlinks to the site-specific files
	#
	ln -sf ${STYLE} style.css
	ln -sf ${SCREENSHOT} screenshot.png
	ln -sf ${PAGE} page.tpl.php
	ln -sf ${NODE} node.tpl.php
	ln -sf ${SCRIPT} script.js
	ln -sf ${LOGO} logo.jpg
	ln -sf ${FAVICON} favicon.ico
	ln -sf ${LIB} lib.inc.php
	ln -sf ${AUTHOR_PANE} advf-author-pane.tpl.php

else
	#
	# Copy the files instead, since Windows doesn't like symlinks.
	#
	cp -f ${STYLE} style.css
	cp -f ${SCREENSHOT} screenshot.png
	cp -f ${PAGE} page.tpl.php
	cp -f ${NODE} node.tpl.php
	cp -f ${SCRIPT} script.js
	cp -f ${LOGO} logo.jpg
	cp -f ${FAVICON} favicon.ico
	cp -f ${LIB} lib.inc.php
	cp -f ${AUTHOR_PANE} advf-author-pane.tpl.php

fi

#
# Always copy the theme file, and append a description to it so we know
# what directory this theme is in.
#
cp -f ${INFO} ${THEME}.info
echo "description = (Theme directory: ${THEME})" >> ${THEME}.info

#
# Finally clear the cache, in case the current template has any remaining 
# references to old template files.
#
if test ! "$NO_DRUSH"
then
	drush -q cache clear
else
	echo "$0: Unable to clear the cache.  You may need to do this by hand."
fi

echo "Site '${SITE}' deployed in theme '${THEME}'!"


