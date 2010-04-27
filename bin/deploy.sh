#!/bin/sh

#
# style, screenshot, info
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
	echo "Syntax: $0 <site to deploy>";
	exit 1
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


#
# Create our symlinks to the site-specific files
#
ln -sf ${STYLE} style.css
ln -sf ${SCREENSHOT} screenshot.png
ln -sf ${INFO} ${THEME}.info


