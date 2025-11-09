<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_user = $_COOKIE["user"];
$id_hiking = isset($_GET['id_hiking']) ? intval($_GET['id_hiking']) : 0;

if (!($id_hiking > 0)) {
    die(err("id_hiking is undefined"));
}

$z = "SELECT
    hiking_obstacles.`id`,
    hiking_obstacles.`id_hiking`,
    hiking_obstacles.`id_obstacle`,
    hiking_obstacles.`id_hiking_track`,
    hiking_obstacles.`id_hiking_break`,
    hiking_obstacles.`description`,
    hiking_obstacles.`description_in`,
    hiking_obstacles.`description_out`,
    hiking_obstacles.`date_in`,
    hiking_obstacles.`date_out`,
    hiking_obstacles.`created_at`,
    hiking_obstacles.`creator_id`,
    hiking_obstacles.`updated_at`,
    hiking_obstacles.`updated_id`,

    obstacles.`id` as obstacle_id,
    obstacles.`name` as obstacle_name,
    obstacles.`description` as obstacle_description,
    ST_X( obstacles.coordinates) as obstacle_lat,
    ST_Y( obstacles.coordinates) as obstacle_lon,
    obstacles.`altitude` as obstacle_altitude,
    obstacles.`link` as obstacle_link,
    obstacles.`comment` as obstacle_comment,
    obstacles.`type` as obstacle_type,
    obstacles.`category` as obstacle_category,
    obstacles.`id_geo_region` as obstacle_geo_region_id,
    geo_regions.`name` as obstacle_geo_region_name,

    cruser.name as creator_name,
    cruser.surname as creator_surname,
    cruser.photo_50 as creator_photo,
    upuser.name as updated_name,
    upuser.surname as updated_surname,
    upuser.photo_50 as updated_photo
FROM `hiking_obstacles`
    LEFT JOIN users as cruser ON cruser.id = hiking_obstacles.`creator_id`
    LEFT JOIN users as upuser ON upuser.id = hiking_obstacles.`updated_id`
    LEFT JOIN obstacles ON obstacles.id = hiking_obstacles.`id_obstacle`
    LEFT JOIN geo_regions ON geo_regions.id = obstacles.id_geo_region
WHERE
    hiking_obstacles.id_hiking={$id_hiking}
";
$q = $mysqli->query($z);
if (!$q) {
    die(err($mysqli->error, array("z" => $z)));
}
$res = array();
while ($r = $q->fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
