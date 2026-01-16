<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php");
$result = array();
$current_user = intval($_COOKIE["user"]);

$id_hiking_obstacle = isset($_POST['id_hiking_obstacle']) ? intval($_POST['id_hiking_obstacle']) : 0;
$id_hiking = isset($_POST['id_hiking']) ? intval($_POST['id_hiking']) : 0;

$url_preview = $mysqli->real_escape_string($_POST['url_preview']);
$url = $mysqli->real_escape_string($_POST['url']);
$date = $mysqli->real_escape_string($_POST['date']);
$comment = $mysqli->real_escape_string($_POST['comment']);

$point = isset($_POST['lat']) && isset($_POST['lon']) && !empty($_POST['lat']) && !empty($_POST['lon']) ? "POINT(" . floatval($_POST['lat']) . ", " . floatval($_POST['lon']) . ")" : 'NULL';
$altitude = isset($_POST['altitude']) && !empty($_POST['altitude']) ? intval($_POST['altitude']) : 'NULL';

if (!($id_hiking > 0)) {
    die(json_encode(array("error" => "id_hiking is undefined")));
}
if (!($id_hiking_obstacle > 0)) {
    die(json_encode(array("error" => "id_hiking_obstacle is undefined")));
}

if (!(strlen($url_preview) > 0)) {
    die(json_encode(array("error" => "url_preview is empty")));
}
if (!(strlen($url) > 0)) {
    die(json_encode(array("error" => "url is empty")));
}
if (!(strlen($date) > 0)) {
    die(json_encode(array("error" => "date is empty")));
}

$q = $mysqli->query("SELECT id_user FROM hiking_members WHERE id_hiking={$id_hiking} AND id_user={$current_user}");
if ($q && $q->num_rows === 0) {
    die(json_encode(array("error" => "Доступ только у участников похода")));
}

$z = "
INSERT INTO
    `hiking_obstacles_photos`
SET
    `id_hiking_obstacle` = {$id_hiking_obstacle},
    `url_preview` = '{$url_preview}',
    `url` = '{$url}',
    `date` = '{$date}',
    `coordinates` = $point,
    `altitude` = $altitude,
    `comment` = '$comment',
    `created_at` = NOW(),
    `creator_id` = {$current_user}
";
$q = $mysqli->query($z);
if (!$q) {
    die(err($mysqli->error, array("z" => $z)));
}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id
)));
