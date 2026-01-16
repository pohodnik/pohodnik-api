<?php

include("../../../blocks/db.php"); //подключение к БД
include("../../../blocks/for_auth.php"); //Только для авторизованных
$id_user = intval($_COOKIE["user"]);
$id_author = intval($_COOKIE["user"]);

$id_hiking = intval($_POST['id_hiking']);
$id_workout_track = intval($_POST['id_workout_track']);
$name = $mysqli->real_escape_string($_POST['name']);

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_author} LIMIT 1");
if($q && $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_guide=1  AND id_user = {$id_author} LIMIT 1");
	if($q && $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа")));
	}
}


$q = $mysqli->query("
INSERT INTO
	`hiking_tracks`
SET
	`id_user` = {$id_user},
	`id_hiking` = {$id_hiking},
	`id_workout_track` = {$id_workout_track},
	`name` = '{$name}',
	`date_create` = NOW()
");

echo(json_encode(array("success"=>true, "msg"=>"Трек успешно добавлен", "id" => $mysqli->insert_id)));	



?>
