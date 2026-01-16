<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$id_user = intval($_COOKIE["user"]);
$res = array();
$claus = "";
if(isset($_GET['id_hiking'])){
	$claus .= " AND user_equip_sets.id_hiking=".intval($_GET['id_hiking']);
}

if(isset($_GET['id_backpack'])){
	$claus .= " AND user_equip_sets.id_backpack=".intval($_GET['id_backpack']);
}

$q = $mysqli->query("
SELECT
    user_equip_sets.`id`,
    user_equip_sets.`id_user`,
    user_equip_sets.`id_hiking`,
    user_equip_sets.`id_backpack`,
    user_equip_sets.`name`,
    user_equip_sets.`description`,
    user_equip_sets.`date_update`,
    
    hiking.id as hiking_id,
    hiking.name as hiking_name,
    hiking.ava as hiking_ava,
    hiking.start as hiking_start,
    hiking.finish as hiking_finish,

    user_backpacks.`id` as backpack_id,
    user_backpacks.`id_user` as backpack_id_user,
    user_backpacks.`name` as backpack_name,
    user_backpacks.`weight` as backpack_weight,
    user_backpacks.`value` as backpack_value,
    user_backpacks.`photo` as backpack_photo
FROM
    `user_equip_sets`
    LEFT JOIN user_backpacks ON user_backpacks.id = user_equip_sets.`id_backpack`
    LEFT JOIN hiking ON hiking.id = user_equip_sets.`id_hiking`
WHERE
    user_equip_sets.id_user={$id_user}
    {$claus}
");
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
while($r = $q->fetch_assoc()){
	$res[] = $r;
}
die(json_encode($res));
