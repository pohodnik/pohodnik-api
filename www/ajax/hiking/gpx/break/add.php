<?php
include("../../../../blocks/db.php"); //подключение к БД
include("../../../../blocks/for_auth.php"); //Только для авторизованных

$id_user = isset($_COOKIE["user"]) ? $_COOKIE["user"] : 'NULL';

global $mysqli;

$id_track = intval($_POST['id_track']);
$name = $mysqli->real_escape_string($_POST['name']);
$from_point = implode('|', $_POST['from_point']);
$to_point = implode('|', $_POST['to_point']);
$from_time = intval($_POST['from_time']);
$to_time = intval($_POST['to_time']);

$z = "
INSERT INTO
    `hiking_tracks_break`
SET
    `id_track` = {$id_track},
    `name` = '{$name}',
    `from_point` = '{$from_point}',
    `from_time` = {$from_time},
    `to_point` = '{$to_point}',
    `to_time` = {$to_time},
    `created_at` = NOW(),
    `updated_at` = NULL,
    `id_author` = {$id_user}
";

$q = $mysqli->query($z);

if(!$q){die(json_encode(array('error'=>$mysqli->error, 'query' => $z)));}

die(json_encode(array('success'=>true,'id'=>$mysqli->insert_id)));
