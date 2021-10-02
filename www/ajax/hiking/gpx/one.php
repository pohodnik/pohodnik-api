<?php
	include("../../../blocks/db.php"); //подключение к БД
	include("../../../blocks/for_auth.php"); //Только для авторизованных
	$id_user = $_COOKIE["user"];
	$id = intval($_GET['id']);
	global $mysqli;
	$q = $mysqli->query("	SELECT hiking_tracks.*, 
							UNIX_TIMESTAMP(hiking_tracks.date_create) AS date_create,
							UNIX_TIMESTAMP(hiking_tracks.date_start) AS date_start,
							UNIX_TIMESTAMP(hiking_tracks.date_finish) AS date_finish,
							CONCAT(users.name,' ',users.surname) AS username
							FROM hiking_tracks LEFT JOIN users ON hiking_tracks.id_user=users.id
							WHERE hiking_tracks.id={$id}
							");
	if(!$q){ die(json_encode(array('error'=>$mysqli->error))); }
	$res = $q->fetch_assoc();
	die(json_encode($res));
