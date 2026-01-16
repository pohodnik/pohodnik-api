<?php
include("../blocks/db.php"); //подключение к БД
include("../blocks/global.php");

$name=		$mysqli->real_escape_string(trim($_POST["name"]));
$surname=	$mysqli->real_escape_string(trim($_POST["surname"]));
$login=		$mysqli->real_escape_string(trim(strtolower($_POST["login"])));
$email=		$mysqli->real_escape_string(trim(strtolower($_POST["email"])));
$pass=		$mysqli->real_escape_string(trim($_POST["pass"]));
$dob=		$mysqli->real_escape_string($_POST["dob"]);
$hash  =	uniqid("poh").rand(100,999).'r';
$id_app  =	isset($_POST['id_app'])?intval($_POST['id_app']):'NULL';

$q = $mysqli->query("SELECT id_user FROM user_login_variants WHERE login='{$login}' OR email='{$email}' LIMIT 1");
if($q && $q->num_rows===1){ die((err("Пользователь с таким логином уже существует.")));}

$z = "INSERT INTO users SET
`name`='{$name}',
`email`='{$email}',
`surname`='{$surname}',
`reg_date`=NOW(),
`dob`='{$dob}',
`ava`=''
";

$q = $mysqli->query($z);
if(!$q){ die((err($mysqli->error, array("z" =>$z))));}

$id_user = $mysqli->insert_id;
				
					
$q = $mysqli->query("INSERT INTO user_login_variants SET login='{$login}',email='{$email}', id_user={$id_user}, password='".md5(md5($pass))."'");
if(!$q){die((err("Ошибка добавления варианта залогинивания".$mysqli->error)));}
	
	
$q = $mysqli->query("INSERT INTO `user_hash`(`id_user`, `hash`, `date_start`, `id_external_app`) VALUES ({$id_user},'{$hash}',NOW(), {$id_app})");
if(!$q){die((err("Ошибка добавления токена ".$mysqli->error)));}	

setcookie("hash", $hash,time()+86400*7,"/");
setcookie("user", $id_user,time()+86400*7,"/");
die(json_encode(array("user"=>$id_user)));

?>