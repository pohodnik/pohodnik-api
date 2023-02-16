<?php
	include("../../blocks/db.php"); //подключение к БД
	$client = $mysqli->real_escape_string($_POST['client']);
	$secret = $mysqli->real_escape_string($_POST['secret']);
	$token = $mysqli->real_escape_string($_POST['token']);
	$referer = $_SERVER['HTTP_REFERER'];


	$q = $mysqli->query("SELECT `domain`, `last_call` FROM `external_apps` WHERE `id`={$client} AND `secret`='{$secret}' LIMIT 1");
	if (!$q){ die(json_encode(array("error"=>"Wrong client data. ".$mysqli->error))); }
	if ($q->num_rows===0){ die(json_encode(array("error"=>"Is Not a valid client."))); }
	$res = $q->fetch_assoc();
	$domain = $res["domain"];

	if (str_contains($referer, $domain)) {
	    die(json_encode(array("error"=>"Wrong referer ".$referer)));
	}

	$q = $mysqli->query("
	SELECT users.id, users.name, users.surname, users.email, users.photo_50
	FROM user_hash
	LEFT JOIN users ON user_hash.id_user = users.id WHERE  user_hash.hash='{$token}' LIMIT 1"); //id_external_app={$client} AND
	if (!$q){ die(json_encode(array("error"=>"Wrong client data. ".$mysqli->error))); }
	$res = $q->fetch_assoc();
	die(json_encode($res));


