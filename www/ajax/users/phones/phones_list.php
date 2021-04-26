<?php
	include('../../../blocks/db.php');
	include("../../../blocks/for_auth.php");

    $id_user = $_COOKIE["user"];

    $key="secret";

    $q = $mysqli->query("SELECT reg_date from users WHERE id={$id_user} LIMIT 1");
    if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
    $r = $q -> fetch_assoc();
    $reg_date = $r['reg_date'];
    $key = md5($id_user."#".$reg_date);

	$q = $mysqli->query("SELECT
    `id`, `id_user`, `phone`, `is_contact`, `is_send_sms`, AES_DECRYPT(`sms_api_key`, '{$key}') AS `sms_api_key`
    FROM `user_phones` WHERE id_user={$id_user}");
	if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
    
    $res = array();
    while($r = $q ->fetch_assoc()) {
        $res[] = $r;
    }
	die(json_encode($res));	