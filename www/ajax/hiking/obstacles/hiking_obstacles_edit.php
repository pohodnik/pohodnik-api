<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

include("../../../blocks/rules.php");

$current_user = intval($_COOKIE["user"]);

$id = isset($_POST['id'])?intval($_POST['id']):0;
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;

$updates = array();

if (isset($_POST['description'])) {
    $description = $mysqli->real_escape_string($_POST['description']);
    $updates[] = "`description` = '{$description}'";
}

if (isset($_POST['description_in'])) {
    $description_in = $mysqli->real_escape_string($_POST['description_in']);
    $updates[] = "`description_in` = '{$description_in}'";
}

if (isset($_POST['description_out'])) {
    $description_out = $mysqli->real_escape_string($_POST['description_out']);
    $updates[] = "`description_out` = '{$description_out}'";
}

if (isset($_POST['date_in'])) {
    $date_in = $mysqli->real_escape_string($_POST['date_in']);
    $updates[] = "`date_in` = '{$date_in}'";
}

if (isset($_POST['date_out'])) {
    $date_out = $mysqli->real_escape_string($_POST['date_out']);
    $updates[] = "`date_out` = '{$date_out}'";
}

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'routes'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }

$sz = implode(',\n', $updates);
$z = "
UPDATE
    `hiking_obstacles`
SET
    {$sz},
    `updated_at` = NOW(),
    `updated_id` = {$current_user}
WHERE
    `id`={$id}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}


die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
)));
