<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");

$result = array();
$current_user = intval($_COOKIE["user"]);

$id_workout = isset($_POST['id_workout']) ? intval($_POST['id_workout']) : 0;

$url_preview = $mysqli->real_escape_string($_POST['url_preview']);
$url = $mysqli->real_escape_string($_POST['url']);
$date = $mysqli->real_escape_string($_POST['date']);
$comment = $mysqli->real_escape_string($_POST['comment']);
$is_main = $mysqli->real_escape_string($_POST['is_main']);

$point = isset($_POST['lat']) && isset($_POST['lon']) && !empty($_POST['lat']) && !empty($_POST['lon']) ? "POINT(" . floatval($_POST['lat']) . ", " . floatval($_POST['lon']) . ")" : 'NULL';
$altitude = isset($_POST['altitude']) && !empty($_POST['altitude']) ? intval($_POST['altitude']) : 'NULL';

if (!($id_workout > 0)) {
    die(json_encode(array("error" => "id_workout is undefined")));
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

$z = "
INSERT INTO
    `workout_photos`
SET
    `id_workout` = {$id_workout},
    `url_preview` = '{$url_preview}',
    `url` = '{$url}',
    `date` = '{$date}',
    `coordinates` = $point,
    `altitude` = $altitude,
    `is_main` = $is_main,
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