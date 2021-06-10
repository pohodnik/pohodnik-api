<?php
	ini_set('memory_limit', '256M');
	include("../blocks/for_auth.php"); //Только для авторизованных
	include("../blocks/err.php"); //Только для авторизованных

	$imageData = $_POST['data'];
	$name = isset($_POST['name'])?$_POST['name']:'file_'.md5(time());
	$folder = trim(isset($_POST['folder'])?$_POST['folder']:'images/custom/', "/");
	
	list($type, $imageData) = explode(';', $imageData);
	list(,$extension) = explode('/',$type);
	list(,$imageData)      = explode(',', $imageData);
	$fileName = $name.'.'.$extension;
	$imageData = base64_decode($imageData);
	if(file_exists ('../'.$folder."/".$fileName )){ $fileName = '_'.$name.'.'.$extension; }

	if(!file_exists ('../'.$folder."/" )){
		if(!mkdir('../'.$folder."/", 0777, true)) {
			die(json_encode(array("error"=>"Не удалось создать папку ".'../'.$folder."/")));	
		}
	}

	file_put_contents('../'.$folder."/".$fileName, $imageData);
	if(file_exists ('../'.$folder."/".$fileName )){ 
	$resSizes= array();

		if(isset($_POST['sizes'])){
			if(is_array($_POST['sizes'])){
				$sizes = $_POST['sizes'];
			} else {
				$sizes = explode(",", $_POST['sizes']);
			}
			if(count($sizes) > 0){
				list($originalWidth, $originalHeight) = getimagesize('../'.$folder."/".$fileName);
				$coeff = $originalWidth / $originalHeight;
				$width = $originalWidth;
				$height = $originalHeight;

				require_once('lib/php-image-magician/php_image_magician.php');
				$lastSuccessSize = $originalWidth;

				foreach ($sizes as $size) {
					
					if(strpos($size, "/") > 0){
						$tmp = explode("/", $size);
						$width = intval($tmp[0]);
						$height = intval($tmp[1]);
					} else {
						$width = intval($size);
						$height = intval($size) / $coeff;
					}

					if ($width <= $originalWidth && $height <= $originalHeight) {		
						$magicianObj = new imageLib('../'.$folder."/".$fileName);
						$magicianObj -> resizeImage($width, $height, 'crop');
						$resFile = $folder."/".$name.'_'.$width."_".$height.'.'.$extension;
						$magicianObj -> saveImage('../'.$resFile);
						$resSizes[$size] = $resFile;
						$lastSuccessSize = $size;
					} else {
						$resSizes[$size] = $resSizes[$lastSuccessSize];	
					}

				}
			}
		}

		die(json_encode(array(
			'success'=>true,
			'filename'=>$fileName,
			'name'=>$fileName,
			'extention'=>$extension,
			'type'=>$type,
			'folder'=>$folder,
			'sizes'=>$resSizes
		)));
	} else {
		die(json_encode(array("error"=>"Не удалось сохранить файл")));	
	}