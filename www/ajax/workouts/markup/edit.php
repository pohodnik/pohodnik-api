<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = intval($_COOKIE["user"]);

$id = isset($_POST['id'])?intval($_POST['id']):0;
if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$name = $mysqli->real_escape_string($_POST['name']);
$is_break = intval($_POST['is_break']);
$date_from = $mysqli->real_escape_string($_POST['date_from']);
$date_to = $mysqli->real_escape_string($_POST['date_to']);


$z = "UPDATE
    `workout_track_markup`
SET
    `name` = '{$name}',
    `is_break` = {$is_break},
    `date_from` = '{$date_from}',
    `date_to` = '{$date_to}',
    `updated_at` = NOW()
WHERE
    `id` = {$id}
    AND
    `id_author` = {$current_user}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows
)));