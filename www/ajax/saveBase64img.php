<?php
	ini_set('memory_limit', '256M');
	include("../blocks/for_auth.php"); //Только для авторизованных
	include("../blocks/err.php"); //Только для авторизованных
    include("../blocks/imagesStorage.php");

	$imageData = $_POST['data'];
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$folder = trim(isset($_POST['folder'])?$_POST['folder']:'images/custom/', "/");
	
	list($type, $imageData) = explode(';', $imageData);
	list(,$extension) = explode('/',$type);
	list(,$imageData) = explode(',', $imageData);
	$fileName = uniqid($name).'.'.$extension;
	$imageData = base64_decode($imageData);

	if (!file_exists ('../temp/' )){
		if(!mkdir('../temp/', 0777, true)) {
			die(json_encode(array("error"=>"Не удалось создать папку ../temp/")));	
		}
	}

	$newFilePath = '../temp/'.$fileName;

	file_put_contents($newFilePath, $imageData);
	
	if (!file_exists ($newFilePath)) {
		die(json_encode(array("error"=>"Не удалось сохранить файл")));	
	}

	$needSizes = array();
	$needSizesKeys = array();

	if (isset($_POST['sizes'])){
		if (is_array($_POST['sizes'])){
			$sizes = $_POST['sizes'];
		} else {
			$sizes = explode(",", $_POST['sizes']);
		}

		if (count($sizes) > 0){
			foreach ($sizes as $size) {
				if(strpos($size, "/") > 0){
					$tmp = explode("/", $size);
					$width = intval($tmp[0]);
					$height = intval($tmp[1]);
					$needSizesKeys[] = $size;
					$needSizes[$size] = ["width" => $width, "height" => $height, "crop" => "pad"];
				} else {
					$width = intval($size);
					$needSizesKeys[] = $size;
					$needSizes[$size] = ["width" => $width, "crop" => "pad"];
				}
			}
		}
	}

	        
    $res = uploadCloudImage($newFilePath, $folder, $needSizes);

    unlink($newFilePath);

	$sizesRes = array();

	foreach($needSizesKeys as $i => $sz){
		$sizesRes[$sz] = $res['eager'][$i]['url'];
	}

	die(json_encode(array(
		'success'=>true,
		'filename'=>$fileName,
		'name'=>$fileName,
		'extention'=>$extension,
		'type'=>$type,
		'folder'=>$folder,
		'url'=>$res['url'],
		"sizes" => $sizesRes
	)));
	