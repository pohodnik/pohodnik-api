<?php
include("../../blocks/db.php"); //подключение к БД

$id_route_object = intval($_GET['id_route_object']);

$res = array();
$q1=$mysqli->query("SELECT * FROM route_objects WHERE id=$id_route_object");
if(!$q1){die($mysqli->error);}
$r1=$q1->fetch_assoc();

die(json_encode($r1));