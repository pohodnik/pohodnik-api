<?php
	ini_set('memory_limit', '256M');
	include("../blocks/for_auth.php");
	include("../blocks/db.php");
	include("../blocks/err.php");
    include("../blocks/imagesStorage.php");

	$q = $mysqli->query("
	SELECT
		`id`,
		`ava`,
		`photo_50`,
		`photo_100`,
		`photo_200_orig`,
		`photo_max`,
		`photo_max_orig`,
		`vk_id`
	FROM
		`users`
	WHERE
		photo_50 LIKE('ava%')
	");

	$res = array();

	$needSizes = array();
	

	$sizes = array("200", "100", "50");
	
	$needSizesKeys = array();

	foreach ($sizes as $size) {
		$width = intval($size);
		$needSizesKeys[] = $size;
		$needSizes[$size] = ["width" => $width, "crop" => "pad"];
	}

	$upArr = array();

	while($r = $q->fetch_assoc()) {
		
		$res = uploadCloudImage('http://pohodnik.tk/'.trim($r['photo_max'],"./"), 'avatars/'.$r['id'].'/', $needSizes);
		foreach($needSizesKeys as $i => $sz){
			$sizesRes[$sz] = $res['eager'][$i]['url'];
		}
		$UQ = "UPDATE users SET
		`ava`='".$res['url']."',
		`photo_50`='".$res['eager'][2]['url']."',
		`photo_100`='".$res['eager'][1]['url']."',
		`photo_200_orig`='".$res['eager'][0]['url']."',
		`photo_max`='".$res['url']."',
		`photo_max_orig`='".$res['url']."'
		WHERE id=".$r['id'];


		$upArr[] = $UQ;
		$r['update'] = $UQ;

		$mysqli->query($UQ);

		$res[] = $r;
	}

	echo '<pre>';
	print_r($res);
