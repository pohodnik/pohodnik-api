<?php
	include("../../../blocks/db.php"); //подключение к БД

	$res = array();
	$z = "SELECT hiking_finance_receipt_categories.* FROM hiking_finance_receipt_categories";
	
	$q = $mysqli->query($z);
    
	if(!$q ) exit(json_encode(array(
        "success" => false,
        "error"=>"Ошибка\r\n".$mysqli->error."\r\n".$z
    )));

	while($r = $q->fetch_assoc()){
		$res[] = $r;
	}
	
	echo json_encode($res);