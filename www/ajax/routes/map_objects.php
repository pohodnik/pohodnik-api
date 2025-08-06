<?php
Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); //Дата в прошлом 
Header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 
Header("Pragma: no-cache"); // HTTP/1.1 
Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
include("../../blocks/db.php"); //подключение к БД

$result = array();
$wh = "";
$fields = "";
$group = "";
$join = "";
$order = "route_objects.ord, route_objects.date_create";


if(isset($_GET['id_route'])){ $wh .= " AND route_objects.id_route = ".intval($_GET['id_route']); }
if(isset($_GET['id_route_object'])){ $wh .= " AND route_objects.id = ".intval($_GET['id_route_object']); }
if(isset($_GET['id_typeobject'])){ $wh .= " AND route_objects.id_typeobject = ".intval($_GET['id_typeobject']); }
if(isset($_GET['all'])){ 
	$fields = ", routes.*, GROUP_CONCAT(hiking.id) AS hikings ";
	$join = " LEFT JOIN routes ON routes.id=route_objects.id_route  LEFT JOIN hiking ON routes.id=hiking.id_route ";
	$group = " GROUP BY route_objects.id ";
}

$res = array();
$q1=$mysqli->query("SELECT
	route_objects.*,
	mountain_passes.name as mp_name,
	mountain_passes.altitude as mp_altitude,
	mountain_passes.comment as mp_comment,
	mountain_passes_categories.name as mpc_name,
	mountain_passes_categories.description as mpc_comment,
	creator.id AS creator_id,
	creator.photo_50 as creator_photo,
    CONCAT(creator.surname,' ', creator.name) as creator_name,
    editor.id AS editor_id,
	editor.photo_50 as editor_photo,
    CONCAT(editor.surname,' ', editor.name) as editor_name,

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
	{$fields}
FROM route_objects
	LEFT JOIN mountain_passes ON mountain_passes.id = route_objects.id_mountain_pass
	LEFT JOIN obstacles ON obstacles.id = route_objects.id_obstacle
	LEFT JOIN mountain_passes_categories ON mountain_passes_categories.id = mountain_passes.id_pass_category
	LEFT JOIN users as creator ON creator.id = route_objects.id_creator 
	LEFT JOIN users as editor ON editor.id = route_objects.id_editor 
	
{$join}
WHERE 1 {$wh} {$group} ORDER BY {$order}");
if(!$q1){die($mysqli->error);}
while($r1=$q1->fetch_assoc()){
	//if($r1['id_typeobject']==2){ $result[]=json_decode($r1['coordinates']); }	
	$res[] = $r1;
}


echo json_encode($res);
