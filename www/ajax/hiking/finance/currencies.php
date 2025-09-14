<?php
	include("../../../blocks/db.php"); //подключение к БД

	$res = array();
	$z = "
SELECT
    `id`,
    `name`,
    `short_name`,
    `symbol`
FROM
    `hiking_finance_currencies`
WHERE
    1";
	
	$q = $mysqli->query($z);
	if(!$q ){exit(json_encode(array("error"=>"Ошибка\r\n".$mysqli->error."\r\n".$z)));}
	while($r = $q->fetch_assoc()){
		$res[] = $r;
	}
	
	echo json_encode($res);