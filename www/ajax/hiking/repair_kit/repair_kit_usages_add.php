<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php");

$current_user = intval($_COOKIE["user"]);

$id_hiking_repair_kit = isset($_POST['id_hiking_repair_kit'])?intval($_POST['id_hiking_repair_kit']):0;
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id_user = isset($_POST['id_user']) && !empty($_POST['id_user']) ?intval($_POST['id_user']):'NULL';
$comment = isset($_POST['comment']) && !empty($_POST['comment']) ? $mysqli->real_escape_string($_POST['comment']) : '';
$date = isset($_POST['date']) && !empty($_POST['date']) ? $mysqli->real_escape_string($_POST['date']) : '';

if(!($id_hiking_repair_kit>0)){die(json_encode(array("error"=>"id_hiking_repair_kit is undefined")));}
if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'equip'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }


$z = "
INSERT INTO `hiking_repair_kit_usages`(
    `id_hiking_repair_kit`,
    `id_user`,
    `comment`,
    `date`,
    `created_at`,
    `creator_id`
)
VALUES(
    {$id_hiking_repair_kit},
    {$id_user},
    '{$comment}',
    '{$date}',
    NOW(),
    {$current_user}
)
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id
)));
