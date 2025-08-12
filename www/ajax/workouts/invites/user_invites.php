<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = $_COOKIE["user"];
$z = "SELECT 
    workout_invites.`id`,
    workout_invites.`id_workout`,
    workout_invites.`id_user`,
    workout_invites.`id_author`,
    workout_invites.`created_at`,
    workout_invites.`accepted_at`,
    workout_invites.`rejected_at`,
    users.id as author_id,
    users.name as author_name,
    users.surname as author_surname,
    users.photo_50 as author_photo,
    workouts.name,
    workouts.description,
    workouts.workout_group as workout_group_id,
    workouts_groups.name as workout_group_name,
    workout_tracks.id as id_workout_track,
    workout_tracks.date_start,
    workout_tracks.date_finish,
    workout_tracks.distance,
    workout_types.id as workout_type_id,
    workout_types.name as workout_type_name
FROM
  `workout_invites`
  LEFT JOIN users ON users.id = workout_invites.`id_author`
  LEFT JOIN workouts ON workouts.id = workout_invites.`id_workout`
  LEFT JOIN users ON users.id = workouts.id_author
  LEFT JOIN workouts_groups ON workouts.workout_group = workouts_groups.id
  LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
  LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
WHERE workout_invites.id_user={$current_user} AND workout_invites.accepted_at IS NULL AND workout_invites.rejected_at IS NULL";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}
die(out($res));
