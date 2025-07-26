<?php
	include("../../blocks/db.php"); //подключение к БД
	include("../../blocks/for_auth.php"); //Только для авторизованных
	$result = array();
	$q = $mysqli->query("SELECT id, name, surname, photo_50 as photo FROM users");
	while($r = $q->fetch_assoc()){
		$result[] = $r;
	}
	
	echo json_encode($result);