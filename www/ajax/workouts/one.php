<?php
$id = intval($_GET['id']);
if (!($id > 0)) {
    die(json_encode(array('error' => 'id is required')));
}
include("../../blocks/db.php"); //подключение к БД

$id_user = intval($_COOKIE["user"]);
ini_set('memory_limit', '256M');
global $mysqli;

$z = "
SELECT
    workout_tracks.*,
    workouts.*,
    users.name as user_name, users.surname as user_surname, users.photo_50 as user_photo,
    workout_types.id as workout_type_id, workout_types.name as workout_type_name,
    hiking_tracks.id_hiking as hiking_id,
    hiking.name as hiking_name,
    hiking.ava as hiking_ava,
    hiking.start as hiking_start,
    hiking.finish as hiking_finish,
    `workouts_groups`.`name` as workout_group_name,
    track_owner.id as track_owner_id,
    track_owner.name as track_owner_name,
    track_owner.surname as track_owner_surname,
    track_owner.photo_50 as track_owner_photo
FROM
    `workouts`
    LEFT JOIN users ON users.id = workouts.id_user
    LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
    LEFT JOIN users as track_owner ON track_owner.id = workout_tracks.id_user
    LEFT JOIN workouts_groups ON workouts.workout_group = workouts_groups.id
    LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
    LEFT JOIN hiking_tracks ON hiking_tracks.id_workout_track = workout_tracks.id
    LEFT JOIN hiking ON hiking_tracks.id_hiking = hiking.id
WHERE workouts.id = {$id} LIMIT 1
";
$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}

$res = $q -> fetch_assoc();

exit(json_encode($res));
