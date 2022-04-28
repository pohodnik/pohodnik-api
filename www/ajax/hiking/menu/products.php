<?php
include("../../../blocks/db.php"); //подключение к БД
include("../../../blocks/for_auth.php"); //Только для авторизованных
$res = array();
$id_hiking = intval($_GET['id_hiking']);

$addwhere = "";
$addwhere1 = "";

if(isset($_GET['id_act'])){
    $addwhere .= " AND hiking_menu.id_act=".intval($_GET['id_act'])." ";
    $addwhere1 .= " AND id_food_act =".intval($_GET['id_act'])." ";
}
if(isset($_GET['date'])){
    $addwhere .= " AND hiking_menu.date='".$mysqli->real_escape_string($_GET['date'])."' ";
    $addwhere1 .= " AND DATE(d1) ='".$mysqli->real_escape_string($_GET['date'])."' ";
}

$q = $mysqli -> query("SELECT d1, d2, name, DATE(d1) as date, id_food_act FROM `hiking_schedule` WHERE id_hiking={$id_hiking} AND id_food_act IS NOT NULL {$addwhere1}");
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
$sss = array();
while($r = $q->fetch_assoc()){


    if (!isset($sss[$r['date']])) {
        $sss[$r['date']] = array();
    }

    if (!isset($sss[$r['date']][$r['id_food_act']])) {
        $sss[$r['date']][$r['id_food_act']] = $r;
    }
}

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
		recipes_structure.amount * (hiking_menu.сorrection_coeff_pct / 100),
		hiking_menu.id_act
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
    $usages = explode(',',$r['use9']);
    $r['usages'] = array_map(function($str) use ($sss){
        $parts = explode('|',$str);
   		$scheduleItem = $sss[$parts[1]][$parts[3]];
        return array(
            'name' => $parts[0],
            'date' => $scheduleItem['d1'],
            'amount' => floatval($parts[2]),
            'schedule' => $scheduleItem,
            'parts' => $parts,
            'sss' => $sss
        );
    }, $usages);
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
