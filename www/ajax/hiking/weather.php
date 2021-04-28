<?php
include("../../blocks/db.php"); //подключение к БД
$result=array();
$id_hiking = intval($_GET["id_hiking"]);
$q = $mysqli->query("
SELECT `date`, `name`, `lat`, `lon`, `forecast`, `created_at`
FROM `hiking_weather` WHERE `id_hiking`={$id_hiking}
ORDER BY date
");
if(!$q){die($mysqli->error);}

while($r = $q->fetch_assoc()){
	$r['forecast'] = json_decode($r['forecast'], true);
	$result[] = $r;
}

echo json_encode($result);