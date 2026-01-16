<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php"); // Права доступа

$allow_types = array('obstacle', 'schedule', 'menu','first_aid_kit','repair_kit');

$types_positions = array(
    'obstacle' => array('boss', 'routes'),
    'schedule' => array('boss', 'routes', 'time'),
    'menu' => array('boss', 'kitchen'),
    'first_aid_kit' => array('boss', 'health'),
    'repair_kit' => array('boss', 'equip')
);

global $mysqli;
$id_user = intval($_COOKIE["user"]);
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$entity_id = isset($_POST['entity_id']) && intval($_POST['entity_id']) > 0?intval($_POST['entity_id']):'NULL';
$entity_type = isset($_POST['entity_type'])?$mysqli->real_escape_string($_POST['entity_type']):'';

$id_position = isset($_POST['id_position']) && !empty($_POST['id_position']) ? $mysqli->real_escape_string($_POST['id_position']) : 'NULL';

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!in_array($entity_type, $allow_types)){die(json_encode(array("error"=>"entity_type is not allow")));}

$hasRules = hasHikingRules($id_hiking, $types_positions[$entity_type]);
if (!$hasRules) die(json_encode(array("error"=>"У вас нет доступа")));

$q = $mysqli -> query("SELECT * FROM hiking_approvers WHERE id_hiking={$id_hiking} AND id_position={$id_position} AND id_user={$id_user} LIMIT 1");
if ($q && $q->num_rows == 1) die(json_encode(array("error"=>"Вы уже подтверждали")));

$z = "INSERT INTO `hiking_approvers`(
    `id_hiking`,
    `id_user`,
    `id_position`,
    `entity_id`,
    `entity_type`,
    `created_at`
)
VALUES(
    {$id_hiking},
    {$id_user},
    {$id_position},
    {$entity_id},
    '{$entity_type}',
    NOW()
)";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}


die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id
)));
