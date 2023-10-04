<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных

$id_user = isset($_COOKIE["user"]) ? $_COOKIE["user"] : 'NULL';

global $mysqli;

$name = $mysqli->real_escape_string($_POST['name']);
$description = $mysqli->real_escape_string($_POST['description']);
$lat = floatval($_POST['lat']);
$lon = floatval($_POST['lon']);
$alt = intval($_POST['alt']);
$link = $mysqli->real_escape_string($_POST['link']);
$comment = $mysqli->real_escape_string($_POST['comment']);
$type = $mysqli->real_escape_string($_POST['type']);
$category = $mysqli->real_escape_string($_POST['category']);
$id_geo_region = $_POST['id_geo_region'] > 0 ? intval($_POST['id_geo_region']) : 'NULL';

$z = "
INSERT INTO
    `obstacles`
SET
    `name` = '{$name}',
    `description` = '{$description}',
    `coordinates` = POINT({$lat}, {$lon}),
    `altitude` = {$alt},
    `link` = '{$link}',
    `comment` = '{$comment}',
    `type` = '{$type}',
    `category` = '{$category}',
    `id_geo_region` = {$id_geo_region},
    `created_at` = NOW(),
    `creator_id` = {$id_user}
";

$q = $mysqli->query($z);
if(!$q){die(err($mysqli->error, array('query' => $z)));}
die(jout(array('id' => $mysqli->insert_id, 'success' => true)));
