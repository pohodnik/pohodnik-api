<?php
$id = intval($_GET['id']);
if (!($id > 0)) {
    die(json_encode(array('error' => 'id is required')));
}
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
WHERE workouts.id = {$id} LIMIT 1
";
$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}

$res = $q -> fetch_assoc();

exit(json_encode($res));
