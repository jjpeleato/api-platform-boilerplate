#!/bin/bash

#
# Shell script for installing a clean database.
#
# Notes:
# - Composer install is assumed
# - Parameters.yml is assumed
# - Doctrine configuration is assumed
# - Windows host and Cygwin environment is assumed
# - UNIX target environment with SSH+rsync is assumed
#

# Answer to continue
echo
echo -n "Do you want to reset database? For default: No (y/n)? "
read -r answer

if [ "$answer" != "${answer#[Yy]}" ] ; then
    echo
    echo "Clean database. In progress ..."
else
    echo
    echo "Goodbye"
    exit
fi

# Answer to production or lando environment
echo
echo -n "Do you want to execute on production environment?. (pro) (For default: lando): "
read -r answer

if [ "$answer" = "pro" ] ; then
    echo
    echo "Production environment"
    COMMAND="php bin/console"
else
    echo
    echo "Lando selection"
    COMMAND="lando console"
fi

# Drop and create database
echo
echo "Drop and create database"
$COMMAND doctrine:schema:drop --force
$COMMAND doctrine:schema:create

# Import data
echo
echo "Import minimal data"
$COMMAND doctrine:database:import ./private/sql/admin.sql

# Answer to continue
echo
echo -n "Do you want to import fake data? For default: No (y/n)? "
read -r answer

if [ "$answer" != "${answer#[Yy]}" ] ; then
    echo
    echo "Import fake data"
else
    echo
    echo "Finish"
    exit
fi

# Finish
echo
echo "Finish"
exit
