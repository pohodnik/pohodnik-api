<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_user = intval($_COOKIE["user"]);

global $mysqli;

$z = "
SELECT
    workouts.*,
    users.name as user_name, users.surname as user_surname, users.photo_50 as user_photo
FROM
    `workouts`
    LEFT JOIN users ON users.id = workouts.id_user
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
