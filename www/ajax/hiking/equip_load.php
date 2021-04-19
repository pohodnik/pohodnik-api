<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$id_hiking = intval($_GET['id_hiking']);
$id_user = $_COOKIE["user"];

$q = $mysqli->query("
	SELECT
		he.id, he.`id_user`, he.`name`, he.`weight`, he.`value` , he.is_confirm, he.photo,
		users.name AS uname, users.surname AS usurname, users.photo_50
	FROM
		hiking_equipment  AS he
		LEFT JOIN users ON (users.id = he.id_user)
	WHERE
		he.id_hiking={$id_hiking}
	ORDER BY users.id
");

if($q){
	while($r = $q->fetch_assoc()){
		$r['my'] = $r['id_user'] == $id_user;
		$result[] = $r;
	}
	exit(json_encode($result));
}else{exit(json_encode(array("error"=>"Ошибка . \r\n".$mysqli->error)));}

?>