<?php

include("../../../../blocks/db.php"); //подключение к БД
include("../../../../blocks/for_auth.php"); //Только для авторизованных
$id = intval($_POST['id']);
$id_user = intval($_COOKIE["user"]);


global $mysqli;
$q = $mysqli->query("DELETE FROM hiking_tracks_break WHERE id={$id} AND id_author={$id_user}");
if(!$q){die(array('error'=>$mysqli->error, 'query' => "WHERE id={$id} AND id_author={$id_user}"));}
if($mysqli -> affected_rows === 1 ){
	echo(json_encode(array("success"=>true)));
} else {
	exit(json_encode(array("error"=>"Запись не найдена")));	
}
