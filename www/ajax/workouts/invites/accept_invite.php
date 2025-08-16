<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = $_COOKIE["user"];

$id = isset($_POST['id'])?intval($_POST['id']):0;

if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$q = $mysqli->query("SELECT id_workout FROM `workout_invites` WHERE id_user={$current_user} AND id={$id} LIMIT 1");
if($q && $q->num_rows===0) die(json_encode(array("error"=>"Access denied")));

$r = $q->fetch_assoc();
$id_workout = $r['id_workout'];

$q = $mysqli->query("SELECT `id_user`, `name`, `description`, `workout_type`, `workout_group`, id_workout_track FROM `workouts` WHERE id={$id_workout} LIMIT 1");
if(!$q) { die(err($mysqli->error, array("z" => "workout info")));}
$r = $q->fetch_assoc();
$workout_group = intval($r['workout_group']);
if(!($workout_group > 0)) {
    $z ="
        INSERT INTO `workouts_groups`(
            `name`,
            `workout_type`,
            `id_user`,
            `date_create`
        )
        VALUES(
            '".$r['name']."',
            ".$r['workout_type'].",
            ".$r['id_user'].",
            NOW()
        )
    ";
    $q = $mysqli->query($z);
    if(!$q) { die(err($mysqli->error, array("z" => $z)));}
    $workout_group = $mysqli->insert_id;

    $z = "UPDATE `workouts` SET workout_group={$workout_group} WHERE id={$id_workout}";
    $q = $mysqli->query($z);
    if(!$q) { die(err($mysqli->error, array("z" => $z)));}
}



$z = "INSERT INTO `workouts`(
    `id_user`,
    `name`,
    `description`,
    `workout_type`,
    `workout_group`,
    `id_workout_track`,
    `date_create`
)
VALUES(
    {$current_user},
    '{$r['name']}',
    '{$r['description']}',
    {$r['workout_type']},
    {$workout_group},
    {$r['id_workout_track']},
    NOW()
)";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}
$new_workout_id = $mysqli->insert_id;

$z = "UPDATE `workout_invites` SET accepted_at=NOW() WHERE id={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "workout_id" => $new_workout_id,
    "workout_group" => $workout_group
)));
