<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных


$id_user = $_COOKIE["user"];

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
$q = $mysqli->query("
	SELECT
		user_backpacks.*,
		user_backpacks.name AS backpack_name,
		user_equip_sets.*,
		user_equip_sets.id_user={$id_user} AS has_access 
	FROM `user_equip_sets` 
		LEFT JOIN user_backpacks ON user_backpacks.id =user_equip_sets.id_backpack 
		WHERE ".$wh
);
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
if($q->num_rows===0){die(json_encode(array("noSet" => true)));}
$r = $q->fetch_assoc();

$q = $mysqli->query("SELECT `id`, `id_set`, `to_user` FROM `user_equip_sets_share` WHERE id_set={$r['id']}");
$r['share'] = array();
while($s = $q ->fetch_assoc()) {
	$r['share'][] = $s;
}


if($r['id_hiking']>0){
	$qh = $mysqli->query("SELECT id, name, UNIX_TIMESTAMP(`start`) AS start, UNIX_TIMESTAMP(`finish`) AS finish FROM hiking WHERE id=".$r['id_hiking']." LIMIT 1");
	if($qh && $qh->num_rows===1){
		$r['hiking'] = $qh->fetch_assoc();
	}
}
die(json_encode($r));