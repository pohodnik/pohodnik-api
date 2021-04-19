<?
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$term = $mysqli->real_escape_string(trim($_GET['term']));
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$res = array();
$q = $mysqli->query("
	SELECT 
		`category`
	FROM `user_equip`
		WHERE `category` LIKE('%{$term}%') AND is_archive=0
	LIMIT {$limit}");
	
while($r = $q->fetch_assoc()){$res[] = $r; }
die(json_encode($res));