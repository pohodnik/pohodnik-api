<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = intval($_COOKIE["user"]);

$id = isset($_POST['id'])?intval($_POST['id']):0;
if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$z = "DELETE FROM
    `workout_track_markup`
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