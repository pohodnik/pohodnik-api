<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = $_COOKIE["user"];

$id_workout = isset($_POST['id_workout'])?intval($_POST['id_workout']):0;
$id_user = isset($_POST['id_user'])?intval($_POST['id_user']):0;

if(!($id_workout>0)){die(json_encode(array("error"=>"id_workout is undefined")));}
if(!($id_user>0)){die(json_encode(array("error"=>"$id_user is undefined")));}

$q = $mysqli->query("SELECT * FROM `workouts` WHERE id_user= {$current_user} LIMIT 1");
if($q && $q->num_rows===0) die(json_encode(array("error"=>"Нет доступа")));

$q = $mysqli->query("SELECT * FROM `workout_invites` WHERE id_user= {$current_user} AND id_workout={$id_workout} LIMIT 1");
if($q && $q->num_rows===1) die(json_encode(array("error"=>"Уже приглашен")));

$z = "
INSERT INTO `workout_invites`(
    `id_workout`,
    `id_user`,
    `id_author`,
    `created_at`,
    `accepted_at`
)
VALUES(
    {$id_workout},
    {$id_user},
    {$current_user},
    NOW(),
    NULL
)
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "id" => $mysqli->insert_id
)));
