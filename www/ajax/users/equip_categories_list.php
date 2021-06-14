<?
include("../../blocks/db.php"); //подключение к БД

$res = array();
$q = $mysqli->query("
	SELECT 
		id, name
	FROM `user_equip_categories`
");
	
while($r = $q->fetch_assoc()){
	$res[] = $r;
}
die(json_encode($res));