<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;
if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "SELECT
    `hiking_repair_kit`.`id`,
    `hiking_repair_kit`.`id_hiking`,
    `hiking_repair_kit`.`name`,
    `hiking_repair_kit`.`comment`,
    `hiking_repair_kit`.`created_at`,
    `hiking_repair_kit`.`creator_id`,
    `hiking_repair_kit`.`updated_at`,
    `hiking_repair_kit`.`updater_id`,
    `hiking_repair_kit`.`id_assignee`,
    `hiking_repair_kit`.`weight`,
    
    creator.name as creator_name,
    creator.surname as creator_surname,
    creator.photo_50 as creator_photo,

    updater.name as updater_name,
    updater.surname as updater_surname,
    updater.photo_50 as updater_photo,

    assignee.name as assignee_name,
    assignee.surname as assignee_surname,
    assignee.photo_50 as assignee_photo
FROM
    `hiking_repair_kit`
    LEFT JOIN users as creator ON creator.id = `hiking_repair_kit`.`creator_id`
    LEFT JOIN users as updater ON updater.id = `hiking_repair_kit`.`updater_id`
    LEFT JOIN users as assignee ON assignee.id = `hiking_repair_kit`.`id_assignee`
WHERE
    id_hiking={$id_hiking}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
