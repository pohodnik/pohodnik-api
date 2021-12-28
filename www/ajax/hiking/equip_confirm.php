<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$result = array();

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
$id = intval($_POST['id']);
$id_hiking = intval($_POST['id_hiking']);
$id_equip = isset($_POST['id_equip']) ? intval($_POST['id_equip']) : "";
$confirm = intval($_POST['confirm']);
$id_user = $_COOKIE["user"];

$q = $mysqli->query("SELECT id FROM hiking WHERE id_author={$id_user} AND id={$id_hiking}");
if(!$q || $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_user={$id_user} AND id_hiking={$id_hiking}");
	if(!$q || $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа . \r\n".$mysqli->error)));
	}
}

$z = "UPDATE `hiking_equipment` SET `is_confirm`='{$confirm}' WHERE id={$id}";

if(!empty($id_equip)) {
	$q = $mysqli->query("
	SELECT
		uesi.id
	FROM
		user_equip_set_items AS uesi
		LEFT JOIN user_equip_sets ON (user_equip_sets.id = uesi.id_set)
	WHERE user_equip_sets.id_hiking={$id_hiking} AND uesi.id_equip={$id_equip}
	");
	if(!$q || $q->num_rows===0){
		die(json_encode(array("error"=>"Нет найден элемент снаряжения с id_equip={$id_equip} . \r\n".$mysqli->error)));
	}
	$r = $q -> fetch_row();
	$id_user_equip_set_item = $r[0];

	$z = "UPDATE
		user_equip_set_items
	SET user_confirm=".($confirm == 1 ? $id_user : 'NULL').",
	date_confirm=".($confirm == 1 ? 'NOW()' : 'NULL')."
	WHERE id={$id_user_equip_set_item}";
}


	if($mysqli->query($z)){
		exit(json_encode(array("success"=>true, "id"=> $id)));
	}else{exit(json_encode(array("error"=>"Ошибка обновления . \r\n".$mysqli->error)));}

?>