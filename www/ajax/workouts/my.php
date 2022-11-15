<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_user = intval($_COOKIE["user"]);
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 100;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;


global $mysqli;

$z = "
SELECT
    workout_tracks.*,
    workouts.*,
    workout_types.id as workout_type_id, workout_types.name as workout_type_name
FROM
    `workouts`
WHERE
    workouts.`id_user`={$id_user}
    LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
    LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
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
