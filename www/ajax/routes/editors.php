<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$result = array();
$id = intval($_GET['id']);
$id_user = $_COOKIE["user"];

$q = $mysqli->query("SELECT 0 as id, users.id as id_user, users.name, users.surname,users.photo_50 as photo, 1 as author FROM routes LEFT JOIN users ON routes.id_author = users.id 
WHERE routes.id={$id} LIMIT 1");
$res = array();
$r = $q->fetch_assoc();
$res[] = $r;


$q = $mysqli->query("SELECT users.id as id_user, route_editors.id, users.name, users.surname, users.photo_50 as photo, 0 as author FROM route_editors LEFT JOIN users ON route_editors.id_user = users.id 
WHERE route_editors.id_route={$id}");

while($r = $q->fetch_assoc()){
	$res[] = $r;
}

echo json_encode($res);



