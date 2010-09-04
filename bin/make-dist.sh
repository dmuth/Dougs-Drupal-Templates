#!/bin/sh
#
# This script is used to make a distrubtion tarball.
#

OUTPUT=dist.tgz

#
# Files to back up
#
FILES="*.php *.ico *.jpg *.info *.png *.js *.css"

#
# List of files that actually exist
#
INPUT=""

for FILE in $FILES
do
	if test -e ${FILE}
	then
		INPUT="${INPUT} ${FILE}"
	fi
done

tar cfvzh $OUTPUT $INPUT


