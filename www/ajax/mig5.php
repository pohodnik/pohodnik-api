<?php
	ini_set('memory_limit', '256M');
	include("../blocks/for_auth.php");
	include("../blocks/db.php");
	include("../blocks/err.php");
    include("../blocks/imagesStorage.php");

	$q = $mysqli->query("SELECT `id`, `ava`, `bg` FROM `hiking` WHERE 1");

	$res = array();


	$upArr = array();

	while($r = $q->fetch_assoc()) {
		$avaurl = $r['ava'];
		$bgurl = $r['bg'];

		$res0 = array("url" => "");
		$res1 = array("url" => "");
		
		if (empty($avaurl) && empty($bgurl)) {
			continue;
		}

		if (!empty($avaurl) && getimagesize('http://pohodnik.tk/'.$avaurl) !== false) {
			$res0 = uploadCloudImage('http://pohodnik.tk/'.$avaurl, 'images/hiking/'.$r['id'].'/ava/', array());
		}

		if (!empty($bgurl) && getimagesize('http://pohodnik.tk/'.$bgurl) !== false) {
			$res1 = uploadCloudImage('http://pohodnik.tk/'.$bgurl, 'images/hiking/'.$r['id'].'/bg/', array());
		}

		$UQ = "UPDATE hiking SET `ava`='".$res0['url']."', `bg`='".$res1['url']."' WHERE id=".$r['id'];
		$mysqli->query($UQ);
		$res[] = $r;

	}

	echo '<pre>';
	print_r($res);
