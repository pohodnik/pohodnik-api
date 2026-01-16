<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$result = array();

$id_user = intval($_COOKIE["user"]);
$id = isset($_POST['id'])?intval($_POST['id']):0;
if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$q = $mysqli->query("SELECT id_hiking FROM hiking_menu_products_force WHERE id={$id} AND id_author = {$id_user} LIMIT 1");
if($q){
	if ($q->num_rows===0) {
		die(json_encode(array("error"=>"Это не ваша запись")));
	}
	if ($q->num_rows===1) {
		$r = $q -> fetch_row();
		$id_hiking = $r[0];
	}	
}

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}

$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking} AND is_cook=1  AND id_user = {$id_user} LIMIT 1");
	if($q && $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа")));
	}
}

if($mysqli->query("DELETE FROM `hiking_menu_products_force` WHERE id={$id}")){
	die(json_encode(array('success'=>true)));
} else {
	die(json_encode(array('error'=>$mysqli->error)));
}
