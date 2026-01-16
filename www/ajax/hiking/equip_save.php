<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_hiking = intval($_POST['id_hiking']);
$id_user = intval($_COOKIE["user"]);

$q = $mysqli->query("SELECT id FROM hiking WHERE id_author={$id_user} AND id={$id_hiking}");
if(!$q || $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_user={$id_user} AND id_hiking={$id_hiking}");
	if(!$q || $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа . \r\n".$mysqli->error)));
	}
}

$id = intval($_POST['id']);
$name = $mysqli->real_escape_string(trim($_POST['name']));
$user = isset($_POST['id_user']) && intval($_POST['id_user']) > 0 && $_POST['id_user']!='null' ? intval($_POST['id_user']) : 'NULL';
$weight = floatval($_POST['weight']);
$value = floatval($_POST['value']);
$is_confirm = boolval($_POST['is_confirm']) ? 1 : 0;
$photo = $mysqli->real_escape_string(trim($_POST['photo']));

$action = $id > 0 ? 'UPDATE' : 'INSERT INTO';
$claus = $id > 0 ? 'WHERE id='.$id : '';

$z = "
	{$action}
		`hiking_equipment`
	SET
		`id_hiking`={$id_hiking},
		`id_user`={$user},
		`name`='{$name}',
		`weight`={$weight},
		`value`={$value},
		`is_confirm`={$is_confirm},
		`photo`='{$photo}',
		`id_author`={$id_user},
		`date_create`=NOW()
	{$claus}
";

$q = $mysqli->query($z);
if (!$q) { exit(json_encode(array("error"=>"Ошибка {$action}. \r\n".$mysqli->error, "sql" => $z))); }
$id = $mysqli->insert_id;
exit(json_encode(array("success"=>true, "id"=> $id, "z" => $z)));
