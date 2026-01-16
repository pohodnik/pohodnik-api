<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$id = isset($_POST['id'])?intval($_POST['id']):0;

$id_hiking = intval($_POST['id_hiking']);
$id_user = intval($_COOKIE["user"]);

$q = $mysqli->query("SELECT id FROM hiking WHERE id_author={$id_user} AND id={$id_hiking}");
if(!$q || $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_user={$id_user} AND id_hiking={$id_hiking}");
	if(!$q || $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа . \r\n".$mysqli->error)));
	}
}

if($id>0){
	if($mysqli->query("DELETE FROM `hiking_equipment` WHERE id={$id}  ")){
		exit(json_encode(array("success"=>"Запись удалена", "id"=> $id)));
	}else{exit(json_encode(array("error"=>"Ошибка удаления . \r\n".$mysqli->error)));}
}
?>
