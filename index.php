<?php
ob_start();
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include_once('parser_configs.php');
include_once('simple_html_dom.php');
require_once('database.php');
$GLOBALS['customCount'] = 0;
$db = new Database;

$page = file_get_contents('pageNumber.txt');
$url = 'http://localhost/parse/patents/htmlPageForParse' . trim($page) . '.html';

$html = file_get_contents($url);

$pageContent = str_get_html($html);
$mainCategories = $pageContent->find("table tr");
$bigArray = [];
foreach ($mainCategories as $tr) {
    $link = $tr->find('th a');
    if (empty($link)) {
        $tds = $tr->find('td');
        foreach ($tds as $td) {
            $text = $td->text();
            if (strpos($text, 'Publication') !== false) {
                $textArr = explode('.', $text);
                $bigArray[$GLOBALS['customCount']][1] = $textArr[1];
            }
        }
    } else {
        $patent_url = $link[0]->getAttribute('href');
        $bigArray[$GLOBALS['customCount']][0] = $patent_url;
    }

    if (count($bigArray[$GLOBALS['customCount']]) === 2) {
        $GLOBALS['customCount']++;
    }
}
foreach ($bigArray as $patent) {
    $db->execute("INSERT INTO TABLENAME (patent_url,patent_code) VALUES ('" . $patent[0] . "','" . $patent[1] . "')");
}
$newPage = intval(trim($page)) + 1;

file_put_contents('pageNumber.txt', $newPage);
echo "<script>window.location.reload()</script>";
sleep(1);





