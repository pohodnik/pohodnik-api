<?php
	ini_set('memory_limit', '256M');
	include("../blocks/for_auth.php");
	include("../blocks/db.php");
	include("../blocks/err.php");
    include("../blocks/imagesStorage.php");

	$q = $mysqli->query("SELECT `id`, `photo` FROM `user_equip` WHERE 1");

	$res = array();


	$upArr = array();

	while($r = $q->fetch_assoc()) {
		$url = $r['photo'];

		if (empty($url) || getimagesize('http://pohodnik.tk/'.$url) === false) {
			continue;
		}

		$res = uploadCloudImage('http://pohodnik.tk/'.$url, 'images/equip/', array());
		$UQ = "UPDATE user_equip SET `photo`='".$res['url']."' WHERE id=".$r['id'];
		$mysqli->query($UQ);
		$res[] = $r;

	}

	echo '<pre>';
	print_r($res);
