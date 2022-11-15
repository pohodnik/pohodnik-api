<?php
$id = intval($_GET['id']);
if (!($id > 0)) {
    die(json_encode(array('error' => 'id is required')));
}
include("../../blocks/db.php"); //подключение к БД

$id_user = intval($_COOKIE["user"]);

global $mysqli;

$z = "
SELECT
    workout_tracks.*,
    workouts.*,
    users.name as user_name, users.surname as user_surname, users.photo_50 as user_photo,
    workout_types.id as workout_type_id, workout_types.name as workout_type_name
FROM
    `workouts`
    LEFT JOIN users ON users.id = workouts.id_user
    LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
    LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
WHERE workouts.id = {$id} LIMIT 1
";
$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}

$res = $q -> fetch_assoc();

exit(json_encode($res));
