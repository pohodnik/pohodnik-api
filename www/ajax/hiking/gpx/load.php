<?php
	include("../../../blocks/db.php"); //подключение к БД
	include("../../../blocks/for_auth.php"); //Только для авторизованных
	$id_user = intval($_COOKIE["user"]);
	$id_hiking = intval($_GET['id_hiking']);

    $add_where = "";

    if (isset($_GET['d1']) && !empty($_GET['d1'])) {
        $add_where .= " AND workout_tracks.date_start >= '".$mysqli->real_escape_string($_GET['d1'])."'";
    }

    if (isset($_GET['d2']) && !empty($_GET['d2'])) {
        $add_where .= " AND workout_tracks.date_finish <= '".$mysqli->real_escape_string($_GET['d2'])."'";
    }

    if (isset($_GET['d']) && !empty($_GET['d'])) {
        $add_where .= " AND ('".$mysqli->real_escape_string($_GET['d'])."' BETWEEN workout_tracks.date_start AND workout_tracks.date_finish)";
    }

$z ="
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
	WHERE hiking_tracks.id_hiking={$id_hiking} {$add_where}
	ORDER BY workout_tracks.date_start ASC
";
	$q = $mysqli->query($z);
	if(!$q){ die(json_encode(array('error'=>$mysqli->error, "query"=>$z))); }
	$res = array();
	while($r = $q->fetch_assoc()){
		$res[] = $r;
	}
	die(json_encode($res));
