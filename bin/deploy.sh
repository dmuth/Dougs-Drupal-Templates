#!/bin/sh
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

#
# Clear out the currently deployed site.  Note that this WILL break 
# the current template until another site is deployed.
#
if test "$1" = "clean"
then
	rm -f style.css screenshot.png *.info page.tpl.php node.tpl.php
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
# Check for each of our site-specific files, and make sure they exist.
#
STYLE=styles/${SITE}.css
if test ! -f ${STYLE}
then
	echo "$0: File '${STYLE}' not found.";
	exit 1
fi

SCREENSHOT=screenshots/${SITE}.png
if test ! -f ${SCREENSHOT}
then
	echo "$0: File '${SCREENSHOT}' not found.";
	exit 1;

fi

INFO=infos/${SITE}.info
if test ! -f ${INFO}
then
	echo "$0: File '${INFO}' not found.";
	exit 1
fi

PAGE=page/${SITE}.tpl.php
if test ! -f ${PAGE}
then
	echo "$0: File '${PAGE}' not found.";
	exit 1
fi

NODE=node/${SITE}.tpl.php
if test ! -f ${NODE}
then
	echo "$0: File '${NODE}' not found.";
	exit 1
fi


#
# Create our symlinks to the site-specific files
#
ln -sf ${STYLE} style.css
ln -sf ${SCREENSHOT} screenshot.png
ln -sf ${INFO} ${THEME}.info
ln -sf ${PAGE} page.tpl.php
ln -sf ${NODE} node.tpl.php

#
# Finally clear the cache, in case the current template has any remaining 
# references to old template files.
#
drush -q cache clear

echo "Site '${SITE}' deployed in theme '${THEME}'!"


