<?
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/imagesStorage.php"); //Только для авторизованных
include("../../vendor/autoload.php"); //Только для авторизованных
$id=intval($_POST['id']);
$id_user = $_COOKIE["user"];
$res = array();

$z = "SELECT photo FROM user_backpacks WHERE id={$id} LIMIT 1";
$q = $mysqli->query($z);
if (!$q) {
	die(json_encode(array("error"=>$mysqli->error)));
}
$r = $q -> fetch_assoc();
$oldPhoto = $r['photo'];

if (!empty($oldPhoto)) {
	if (isUrlCloudinary($oldPhoto)) {
		deleteCloudImageByUrl($oldPhoto);
	}
}


if($mysqli->query("DELETE FROM user_backpacks WHERE id={$id} AND id_user={$id_user}")){
	$res['success'] = true;
} else {
	$res['error'] = $mysqli->error;
}
die(json_encode($res));