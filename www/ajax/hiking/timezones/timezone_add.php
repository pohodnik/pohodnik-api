<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/rules.php");
$result = array();
$current_user = $_COOKIE["user"];

$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$timezone = $mysqli->real_escape_string($_POST['timezone']);
$date_in = $mysqli->real_escape_string($_POST['date_in']);
$date_out = $mysqli->real_escape_string($_POST['date_out']);
$comment = isset($_POST['comment']) && !empty($_POST['comment']) ? $mysqli->real_escape_string($_POST['comment']) : '';

if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!(strlen($timezone)>0)){die(json_encode(array("error"=>"Timezone is empty")));}
if(!(strlen($date_in)>0)){die(json_encode(array("error"=>"date_in is empty")));}
if(!(strlen($date_out)>0)){die(json_encode(array("error"=>"date_out is empty")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'time'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }


$z = "INSERT INTO `hiking_timezones`
    (`id_hiking`, `timezone`, `date_in`, `date_out`, `comment`, `created_at`, `creator_id`)
    VALUES
    ({$id_hiking},'{$timezone}','{$date_in}','{$date_out}','{$comment}', NOW(),{$current_user})";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id
)));
