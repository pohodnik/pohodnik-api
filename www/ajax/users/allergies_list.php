<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$tWH = isset($_GET['type'])?" AND type=".intval($_GET['type']):"";
$id_user = $_COOKIE["user"];
$z = "SELECT 
user_allergies.`id`,
user_allergies.`id_user`,
user_allergies.`name`,
user_allergies.`comment`,
user_allergies.`id_product`,
user_allergies.`id_medicament`,
user_allergies.`type`,
user_allergies.`created_at`,
user_allergies.`updated_at`,
medicaments.name as medicament_name,
recipes_products.name as product_name
FROM `user_allergies`
    LEFT JOIN recipes_products ON recipes_products.id = user_allergies.`id_product`
    LEFT JOIN medicaments ON medicaments.id = user_allergies.`id_medicament`

WHERE user_allergies.id_user={$id_user} {$tWH}";

$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
$res = array();
while($r = $q->fetch_assoc()){
	$res[] = $r;
}

die(json_encode($res));