<?php
$curl = curl_init();
$locations = $_GET['locations'];

$url = "https://api.open-elevation.com/api/v1/lookup";
//$url = "https://api.opentopodata.org/v1/srtm90m";


curl_setopt($curl, CURLOPT_URL, "{$url}?locations={$locations}");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:7.0.1) Gecko/20100101 Firefox/7.0.12011-10-16 20:23:00");
curl_setopt($curl, CURLOPT_REFERER, "https://pohodnik.tk");
curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
$out = curl_exec($curl);
curl_close($curl);

die($out);

