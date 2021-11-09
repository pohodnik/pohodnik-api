<?php
include("../../../blocks/db.php"); //подключение к БД
include("../../../blocks/for_auth.php"); //Только для авторизованных
include("../../../blocks/imagesStorage.php"); //Только для авторизованных
include("../../../vendor/autoload.php"); //Только для авторизованных
$result = array();
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):'NULL';
$url = isset($_POST['url'])?($_POST['url']):'NULL';
$id_user = isset($_COOKIE["user"])?$_COOKIE["user"]:0;

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_guide=1  AND id_user = {$id_user} LIMIT 1");
	if($q && $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа")));
	}
}

	if (isUrlCloudinary($url)) {
		deleteCloudImageByUrl($url);
	} else if(is_file('../../../'.$url)){
		unlink('../../../'.$url);
	}	

?>