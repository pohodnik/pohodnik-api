<?php
include_once("../../blocks/db.php"); //подключение к БД
$result = array();
$q = $mysqli->query("SELECT `id`,  `name` FROM `hiking_types`");
	if($q && $q->num_rows>0){
		while($r = $q->fetch_assoc()){
			$result[] = $r;
		}
		echo json_encode($result);
	}else{
		exit(json_encode(array("error"=>"Ошибка при получении данных пользователя. \r\n" . $mysqli->error )));
	}

?>