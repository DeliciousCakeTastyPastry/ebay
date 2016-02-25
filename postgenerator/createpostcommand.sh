#!/bin/bash
while read line
do
file=`find . -name "$line" -print`

php ~/am/wp-cli.phar post create ~/ebay/postgenerator/$file --path="/var/www/stephenpicardi.com/public_html/" --allow-root --post_type=post --post_title="LOL" --post_status=publish
done < longestfiles.txt
