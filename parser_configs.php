<?php
/**
 * @param $url
 * @param string $referer
 * @return mixed
 * @author Ashot Gharakeshishyan
 */
function curl_get($url, $referer = 'https://www.google.com/')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1;WOW64;rv:38.0) Gecko/20100101 Firefox/38.0");
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $datav = curl_exec($ch);
    curl_close($ch);
    return $data;
}

?>