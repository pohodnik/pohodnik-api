<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$term = $mysqli->real_escape_string(trim($_GET['term']));
$res = array();
$q = $mysqli->query("
	SELECT 
		`id`, `name`, `weight`, `value`, `photo`
	FROM `hiking_equipment`
		WHERE `name` LIKE('%{$term}%')
	LIMIT 5");
while($r = $q->fetch_assoc()){$res[] = $r; }
die(json_encode($res));