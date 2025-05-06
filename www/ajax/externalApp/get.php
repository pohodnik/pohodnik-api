<?php
	include("../../blocks/db.php"); //подключение к БД
	$id = $mysqli->real_escape_string($_GET['id']);


	$q = $mysqli->query("SELECT `id`, `name`, `description`, `domain`, `img_url`, `callback` FROM `external_apps` WHERE `id`={$id} LIMIT 1");
	if (!$q){ die(json_encode(array("error"=>"Wrong client data. ".$mysqli->error))); }
	if ($q->num_rows===0){ die(json_encode(array("error"=>"Is Not a valid client."))); }
	$res = $q->fetch_assoc();
	die(json_encode($res));





