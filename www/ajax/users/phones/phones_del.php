<?php
	include('../../../blocks/db.php');
	include("../../../blocks/for_auth.php");
    $id_user = $_COOKIE["user"];

	$id = intval($_POST['id']);
	$q = $mysqli->query("DELETE FROM user_phones WHERE id_user={$id_user} AND id={$id}");
	if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
	die(json_encode(array("success"=>true)));	