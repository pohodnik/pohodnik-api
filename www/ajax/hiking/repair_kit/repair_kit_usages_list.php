<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;
if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "SELECT
    `hiking_repair_kit_usages`.`id`,
    `hiking_repair_kit_usages`.`id_hiking_repair_kit`,
    `hiking_repair_kit_usages`.`date`,
    `hiking_repair_kit_usages`.`comment`,
    `hiking_repair_kit_usages`.`created_at`,
    `hiking_repair_kit_usages`.`creator_id`,
    `hiking_repair_kit_usages`.`id_user`,

    
    creator.name as creator_name,
    creator.surname as creator_surname,
    creator.photo_50 as creator_photo,

    users.name as user_name,
    users.surname as user_surname,
    users.photo_50 as user_photo
FROM
    `hiking_repair_kit_usages`
    LEFT JOIN hiking_repair_kit ON hiking_repair_kit_usages.id_hiking_repair_kit = hiking_repair_kit.id
    LEFT JOIN users as creator ON creator.id = `hiking_repair_kit_usages`.`creator_id`
    LEFT JOIN users ON users.id = `hiking_repair_kit_usages`.`id_user`
WHERE
    hiking_repair_kit.id_hiking={$id_hiking}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
