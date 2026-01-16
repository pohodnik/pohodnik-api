<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/global.php");
include("../../blocks/rules.php");


$res = array();
$id_hiking = intval($_POST['id_hiking']);
$id = intval($_POST['id']);

$current_user = intval($_COOKIE["user"]);

if (!($id > 0)) die(jout(err("id is required")));
if (!($id_hiking > 0)) die(jout(err("id_hiking is required")));

$hasRules = hasHikingRules($id_hiking, array('full', 'boss'));
if (!$hasRules) die(jout(err("Доступ только у создателя и руководителя")));

$q = $mysqli->query("
    DELETE FROM
        hiking_radish
    WHERE
        id = {$id}
");

if(!$q) die(jout(err($mysqli->error)));

die(jout(array("success"=>true, "affected" => $mysqli->affected_rows)));

?>