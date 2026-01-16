<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_set = intval($_POST['id_set']);
if (!isset($id_set) || empty($id_set)) { die(json_encode(array('error' => 'id_set is required'))); }

$id_equip = $_POST['id_equip'];
if (!isset($id_equip) || empty($id_equip) || !is_array($id_equip)) { die(json_encode(array('error' => 'id_equip is required array'))); }

$id_user = intval($_COOKIE["user"]);

$res = array();
$rows = array();
$sql = "INSERT INTO `user_equip_set_items`(`id_set`, `id_equip`) VALUES ";

foreach($id_equip as $id) {
	$rows[] = "($id_set,$id)";
}

$sql .= implode(',', $rows).";";
$q = $mysqli->multi_query($sql);

if (!$q) {
	exit(json_encode(array(
		'success' => false,
		'error' => $mysqli->error,
		'sql' => $sql
	)));
}

$mysqli->query("UPDATE user_equip_sets SET date_update=NOW() WHERE id={$id_set}");
exit(json_encode(array("success"=>true, 'sql' => $sql)));
