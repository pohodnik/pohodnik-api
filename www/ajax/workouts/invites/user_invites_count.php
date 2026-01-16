<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = intval($_COOKIE["user"]);
$z = "SELECT COUNT(*) FROM `workout_invites` WHERE id_user={$current_user} AND accepted_at IS NULL AND rejected_at IS NULL";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "count" => $q->fetch_row()[0]
)));
