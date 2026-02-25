<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = intval($_COOKIE["user"]);

$id_workout_track = isset($_POST['id_workout_track'])?intval($_POST['id_workout_track']):0;
if(!($id_workout_track>0)){die(json_encode(array("error"=>"id_workout is undefined")));}

$name = $mysqli->real_escape_string($_POST['name']);
$is_break = intval($_POST['is_break']);
$date_from = $mysqli->real_escape_string($_POST['date_from']);
$date_to = $mysqli->real_escape_string($_POST['date_to']);


$z = "INSERT INTO `workout_track_markup`(
    `id_workout_track`,
    `name`,
    `is_break`,
    `date_from`,
    `date_to`,
    `created_at`,
    `updated_at`,
    `id_author`
)
VALUES(
    {$id_workout_track},
    '{$name}',
    {$is_break},
    '{$date_from}',
    '{$date_to}',
    NOW(),
    NULL,
    {$current_user}
)";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "id" => $mysqli->insert_id
)));