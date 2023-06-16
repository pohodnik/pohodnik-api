<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_hiking = intval($_GET['id_hiking']);
$id_user = $_COOKIE["user"];

$claus1 = '';
$claus2 = '';

if (isset($_GET['confirmed']) && intval($_GET['confirmed']) == 1) {
	$claus1 .= " AND is_confirm=1";
	$claus2 .= " AND uesi.date_confirm IS NOT NULL";
}

$result = array();

$q = $mysqli->query("
	(
		SELECT
			he.id, he.id_user, he.name, he.weight, he.value, he.photo,
			he.is_confirm,
			users.name AS uname, users.surname AS usurname, users.photo_50,
			NULL AS id_equip,
			NULL AS from_user_id,
			NULL AS from_user_name,
			NULL AS from_user_photo,
			'hiking' AS src,
			he.id_user = {$id_user} as my
		FROM
			hiking_equipment  AS he
			LEFT JOIN users ON (users.id = he.id_user)
		WHERE
			he.id_hiking={$id_hiking} {$claus1}
	)

	UNION
	
	(
		SELECT
			ue.id, user_equip_sets.id_user, ue.name, ue.weight, ue.value, ue.photo,
			(uesi.date_confirm IS NOT NULL) as is_confirm,
			users.name AS uname, users.surname AS usurname, users.photo_50,
			uesi.id as id_equip,
			from_user AS from_user_id,
			CONCAT(fu.name,' ', fu.surname)  AS from_user_name,
			fu.photo_50 AS from_user_photo,
			'equip' AS src,
			user_equip_sets.id_user = {$id_user} as my
		FROM
			user_equip_set_items AS uesi
			LEFT JOIN user_equip_sets ON (user_equip_sets.id = uesi.id_set)
			LEFT JOIN user_equip AS ue ON (uesi.id_equip = ue.id)
			LEFT JOIN users ON (users.id = user_equip_sets.id_user)
			LEFT JOIN users as fu ON (fu.id = uesi.from_user)
		WHERE
			user_equip_sets.id_hiking={$id_hiking} AND ue.is_group = 1 {$claus2}
	)
	
	ORDER BY id_user
");

if($q){
	while($r = $q->fetch_assoc()){
		$r['my'] = $r['id_user'] == $id_user;
		$result[] = $r;
	}
	exit(json_encode($result));
}else{exit(json_encode(array("error"=>"Ошибка . \r\n".$mysqli->error)));}

?>
