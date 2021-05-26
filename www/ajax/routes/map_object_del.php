<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id = intval($_POST['id']);
$q = $mysqli->query("DELETE FROM `route_objects` WHERE id={$id}");
if (!$q) {
	exit(json_encode(array("error"=>"Ошибка удаления объекта. \r\n".$mysqli->error)));
}

exit(json_encode(array("success"=>"Обьект успешно удален", "id"=> $mysqli->affected_rows)));
