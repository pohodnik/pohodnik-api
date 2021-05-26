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
	mountain_passes_categories.description as mpc_comment
	{$fields}
FROM route_objects
	LEFT JOIN mountain_passes ON mountain_passes.id = route_objects.id_mountain_pass
	LEFT JOIN mountain_passes_categories ON mountain_passes_categories.id = mountain_passes.id_pass_category
{$join}
WHERE 1 {$wh} {$group} ORDER BY {$order}");
if(!$q1){die($mysqli->error);}
while($r1=$q1->fetch_assoc()){
	//if($r1['id_typeobject']==2){ $result[]=json_decode($r1['coordinates']); }	
	$res[] = $r1;
}


echo json_encode($res);