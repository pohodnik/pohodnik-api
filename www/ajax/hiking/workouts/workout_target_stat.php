<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;

if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

global $mysqli;

$where = "`hiking_members`.`id_hiking`={$id_hiking}";

if (isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] !== 'null' && $_GET['type'] > 0) {
    $where .= " AND `workouts`.`workout_type`=".intval($_GET['type']);
}

$z = "
SELECT
      `hiking_members`.id_user,
      GROUP_CONCAT(`workouts`.`name`) as names,
      GROUP_CONCAT(`workouts`.`id`) as ids,
      GROUP_CONCAT(CONCAT(`workout_tracks`.`date_start`, '—', `workout_tracks`.`date_finish`)) as dates,
      GROUP_CONCAT(`workout_tracks`.`distance`) as distances,
      MIN(`workout_tracks`.`date_start`) as first_workout_date,
      MAX(`workout_tracks`.`date_finish`) as max_workout_date,
      SUM(`workout_tracks`.`distance`) as distance,
      SUM(`workout_tracks`.`alt_ascent`) as alt_ascent,
      SUM(`workout_tracks`.`alt_descent`) as alt_descent,
      MAX(`workout_tracks`.`alt_max`) as alt_max,
      MIN(`workout_tracks`.`alt_min`) as alt_min,
      AVG(`workout_tracks`.`alt_avg`) as alt_avg,
      MAX(`workout_tracks`.`speed_max`) as speed_max,
      MIN(`workout_tracks`.`speed_min`) as speed_min,
      AVG(`workout_tracks`.`speed_avg`) as speed_avg,
      MAX(`workout_tracks`.`hr_max`) as hr_max,
      MIN(`workout_tracks`.`hr_min`) as hr_min,
      AVG(`workout_tracks`.`hr_avg`) as hr_avg,
      SUM(`workout_tracks`.`time_mooving`) as time_mooving

FROM
      `hiking_members`

      LEFT JOIN workouts ON workouts.id_user = hiking_members.id_user
      LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
      LEFT JOIN hiking_workouts_target ON `hiking_workouts_target`.`id_hiking`=hiking_members.id_hiking
WHERE
      {$where}
AND workout_tracks.date_start BETWEEN hiking_workouts_target.date_start AND hiking_workouts_target.date_finish

GROUP BY hiking_members.id_user
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}
die(out($res));
