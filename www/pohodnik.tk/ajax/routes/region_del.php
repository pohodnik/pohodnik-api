<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$result = array();
$id_route = intval($_POST['id_route']);
$id_region = intval($_POST['id_region']);

$id_user = $_COOKIE["user"];

$q = $mysqli->query("SELECT id FROM routes WHERE id_author={$id_user} AND id={$id_route} LIMIT 1");
if($q && $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM route_editors WHERE id_user={$id_user} AND id_route={$id_route} LIMIT 1");
	if($q && $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа".$mysqli->error)));
	}
}

$q = $mysqli->query("SELECT id FROM  route_regions WHERE  id_route={$id_route} AND id_region={$id_region} LIMIT 1");
if($q->num_rows===1){ 
	$r= $q->fetch_row();
	$id=$r[0];
	$q = $mysqli->query("DELETE FROM route_regions WHERE id={$id}");
	if($q){
		die(json_encode(array("success"=>true)));
	} else {
		die(json_encode(array("error"=>"Ошибка удаления.".$mysqli->error)));
	}
} else {
	die(json_encode(array("error"=>"Запись не найдена.".$mysqli->error)));
}


