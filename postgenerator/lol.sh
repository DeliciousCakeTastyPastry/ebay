#/bin/bash

# This script will scrape NexTag.com's keyword suggestion tools.

query=$1
f_query=$(echo "$query" | sed 's/ /%20/g')
curl -s "http://www.nextag.com/buyer/opensearch.jsp?suggest=complete&perpage=100&search=$f_query" | sed 's/\[//g;s/\]//g;s/","/\n/g;s/"//g'
echo
