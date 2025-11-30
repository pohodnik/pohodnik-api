<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/rules.php");

$result = array();
$id_hiking = intval($_POST['id_hiking']);
$id_user = $_COOKIE["user"];

$hasRules = hasHikingRules($id_hiking, array('boss', 'time'));
if (!$hasRules) {
    die(json_encode(array("error" => "У вас нет доступа")));
}

$v = "
    `id_hiking`={$id_hiking},
    `name`='" . $mysqli->real_escape_string($_POST['name']) . "',
    `date`='" . $mysqli->real_escape_string($_POST['date']) . "',
    `lat`=" . $mysqli->real_escape_string($_POST['lat']) . ",
    `lon`=" . $mysqli->real_escape_string($_POST['lon']) . "
    ";

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($id > 0) {
    $z = "UPDATE hiking_keypoints SET {$v} WHERE id={$id}";
} else {
    $z = "INSERT INTO hiking_keypoints SET {$v}";
}

$q = $mysqli->query($z);
if ($q) {
    $result['success'] = true;
    if ($id === 0) {
        $result['id'] = $mysqli->insert_id;
    }
    die(json_encode($result));
} else {
    die(json_encode(array("error" => "Error " . $mysqli->error . " \r\n" . $z)));
}
