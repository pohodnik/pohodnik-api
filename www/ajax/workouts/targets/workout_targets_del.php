<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = intval($_COOKIE["user"]);

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if (!($id > 0)) {
  die(err("id is incorrect"));
}


$z = "DELETE FROM `workout_targets` WHERE `id` = {$id} AND id_author={$id_user}";
$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}

die(out(array(
  "success" => true,
  "affected" => $mysqli->affected_rows
)));