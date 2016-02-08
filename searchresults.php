<?php

print_r("Welcome");

$url = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=LaurensM-9ccd-4d15-8eba-9602a1a3f606&RESPONSE-DATA-FORMAT=XML&REST-PAYLOAD&keywords=harry%20potter%20phoenix";
$response = file_get_contents($url);
$xml = simplexml_load_string( $response );
$count = $xml->searchResult[0]['count'];

for ($i = 1; ; $i++) {
        if ($i >= $count) {
                break;
                print_r("Done");
        }
        $ItemID = $xml->searchResult->item[$i]->itemId;
        $singleitemurl = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=XML&appid=LaurensM-9ccd-4d15-8eba-9602a1a3f606&siteid=0&version=515&ItemID=" . "$ItemID" . "&IncludeSelector=Description,ItemSpecifics";
        $resp = file_get_contents($singleitemurl);
        $obj = new SimpleXMLElement($resp);
        $html = $obj->Item[0]->Description;
        $itemurl = $obj->Item[0]->PictureURL;
        $html = preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $html);
        $body = strip_tags($html);
        $body = "<img src=\"$itemurl\">" . "$body";
        $file = 'results/search.txt';
        file_put_contents($file, $body, FILE_APPEND | LOCK_EX);

}
?>
