<?php
include("../../blocks/db.php"); //подключение к БД

$id_user = intval($_COOKIE["user"]);

global $mysqli;

$z = "
SELECT
    workouts.*,
    users.name as user_name, users.surname as user_surname, users.photo_50 as user_photo,
    workout_types.id as workout_type_id, workout_types.name as workout_type_name
FROM
    `workouts`
    LEFT JOIN users ON users.id = workouts.id_user
    LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
ORDER BY workouts.date_start DESC
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
