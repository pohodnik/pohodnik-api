<?php

	include("../../../blocks/db.php"); //подключение к БД
	include("../../../blocks/for_auth.php"); //Только для авторизованных
	include("../../../blocks/imagesStorage.php"); //Только для авторизованных
	include(__DIR__."/../../../vendor/autoload.php"); //Только для авторизованных
	$id_user = intval($_COOKIE["user"]);

    $id = intval($_POST['id']);
	$id_hiking = intval($_POST['id_hiking']);
	
	if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
	if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

	$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_user} LIMIT 1");
	if($q && $q->num_rows===0){
		$q = $mysqli->query("SELECT id FROM hiking_editors WHERE id_hiking={$id_hiking}  AND is_financier=1  AND id_user = {$id_user} LIMIT 1");
		if($q && $q->num_rows===0){
			die(json_encode(array("error"=>"Нет доступа")));
		}
	}

	$z = "SELECT img_orig, img_600, img_100 FROM hiking_finance_receipt WHERE id={$id} LIMIT 1";
	$q = $mysqli->query($z);
	if (!$q) die(json_encode(array("success" => false, "error" => $mysqli->error )));
	
	$r = $q -> fetch_assoc();
	$oldPhoto = $r['img_orig'];
	
	if (!empty($oldPhoto)) {
		if (isUrlCloudinary($oldPhoto)) {
			deleteCloudImageByUrl($oldPhoto);
            deleteCloudImageByUrl($r['img_600']);
            deleteCloudImageByUrl($r['img_100']);
		} else {
			unlink('../../../'.$r['img_600']);
			unlink('../../../'.$r['img_100']);
			unlink('../../../'.$r['img_orig']);
		}
	}
	
	$q=$mysqli->query("DELETE FROM `hiking_finance_receipt` WHERE id={$id}");
	if(!$q){exit(json_encode(array("success" => false, "error"=>"Ошибка\r\n".$mysqli->error)));}
	exit(json_encode(array( "success"=>true )));
?>
