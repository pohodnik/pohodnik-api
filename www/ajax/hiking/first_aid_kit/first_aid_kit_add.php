<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id_medicament = isset($_POST['id_medicament'])?intval($_POST['id_medicament']):0;
$amount = isset($_POST['amount'])?intval($_POST['amount']):0;
$comment = isset($_POST['comment'])?$mysqli->real_escape_string($_POST['comment']):"";
$deadline = isset($_POST['deadline']) && !empty($_POST['deadline'])?"'".$mysqli->real_escape_string($_POST['deadline'])."'":"NULL";

if(!($id_hiking>0)){die(err("id_hiking is undefined"));}
if(!($amount>0)){die(err("Укажите количество препата в аптечке"));}

$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking} AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0){
	$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_medic=1  AND id_user = {$id_user} LIMIT 1");
	if($q && $q->num_rows===0){
		die(json_encode(array("error"=>"Нет доступа")));
	}
}

$q = $mysqli->query("SELECT id FROM hiking_first_aid_kit WHERE id_hiking={$id_hiking}  AND id_medicament={$id_medicament} LIMIT 1");
if($q && $q->num_rows===1){
    die(json_encode(array("error"=>"Уже добавлено")));
}

$z = "INSERT INTO `hiking_first_aid_kit`
    (`id_hiking`, `id_medicament`, `amount`, `id_author`, comment, deadline) VALUES 
    ({$id_hiking},{$id_medicament},{$amount},{$id_user},'{$comment}',{$deadline})";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id,
    "z" => $z
)));
