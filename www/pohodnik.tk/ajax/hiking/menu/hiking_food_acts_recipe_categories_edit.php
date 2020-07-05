<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_cook=1  AND id_user = {$id_user} LIMIT 1");
	if($q && $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа")));
	}
}

$id = isset($_POST['id'])?intval($_POST['id']):0;
if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$patch = array();
$avai = array("can_increase","can_dublicate","min_pct","max_pct","order_index");

foreach ($avai as $field) {
    if(isset($_POST[$field])) {
		$patch[] = "`{$field}`=".$mysqli->real_escape_string($_POST[$field]);
	}
}

$z = "UPDATE `hiking_food_acts_recipe_categories` SET ".implode(',', $patch)." WHERE `id`={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, $z)); }

die(out(array("success" => true, "affected" => $mysqli->affected_rows)));