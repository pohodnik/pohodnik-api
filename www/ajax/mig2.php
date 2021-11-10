<?php
	ini_set('memory_limit', '256M');
	include("../blocks/for_auth.php");
	include("../blocks/db.php");
	include("../blocks/err.php");
    include("../blocks/imagesStorage.php");

	$q = $mysqli->query("
	SELECT
		`id`,
		`img_600`,
		`img_100`,
		`img_orig`
	FROM
		`hiking_finance_receipt`
	WHERE
		1
	");

	$res = array();

	$needSizes = array();
	

	$sizes = array("600", "100");
	
	$needSizesKeys = array();

	foreach ($sizes as $size) {
		$width = intval($size);
		$needSizesKeys[] = $size;
		$needSizes[$size] = ["width" => $width, "crop" => "pad"];
	}

	$upArr = array();

	while($r = $q->fetch_assoc()) {
		$url = 'http://pohodnik.tk/'.trim(empty($r['img_orig']) ? $r['img_600'] : $r['img_orig'],"./");
		if (getimagesize($url) === false) {
			continue;
		}

			$res = uploadCloudImage($url, 'images/receipts/'.$r['id'].'/', $needSizes);
			foreach($needSizesKeys as $i => $sz){
				$sizesRes[$sz] = $res['eager'][$i]['url'];
			}
			$UQ = "UPDATE hiking_finance_receipt SET
			`img_orig`='".$res['url']."',
			`img_600`='".$res['eager'][1]['url']."',
			`img_100`='".$res['eager'][0]['url']."'
			WHERE id=".$r['id'];


			$upArr[] = $UQ;
			$r['update'] = $UQ;

			$mysqli->query($UQ);

			$res[] = $r;

	}

	echo '<pre>';
	print_r($res);
