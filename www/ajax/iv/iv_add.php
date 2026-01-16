<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/err.php"); //Только для авторизованных
$result = array();
$id_user = intval($_COOKIE["user"]);

$id = isset($_POST['id'])?intval($_POST['id']):0;

$name = $mysqli->real_escape_string(trim($_POST['name']));
$desc = $mysqli->real_escape_string(trim($_POST['desc']));
$hello_text = $mysqli->real_escape_string(trim($_POST['hello_text']));
$by_text = $mysqli->real_escape_string(trim($_POST['by_text']));
$member_limit = intval($_POST['member_limit']);
$d1 = $mysqli->real_escape_string(trim($_POST['d1']));
$d2 = $mysqli->real_escape_string(trim($_POST['d2']));
$id_hiking = isset($_POST['id_hiking']) && intval($_POST['id_hiking'])>0 ?intval($_POST['id_hiking']):'NULL';
$main = isset($_POST['main'])?intval($_POST['main']):0;

if($id>0){
	if($mysqli->query("UPDATE `iv` SET 
						`name`='{$name}',
						`desc`='{$desc}',
						`id_author`={$id_user},
						`date_start`='{$d1}',
						`date_finish`='{$d2}',
						`hello_text`='{$hello_text}',
						`by_text`='{$by_text}',
						`members_limit`={$member_limit},
						`id_hiking`	=	{$id_hiking},
						`main`		=	{$main}
					  WHERE id={$id}
					  ")){
		exit(json_encode(array("success"=>"Данные успешно сохранены", "id"=> $id)));
	}else{exit(json_encode(array("error"=>"Ошибка обновления опроса. \r\n".$mysqli->error)));}
} else {

	if($mysqli->query("INSERT INTO `iv` SET 
						`name`='{$name}',
						`desc`='{$desc}',
						`id_author`={$id_user},
							`date_start`='{$d1}',
						`date_finish`='{$d2}',
						`hello_text`='{$hello_text}',
						`by_text`='{$by_text}',
						`members_limit`={$member_limit},
						`id_hiking`	=	{$id_hiking},
						`main`		=	{$main}
					  ")){
		exit(json_encode(array("success"=>"Опрос создан", "id"=> $mysqli->insert_id)));
	}else{exit(json_encode(array("error"=>"Ошибка добавления опроса. \r\n".$mysqli->error)));}
}




?>
