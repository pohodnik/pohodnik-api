<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");

$result = array();
$current_user = intval($_COOKIE["user"]);

$id_workout = isset($_POST['id_workout']) ? intval($_POST['id_workout']) : 0;
$id_workout_tag = isset($_POST['id_workout_tag']) ? intval($_POST['id_workout_tag']) : 0;


if (!($id_workout > 0)) { die(json_encode(array("error" => "id_workout is undefined"))); }
if (!($id_workout_tag > 0)) { die(json_encode(array("error" => "id_workout_tag is undefined"))); }

$z = "
INSERT INTO
    `workout_tags_usages`
SET
    `id_workout` = {$id_workout},
    `id_workout_tag` = {$id_workout_tag},
    `created_at` = NOW()
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
