<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = $_COOKIE["user"];

$id_workout = isset($_GET['id_workout'])?intval($_GET['id_workout']):0;

if(!($id_workout>0)){die(json_encode(array("error"=>"id_workout is undefined")));}


$z = "SELECT 
    workout_invites.`id`,
    workout_invites.`id_workout`,
    workout_invites.`id_user`,
    workout_invites.`id_author`,
    workout_invites.`created_at`,
    workout_invites.`accepted_at`,
    workout_invites.`rejected_at`,
    author.id as author_id,
    author.name as author_name,
    author.surname as author_surname,
    author.photo_50 as author_photo,
    users.id as user_id,
    users.name as user_name,
    users.surname as user_surname,
    users.photo_50 as user_photo
FROM
  `workout_invites`
  LEFT JOIN workouts ON workouts.id = workout_invites.`id_workout`
  LEFT JOIN users as author ON author.id =  workout_invites.`id_author`
  LEFT JOIN users ON users.id = workout_invites.id_user
WHERE workout_invites.id_workout={$id_workout}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}
die(out($res));
