<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");
include("../../blocks/rules.php"); // Права доступа

global $mysqli;

$id_user = intval($_COOKIE["user"]);
$id_hiking = isset($_GET['id_hiking']) ? intval($_GET['id_hiking']) : null;
$id_position = isset($_GET['id_position']) ? intval($_GET['id_position']) : null;
$id_recipe = isset($_GET['id_recipe']) ? intval($_GET['id_recipe']) : null;
$id_route = isset($_GET['id_route']) ? intval($_GET['id_route']) : null;
$id_workout_group = isset($_GET['id_workout_group']) ? intval($_GET['id_workout_group']) : null;
$id_workout = isset($_GET['id_workout']) ? intval($_GET['id_workout']) : null;
$id_obstacle = isset($_GET['id_obstacle']) ? intval($_GET['id_obstacle']) : null;
$id_hiking_obstacle = isset($_GET['id_hiking_obstacle']) ? intval($_GET['id_hiking_obstacle']) : null;

if (!empty($id_hiking)) {
    $hasRules = hasHikingRules($id_hiking, array('member'));
    if (!$hasRules) { die(err("У вас нет доступа")); }
}

$where = array("1");

if (!empty($id_hiking)) { $where[] = "comments_branch.id_hiking={$id_hiking}"; }
if (!empty($id_position)) { $where[] = "comments_branch.id_position={$id_position}"; }
if (!empty($id_recipe)) { $where[] = "comments_branch.id_recipe={$id_recipe}"; }
if (!empty($id_route)) { $where[] = "comments_branch.id_route={$id_route}"; }
if (!empty($id_workout_group)) { $where[] = "comments_branch.id_workout_group={$id_workout_group}"; }
if (!empty($id_workout)) { $where[] = "comments_branch.id_workout={$id_workout}"; }
if (!empty($id_obstacle)) { $where[] = "comments_branch.id_obstacle={$id_obstacle}"; }
if (!empty($id_hiking_obstacle)) { $where[] = "comments_branch.id_hiking_obstacle={$id_hiking_obstacle}"; }


$z = "
SELECT
    comments_branch.id,
    comments_branch.id_hiking,
    comments_branch.id_position,
    comments_branch.id_recipe,
    comments_branch.id_route,
    comments_branch.id_workout_group,
    comments_branch.id_workout,
    comments_branch.id_hiking_obstacle,
    comments_branch.id_obstacle,
    comments_branch.created_at,
    comments_branch.id_author,
    CONCAT(users.name, ' ', users.surname) as user_name,
    users.photo_50 as user_photo
FROM
    `comments_branch`
    LEFT JOIN users ON users.id = comments_branch.id_author
WHERE
    ".implode(' AND ', $where)."
LIMIT 1
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = $q -> fetch_assoc();
die(out($res));
