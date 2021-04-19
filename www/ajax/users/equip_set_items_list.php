<?
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$id_user = $_COOKIE["user"];
$id = intval($_GET['id']);
$res = array();

$q = $mysqli->query("SELECT 
	user_equip_set_items.id AS iid,	user_equip_set_items.is_check,
	user_equip.id,
	user_equip.id_user, 
	user_equip.name,
	user_equip.photo, 
	user_equip.weight, 
	user_equip.value,
	user_equip.is_musthave,
	user_equip.is_group,
	user_equip.is_archive,
	user_equip.category
FROM user_equip_set_items 
LEFT JOIN user_equip ON(user_equip_set_items.id_equip = user_equip.id)
WHERE user_equip_set_items.id_set={$id}
ORDER BY user_equip.is_musthave DESC, user_equip.name
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
		die(json_encode(array("error"=>'Нет доступа')));
	}

	foreach($res as $i=>$r) {
		$res[$i]['readonly'] = true;
	}
}






die(json_encode($res));