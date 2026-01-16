<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/imagesStorage.php"); //Только для авторизованных
include(__DIR__."/../../vendor/autoload.php"); //Только для авторизованных
$result = array();
$id = intval($_POST['id']);
if(!($id>0)){exit(json_encode(array("error"=>"Не передан идентификатор")));}

$id_user = intval($_COOKIE["user"]);

$q = $mysqli->query("SELECT id FROM routes WHERE id_author={$id_user} AND id={$id} LIMIT 1");
if(!$q || $q->num_rows!=1){
	exit(json_encode(array("error"=>"Удалить маршрут может только его создатель. \r\n".$mysqli->error)));
}

$z = "SELECT preview_img FROM routes WHERE id={$id} LIMIT 1";
$q = $mysqli->query($z);
if (!$q) {
	die(json_encode(array("error"=>$mysqli->error)));
}
$r = $q -> fetch_assoc();
$oldPhoto = $r['preview_img'];

if (!empty($oldPhoto)) {
	if (isUrlCloudinary($oldPhoto)) {
		deleteCloudImageByUrl($oldPhoto);
	}
}



$q1 = $mysqli->query("DELETE FROM route_objects WHERE id_route={$id}");
$q2 = $mysqli->query("DELETE FROM route_editors WHERE id_route={$id}");
$q3 = $mysqli->query("DELETE FROM routes WHERE id={$id}");
if($q1 && $q2 && $q3){
	$mysqli->query("UPDATE hiking SET id_route=0 WHERE id_route={$id}");
	exit(json_encode(array("success"=>true )));							
}else{
	exit(json_encode(array("error"=>"Ошибка удаления. \r\n".$mysqli->error)));
}

?>
