<?php //recipes_product_add.php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

global $mysqli;

$result = array();
$id_user = intval($_COOKIE["user"]);

$id_hiking = intval($_POST['id_hiking']);
$d1 = $mysqli->real_escape_string($_POST['d1']);
$d2 = $mysqli->real_escape_string($_POST['d2']);

$bufferDate1 = '1990-10-11';
$bufferDate2 = '1991-05-17';

if(!($id_hiking>0)){die(json_encode(array("error"=>"Undefined ID hiking")));}


$z1 = "UPDATE `hiking_schedule` SET d1=CONCAT(DATE('{$bufferDate1}'), ' ', TIME(d1)), d2=CONCAT(DATE('{$bufferDate1}'), ' ', TIME(d2)) WHERE id_hiking={$id_hiking} AND DATE(d1)=DATE('{$d1}') AND DATE(d2)=DATE('{$d1}')";
$q = $mysqli->query($z1);
if (!$q) { die(json_encode(array("success"=>false, "error" => $mysqli->error, "query"=>$z1))); }


$z2 = "UPDATE `hiking_schedule` SET d1=CONCAT(DATE('{$bufferDate2}'), ' ', TIME(d1)), d2=CONCAT(DATE('{$bufferDate2}'), ' ', TIME(d2)) WHERE id_hiking={$id_hiking} AND DATE(d1)=DATE('{$d2}') AND DATE(d2)=DATE('{$d2}')";
$q = $mysqli->query($z2);
if (!$q) { die(json_encode(array("success"=>false, "error" => $mysqli->error, "query"=>$z2))); }


$z3 = "UPDATE `hiking_schedule` SET d1=CONCAT(DATE('{$d2}'), ' ', TIME(d1)), d2=CONCAT(DATE('{$d2}'), ' ', TIME(d2)) WHERE id_hiking={$id_hiking} AND  DATE(d1)=DATE('{$bufferDate1}') AND DATE(d2)=DATE('{$bufferDate1}')";
$q = $mysqli->query($z3);
if (!$q) { die(json_encode(array("success"=>false, "error" => $mysqli->error, "query"=>$z3))); }


$z4 = "UPDATE `hiking_schedule` SET d1=CONCAT(DATE('{$d1}'), ' ', TIME(d1)), d2=CONCAT(DATE('{$d1}'), ' ', TIME(d2)) WHERE id_hiking={$id_hiking} AND  DATE(d1)=DATE('{$bufferDate2}') AND DATE(d2)=DATE('{$bufferDate2}')";
$q = $mysqli->query($z4);
if (!$q) { die(json_encode(array("success"=>false, "error" => $mysqli->error, "query"=>$z4))); }

die(json_encode(array("success"=>true, "queries" => array($z1, $z2, $z3, $z4))));

