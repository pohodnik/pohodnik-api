<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php");
$result = array();
$current_user = $_COOKIE["user"];

$id_photo = isset($_POST['id_photo']) ? intval($_POST['id_photo']) : 0;
$id_hiking = isset($_POST['id_hiking']) ? intval($_POST['id_hiking']) : 0;

$date = $mysqli->real_escape_string($_POST['date']);
$comment = $mysqli->real_escape_string($_POST['comment']);
$point = isset($_POST['lat']) && isset($_POST['lon']) && !empty($_POST['lat']) && !empty($_POST['lon']) ? "POINT(" . floatval($_POST['lat']) . ", " . floatval($_POST['lon']) . ")" : 'NULL';
$altitude = isset($_POST['altitude']) && !empty($_POST['altitude']) ? intval($_POST['altitude']) : 'NULL';


if (!($id_hiking > 0)) {
    die(json_encode(array("error" => "id_hiking is undefined")));
}
if (!($id_photo > 0)) {
    die(json_encode(array("error" => "id_photo is undefined")));
}

if (!(strlen($date) > 0)) {
    die(json_encode(array("error" => "date is empty")));
}

$q = $mysqli->query("SELECT id_user FROM hiking_members WHERE id_hiking={$id_hiking} AND id_user={$current_user}");
if ($q && $q->num_rows === 0) {
    die(json_encode(array("error" => "Доступ только у участников похода")));
}

$z = "
UPDATE
    `hiking_obstacles_photos`
SET
    `date` = '{$date}',
    `coordinates` = $point,
    `altitude` = $altitude,
    `comment` = '$comment'
WHERE id={$id_photo}
";
$q = $mysqli->query($z);
if (!$q) {
    die(err($mysqli->error, array("z" => $z)));
}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows
)));
