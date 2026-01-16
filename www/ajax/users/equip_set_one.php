<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных


$id_user = intval($_COOKIE["user"]);

if(isset($_GET['id'])){
	$id = intval($_GET['id']);
	$wh = "(
		user_equip_sets.id_user={$id_user}
		OR ({$id_user} IN (SELECT to_user FROM user_equip_sets_share WHERE id_set=user_equip_sets.id))
		OR (SELECT COUNT(*) FROM user_equip_sets_share WHERE id_set=user_equip_sets.id AND to_user IS NULL)
	) AND user_equip_sets.id={$id}";
} else if(isset($_GET['id_hiking'])){
	$id_hiking = intval($_GET['id_hiking']);
	$wh = "user_equip_sets.id_user={$id_user} AND user_equip_sets.id_hiking={$id_hiking}";
}

$r = array();
$z = "
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
    user_backpacks.`photo` as backpack_photo,
    
    user_equip_sets.id_user as user_id,
	users.surname as user_surname,
    users.name as user_name,
	users.photo_50 as user_photo,

    user_equip_sets.id_user={$id_user} AS has_access

FROM `user_equip_sets` 
    LEFT JOIN user_backpacks ON user_backpacks.id = user_equip_sets.`id_backpack`
    LEFT JOIN hiking ON hiking.id = user_equip_sets.`id_hiking`
    LEFT JOIN users ON users.id =user_equip_sets.id_user
WHERE ".$wh;

$q = $mysqli->query($z);
if(!$q) die(jout(err($mysqli->error, array("z" => $z))));
if($q->num_rows===0){die(json_encode(array("noSet" => true)));}
$r = $q->fetch_assoc();

$q = $mysqli->query("SELECT `id`, `id_set`, `to_user` FROM `user_equip_sets_share` WHERE id_set={$r['id']}");
$r['share'] = array();
while($s = $q ->fetch_assoc()) {
	$r['share'][] = $s;
}

die(jout($r));
