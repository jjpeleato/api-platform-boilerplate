#!/bin/bash

#
# Shell script for database update and cache clear.
#
# Notes:
# - Lando is assumed
# - Console is assumed
# - Composer is assumed
# - Windows host and Cygwin environment is assumed
# - UNIX target environment with SSH+rsync is assumed
#

# Execute cache clear command
echo
echo "Cache clear"
php bin/console cache:clear --env prod

if [ "$?" != "0" ] ; then
    echo
    echo "ERROR: cache:clear."
    exit
fi

# Execute database update command
echo
echo "Database update"
php bin/console doctrine:schema:update --force

if [ "$?" != "0" ] ; then
    echo
    echo "ERROR: Database update."
    exit
fi

# Finish
echo "Finish"
exit
