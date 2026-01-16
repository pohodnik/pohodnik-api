<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$id=intval($_POST['id']);
$value=intval($_POST['value']);
$id_user = intval($_COOKIE["user"]);
$res = array();

if($mysqli->query("UPDATE user_equip_set_items SET amount={$value} WHERE id={$id}")){
	$res['success'] = true;
} else {
	$res['error'] = $mysqli->error;
}
die(json_encode($res));
