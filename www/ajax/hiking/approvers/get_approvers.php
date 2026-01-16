<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_user = intval($_COOKIE["user"]);

$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;

if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$where = "";

if (isset($_GET['entity_type'])) {
    $entity_type = $mysqli->real_escape_string($_GET['entity_type']);
    $where = " AND hiking_approvers.`entity_type`='{$entity_type}'";
}

if (isset($_GET['entity_id'])) {
    $entity_id = $mysqli->real_escape_string($_GET['entity_id']);
    $where = $entity_id > 0 ? " AND hiking_approvers.`entity_id`={$entity_id}" : " AND hiking_approvers.`entity_id` IS NULL";
}

$z = "
SELECT
    hiking_approvers.`id`,
    hiking_approvers.`id_hiking`,
    hiking_approvers.`id_user`,
    hiking_approvers.`id_position`,
    hiking_approvers.`entity_id`,
    hiking_approvers.`entity_type`,
    hiking_approvers.`created_at`,
    positions.name as position_name,
    users.name as user_name,
    users.surname as user_surname,
    users.photo_50 as user_photo
FROM `hiking_approvers`
    LEFT JOIN positions ON positions.id = hiking_approvers.`id_position`
    LEFT JOIN users ON users.id = hiking_approvers.`id_user`
WHERE hiking_approvers.id_hiking={$id_hiking} {$where}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
