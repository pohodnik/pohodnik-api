<?php //recipes_product_add.php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

global $mysqli;

$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = intval($_POST['id_hiking']);
$id = intval($_POST['id']);
$d1 = $mysqli->real_escape_string($_POST['d1']);
$d2 = $mysqli->real_escape_string($_POST['d2']);


$name = $mysqli->real_escape_string($_POST['name']);
$id_food_act = isset($_POST['id_food_act']) && intval($_POST['id_food_act'])>0?intval($_POST['id_food_act']):'NULL';
$id_route_object = isset($_POST['id_route_object']) && intval($_POST['id_route_object'])>0?intval($_POST['id_route_object']):'NULL';
$kkal = isset($_POST['kkal']) && intval($_POST['kkal'])>0?intval($_POST['kkal']):0;

$description = isset($_POST['description']) && strlen(trim($_POST['description'])) > 0 ? "'".$mysqli->real_escape_string(trim($_POST['description']))."'":'NULL';
$link = isset($_POST['link']) && strlen(trim($_POST['link'])) > 0 ? "'".$mysqli->real_escape_string(trim($_POST['link']))."'":'NULL';
$cost = isset($_POST['cost']) && floatval($_POST['cost'])>0 ? floatval($_POST['cost']) : 'NULL';


if(!($id_hiking>0)){die(json_encode(array("error"=>"Undefined ID hiking")));}
if(!($id>0)){die(json_encode(array("error"=>"Undefined ID")));}

$z = "UPDATE `hiking_schedule` SET
    `id_hiking`={$id_hiking},
    `d1`='{$d1}',
    `d2`='{$d2}',
    `name`='{$name}',
    `id_food_act`={$id_food_act},
    `id_route_object`={$id_route_object},
    `kkal`={$kkal},
    `description`={$description},
    `link`={$link},
    `cost`={$cost}
 WHERE id={$id}";

if($mysqli->query($z)){
	die(json_encode(array("success"=>true, "id"=>$mysqli->insert_id)));
} else {
	die(json_encode(array("error"=>"Ошибка. ".$mysqli->error, "q" => $z)));
}
