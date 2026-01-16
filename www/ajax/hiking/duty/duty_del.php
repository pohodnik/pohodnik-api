<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$current_user = intval($_COOKIE["user"]);

$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id = isset($_POST['id'])?intval($_POST['id']):0;

if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}
if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$current_user} LIMIT 1");
if($q && $q->num_rows===0){
    $q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_cook=1  AND id_user = {$current_user} LIMIT 1");
    if($q && $q->num_rows===0){
        die(json_encode(array("error"=>"Нет доступа")));
    }
}


$z = "DELETE FROM `hiking_duty`  WHERE `id`={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
)));
