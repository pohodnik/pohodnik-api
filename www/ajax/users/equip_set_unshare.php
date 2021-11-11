<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

if (!isset($_POST['id'])) { die(json_encode(array("error"=>"id is required"))); }
$id = intval($_POST['id']);
$id_current_user = $_COOKIE["user"];

$z = "SELECT id_set FROM `user_equip_sets_share` WHERE id=$id LIMIT 1";
$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
if($q->num_rows != 1){die(json_encode(array("error"=>"access denide")));}
$r = $q -> fetch_assoc();
$id_set = $r['id_set'];

$z = "SELECT id FROM `user_equip_sets` WHERE id=$id_set AND id_user=$id_current_user LIMIT 1";
$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
if($q->num_rows != 1){die(json_encode(array("error"=>"access denide")));}



$z = "DELETE FROM `user_equip_sets_share` WHERE id=$id";

$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
die(json_encode(array("success"=>true)));