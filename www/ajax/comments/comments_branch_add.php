<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");
include("../../blocks/rules.php"); // Права доступа

global $mysqli;

$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking']) ? intval($_POST['id_hiking']) : 'NULL';
$id_position = isset($_POST['id_position']) ? intval($_POST['id_position']) : 'NULL';
$id_recipe = isset($_POST['id_recipe']) ? intval($_POST['id_recipe']) : 'NULL';
$id_route = isset($_POST['id_route']) ? intval($_POST['id_route']) : 'NULL';

if ($id_hiking != 'NULL') {
    $hasRules = hasHikingRules($id_hiking, array('member'));
    if (!$hasRules) { die(err("У вас нет доступа")); }
}

$z = "
INSERT INTO
    `comments_branch`
SET
    `id_hiking` = {$id_hiking},
    `id_position` = {$id_position},
    `id_recipe` = {$id_recipe},
    `id_route` = {$id_route},
    `created_at` = NOW(),
    `id_author` = {$id_user}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array(
    "success" => true,
    "id" => $mysqli -> insert_id,
);

die(out($res));
