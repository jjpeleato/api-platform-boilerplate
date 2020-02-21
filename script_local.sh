#!/bin/bash

#
# Shell script for PHP validate, database update and cache clear.
#
# Notes:
# - Lando is assumed
# - Console is assumed
# - Composer is assumed
# - Windows host and Cygwin environment is assumed
# - UNIX target environment with SSH+rsync is assumed
#

# Execute PHP validate
echo
echo "PHP validate"
lando composer cs

if [ "$?" != "0" ] ; then
    echo
    echo "ERROR: PHP validate."
    exit
fi

# Execute database update command
echo
echo "Database update"
lando console doctrine:schema:update --force

if [ "$?" != "0" ] ; then
    echo
    echo "ERROR: Database update."
    exit
fi

# Execute cache clear command
echo
echo "Cache clear"
lando console cache:clear
lando console cache:clear --env test
lando console cache:clear --env prod

# Finish
echo "Finish"
exit
