<?php 
include_once("blocks/err.php");
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$psw = getenv('MYSQL_PASSWORD');
$db = getenv('MYSQL_DATABASE');

$conn = mysqli_connect($host, $user, $psw, $db);
if (!$conn) {	
    exit('!!!Connection failed: '.mysqli_connect_error().PHP_EOL."h={$host}, u={$user}, p={$psw}, db={$db}");
}
 
echo "Successful database connection {$db}!".PHP_EOL;
 ?>