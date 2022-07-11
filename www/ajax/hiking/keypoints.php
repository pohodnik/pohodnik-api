<?php
include("../../blocks/db.php"); //подключение к БД
// include("../../blocks/for_auth.php"); //Только для авторизованных
$result = array();
$id_hiking = intval($_GET['id_hiking']);
$q = $mysqli->query("SELECT `id`, `name`, `date`, `lat`, `lon` FROM `hiking_keypoints` WHERE id_hiking={$id_hiking} ORDER BY date");
if(!$q){die(json_encode(array("error"=>"Error. ".$mysqli->error)));}
while($r=$q->fetch_assoc()){
    $result[] = $r;
}

die(json_encode($result));
