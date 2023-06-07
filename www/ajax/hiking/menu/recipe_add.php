<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
$result = array();

$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id_recipe = isset($_POST['id_recipe'])?$_POST['id_recipe']:0;

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_cook=1  AND id_user = {$id_user} LIMIT 1");
	if($q && $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа")));
	}
}

if(is_array($id_recipe)){

	$q = $mysqli->query("SELECT id_recipe FROM hiking_recipes WHERE `id_hiking`={$id_hiking} AND `id_recipe` IN(".implode(",", $id_recipe).")");
	if($q && $q->num_rows>0){ 
		$exsts = array();
		while($r = $q->fetch_row()){$exsts[]=$r[0];}
		if(count($exsts)>0){
			$id_recipe = array_filter($id_recipe, function($k)  use ($exsts) {
				return in_array($k,$exsts);
			});
		}
	}	
	$values = array();
	foreach($id_recipe as $id){
		$values[]="({$id_hiking},{$id})";
	}
} else {
	$q = $mysqli->query("SELECT id FROM hiking_recipes WHERE `id_hiking`={$id_hiking} AND `id_recipe`={$id_recipe} LIMIT 1");
	if($q && $q->num_rows===1){ die(json_encode(array("error"=>"Уже добавлено"))); }	
	$values = array("({$id_hiking},{$id_recipe})");
}


$z = "INSERT INTO `hiking_recipes`( `id_hiking`, `id_recipe`) VALUES ".implode(',',$values)."";
if($mysqli->query($z)){

    $id = $mysqli->insert_id;
    $ids = [$id];
    if ($id && $mysqli->affected_rows > 1) {
        for ($i = 0; $i < $mysqli->affected_rows - 1; $i++) {
            $ids[] = $id + 1;
        }
    }


	die(json_encode(
        array('success'=>true, 'id'=>$id,'ids'=>$ids, "recipes_id"=>$id_recipe, "affected" => $mysqli->affected_rows)));
} else {
	die(json_encode(array('error'=>$mysqli->error, "z" => $z)));
}
