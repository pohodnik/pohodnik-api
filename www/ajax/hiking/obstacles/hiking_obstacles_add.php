<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php");
$result = array();
$current_user = intval($_COOKIE["user"]);

$id_hiking = isset($_POST['id_hiking']) ? intval($_POST['id_hiking']) : 0;
$id_obstacle = isset($_POST['id_obstacle']) ? intval($_POST['id_obstacle']) : 0;
$id_hiking_track = isset($_POST['id_hiking_track']) ? intval($_POST['id_hiking_track']) : 'NULL';
$id_hiking_break = isset($_POST['id_hiking_break']) ? intval($_POST['id_hiking_break']) : 'NULL';

$description = $mysqli->real_escape_string($_POST['description']);
$description_in = $mysqli->real_escape_string($_POST['description_in']);
$description_out = $mysqli->real_escape_string($_POST['description_out']);

$date_in = $mysqli->real_escape_string($_POST['date_in']);
$date_out = $mysqli->real_escape_string($_POST['date_out']);

if (!($id_hiking > 0)) {
    die(json_encode(array("error" => "id_hiking is undefined")));
}
if (!($id_obstacle > 0)) {
    die(json_encode(array("error" => "id_obstacle is undefined")));
}

if (!(strlen($date_in) > 0)) {
    die(json_encode(array("error" => "date_in is empty")));
}
if (!(strlen($date_out) > 0)) {
    die(json_encode(array("error" => "date_out is empty")));
}

$hasRules = hasHikingRules($id_hiking, array('boss', 'routes'));
if (!$hasRules) {
    die(json_encode(array("error" => "У вас нет доступа")));
}


$z = "
INSERT INTO
    `hiking_obstacles`
SET
    `id_hiking` = {$id_hiking},
    `id_obstacle` = {$id_obstacle},
    `id_hiking_track` = {$id_hiking_track},
    `id_hiking_break` = {$id_hiking_break},
    `description` = '{$description}',
    `description_in` = '{$description_in}',
    `description_out` = '{$description_out}',
    `date_in` = '{$date_in}',
    `date_out` = '{$date_out}',
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
