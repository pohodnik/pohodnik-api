<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/global.php"); //подключение к БД

global $mysqli;

$id_user = isset($_GET['id_user']) ? intval($_GET['id_user']) : $_COOKIE["user"];

$claus = "";

if (isset($_GET['type'])) {
    $claus .= " AND obstacles.`type` = '".$mysqli->real_escape_string($_GET['type'])."'";
}

$z = "
SELECT
    obstacles.`id`,
    obstacles.`name`,
    obstacles.`description`,
    ST_X( obstacles.coordinates) as lat,
    ST_Y( obstacles.coordinates) as lon,
    obstacles.`altitude`,
    obstacles.`link`,
    obstacles.`comment`,
    obstacles.`type`,
    obstacles.`category`,
    obstacles.`id_geo_region` as geo_region_id,
    obstacles.`created_at`,
    obstacles.`creator_id`,
    obstacles.`updated_at`,
    obstacles.`updated_id` as updator_id,
    CONCAT(creator.name,' ',creator.surname) AS creator_name,
    CONCAT(updator.name,' ',updator.surname) AS updator_name,
    geo_regions.name as geo_region_name,
    hiking_obstacles_members.`id_hiking_obstacle`,
    hiking_obstacles.date_in,
    hiking_obstacles.date_out,
    hiking_obstacles.id_hiking,
    hiking.name as hiking_name,
    hiking.ava as hiking_ava
FROM
    `hiking_obstacles_members`
    LEFT JOIN hiking_obstacles ON hiking_obstacles_members.id_hiking_obstacle = hiking_obstacles.id
    LEFT JOIN `obstacles` ON `obstacles`.id = hiking_obstacles.id_obstacle
    LEFT JOIN users AS creator ON creator.id = obstacles.creator_id
    LEFT JOIN users AS updator ON updator.id = obstacles.updated_id
    LEFT JOIN geo_regions ON geo_regions.id = obstacles.id_geo_region
    LEFT JOIN hiking ON hiking.id = hiking_obstacles.id_hiking
WHERE hiking_obstacles_members.`id_user` = {$id_user} {$claus}
ORDER BY obstacles.`altitude` DESC
";
$q = $mysqli->query($z);
if(!$q){die(err($mysqli->error, array('query' => $z)));}
$res = array();

while($r = $q->fetch_assoc()) {
    $res[] = $r;
}
echo(jout($res));

