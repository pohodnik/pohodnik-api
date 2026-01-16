<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$current_user = intval($_COOKIE["user"]);

$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id_user = isset($_POST['id_user'])?intval($_POST['id_user']):0;
$comment = isset($_POST['comment']) && !empty($_POST['comment']) ? $mysqli->real_escape_string($_POST['comment']) : '';
$date = isset($_POST['date']) && !empty($_POST['date']) ? $mysqli->real_escape_string($_POST['date']) : '';

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!($id_user>0)){die(json_encode(array("error"=>"$id_user is undefined")));}
$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$current_user} LIMIT 1");
if($q && $q->num_rows===0){
    $q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_cook=1  AND id_user = {$current_user} LIMIT 1");
    if($q && $q->num_rows===0){
        die(json_encode(array("error"=>"Нет доступа")));
    }
}


$z = "INSERT INTO `hiking_duty`
    (`id_hiking`, `id_user`, `date`, `comment`, `created_at`, `creator_id`)
    VALUES
    ({$id_hiking},{$id_user},'{$date}','{$comment}',NOW(),{$current_user})";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id
)));
