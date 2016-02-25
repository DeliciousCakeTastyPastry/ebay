<?php

$numargs = count($argv);
$keywords = "";
for( $i = 1; $i < $numargs ; $i++ ) {
	$keywords = $keywords . $argv[$i] . "+";
	}
$len = strlen( $keywords);
$keywords = substr( $keywords, 0 , $len - 1 );
#echo $keywords;
mkdir("output");
chdir("output");

$url = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=LaurensM-9ccd-4d15-8eba-9602a1a3f606&RESPONSE-DATA-FORMAT=XML&REST-PAYLOAD&keywords=$keywords";
$response = file_get_contents($url);
$xml = simplexml_load_string( $response );
$count = $xml->searchResult[0]['count'];
echo "Number of results found: " . $count . "\n";
if ($count < 1) {
die("Too few results: $count \n");
}
mkdir($keywords);
chdir($keywords);

for ($i = 0; $i < $count ; $i++) {
        $ItemID = $xml->searchResult->item[$i]->itemId;
        echo($ItemID);
        $singleitemurl = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=XML&appid=LaurensM-9ccd-4d15-8eba-9602a1a3f606&siteid=0&version=515&ItemID=" . "$ItemID" . "&IncludeSelector=Description,ItemSpecifics";
        $resp = file_get_contents($singleitemurl);
        $obj = new SimpleXMLElement($resp);
        $html = $obj->Item[0]->Description;
        $itemurl = $obj->Item[0]->PictureURL;
	$html = strip_html_tags($html);
	$html = replaceWhitespace($html);
        $html = preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $html);
        $body = strip_tags($html);
        $body = "<img src=\"$itemurl\">" . "$body";
        $file = 'search.txt';
#        file_put_contents($file, $body, FILE_APPEND | LOCK_EX);
	file_put_contents($keywords . $i, $body);
}

function strip_html_tags($str){
    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
    $str = preg_replace(
        array(// Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            ),
        "", //replace above with nothing
        $str );
    $str = replaceWhitespace($str);
    $str = strip_tags($str);
    return $str;
} //function strip_html_tags ENDS

//To replace all types of whitespace with a single space
function replaceWhitespace($str) {
    $result = $str;
    foreach (array(
    "  ", " \t",  " \r",  " \n",
    "\t\t", "\t ", "\t\r", "\t\n",
    "\r\r", "\r ", "\r\t", "\r\n",
    "\n\n", "\n ", "\n\t", "\n\r",
    ) as $replacement) {
    $result = str_replace($replacement, $replacement[0], $result);
    }
    return $str !== $result ? replaceWhitespace($result) : $result;
}
############################
?>
