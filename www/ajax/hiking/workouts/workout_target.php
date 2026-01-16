<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = intval($_COOKIE["user"]);
$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;
global $mysqli;
if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "SELECT
hiking_workouts_target.`id`,
hiking_workouts_target.`id_hiking`,
hiking_workouts_target.`id_author`,
hiking_workouts_target.`date_create`,
hiking_workouts_target.`date_update`,
hiking_workouts_target.`name`,
hiking_workouts_target.`workout_type`,
hiking_workouts_target.`description`,
hiking_workouts_target.`date_start`,
hiking_workouts_target.`date_finish`,
hiking_workouts_target.`distance`,
hiking_workouts_target.`alt_ascent`,
hiking_workouts_target.`alt_descent`,
hiking_workouts_target.`speed_max`,
hiking_workouts_target.`speed_min`,
hiking_workouts_target.`speed_avg`,
hiking_workouts_target.`hr_max`,
hiking_workouts_target.`hr_min`,
hiking_workouts_target.`hr_avg`,
hiking_workouts_target.`time_mooving`,
workout_types.name as workout_type_name
FROM
`hiking_workouts_target`
LEFT JOIN workout_types ON hiking_workouts_target.workout_type = workout_types.id
      WHERE
      hiking_workouts_target.id_hiking={$id_hiking}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();
while($r = $q -> fetch_assoc()) {
    $res[] = $r;
}
die(out($res));
