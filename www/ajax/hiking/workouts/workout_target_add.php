<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;

$name = isset($_POST['name']) && !empty($_POST['name']) ? $mysqli->real_escape_string($_POST['name']) : '';
$description = isset($_POST['description']) && !empty($_POST['description']) ? $mysqli->real_escape_string($_POST['description']) : '';
$date_start = isset($_POST['date_start']) && !empty($_POST['date_start']) ? $mysqli->real_escape_string($_POST['date_start']) : '';
$date_finish = isset($_POST['date_finish']) && !empty($_POST['date_finish']) ? $mysqli->real_escape_string($_POST['date_finish']) : '';
$distance = isset($_POST['distance']) && !empty($_POST['distance']) ? intval($_POST['distance']) : 'NULL';
$alt_ascent = isset($_POST['alt_ascent']) && !empty($_POST['alt_ascent']) ? intval($_POST['alt_ascent']) : 'NULL';
$alt_descent = isset($_POST['alt_descent']) && !empty($_POST['alt_descent']) ? intval($_POST['alt_descent']) : 'NULL';
$speed_max = isset($_POST['speed_max']) && !empty($_POST['speed_max']) ? intval($_POST['speed_max']) : 'NULL';
$speed_min = isset($_POST['speed_min']) && !empty($_POST['speed_min']) ? intval($_POST['speed_min']) : 'NULL';
$speed_avg = isset($_POST['speed_avg']) && !empty($_POST['speed_avg']) ? intval($_POST['speed_avg']) : 'NULL';
$hr_max = isset($_POST['hr_max']) && !empty($_POST['hr_max']) ? intval($_POST['hr_max']) : 'NULL';
$hr_min = isset($_POST['hr_min']) && !empty($_POST['hr_min']) ? intval($_POST['hr_min']) : 'NULL';
$hr_avg = isset($_POST['hr_avg']) && !empty($_POST['hr_avg']) ? intval($_POST['hr_avg']) : 'NULL';
$time_mooving = isset($_POST['time_mooving']) && !empty($_POST['time_mooving']) ? intval($_POST['time_mooving']) : 'NULL';
$workout_type = isset($_POST['workout_type']) && !empty($_POST['workout_type']) ? intval($_POST['workout_type']) : 'NULL';

if(strlen($date_start)<10){die(err("date_start is incorrect"));}
if(strlen($date_finish)<10){die(err("date_finish is incorrect"));}

$q = $mysqli->query("SELECT id FROM hiking WHERE id={$id_hiking}  AND id_author = {$id_user} LIMIT 1");
if($q && $q->num_rows===0){ die(err("Нет доступа"));}

$z = "INSERT INTO
`hiking_workouts_target`
SET
`id_hiking` = {$id_hiking},
`id_author` = {$id_user},
`date_create` = NOW(),
`name` = '{$name}',
`description` = '{$description}',
`date_start` = '{$date_start}',
`date_finish` = '{$date_finish}',
`distance` = {$distance},
`alt_ascent` = {$alt_ascent},
`alt_descent` = {$alt_descent},
`speed_max` = {$speed_max},
`speed_min` = {$speed_min},
`speed_avg` = {$speed_avg},
`hr_max` = {$hr_max},
`hr_min` = {$hr_min},
`hr_avg` = {$hr_avg},
`time_mooving` = {$time_mooving},
`workout_type` = {$workout_type}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "id" => $mysqli->insert_id
)));
