<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_user = $_COOKIE["user"];
$id = isset($_POST['id'])?intval($_POST['id']):0;
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;

if(!($id>0)){die(err("id is undefined"));}
if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking} AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_medic=1  AND id_user = {$id_user} LIMIT 1");
	if($q && $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа")));
	}
}

$patch = array();
if (isset($_POST['comment'])) {
    $patch[] = "`comment`='".$mysqli->real_escape_string($_POST['comment'])."'";
}

if (isset($_POST['amount'])) {
    $patch[] = "`amount`=".intval($_POST['amount'])."";
}

if (isset($_POST['deadline'])) {
    if (empty($_POST['deadline'])) {
        $patch[] = "`deadline` = NULL";
    } else {
        $patch[] = "`deadline`='".$mysqli->real_escape_string($_POST['deadline'])."'";
    }

}

if(!(count($patch)>0)){die(err("no changes"));}


$z = "UPDATE `hiking_first_aid_kit` SET ".implode(",", $patch)." WHERE `id`={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z, "patch" => $patch)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows
)));
