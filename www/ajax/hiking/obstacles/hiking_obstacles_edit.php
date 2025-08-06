<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

include("../../../blocks/rules.php");

$current_user = $_COOKIE["user"];

$id = isset($_POST['id'])?intval($_POST['id']):0;
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id_obstacle = isset($_POST['id_obstacle'])?intval($_POST['id_obstacle']):0;

$description = $mysqli->real_escape_string($_POST['description']);
$description_in = $mysqli->real_escape_string($_POST['description_in']);
$description_out = $mysqli->real_escape_string($_POST['description_out']);

$date_in = $mysqli->real_escape_string($_POST['date_in']);
$date_out = $mysqli->real_escape_string($_POST['date_out']);

if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}
if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!($id_obstacle>0)){die(json_encode(array("error"=>"id_obstacle is undefined")));}

if(!(strlen($description)>0)){die(json_encode(array("error"=>"description is empty")));}
if(!(strlen($description_in)>0)){die(json_encode(array("error"=>"description_in is empty")));}
if(!(strlen($description_out)>0)){die(json_encode(array("error"=>"description_out is empty")));}

if(!(strlen($date_in)>0)){die(json_encode(array("error"=>"date_in is empty")));}
if(!(strlen($date_out)>0)){die(json_encode(array("error"=>"date_out is empty")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'routes'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }


$z = "
UPDATE
    `hiking_obstacles`
SET
    `id_hiking` = {$id_hiking},
    `id_obstacle` = {$id_obstacle},
    `description` = '{$description}',
    `description_in` = '{$description_in}',
    `description_out` = '{$description_out}',
    `date_in` = '{$date_in}',
    `date_out` = '{$date_out}',
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
