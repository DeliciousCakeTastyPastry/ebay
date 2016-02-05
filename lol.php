<?php
$html = file_get_contents("A");
        #$obj = new SimpleXMLElement($resp);
        #$html = $obj->Item[0]->Description;
        #$itemurl = $obj->Item[0]->PictureURL;
        #$html = strip_html_tags($html);
        #$html = replaceWhitespace($html);
        $html = preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $html);
        $body = strip_tags($html);
        #$body = "<img src=\"$itemurl\">" . "$body";
        $file = 'search.txt';
        file_put_contents($file, $body, FILE_APPEND | LOCK_EX);

        #file_put_contents($keywords . $i, $body);
