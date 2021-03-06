<?php
$domain = "lowbayledlighting.xyz";
$body = "";
$numargs = count($argv);
$keywords = "";
for( $i = 1; $i < $numargs ; $i++ ) {
	$keywords = $keywords . $argv[$i] . "+";
	}
$len = strlen( $keywords);
$keywords = substr( $keywords, 0 , $len - 1 );
#echo $keywords;
mkdir("/tmp/output");
chdir("/tmp/output");

mkdir("/var/www/$domain/public_html/images");

if (file_exists("/tmp/titles.txt")) {
                unlink("/tmp/titles.txt");
                }


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

	$itempicture = file_get_contents($itemurl);
	$randomnumber = rand();
#This line strips /, which is treated as a directory later when saving file
$itemurl = str_replace("/", "", $itemurl);

	$itemtitle = $obj->Item[0]->Title;
	$itemtitle = str_replace('/', '', $itemtitle);
	
	$savefile = fopen("/var/www/$domain/public_html/images/$itemtitle$randomnumber.jpg", 'w');
	fwrite($savefile, $itempicture);
        fclose($savefile);
	
	$titlefile = fopen("/tmp/titles.txt", 'a');
	$itemtitle = $itemtitle . "\n";
	fwrite($titlefile, "$itemtitle");
	fclose($titlefile);

	$html = strip_html_tags($html);
	$html = replaceWhitespace($html);
        $html = preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $html);
        $body = strip_tags($html);
	$body = "<h1> $itemtitle </h1>\n" . $body;
        $body = "<img src=\"http://$domain/images/$itemtitle$randomnumber.jpg\">" . "$body";
        $file = 'search.txt';
#        file_put_contents($file, $body, FILE_APPEND | LOCK_EX);
	file_put_contents($i . $keywords, $body);
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
