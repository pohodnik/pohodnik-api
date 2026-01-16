<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php"); // Права доступа

global $mysqli;
$id_user = intval($_COOKIE["user"]);
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id = $mysqli->real_escape_string($_POST['id']);

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'equip'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }


$z = "DELETE FROM `hiking_repair_kit_approvers` WHERE id={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "z" => $z
)));
