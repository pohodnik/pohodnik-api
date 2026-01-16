<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$result = array();
$id_user = intval($_COOKIE["user"]);

$id = isset($_POST['id'])?intval($_POST['id']):0;

if($id>0){
	if($mysqli->query("DELETE FROM `iv` WHERE id={$id} AND `id_author`={$id_user}")){
		exit(json_encode(array("success"=>$mysqli->affected_rows > 0)));
	}else{exit(json_encode(array("error"=>$mysqli->error)));}
}
?>
