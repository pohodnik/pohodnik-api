<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$result = array();
$id_route = intval($_POST['id_route']);
$id_type = intval($_POST['id_type']);

$coordinates = isset($_POST['coordinates']) ? $mysqli->real_escape_string(trim($_POST['coordinates'])) : '';
$trackData = isset($_POST['trackData']) ? $mysqli->real_escape_string(trim($_POST['trackData'])) : '';

$distance = isset($_POST['distance']) ? intval($_POST['distance']) : 0;

$stroke_color = isset($_POST['stroke_color']) ? $mysqli->real_escape_string(trim($_POST['stroke_color'])) : '#006699';
$stroke_opacity = isset($_POST['stroke_opacity']) ? intval($_POST['stroke_opacity']) : 100;
$stroke_width = isset($_POST['stroke_width']) ? intval($_POST['stroke_width']) : 2;

$id_obstacle = isset($_POST['id_obstacle']) && intval($_POST['id_obstacle']) > 0 ? intval($_POST['id_obstacle']) : 'NULL';


$name = $mysqli->real_escape_string(trim($_POST['name']));
$id_user = isset($_COOKIE["user"])?$_COOKIE["user"]:0;
if($id_route>0 && $id_user>0){
$z = "
INSERT INTO `route_objects` SET
    `id_route`={$id_route},
    `name`='{$name}',
    `coordinates`='".$coordinates."',
    `trackData`='".$trackData."',
    `id_typeobject`={$id_type},
    `distance`={$distance},
    `stroke_color` = '{$stroke_color}',
    `stroke_opacity` = {$stroke_opacity},
    `stroke_width` = {$stroke_width},
    `id_editor`={$id_user},
    `id_creator`={$id_user},
    `date_create`=NOW(),
    `date_last_modif`= NOW(),
    `id_obstacle` = {$id_obstacle}
";
							
	$q = $mysqli->query($z);
	if($q){
	//exit
		$nq = $mysqli->query("SELECT
    route_objects.*,
	creator.id AS creator_id,
	creator.photo_50 as creator_photo,
    CONCAT(creator.surname,' ', creator.name) as creator_name,
    obstacles.`id` as obstacle_id,
    obstacles.`name` as obstacle_name,
    obstacles.`description` as obstacle_description,

    ST_X(obstacles.`coordinates`) as obstacle_lat,
    ST_Y(obstacles.`coordinates`) as obstacle_lon,
    obstacles.`altitude` as obstacle_altitude,
    obstacles.`link` as obstacle_link,
    obstacles.`comment` as obstacle_comment,
    obstacles.`type` as obstacle_type,
    obstacles.`category` as obstacle_category,
    obstacles.`id_geo_region` as obstacle_id_geo_region,
    obstacles.`created_at` as obstacle_created_at,
    obstacles.`creator_id` as obstacle_creator_id

	FROM `route_objects`
        LEFT JOIN users as creator ON creator.id = route_objects.id_creator
	    LEFT JOIN obstacles ON obstacles.id = route_objects.id_obstacle

WHERE route_objects.id=".$mysqli->insert_id." LIMIT 1");
		if(!$nq){exit(json_encode(array("error"=>"Ошибка получ объекта. \r\n".$mysqli->error)));}
		$nr = $nq->fetch_assoc();
		exit(json_encode(array("success"=>"Обьект успешно добавлен", "id"=> $mysqli->insert_id, "data"=>$nr)));
	}else{exit(json_encode(array("error"=>"Ошибка добавления объекта. \r\n".$mysqli->error)));}
}else{exit(json_encode(array("error"=>"Не определен слой для добавления объекта")));}
?>
