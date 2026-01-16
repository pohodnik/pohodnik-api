<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php");
$result = array();
$current_user = intval($_COOKIE["user"]);

$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id_hiking_obstacle = isset($_POST['id_hiking_obstacle'])?intval($_POST['id_hiking_obstacle']):0;
$id_user = isset($_POST['id_user'])?intval($_POST['id_user']):0;

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!($id_hiking_obstacle>0)){die(json_encode(array("error"=>"id_hiking_obstacle is undefined")));}
if(!($id_user>0)){die(json_encode(array("error"=>"id_user is undefined")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'routes'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }


$z = "INSERT INTO `hiking_obstacles_members`(`id_hiking_obstacle`, `id_user`) VALUES ({$id_hiking_obstacle},{$id_user})";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id
)));
