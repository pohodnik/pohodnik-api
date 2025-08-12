<?php
include("../../../blocks/db.php"); //подключение к БД
include("../../../blocks/for_auth.php"); //Только для авторизованных
include("../../../blocks/rules.php"); // Права доступа

global $mysqli;

$current_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
$hasRules = hasHikingRules($id_hiking, array('kitchen'));

if (!$hasRules) { die(json_encode(array("error"=>"Нет доступа"))); }

$id = intval($_POST['id']);

if(isset($_POST['id'])){
	if(is_array($_POST['id'])){
		$wh = " id IN(".implode($_POST['id']).")";
	} else {
		$wh = " id = ".intval($_POST['id'])."";
	}
} else {
	
    $wh = " 1 ";
    if(isset($_POST['id_hiking'])){$wh .= " AND hiking_menu.id_hiking=".intval($_POST['id_hiking'])." ";}
    if(isset($_POST['id_act'])){$wh .= " AND hiking_menu.id_act=".intval($_POST['id_act'])." ";}
    if(isset($_POST['date'])){$wh .= " AND hiking_menu.date='".$mysqli->real_escape_string($_POST['date'])."' ";}

}
$updatesArr = array();

if(isset($_POST['is_optimize'])){
	$updatesArr[] = "is_optimize=".intval($_POST['is_optimize']);
}

if(isset($_POST['сorrection_coeff_pct'])){
	$updatesArr[] = "сorrection_coeff_pct=".intval($_POST['сorrection_coeff_pct']);
}

if(isset($_POST['assignee'])){
	$updatesArr[] = "assignee_user=".(intval($_POST['assignee']) > 0 ? intval($_POST['assignee']) : 'NULL');
}

if(isset($_POST['confirm'])){
    $hasBossRules = hasHikingRules($id_hiking, array('boss'));
    if (!$hasBossRules) { die(json_encode(array("error"=>"Доступно только руководителю"))); }
    if ($_POST['confirm'] != 'false') {
        $updatesArr[] = "confirm_user={$current_user}";
        $updatesArr[] = "confirm_date=NOW()";
    } else {
        $updatesArr[] = "confirm_user=NULL";
        $updatesArr[] = "confirm_date=NULL";
    }
}

$z = "UPDATE hiking_menu SET ".implode(', ', $updatesArr)." WHERE {$wh}";
$q = $mysqli->query($z);
if(!$q){die(json_encode(array(
    "error"=>$mysqli->error,
    "ups" => $updatesArr,
    "z" => $z
)));}


die(json_encode(array("success"=>true, "updates" => $updatesArr,
"affected"=>$mysqli->affected_rows, "z" => $z)));
