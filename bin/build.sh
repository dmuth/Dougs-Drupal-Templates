#!/bin/sh
#
# This script is used to build a file for distribution.
#

#
# Make errors fatal
#
set -e

#
# Debugging
#
#set -x

#
# Change to the directory of this script, then go to the parent, which
# guarantees we'll be in the theme directory.
#
cd `dirname $0`
cd ..

#
# Grab our highest version, so we can get a uniquely named file.
#
echo "Checking version...  Make sure you have svn set up!"
#VERSION=`svn stat -v |cut -c20-26 |sort -r |head -n1 |sed -e s/" "//g`
VERSION=`git svn info |grep "Revision" |cut -d: -f2 |sed -e s/[^0-9]//`

PWD=`pwd`
DIR=`basename $PWD`
TARBALL=${DIR}/dougs-drupal-templates-build_${VERSION}.tgz

#
# We don't want any revision control files included in the atrball.
#
OPTIONS='--exclude RCS --exclude .svn --exclude .git'

cd ..

if test -f ${TARBALL}
then
	rm -f ${TARBALL}
fi

tar cfz ${TARBALL} ${DIR}/* ${OPTIONS}

echo "Distfile created in '${TARBALL}'"

