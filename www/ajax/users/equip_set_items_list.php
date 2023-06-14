<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$id_user = $_COOKIE["user"];
$id = intval($_GET['id']);
$res = array();
$addWhere = "";

$q = $mysqli->query("SELECT 
	user_equip_set_items.id AS iid,
	user_equip_set_items.is_check,
	user_equip.id,
	user_equip_sets.id_user, 
	user_equip.name,
	user_equip.photo, 
	user_equip.weight, 
	user_equip.value,
	user_equip.is_musthave,
	user_equip.is_group,
	user_equip.is_archive,
	user_equip.id_category,
	user_equip_set_items.id_set,
    `user_equip_set_items`.`amount`,
	user_equip_set_items.from_user AS ownerId,
	CONCAT(users.name, ' ', users.surname) AS ownerName,
	users.photo_50 AS ownerPhoto
FROM user_equip_sets
LEFT JOIN user_equip_set_items ON (user_equip_set_items.id_set = user_equip_sets.id)
LEFT JOIN user_equip ON(user_equip_set_items.id_equip = user_equip.id)
LEFT JOIN users ON(user_equip_set_items.from_user = users.id)
WHERE user_equip_sets.id={$id} AND user_equip_set_items.user_confirm IS NULL {$addWhere}
ORDER BY user_equip.id_category, user_equip.is_musthave DESC, user_equip.name
");
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
while($r = $q->fetch_assoc()){
	$res[] = $r;
}


if($res[0] && $res[0]['id_user'] != $id_user) {
	$z = "SELECT to_user FROM `user_equip_sets_share` where `id_set`={$id} AND (to_user={$id_user} OR to_user IS NULL)";
	$q = $mysqli->query($z);
	if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
	if ($q->num_rows == 0) {
		die(json_encode(array("error"=>'Нет доступа', 'res' => $res)));
	}

	foreach($res as $i=>$r) {
		$res[$i]['readonly'] = true;
	}
}






die(json_encode($res));
