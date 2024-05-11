<?php
	include("../../blocks/db.php"); //подключение к БД
	include("../../blocks/for_auth.php"); //Только для авторизованных

	$id = intval($_POST['id']);
$coordinates = isset($_POST['coordinates']) ? $mysqli->real_escape_string(trim($_POST['coordinates'])) : '';
	$trackData = isset($_POST['trackData']) ? $mysqli->real_escape_string(trim($_POST['trackData'])) : '';
	$name = $mysqli->real_escape_string(trim($_POST['name']));
	$desc = $mysqli->real_escape_string(trim($_POST['desc']));
	$icon_url = $mysqli->real_escape_string(trim($_POST['icon_url']));
	$stroke_color = $mysqli->real_escape_string(trim($_POST['stroke_color']));
	$stroke_opacity = intval($_POST['stroke_opacity']);
	$stroke_width = intval($_POST['stroke_width']);
	$distance = floatval($_POST['distance']);
	$is_in_distance = intval($_POST['is_in_distance']);
	$id_mountain_pass = isset($_POST['id_mountain_pass']) && intval($_POST['id_mountain_pass']) > 0 ? intval($_POST['id_mountain_pass']) : 'NULL';


	$id_user = isset($_COOKIE["user"]) ? $_COOKIE["user"] : 0;

	if (!($id > 0)) {
		exit(json_encode(array("error"=>"id is required")));
	}

	if (!($id_user > 0)) {
		exit(json_encode(array("error"=>"user is required")));
	}

	$z = "
		UPDATE
			`route_objects`
		SET
			`name` = '{$name}',
			`desc` = '{$desc}',
			`coordinates` = '{$coordinates}',
			`trackData` = '{$trackData}',
			`icon_url` = '{$icon_url}',
			`stroke_color` = '{$stroke_color}',
			`stroke_opacity` = {$stroke_opacity},
			`stroke_width` = {$stroke_width},
			`distance` = {$distance},
			`is_in_distance` = {$is_in_distance},
			`id_editor` = {$id_user},
			`date_last_modif` = NOW(),
			`id_mountain_pass` = {$id_mountain_pass}
		WHERE
			`id` = {$id}
	";
							
	$q = $mysqli->query($z);
	if (!$q) {
		exit(
			json_encode(
				array(
					"suceess" => false,
					"error"=>$mysqli->error,
					"q" => $z
				)
			)
		);
	}

	exit(
		json_encode(
			array(
				"suceess" => true
			)
		)
	);
