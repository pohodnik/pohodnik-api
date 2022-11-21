<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_user = isset($_COOKIE["user"]) ? $_COOKIE["user"] : 'NULL';

global $mysqli;

$id = $mysqli->real_escape_string($_POST['id']);
$name = $mysqli->real_escape_string($_POST['name']);
$description = $mysqli->real_escape_string($_POST['description']);
$workout_type = isset($_POST['workout_type']) && !empty($_POST['workout_type']) ? intval($_POST['workout_type']) : 'NULL';


$q = $mysqli ->query("SELECT id_user FROM workouts WHERE id_user={$id_user} AND id={$id} LIMIT 1");
if ($q && $q->num_rows == 0) {
    die(json_encode(array('error'=>"Это не ваш трек")));
}


$z = "
UPDATE
    `workouts`
SET
    `name` = '{$name}',
    `description` = '{$description}',
    `workout_type` = {$workout_type},
    `date_update` = NOW()
WHERE id={$id}
";

$q = $mysqli->query($z);

if(!$q){die(json_encode(array('error'=>$mysqli->error, 'query' => $z)));}

die(json_encode(array('success'=>true)));
