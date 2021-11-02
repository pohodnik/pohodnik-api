<?php
	ini_set('memory_limit', '256M');
	include("../blocks/for_auth.php"); //Только для авторизованных
	include("../blocks/err.php"); //Только для авторизованных
    include("../blocks/cloudinary.php");
    include("../vendor/autoload.php");

	$url = $_POST['url'];
	if (isUrlCloudinary($url)) {
		(new Cloudinary\Api\Upload\UploadApi)->destroy(getCloudinaryPublickIdByUrl($url));
	} else {
		die(json_encode(array(
			'error'=> "Is'nt Cloudinary url"
		)));
	}

	die(json_encode(array(
		'success'=>true
	)));
	