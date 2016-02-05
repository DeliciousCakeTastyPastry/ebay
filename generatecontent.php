<?php

$numargs = count($argv);
$keywords = "";
for( $i = 1; $i < $numargs ; $i++ ) {
	$keywords = $keywords . $argv[$i] . "+";
	}
$len = strlen( $keywords);
$keywords = substr( $keywords, 0 , $len - 1 );
#echo $keywords;

mkdir($keywords);

$url = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=LaurensM-9ccd-4d15-8eba-9602a1a3f606&RESPONSE-DATA-FORMAT=XML&REST-PAYLOAD&keywords=$keywords";
$response = file_get_contents($url);
$xml = simplexml_load_string( $response );

chdir($keywords);
for ($i = 1; ; $i++) {
        if ($i > 100) {
                break;
#                print_r("Done");
        }
        $ItemID = $xml->searchResult->item[$i]->itemId;
        echo($ItemID);
        $singleitemurl = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=XML&appid=LaurensM-9ccd-4d15-8eba-9602a1a3f606&siteid=0&version=515&ItemID=" . "$ItemID" . "&IncludeSelector=Description,ItemSpecifics";
        $resp = file_get_contents($singleitemurl);
        $obj = new SimpleXMLElement($resp);
        $html = $obj->Item[0]->Description;
        $itemurl = $obj->Item[0]->PictureURL;
        $html = preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $html);
        $body = strip_tags($html);
        #$body = "<img src=\"$itemurl\">" . "$body";
        $file = 'search.txt';
        file_put_contents($file, $body, FILE_APPEND | LOCK_EX);

	file_put_contents($keywords . $i, $body);
}
?>
