<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

if (!isset($_GET['id_hiking'])) {
    die(json_encode(array("error" => "id_hiking is required")));
}
$id_hiking = intval($_GET['id_hiking']);

$id_current_user = intval($_COOKIE["user"]);

$z = "
SELECT
 
    sh.`id`,
    sh.`id_set`,
    sh.`to_user`,
    
    users.name,
    users.surname,
    users.photo_50 as photo,
    
    own.id as own_id,
    own.name as own_name,
    own.surname as own_surname,
    own.photo_50 as own_photo
FROM
    `user_equip_sets_share` as sh
    LEFT JOIN users ON users.id = sh.to_user
    LEFT JOIN user_equip_sets ON user_equip_sets.id = sh.id_set
    LEFT JOIN users AS own ON user_equip_sets.id_user = own.id
WHERE
    id_hiking={$id_hiking}
";

$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error" => $mysqli->error)));
}
$res = array();
while ($r = $q->fetch_assoc()) {
    $res[] = $r;
}
die(json_encode($res));
