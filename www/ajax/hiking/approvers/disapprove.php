<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php"); // Права доступа


global $mysqli;
$id_user = intval($_COOKIE["user"]);
$id = isset($_POST['id'])?intval($_POST['id']):0;

if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$q = $mysqli -> query("SELECT * FROM hiking_approvers WHERE id={$id} AND id_user={$id_user} LIMIT 1");
if ($q && $q->num_rows == 0) die(json_encode(array("error"=>"Нет записи")));

$z = "DELETE FROM `hiking_approvers` WHERE id={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}


die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows
)));
