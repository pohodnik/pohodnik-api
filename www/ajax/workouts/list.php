<?php
include("../../blocks/db.php"); //подключение к БД

$id_user = intval($_COOKIE["user"]);
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 30;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$id_group = isset($_GET['id_group']) ?  : 0;


$where = "1";

if (isset($_GET['id_group'])) {
    $id_group = intval($_GET['id_group']);
    $where .= " AND `workouts`.`workout_group`={$id_group}";
}

if (isset($_GET['d1'])) {
    $d1 = $mysqli->real_escape_string($_GET['d1']);
    $where .= " AND `workout_tracks`.`date_start`>'{$d1}'";
}

if (isset($_GET['d2'])) {
    $d2 = $mysqli->real_escape_string($_GET['d2']);
    $where .= " AND `workout_tracks`.`date_finish`<'{$d2}'";
}

global $mysqli;

$z = "
SELECT
    `workouts`.`id`,
    `workouts`.`id_user`,
    `workouts`.`name`,
    `workouts`.`description`,
    `workouts`.`workout_type`,
    `workouts`.`workout_group`,
    `workout_tracks`.`id` as id_workout_track,
    `workout_tracks`.`date_start`,
    `workout_tracks`.`date_finish`,
    `workout_tracks`.`date_upload`,
    `workout_tracks`.`date_update`,
    `workout_tracks`.`activity_type`,
    `workout_tracks`.`distance`,
    `workout_tracks`.`alt_ascent`,
    `workout_tracks`.`alt_descent`,
    `workout_tracks`.`alt_max`,
    `workout_tracks`.`alt_min`,
    `workout_tracks`.`alt_avg`,
    `workout_tracks`.`speed_max`,
    `workout_tracks`.`speed_min`,
    `workout_tracks`.`speed_avg`,
    `workout_tracks`.`hr_max`,
    `workout_tracks`.`hr_min`,
    `workout_tracks`.`hr_avg`,
    `workout_tracks`.`temp_max`,
    `workout_tracks`.`temp_min`,
    `workout_tracks`.`temp_avg`,
    `workout_tracks`.`time_mooving`,
    `workout_tracks`.`time_pause`,
    users.name as user_name, users.surname as user_surname, users.photo_50 as user_photo,
    workout_types.id as workout_type_id, workout_types.name as workout_type_name,
    hiking_tracks.id_hiking as hiking_id,
    hiking.name as hiking_name,
    hiking.ava as hiking_ava,
    hiking.start as hiking_start,
    hiking.finish as hiking_finish
FROM
    `workouts`
    LEFT JOIN users ON users.id = workouts.id_user
    LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
    LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
    LEFT JOIN hiking_tracks ON hiking_tracks.id_workout_track = workout_tracks.id
    LEFT JOIN hiking ON hiking_tracks.id_hiking = hiking.id
WHERE {$where}
ORDER BY workout_tracks.date_start DESC
LIMIT {$limit} OFFSET {$offset}
";
$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}

$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

exit(json_encode($res));
