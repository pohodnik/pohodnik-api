<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

include("../../../blocks/rules.php");
$result = array();
$current_user = intval($_COOKIE["user"]);

$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
$id = isset($_POST['id'])?intval($_POST['id']):0;

$timezone = $mysqli->real_escape_string($_POST['timezone']);
$date_in = $mysqli->real_escape_string($_POST['date_in']);
$date_out = $mysqli->real_escape_string($_POST['date_out']);
$comment = isset($_POST['comment']) && !empty($_POST['comment']) ? $mysqli->real_escape_string($_POST['comment']) : '';

if(!($id>0)){die(json_encode(array("error"=>"id is undefined")));}
if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
if(!(strlen($timezone)>0)){die(json_encode(array("error"=>"Timezone is empty")));}
if(!(strlen($date_in)>0)){die(json_encode(array("error"=>"date_in is empty")));}
if(!(strlen($date_out)>0)){die(json_encode(array("error"=>"date_out is empty")));}

$hasRules = hasHikingRules($id_hiking, array('boss', 'time'));
if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }

$z = "UPDATE `hiking_timezones` SET
`timezone`='{$timezone}',
`date_in`='{$date_in}',
`date_out`='{$date_out}',
`comment`='{$comment}',
`updated_at`=NOW(),
`updated_id`={$current_user}
WHERE  `id`={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
)));
