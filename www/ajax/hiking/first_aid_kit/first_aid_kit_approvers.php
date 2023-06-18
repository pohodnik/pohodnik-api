<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_user = $_COOKIE["user"];
$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;

if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "
SELECT
    hiking_first_aid_kit_approvers.`id`,
    hiking_first_aid_kit_approvers.`id_user`,
    hiking_first_aid_kit_approvers.`id_position`,
    hiking_first_aid_kit_approvers.`date`,
    positions.name as position_name,
    CONCAT(users.name, ' ', users.surname) as user_name,
    users.photo_50 as user_photo
FROM `hiking_first_aid_kit_approvers`
    LEFT JOIN positions ON positions.id = hiking_first_aid_kit_approvers.`id_position`
    LEFT JOIN users ON users.id = hiking_first_aid_kit_approvers.`id_user`
WHERE hiking_first_aid_kit_approvers.id_hiking={$id_hiking} ";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
