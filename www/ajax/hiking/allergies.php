<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/global.php");

$res = array();
$id_hiking = intval($_GET['id_hiking']);

$z = "SELECT
    `user_allergies`.`id`,
    `user_allergies`.`id_user`,
    `user_allergies`.`name`,
    `user_allergies`.`comment`,
    `user_allergies`.`id_product`,
    `user_allergies`.`id_medicament`,
    `user_allergies`.`type`,
    `user_allergies`.`created_at`,
    `user_allergies`.`updated_at`,
    `users`.`name` AS user_name,
    `users`.`surname` AS user_surname,
    `users`.`photo_50` AS user_photo
FROM
    `user_allergies`
LEFT JOIN users ON users.id = `user_allergies`.`id_user`
WHERE
    `user_allergies`.`id_user` IN(
    SELECT
        id_user
    FROM
        hiking_members
    WHERE
        id_hiking = {$id_hiking}
);";

$q = $mysqli->query($z);
if(!$q) die(jout(err($mysqli->error, array("z"=>$z))));

while ($r = $q->fetch_assoc()) {
    $res[] = $r;
}

echo jout($res);
	