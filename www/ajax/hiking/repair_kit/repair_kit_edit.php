<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php");

$current_user = $_COOKIE["user"];

$id = isset($_POST['id'])?intval($_POST['id']):0;
$weight = isset($_POST['weight'])?intval($_POST['weight']):0;
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$name = isset($_POST['name']) && !empty($_POST['name']) ? $mysqli->real_escape_string($_POST['name']) : '';
$comment = isset($_POST['comment']) && !empty($_POST['comment']) ? $mysqli->real_escape_string($_POST['comment']) : '';
$id_assignee = isset($_POST['id_assignee']) && !empty(isset($_POST['id_assignee']))?intval($_POST['id_assignee']):'NULL';

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}
if(!($weight>0)){die(json_encode(array("error"=>"weight is undefined")));}
if(!(strlen($name)>0)){die(json_encode(array("error"=>"name is empty")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'equip'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }


$z = "
UPDATE
    `hiking_repair_kit`
SET
    `name` = '{$name}',
    `weight` = '{$weight}',
    `comment` = '{$comment}',
    `id_assignee` = {$id_assignee},
    `updated_at` = NOW(),
    `updater_id` = {$current_user}
WHERE
    id={$id}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows
)));
