<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

if (!isset($_POST['id_set'])) { die(json_encode(array("error"=>"id_set is required"))); }
$id_set = intval($_POST['id_set']);
$id_user = isset($_POST['id_user']) && !empty($_POST['id_user']) ? intval($_POST['id_user']) : 'NULL';

$id_current_user = $_COOKIE["user"];

$z = "SELECT id FROM `user_equip_sets` WHERE id=$id_set AND id_user=$id_current_user LIMIT 1";
$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
if($q->num_rows != 1){die(json_encode(array("error"=>"access denide")));}



$z = "INSERT INTO `user_equip_sets_share`(`id_set`, `to_user`) VALUES ($id_set,$id_user)";

$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
if(!$id>0){$id=$mysqli->insert_id;}
die(json_encode(array("success"=>true, "id"=>$id)));