<?php
	include('../../../blocks/db.php');
	include("../../../blocks/for_auth.php");

    $id_user = intval($_COOKIE["user"]);
    $id = intval($_POST['id']);

    $key="secret";


    $q = $mysqli->query("SELECT reg_date from users WHERE id={$id_user} LIMIT 1");
    if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
    $r = $q -> fetch_assoc();
    $reg_date = $r['reg_date'];
    $key = md5($id_user."#".$reg_date);
    
    
	$q = $mysqli->query("SELECT `phone`, AES_DECRYPT(`sms_api_key`, '{$key}') AS `sms_api_key`
    FROM `user_phones` WHERE id_user={$id_user} AND id={$id}");
	if(!$q){die(json_encode(array("error"=>$mysqli->error)));}

    $r = $q ->fetch_assoc();
    $sms_api_key = $r['sms_api_key'];
    $phone = $r['phone'];

    $msg = "Hello from pohodnik.tk :)";
    $body = file_get_contents("https://sms.ru/sms/send?api_id={$sms_api_key}&to={$phone}&msg=".urlencode(iconv("windows-1251","utf-8",$msg))."&json=1"); # Если приходят крякозябры, то уберите iconv и оставьте только urlencode("Привет!")

die($body);
