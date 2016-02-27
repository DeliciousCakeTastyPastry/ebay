#!/bin/bash

terms="$@"

php arethere100listings.php $terms
if [ $? == 1 ]
then
echo Not 100 Listings.
exit 1
fi
domain=`./termstodomain.sh $terms`
./isdomainavailable.sh $domain
if [ $? == 1 ]
then
exit 1
fi
