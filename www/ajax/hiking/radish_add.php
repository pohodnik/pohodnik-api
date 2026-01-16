<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/global.php");
include("../../blocks/rules.php");


$res = array();
$id_hiking = intval($_POST['id_hiking']);
$id_user = intval($_POST['id_user']);

$current_user = intval($_COOKIE["user"]);

if (!($id_user > 0)) die(jout(err("id_user is required")));
if (!($id_hiking > 0)) die(jout(err("id_hiking is required")));

$hasRules = hasHikingRules($id_hiking, array('full', 'boss'));
if (!$hasRules) die(jout(err("Доступ только у создателя и руководителя")));

$q = $mysqli->query("DELETE FROM hiking_members WHERE id_user = {$id_user} AND id_hiking = {$id_hiking}");
if(!$q) die(jout(err($mysqli->error)));

$q = $mysqli->query("
    INSERT INTO
        hiking_radish
    SET
        id_user = {$id_user},
        id_hiking = {$id_hiking},
        comment='',
        date=NOW(),
        killer={$current_user}
");

if(!$q) die(jout(err($mysqli->error)));

die(jout(array("success"=>true, "id" => $mysqli->insert_id)));

?>