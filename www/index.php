<?php 
require_once("./blocks/config.php")
$host = getConf('MYSQL_HOST');
$user = getConf('MYSQL_USER');
$psw = getConf('MYSQL_PASSWORD');
$db = getConf('MYSQL_DATABASE');

$conn = mysqli_connect($host, $user, $psw, $db);
if (!$conn) {	
    exit('Connection failed: '.mysqli_connect_error().PHP_EOL."h={$host}, u={$user}, p={$psw}, db={$db}");
}
 
echo "Successful database connection {$db}!".PHP_EOL;
 ?>