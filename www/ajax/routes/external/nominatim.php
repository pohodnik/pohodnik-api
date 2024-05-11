<?php
$curl = curl_init();
$lat = $_GET['lat'];
$lon = $_GET['lon'];
$layer = isset($_GET['layer']) ? $_GET['layer'] : 'unset';

curl_setopt($curl, CURLOPT_URL, "https://nominatim.openstreetmap.org/reverse?lat={$lat}&lon={$lon}&format=json&extratags=1&layer={$layer}");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:7.0.1) Gecko/20100101 Firefox/7.0.12011-10-16 20:23:00");
curl_setopt($curl, CURLOPT_REFERER, "https://pohodnik.tk");
curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
$out = curl_exec($curl);
curl_close($curl);

die($out);

