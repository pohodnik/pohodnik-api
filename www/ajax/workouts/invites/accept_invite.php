<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = $_COOKIE["user"];

$id = isset($_POST['id'])?intval($_POST['id']):0;

if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$q = $mysqli->query("SELECT * FROM `workout_invites` WHERE id_user={$current_user} AND id={$id} LIMIT 1");
if($q && $q->num_rows===0) die(json_encode(array("error"=>"Access denied")));

$z = "UPDATE `workout_invites` SET accepted_at=NOW() WHERE id={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows
)));
