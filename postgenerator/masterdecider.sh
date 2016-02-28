#!/bin/bash
. functions.cfg
terms="$@"

howmanyebayresults $terms
if [ $? == 1 ]
then
echo Not 100 Listings.
exit 1
fi
domain=`termstodomain $terms`
isdomainavailable $domain
if [ $? == 1 ]
then
exit 1
fi
