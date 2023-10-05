<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/global.php"); //подключение к БД

global $mysqli;

$id = intval($_GET['id']);

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
    geo_regions.name as geo_region_name
FROM
    `obstacles`
    LEFT JOIN users AS creator ON creator.id = obstacles.creator_id
    LEFT JOIN users AS updator ON updator.id = obstacles.updated_id
    LEFT JOIN geo_regions ON geo_regions.id = obstacles.id_geo_region
WHERE obstacles.`id` = {$id}
";
$q = $mysqli->query($z);
if(!$q){die(err($mysqli->error, array('query' => $z)));}
$r = $q->fetch_assoc();
echo(jout($r));

