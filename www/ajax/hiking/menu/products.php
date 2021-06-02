<?php
include("../../../blocks/db.php"); //подключение к БД
include("../../../blocks/for_auth.php"); //Только для авторизованных
$res = array();
$id_hiking = intval($_GET['id_hiking']);

$addwhere = "";

if(isset($_GET['id_act'])){$addwhere .= " AND hiking_menu.id_act=".intval($_GET['id_act'])." ";}
if(isset($_GET['date'])){$addwhere .= " AND hiking_menu.date='".$mysqli->real_escape_string($_GET['date'])."' ";}

$q = $mysqli->query("SELECT
recipes_products.name,
SUM(recipes_structure.amount * (hiking_menu.сorrection_coeff_pct / 100)) AS amount,	
recipes_products.id AS id_product,
0 AS is_optimize,
hiking_menu_products_force.id AS id_force,
forceUser.id AS forceUserId,
CONCAT(forceUser.name,' ',forceUser.surname) AS forceUserName,
forceUser.photo_50 AS forceUserPhoto,

GROUP_CONCAT(
	CONCAT_WS(
		'|',
		recipes.name,
		hiking_menu.date,
		recipes_structure.amount * (hiking_menu.сorrection_coeff_pct / 100)
	)
) AS use9,

(
	SELECT
		GROUP_CONCAT(
			CONCAT_WS('|', weight, value, cost)
		) as g
	FROM
		recipes_products_units_values
	WHERE
		id_product = recipes_products.id
		GROUP BY id_product
) AS cost,
(
	SELECT
		GROUP_CONCAT(
			CONCAT_WS('|', weight, weight / 1000, cost)
		) as g
	FROM
		hiking_finance
	WHERE
		id_product = recipes_products.id
	GROUP BY id_product
) AS cost1

FROM hiking_menu
	LEFT JOIN recipes ON recipes.id = hiking_menu.id_recipe 
	LEFT JOIN recipes_structure ON recipes_structure.id_recipe = recipes.id
	LEFT JOIN recipes_products ON  recipes_structure.id_product = recipes_products.id
	LEFT JOIN hiking_menu_products_force ON (
		hiking_menu_products_force.id_product = recipes_products.id
		AND hiking_menu_products_force.id_hiking={$id_hiking})
	LEFT JOIN users AS forceUser ON  hiking_menu_products_force.id_user = forceUser.id

WHERE hiking_menu.id_hiking={$id_hiking} ".$addwhere." GROUP BY id_product");//
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
while($r = $q->fetch_assoc()){
	$res[] = $r;
}

if(!isset($_GET['view'])){
	exit(json_encode($res));
} else {
	echo '<html><head><meta charset="utf-8"></head><body><table border="1" cellspacing=0 cellpadding=3>';
	echo '<tr>';
		foreach($res[0] as $k=>$v){
			echo '<td>'.$k.'</td>';
		}
	echo '</tr>';
	
	
	foreach($res as $r){
		foreach($r as $k=>$v){
			echo '<tr>';
				foreach($r as $k=>$v){
					echo '<td>'.$v.'</td>';
				}
			echo '</tr>'; 
		}
	}
	echo '</table>';
}
