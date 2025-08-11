<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/global.php"); //подключение к БД

global $mysqli;

$claus = "";

if (isset($_GET['type'])) {
    $claus .= " AND obstacles.`type` = '".$mysqli->real_escape_string($_GET['type'])."'";
}

if (isset($_GET['bounds'])) {
    $bounds = explode(',', $mysqli->real_escape_string($_GET['bounds']));


    $claus .= "AND ST_INTERSECTS(
        ST_MakeEnvelope(Point({$bounds[0]}, {$bounds[1]}), Point({$bounds[2]}, {$bounds[3]})), 
        obstacles.coordinates
    )
  ";
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
    geo_regions.name as geo_region_name
FROM
    `obstacles`
    LEFT JOIN users AS creator ON creator.id = obstacles.creator_id
    LEFT JOIN users AS updator ON updator.id = obstacles.updated_id
    LEFT JOIN geo_regions ON geo_regions.id = obstacles.id_geo_region
WHERE 1 {$claus}
";
$q = $mysqli->query($z);
if(!$q){die(err($mysqli->error, array('query' => $z)));}
$res = array();

while($r = $q->fetch_assoc()) {
    $res[] = $r;
}
echo(jout($res));

