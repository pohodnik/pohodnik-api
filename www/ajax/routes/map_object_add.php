<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$result = array();
$id_route = intval($_POST['id_route']);
$id_type = intval($_POST['id_type']);
$coordinates = isset($_POST['coordinates']) ? $mysqli->real_escape_string(trim($_POST['coordinates'])) : '';
$trackData = isset($_POST['trackData']) ? $mysqli->real_escape_string(trim($_POST['trackData'])) : '';
$name = $mysqli->real_escape_string(trim($_POST['name']));
$id_user = isset($_COOKIE["user"])?$_COOKIE["user"]:0;
if($id_route>0 && $id_user>0){
$z = "	INSERT INTO `route_objects` 
							SET `id_route`={$id_route},
								`name`='{$name}',
								`coordinates`='".$coordinates."',
								`trackData`='".$trackData."',
								`id_typeobject`={$id_type},
								`id_creator`={$id_user},
								`date_create`='".date('Y-m-d H:i:s')."',
								`id_editor`={$id_user},
								`date_last_modif`= '".date('Y-m-d H:i:s')."'
							";
							
	$q = $mysqli->query($z);
	if($q){
	//exit
		$nq = $mysqli->query("SELECT
    route_objects.*,
	creator.id AS creator_id,
	creator.photo_50 as creator_photo,
    CONCAT(creator.surname,' ', creator.name) as creator_name
	FROM `route_objects`
LEFT JOIN users as creator ON creator.id = route_objects.id_creator 

WHERE route_objects.id=".$mysqli->insert_id." LIMIT 1");
		if(!$nq){exit(json_encode(array("error"=>"Ошибка получ объекта. \r\n".$mysqli->error)));}
		$nr = $nq->fetch_assoc();
		exit(json_encode(array("success"=>"Обьект успешно добавлен", "id"=> $mysqli->insert_id, "data"=>$nr)));
	}else{exit(json_encode(array("error"=>"Ошибка добавления объекта. \r\n".$mysqli->error)));}
}else{exit(json_encode(array("error"=>"Не определен слой для добавления объекта")));}
?>
