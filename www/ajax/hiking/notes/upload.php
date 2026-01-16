<?php
include("../../../blocks/db.php"); //подключение к БД
include("../../../blocks/for_auth.php"); //Только для авторизованных

$id_hiking = intval($_GET['id_hiking']);
$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$id_user = intval($_COOKIE["user"]);
if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
$q = $mysqli->query("SELECT id FROM hiking_members WHERE id_hiking={$id_hiking}  AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0) die(json_encode(array("error"=>"Нет доступа")));

if (!is_array($data)) die(json_encode(array("error"=>"data is not array")));

$add = array();
foreach ($data as $item) {
    $coordinates = $item['coordinates'];
    $comment = $item['comment'];
    $created = $item['created'];
    $add[] = "({$id_hiking},'{$coordinates}','{$comment}','{$created}',NOW(),{$id_user})";
}

$z = "
INSERT INTO `hiking_notes`
    (`id_hiking`, `coordinates`, `comment`, `created_at`, `uploaded_at`, `creator_id`)
    VALUES ".implode(",\n", $add)."
";
$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error, "z"=>$z)));}
die(json_encode(array("success"=>true)));
