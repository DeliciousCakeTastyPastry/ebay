#!/bin/bash

while read line ; do ./lol.sh $line > ${line}.tmp ; echo $line >> tmp.tmp; done < randomwords

while read line; do sed -i '/^\s*$/d' $line.tmp ; cat $line.tmp | sort | uniq | head -n 2 | tail -n 1 ; done < tmp.tmp > a.txt

while read line; do php generatecontent.php $line; done < a.txt

ls ./output > tmp2.tmp ; while read line; do ls -lS ./output/$line | head -n 2 | tail -n 1 | cut -f 9 -d" " ; done < tmp2.tmp > longestfiles.txt

rm a.txt *.tmp

