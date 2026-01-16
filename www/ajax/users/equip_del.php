<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/imagesStorage.php"); //Только для авторизованных
include(__DIR__."/../../vendor/autoload.php"); //Только для авторизованных
$id=intval($_POST['id']);
$id_user = intval($_COOKIE["user"]);
$res = array();
$z = "SELECT photo FROM user_equip WHERE id={$id} LIMIT 1";
$q = $mysqli->query($z);
if (!$q) {
	die(json_encode(array("error"=>$mysqli->error)));
}
$r = $q -> fetch_assoc();
$oldPhoto = $r['photo'];

if($mysqli->query("DELETE FROM user_equip WHERE id={$id} AND id_user={$id_user}")){


	if (!empty($oldPhoto)) {
		$z = "SELECT photo FROM user_equip WHERE photo='{$oldPhoto}' LIMIT 1";
		$q = $mysqli->query($z);
		if ($q -> num_rows === 0) {
			if (isUrlCloudinary($oldPhoto)) {
				deleteCloudImageByUrl($oldPhoto);
			} else if(is_file("../../".$oldPhoto)){
				unlink("../../".$oldPhoto);
			}
		}
	}

	$res['success'] = true;
} else {
	$res['error'] = $mysqli->error;
}
die(json_encode($res));
