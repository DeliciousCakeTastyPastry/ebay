#!/bin/bash
. functions.cfg
function getnexttitle {
	nexttitle=`head -n 1 /tmp/titles.txt`
	echo $nexttitle
	sed '1d' /tmp/titles.txt > tmpfile; mv tmpfile /tmp/titles.txt
	}

getnexttitle
