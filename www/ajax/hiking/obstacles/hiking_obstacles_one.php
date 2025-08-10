<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_user = $_COOKIE["user"];
$id = isset($_GET['id'])?intval($_GET['id']):0;

if(!($id>0)){die(err("id is undefined"));}

$z = "SELECT
    hiking_obstacles.`id`,
    hiking_obstacles.`id_hiking`,
    hiking_obstacles.`id_obstacle`,
    hiking_obstacles.`description`,
    hiking_obstacles.`description_in`,
    hiking_obstacles.`description_out`,
    hiking_obstacles.`date_in`,
    hiking_obstacles.`date_out`,
    hiking_obstacles.`created_at`,
    hiking_obstacles.`creator_id`,
    hiking_obstacles.`updated_at`,
    hiking_obstacles.`updated_id`,
    cruser.name as creator_name,
    cruser.surname as creator_surname,
    cruser.photo_50 as creator_photo,
    upuser.name as updated_name,
    upuser.surname as updated_surname,
    upuser.photo_50 as updated_photo
FROM `hiking_obstacles`
    LEFT JOIN users as cruser ON cruser.id = hiking_obstacles.`creator_id`
    LEFT JOIN users as upuser ON upuser.id = hiking_obstacles.`updated_id`
WHERE
    hiking_obstacles.id={$id}
";

$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}
$res = $q -> fetch_assoc();


$z = "SELECT
    hiking_obstacles_members.`id`,
    hiking_obstacles_members.`id_hiking_obstacle`,
    hiking_obstacles_members.`id_user` as user_id,
    users.`name` as user_name,
    users.`surname` as user_surname,
    users.`photo_50` as user_photo
FROM
    `hiking_obstacles_members`
    LEFT JOIN users ON users.id = hiking_obstacles_members.id_user
WHERE
    hiking_obstacles_members.id_hiking_obstacle={$id}
";

$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}
$res['members'] = array();
while ($r = $q -> fetch_assoc()) {
    $res['members'][] = $r;
}


$z = "SELECT
    hiking_obstacles_photos.`id`,
    hiking_obstacles_photos.`id_hiking_obstacle`,
    hiking_obstacles_photos.`url_preview`,
    hiking_obstacles_photos.`url`,
    hiking_obstacles_photos.`date`,
    hiking_obstacles_photos.`comment`,
    hiking_obstacles_photos.`created_at`,
    hiking_obstacles_photos.`creator_id`,
    users.`name` as creator_name,
    users.`surname` as creator_surname,
    users.`photo_50` as creator_photo
FROM
    `hiking_obstacles_photos`
    LEFT JOIN users ON users.id = hiking_obstacles_photos.creator_id
WHERE
    hiking_obstacles_photos.id_hiking_obstacle={$id}
";

$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}
$res['photos'] = array();
while ($r = $q -> fetch_assoc()) {
    $res['photos'][] = $r;
}

$z = "SELECT
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
WHERE obstacles.id={$res['id_obstacle']}";

$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}
$res['obstacle'] = $q -> fetch_assoc();



die(out($res));
