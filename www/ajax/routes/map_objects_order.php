<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$result = array();
$ids = $_POST['ids'];

if(!is_array($ids)){exit(json_encode(array("error"=>"Ошибка входных данных")));}

$rows = array();
$index = 1;

foreach($ids as $id) {
	$rows[] = "UPDATE route_objects SET `ord`='$index' WHERE id=$id";
	$index++;
}

$sql = implode(';\n', $rows);
$q = $mysqli->multi_query($sql);

if (!$q) {
	exit(json_encode(array(
		'success' => false,
		'error' => $mysqli->error,
		'sql' => $sql
	)));
}

exit(json_encode(array("success"=>true)));
?>