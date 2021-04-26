<?php
	include('../../../blocks/db.php');
	include("../../../blocks/for_auth.php");
	$id_subs = intval($_POST['id_subs']);
	$id_region = intval($_POST['id_region']);
	$q = $mysqli->query("DELETE FROM user_subscribes_regions WHERE id_subs={$id_subs} AND id_region={$id_region}");
	if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
	die(json_encode(array("success"=>true)));	