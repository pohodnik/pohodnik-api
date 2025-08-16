<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_user = isset($_COOKIE["user"]) ? $_COOKIE["user"] : 'NULL';

global $mysqli;

$id = $mysqli->real_escape_string($_POST['id']);
$name = $mysqli->real_escape_string($_POST['name']);

$q = $mysqli ->query("SELECT id_user FROM workouts WHERE id_user={$id_user} AND workout_group={$id} LIMIT 1");
if ($q && $q->num_rows == 0) die(json_encode(array('error'=>"Это не ваша группа")));

$z = "
UPDATE
    `workouts_groups`
SET
    `name` = '{$name}',
    `date_update` = NOW()
WHERE id={$id}
";

$q = $mysqli->query($z);

if(!$q){die(json_encode(array('error'=>$mysqli->error, 'query' => $z)));}

die(json_encode(array('success'=>true, 'affected' => $mysqli -> affected_rows)));
