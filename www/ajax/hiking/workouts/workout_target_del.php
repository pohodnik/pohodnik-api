<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id = isset($_POST['id'])?intval($_POST['id']):0;


if(!($id_hiking > 0)){die(err("id_hiking is incorrect"));}
if(!($id > 0)){die(err("id is incorrect"));}

$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0){ die(err("Нет доступа"));}

$z = "DELETE FROM `hiking_workouts_target` WHERE `id` = {$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows
)));
