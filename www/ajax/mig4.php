<?php
	ini_set('memory_limit', '256M');
	include("../blocks/for_auth.php");
	include("../blocks/db.php");
	include("../blocks/err.php");
    include("../blocks/imagesStorage.php");

	$q = $mysqli->query("SELECT `id`, `photo` FROM `user_equip` WHERE photo not like('%cloudinary%')");

	$res = array();


	$upArr = array();

	while($r = $q->fetch_assoc()) {
		$url = $r['photo'];

		if (empty($url) || getimagesize($url) === false) {
			continue;
		}

		$res = uploadCloudImage($url, 'images/equip/', array());
		$UQ = "UPDATE user_equip SET `photo`='".$res['url']."' WHERE id=".$r['id'];
		$mysqli->query($UQ);
		$res[] = $r;

	}

	echo '<pre>';
	print_r($res);
