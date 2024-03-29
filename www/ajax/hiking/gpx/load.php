<?php
	include("../../../blocks/db.php"); //подключение к БД
	include("../../../blocks/for_auth.php"); //Только для авторизованных
	$id_user = $_COOKIE["user"];
	$id_hiking = intval($_GET['id_hiking']);
	$q = $mysqli->query("
	SELECT
	    workout_tracks.*,
		hiking_tracks.*, 
		UNIX_TIMESTAMP(workout_tracks.date_upload) AS date_create,
		UNIX_TIMESTAMP(workout_tracks.date_start) AS date_start,
		UNIX_TIMESTAMP(workout_tracks.date_finish) AS date_finish,
		CONCAT(users.name,' ',users.surname) AS username
	FROM
		hiking_tracks
		LEFT JOIN users ON hiking_tracks.id_user=users.id
		LEFT JOIN workout_tracks ON hiking_tracks.id_workout_track = workout_tracks.id
	WHERE hiking_tracks.id_hiking={$id_hiking} 
	ORDER BY workout_tracks.date_start ASC
");
	if(!$q){ die(json_encode(array('error'=>$mysqli->error))); }
	$res = array();
	while($r = $q->fetch_assoc()){
		$res[] = $r;
	}
	die(json_encode($res));