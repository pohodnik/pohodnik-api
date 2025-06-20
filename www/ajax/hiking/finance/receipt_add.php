<?php

include("../../../blocks/db.php"); //подключение к БД
include("../../../blocks/for_auth.php"); //Только для авторизованных
include("../../../blocks/err.php"); //Только для авторизованных
include("../../../blocks/imagesStorage.php"); //Только для авторизованных
include(__DIR__."/../../../vendor/autoload.php"); //Только для авторизованных


$id_user = isset($_POST['id_user']) ? intval($_POST['id_user']) : $_COOKIE["user"];
$id_author = $_COOKIE["user"];
$id_hiking = intval($_POST['id_hiking']);

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if($id_user != $id_author){
	$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_author} LIMIT 1");
	if($q && $q->num_rows===0){
		$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_financier=1  AND id_user = {$id_author} LIMIT 1");
		if($q && $q->num_rows===0){
			die(json_encode(array("error"=>"Нет доступа")));
		}
	}
}

$id_category = isset($_POST['id_category']) && intval($_POST['id_category']) > 0 ? intval($_POST['id_category']) : 'NULL';

$name = isset($_POST['name']) && strlen($_POST['name'])>0
    ? $mysqli->real_escape_string(trim($_POST['name']))
    : "Чек от ".date('d.m.Y');

$summ = floatval($_POST['summ']);
$img_orig = $mysqli->real_escape_string($_POST['img_orig']);
$img_600 = $mysqli->real_escape_string($_POST['img_600']);
$img_100 = $mysqli->real_escape_string($_POST['img_100']);

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $z = "SELECT img_orig, img_600, img_100 FROM hiking_finance_receipt WHERE id={$id} LIMIT 1";
	$q = $mysqli->query($z);
	if (!$q) die(json_encode(array("success" => false, "error" => $mysqli->error, "z" => $z, "target"=>"get old images for del")));
	
	$old_row = $q -> fetch_assoc();

    if ($old_row['img_orig'] != $img_orig && isUrlCloudinary($old_row['img_orig'])) deleteCloudImageByUrl($old_row['img_orig']);
    if ($old_row['img_600'] != $img_600 && isUrlCloudinary($old_row['img_600'])) deleteCloudImageByUrl($old_row['img_600']);
    if ($old_row['img_100'] != $img_100 && isUrlCloudinary($old_row['img_100'])) deleteCloudImageByUrl($old_row['img_100']);	
}

$z = (isset($_POST['id']) ? "UPDATE `hiking_finance_receipt` SET" : "INSERT INTO `hiking_finance_receipt` SET `date`=NOW(),`id_author`={$id_author},
`id_hiking`={$id_hiking},")."
`id_category`={$id_category},
`name`='{$name}',
`id_user`={$id_user},
`img_600`='{$img_600}',
`img_100`='{$img_100}',
`img_orig`='{$img_orig}',
`summ`={$summ}
".(isset($_POST['id'])?" WHERE id=".intval($_POST['id']):'');

$q=$mysqli->query($z);
if(!$q) exit(json_encode(array("success" => false,"z"=>$z, "error"=>"Ошибка\r\n".$mysqli->error)));
exit(json_encode(array(
    "id" => isset($_POST['id'])?intval($_POST['id']):$mysqli->insert_id,
    "id_author" => $id_author,
    "id_user" => $id_user,
    "success"=>true,
    "img_100"=>$img_100,
    "img_600"=>$img_600
)));

?>
