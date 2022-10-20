<?php
include("../../../../blocks/db.php"); //подключение к БД
include("../../../../blocks/for_auth.php"); //Только для авторизованных

$id_user = isset($_COOKIE["user"]) ? $_COOKIE["user"] : 'NULL';

global $mysqli;
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$id_track = intval($_POST['id_track']);
$is_break = $mysqli->real_escape_string($_POST['is_break']);
$name = $mysqli->real_escape_string($_POST['name']);
$from_point = implode('|', $_POST['from_point']);
$to_point = implode('|', $_POST['to_point']);
$from_time = intval($_POST['from_time']);
$to_time = intval($_POST['to_time']);

$sql_command = $id > 0 ? "UPDATE" : "INSERT INTO";
$sql_where = $id > 0 ? "WHERE id={$id}" : "";
$updated = $id > 0 ? "`updated_at` = NOW()," : "`updated_at` = NULL,";
$created = $id > 0 ? "" : "`created_at` = NOW(),";

$z = "
{$sql_command}
    `hiking_tracks_break`
SET
    `id_track` = {$id_track},
    `is_break` = {$is_break},
    `name` = '{$name}',
    `name` = '{$name}',
    `from_point` = '{$from_point}',
    `from_time` = {$from_time},
    `to_point` = '{$to_point}',
    `to_time` = {$to_time},
    {$created}
    {$updated}
    `id_author` = {$id_user}
{$sql_where}
";

$q = $mysqli->query($z);

if(!$q){die(json_encode(array('error'=>$mysqli->error, 'query' => $z)));}

die(json_encode(array('success'=>true,'id'=>$mysqli->insert_id)));
