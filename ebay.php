<?php

$ItemID = "$argv[1]";
$singleitemurl="http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=XML&appid=MeganKre-71ab-4611-9fc8-68195808373e&siteid=0&version=515&ItemID=" . "$ItemID" . "&IncludeSelector=Description,ItemSpecifics";
$response = file_get_contents($singleitemurl);

$obj =  new SimpleXMLElement($response);

#print_r($obj);
$html = $obj->Item[0]->Description;
$itemurl = $obj->Item[0]->PictureURL;

#http://stackoverflow.com/questions/1886740/php-remove-javascript
$html = preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $html);
$body = strip_tags($html);
$body = "<img src=\"$itemurl\">" . "$body";
echo $body;
