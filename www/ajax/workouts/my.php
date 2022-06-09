<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_user = intval($_COOKIE["user"]);

global $mysqli;

$z = "
SELECT
    workouts.*,
    workout_types.id as workout_type_id, workout_types.name as workout_type_name
FROM
    `workouts`
WHERE
    workouts.`id_user`={$id_user}
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
