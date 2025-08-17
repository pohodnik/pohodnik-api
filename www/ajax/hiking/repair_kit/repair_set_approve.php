<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php"); // Права доступа

global $mysqli;
$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id_position = $mysqli->real_escape_string($_POST['id_position']);

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!($id_position>0)){die(json_encode(array("error"=>"id_position is undefined")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'equip'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }



$q = $mysqli -> query("
SELECT * FROM hiking_repair_kit_approvers WHERE 
                                                   id_hiking={$id_hiking} AND id_position={$id_position} AND id_user={$id_user} LIMIT 1");
if ($q && $q->num_rows == 1) {
    die(json_encode(array("error"=>"Вы уже подтверждали")));
}



$z = "INSERT INTO `hiking_repair_kit_approvers`
    (`id`, `id_user`,`id_hiking`, `id_position`, `date`)
    VALUES 
    (NULL,{$id_user},{$id_hiking},{$id_position},NOW())
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}


die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id,
    "z" => $z
)));
