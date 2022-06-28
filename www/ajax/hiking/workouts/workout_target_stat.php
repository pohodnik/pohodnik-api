<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;

if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "
SELECT
      `hiking_members`.id_user,
      GROUP_CONCAT(`workouts`.`name`) as names,
      GROUP_CONCAT(`workouts`.`id`) as ids,
      GROUP_CONCAT(CONCAT(`workouts`.`date_start`, '—', `workouts`.`date_finish`)) as dates,
      GROUP_CONCAT(`workouts`.`distance`) as distances,
      MIN(`workouts`.`date_start`) as first_workout_date,
      MAX(`workouts`.`date_finish`) as max_workout_date,
      SUM(`workouts`.`distance`) as distance,
      SUM(`workouts`.`alt_ascent`) as alt_ascent,
      SUM(`workouts`.`alt_descent`) as alt_descent,
      MAX(`workouts`.`alt_max`) as alt_max,
      MIN(`workouts`.`alt_min`) as alt_min,
      AVG(`workouts`.`alt_avg`) as alt_avg,
      MAX(`workouts`.`speed_max`) as speed_max,
      MIN(`workouts`.`speed_min`) as speed_min,
      AVG(`workouts`.`speed_avg`) as speed_avg,
      MAX(`workouts`.`hr_max`) as hr_max,
      MIN(`workouts`.`hr_min`) as hr_min,
      AVG(`workouts`.`hr_avg`) as hr_avg,
      SUM(`workouts`.`time_mooving`) as time_mooving

FROM
      `hiking_members`
      LEFT JOIN workouts ON workouts.id_user = hiking_members.id_user
      LEFT JOIN hiking_workouts_target ON `hiking_workouts_target`.`id_hiking`=hiking_members.id_hiking
WHERE
      `hiking_members`.`id_hiking`={$id_hiking}
      AND workouts.date_start BETWEEN hiking_workouts_target.date_start AND hiking_workouts_target.date_finish

GROUP BY hiking_members.id_user
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}
die(out($res));